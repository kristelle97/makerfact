<?php

namespace App\Http\Controllers;

use App\Http\Requests\LikePostRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Policies\PostPolicy;
use App\Rules\SafeUrl;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts = Post::whereDate('created_at', Carbon::today())->get();
        foreach ($posts as $post){
            $post->username = User::find($post->user_id)->name;
        }

        return view('dashboard')->with([
            'posts' => $posts->sortByDesc('likes'),
        ]);
    }

    public function all(){
        $posts = Post::all();
        foreach ($posts as $post){
            $post->username = User::find($post->user_id)->name;
        }

        return view('past_dashboard')->with([
            'posts' => $posts->sortByDesc('likes'),
        ]);
    }

    public function showPost(int $postID){
        $post = Post::findOrFail($postID);
        $post->username = User::find($post->user_id)->name;

        return view('posts.post')->with([
            'post' => $post,
        ]);
    }

    public function create(){
        return view('posts/new_post_form');
    }

    public function store(StorePostRequest $request){
        Auth::user()->posts()->create(
            [
                'title'=>$request->title,
                'description'=>$request->description,
                'url'=>$request->url,
                'likes'=>0,
            ],
        );

        return redirect()->back()->with('message', 'Post created successfully!');
    }

    public function like(Request $request, $post_id)
    {
        $user = $request->user();

        $post = Post::findOrFail($post_id);

        $like = Like::where('user_id', $user->id)
            ->where('post_id', $post_id)
            ->first();

        if ($post->likes!=0) {
            $like->delete();
            $post->decrement('likes');
            return redirect()->back();
        }

        $like = new Like([
            'user_id' => $user->id,
            'post_id' => $post_id,
        ]);
        $like->save();
        $post->increment('likes');

        return redirect()->back();
    }
}
