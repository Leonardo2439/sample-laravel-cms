<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{

    public function index() {

        $posts = auth()->user()->posts()->paginate(5);
        // $posts = Post::all();

        return view('admin.posts.index', ['posts'=>$posts]);
    }

    public function show(Post $post) {


        return view('blog-post', ['post' => $post]);
    }

    public function create() {

        $this->authorize('create', Post::class);         

        return view('admin.posts.create');
    }

    public function store() {

        $this->authorize('create', Post::class); 

        $inputs = request()->validate([
            'title' => 'required|min:8|max:255',
            'post_image' => 'mimes:jpeg,png',
            'body' => 'required',
        ]);

        if(request('post_image')) {
            // $inputs['post_image'] = request('post_image')->store('images');
            $inputs['post_image'] ='images/' . time() . '.' . request()->post_image->extension();       
            request()->post_image->move(public_path('images'),$inputs['post_image']);                   
        }

        auth()->user()->posts()->create($inputs);

        session()->flash('post-created-message', 'Post '.$inputs['title'].' was created.');

        return redirect()->route('post.index');
    }

    public function destroy(Post $post) {

        // $this->authorize('delete', $post);

        $post->delete();

        Session::flash('message', 'Post was Deleted');

        return back();

    }

    public function edit(Post $post) {

        $this->authorize('view', $post);
        // if (auth()->user()->can('view', $post)) {
        //     # code...
        // }

        return view('admin.posts.edit', ['post'=>$post]);

    }

    public function update(Post $post) {

        $inputs = request()->validate([
            'title' => 'required|min:8|max:255',
            'post_image' => 'mimes:jpeg,png',
            'body' => 'required',
        ]);


        if(request('post_image')) {
            // $inputs['post_image'] = request('post_image')->store('images');
            $inputs['post_image'] ='images/' . time() . '.' . request()->post_image->extension();       
            request()->post_image->move(public_path('images'),$inputs['post_image']);  
            
            $post->post_image = $inputs['post_image'];
        }

        $post->title = $inputs['title'];
        $post->body = $inputs['body'];
        
        session()->flash('post-updated-message', 'Post '.$inputs['title'].' was updated.');

        $this->authorize('update', $post);

        $post->save();

        return redirect()->route('post.index');


    }

}
