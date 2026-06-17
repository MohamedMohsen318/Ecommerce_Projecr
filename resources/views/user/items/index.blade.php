@extends('layouts.app')

@section('title', 'Products')

@section('content')
    @php
        $isArabic = app()->getLocale() === 'ar';
        $t = fn (string $en, string $ar) => $isArabic ? $ar : $en;
    @endphp

    <section class="stack">
        <div class="page-head">
            <div>
                <h1>{{ $t('Products', 'المنتجات') }}</h1>
                <p class="muted">{{ $t('Available items connected to the store categories for easy browsing.', 'منتجات مرتبطة بالأقسام لتصفح أسهل وأوضح.') }}</p>
            </div>
            <a class="button secondary" href="{{ route('categories.index') }}">{{ $t('Browse Categories', 'تصفح الأقسام') }}</a>
        </div>

        <div class="grid">
            @forelse ($items as $item)
                <article class="card catalog-card">
                    @if ($item->getFirstImageUrl())
                        <a class="media-link" href="{{ $item->getFirstImageUrl() }}" target="_blank" rel="noopener">
                            <img class="card-media" src="{{ $item->getFirstImageUrl() }}" alt="{{ $item->name }}">
                        </a>
                    @else
                        <div class="image-placeholder">No Image</div>
                    @endif
                    <div class="catalog-body">
                        <div>
                            <h2 class="catalog-title">{{ $item->name }}</h2>
                            <p class="muted catalog-description">{{ \Illuminate\Support\Str::limit($item->description, 100) }}</p>
                        </div>
                        @if ($item->categories->isNotEmpty())
                            <div class="pill-list">
                                @foreach ($item->categories->take(2) as $category)
                                    <span class="pill">{{ $category->translate(app()->getLocale())?->name ?? $category->translate('en')?->name ?? $category->slug }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="catalog-footer">
                            <div>
                                <div class="price">{{ $item->price }} EGP</div>
                                <div class="stock">{{ $t($item->stock . ' in stock', $item->stock . ' متوفر') }}</div>
                            </div>
                            <a class="button" href="{{ route('products.show', $item) }}">{{ $t('View', 'عرض') }}</a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="muted">{{ $t('No products are available right now.', 'لا توجد منتجات متاحة حالياً.') }}</p>
            @endforelse
        </div>
    </section>
@endsection
