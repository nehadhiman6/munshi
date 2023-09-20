<header class="app-header top-bar">
    <!-- begin navbar -->
    <nav class="navbar navbar-expand-md">
       <div class="navbar-header d-flex align-items-center">
        <a href="javascript:void:(0)" class="mobile-toggle"><i class="fe fe-menu"></i></a>
            <a class="navbar-brand" href="{{ url('/')}}">
             <img src="{{asset('assets/img/munshi-logo.png')}}" class="img-fluid logo-desktop" alt="logo" />
             {{-- <b class="logo-desktop">
             <span>[</span>Munshi<span>]</span>
             </b> --}}
             <b class="logo-mobile">
             <span>[</span>M<span>]</span>
             </b>
             <!--<span class="img-fluid logo-mobile">[<span>bt</span>]</span>-->
             <!--<img src="assets/img/logo-icon.png" class="img-fluid logo-mobile" alt="logo" />-->
          </a>
       </div>
       <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
       <i class="fe fe-menu"></i>
       </button>
       <!-- end navbar-header -->
       <!-- begin navigation -->
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="navigation d-flex">
             <ul class="navbar-nav nav-left">
                <!-- begin navbar-header -->
                <li class="nav-item iw-bd-right iw-bd-left iwj-sidebar-toggle-btn ">
                   <a href="javascript:void(0)" class="nav-link sidebar-toggle main-header-menu-icon">
                   <span></span>
                   </a>
                </li>

                {{-- <li class="nav-item d-md-flex">
                    <a class="nav-link" href="{{ url('add-course')}}"><span class="badge bg-success-400 ml-md-auto mr-md-3">Add Course</span></a>
                </li> --}}
             </ul>
             @yield('submenu')

             <ul class="navbar-nav nav-right ml-auto">

                <li class="nav-item iw-bd-right">
                   <a class="nav-link search" href="javascript:void(0)">
                   <i class="fe fe-search"></i>
                   </a>
                   <div class="search-wrapper">
                      <div class="close-btn">
                         <i class="fe fe-x"></i>
                      </div>
                      <div class="search-content">
                         <form>
                            <div class="form-group">
                               <i class="fe fe-search magnifier"></i>
                               <input type="text" class="form-control autocomplete" placeholder="Search Here" id="autocomplete-ajax" autofocus="autofocus">
                            </div>
                         </form>
                      </div>
                   </div>
                </li>

                <li class="nav-item d-md-flex">
                   <a class="nav-link icon full-screen-link"> <i class="fe fe-maximize fullscreen-button"></i> </a>
                </li>
                <li class="nav-item dropdown user-profile iw-bd-right">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle " id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    @if(auth() && auth()->user() && auth()->user()->profile &&  auth()->user()->profile->attachment_id > 0)
                        <img src="{{ url('user-attachment') .'/'.auth()->user()->profile->attachment_id}}" alt="avtar-img" onError="this.onerror=null;this.src='images/user.png';" >
                    @else
                        <img src="{{ url('/assets/img/avatar.jpg')}}" alt="avtar-img">
                    @endif
                    </a>
                    <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                      <div class="main-profile-menu">
                        <div class="header-navheading">
                            @if(auth()->user())
                            <h6 class="main-notification-title">{{auth()->user()->name}}</h6>
                                <p class="main-notification-text">{{auth()->user()->name }}</p>
                            </div>
                            @endif
                            {{-- <a class="dropdown-item border-top" href="{{ url('user-profile')}}">
                                <i class="fe fe-user"></i> My Profile
                            </a> --}}
                            <a class="dropdown-item" href="{{ url('reset-password')}}" >
                                <i class="fe fe-settings"></i> Reset  Password
                            </a>
                            <a href="{{ route('logout') }}"  class="dropdown-item"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  href="signin.html">
                                <i class="fe fe-power"></i> Sign Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                   </div>
                </li>
             </ul>
          </div>
       </div>
       <!-- end navigation -->
    </nav>
    <!-- end navbar -->
 </header>
