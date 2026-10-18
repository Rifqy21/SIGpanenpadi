<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIG Data Panen</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icon -->
    <script src="https://kit.fontawesome.com/26af10689e.js" crossorigin="anonymous"></script>

    <!-- Plugin CSS (Bootstrap 4 + AdminLTE lokal, dipakai juga oleh halaman lain) -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jqvmap/jqvmap.min.css') }}">

    <style>
        :root {
            --lp-primary: #5A67D8;
            --lp-primary-dark: #4C51BF;
            --lp-primary-soft: #EEF0FF;
            --lp-ink: #1A202C;
            --lp-muted: #64748B;
            --lp-border: #E5E7EF;
            --lp-bg: #F8F9FD;
            --lp-radius: 20px;
        }

        html { scroll-behavior: smooth; }

        body.lp-body {
            font-family: 'Inter', sans-serif;
            color: var(--lp-ink);
            background: var(--lp-bg);
            overflow-x: hidden;
            margin: 0;
        }

        /* ---------- Navbar ---------- */
        .lp-nav {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: min(1100px, calc(100% - 32px));
            z-index: 1000;
            background: rgba(255, 255, 255, .8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--lp-border);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(90, 103, 216, .08);
            padding: 10px 18px;
        }

        .lp-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            color: var(--lp-ink);
            text-decoration: none !important;
            letter-spacing: -.01em;
        }

        .lp-brand .logo {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--lp-primary), #8B5CF6);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 16px;
        }

        .lp-nav .nav-link {
            color: var(--lp-muted);
            font-weight: 600;
            font-size: .9rem;
            padding: 8px 14px !important;
            border-radius: 10px;
            transition: all .2s;
        }

        .lp-nav .nav-link:hover { color: var(--lp-primary); background: var(--lp-primary-soft); }
        .lp-nav .nav-link.active-lp { color: var(--lp-primary); background: var(--lp-primary-soft); }

        .lp-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: .95rem;
            border-radius: 12px;
            padding: 11px 22px;
            border: 1px solid transparent;
            transition: all .2s;
            text-decoration: none !important;
            cursor: pointer;
        }

        .lp-btn-primary {
            background: var(--lp-primary);
            color: #fff !important;
            box-shadow: 0 8px 20px rgba(90, 103, 216, .3);
        }

        .lp-btn-primary:hover { background: var(--lp-primary-dark); transform: translateY(-2px); }

        .lp-btn-ghost {
            background: #fff;
            color: var(--lp-ink) !important;
            border-color: var(--lp-border);
        }

        .lp-btn-ghost:hover { border-color: var(--lp-primary); color: var(--lp-primary) !important; transform: translateY(-2px); }

        .lp-nav .lp-btn { padding: 5px 14px; font-size: .78rem; gap: 6px; border-radius: 10px; box-shadow: none; }

        /* ---------- Hero ---------- */
        .lp-hero {
            position: relative;
            padding: 150px 0 90px;
            background:
                radial-gradient(600px 300px at 15% 10%, rgba(90, 103, 216, .18), transparent 70%),
                radial-gradient(500px 300px at 90% 30%, rgba(139, 92, 246, .15), transparent 70%),
                var(--lp-bg);
        }

        .lp-hero h1 {
            font-size: clamp(1.8rem, 3.6vw, 2.7rem);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -.02em;
            margin-bottom: 18px;
        }

        .lp-hero h1 span {
            background: linear-gradient(135deg, var(--lp-primary), #8B5CF6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .lp-hero p.lead {
            color: var(--lp-muted);
            font-size: 1.05rem;
            line-height: 1.75;
            max-width: 520px;
        }

        .lp-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }

        .lp-map-card {
            background: #fff;
            border: 1px solid var(--lp-border);
            border-radius: 24px;
            padding: 18px;
            box-shadow: 0 25px 60px rgba(90, 103, 216, .15);
            transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease;
            cursor: pointer;
        }

        /* Hover: kartu terangkat dan peta membesar sedikit */
        .lp-map-card:hover {
            transform: translateY(-8px);
            border-color: rgba(90, 103, 216, .35);
            box-shadow: 0 35px 70px rgba(90, 103, 216, .25);
        }

        .lp-map-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2px 6px 14px;
            font-weight: 700;
            font-size: .95rem;
        }

        .lp-map-head small { color: var(--lp-muted); font-weight: 500; }

        .lp-dots i {
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            margin-left: 5px;
            background: #E2E8F0;
            transition: background .3s;
        }

        .lp-map-card:hover .lp-dots i { background: var(--lp-primary); }
        .lp-map-card:hover .lp-dots i:nth-child(2) { background: #8B5CF6; }
        .lp-map-card:hover .lp-dots i:nth-child(3) { background: #A5B4FC; }

        #world-map {
            height: 250px !important;
            width: 100%;
            background: var(--lp-primary-soft);
            border-radius: 14px;
            position: relative;
            overflow: hidden;
            transition: transform .45s ease, box-shadow .45s ease;
        }

        .lp-map-card:hover #world-map {
            transform: scale(1.03);
            box-shadow: inset 0 0 0 1px rgba(90, 103, 216, .2);
        }

        @media (max-width: 575px) {
            #world-map { height: 200px !important; }
        }

        /* Tombol zoom peta (ikon Font Awesome) */
        .jqvmap-zoomin,
        .jqvmap-zoomout {
            left: auto !important;
            right: 12px;
            width: 30px !important;
            height: 30px !important;
            padding: 0 !important;
            line-height: 1 !important;
            display: grid;
            place-items: center;
            background: #fff !important;
            color: var(--lp-primary) !important;
            border: 1px solid var(--lp-border);
            border-radius: 8px !important;
            font-size: 12px;
            box-shadow: 0 2px 8px rgba(90, 103, 216, .15);
            transition: all .2s;
        }

        .jqvmap-zoomin { top: 12px !important; }
        .jqvmap-zoomout { top: 50px !important; }

        .jqvmap-zoomin:hover,
        .jqvmap-zoomout:hover {
            background: var(--lp-primary) !important;
            color: #fff !important;
        }

        /* Tooltip nama wilayah */
        .jqvmap-label {
            background: var(--lp-ink) !important;
            border-radius: 8px !important;
            padding: 6px 10px !important;
            font-family: 'Inter', sans-serif;
            font-size: .8rem;
            font-weight: 600;
        }

        /* ---------- Section ---------- */
        .lp-section { padding: 90px 0; }

        .lp-eyebrow {
            color: var(--lp-primary);
            font-weight: 700;
            font-size: .8rem;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .lp-title {
            font-weight: 800;
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            letter-spacing: -.02em;
            margin: 8px 0 12px;
        }

        .lp-sub { color: var(--lp-muted); max-width: 560px; margin: 0 auto; line-height: 1.7; }

        .lp-feature {
            height: 100%;
            background: #fff;
            border: 1px solid var(--lp-border);
            border-radius: var(--lp-radius);
            padding: 28px;
            transition: all .25s;
        }

        .lp-feature:hover {
            transform: translateY(-6px);
            border-color: transparent;
            box-shadow: 0 20px 45px rgba(90, 103, 216, .15);
        }

        .lp-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: var(--lp-primary-soft);
            color: var(--lp-primary);
            display: grid;
            place-items: center;
            font-size: 22px;
            margin-bottom: 18px;
        }

        .lp-feature h5 { font-weight: 700; margin-bottom: 8px; }
        .lp-feature p { color: var(--lp-muted); margin: 0; line-height: 1.7; font-size: .95rem; }

        /* ---------- Tentang padi ---------- */
        .lp-about {
            background: #fff;
            border: 1px solid var(--lp-border);
            border-radius: 28px;
            padding: 40px;
        }

        .lp-about img {
            width: 100%;
            height: 100%;
            max-height: 340px;
            object-fit: cover;
            border-radius: 20px;
        }

        .lp-about p { color: var(--lp-muted); line-height: 1.8; }

        /* ---------- CTA & Footer ---------- */
        .lp-cta {
            background: linear-gradient(135deg, var(--lp-primary), #8B5CF6);
            border-radius: 28px;
            padding: 56px 32px;
            text-align: center;
            color: #fff;
        }

        .lp-cta h2 { font-weight: 800; letter-spacing: -.02em; }
        .lp-cta p { opacity: .9; }
        .lp-cta .lp-btn { background: #fff; color: var(--lp-primary-dark) !important; }

        .lp-footer {
            padding: 28px 0;
            text-align: center;
            color: var(--lp-muted);
            font-size: .88rem;
        }

        /* ---------- Modal ---------- */
        .lp-modal .modal-content { border: 0; border-radius: 24px; overflow: hidden; }
        .lp-modal .modal-header {
            background: linear-gradient(135deg, var(--lp-primary), #8B5CF6);
            color: #fff;
            border: 0;
            padding: 20px 26px;
        }
        .lp-modal .close { color: #fff; opacity: .9; text-shadow: none; }

        /* ---------- Animasi ---------- */
        .reveal { opacity: 0; transform: translateY(24px); transition: all .7s ease; }
        .reveal.show { opacity: 1; transform: none; }

        @media (max-width: 991px) {
            .lp-nav { top: 10px; padding: 8px 14px; }
            .lp-hero { padding: 120px 0 60px; }
            .lp-section { padding: 60px 0; }
            .lp-about { padding: 24px; }
            .lp-nav .navbar-collapse { padding: 12px 0 6px; }
        }
    </style>
</head>

<body class="lp-body">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg lp-nav">
        <a class="lp-brand" href="{{ route('landing-page') }}">
            <span class="logo"><i class="fas fa-wheat-awn"></i></span>
            SIG Panen Padi
        </a>
        <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#lpNav"
            aria-controls="lpNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="lpNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link @if (request()->is('/')) active-lp @endif"
                        href="{{ route('landing-page') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->is('data-panen')) active-lp @endif"
                        href="{{ route('data-panen') }}">Data Panen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->is('bpsMaps')) active-lp @endif"
                        href="{{ route('bps-maps') }}">Peta</a>
                </li>
            </ul>
            <a class="lp-btn lp-btn-primary" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </nav>

    <!-- Hero -->
    <header class="lp-hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0 reveal">
                    <h1>Sistem Informasi Geografis <span>Panen Padi</span></h1>
                    <p class="lead">
                        Lihat data panen berdasarkan provinsi, tahun, dan lainnya melalui tampilan peta dan grafik
                        yang interaktif, mudah dibaca, dan selalu siap diakses.
                    </p>
                    <div class="lp-actions">
                        <a href="{{ route('data-panen') }}" class="lp-btn lp-btn-primary">
                            <i class="fas fa-table"></i> Lihat Data Panen
                        </a>
                        <a href="{{ route('bps-maps') }}" class="lp-btn lp-btn-ghost">
                            <i class="fas fa-map-marked-alt"></i> Buka Peta
                        </a>
                        <button type="button" class="lp-btn lp-btn-ghost" data-toggle="modal"
                            data-target="#tentangPadiModal">
                            <i class="fas fa-info-circle"></i> Tentang Padi
                        </button>
                    </div>
                </div>

                <div class="col-lg-6 reveal">
                    <div class="lp-map-card">
                        <div class="lp-map-head">
                            <div>Peta Indonesia <small class="d-block">Sebaran wilayah</small></div>
                            <div class="lp-dots"><i></i><i></i><i></i></div>
                        </div>
                        <div id="world-map"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Fitur -->
    <section class="lp-section" id="fitur">
        <div class="container">
            <div class="text-center mb-5 reveal">
                <span class="lp-eyebrow">Fitur</span>
                <h2 class="lp-title">Semua yang Anda butuhkan</h2>
                <p class="lp-sub">Akses informasi panen dengan cepat, dari tabel data hingga visualisasi peta.</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4 reveal">
                    <div class="lp-feature">
                        <div class="lp-icon"><i class="fas fa-table"></i></div>
                        <h5>Data Panen</h5>
                        <p>Telusuri data panen per provinsi dan tahun dalam tabel yang rapi dan mudah dicari.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 reveal">
                    <div class="lp-feature">
                        <div class="lp-icon"><i class="fas fa-map"></i></div>
                        <h5>Peta Interaktif</h5>
                        <p>Visualisasi sebaran wilayah secara geografis agar pola panen lebih mudah dipahami.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4 reveal">
                    <div class="lp-feature">
                        <div class="lp-icon"><i class="fas fa-chart-line"></i></div>
                        <h5>Grafik &amp; Analisis</h5>
                        <p>Pantau perkembangan produksi dari waktu ke waktu untuk mendukung pengambilan keputusan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Padi -->
    <section class="lp-section pt-0" id="tentang">
        <div class="container">
            <div class="lp-about reveal">
                <div class="row align-items-center">
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <img src="{{ asset('assets/img/landing_page/padi.jpg') }}" alt="Ilustrasi Tanaman Padi">
                    </div>
                    <div class="col-lg-7 pl-lg-5">
                        <span class="lp-eyebrow">Tentang</span>
                        <h2 class="lp-title">Tanaman Padi</h2>
                        <p>
                            Padi merupakan komoditas utama sektor pertanian di Indonesia. Beras menjadi makanan pokok
                            sehari-hari, sehingga produksi padi menjadi indikator penting bagi ketahanan pangan nasional.
                        </p>
                        <p>
                            Potensi lahan sawah tiap daerah berbeda, dipengaruhi iklim, jenis tanah, dan ketersediaan
                            air. Dengan sistem informasi geografis, perkembangan produksi dapat dipantau lebih efektif
                            untuk mendukung kebijakan pertanian yang tepat sasaran.
                        </p>
                        <button type="button" class="lp-btn lp-btn-ghost mt-2" data-toggle="modal"
                            data-target="#tentangPadiModal">
                            Baca selengkapnya <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="pb-5">
        <div class="container reveal">
            <div class="lp-cta">
                <h2>Siap menjelajahi data panen?</h2>
                <p class="mb-4">Mulai dari melihat data, atau login untuk mengelola data.</p>
                <a href="{{ route('data-panen') }}" class="lp-btn">Mulai Sekarang <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <footer class="lp-footer">
        &copy; {{ date('Y') }} Sistem Informasi Geografis Data Panen
    </footer>

    <!-- Modal: Tentang Tanaman Padi -->
    <div class="modal fade lp-modal" id="tentangPadiModal" tabindex="-1" role="dialog"
        aria-labelledby="tentangPadiLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="tentangPadiLabel"><i class="fas fa-seedling mr-2"></i> Tentang Tanaman Padi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-3 mb-md-0">
                            <img src="{{ asset('assets/img/landing_page/padi.jpg') }}" class="img-fluid rounded shadow-sm"
                                alt="Ilustrasi Tanaman Padi">
                        </div>
                        <div class="col-md-7" style="color: var(--lp-muted); line-height: 1.8;">
                            <p><i class="fas fa-seedling mr-2" style="color: var(--lp-primary);"></i>Tanaman padi merupakan komoditas utama dalam sektor pertanian di Indonesia. Sebagian besar masyarakat mengandalkan <i>beras</i> sebagai makanan pokok, sehingga produksi padi menjadi indikator penting ketahanan pangan nasional.</p>
                            <p><i class="fas fa-map-marker-alt mr-2" style="color: var(--lp-primary);"></i>Setiap daerah memiliki potensi lahan sawah yang berbeda, dipengaruhi iklim, jenis tanah, dan ketersediaan air. Jawa Tengah, Jawa Timur, dan Sumatera Utara menjadi kontributor besar produksi padi nasional.</p>
                            <p class="mb-0"><i class="fas fa-chart-bar mr-2" style="color: var(--lp-primary);"></i>Dengan data geografis dan sistem informasi, perkembangan produksi padi di berbagai wilayah dapat dipantau lebih efektif untuk mendukung kebijakan pertanian yang tepat sasaran.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jqvmap/maps/jquery.vmap.indonesia.js') }}"></script>

    @if (session('success'))
        <script>
            $(document).Toasts('create', { class: 'bg-success', title: 'Sukses', body: @json(session('success')) });
        </script>
    @endif
    @if (session('info'))
        <script>
            $(document).Toasts('create', { class: 'bg-info', title: 'Informasi', body: @json(session('info')) });
        </script>
    @endif
    @if (session('error'))
        <script>
            $(document).Toasts('create', { class: 'bg-danger', title: 'Gagal', body: @json(session('error')) });
        </script>
    @endif
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                $(document).Toasts('create', { class: 'bg-danger', title: 'Gagal', body: @json($error) });
            @endforeach
        </script>
    @endif

    <script>
        $(document).ready(function() {
            // Peta Indonesia
            $('#world-map').vectorMap({
                map: 'indonesia_id',
                backgroundColor: 'transparent',
                color: '#7F8AE6',
                hoverColor: '#4C51BF',
                selectedColor: '#4C51BF',
                borderColor: '#ffffff',
                borderOpacity: 1,
                borderWidth: 0.8,
                hoverOpacity: 1,
                enableZoom: true,
                showTooltip: true
            });

            // Ganti tombol zoom bawaan dengan ikon Font Awesome
            $('.jqvmap-zoomin').html('<i class="fas fa-plus"></i>');
            $('.jqvmap-zoomout').html('<i class="fas fa-minus"></i>');

            // Animasi muncul saat scroll
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        e.target.classList.add('show');
                        io.unobserve(e.target);
                    }
                });
            }, { threshold: 0.12 });
            document.querySelectorAll('.reveal').forEach(el => io.observe(el));
        });
    </script>
</body>

</html>