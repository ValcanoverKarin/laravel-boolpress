@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">Modifica post</a>
        </div>
        <h1>{{ $post->title }}</h1>

        <div class="mt-2 mb-2"><strong>Slug:</strong> {{ $post->slug }}</div>

        @if($post_category)
            <div class="mt-2 mb-2">
                <strong>Categoria:</strong> {{ $post_category->name }}
            </div>
        @endif

        @if($post_tags->isNotEmpty())
        <div class="mt-2 mb-2">
            <strong>Tags:</strong>
            @foreach($post_tags as $tag)
                <span>{{ $tag->name }}{{ $loop->last ? '' : ', ' }}</span>
            @endforeach  
        </div>
        @endif

        <p>{{ $post->content }}</p>

    </div>
@endsection