<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Skip if order is already completed or failed to prevent state overwrite
        if (in_array($this->order->status, ['completed', 'failed'])) {
            Log::info("Order ID: " . $this->order->id . " is already " . $this->order->status . ". Skipping job.");
            return;
        }

        // Simulate processing flow
        Log::info("Processing Order ID: " . $this->order->id);

        $this->order->update(['status' => 'processing']);

        // Simulate external API call delay
        sleep(5);

        // Success condition (User said "get responsed ... and change stats to complete")
        // We simulate a successful response
        $response = [
            'status' => 'success',
            'external_id' => 'EXT-' . uniqid(),
            'message' => 'Bundle sent successfully'
        ];

        $this->order->complete($response);

        Log::info("Order ID: " . $this->order->id . " completed.");
    }
}
