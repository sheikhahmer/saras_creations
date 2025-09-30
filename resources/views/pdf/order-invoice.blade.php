<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .invoice-box {
            width: 100%;
            max-width: 900px;   /* keep within A4 width */
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            height: 80px;
        }

        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #616f4d;
        }

        .details {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .details .block {
            width: 48%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table th {
            background: #616f4d;
            color: #fff;
            text-align: left;
            padding: 8px;
            font-size: 14px;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .totals {
            margin-top: 20px;
            width: 100%;
        }

        .totals td {
            padding: 8px;
        }

        .totals .label {
            text-align: right;
            font-weight: bold;
        }

        .totals .value {
            text-align: right;
        }

        .highlight {
            background: #616f4d;
            color: #fff;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="">
    <!-- Header -->
    <table width="100%" cellspacing="0" cellpadding="0" style="border:none; border-collapse:collapse; margin-bottom:20px;">
        <tr>
            <!-- Left: Logo -->
            <td style="border:none; text-align:left; padding:0; vertical-align:middle;">
                <div class="header" style="display:inline-block; margin-left:0;">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/image/logo2.png'))) }}" alt="Logo" style="height:120px; width:auto; display:block;">
                </div>
            </td>
            <!-- Right: Invoice Info -->
            <td style="text-align:right; font-size:13px; color:#444; border:none;">
                <div style="font-weight:bold; font-size:18px; margin-bottom:6px;">INVOICE</div>
                <div>Date: {{ $order->created_at->format('d/m/Y') ?? '01/05/2023' }}</div>
                <div>Invoice # INV-{{ $order->id }}</div>
                <div>Tracking ID :  {{ $order->tracking_id }}</div>
            </td>
        </tr>
    </table>
    <!-- Invoice & Billing Details -->
    <div style="width:100%; border-bottom:2px solid #ccc; padding-bottom:15px; margin-bottom:20px;">
        <!-- Billing Details -->
        <div style="margin-top:15px;">
            <div style="font-size:16px; font-weight:bold; margin-bottom:8px; color:#333;">Bill To:</div>
            <div style="font-size:14px; color:#444; margin-bottom:3px;">
                {{ $order->customer->name ?? 'John Doe' }}
            </div>
            <div style="font-size:14px; color:#444; margin-bottom:3px;">
                {{ $order->customer->address ?? '123 Main St.' }}
            </div>
            <div style="font-size:14px; color:#444; margin-bottom:3px;">
                {{ $order->customer->city ?? 'Anytown, USA 12345' }}
            </div>
            <div style="font-size:14px; color:#444;">
                {{ $order->customer->phone_no ?? '0300-1234567' }}
            </div>
        </div>
    </div>

    <!-- Table -->
    <table>
        <thead>
        <tr>
            <th style="width:5%">NO</th>
            <th style="width:45%">DESCRIPTION</th>
            <th style="width:15%">PRICE</th>
            <th style="width:10%">QTY</th>
            <th style="width:20%">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $index => $item)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>
                    {{ $item->product->name }}
                    @if($item->variant)
                        <br>
                        <small>
                            @if($item->variant->color)
                                <strong>Color:</strong> {{ $item->variant->color }}
                            @endif
                            @if($item->variant->size)
                                | <strong>Size:</strong> {{ $item->variant->size }}
                            @endif
                        </small>
                    @endif
                </td>
                <td>Rs {{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rs {{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <!-- Totals -->
    <table class="totals">
        <tr>
            <td class="label">SUB-TOTAL</td>
            <td class="value">Rs {{ number_format($order->items->sum('subtotal'), 2) }}</td>
        </tr>
        <tr>
            <td class="label">Delivery Charges</td>
            <td class="value">Rs {{ number_format($order->shipping_charges) }}</td>
        </tr>
        <tr class="highlight">
            <td class="label">Total Due</td>
            <td class="value">Rs {{ number_format($order->total_amount) }}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer" style="text-align:center; padding:20px; background:#f8f8f8; border-top:1px solid #ddd;">
        <p><strong>PAYMENT METHODS</strong></p>
        <p>EasyPaisa / JazzCash: 0304-2824800 (Sara Creation)</p>
        <p>Bank: Meezan Bank | Account Name: Sara Creation | Account #: 05810104804384</p>
        <hr style="margin:15px 0;">
        <p style="font-size:14px; color:#555; line-height:1.6; text-align:center;">
            Thank you for choosing <strong>Sara Creation</strong>. <br>
            Your trust means the world to us, and we’re honored to be part of your journey. <br>
            We look forward to serving you again with the same dedication and care.
        </p>
    </div>
</div>
</body>
</html>
















