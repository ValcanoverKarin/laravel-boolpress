@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Categoria ricette: {{ $category->name }}</h1>


        <div class="row">
            @foreach ($related_posts as $post)
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                      <h5 class="card-title"> {{ $post->title }} </h5>
                      <a href="{{ route('blog-page', [
                          'slug' => $post->slug
                      ]) }}" class="btn btn-primary">Vai alla Ricetta</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection