<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Familles - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }
    </style>
</head>
<body class="min-h-screen antialiased"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Contenu --}}
    <div class="max-w-4xl mx-auto p-4 md:p-8">
        <div class="rounded-2xl p-5 sm:p-8"
             style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                          style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                        Miza Shop — Admin
                    </span>
                    <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                        Liste des Familles
                    </h2>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full md:w-auto">
                    <form action="{{ route('brands.index') }}" method="GET" class="flex gap-2 w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Chercher une famille..."
                               class="w-full sm:w-auto px-4 py-2.5 rounded-xl text-sm outline-none transition-all duration-200"
                               style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); color:#fffffe;"
                               onfocus="this.style.borderColor='#e8c547'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                               onblur="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.boxShadow='none'">
                        <button type="submit"
                                class="font-semibold px-4 py-2.5 rounded-xl text-sm transition-all duration-200"
                                style="background:rgba(255,255,255,0.1); color:#fffffe; border:1px solid rgba(255,255,255,0.1);"
                                onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                                onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            🔍
                        </button>
                    </form>
                    <a href="{{ route('brands.create') }}"
                       class="font-semibold py-2.5 px-5 rounded-xl text-sm transition-all duration-200 text-center w-full sm:w-auto whitespace-nowrap"
                       style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                       onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(232,197,71,0.35)'"
                       onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(232,197,71,0.25)'">
                        + Ajouter une Famille
                    </a>
                </div>
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
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase"
                                style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">ID</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase"
                                style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Nom de la Famille</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase"
                                style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Date d'ajout</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase text-center"
                                style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05); transition:background 0.15s;"
                            onmouseover="this.style.background='rgba(232,197,71,0.04)'"
                            onmouseout="this.style.background='transparent'">

                            <td class="px-5 py-4 text-sm" style="color:#a7a4c0;">{{ $brand->id }}</td>
                            <td class="px-5 py-4 font-semibold text-sm" style="color:#e8c547;">{{ $brand->name }}</td>
                            <td class="px-5 py-4 text-sm" style="color:#6e6b8a;">{{ $brand->created_at->format('d/m/Y') }}</td>

                            <td class="px-5 py-4 text-center">
                                <form action="{{ route('brands.destroy', $brand->id) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette famille ?');">
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Empty state --}}
            @if($brands->isEmpty())
                <div class="text-center py-16">
                    <div class="text-4xl mb-4">🏷️</div>
                    <p class="font-medium" style="color:#a7a4c0;">Aucune famille trouvée.</p>
                    <p class="text-sm mt-1" style="color:#6e6b8a;">Commencez par en ajouter une !</p>
                </div>
            @endif

        </div>
    </div>

</body>
</html>
