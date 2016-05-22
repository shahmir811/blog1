<!DOCTYPE html>
<html lang="en">
  
  <head>  
    @include ('partials._head')
  </head>
 
    <body>
   
      @include('partials._nav')
       
        <div class="container">
            @include('partials._messages')


            @yield('content')

            @include('partials._footer')

        </div> <!--End of Container (that is at the top of the site) -->

      @include('partials._javascript')

      @yield('scripts')
    </body>
</html>
