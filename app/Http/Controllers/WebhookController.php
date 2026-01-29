<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Handle incoming webhooks from external websites.
     */
    public function handle(Request $request)
    {
        // Log the incoming webhook
        Log::info('Incoming webhook received', [
            'headers' => $request->headers->all(),
            'payload' => $request->all()
        ]);

        // Verify signature if a secret is configured (optional implementation)
        $secret = \App\Models\Setting::where('key', 'webhook_secret')->value('value');
        if ($secret) {
            $signature = $request->header('X-Webhook-Signature');
            // Simplified verification for now - implement specific logic as needed
            if (!$signature) {
                // Log::warning('Webhook missing signature');
                // return response()->json(['message' => 'Missing signature'], 401);
            }
        }

        // Process based on event type
        $event = $request->input('event');
        $data = $request->input('data');

        switch ($event) {
            case 'order.created':
                // Handle order creation logic
                break;
            case 'payment.success':
                // Handle payment success logic
                break;
            default:
                Log::info("Unhandled webhook event: {$event}");
        }

        return response()->json(['message' => 'Webhook processed']);
    }
}
