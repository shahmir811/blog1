<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comment;
use App\Post;
use Session;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'store']);
    }



    public function store(Request $request, $post_id)
    {
        
        $this->validate($request,[
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'comment' => 'required|min:5|max:2000'
            ]);

        $post = Post::find($post_id);

        $comment = new Comment();

        $comment -> name    = $request-> name;
        $comment -> email   = $request-> email;
        $comment -> comment = $request -> comment;
        $comment -> approved = true;
        
        //Below Commented line not working, no idea why ???
        //$comment -> post() -> associate('post');

        $comment -> post_id = $post->id;

        $comment -> save();

        Session::flash('success', 'Comment was added');

        return redirect() -> route('blog.single', [$post->slug]);
    }

    public function edit($id)
    {
        $comment = Comment::find($id);
        return view('comments.edit')->with('comment',$comment);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required|min:5|max:2000'
            ]);

        $comment = Comment::find($id);

        $comment->comment = $request->comment;
        $comment->save();

        Session::flash('success', 'Comment Updated !!!');

        return redirect()-> route('posts.show', $comment->post->id);

    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        return view('comments.delete')->with('comment', $comment);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $post_id = $comment->post->id;

        $comment->delete();

        Session::flash('success', 'Comment Deleted');

        return redirect() -> route('posts.show', $post_id);
    }



}
