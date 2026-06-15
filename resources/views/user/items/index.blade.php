@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <section class="stack">
        <div class="page-head">
            <div>
                <h1>Products</h1>
                <p class="muted">Available items connected to the store categories for easy browsing.</p>
            </div>
            <a class="button secondary" href="{{ route('categories.index') }}">Browse Categories</a>
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
                                    <span class="pill">{{ $category->translate('en')?->name ?? $category->slug }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="catalog-footer">
                            <div>
                                <div class="price">{{ $item->price }} EGP</div>
                                <div class="stock">{{ $item->stock }} in stock</div>
                            </div>
                            <a class="button" href="{{ route('products.show', $item) }}">View</a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="muted">No products are available right now.</p>
            @endforelse
        </div>
    </section>
@endsection
