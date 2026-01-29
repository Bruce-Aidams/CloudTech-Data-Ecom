<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'total_credited',
        'total_debited',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'total_credited' => 'decimal:2',
        'total_debited' => 'decimal:2',
    ];

    /**
     * Get the user that owns the wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Credit the wallet.
     */
    public function credit(float $amount, ?string $description = null)
    {
        $this->balance = bcadd((string) $this->balance, (string) $amount, 2);
        $this->total_credited = bcadd((string) $this->total_credited, (string) $amount, 2);
        $this->save();

        return $this;
    }

    /**
     * Debit the wallet.
     */
    public function debit(float $amount, ?string $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient balance');
        }

        $this->balance = bcsub((string) $this->balance, (string) $amount, 2);
        $this->total_debited = bcadd((string) $this->total_debited, (string) $amount, 2);
        $this->save();

        return $this;
    }

    /**
     * Check if wallet has sufficient balance.
     */
    public function hasSufficientBalance(float $amount): bool
    {
        return $this->balance >= $amount;
    }
}
