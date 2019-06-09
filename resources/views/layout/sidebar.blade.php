<style>
    .dropdown {
        position: absolute;
        display: block;
    }
    #searchBox{
        width:90%;
    }


    .dropdown-content {
        padding: 12px 16px;
        text-decoration: none;
        position: relative;
        display: block;
        z-index: 10;
        width: 100%;
        background: #374850;
    }
    #searchBox a:hover{
        background:#0a0a0a;
    }

</style><!-- Left side column. contains the logo and sidebar -->
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
            <li class="{{ request()->is('uploads/*') || request()->is('upload') || request()->is("uploads") ? 'active treeview' : 'treeview' }}">
                <a href="#">
                    <i class="fa  fa-television"></i> <span>@lang('conteudos.content')</span>
                    <span class="pull-right-container">
  <i class="fa fa-angle-left pull-right"></i>
</span>

                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->url() == route('uploads') ? 'active' : '' }}"><a
                                href="{{route('uploads')}}"><i
                                    class="fa fa-circle-o"></i>@lang('conteudos.list_content')</a></li>
                    @role('simpatizante')

                    <li class="{{ request()->url() == route('upload') ? 'active' : '' }}"><a
                                href="{{route('upload')}}"><i
                                    class="fa fa-circle-o"></i>@lang('conteudos.upload_content')</a>
                    </li>
                    @endrole

                </ul>
            </li>

            <li class="{{ request()->is('users/*') || request()->is('users') ? 'active treeview' : 'treeview' }}">
                <a href="#">
                    <i class="fa fa-user"></i> <span id="change_me">@lang('categorias.users')</span>
                    <span class="pull-right-container">
  <i class="fa fa-angle-left pull-right"></i>
</span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->url() == route('users') ? 'active' : '' }}"><a href="{{route('users')}}"><i
                                    class="fa fa-circle-o"></i>@lang('user.list')</a></li>
                    @role('admin')
                    <li class="{{ request()->url() == route('users.create') ? 'active' : '' }}"><a
                                href="{{route('users.create')}}"><i class="fa fa-circle-o"></i>@lang('user.create')</a>
                    </li>
                    @endrole

                </ul>


            </li>

            <li class="{{ request()->is('categorias/*') || request()->is('categorias') ? 'active treeview' : 'treeview' }}">
                <a href="#">
                    <i class="fa fa-book"></i> <span>@lang('categorias.categories')</span>
                    <span class="pull-right-container">
  <i class="fa fa-angle-left pull-right"></i>
