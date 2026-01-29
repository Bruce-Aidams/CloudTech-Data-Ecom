@extends('layouts.dashboard')

@section('title', 'Processing Payment')

@section('content')
    <div class="max-w-md mx-auto py-24 text-center space-y-8" x-data="{
                                amount: {{ $amount }},
                                email: '{{ $user->email }}',
                                publicKey: '{{ $publicKey }}',
                                orderIds: {{ json_encode($orderIds) }},

                                initPaystack() {
                                    const handler = PaystackPop.setup({
                                        key: this.publicKey,
                                        email: this.email,
                                        amount: Math.round(this.amount * 100), // In pesewas
                                        currency: 'GHS',
                                        metadata: {
                                            order_ids: this.orderIds
                                        },
                                        callback: (response) => {
                                            window.location.href = `{{ $callback_url }}?reference=${response.reference}`;
                                        },
                                        onClose: () => {
                                            window.location.href = `{{ route('cart.index') }}`;
                                        }
                                    });
                                    handler.openIframe();
                                }
                             }" x-init="setTimeout(() => initPaystack(), 800)">

        <!-- Loading / Status -->
        <div class="space-y-6 animate-in fade-in zoom-in-95 duration-700">
            <div class="relative flex items-center justify-center">
                <div class="h-24 w-24 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <svg class="h-10 w-10 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div
                    class="absolute inset-0 rounded-full border-4 border-primary/20 border-t-primary animate-spin h-24 w-24 mx-auto">
                </div>
            </div>

            <div class="space-y-2">
                <h2 class="text-2xl font-bold tracking-tight text-foreground">Processing Payment</h2>
                <p class="text-muted-foreground font-medium">Please wait while we connect to Paystack...</p>
            </div>
        </div>

        <!-- Payment Details Card -->
        <div
            class="rounded-xl border bg-card text-card-foreground shadow-sm animate-in fade-in slide-in-from-bottom-8 duration-1000 border-none">
            <div class="p-6 space-y-6">
                <div class="flex flex-col gap-2 items-center pb-6 border-b border-border">
                    <span class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Total Amount</span>
                    <div class="text-4xl font-bold text-foreground">
                        GHS {{ number_format($amount, 2) }}
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-muted-foreground">Service</span>
                        <span class="font-medium text-foreground">Data Bundle Purchase</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-muted-foreground">Payer</span>
                        <span class="font-medium text-foreground">{{ $user->email }}</span>
                    </div>
                </div>

                <button @click="initPaystack"
                    class="w-full inline-flex items-center justify-center update-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                    Pay Now
                </button>
            </div>
        </div>

        <!-- Security Footer -->
        <div class="flex items-center justify-center gap-2 text-xs text-muted-foreground">
            <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                </path>
            </svg>
            <span class="font-medium">Secured by Paystack</span>
        </div>
    </div>

    @push('scripts')
        <script src="https://js.paystack.co/v1/inline.js"></script>
    @endpush
@endsection