@extends('main')

@section('title', ' | Login')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			
			{!! Form::open() !!}

			{{ Form::label('email', 'Email:') }}
			{{ Form::email('email', null, ['class' => 'form-control']) }}

			{{ Form::label('password', 'Password:') }}
			{{ Form::password('password', ['class' => 'form-control']) }}

			<br> <!-- LINE Breaker -->
			{{ Form::label('remember', 'Remember Me') }}
			{{ Form::checkbox('remember') }}

			<br> <!-- LINE Breaker -->
			{{ Form::submit('Login', ['class' => 'btn btn-primary btn-lg btn-block' ]) }}	


			{!! Form::close() !!}
		</div>

	</div>

@stop
