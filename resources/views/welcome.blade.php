<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BUMDESMA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; background: #fff; color: #111; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }
        ::selection { background: #f59e0b; color: #fff; }

        .navbar { display: flex; align-items: center; justify-content: space-between; padding: 12px 48px; background: rgba(255,255,255,0.95); backdrop-filter: blur(8px); border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 50; transition: box-shadow .3s ease; }
        .navbar.scrolled { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-logo { height: 48px; width: auto; object-fit: contain; transition: transform .3s ease; }
        .brand:hover .brand-logo { transform: scale(1.06) rotate(-2deg); }
        .brand-name { font-weight: 800; font-size: 20px; letter-spacing: 0.5px; }
        .brand-name small { display: block; font-weight: 600; font-size: 10px; color: #666; letter-spacing: 0.3px; }

        .nav-links { display: flex; align-items: center; gap: 28px; list-style: none; }
        .nav-links > li > a { position: relative; font-size: 13px; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase; color: #111; padding-bottom: 4px; transition: color .25s ease; }
        .nav-links > li > a::after { content: ""; position: absolute; left: 0; bottom: 0; height: 2px; width: 100%; background: #f59e0b; transform: scaleX(0); transform-origin: left; transition: transform .3s ease; }
        .nav-links > li > a:hover::after, .nav-links > li > a.active::after { transform: scaleX(1); }
        .nav-links a.active, .nav-links a:hover { color: #f59e0b; }

        .hamburger { display: none; background: none; border: 0; font-size: 26px; line-height: 1; cursor: pointer; transition: transform .25s ease; }
        .hamburger:hover { transform: scale(1.15); }

        .has-dropdown { position: relative; }
        .dropdown { display: block; opacity: 0; visibility: hidden; transform: translateY(10px); position: absolute; top: 100%; left: 0; background: #fff; min-width: 230px; list-style: none; box-shadow: 0 8px 24px rgba(0,0,0,0.12); border: 1px solid #eee; z-index: 60; transition: opacity .25s ease, transform .25s ease, visibility .25s; }
        .has-dropdown:hover > .dropdown, .has-dropdown.open > .dropdown { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown a { display: block; padding: 12px 18px; font-size: 13px; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase; color: #111; border-left: 3px solid transparent; transition: color .2s ease, background .2s ease, border-color .2s ease, padding-left .2s ease; }
        .dropdown a:hover { color: #f59e0b; background: #fafafa; border-left-color: #f59e0b; padding-left: 24px; }
        .caret { display: inline-block; font-size: 10px; margin-left: 4px; transition: transform .25s ease; }
        .has-dropdown:hover .caret, .has-dropdown.open .caret { transform: rotate(180deg); }

        .hero { position: relative; min-height: calc(100vh - 70px); min-height: calc(100svh - 70px); display: flex; align-items: center; background: #1f2937; overflow: hidden; }
        .hero-video { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: center; animation: heroZoom 26s ease-in-out infinite alternate; transition: opacity 1.2s ease; }
        .hero-video.faded { opacity: 0; }
        @keyframes heroZoom { from { transform: scale(1); } to { transform: scale(1.1); } }
        .hero::before { content: ""; position: absolute; inset: 0; z-index: 1; background: linear-gradient(to top, rgba(0,0,0,0.65), rgba(0,0,0,0.35) 55%, rgba(0,0,0,0.45)); }
        .hero-inner { position: relative; z-index: 2; padding: 80px 48px; max-width: 900px; color: #fff; }
        .hero h1 { font-size: clamp(28px, 5vw, 52px); font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; text-shadow: 0 2px 12px rgba(0,0,0,0.5); animation: rise .9s .2s cubic-bezier(.22,.61,.36,1) both; }
        .hero p { margin-top: 16px; font-size: clamp(13px, 2vw, 16px); font-weight: 500; color: #f3f4f6; text-shadow: 0 1px 8px rgba(0,0,0,0.5); animation: rise .9s .45s cubic-bezier(.22,.61,.36,1) both; }
        @keyframes rise { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .scroll-cue { position: absolute; left: 50%; bottom: 22px; z-index: 2; transform: translateX(-50%); color: #fff; font-size: 26px; animation: cueBob 1.8s ease-in-out infinite; opacity: .85; }
        @keyframes cueBob { 0%, 100% { transform: translate(-50%, 0); } 50% { transform: translate(-50%, 10px); } }

        .section { padding: 72px 48px; max-width: 1200px; margin: 0 auto; scroll-margin-top: 70px; }
        .section-title { position: relative; display: inline-block; font-size: 22px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 32px; }
        .section-title::after { content: ""; position: absolute; left: 0; bottom: -8px; height: 3px; width: 100%; background: #f59e0b; border-radius: 2px; transform: scaleX(0); transform-origin: left; transition: transform .6s .2s ease; }
        .visible .section-title::after { transform: scaleX(1); }

        /* Reveal on scroll */
        .reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s ease, transform .7s cubic-bezier(.22,.61,.36,1); }
        .reveal.visible { opacity: 1; transform: none; }
        .d1 { transition-delay: .1s; } .d2 { transition-delay: .2s; } .d3 { transition-delay: .3s; } .d4 { transition-delay: .4s; }

        /* Sorotan / highlight cards */
        .carousel-wrap { display: flex; align-items: center; gap: 16px; }
        .carousel-btn { flex: 0 0 auto; width: 40px; height: 40px; border: 0; background: none; font-size: 24px; font-weight: 800; cursor: pointer; transition: transform .25s ease, color .25s ease; }
        .carousel-btn:hover { transform: scale(1.25); color: #f59e0b; }
        .carousel { display: flex; gap: 24px; overflow-x: auto; scroll-behavior: smooth; padding: 8px 4px 16px; flex: 1; }
        .carousel::-webkit-scrollbar { height: 8px; }
        .carousel::-webkit-scrollbar-thumb { background: #ddd; border-radius: 8px; }
        .info-card { position: relative; overflow: hidden; flex: 0 0 320px; background: linear-gradient(160deg, #b02a2e, #8e1f23); color: #fff; border-radius: 20px; padding: 36px 28px; min-height: 320px; transition: transform .35s ease, box-shadow .35s ease; }
        .info-card::after { content: ""; position: absolute; top: 0; left: -80%; width: 60%; height: 100%; background: linear-gradient(100deg, transparent, rgba(255,255,255,0.18), transparent); transform: skewX(-20deg); transition: left .6s ease; }
        .info-card:hover { transform: translateY(-8px); box-shadow: 0 18px 40px rgba(176,42,46,0.35); }
        .info-card:hover::after { left: 130%; }
        .info-card .icon { width: 64px; height: 64px; margin: 0 auto 20px; border: 2px solid #f5a623; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; color: #f5a623; transition: transform .35s ease, background .35s ease; }
        .info-card:hover .icon { transform: rotate(12deg) scale(1.1); background: rgba(245,166,35,0.12); }
        .info-card h3 { font-size: 17px; font-weight: 800; text-align: center; line-height: 1.4; margin-bottom: 14px; }
        .info-card p { font-size: 13.5px; line-height: 1.65; color: #f6e8e8; }

        /* Tentang */
        .about { background: #faf7f5; overflow: hidden; scroll-margin-top: 70px; }
        .about-inner { max-width: 1200px; margin: 0 auto; padding: 72px 48px; display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 48px; align-items: center; }
        .about h2 { font-size: 22px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px; }
        .about h3 { font-size: clamp(22px, 3vw, 32px); font-weight: 700; line-height: 1.25; margin-bottom: 20px; }
        .about p { font-size: 16px; line-height: 1.7; color: #333; }
        .about-img { width: 100%; max-width: 480px; height: auto; display: block; margin: 0 auto; border-radius: 18px; filter: drop-shadow(0 16px 30px rgba(0,0,0,0.15)); animation: floaty 5s ease-in-out infinite; transition: transform .35s ease; }
        .about-img:hover { transform: scale(1.04); }
        @keyframes floaty { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-12px); } }

        /* Penghargaan */
        .award-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px; }
        .award-card { text-align: center; transition: transform .3s ease; }
        .award-card:hover { transform: translateY(-6px); }
        .award-photo { background: #e8e0d8; border: 1px solid #ddd; border-radius: 4px; aspect-ratio: 4/3; display: flex; align-items: center; justify-content: center; color: #888; font-size: 13px; font-weight: 700; padding: 12px; overflow: hidden; transition: transform .35s ease, box-shadow .35s ease; }
        .award-card:hover .award-photo { transform: scale(1.03); box-shadow: 0 14px 30px rgba(0,0,0,0.15); }
        .award-card h4 { margin-top: 16px; font-size: 16px; font-weight: 800; line-height: 1.4; }
        .award-nav { display: flex; justify-content: space-between; margin-top: 20px; }
        .award-nav button { background: none; border: 0; font-size: 22px; font-weight: 800; cursor: pointer; transition: transform .25s ease, color .25s ease; }
        .award-nav button:hover { transform: scale(1.3); color: #f59e0b; }

        #toTop { position: fixed; right: 24px; bottom: 24px; z-index: 80; width: 46px; height: 46px; border: 0; border-radius: 50%; background: #f59e0b; color: #fff; font-size: 20px; font-weight: 800; cursor: pointer; box-shadow: 0 10px 24px rgba(245,158,11,0.4); opacity: 0; visibility: hidden; transform: translateY(12px); transition: opacity .3s ease, transform .3s ease, visibility .3s; }
        #toTop.show { opacity: 1; visibility: visible; transform: translateY(0); }
        #toTop:hover { transform: translateY(-4px) scale(1.05); }

        @media (max-width: 900px) {
            .navbar { padding: 12px 20px; }
            .nav-links { display: none; position: absolute; top: 100%; left: 0; right: 0; max-height: calc(100vh - 70px); max-height: calc(100svh - 70px); overflow-y: auto; background: #fff; flex-direction: column; align-items: stretch; padding: 8px 20px 20px; gap: 4px; border-bottom: 1px solid #eee; box-shadow: 0 16px 30px rgba(0,0,0,0.08); }
            .nav-links.open { display: flex; animation: menuIn .3s ease; }
            @keyframes menuIn { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
            .nav-links > li > a { display: block; padding: 12px 0; }
            .nav-links > li > a::after { display: none; }
            .hamburger { display: block; }
            /* Video hero di HP: teks rata tengah agar komposisi rapi */
            .hero { align-items: flex-end; }
            .hero-inner { padding: 60px 20px 96px; max-width: 100%; text-align: center; }
            .hero-video { object-position: center 40%; }
            .section, .about-inner { padding: 48px 20px; }
            .section-title { font-size: 19px; }
            .about-inner { grid-template-columns: 1fr; gap: 32px; }
            .about-img { max-width: 320px; }
            .carousel-wrap { gap: 0; }
            .carousel-btn { display: none; }
            .carousel { scrollbar-width: none; scroll-snap-type: x mandatory; margin: 0 -20px; padding: 8px 20px 16px; }
            .carousel::-webkit-scrollbar { display: none; }
            .award-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
            .award-nav { display: none; }
            .info-card { flex-basis: 82%; padding: 28px 20px; min-height: 0; scroll-snap-align: center; }
            .dropdown { display: none; opacity: 1; visibility: visible; transform: none; transition: none; position: static; box-shadow: none; border: 0; border-left: 3px solid #eee; min-width: 0; width: 100%; }
            .dropdown a { padding: 10px 14px; font-size: 12px; }
            .has-dropdown.open > .dropdown { display: block; animation: menuIn .3s ease; }
            #toTop { right: 16px; bottom: 16px; width: 42px; height: 42px; }
        }

        @media (max-width: 480px) {
            .navbar { padding: 10px 16px; }
            .brand { gap: 8px; }
            .brand-logo { height: 34px; }
            .brand-name { font-size: 15px; }
            .hero h1 { font-size: 30px; }
            .section, .about-inner { padding: 40px 16px; }
            .carousel { margin: 0 -16px; padding-left: 16px; padding-right: 16px; }
            .info-card { flex-basis: 84%; }
            .award-card h4 { font-size: 13.5px; }
            .scroll-cue { bottom: 14px; }
        }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
            .reveal { opacity: 1; transform: none; }
        }
    </style>
</head>
<body>
    <header class="navbar" id="navbar">
        <a class="brand" href="/">
            <img class="brand-logo" src="{{ asset('logo-bumdesma.png') }}" alt="Logo BUMDESMA">
            <img class="brand-logo" src="{{ asset('logo-kabupaten.png') }}" alt="Logo Kabupaten">
            <span class="brand-name">BUMDESMA</span>
        </a>
        <button class="hamburger" aria-label="Menu" onclick="document.getElementById('navLinks').classList.toggle('open')">☰</button>
        <nav>
            <ul class="nav-links" id="navLinks">
                <li><a href="/" class="active">Beranda</a></li>
                <li class="has-dropdown">
                    <a href="#tentang" onclick="this.parentElement.classList.toggle('open');return false;">Profil<span class="caret">▾</span></a>
                    <ul class="dropdown">
                        <li><a href="#">Visi Misi</a></li>
                        <li><a href="#">Tugas Pokok &amp; Fungsi</a></li>
                        <li><a href="#">Struktur Organisasi</a></li>
                    </ul>
                </li>
                <li class="has-dropdown">
                    <a href="#sorotan" onclick="this.parentElement.classList.toggle('open');return false;">Unit Usaha<span class="caret">▾</span></a>
                    <ul class="dropdown">
                        <li><a href="#">PT.LKM</a></li>
                        <li><a href="#">Unit DBM</a></li>
                        <li><a href="#">Unit Perdagangan</a></li>
                        <li><a href="#">Unit Pertanian</a></li>
                    </ul>
                </li>
                <li><a href="#">Berita</a></li>
                <li><a href="#">Galeri</a></li>
                <li><a href="#penghargaan">Penghargaan</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <video id="heroVideoA" class="hero-video" autoplay muted playsinline preload="auto" src="{{ asset('video.mp4') }}?v={{ filemtime(public_path('video.mp4')) }}"></video>
        <video id="heroVideoB" class="hero-video faded" muted playsinline preload="auto" src="{{ asset('video.mp4') }}?v={{ filemtime(public_path('video.mp4')) }}"></video>
        <div class="hero-inner">
            {{-- Ganti teks placeholder ini dengan nama + wilayah asli --}}
            <h1>Nama Bumdesma.LKD</h1>
            <p>Kecamatan ... Kabupaten ... - Provinsi ...</p>
        </div>
        <a class="scroll-cue" href="#sorotan" aria-label="Gulir ke bawah">⌄</a>
    </section>

    {{-- Kartu sorotan ala #courses pada referensi --}}
    <section class="section reveal" id="sorotan">
        <div class="carousel-wrap">
            <button class="carousel-btn" aria-label="Sebelumnya" onclick="document.getElementById('highlightTrack').scrollBy({left:-360,behavior:'smooth'})">‹</button>
            <div class="carousel" id="highlightTrack">
                {{-- Ganti judul + deskripsi dengan konten asli --}}
                <article class="info-card reveal d1">
                    <div class="icon">◈</div>
                    <h3>Judul Sorotan 1</h3>
                    <p>Deskripsi singkat capaian atau program pertama. Ganti dengan teks asli, misalnya pertumbuhan ekonomi desa.</p>
                </article>
                <article class="info-card reveal d2">
                    <div class="icon">◈</div>
                    <h3>Judul Sorotan 2</h3>
                    <p>Deskripsi singkat program pemberdayaan atau pelibatan masyarakat. Ganti dengan teks asli.</p>
                </article>
                <article class="info-card reveal d3">
                    <div class="icon">◈</div>
                    <h3>Judul Sorotan 3</h3>
                    <p>Slot kartu ketiga — isi dengan sorotan lain atau hapus kartu ini bila hanya butuh dua.</p>
                </article>
            </div>
            <button class="carousel-btn" aria-label="Berikutnya" onclick="document.getElementById('highlightTrack').scrollBy({left:360,behavior:'smooth'})">›</button>
        </div>
    </section>

    {{-- Tentang --}}
    <section class="about reveal" id="tentang">
        <div class="about-inner">
            <div class="reveal d1">
                <h2>Tentang Bumdesma</h2>
                {{-- Ganti dengan profil asli --}}
                <h3>Badan Usaha Milik Desa Bersama (BUMDESMA)</h3>
                <p>Mewujudkan kesejahteraan masyarakat melalui pengelolaan usaha, pemanfaatan aset, pengembangan investasi dan produktivitas, serta layanan usaha lainnya untuk sebesar-besarnya kesejahteraan masyarakat desa. Ganti paragraf ini dengan profil asli.</p>
            </div>
            <div class="reveal d2"><img class="about-img" src="{{ asset('logo-bumdesma.png') }}" alt="Logo BUMDESMA"></div>
        </div>
    </section>

    {{-- Penghargaan --}}
    <section class="section reveal" id="penghargaan">
        <h2 class="section-title">Penghargaan</h2>
        <div class="award-grid">
            {{-- Ganti dengan foto + judul piagam asli --}}
            <div class="award-card reveal d1"><div class="award-photo">Foto piagam 4:3</div><h4>Judul penghargaan 1</h4></div>
            <div class="award-card reveal d2"><div class="award-photo">Foto piagam 4:3</div><h4>Judul penghargaan 2</h4></div>
            <div class="award-card reveal d3"><div class="award-photo">Foto piagam 4:3</div><h4>Judul penghargaan 3</h4></div>
            <div class="award-card reveal d4"><div class="award-photo">Foto piagam 4:3</div><h4>Judul penghargaan 4</h4></div>
        </div>
        <div class="award-nav">
            <button aria-label="Sebelumnya" onclick="window.scrollBy({top:0})">‹</button>
            <button aria-label="Berikutnya" onclick="window.scrollBy({top:0})">›</button>
        </div>
    </section>

    <button id="toTop" aria-label="Kembali ke atas" onclick="window.scrollTo({top:0,behavior:'smooth'})">↑</button>

    <script>
        (function () {
            var navbar = document.getElementById('navbar');
            var toTop = document.getElementById('toTop');
            var ticking = false;
            function onScroll() {
                var y = window.scrollY || window.pageYOffset;
                navbar.classList.toggle('scrolled', y > 10);
                toTop.classList.toggle('show', y > 600);
                ticking = false;
            }
            window.addEventListener('scroll', function () {
                if (!ticking) { window.requestAnimationFrame(onScroll); ticking = true; }
            }, { passive: true });
            onScroll();

            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
                });
            }, { threshold: 0.12 });
            document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });

            /* Seamless hero loop: crossfade ke lapisan kedua sebelum klip habis */
            var heroA = document.getElementById('heroVideoA');
            var heroB = document.getElementById('heroVideoB');
            if (heroA && heroB) {
                var FADE = 1.2, active = heroA, standby = heroB, switching = false;
                function onTick() {
                    var d = active.duration;
                    if (!switching && d && d - active.currentTime <= FADE) {
                        switching = true;
                        var old = active;
                        standby.currentTime = 0;
                        standby.play().catch(function () {});
                        standby.classList.remove('faded');
                        old.classList.add('faded');
                        setTimeout(function () {
                            old.pause();
                            active = standby; standby = old;
                            switching = false;
                        }, FADE * 1000);
                    }
                }
                heroA.addEventListener('timeupdate', onTick);
                heroB.addEventListener('timeupdate', onTick);
                heroA.play().catch(function () {});
            }
        })();
    </script>
</body>
</html>
