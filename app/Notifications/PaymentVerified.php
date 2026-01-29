<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Transaction;

class PaymentVerified extends Notification
{
    use Queueable;

    protected $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable): array
    {
        return ['database']; // Keeping it simple on dashboard for now
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Payment Verified',
            'message' => "Your top-up of ₵" . number_format((float) $this->transaction->amount, 2) . " has been successfully verified.",
            'transaction_id' => $this->transaction->id,
            'reference' => $this->transaction->reference,
        ];
    }
}
