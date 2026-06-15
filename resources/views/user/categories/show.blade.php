@extends('layouts.app')

@section('title', $category->translate('en')?->name ?? $category->slug)

@section('content')
    <section class="stack">
        <div class="page-head">
            <div>
                <h1>{{ $category->translate('en')?->name ?? $category->slug }}</h1>
                <p class="muted">{{ $category->translate('en')?->description }}</p>
            </div>
            <a class="button secondary" href="{{ route('categories.index') }}">Back to Categories</a>
        </div>

        <section class="detail-layout">
            <div class="detail-media">
                @if ($category->getFirstImageUrl())
                    <a class="media-link" href="{{ $category->getFirstImageUrl() }}" target="_blank" rel="noopener">
                        <img class="card-media" src="{{ $category->getFirstImageUrl() }}" alt="{{ $category->translate('en')?->name ?? $category->slug }}">
                    </a>
                @else
                    <div class="image-placeholder">No Image</div>
                @endif
            </div>

            <div class="detail-panel">
                <h2 class="section-title">Subcategories</h2>
                <div class="grid">
                    @forelse ($children as $child)
                        <article class="card catalog-card">
                            @if ($child->getFirstImageUrl())
                                <a class="media-link" href="{{ $child->getFirstImageUrl() }}" target="_blank" rel="noopener">
                                    <img class="card-media" src="{{ $child->getFirstImageUrl() }}" alt="{{ $child->translate('en')?->name ?? $child->slug }}">
                                </a>
                            @else
                                <div class="image-placeholder">No Image</div>
                            @endif
                            <div class="catalog-body">
                                <h2 class="catalog-title">{{ $child->translate('en')?->name ?? $child->slug }}</h2>
                                <a class="button secondary" href="{{ route('categories.show', $child->fullPath()) }}">View</a>
                            </div>
                        </article>
                    @empty
                        <p class="muted">No subcategories are available.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <div class="page-head">
            <div>
                <h2 class="section-title">Products</h2>
                <p class="muted">Products assigned to this category.</p>
            </div>
        </div>

        <div class="grid">
            @forelse ($products as $item)
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
                        <div class="catalog-footer">
                            <span class="price">{{ $item->price }} EGP</span>
                            <a class="button" href="{{ route('products.show', $item) }}">View</a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="muted">No products are assigned to this category yet.</p>
            @endforelse
        </div>

        {{ $products->links() }}
    </section>
@endsection
