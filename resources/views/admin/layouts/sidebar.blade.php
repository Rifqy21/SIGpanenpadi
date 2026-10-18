<style>
    /* ---------- Sidebar SIG Panen Padi (tema putih) ---------- */

    .main-sidebar.sidebar-padi {
        background: #fff !important;
        border-right: 1px solid #E5E7EF;
        box-shadow: none;
    }

    /* Brand: hanya bagian ini yang berwarna ungu */
    .sidebar-padi .brand-link {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 64px;
        padding: 14px 16px;
        background: linear-gradient(135deg, #6366F1, #8B5CF6) !important;
        border-bottom: 0;
        text-decoration: none !important;
    }

    .sidebar-padi .brand-mark {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        border-radius: 10px;
        background: rgba(255, 255, 255, .2);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
    }

    .sidebar-padi .brand-text {
        color: #fff;
        font-size: .95rem;
        font-weight: 800 !important;
        letter-spacing: -.01em;
        white-space: nowrap;
    }

    /* Search */
    .sidebar-padi .form-inline {
        padding: 14px 14px 4px;
        margin-bottom: 4px;
    }

    .sidebar-padi .form-control-sidebar {
        background: #F5F6FB;
        border: 1px solid #E5E7EF;
        border-radius: 10px 0 0 10px;
        color: #1A202C;
        font-size: .85rem;
        box-shadow: none;
    }

    .sidebar-padi .form-control-sidebar::placeholder {
        color: #94A3B8;
    }

    .sidebar-padi .form-control-sidebar:focus {
        background: #fff;
        color: #1A202C;
        border-color: #5A67D8;
        box-shadow: 0 0 0 3px rgba(90, 103, 216, .12);
    }

    .sidebar-padi .btn-sidebar {
        background: #F5F6FB;
        border: 1px solid #E5E7EF;
        border-radius: 0 10px 10px 0;
        color: #64748B;
    }

    .sidebar-padi .btn-sidebar:hover {
        color: #5A67D8;
    }

    /* Header kategori menu */
    .sidebar-padi .nav-header {
        padding: 14px 20px 6px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #94A3B8;
    }

    /* Item menu */
    .sidebar-padi .nav-sidebar > .nav-item > .nav-link {
        margin: 3px 12px;
        padding: 9px 12px;
        border-radius: 10px;
        color: #475569 !important;
        font-size: .9rem;
        font-weight: 600;
        transition: background .2s, color .2s;
    }

    .sidebar-padi .nav-sidebar > .nav-item > .nav-link:hover {
        background: #F3F4FB;
        color: #5A67D8 !important;
    }

    /* Menu aktif */
    .sidebar-padi .nav-sidebar > .nav-item > .nav-link.active {
        background: #7C6CF2 !important;
        color: #fff !important;
    }

    .sidebar-padi .nav-sidebar .nav-icon {
        width: 1.4rem;
        font-size: .85rem;
    }

    /* Logout */
    .sidebar-padi .nav-sidebar > .nav-item > .nav-link.logout:hover {
        background: #FFF1F2;
        color: #E11D48 !important;
    }

    /* ---------- Navbar (selaras dengan sidebar putih) ---------- */
    .main-header.navbar {
        background: #fff !important;
        border-bottom: 1px solid #E5E7EF !important;
        box-shadow: none !important;
        color: #1A202C;
    }

    .main-header.navbar .nav-link {
        color: #475569 !important;
        font-weight: 600;
        border-radius: 10px;
        transition: background .2s, color .2s;
    }

    .main-header.navbar .nav-link:hover {
        background: #F3F4FB;
        color: #5A67D8 !important;
    }

    .main-header.navbar .nav-link[data-widget="pushmenu"] i {
        color: #64748B;
    }

    .main-header.navbar .nav-link[data-widget="pushmenu"]:hover i {
        color: #5A67D8;
    }
</style>

<aside class="main-sidebar sidebar-light-primary sidebar-padi elevation-0">
    <!-- Brand -->
    <a href="{{ route('admin') }}" class="brand-link">
        <span class="brand-mark"><i class="fas fa-seedling"></i></span>
        <span class="brand-text">Admin SIG Panen Padi</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Search -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..."
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar" type="button">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-header">Menu Utama</li>

                <li class="nav-item">
                    <a href="{{ route('admin') }}"
                        class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.data-bps.index') }}"
                        class="nav-link {{ request()->is('admin/data-bps') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Data Panen</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.data-bps.map') }}"
                        class="nav-link {{ request()->is('admin/data-bps/map') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-map"></i>
                        <p>Peta</p>
                    </a>
                </li>

                <li class="nav-header">Akun</li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link logout">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>