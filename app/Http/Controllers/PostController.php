<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Category;
use  Session;

class PostController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Create a Varaible and store all the blog posts that are in the database
        $posts=Post::orderBy('id','desc')->paginate(10);

        //return a view and pass the above variable
        return view('posts.index')->with ('posts',$posts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view ('posts.create')->with('categories', $categories);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the Data
      $this->validate($request, array(
        'title'        => 'required|max:255',
        'slug'         => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
        'category_id'  => 'required|integer',
        'body'         => 'required'
        ));

      //Store Data in the Database
      $post = new Post;

      $post->title       = $request->title;
      $post->slug        = $request->slug;
      $post->category_id = $request->category_id;
      $post->body        = $request->body;

      $post->save();

      //Redirect to another page

      Session::flash('success','The Blog Post was Succesffuly saved !!!');

      return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with ('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Find post in the DB and store it in the variable
        $post = Post::find($id); //Find the individual Post1

        $categories = Category::all();
        $cats = [];

        foreach ($categories as $category){
            $cats[$category->id]= $category->name;
        }
        

        //Return a view and pass the variable
        return view('posts.edit')->with('post',$post)->with('categories',$cats);

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
        $post=Post::find($id);

        if ( $request->input('slug') == $post->slug ) {
            
             $this->validate($request,[
            'title'         =>'required | max:255',
            'category_id'   => 'required|integer', 
            'body'          => 'required'
            ]);

        }
        else{
        //Validate the New Updated Data
        $this->validate($request,[
            'title'         =>'required | max:255', 
            'slug'          => 'required|alpha_dash|min:5|max:255|unique:posts,slug', 
            'category_id'   => 'required|integer',
            'body'          => 'required'
            ]);
        }

        //Store Data in the DB

        $post = Post::find($id);

        $post->title        = $request->input('title');
        $post->slug         = $request->input('slug');
        $post->category_id  = $request->input('category_id');
        $post->body         = $request->input('body');

        $post->save();

        //Set Flash Data with Success Message
        Session::flash('success','Post is successfully updated');

        //Redirect with Flash Data to posts.show
        return redirect()->route('posts.show',$post->id);

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

        Session::flash('success', 'The Post is successfully deleted');

        return redirect()->route('posts.index');
    }
}
