<?php 

namespace App\Http\Controllers;

use App\Post;

Class PagesController extends Controller
{
	public function getIndex(){

		$posts=Post::orderBy('created_at','desc')->limit(4)->get();

		return view('pages.welcome')->with('posts',$posts);
	}

	public function getAbout(){

		$first = 'Shahmir';
		$last = 'Jadoon';

		$full = $first." ".$last;
		$email = 'shahmirkj@gmail.com';

		$data = [];
		$data['email'] = $email;
		$data['fullname'] = $full;

		return view ('pages.about')->withData($data);

	}

	public function getContact(){
		return view ('pages.contact');

	}

}
