<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bundle_id',
        'recipient_phone',
        'status',
        'cost',
        'cost_price',
        'profit',
        'reference',
        'response_data',
    ];

    protected $casts = [
        'response_data' => 'array',
        'cost' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function complete($responseData = null)
    {
        if ($this->status === 'completed') {
            return;
        }

        $this->update([
            'status' => 'completed',
            'response_data' => $responseData
        ]);

        $user = $this->user;
        if ($user->referred_by_id) {
            $referrer = $user->referrer;
            $commissionAmount = 0;

            if ($referrer->isReseller()) {
                // Calculate profit based on reseller's cost
                $bundle = $this->bundle;
                $rolePrices = $bundle->role_prices ?: [];
                $resellerCost = $rolePrices[$referrer->role] ?? $bundle->price;

                // Commission is the difference between what the customer paid and the reseller's cost
                $commissionAmount = $this->cost - $resellerCost;

                // Ensure it's not negative (safety check)
                $commissionAmount = max(0, $commissionAmount);
            } else {
                // Standard 5% commission for normal user referrals
                $commissionAmount = $this->cost * 0.05;
            }

            if ($commissionAmount > 0) {
                Commission::create([
                    'user_id' => $referrer->id,
                    'referred_user_id' => $user->id,
                    'order_id' => $this->id,
                    'amount' => $commissionAmount,
                    'status' => 'earned',
                ]);

                $referrer->increment('commission_balance', $commissionAmount);

                $referrer->transactions()->create([
                    'amount' => $commissionAmount,
                    'type' => 'credit',
                    'reference' => 'COM-' . strtoupper(\Illuminate\Support\Str::random(10)),
                    'status' => 'success',
                    'description' => "Reseller profit from order #{$this->reference} by {$user->name}",
                ]);
            }
        }
    }
}
