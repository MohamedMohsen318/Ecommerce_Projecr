@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
    <section class="stack">
        <div class="page-head">
            <h1>Manage Categories</h1>
            <a class="button" href="{{ route('admins.categories.create') }}">Add Category</a>
        </div>

        <div class="card">
            <table class="table">
                <thead>
                    <tr><th>Name</th><th>Slug</th><th>Products</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @if ($categories->isNotEmpty())
                        @include('admin.categories._category_rows', [
                            'categories' => $categories,
                            'level' => 0,
                        ])
                    @else
                        <tr><td colspan="5" class="muted">No categories yet.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>
@endsection
