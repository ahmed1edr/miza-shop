<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h2   { font-family: 'DM Serif Display', serif; }
        input::placeholder { color: rgba(167,164,192,0.4); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-8"
      style="background:#0f0e17; background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%);">

    <div class="w-full max-w-sm rounded-2xl p-8"
         style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

        {{-- Logo / Brand --}}
        <div class="text-center mb-8">
            <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full inline-block mb-4"
                  style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                Miza Shop
            </span>
            <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                Connexion
            </h2>
            <p class="text-sm mt-1" style="color:#6e6b8a;">Accédez à votre espace admin</p>
        </div>

        {{-- Error --}}
        @if($errors->any())
            <div class="flex items-center gap-3 p-4 rounded-xl mb-6 text-sm"
                 style="background:#2d1515; border:1px solid rgba(252,165,165,0.15); color:#fca5a5;">
                <span>⚠</span>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        {{-- Form --}}
        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                       style="color:#a7a4c0;">Email</label>
                <input type="email" name="email" required
                       placeholder="votre@email.com"
                       class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                       style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                       onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
            </div>

            <div>
                <label class="block text-xs font-semibold tracking-widest uppercase mb-2"
                       style="color:#a7a4c0;">Mot de passe</label>
                <input type="password" name="password" required
                       placeholder="••••••••"
                       class="w-full px-4 py-3 rounded-xl outline-none transition-all text-sm"
                       style="background:#232136; border:1px solid rgba(255,255,255,0.07); color:#fffffe;"
                       onfocus="this.style.borderColor='#e8c547'; this.style.background='#27253e'; this.style.boxShadow='0 0 0 3px rgba(232,197,71,0.12)'"
                       onblur="this.style.borderColor='rgba(255,255,255,0.07)'; this.style.background='#232136'; this.style.boxShadow='none'">
            </div>

            <div style="padding-top:8px;">
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl font-semibold text-sm transition-all duration-200"
                        style="background:#e8c547; color:#0f0e17; box-shadow:0 4px 20px rgba(232,197,71,0.25);"
                        onmouseover="this.style.background='#f0d060'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 28px rgba(232,197,71,0.35)'"
                        onmouseout="this.style.background='#e8c547'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(232,197,71,0.25)'">
                    Se connecter
                </button>
            </div>

        </form>

    </div>
</body>
</html>
