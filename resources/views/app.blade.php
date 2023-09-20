<!DOCTYPE html>
<html lang="en">
    @include('layouts.head')
    {{-- @if(userPreferencesSidebar() == 'open') --}}
    <body>

    {{-- @else --}}
    {{-- <body class="sidebar-mini"> --}}
    {{-- @endif --}}
      <!-- begin app -->
      <main class="app">
         <!-- begin app-wrap -->
         <div class="app-wrap">
            <!-- begin app-header -->
            @include('layouts.header')
            <!-- begin app-header -->
            <!-- begin app-container -->
            <div class="app-container">

               <!-- sidebar -->
               @include('layouts.sidebar')
               <!-- sidebar -->
               <!-- begin app-main -->
               <div class="app-main" id="main">

                  <!-- begin container-fluid -->
                  <div class="container-fluid">

                    @include('flash::message')
                    @if(session()->has('message'))
                    <ul class="alert alert-warning">
                        {{ session()->get('message') }}
                    </ul>
                    @endif
                    @if(session()->has('success'))
                        <ul class="alert alert-success">
                            {{ session()->get('success') }}
                        </ul>
                    @endif
                    @if(session()->has('error'))
                        <ul class="alert alert-danger">
                            {{ session()->get('error') }}
                        </ul>
                    @endif
                    @if (count($errors) > 0)
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                     @yield('content')
                  </div>
                  <!--end app-container-->
               </div>
               <!-- end app-main -->
            </div>
            <!-- end app-container -->
            <!--right sidebar-->
            {{-- @include('layouts.sidebar-right') --}}
            <!--right sidebar-->
            <!-- begin footer -->
            <footer class="footer text-center">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        {{-- <span>Copyright © 2019 <a href="#">{{ config('lms.company') }}</a></span> --}}
                     </div>
                  </div>
               </div>
            </footer>
            <!-- end footer -->
         </div>
         <!-- end app-wrap -->
      </main>
        {{-- login modal --}}
        <div id ="iw-content-bottom">
            {{-- <login-modal
                base_url="{{ url('/') }}">
            </login-modal> --}}
        </div>
        <!-- end app -->
      <!-- begin app -->
      @include('layouts.scripts')
      <!-- vue components -->
      @stack('vue-components')
      <!-- scripts in pages -->
      @yield('script')
   </body>
</html>
