# Paystack Integration Setup Guide

## Quick Start

### 1. Get Your API Keys

1. Visit [Paystack Dashboard](https://dashboard.paystack.com)
2. Navigate to **Settings → API Keys & Webhooks**
3. Copy your keys:
   - **Test Keys** (for development): `pk_test_...` and `sk_test_...`
   - **Live Keys** (for production): `pk_live_...` and `sk_live_...`

### 2. Configure Environment Variables

Update your `.env` file:

```env
# For Development
PAYSTACK_PUBLIC_KEY=pk_test_YOUR_TEST_PUBLIC_KEY
PAYSTACK_SECRET_KEY=sk_test_YOUR_TEST_SECRET_KEY

# For Production
PAYSTACK_PUBLIC_KEY=pk_live_YOUR_LIVE_PUBLIC_KEY
PAYSTACK_SECRET_KEY=sk_live_YOUR_LIVE_SECRET_KEY
```

### 3. Configure Webhook URL

In your Paystack Dashboard:

1. Go to **Settings → API Keys & Webhooks**
2. Set webhook URL to: `https://yourdomain.com/api/paystack/webhook`
3. Make sure the URL is publicly accessible (not localhost)

> **Note**: For local testing, use a tool like [ngrok](https://ngrok.com) to expose your local server.

## Testing

### Test Payment Flow

1. **Initialize Payment**:
   ```bash
   POST /api/paystack/initialize
   {
     "amount": 10.00,
     "email": "test@example.com"
   }
   ```

2. **Verify Payment**:
   ```bash
   GET /api/paystack/verify?reference=PAY-xxx
   ```

### Test Webhook

Use Paystack's webhook testing tool in the dashboard to send test events.

## Troubleshooting

### Common Issues

1. **"API keys not configured"**
   - Check that keys are set in `.env`
   - Run `php artisan config:clear`

2. **"Unable to connect to payment gateway"**
   - Check internet connection
   - Verify firewall isn't blocking outbound HTTPS requests
   - Check if Paystack API is operational

3. **Webhook not receiving events**
   - Ensure webhook URL is publicly accessible
   - Check CSRF middleware exemption
   - Verify webhook signature validation

4. **SSL/TLS errors**
   - Ensure production server has valid SSL certificate
   - Check that SSL verification is enabled in production

## Security Checklist

- [ ] Never commit live API keys to version control
- [ ] Use environment variables for all sensitive data
- [ ] Keep webhook signature validation enabled
- [ ] Use HTTPS in production
- [ ] Regularly rotate API keys
- [ ] Monitor webhook logs for suspicious activity

## Production Deployment

Before going live:

1. ✅ Replace test keys with live keys
2. ✅ Set webhook URL in Paystack dashboard
3. ✅ Ensure SSL certificate is valid
4. ✅ Test payment flow end-to-end
5. ✅ Verify webhook delivery
6. ✅ Set up monitoring and alerts
