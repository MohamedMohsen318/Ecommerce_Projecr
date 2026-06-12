@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <section class="stack">
        <h1>Categories</h1>
        <div class="grid">
            @forelse ($categories as $category)
                <article class="card">
                    <h2>{{ $category->translate('en')?->name ?? $category->slug }}</h2>
                    <p class="muted">{{ $category->translate('en')?->description }}</p>
                    <a href="{{ route('categories.show', $category->slug) }}">View category</a>
                </article>
            @empty
                <p class="muted">No categories available.</p>
            @endforelse
        </div>
    </section>
@endsection
