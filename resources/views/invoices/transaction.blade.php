<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $transaction->reference }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            padding: 40px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #6366f1;
        }

        .company-info h1 {
            font-size: 32px;
            font-weight: bold;
            color: #6366f1;
            margin-bottom: 5px;
        }

        .company-info p {
            font-size: 12px;
            color: #666;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .invoice-info p {
            font-size: 12px;
            color: #666;
            margin: 3px 0;
        }

        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .details-box {
            width: 48%;
        }

        .details-box h3 {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .details-box p {
            font-size: 13px;
            color: #666;
            margin: 5px 0;
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .transaction-table thead {
            background-color: #f8f9fa;
        }

        .transaction-table th {
            padding: 15px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            border-bottom: 2px solid #e5e7eb;
        }

        .transaction-table td {
            padding: 15px;
            font-size: 13px;
            color: #666;
            border-bottom: 1px solid #f3f4f6;
        }

        .transaction-table tr:last-child td {
            border-bottom: none;
        }

        .totals-section {
            margin-top: 30px;
            text-align: right;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            margin: 10px 0;
            font-size: 14px;
        }

        .total-label {
            width: 200px;
            text-align: right;
            padding-right: 20px;
            color: #666;
        }

        .total-value {
            width: 150px;
            text-align: right;
            font-weight: bold;
            color: #333;
        }

        .grand-total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
        }

        .grand-total .total-label {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .grand-total .total-value {
            font-size: 20px;
            font-weight: bold;
            color: #6366f1;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-failed {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 11px;
            color: #999;
        }

        .footer p {
            margin: 5px 0;
        }

        .type-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .type-credit {
            background-color: #d1fae5;
            color: #065f46;
        }

        .type-debit {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>CloudTech</h1>
                <p>Data Bundle Services</p>
                <p>Ghana</p>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p><strong>Invoice #:</strong> {{ $transaction->reference }}</p>
                <p><strong>Date:</strong> {{ $transaction->created_at->format('M d, Y') }}</p>
                <p><strong>Status:</strong>
                    <span class="status-badge status-{{ $transaction->status }}">
                        {{ $transaction->status === 'success' ? 'Delivered' : ($transaction->status === 'pending' ? 'Validating' : ucfirst($transaction->status)) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Details Section -->
        <div class="details-section">
            <div class="details-box">
                <h3>Bill To:</h3>
                <p><strong>{{ auth()->user()->name }}</strong></p>
                <p>{{ auth()->user()->email }}</p>
                @if(auth()->user()->phone)
                    <p>{{ auth()->user()->phone }}</p>
                @endif
            </div>
            <div class="details-box">
                <h3>Transaction Details:</h3>
                <p><strong>Reference:</strong> {{ $transaction->reference }}</p>
                <p><strong>Type:</strong>
                    <span class="type-badge type-{{ $transaction->type }}">
                        {{ ucfirst($transaction->type) }}
                    </span>
                </p>
                <p><strong>Date:</strong> {{ $transaction->created_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>

        <!-- Transaction Table -->
        <table class="transaction-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Reference</th>
                    <th>Type</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $transaction->description ?? 'Transaction' }}</td>
                    <td>{{ $transaction->reference }}</td>
                    <td>
                        <span class="type-badge type-{{ $transaction->type }}">
                            {{ ucfirst($transaction->type) }}
                        </span>
                    </td>
                    <td style="text-align: right; font-weight: bold;">
                        GHC {{ number_format($transaction->amount, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals-section">
            <div class="total-row">
                <div class="total-label">Subtotal:</div>
                <div class="total-value">GHC {{ number_format($transaction->amount, 2) }}</div>
            </div>
            <div class="total-row grand-total">
                <div class="total-label">Total Amount:</div>
                <div class="total-value">GHC {{ number_format($transaction->amount, 2) }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>CloudTech - Data Bundle Services</strong></p>
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice and does not require a signature.</p>
            <p>For any queries, please contact support.</p>
        </div>
    </div>
</body>

</html>