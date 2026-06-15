@extends('layouts.app')

@section('title', $item->name)

@section('content')
    <section class="stack">
        <article class="detail-layout">
            <div class="detail-media">
                @if ($item->getFirstImageUrl())
                    <a class="media-link" href="{{ $item->getFirstImageUrl() }}" target="_blank" rel="noopener">
                        <img class="card-media" src="{{ $item->getFirstImageUrl() }}" alt="{{ $item->name }}">
                    </a>
                @else
                    <div class="image-placeholder">No Image</div>
                @endif
            </div>

            <div class="card stack">
                <div>
                    <h1>{{ $item->name }}</h1>
                    <p class="muted">{{ $item->description }}</p>
                </div>

                @if ($item->categories->isNotEmpty())
                    <div class="pill-list">
                        @foreach ($item->categories as $category)
                            <a class="pill" href="{{ route('categories.show', $category->fullPath()) }}">{{ $category->translate('en')?->name ?? $category->slug }}</a>
                        @endforeach
                    </div>
                @endif

                <div>
                    <div class="price">{{ $item->price }} EGP</div>
                    <p class="stock">{{ $item->stock }} in stock</p>
                </div>

                <div class="actions">
                    <a class="button secondary" href="{{ route('products.index') }}">Back to Products</a>
                    @auth
                        <form method="POST" action="{{ route('orders.store') }}">
                            @csrf
                            <input type="hidden" name="items[0][item_id]" value="{{ $item->id }}">
                            <input type="hidden" name="items[0][quantity]" value="1">
                            <button class="button" type="submit">Order Now</button>
                        </form>
                    @else
                        <a class="button" href="{{ route('login') }}">Log in to Order</a>
                    @endauth
                </div>
            </div>
        </article>
    </section>
@endsection
