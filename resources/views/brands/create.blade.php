<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Famille - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }
    </style>
</head>
<body class="min-h-screen antialiased flex items-center justify-center p-8"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    <div class="w-full max-w-md rounded-2xl p-8"
         style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

        {{-- Header --}}
        @include('layouts.navbar')

        {{-- Errors --}}
        @if($errors->any())
            <div class="p-4 rounded-xl mb-6 text-sm"
                 style="background:#2d1515; border:1px solid rgba(252,165,165,0.15); color:#fca5a5;">
                <ul style="list-style:none; padding:0;" class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>· {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('brands.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                       style="color:#a7a4c0;">Nom de la famille (Marque)</label>
                <input type="text" name="name" placeholder="ex : Apple, Sony..." required
                       class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                       style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                       onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
            </div>

            <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:20px;">
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-200"
                        style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                        onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(232,197,71,0.35)'"
                        onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(232,197,71,0.25)'">
                    Enregistrer la Famille
                </button>
            </div>
        </form>

    </div>
</body>
</html>
