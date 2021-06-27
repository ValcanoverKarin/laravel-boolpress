<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use Illuminate\Support\Str;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        
        $data = [
            'posts' => $posts
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        $data = [
            'categories' => $categories
        ];

        return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:65000',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $new_post_data = $request->all();

        //creao slug 
        $new_slug = Str::slug($new_post_data['title'], '-');
        $base_slug = $new_slug;
        //controlla che non esista un post con questo slug
        $post_with_existing_slug = Post::where('slug', '=', $new_slug)->first();
        $counter = 1;

        //se esiste tenta con altri slug
        while($post_with_existing_slug) {
            //Provo con un nuovo slug appendendo il counter
            $new_slug = $base_slug . '-' . $counter;
            $counter++;
            //se anche il nuovo slug esiste nel db il while continua
            $post_with_existing_slug = Post::where('slug', '=', $new_slug)->first();
        }
        //quando trova uno slug libero, popola il data da salvare
        $new_post_data['slug'] = $new_slug;

        $post = new Post();
        $post->fill($new_post_data);
        $post->save();

        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $data = [
            'post' => $post,
            'post_category' => $post->category,
            'post_tags' => $post->tags
        ];

        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();

        $data = [
            'post' => $post,
            'categories' => $categories
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|max:65000',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $modified_post_data = $request->all();

        $post = Post::findOrFail($id);
 
        //di default lo slug non dovrebbe essere cambiato a meno che cambi il titolo del post
        $modified_post_data['slug'] = $post->slug;

        //se il titolo cambia ricalcola lo slug
        if($modified_post_data['title'] != $post->title) {
            //slug
            $new_slug = Str::slug($modified_post_data['title'], '-');
            $base_slug = $new_slug;
            //controlla che non esista un post con questo slug
            $post_with_existing_slug = Post::where('slug', '=', $new_slug)->first();
            $counter = 1;

            //se esiste tenta con altri slug
            while($post_with_existing_slug) {
                //Provo con un nuovo slug appendendo il counter
                $new_slug = $base_slug . '-' . $counter;
                $counter++;
                //se anche il nuovo slug esiste nel db il while continua
                $post_with_existing_slug = Post::where('slug', '=', $new_slug)->first();
            }
            //quando trova uno slug libero, popola il data da salvare
            $modified_post_data['slug'] = $new_slug;
        }

        $post->update($modified_post_data);
        
        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
