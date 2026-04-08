<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la commande #{{ $order->id }} - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }
        input[type="number"] { -moz-appearance: textfield; }
        input[type="number"]::-webkit-inner-spin-button { opacity: 1; }
    </style>
</head>
<body class="min-h-screen antialiased"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    {{-- Navbar --}}
    @include('layouts.navbar')

    <div class="max-w-3xl mx-auto p-8">
        <div class="rounded-2xl p-8"
             style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                          style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                        Miza Shop — Commandes
                    </span>
                    <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                        Modifier la commande <span style="color:#e8c547;">#{{ $order->id }}</span>
                    </h2>
                </div>
                <a href="{{ route('orders.index') }}"
                   class="text-sm font-medium transition-all duration-200"
                   style="color:#a7a4c0;"
                   onmouseover="this.style.color='#e8c547'"
                   onmouseout="this.style.color='#a7a4c0'">
                    &larr; Retour
                </a>
            </div>

            {{-- Info Client --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 p-4 rounded-xl"
                 style="background:#232136; border:1px solid rgba(255,255,255,0.07);">
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase mb-1" style="color:#6e6b8a;">Client</p>
                    <p class="font-bold text-sm" style="color:#fffffe;">{{ $order->name }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase mb-1" style="color:#6e6b8a;">Téléphone</p>
                    <p class="font-bold text-sm" style="color:#fffffe;">📞 {{ $order->phone }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold tracking-widest uppercase mb-1" style="color:#6e6b8a;">Statut</p>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                          style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                        {{ $order->status }}
                    </span>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <p class="text-xs font-semibold tracking-widest uppercase mb-3" style="color:#a7a4c0;">
                        Produits commandés — modifiez les quantités
                    </p>
                    <p class="text-xs mb-4" style="color:#6e6b8a;">
                        💡 Mettez la quantité à <b style="color:#f87171;">0</b> pour retirer un produit de la commande.
                    </p>
                </div>

                <div class="space-y-3 mb-8">
                    @foreach($order->items as $id => $item)
                    <div class="flex items-center gap-4 p-4 rounded-xl transition-all"
                         style="background:#232136; border:1px solid rgba(255,255,255,0.07);"
                         id="item-row-{{ $id }}">

                        {{-- Image --}}
                        <div class="w-14 h-14 rounded-lg overflow-hidden flex-shrink-0"
                             style="border:1px solid rgba(255,255,255,0.08);">
                            @if(isset($item['image']) && $item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center" style="background:#1a1828;">
                                    <span style="opacity:0.3;">📦</span>
                                </div>
                            @endif
                        </div>

                        {{-- Name --}}
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm truncate" style="color:#fffffe;">{{ $item['name'] }}</p>
                            <p class="text-xs mt-0.5" style="color:#6e6b8a;">
                                {{ number_format($item['price'], 2) }} DH / unité
                            </p>
                        </div>

                        {{-- Quantity Input --}}
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-semibold" style="color:#a7a4c0;">Qté :</label>
                            <input type="number"
                                   name="quantities[{{ $id }}]"
                                   value="{{ $item['quantity'] }}"
                                   min="0"
                                   class="w-20 px-3 py-2 rounded-lg text-center text-sm font-bold outline-none transition-all"
                                   style="background:#0f0e17; border:1px solid rgba(255,255,255,0.1); color:#fffffe;"
                                   onfocus="this.style.borderColor='#e8c547'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                                   onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none'"
                                   onchange="updateRowTotal(this, {{ $item['price'] }}, '{{ $id }}')">
                        </div>

                        {{-- Row Total --}}
                        <div class="text-right min-w-[80px]">
                            <p class="font-bold text-sm" style="color:#e8c547;" id="row-total-{{ $id }}">
                                {{ number_format($item['price'] * $item['quantity'], 2) }} DH
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="flex justify-between items-center p-4 rounded-xl mb-6"
                     style="background:rgba(232,197,71,0.06); border:1px solid rgba(232,197,71,0.15);">
                    <span class="font-semibold text-sm" style="color:#a7a4c0;">Nouveau total :</span>
                    <span class="font-bold text-2xl" style="color:#e8c547; font-family:'DM Serif Display',serif;" id="grand-total">
                        {{ number_format($order->total, 2) }} DH
                    </span>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3">
                    <button type="submit"
                            class="flex-1 py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-200"
                            style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                            onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'">
                        ✅ Enregistrer les modifications
                    </button>
                    <a href="{{ route('orders.index') }}"
                       class="py-3 px-6 rounded-xl font-semibold text-sm transition-all duration-200 text-center"
                       style="background:rgba(255,255,255,0.05); color:#a7a4c0; border:1px solid rgba(255,255,255,0.07);"
                       onmouseover="this.style.background='rgba(255,255,255,0.08)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                        Annuler
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        // كنحسبو المجموع الجديد ديناميكيا ملي كتبدل الكمية
        function updateRowTotal(input, price, id) {
            const qty = parseInt(input.value) || 0;
            const rowTotal = (price * qty).toFixed(2);
            const rowEl = document.getElementById('row-total-' + id);
            const rowItem = document.getElementById('item-row-' + id);

            if (qty === 0) {
                rowEl.textContent = '0.00 DH';
                rowItem.style.opacity = '0.4';
                rowItem.style.borderColor = 'rgba(239,68,68,0.3)';
            } else {
                rowEl.textContent = rowTotal + ' DH';
                rowItem.style.opacity = '1';
                rowItem.style.borderColor = 'rgba(255,255,255,0.07)';
            }

            // نحسبو المجموع الكلي
            let grandTotal = 0;
            document.querySelectorAll('input[name^="quantities"]').forEach(inp => {
                const q = parseInt(inp.value) || 0;
                const p = parseFloat(inp.getAttribute('onchange').match(/[\d.]+/)?.[0] || 0);
                grandTotal += p * q;
            });
            document.getElementById('grand-total').textContent = grandTotal.toFixed(2) + ' DH';
        }
    </script>

</body>
</html>
