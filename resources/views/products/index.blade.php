<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }
    </style>
</head>
<body class="min-h-screen antialiased p-8"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    <div class="max-w-7xl mx-auto rounded-2xl p-8"
         style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                      style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                    Miza Shop — Admin
                </span>
                <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                    Liste des produits
                </h2>
            </div>
            <a href="{{ route('products.create') }}"
               class="font-semibold py-2.5 px-5 rounded-xl text-sm transition-all duration-200"
               style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
               onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(232,197,71,0.35)'"
               onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(232,197,71,0.25)'">
                + Ajouter un produit
            </a>
        </div>

        {{-- Success --}}
        @if(session('success'))
            <div class="flex items-start gap-3 p-4 rounded-xl mb-6 text-sm font-medium"
                 style="background:#0d2e1e; border:1px solid rgba(110,231,183,0.2); color:#6ee7b7;">
                <span class="font-bold">✓</span>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto rounded-xl" style="border:1px solid rgba(255,255,255,0.07);">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr style="background:#232136;">
                        <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Image</th>
                        <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Référence</th>
                        <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Produit</th>
                        <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Catégorie</th>
                        <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Prix</th>
                        <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Stock</th>
                        <th class="px-4 py-4 text-xs font-semibold tracking-widest uppercase text-center" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05); transition:background 0.15s;"
                        onmouseover="this.style.background='rgba(232,197,71,0.04)'"
                        onmouseout="this.style.background='transparent'">

                        {{-- Image --}}
                        <td class="px-4 py-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-11 h-11 object-cover rounded-lg"
                                     style="border:1px solid rgba(255,255,255,0.08);">
                            @else
                                <div class="w-11 h-11 rounded-lg flex items-center justify-center text-xs"
                                     style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#6e6b8a;">
                                    —
                                </div>
                            @endif
                        </td>

                        {{-- Référence --}}
                        <td class="px-4 py-4 text-xs font-mono" style="color:#6e6b8a;">{{ $product->reference }}</td>

                        {{-- Nom --}}
                        <td class="px-4 py-4 font-semibold text-sm" style="color:#fffffe;">{{ $product->name }}</td>

                        {{-- Catégorie --}}
                        <td class="px-4 py-4 text-sm" style="color:#e8c547;">{{ $product->category->name ?? 'Sans catégorie' }}</td>

                        {{-- Prix --}}
                        <td class="px-4 py-4 text-sm">
                            <span class="line-through mr-1" style="color:#6e6b8a;">{{ $product->purchase_price }} DH</span>
                            <span class="font-bold" style="color:#6ee7b7;">{{ $product->selling_price }} DH</span>
                        </td>

                        {{-- Stock --}}
                        <td class="px-4 py-4">
                            @if($product->stock_quantity <= $product->alert_stock)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                      style="background:rgba(239,68,68,0.12); color:#f87171; border:1px solid rgba(239,68,68,0.2);">
                                    {{ $product->stock_quantity }} — Critique
                                </span>
                            @else
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                      style="background:rgba(110,231,183,0.1); color:#6ee7b7; border:1px solid rgba(110,231,183,0.2);">
                                    {{ $product->stock_quantity }}
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-200"
                                   style="background:rgba(99,102,241,0.12); color:#818cf8; border:1px solid rgba(99,102,241,0.2);"
                                   onmouseover="this.style.background='rgba(99,102,241,0.22)'; this.style.color='#a5b4fc'"
                                   onmouseout="this.style.background='rgba(99,102,241,0.12)'; this.style.color='#818cf8'">
                                    ✎ Modifier
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Voulez-vous supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs font-semibold px-3 py-1.5 rounded-lg transition-all duration-200"
                                            style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2);"
                                            onmouseover="this.style.background='rgba(239,68,68,0.2)'; this.style.color='#fca5a5'"
                                            onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.color='#f87171'">
                                        ✕ Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Empty state --}}
        @if($products->isEmpty())
            <div class="text-center py-16">
                <div class="text-4xl mb-4">📦</div>
                <p class="font-medium" style="color:#a7a4c0;">Aucun produit dans le stock.</p>
                <p class="text-sm mt-1" style="color:#6e6b8a;">Commencez par en ajouter un !</p>
            </div>
        @endif

    </div>
</body>
</html>
