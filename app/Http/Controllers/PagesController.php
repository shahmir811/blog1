<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Requests;
use App\Post;
use Session;
use Mail;

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

	public function postContact(Request $request){
		$this->validate($request, [
			'email'   => 'required|email',
			'subject' => 'min:3',
			'message' => 'min:10'
		]);

		$data = [
			'email' 	  => $request->email,
			'subject' 	  => $request->subject,
			'bodyMessage' => $request->message
			];

		Mail::send('emails.contact', $data, function($message) use ($data){
			$message->from($data['email']);
			$message->to('shahmirkj@gmail.com');
			$message->subject($data['subject']);
		});

		Session::flash('success', 'Mail is send successfully');

		return redirect()-> route('home');
	}

}
