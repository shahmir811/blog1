@extends('main')

@section('title',' | Homepage')



@section('content')
      <div class="row">
        <div class="col-md-12">
          <div class="jumbotron">
            <h1>Welcome To my Blog Website !!!</h1>
            <p class="lead"> This is my test site. I am currently working on Laravel. So, its just a new Blog site. Hope you enjoy. Please read my popular posts </p>
            <p><a class="btn btn-primary btn-lg" href="#" role="button">Popular Posts</a></p>
          </div>
        </div>
      </div> <!--End of header.row -->

      <div class="row">
          <div class="col-md-8">

              @foreach($posts as $post)
                <div class="post">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ substr($post->body, 0, 150) }}{{ strlen($post->body) > 150 ? "..." : "" }}</p>
                    <a href="{{ url('blog/'.$post->slug) }}" class="btn btn-primary">Read More</a>
                </div>

                <hr>                


              @endforeach            

          </div>
          
          <div class="col-md-3 col-md-offset-1" >
            <h2>SideBar</h2>
          </div>

      </div>
@endsection
 
