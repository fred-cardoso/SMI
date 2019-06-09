<header class="main-header">
    <!-- Logo -->
    <a href="{{route('home')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>M</b>SH</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Media</b>SHARE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @auth
                    <li class="dropdown">
                        @if(auth()->user()->lang == 'pt')
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="flag-icon flag-icon-pt"></span></a>
                            <ul class="dropdown-menu" style="min-width: 20px; right:0; left:auto;">
                                <li>
                                    <a href="{{route('locale', 'en')}}">
                                        <span class="flag-icon flag-icon-gb"></span></a>
                                </li>
                            </ul>
                        @else
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="flag-icon flag-icon-gb"></span></a>
                            <ul class="dropdown-menu" style="min-width: 20px; right:0; left:auto;">
                                <li>
                                    <a href="{{route('locale', 'pt')}}">
                                        <span class="flag-icon flag-icon-pt"></span></a>
                                </li>
                            </ul>
                        @endif
                    </li>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                            <span class="hidden-xs">{{auth()->user()->name}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <p>
                                    {{auth()->user()->name}}
                                    <small>@lang('outlayout.member') {{ \Carbon\Carbon::parse(auth()->user()->created_at)->format('d/m/Y')}}
                                    </small>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{route('profile')}}"
                                       class="btn btn-default btn-flat">@lang('user.profile')</a>
                                </div>
                                <div class="pull-right">
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-default btn-flat">@lang('auth.logout')</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endauth
                @guest
                    <li>
                        <a href="{{route('login')}}">
                            <i class="fa fa-user"></i>
                            <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                            <span class="hidden-xs">@lang('auth.begin_session')</span>
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</header>