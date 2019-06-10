<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- search form -->

        <form action='{{route('search')}}' method="post" class="sidebar-form" oninput="ajax_search()">
            @csrf

            <div class="input-group">
                <input type="text" id='search' name="q" class="form-control" placeholder="@lang('common.search')"
                       required>
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>

              </span>
            </div>
            <div class="dropdown" id="searchBox"></div>

        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">

            <li class="header">@lang('outlayout.main_nav')</li>

            <li><a href="/"><i class="fa fa-home"></i> <span>@lang('categorias.home_page')</span></a></li>
            <li class="{{ request()->is('uploads/*') ||Request::routeIs('upload') || Request::routeIs('upload.bulk')|| Request::routeIs("uploads") ? 'active treeview' : 'treeview' }}">
                <a href="#">
                    <i class="fa  fa-television"></i> <span>@lang('conteudos.content')</span>
                    <span class="pull-right-container">
  <i class="fa fa-angle-left pull-right"></i>
</span>

                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::routeIs('uploads') ? 'active' : '' }}"><a
                                href="{{route('uploads')}}"><i
                                    class="fa fa-circle-o"></i>@lang('conteudos.list_content')</a></li>
                    @role('simpatizante')
                    <li class="{{ Request::routeIs('upload') ? 'active' : '' }}"><a
                                href="{{route('upload')}}"><i
                                    class="fa fa-circle-o"></i>@lang('conteudos.upload_content')</a>
                    </li>

                    <li class="{{ Request::routeIs('upload.bulk') ? 'active' : '' }}"><a
                                href="{{route('upload.bulk')}}"><i
                                    class="fa fa-circle-o"></i>@lang('contents.mass_content')</a>
                    </li>
                    @endrole

                </ul>
            </li>

            <li class="{{ request()->is('users/*') || Request::routeIs('users') ? 'active treeview' : 'treeview' }}">
                <a href="#">
                    <i class="fa fa-user"></i> <span id="change_me">@lang('categorias.users')</span>
                    <span class="pull-right-container">
  <i class="fa fa-angle-left pull-right"></i>
</span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::routeIs('users') ? 'active' : '' }}"><a href="{{route('users')}}"><i
                                    class="fa fa-circle-o"></i>@lang('user.list')</a></li>
                    @role('admin')
                    <li class="{{ Request::routeIs('users.create') ? 'active' : '' }}"><a
                                href="{{route('users.create')}}"><i class="fa fa-circle-o"></i>@lang('user.create')</a>
                    </li>
                    @endrole

                </ul>


            </li>

            <li class="{{request()->is('categorias/*') || request()->is('categorias') ? 'active treeview' : 'treeview' }}">
                <a href="#">
                    <i class="fa fa-book"></i> <span>@lang('categorias.categories')</span>
                    <span class="pull-right-container">
  <i class="fa fa-angle-left pull-right"></i>
</span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::routeIs('categorias') ? 'active' : '' }}"><a
                                href="{{route('categorias')}}"><i
                                    class="fa fa-circle-o"></i>@lang('categorias.list_cat') </a></li>
                    @auth
                        @if(auth()->user()->categoria()->count())
                            <li class="treeview">
                                <a href="#"><i class="fa fa-circle-o"></i>@lang('categorias.subed_cat')
                                    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
                                </a>

                                <ul class="treeview-menu">
                                    <?php
                                    $user_id = auth()->user()->id;
                                    $categoria = auth()->user()->categoria();
                                    $counter = $categoria->count();
                                    $catFinder = 1;
                                    for ($x = 0; $x < $counter;) {
                                        $categoria = auth()->user()->categoria();
                                        $putCategoria = $categoria->where('categoria_id', $catFinder)->where('user_id', $user_id)->get();
                                        if ($putCategoria->isEmpty()) {
                                        } else {
                                            $cat_name = $putCategoria->first()->nome;
                                            $cat_id = $putCategoria->first()->id;
                                            echo '<li><a href="/categorias/' . $cat_id . '"><i class="fa fa-book"></i> <span>' . $cat_name . '</span></a></li>';
                                            $x++;
                                        }
                                        $catFinder += 1;
                                    }
                                    ?>
                                </ul>

                            </li>
                        @endif
                        @role('simpatizante')
                        <li class="{{ Request::routeIs('cat.create') ? 'active' : '' }}"><a
                                    href="{{route('cat.create')}}"><i
                                        class="fa fa-circle-o"></i>@lang('categorias.create_cat')</a>
                        </li>
                        @endrole
                    @endauth
                </ul>

            </li>
            @role('admin')
            <li class="header">@lang('outlayout.admin')</li>

            <li class="{{Request::routeIs('config') ? 'active' : '' }}"><a href="{{route('config')}}"><i
                            class="fa fa-circle-o text-red"></i>
                    <span>@lang('common.config_system')</span></a></li>
            <li class="{{Request::routeIs('users.banned') ? 'active' : '' }}"><a href="{{route('users.banned')}}"><i
                            class="fa fa-circle-o text-aqua"></i><span>@lang('outlayout.ban')</span></a>
            </li>
            @endrole
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
