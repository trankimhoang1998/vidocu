{{-- Breadcrumbs Navigation --}}
<nav class="breadcrumbs" aria-label="Breadcrumb">
    <ol itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ route('home') }}" itemprop="item">
                <span itemprop="name">Trang chủ</span>
            </a>
            <meta itemprop="position" content="1" />
        </li>
        @isset($breadcrumbs)
            @foreach($breadcrumbs as $index => $breadcrumb)
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    @if($loop->last)
                        <span itemprop="name" aria-current="page">{{ $breadcrumb['name'] }}</span>
                    @else
                        <a href="{{ $breadcrumb['url'] }}" itemprop="item">
                            <span itemprop="name">{{ $breadcrumb['name'] }}</span>
                        </a>
                    @endif
                    <meta itemprop="position" content="{{ $index + 2 }}" />
                </li>
            @endforeach
        @endisset
    </ol>
</nav>
