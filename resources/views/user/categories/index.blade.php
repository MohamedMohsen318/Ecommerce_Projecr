@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <section class="stack">
        <div class="page-head">
            <div>
                <h1>Categories</h1>
                <p class="muted">Start with the right category, then move smoothly into the products.</p>
            </div>
            <a class="button" href="{{ route('products.index') }}">All Products</a>
        </div>

        <div class="grid">
            @forelse ($categories as $category)
                <article class="card catalog-card">
                    @if ($category->getFirstImageUrl())
                        <a class="media-link" href="{{ $category->getFirstImageUrl() }}" target="_blank" rel="noopener">
                            <img class="card-media" src="{{ $category->getFirstImageUrl() }}" alt="{{ $category->translate('en')?->name ?? $category->slug }}">
                        </a>
                    @else
                        <div class="image-placeholder">No Image</div>
                    @endif
                    <div class="catalog-body">
                        <div>
                            <h2 class="catalog-title">{{ $category->translate('en')?->name ?? $category->slug }}</h2>
                            <p class="muted catalog-description">{{ \Illuminate\Support\Str::limit($category->translate('en')?->description, 95) }}</p>
                        </div>
                        <div class="catalog-footer">
                            <span class="pill">{{ $category->children->count() }} subcategories</span>
                            <a class="button secondary" href="{{ route('categories.show', $category->fullPath()) }}">View</a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="muted">No categories are available right now.</p>
            @endforelse
        </div>
    </section>
@endsection
