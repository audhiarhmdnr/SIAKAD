<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mini SIAKAD – Sistem Informasi Jadwal Kuliah Kalla Institute">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="layout">

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('jadwal.grid') }}" class="logo-wrapper">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="sidebar-logo">
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Main</div>
            
            <a href="{{ route('jadwal.grid') }}" class="nav-item {{ request()->routeIs('jadwal.grid') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </span>
                <span class="nav-label">Grid Jadwal</span>
            </a>

            <div class="nav-section-label">Master Data</div>
            <a href="{{ route('jadwal.index') }}" class="nav-item {{ request()->routeIs('jadwal.*') && !request()->routeIs('jadwal.grid') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                </span>
                <span class="nav-label">Jadwal</span>
            </a>
            <a href="{{ route('dosen.index') }}" class="nav-item {{ request()->routeIs('dosen.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </span>
                <span class="nav-label">Dosen</span>
            </a>
            <a href="{{ route('mata-kuliah.index') }}" class="nav-item {{ request()->routeIs('mata-kuliah.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </span>
                <span class="nav-label">Mata Kuliah</span>
            </a>
            <a href="{{ route('ruangan.index') }}" class="nav-item {{ request()->routeIs('ruangan.*') ? 'active' : '' }}">
                <span class="nav-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </span>
                <span class="nav-label">Ruangan</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">KI</div>
                <div class="user-info">
                    <span class="user-name">Admin SIAKAD</span>
                    <span class="user-role">Kalla Institute</span>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <button class="topbar-toggle" id="sidebarToggle">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <div class="topbar-right">
                <div class="topbar-time" id="topbarTime"></div>
                <div class="topbar-badge">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
            </div>
        </header>

        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success" id="flashAlert">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