</span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ request()->url() == route('categorias') ? 'active' : '' }}"><a
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
                        <li class="{{ request()->url() == route('cat.create') ? 'active' : '' }}"><a
                                    href="{{route('cat.create')}}"><i
                                        class="fa fa-circle-o"></i>@lang('categorias.create_cat')</a>
                        </li>
                        @endrole
                        @if(request()->is('categorias/'))
                            <li class="active"><a
                                        href="#"><i class="fa fa-book"></i>Ver com o fred</a>
                            </li>
                        @endif

                    @endauth
                </ul>

            </li>
            @role('admin')
            <li class="header">@lang('outlayout.admin')</li>

            <li class="{{request()->is('configurations/edit') ? 'active' : '' }}"><a href="{{route('config')}}"><i
                            class="fa fa-circle-o text-red"></i>
                    <span>@lang('common.config_system')</span></a></li>
            <li class="{{Request::routeIs('users.banned') ? 'active' : '' }}"><a href="{{route('users.banned')}}"><i
                            class="fa fa-circle-o text-aqua"></i><span>@lang('outlayout.ban')</span></a>
            </li>
            @endrole
            <!--
           <li class="treeview">
               <a href="#">
                   <i class="fa fa-files-o"></i>
                   <span>Layout Options</span>
                   <span class="pull-right-container">
             <span class="label label-primary pull-right">4</span>
           </span>
               </a>
               <ul class="treeview-menu">
                   <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                   <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                   <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                   <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed
                           Sidebar</a></li>
               </ul>
           </li>
           <li>
               <a href="pages/widgets.html">
                   <i class="fa fa-th"></i> <span>Widgets</span>
                   <span class="pull-right-container">
             <small class="label pull-right bg-green">new</small>
           </span>
               </a>
           </li>

           <li class="treeview">
               <a href="#">
                   <i class="fa fa-pie-chart"></i>
                   <span>Charts</span>
                   <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
               </a>
               <ul class="treeview-menu">
                   <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                   <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                   <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                   <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
               </ul>
           </li>

           <li class="treeview">
               <a href="#">
                   <i class="fa fa-laptop"></i>
                   <span>UI Elements</span>
                   <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
               </a>
               <ul class="treeview-menu">
                   <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                   <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                   <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                   <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                   <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                   <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
               </ul>
           </li>
           <li class="treeview">
               <a href="#">
                   <i class="fa fa-edit"></i> <span>Forms</span>
                   <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
               </a>
               <ul class="treeview-menu">
                   <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                   <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                   <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
               </ul>
           </li>
           <li class="treeview">
               <a href="#">
                   <i class="fa fa-table"></i> <span>Tables</span>
                   <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
               </a>
               <ul class="treeview-menu">
                   <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                   <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
               </ul>
           </li>
           <li>
               <a href="pages/calendar.html">
                   <i class="fa fa-calendar"></i> <span>Calendar</span>
                   <span class="pull-right-container">
             <small class="label pull-right bg-red">3</small>
             <small class="label pull-right bg-blue">17</small>
           </span>
               </a>
           </li>
           <li>
               <a href="pages/mailbox/mailbox.html">
                   <i class="fa fa-envelope"></i> <span>Mailbox</span>
                   <span class="pull-right-container">
             <small class="label pull-right bg-yellow">12</small>
             <small class="label pull-right bg-green">16</small>
             <small class="label pull-right bg-red">5</small>
           </span>
               </a>
           </li>
           <li class="treeview">
               <a href="#">
                   <i class="fa fa-folder"></i> <span>Examples</span>
                   <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
               </a>
               <ul class="treeview-menu">
                   <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                   <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                   <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                   <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                   <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                   <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                   <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                   <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                   <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
               </ul>
           </li>
           -->


            <!-- <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Multilevel</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Level One
                            <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                            <li class="treeview">
                                <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
            </li> -->

            <!--
            <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

<script>
    function ajax_search() {
        var search_request = document.getElementById("search").value;
        var search_response = document.getElementById("searchBox");
        // Exemplo de requisição GET
        var ajax = new XMLHttpRequest();


// Seta tipo de requisição e URL com os parâmetros
        ajax.open("GET", "/searchHelper/" + search_request, true);
        ajax.setRequestHeader("x-csrf-token", "fetch");
        ajax.setRequestHeader("Accept", "application/json");
        ajax.setRequestHeader("Content-Type", "application/json; charset=utf-8");

        //console.log(search_response.childNodes);

// Envia a requisição
        ajax.send();


// Cria um evento para receber o retorno.
        ajax.onreadystatechange = function () {
            var tableRows = search_response.getElementsByTagName('a');
            var rowCount = tableRows.length;
            for (var x = 0; x < rowCount; x++) {
                search_response.removeChild(tableRows[0]);
            }

            // Caso o state seja 4 e o http.status for 200, é porque a requisiçõe deu certo.
            if (ajax.readyState == 4 && ajax.status == 200) {

                var data = ajax.responseText;
                var obj = JSON.parse(data);
                obj.forEach(function (element) {

                    if (element == "Sem Sugestao") {

                    } else {
                        var resultado = htmlToElement(element);
                        search_response.appendChild(resultado);
                    }
                });
            }
        }

    }

    function htmlToElement(html) {
        var template = document.createElement('template');
        html = html.trim(); // Never return a text node of whitespace as the result
        template.innerHTML = html;
        return template.content.firstChild;
    }
</script>