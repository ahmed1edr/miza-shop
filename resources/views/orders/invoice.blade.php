<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Facture N° {{ $order->group_id ?? 'CMD-'.$order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #1a1a2e;
            font-size: 12px;
            line-height: 1.6;
            background: #ffffff;
        }

        /* ===== HEADER ===== */
        .header-wrap {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .header-bar {
            background-color: #E63946;
            padding: 0;
            height: 8px;
            font-size: 1px;
            line-height: 1px;
        }

        .header-content {
            width: 100%;
            border-collapse: collapse;
            padding: 20px 0 15px 0;
            border-bottom: 2px solid #E63946;
            margin-bottom: 25px;
        }

        .logo-brand {
            font-size: 28px;
            font-weight: 900;
            color: #E63946;
            letter-spacing: 2px;
        }

        .logo-sub {
            font-size: 10px;
            color: #888;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .invoice-title-cell {
            text-align: right;
            vertical-align: bottom;
        }

        .invoice-title {
            font-size: 30px;
            font-weight: 900;
            color: #E63946;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .invoice-ref {
            font-size: 11px;
            color: #555;
            margin-top: 4px;
        }

        .invoice-ref strong {
            color: #1a1a2e;
            font-size: 12px;
        }

        /* ===== INFO BOXES ===== */
        .info-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .info-box {
            width: 48%;
            vertical-align: top;
            padding: 14px 16px;
            background-color: #fafafa;
            border: 1px solid #e8e8e8;
            border-top: 3px solid #E63946;
        }

        .info-spacer {
            width: 4%;
        }

        .info-box-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #E63946;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-name {
            font-size: 14px;
            font-weight: bold;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .info-row {
            margin-bottom: 4px;
            font-size: 11px;
        }

        .info-label {
            color: #999;
            font-size: 10px;
        }

        .info-value {
            color: #333;
            font-weight: bold;
        }

        /* Status badge using table */
        .status-badge {
            display: inline;
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #ffc107;
            text-transform: capitalize;
        }

        .status-confirmed {
            background-color: #d1e7dd;
            color: #0a3622;
            border-color: #28a745;
        }

        .status-delivered {
            background-color: #cfe2ff;
            color: #084298;
            border-color: #0d6efd;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #842029;
            border-color: #dc3545;
        }

        /* ===== ITEMS TABLE ===== */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table thead tr {
            background-color: #E63946;
        }

        .items-table thead th {
            color: #ffffff;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 12px;
            text-align: left;
        }

        .items-table thead th.right {
            text-align: right;
        }

        .items-table thead th.center {
            text-align: center;
        }

        .items-table tbody tr td {
            padding: 11px 12px;
            border-bottom: 1px solid #eeeeee;
            font-size: 12px;
            color: #333;
        }

        .items-table tbody tr:nth-child(even) td {
            background-color: #fafafa;
        }

        .items-table tbody tr td.center {
            text-align: center;
        }

        .items-table tbody tr td.right {
            text-align: right;
        }

        .items-table tbody tr td.bold {
            font-weight: bold;
            color: #1a1a2e;
        }

        /* ===== TOTALS ===== */
        .totals-section {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 25px;
        }

        .totals-spacer {
            width: 55%;
            vertical-align: top;
        }

        .totals-box {
            width: 45%;
            vertical-align: top;
        }

        .totals-inner {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #eeeeee;
        }

        .totals-inner td {
            padding: 9px 12px;
            font-size: 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .totals-inner td.t-label {
            color: #666;
            text-align: left;
            width: 55%;
        }

        .totals-inner td.t-value {
            color: #333;
            text-align: right;
            font-weight: bold;
            width: 45%;
        }

        .totals-inner tr.discount-row td {
            color: #E63946;
        }

        .totals-inner tr.grand-total-row td {
            background-color: #E63946;
            color: #ffffff;
            font-weight: bold;
            border-bottom: 0;
            padding: 12px;
        }

        .totals-inner tr.grand-total-row td.t-label {
            font-size: 13px;
            color: #ffffff;
        }

        .totals-inner tr.grand-total-row td.t-value {
            font-size: 16px;
            color: #ffffff;
        }

        /* ===== PAYMENT BADGE ===== */
        .payment-section {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .payment-badge-cell {
            text-align: center;
            padding: 12px;
        }

        .payment-badge-table {
            border-collapse: collapse;
            margin: 0 auto;
        }

        .payment-badge-inner {
            padding: 8px 20px;
            border: 2px dashed #E63946;
            color: #E63946;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }

        /* ===== FOOTER ===== */
        .footer-wrap {
            width: 100%;
            border-collapse: collapse;
            border-top: 1px solid #eeeeee;
            margin-top: 40px;
        }

        .footer-content {
            padding: 15px 0;
            text-align: center;
        }

        .footer-brand {
            font-size: 13px;
            font-weight: bold;
            color: #E63946;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .footer-text {
            font-size: 10px;
            color: #aaa;
            margin-bottom: 3px;
        }

        /* ===== SEPARATORS ===== */
        .section-divider {
            width: 100%;
            border: none;
            border-top: 1px solid #eeeeee;
            margin: 20px 0;
        }
    </style>
</head>
<body>

    <!-- ===== TOP RED BAR ===== -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
        <tr>
            <td style="background-color: #E63946; height: 6px; font-size: 1px; line-height: 1px;">&nbsp;</td>
        </tr>
    </table>

    <!-- ===== HEADER ===== -->
    <table style="width: 100%; border-collapse: collapse; padding: 20px 0 15px 0; border-bottom: 2px solid #E63946; margin-bottom: 25px;">
        <tr>
            <td style="vertical-align: bottom; width: 50%; padding: 20px 0 12px 0;">
                @if(file_exists(public_path('logo.png')))
                    <img src="{{ public_path('logo.png') }}" style="max-width: 140px; max-height: 55px;" alt="Logo">
                @else
                    <div class="logo-brand">MIZA<span style="color: #555; font-weight: 400;">SHOP</span></div>
                    <div class="logo-sub">Boutique en ligne</div>
                @endif
            </td>
            <td class="invoice-title-cell" style="width: 50%; padding: 20px 0 12px 0;">
                <div class="invoice-title">FACTURE</div>
                <div class="invoice-ref">
                    Réf : <strong>{{ $order->group_id ?? 'CMD-'.$order->id }}</strong>
                </div>
                <div class="invoice-ref">
                    Date : <strong>{{ $order->created_at->format('d/m/Y') }}</strong>
                </div>
            </td>
        </tr>
    </table>

    <!-- ===== INFO BOXES ===== -->
    <table class="info-section">
        <tr>
            <!-- Client -->
            <td class="info-box">
                <div class="info-box-title">&#128100; Client</div>
                <div class="info-name">{{ $order->name }}</div>
                <div class="info-row">
                    <span class="info-label">Telephone : </span>
                    <span class="info-value">{{ $order->phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse : </span>
                    <span class="info-value">{{ $order->address }}</span>
                </div>
            </td>

            <td class="info-spacer"></td>

            <!-- Commande -->
            <td class="info-box">
                <div class="info-box-title">&#128203; Details de la commande</div>
                <div class="info-row" style="margin-bottom: 6px;">
                    <span class="info-label">Reference : </span>
                    <span class="info-value">{{ $order->group_id ?? 'CMD-'.$order->id }}</span>
                </div>
                <div class="info-row" style="margin-bottom: 6px;">
                    <span class="info-label">Date emission : </span>
                    <span class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Statut : </span>
                    @php
                        $statusClass = '';
                        if($order->status === 'confirmé') $statusClass = 'status-confirmed';
                        elseif($order->status === 'livré') $statusClass = 'status-delivered';
                        elseif($order->status === 'annulé') $statusClass = 'status-cancelled';
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- ===== PRODUCTS TABLE ===== -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 45%;">Designation</th>
                <th class="center" style="width: 15%;">Qte</th>
                <th class="right" style="width: 20%;">Prix unitaire</th>
                <th class="right" style="width: 20%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td class="bold">{{ $item['name'] }}</td>
                <td class="center">{{ $item['quantity'] }}</td>
                <td class="right">{{ number_format($item['price'], 2) }} MAD</td>
                <td class="right bold">{{ number_format($item['price'] * $item['quantity'], 2) }} MAD</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- ===== TOTALS ===== -->
    @php
        $subtotal = 0;
        foreach($order->items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
    @endphp

    <table class="totals-section">
        <tr>
            <td class="totals-spacer"></td>
            <td class="totals-box">
                <table class="totals-inner">
                    <tr>
                        <td class="t-label">Sous-total</td>
                        <td class="t-value">{{ number_format($subtotal, 2) }} MAD</td>
                    </tr>
                    <tr>
                        <td class="t-label">Frais de livraison</td>
                        <td class="t-value" style="color: #28a745;">Gratuit</td>
                    </tr>

                    @if($subtotal != $order->total)
                    <tr class="discount-row">
                        <td class="t-label">Remise appliquee</td>
                        <td class="t-value">- {{ number_format($subtotal - $order->total, 2) }} MAD</td>
                    </tr>
                    @endif

                    <tr class="grand-total-row">
                        <td class="t-label">Net a payer</td>
                        <td class="t-value">{{ number_format($order->total, 2) }} MAD</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ===== PAYMENT MODE ===== -->
    <table class="payment-section">
        <tr>
            <td class="payment-badge-cell">
                <table class="payment-badge-table">
                    <tr>
                        <td class="payment-badge-inner">
                            &#128179; Paiement a la livraison
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ===== FOOTER ===== -->
    <table class="footer-wrap">
        <tr>
            <td class="footer-content">
                <div class="footer-brand">MIZA SHOP</div>
                <div class="footer-text">Merci pour votre confiance. Nous restons a votre disposition pour toute question.</div>
                <div class="footer-text">Document genere automatiquement le {{ \Carbon\Carbon::now()->format('d/m/Y a H:i') }}</div>
            </td>
        </tr>
    </table>

</body>
</html>
