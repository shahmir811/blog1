<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;
use Session;

class TagController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        //Grab All the Tags first

        $tags = Tag::all();

        return view('tags.index')->with('tags',$tags);
    }


    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
            'name' => 'required|max:255'
            ]);

        $tags = new Tag;

        $tags->name = $request->name;

        $tags->save();

        Session::flash('success', 'New Tag Created Successfully');


        return redirect()->route('tags.index');
    }


    public function show($id)
    {
        $tag = Tag::find($id);
        return view('tags.show')->with('tag',$tag);
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('tags.edit')->with('tag', $tag);
    }


    public function update(Request $request, $id)
    {
        $tag = Tag::find($id);

        $this->validate($request, ['name' => 'required|max:255']);

        $tag->name = $request->input('name');
        $tag->save();

        Session::flash('success', 'Tag is Successfully updated !!!');

        return redirect() -> route('tags.show', $tag->id);

    }


    public function destroy($id)
    {
        $tag = Tag::find($id);
        $tag->posts()->detach();

        $tag->delete();

        Session::flash('success', 'Tag is Successfully deleted !!!');

        return redirect() -> route('tags.index');
    }
}
