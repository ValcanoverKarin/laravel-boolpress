@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">Modifica post</a>
        </div>
        <h1>{{ $post->title }}</h1>

        <div class="mt-2 mb-2"><strong>Slug:</strong> {{ $post->slug }}</div>

        <p>{{ $post->content }}</p>

    </div>
@endsection