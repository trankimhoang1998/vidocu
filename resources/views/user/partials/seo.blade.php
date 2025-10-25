{{-- SEO Meta Tags --}}
<title>{{ $title ?? config('app.name', 'Vidocu') }}</title>
<meta name="description" content="{{ $description ?? 'Chia sẻ tài liệu học tập miễn phí - Vidocu.com' }}">
<meta name="keywords" content="{{ $keywords ?? 'tài liệu học tập, chia sẻ tài liệu, học online, vidocu' }}">
<meta name="author" content="{{ $author ?? 'Vidocu' }}">

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $canonical ?? url()->current() }}">

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="{{ $title ?? config('app.name', 'Vidocu') }}">
<meta property="og:description" content="{{ $description ?? 'Chia sẻ tài liệu học tập miễn phí - Vidocu.com' }}">
<meta property="og:url" content="{{ $canonical ?? url()->current() }}">
<meta property="og:type" content="{{ $type ?? 'website' }}">
<meta property="og:site_name" content="Vidocu">
<meta property="og:locale" content="vi_VN">
<meta property="og:image" content="{{ $image ?? asset('vidocu.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="{{ $imageAlt ?? $title ?? 'Vidocu' }}">

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? config('app.name', 'Vidocu') }}">
<meta name="twitter:description" content="{{ $description ?? 'Chia sẻ tài liệu học tập miễn phí - Vidocu.com' }}">
<meta name="twitter:image" content="{{ $image ?? asset('vidocu.png') }}">
<meta name="twitter:image:alt" content="{{ $imageAlt ?? $title ?? 'Vidocu' }}">

{{-- Additional Meta Tags --}}
<meta name="robots" content="{{ $robots ?? 'index, follow' }}">
<meta name="googlebot" content="{{ $googlebot ?? 'index, follow' }}">
<meta name="language" content="Vietnamese">

{{-- Structured Data (JSON-LD) --}}
@isset($jsonLd)
<script type="application/ld+json">
{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endisset
