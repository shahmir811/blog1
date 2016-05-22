<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

class BlogController extends Controller
{

    public function getIndex(){
    	$post = Post::paginate(10);

    	return view('blog.index')->with('posts',$post);	    	
    }

    public function getSingle($slug){
    	
    	//Fetch slug from the DB
    	$post = Post::where('slug','=',$slug)->first();

    	//return view and pass the slug
    	return view('blog.single')->with('post',$post);
    }

}
