@extends('main')

@section('title', '| All Posts')


@section('content')

	<div class="row">
		<div class="col-md-10"> 
			<h1> All Posts </h1>
		</div>

		<div class="col-md-2">
			<a href=" {{ route('posts.create') }} ", class="btn btn-primary btn-lg btn-block btn-h1-spacing"> Create New Post </a>
		</div>

		<div class="col-md-12">
			<hr>
		</div>

	</div> <!-- End of the ROW -->

	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<thead> <!-- Table Heading (like Column Names) -->
					<th>#</th> <!-- ID Column -->
					<th>Title</th> 
					<th>Body</th>
					<th>Created At</th>
					<th></th>
				</thead>

				<tbody> <!-- Table Body, like rows  -->
					
					@foreach($posts as $post)
						<tr>						   <!-- Table Row -->
							<th> {{ $post->id }} </th> <!-- The output of the ID Column will be bolded -->
							<td> {{ $post->title}} </td>
							<td> {{ substr(strip_tags($post->body), 0, 30) }}{{ strlen(strip_tags($post->body)) > 30 ? "..." : "" }} </td>
							<td> {{ date('M j, Y', strtotime($post->created_at)) }} </td>
							<td> <a href="{{ route('posts.show', $post->id) }} " class="btn btn-default btn-sm">View</a> <a href=" {{ route('posts.edit', $post->id) }}" class="btn btn-default btn-sm">Edit</a> </td>
							
						</tr>

					@endforeach

				</tbody>

			</table>
			
			<div class="text-center">
				{!! $posts->links(); !!}
			</div>

		</div>


	</div>
	








@stop


