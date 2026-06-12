@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <section class="card">
        <h1>Admin Dashboard</h1>
        <p class="muted">Manage store content from here.</p>
        <p><a class="button" href="{{ route('admin.categories.index') }}">Manage categories</a></p>
    </section>
@endsection
