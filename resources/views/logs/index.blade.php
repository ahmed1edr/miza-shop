<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique d'activité - Miza Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <div class="max-w-7xl mx-auto p-4 md:p-8">
        <div class="rounded-2xl p-5 sm:p-8"
             style="background:#1a1828; border:1px solid rgba(255,255,255,0.07); box-shadow: 0 24px 60px rgba(0,0,0,0.5), 0 0 80px rgba(232,197,71,0.04);">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <span class="text-xs font-semibold tracking-widest uppercase px-3 py-1 rounded-full mb-3 inline-block"
                          style="background:rgba(232,197,71,0.12); color:#e8c547; border:1px solid rgba(232,197,71,0.2);">
                        Sécurité & Audit
                    </span>
                    <h2 class="text-3xl font-normal tracking-tight" style="color:#fffffe;">
                        Historique d'Activité
                    </h2>
                </div>
                
                {{-- Search --}}
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 w-full md:w-auto">
                    <form action="{{ route('logs.index') }}" method="GET" class="flex gap-2 w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Chercher par utilisateur, action..."
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
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto rounded-xl" style="border:1px solid rgba(255,255,255,0.07);">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr style="background:#232136;">
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">ID</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Date</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Utilisateur</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Action</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-widest uppercase" style="color:#a7a4c0; border-bottom:1px solid rgba(255,255,255,0.07);">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05); transition:background 0.15s;"
                            onmouseover="this.style.background='rgba(232,197,71,0.04)'"
                            onmouseout="this.style.background='transparent'">
                            
                            <td class="px-5 py-4 text-xs font-mono" style="color:#6e6b8a;">#{{ $log->id }}</td>
                            <td class="px-5 py-4 text-xs" style="color:#a7a4c0;">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4">
                                @if($log->user)
                                    <span class="font-semibold text-sm" style="color:#fffffe;">
                                        {{ $log->user->name }}
                                    </span>
                                    <span class="text-[10px] text-gray-500 block uppercase">{{ $log->user->role }}</span>
                                @else
                                    <span class="text-sm italic" style="color:#6e6b8a;">Système / Inconnu</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full border"
                                      style="background:rgba(99,102,241,0.1); color:#818cf8; border-color:rgba(99,102,241,0.2);">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm" style="color:#a7a4c0;">
                                {{ $log->description }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">{{ $logs->withQueryString()->links() }}</div>

            @if($logs->isEmpty())
                <div class="text-center py-16">
                    <div class="text-4xl mb-4">🕵️</div>
                    <p class="font-medium" style="color:#a7a4c0;">Aucune activité enregistrée pour le moment.</p>
                </div>
            @endif

        </div>
    </div>
</body>
</html>
