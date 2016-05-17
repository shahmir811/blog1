<?php 

namespace App\Http\Controllers;

Class PagesController extends Controller
{
	public function getIndex(){

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
