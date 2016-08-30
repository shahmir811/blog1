<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Tag;
use App\Category;
use Session;
use Purifier;
use Image;
use Storage;


class PostController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        //Create a Varaible and store all the blog posts that are in the database
        $posts=Post::orderBy('id','desc')->paginate(10);

        //return a view and pass the above variable
        return view('posts.index')->with ('posts',$posts);

    }

    public function create()
    {
        $categories = Category::all();

        $tags = Tag::all();

        return view ('posts.create')->with('categories', $categories)->with('tags', $tags);
     }


    public function store(Request $request)
    {
        //validate the Data
      $this->validate($request, array(
        'title'        => 'required|max:255',
        'slug'         => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
        'category_id'  => 'required|integer',
        'body'         => 'required',
        'featured_image' => 'sometimes|image'
        ));

      //Store Data in the Database
      $post = new Post;

      $post->title       = $request->title;
      $post->slug        = $request->slug;
      $post->category_id = $request->category_id;
      $post->body        = Purifier::clean($request->body);

      //Save Image in Public/images folder
      if($request->hasFile('featured_image'))
      {
        $image    = $request->file('featured_image'); //Grab the image file
        $filename = time() . '.' . $image->getClientOriginalExtension(); //it will store the file as timestamp + imagename + fileextention

        $location = public_path('images/'. $filename); //Store in the public/images folder
        Image::make($image)->resize(800,400)->save($location);

        $post->image = $filename;

      }

      $post->save();

        if(isset($request->tags)){
            $post->tags()->sync($request->tags);
        }else{
            $post->tags()->sync([]);
        }

      //Redirect to another page

      Session::flash('success','The Blog Post was Succesffuly saved !!!');

      return redirect()->route('posts.show', $post->id);
    }

 
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with ('post',$post);
    }


    public function edit($id)
    {
        //Find post in the DB and store it in the variable
        $post = Post::find($id); //Find the individual Post1
        $categories = Category::all();
        $cats = [];

        foreach ($categories as $category){
            $cats[$category->id]= $category->name;
        }

        $tags = Tag::lists('name', 'id'); //replaces the below code
        
        /*
        $tags = Tag::all();
        $tags2 = [];

        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;
        }
        */
        //Return a view and pass the variable
        return view('posts.edit')->with('post',$post)->with('categories',$cats)->with('tags', $tags);

    }


    public function update(Request $request, $id)
    {
        $post=Post::find($id);

        //Validate the New Updated Data
        $this->validate($request,[
            'title'         =>'required | max:255', 
            'slug'          => "required|alpha_dash|min:5|max:255|unique:posts,slug,$id", 
            'category_id'   => 'required|integer',
            'body'          => 'required',
            'featured_image'=> 'sometimes|image' 
            ]);


        //Store Data in the DB

        $post = Post::find($id);

        $post->title        = $request->input('title');
        $post->slug         = $request->input('slug');
        $post->category_id  = $request->input('category_id');
        $post->body         = Purifier::clean($request->input('body'));

        if($request->hasFile('featured_image')){
            //Add new Photo
            $image    = $request->file('featured_image'); //Grab the image file
            $filename = time() . '.' . $image->getClientOriginalExtension(); //it will store the file as timestamp + imagename + fileextention

            $location = public_path('images/'. $filename); //Store in the public/images folder
            Image::make($image)->resize(800,400)->save($location);

            $oldFileName = $post->image; //Grab the old File Name

            //Update Database
            $post->image = $filename; //Stores the Update FileName in the Database

            //Delete old photo
            Storage::delete($oldFileName);

        }

        $post->save();

        if(isset($request->tags)){
            $post->tags()->sync($request->tags);
        }else{
            $post->tags()->sync([]);
        }


        //Set Flash Data with Success Message
        Session::flash('success','Post is successfully updated');

        //Redirect with Flash Data to posts.show
        return redirect()->route('posts.show',$post->id);

    }


    public function destroy($id)
    {
        $post = Post::find($id);
        $post->tags()->detach();
        Store::delete($post->image);        

        $post->delete();

        Session::flash('success', 'The Post is successfully deleted');

        return redirect()->route('posts.index');
    }
}
