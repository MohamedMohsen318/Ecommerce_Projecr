@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    @php
        $isArabic = app()->getLocale() === 'ar';
        $t = fn (string $en, string $ar) => $isArabic ? $ar : $en;
    @endphp

    <section class="stack">
        <div class="page-head">
            <div>
                <h1>{{ $t('Categories', 'الأقسام') }}</h1>
                <p class="muted">{{ $t('Start with the right category, then move smoothly into the products.', 'ابدأ من القسم المناسب ثم انتقل بسهولة إلى المنتجات.') }}</p>
            </div>
            <a class="button" href="{{ route('products.index') }}">{{ $t('All Products', 'كل المنتجات') }}</a>
        </div>

        <div class="grid">
            @forelse ($categories as $category)
                <article class="card catalog-card">
                    @if ($category->getFirstImageUrl())
                        <a class="media-link" href="{{ $category->getFirstImageUrl() }}" target="_blank" rel="noopener">
                            <img class="card-media" src="{{ $category->getFirstImageUrl() }}" alt="{{ $category->translate(app()->getLocale())?->name ?? $category->translate('en')?->name ?? $category->slug }}">
                        </a>
                    @else
                        <div class="image-placeholder">{{ $t('No Image', 'لا توجد صورة') }}</div>
                    @endif
                    <div class="catalog-body">
                        <div>
                            <h2 class="catalog-title">{{ $category->translate(app()->getLocale())?->name ?? $category->translate('en')?->name ?? $category->slug }}</h2>
                            <p class="muted catalog-description">{{ \Illuminate\Support\Str::limit($category->translate(app()->getLocale())?->description ?? $category->translate('en')?->description, 95) }}</p>
                        </div>
                        <div class="catalog-footer">
                            <span class="pill">{{ $t($category->children->count() . ' subcategories', $category->children->count() . ' أقسام فرعية') }}</span>
                            <a class="button secondary" href="{{ route('categories.show', $category->fullPath()) }}">{{ $t('View', 'عرض') }}</a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="muted">{{ $t('No categories are available right now.', 'لا توجد أقسام متاحة حالياً.') }}</p>
            @endforelse
        </div>
    </section>
@endsection
