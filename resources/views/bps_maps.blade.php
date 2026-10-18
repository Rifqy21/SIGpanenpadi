<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Data Panen</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icon -->
    <script src="https://kit.fontawesome.com/26af10689e.js" crossorigin="anonymous"></script>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

    <!-- Bootstrap 4 + AdminLTE lokal (sama seperti halaman lain) -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/dist/css/adminlte.min.css') }}">

    <style>
        :root {
            --lp-primary: #5A67D8;
            --lp-primary-dark: #4C51BF;
            --lp-primary-soft: #EEF0FF;
            --lp-ink: #1A202C;
            --lp-muted: #64748B;
            --lp-border: #E5E7EF;
            --lp-bg: #F8F9FD;

            --c-high: green;
            --c-mid: yellow;
            --c-low: red;
            --c-none: #CBD5E1;
        }

        html, body { height: 100%; }

        body.lp-body {
            font-family: 'Inter', sans-serif;
            color: var(--lp-ink);
            background: var(--lp-bg);
            margin: 0;
            overflow: hidden;
        }

        /* ---------- Navbar (sama dengan landing page) ---------- */
        .lp-nav {
            position: fixed;
            top: 16px;
            left: 50%;
            transform: translateX(-50%);
            width: min(1100px, calc(100% - 32px));
            z-index: 1100;
            background: rgba(255, 255, 255, .85);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--lp-border);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(90, 103, 216, .1);
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

        .lp-nav .nav-link:hover,
        .lp-nav .nav-link.active-lp { color: var(--lp-primary); background: var(--lp-primary-soft); }

        .lp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-weight: 600;
            border-radius: 10px;
            border: 1px solid transparent;
            transition: all .2s;
            text-decoration: none !important;
            cursor: pointer;
        }

        .lp-btn-primary {
            background: var(--lp-primary);
            color: #fff !important;
        }

        .lp-btn-primary:hover { background: var(--lp-primary-dark); }

        .lp-nav .lp-btn { padding: 5px 14px; font-size: .78rem; }

        /* ---------- Peta ---------- */
        #map {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            background: #EAEFF7;
            font-family: 'Inter', sans-serif;
        }

        /* ---------- Panel kiri ---------- */
        .map-panel {
            position: fixed;
            top: 84px;
            left: 16px;
            width: 320px;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            z-index: 1000;
            background: rgba(255, 255, 255, .45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, .6);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(90, 103, 216, .15);
            padding: 18px;
        }

        .panel-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: -.01em;
            margin-bottom: 14px;
        }

        .panel-toggle {
            margin-left: auto;
            flex: none;
            width: 32px;
            height: 32px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, .7);
            background: rgba(255, 255, 255, .55);
            color: var(--lp-muted);
            display: grid;
            place-items: center;
            font-size: 12px;
            cursor: pointer;
            transition: all .2s;
        }

        .panel-toggle:hover { color: var(--lp-primary); border-color: var(--lp-primary); }
        .panel-toggle:focus { outline: none; box-shadow: 0 0 0 3px rgba(90, 103, 216, .2); }

        .map-panel .panel-toggle i { transition: transform .25s; }
        .map-panel.collapsed .panel-toggle i { transform: rotate(180deg); }

        /* Panel diminimize: hanya header yang tersisa */
        .map-panel.collapsed {
            width: auto;
            min-width: 210px;
            padding: 10px 12px;
            overflow: visible;
        }

        .map-panel.collapsed .panel-title { margin-bottom: 0; }
        .map-panel.collapsed .panel-body { display: none; }

        .panel-title .ico {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: var(--lp-primary-soft);
            color: var(--lp-primary);
            display: grid;
            place-items: center;
            font-size: 14px;
        }

        .panel-label {
            display: block;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--lp-muted);
            margin-bottom: 6px;
        }

        .field {
            position: relative;
            margin-bottom: 14px;
        }

        .field > i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--lp-muted);
            font-size: .85rem;
            pointer-events: none;
        }

        .field .form-control {
            height: 42px;
            padding-left: 36px;
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 12px;
            background: rgba(255, 255, 255, .55);
            font-size: .9rem;
            font-weight: 500;
            box-shadow: none;
            transition: all .2s;
        }

        .field .form-control:focus {
            border-color: var(--lp-primary);
            box-shadow: 0 0 0 3px rgba(90, 103, 216, .15);
        }

        .search-row { display: flex; gap: 8px; }
        .search-row .field { flex: 1; margin-bottom: 0; }

        .search-row .lp-btn {
            height: 42px;
            width: 42px;
            padding: 0;
            font-size: .9rem;
        }

        .search-msg {
            min-height: 18px;
            margin: 6px 2px 14px;
            font-size: .78rem;
            font-weight: 500;
            color: var(--c-low);
        }

        .btn-reset {
            width: 100%;
            height: 38px;
            background: rgba(255, 255, 255, .55);
            border: 1px solid rgba(255, 255, 255, .7);
            color: var(--lp-muted);
            font-size: .82rem;
        }

        .btn-reset:hover { border-color: var(--lp-primary); color: var(--lp-primary); }

        /* ---------- Ringkasan ---------- */
        .stats {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px dashed rgba(100, 116, 139, .35);
            display: grid;
            gap: 10px;
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .4);
            border: 1px solid rgba(255, 255, 255, .6);
            border-radius: 14px;
            padding: 10px 12px;
        }

        .stat .ico {
            flex: none;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 14px;
            color: #fff;
        }

        .stat.total .ico { background: var(--lp-primary); }
        .stat.high .ico { background: var(--c-high); }
        .stat.low .ico { background: var(--c-low); }

        .stat .meta { min-width: 0; }

        .stat .meta small {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--lp-muted);
        }

        .stat .meta b {
            display: block;
            font-size: .92rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .stat .meta span {
            font-size: .76rem;
            color: var(--lp-muted);
        }

        /* ---------- Legenda ---------- */
        .legend-card {
            background: rgba(255, 255, 255, .45);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, .6);
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(90, 103, 216, .15);
            padding: 14px 16px;
            font-family: 'Inter', sans-serif;
            min-width: 190px;
        }

        .legend-card strong {
            display: block;
            font-size: .72rem;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--lp-muted);
            margin-bottom: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .82rem;
            font-weight: 500;
            margin-bottom: 7px;
        }

        .legend-item:last-child { margin-bottom: 0; }

        .legend-item i {
            flex: none;
            width: 16px;
            height: 16px;
            border-radius: 5px;
            display: inline-block;
        }

        /* ---------- Tooltip & Popup ---------- */
        .leaflet-tooltip.prov-tip {
            background: var(--lp-ink);
            color: #fff;
            border: 0;
            border-radius: 8px;
            padding: 5px 10px;
            font-family: 'Inter', sans-serif;
            font-size: .78rem;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .25);
        }

        .leaflet-tooltip.prov-tip::before { display: none; }

        .leaflet-popup-content-wrapper {
            border-radius: 18px;
            padding: 0;
            box-shadow: 0 20px 45px rgba(26, 32, 44, .25);
        }

        .leaflet-popup-content {
            margin: 0;
            width: 290px !important;
            font-family: 'Inter', sans-serif;
        }

        .leaflet-popup-tip { box-shadow: none; }

        .leaflet-container a.leaflet-popup-close-button {
            top: 10px;
            right: 10px;
            color: var(--lp-muted);
        }

        .pop { padding: 16px; }

        .pop-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            padding-right: 18px;
        }

        .pop-icon {
            flex: none;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--lp-primary-soft);
            color: var(--lp-primary);
            display: grid;
            place-items: center;
            font-size: 17px;
        }

        .pop-head small {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--lp-muted);
        }

        .pop-head b {
            display: block;
            font-size: 1rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -.01em;
        }

        .pop-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            background: var(--lp-bg);
            border: 1px solid var(--lp-border);
            border-radius: 12px;
            padding: 10px 12px;
            font-size: .82rem;
        }

        .pop-row + .pop-row { margin-top: 8px; }

        .pop-row > span { color: var(--lp-muted); font-weight: 500; white-space: nowrap; }
        .pop-row b { font-weight: 700; text-align: right; }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            color: #fff;
        }

        .pop-row .badge-status { color: #fff; font-weight: 700; white-space: nowrap; }
        .badge-status.high { background: var(--c-high); }
        .pop-row .badge-status.mid { background: var(--c-mid); color: #1A202C; }
        .badge-status.low { background: var(--c-low); }
        .pop-row .badge-status.none { background: var(--c-none); color: #475569; }

        /* Kontrol zoom Leaflet */
        .leaflet-control-zoom {
            border: 1px solid var(--lp-border) !important;
            border-radius: 12px !important;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(90, 103, 216, .15) !important;
        }

        .leaflet-control-zoom a {
            color: var(--lp-ink) !important;
            border: 0 !important;
            width: 34px !important;
            height: 34px !important;
            line-height: 34px !important;
        }

        .leaflet-control-zoom a:hover { background: var(--lp-primary-soft) !important; color: var(--lp-primary) !important; }

        /* ---------- Responsif ---------- */
        @media (max-width: 991px) {
            .lp-nav { top: 10px; padding: 8px 14px; }
            .lp-nav .navbar-collapse { padding: 12px 0 6px; }
        }

        @media (max-width: 575px) {
            .map-panel {
                top: 74px;
                left: 10px;
                right: 10px;
                width: auto;
                padding: 14px;
                max-height: none;
            }

            .map-panel .stats,
            .map-panel .btn-reset { display: none; }

            .map-panel.collapsed { right: auto; }

            .legend-card { min-width: 0; padding: 10px 12px; }
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
                    <a class="nav-link @if (request()->is('dataPanen') || request()->is('data-panen')) active-lp @endif"
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

    <!-- Panel: Filter tahun, pencarian, ringkasan -->
    <aside class="map-panel">
        <div class="panel-title">
            <span class="ico"><i class="fas fa-layer-group"></i></span>
            <span>Peta Data Panen</span>
            <button type="button" class="panel-toggle" id="panelToggle" onclick="togglePanel()"
                aria-expanded="true" aria-label="Minimize panel" title="Minimize / buka panel">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>

        <div class="panel-body">

        <label class="panel-label" for="tahunSelect">Tahun</label>
        <div class="field">
            <i class="fas fa-calendar-alt"></i>
            <select id="tahunSelect" class="form-control">
                @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <label class="panel-label" for="searchProvinsi">Cari Provinsi</label>
        <div class="search-row">
            <div class="field">
                <i class="fas fa-search"></i>
                <input type="text" id="searchProvinsi" class="form-control" placeholder="Contoh: Jawa Tengah"
                    list="provinsiList" autocomplete="off" />
            </div>
            <button type="button" class="lp-btn lp-btn-primary" onclick="zoomToProvinsi()" title="Cari">
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>
        <datalist id="provinsiList">
            @foreach ($provinsis as $provinsi)
                <option value="{{ $provinsi->nama_provinsi }}"></option>
            @endforeach
        </datalist>
        <div class="search-msg" id="searchMsg"></div>

        <button type="button" class="lp-btn btn-reset" onclick="resetView()">
            <i class="fas fa-expand"></i> Reset Tampilan
        </button>

        <div class="stats">
            <div class="stat total">
                <span class="ico"><i class="fas fa-wheat-awn"></i></span>
                <div class="meta">
                    <small>Total Produksi</small>
                    <b id="statTotal">-</b>
                    <span id="statTahun"></span>
                </div>
            </div>
            <div class="stat high">
                <span class="ico"><i class="fas fa-arrow-up"></i></span>
                <div class="meta">
                    <small>Tertinggi</small>
                    <b id="statHighNama">-</b>
                    <span id="statHighNilai"></span>
                </div>
            </div>
            <div class="stat low">
                <span class="ico"><i class="fas fa-arrow-down"></i></span>
                <div class="meta">
                    <small>Terendah</small>
                    <b id="statLowNama">-</b>
                    <span id="statLowNilai"></span>
                </div>
            </div>
        </div>
        </div><!-- /.panel-body -->
    </aside>

    <!-- Display Full Map -->
    <div id="map"></div>

    <!-- Scripts -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dist/js/adminlte.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

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
        const provinsis = @json($provinsis);
        const dataBps = @json($dataBps);
        const INITIAL_VIEW = [-0.789275, 113.921327];
        const INITIAL_ZOOM = 5;

        let panen;
        let panenPerProvinsi = {};
        let layersByKey = {};
        let geoLayer = null;
        let geoDataPromise = null;
        const limitsCache = {};

        // Peta dasar OpenStreetMap (sama seperti sebelumnya)
        let map = L.map('map', { zoomControl: false }).setView(INITIAL_VIEW, INITIAL_ZOOM);
        L.control.zoom({ position: 'topright' }).addTo(map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // ---------- Utilitas ----------
        // Warna sama seperti sebelumnya
        const WARNA = {
            high: 'green',
            mid: 'yellow',
            low: 'red'
        };

        function getColor(jumlah, batasAtas, batasBawah) {
            if (jumlah > batasAtas) return WARNA.high;
            else if (jumlah < batasBawah) return WARNA.low;
            else return WARNA.mid;
        }

        function getStatus(jumlah, batasAtas, batasBawah) {
            if (jumlah > batasAtas) return { kelas: 'high', label: 'Tinggi', ikon: 'fa-arrow-up' };
            else if (jumlah < batasBawah) return { kelas: 'low', label: 'Rendah', ikon: 'fa-arrow-down' };
            else return { kelas: 'mid', label: 'Sedang', ikon: 'fa-minus' };
        }

        function formatAngka(angka) {
            return Math.floor(angka).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // "JawaBarat" -> "Jawa Barat" (nama di GeoJSON ditulis tanpa spasi)
        function rapikanNama(nama) {
            return nama.replace(/([a-z])([A-Z])/g, '$1 $2');
        }

        function escapeHtml(str) {
            return String(str).replace(/[&<>"']/g, c => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[c]));
        }

        // Ruang kosong agar peta tidak tertutup panel kiri / navbar
        function paddingKiriAtas() {
            const panel = document.querySelector('.map-panel');
            const tertutup = panel && panel.classList.contains('collapsed');

            if (window.innerWidth > 575) return tertutup ? [260, 90] : [350, 90];
            return tertutup ? [20, 130] : [20, 170];
        }

        // ---------- Minimize panel ----------
        function setPanel(collapsed) {
            const panel = document.querySelector('.map-panel');
            const btn = document.getElementById('panelToggle');
            panel.classList.toggle('collapsed', collapsed);
            btn.setAttribute('aria-expanded', String(!collapsed));
            btn.setAttribute('aria-label', collapsed ? 'Buka panel' : 'Minimize panel');
            try { localStorage.setItem('petaPanelCollapsed', collapsed ? '1' : '0'); } catch (e) {}
        }

        function togglePanel() {
            setPanel(!document.querySelector('.map-panel').classList.contains('collapsed'));
        }

        // Ingat pilihan terakhir; di layar kecil panel mulai dalam keadaan minimize
        (function() {
            let simpan = null;
            try { simpan = localStorage.getItem('petaPanelCollapsed'); } catch (e) {}
            if (simpan === '1') setPanel(true);
            else if (simpan === null && window.innerWidth <= 575) setPanel(true);
        })();

        // GeoJSON provinsi cukup diunduh sekali
        function getGeoData() {
            if (!geoDataPromise) {
                geoDataPromise = fetch("{{ asset('data/provinsi.json') }}")
                    .then(r => r.json())
                    .catch(err => {
                        geoDataPromise = null; // coba lagi pada permintaan berikutnya
                        throw err;
                    });
            }
            return geoDataPromise;
        }

        // ---------- Legenda ----------
        const legend = L.control({ position: 'bottomright' });

        legend.onAdd = function() {
            const div = L.DomUtil.create('div', 'legend-card');
            div.innerHTML = `
                <strong>Keterangan</strong>
                <div class="legend-item"><i style="background:${WARNA.high}"></i><span class="legend-text-green">...</span></div>
                <div class="legend-item"><i style="background:${WARNA.mid}"></i><span class="legend-text-yellow">...</span></div>
                <div class="legend-item"><i style="background:${WARNA.low}"></i><span class="legend-text-red">...</span></div>
                <div class="legend-item"><i style="background:#E2E8F0; border:1px solid #CBD5E1"></i><span>Tidak ada data</span></div>
            `;
            L.DomEvent.disableClickPropagation(div);
            return div;
        };
        legend.addTo(map);

        function updateLegend(lowerLimit, upperLimit) {
            document.querySelector(".legend-text-green").textContent = `> ${formatAngka(upperLimit)} Ton`;
            document.querySelector(".legend-text-yellow").textContent = `${formatAngka(lowerLimit)} – ${formatAngka(upperLimit)} Ton`;
            document.querySelector(".legend-text-red").textContent = `< ${formatAngka(lowerLimit)} Ton`;
        }

        // ---------- Ringkasan ----------
        function updateStats(tahun) {
            let total = 0;
            let tertinggi = null;
            let terendah = null;

            Object.keys(panenPerProvinsi).forEach(function(key) {
                const nilai = panenPerProvinsi[key];
                if (!nilai) return; // lewati provinsi tanpa data

                total += nilai;
                if (!tertinggi || nilai > tertinggi.nilai) tertinggi = { key, nilai };
                if (!terendah || nilai < terendah.nilai) terendah = { key, nilai };
            });

            const namaDari = key => {
                const p = provinsis.find(x => x.nama_provinsi.replace(/\s/g, '') === key);
                return p ? p.nama_provinsi : rapikanNama(key);
            };

            document.getElementById('statTotal').textContent = total ? `${formatAngka(total)} Ton` : 'Tidak ada data';
            document.getElementById('statTahun').textContent = `Tahun ${tahun}`;
            document.getElementById('statHighNama').textContent = tertinggi ? namaDari(tertinggi.key) : '-';
            document.getElementById('statHighNilai').textContent = tertinggi ? `${formatAngka(tertinggi.nilai)} Ton` : '';
            document.getElementById('statLowNama').textContent = terendah ? namaDari(terendah.key) : '-';
            document.getElementById('statLowNilai').textContent = terendah ? `${formatAngka(terendah.nilai)} Ton` : '';
        }

        // ---------- Popup ----------
        function buatPopup(namaProvinsi, jumlahPanen, upperLimit, lowerLimit) {
            const nama = escapeHtml(rapikanNama(namaProvinsi));
            const ada = jumlahPanen !== undefined && jumlahPanen !== 0;

            const jumlahHtml = ada ?
                `${formatAngka(jumlahPanen)} Ton` :
                'Data tidak tersedia';

            const status = ada ?
                getStatus(jumlahPanen, upperLimit, lowerLimit) :
                { kelas: 'none', label: 'Tidak ada data', ikon: 'fa-ban' };

            return `
                <div class="pop">
                    <div class="pop-head">
                        <span class="pop-icon"><i class="fas fa-location-dot"></i></span>
                        <div>
                            <small>Provinsi</small>
                            <b>${nama}</b>
                        </div>
                    </div>
                    <div class="pop-row">
                        <span><i class="fas fa-wheat-awn mr-1"></i> Jumlah Panen</span>
                        <b>${jumlahHtml}</b>
                    </div>
                    <div class="pop-row">
                        <span><i class="fas fa-chart-simple mr-1"></i> Status</span>
                        <span class="badge-status ${status.kelas}"><i class="fas ${status.ikon}"></i> ${status.label}</span>
                    </div>
                </div>
            `;
        }

        // ---------- Peta ----------
        function showMap() {
            panen = dataBps;
            const selectedTahun = document.getElementById('tahunSelect').value;
            panen = panen.filter(p => p.tahun == selectedTahun);

            panenPerProvinsi = {};
            provinsis.forEach(function(provinsi) {
                let nama = provinsi.nama_provinsi.replace(/\s/g, '');
                panenPerProvinsi[nama] = 0;
            });

            panen.forEach(function(p) {
                let namaProvinsi = p.provinsi.replace(/\s/g, '');
                if (panenPerProvinsi[namaProvinsi] !== undefined) {
                    panenPerProvinsi[namaProvinsi] += parseInt(p.produksi);
                } else {
                    panenPerProvinsi[namaProvinsi] = parseInt(p.produksi);
                }
            });

            updateStats(selectedTahun);

            if (!limitsCache[selectedTahun]) {
                limitsCache[selectedTahun] = fetch(`/landing/limits-panen?tahun=${selectedTahun}`)
                    .then(res => res.json())
                    .catch(err => {
                        delete limitsCache[selectedTahun];
                        throw err;
                    });
            }

            Promise.all([limitsCache[selectedTahun], getGeoData()])
                .then(([{ upperLimit, lowerLimit }, data]) => {
                    // Abaikan jika tahun sudah diganti saat data masih dimuat
                    if (document.getElementById('tahunSelect').value !== selectedTahun) return;

                    updateLegend(lowerLimit, upperLimit);

                    // Hapus layer geojson lama
                    if (geoLayer) {
                        map.removeLayer(geoLayer);
                        geoLayer = null;
                    }
                    layersByKey = {};

                    const provinsiOnly = {
                        ...data,
                        features: data.features.filter(f => !f.properties.NAME_2 && !f.properties.NAME_3)
                    };

                    const gayaDasar = function(feature) {
                        const namaProvinsi = feature.properties.NAME_1;
                        const key = namaProvinsi.replace(/\s/g, '');
                        const jumlahPanen = panenPerProvinsi[key];

                        // Hanya warnai jika ada data
                        let warna = null;
                        if (jumlahPanen !== undefined && jumlahPanen !== 0) {
                            warna = getColor(jumlahPanen, upperLimit, lowerLimit);
                        }

                        return {
                            fillColor: warna ?? 'transparent',
                            weight: 1,
                            opacity: 1,
                            color: 'white',
                            dashArray: '3',
                            fillOpacity: warna ? 0.6 : 0
                        };
                    };

                    geoLayer = L.geoJSON(provinsiOnly, {
                        style: gayaDasar,

                        onEachFeature: function(feature, layer) {
                            const namaProvinsi = feature.properties.NAME_1;
                            const key = namaProvinsi.replace(/\s/g, '');
                            const jumlahPanen = panenPerProvinsi[key];

                            layersByKey[key.toLowerCase()] = layer;

                            layer.bindPopup(
                                buatPopup(namaProvinsi, jumlahPanen, upperLimit, lowerLimit), {
                                    maxWidth: 310,
                                    autoPanPaddingTopLeft: paddingKiriAtas(),
                                    autoPanPaddingBottomRight: [20, 20]
                                }
                            );

                            layer.bindTooltip(rapikanNama(namaProvinsi), {
                                sticky: true,
                                direction: 'top',
                                className: 'prov-tip'
                            });

                            // Efek hover
                            layer.on('mouseover', function() {
                                if (jumlahPanen) {
                                    layer.setStyle({ weight: 2.5, color: '#4C51BF', dashArray: null, fillOpacity: 0.85 });
                                } else {
                                    layer.setStyle({ weight: 2.5, color: '#4C51BF', fillColor: '#5A67D8', fillOpacity: 0.12 });
                                }
                                layer.bringToFront();
                            });
                            layer.on('mouseout', function() {
                                geoLayer.resetStyle(layer);
                            });
                        }
                    }).addTo(map);
                })
                .catch(error => {
                    console.error('Gagal mengambil batas atas/bawah dari backend:', error);
                });
        }

        showMap();

        document.getElementById('tahunSelect').addEventListener('change', function() {
            showMap();
        });

        // ---------- Pencarian ----------
        function tampilkanPesan(teks) {
            document.getElementById('searchMsg').textContent = teks || '';
        }

        function zoomToProvinsi() {
            const provinsiDicari = document.getElementById('searchProvinsi').value.toLowerCase().replace(/\s/g, '');
            tampilkanPesan('');

            if (!provinsiDicari) {
                tampilkanPesan('Masukkan nama provinsi terlebih dahulu.');
                return;
            }

            getGeoData()
                .then(data => {
                    const fitur = data.features.find(f => {
                        const nama = f.properties.NAME_1.toLowerCase().replace(/\s/g, '');
                        return nama === provinsiDicari;
                    });

                    if (fitur) {
                        const layer = L.geoJSON(fitur);
                        map.fitBounds(layer.getBounds(), { paddingTopLeft: paddingKiriAtas(), paddingBottomRight: [30, 30] });

                        // Buka popup provinsi yang dicari
                        const target = layersByKey[provinsiDicari];
                        if (target) {
                            map.once('moveend', function() { target.openPopup(); });
                        }
                    } else {
                        tampilkanPesan('Provinsi tidak ditemukan.');
                    }
                })
                .catch(error => {
                    console.error("Gagal mencari provinsi:", error);
                    tampilkanPesan('Gagal memuat data provinsi.');
                });
        }

        function resetView() {
            map.closePopup();
            map.setView(INITIAL_VIEW, INITIAL_ZOOM);
        }

        // Tekan Enter untuk mencari
        document.getElementById('searchProvinsi').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                zoomToProvinsi();
            }
        });

        document.getElementById('searchProvinsi').addEventListener('input', function() {
            tampilkanPesan('');
        });
    </script>

</body>

</html>