<header class="user-header">
    {{-- Top Bar --}}
    <div class="top-bar">
        <div class="container">
            <p>Chào mừng bạn đến với Vidocu.com</p>
        </div>
    </div>

    {{-- Logo --}}
    <div class="header-logo">
        <div class="container">
            <a href="{{ route('home') }}" class="logo">
                <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Vidocu</span>
            </a>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="main-nav">
        <div class="container">
            <ul class="nav-menu">
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') || request()->routeIs('post.detail') ? 'active' : '' }}">
                        TRANG CHỦ
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags') }}" class="{{ request()->routeIs('tags') || request()->routeIs('tag.show') ? 'active' : '' }}">
                        TAGS
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
