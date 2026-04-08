<style id="miza-theme-css">
    /* Theme definitions overriding inline styles */
    
    /* ── BASE AND DARK MODE (Default) ── */
    .dark {
        background-color: #0f0e17 !important;
        background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.08) 0%, transparent 70%) !important;
        color: #fffffe !important;
    }
    .dark [style*="background:#1a1828"], .dark .panel {
        background: #1a1828 !important;
        border-color: rgba(255,255,255,0.07) !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.3) !important;
    }
    .dark [style*="background:#232136"], .dark .sub-panel {
        background: #232136 !important;
        border-color: rgba(255,255,255,0.05) !important;
    }
    .dark [style*="background:rgba(255,255,255,0.05)"] {
        background: rgba(255,255,255,0.05) !important;
        border-color: rgba(255,255,255,0.1) !important;
    }
    
    /* Global Inputs */
    .dark .search-box { background: #232136 !important; border: 1px solid rgba(255,255,255,0.07) !important; color: #fffffe !important; }
    .search-box::placeholder { color: rgba(167,164,192,0.6); }
    .search-box:focus { outline: none; border-color: #e8c547 !important; box-shadow: 0 0 0 3px rgba(232,197,71,0.12) !important; }
    .dark [style*="background:rgba(26,24,40,0.85)"] {
        background: rgba(26,24,40,0.85) !important;
        border-bottom-color: rgba(255,255,255,0.06) !important;
    }
    .dark [style*="color:#fffffe"] { color: #fffffe !important; }
    .dark [style*="color:#a7a4c0"] { color: #a7a4c0 !important; }
    .dark [style*="color:#6e6b8a"] { color: #6e6b8a !important; }

    /* ── LIGHT MODE ── */
    .light {
        background-color: #f4f3ef !important;
        background-image: radial-gradient(ellipse 80% 50% at 50% -10%, rgba(232,197,71,0.12) 0%, transparent 70%) !important;
        color: #1a1828 !important;
    }
    
    /* Panels (Cards) */
    .light [style*="background:#1a1828"], .light .panel {
        background: #ffffff !important;
        border-color: rgba(0,0,0,0.07) !important;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05) !important;
    }
    /* Sub Panels (Headers, inner bg) */
    .light [style*="background:#232136"], .light .sub-panel {
        background: rgba(0,0,0,0.03) !important;
        border-color: rgba(0,0,0,0.05) !important;
    }
    /* Transparent Inputs & searches */
    .light [style*="background:rgba(255,255,255,0.05)"] {
        background: #ffffff !important;
        border-color: rgba(0,0,0,0.12) !important;
        color: #1a1828 !important;
    }
    
    .light .search-box { background: rgba(0,0,0,0.03) !important; border: 1px solid rgba(0,0,0,0.1) !important; color: #1a1828 !important; }
    /* Navbar override */
    .light [style*="background:rgba(26,24,40,0.85)"], .light .navbar {
        background: rgba(255,255,255,0.85) !important;
        border-bottom-color: rgba(0,0,0,0.07) !important;
    }
    
    /* Text Colors */
    .light [style*="color:#fffffe"] { color: #1a1828 !important; }
    .light [style*="color:#a7a4c0"] { color: #4a4766 !important; }
    .light [style*="color:#6e6b8a"] { color: #8a88a0 !important; }

    /* Inputs in light mode */
    .light input, .light select { color: #1a1828 !important; }
    .light select option { background: #ffffff !important; color: #1a1828 !important; }
    
    /* Toggle Button visibility */
    .dark #sunIcon, .dark #sunIconM, .dark #sunIconDesk, .dark #sunIconMob { display: none !important; }
    .dark #moonIcon, .dark #moonIconM, .dark #moonIconDesk, .dark #moonIconMob { display: block !important; }
    .light #moonIcon, .light #moonIconM, .light #moonIconDesk, .light #moonIconMob { display: none !important; }
    .light #sunIcon, .light #sunIconM, .light #sunIconDesk, .light #sunIconMob { display: block !important; }
</style>

<script>
    function applyTheme(theme) {
        const el = document.getElementById('body') || document.body;
        if(!el) return;
        el.classList.remove('dark','light');
        el.classList.add(theme);
        localStorage.setItem('theme', theme);
    }
    
    window.toggleTheme = function() {
        const current = localStorage.getItem('theme') || 'dark';
        applyTheme(current === 'dark' ? 'light' : 'dark');
    };

    function initTheme() {
        const el = document.getElementById('body') || document.body;
        if(!el) return;
        if(!el.id) el.id = 'body';
        el.classList.add('transition-colors', 'duration-300');

        const saved = localStorage.getItem('theme');
        if (saved) {
            applyTheme(saved);
        } else {
            applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        }
    }

    // Run when DOM is ready to avoid crash if included in <head>
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTheme);
    } else {
        initTheme();
    }
</script>
