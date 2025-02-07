<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layout.head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('layout.header')
@include('layout.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @section('content')
        @show
    </div>
    <!-- /.content-wrapper -->
    @include('layout.footer')
</div>

<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!-- Sparkline -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.js"></script>
<!-- Slimscroll -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.8/js/adminlte.min.js"></script>
@yield('scripts')
<script>
    function ajax_search() {
        var search_request = document.getElementById("search").value;
        var search_response = document.getElementById("searchBox");
        // Exemplo de requisição GET
        var ajax = new XMLHttpRequest();


// Seta tipo de requisição e URL com os parâmetros
        if(search_request == "") {
            return;
        }

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
            } else if (ajax.status = 405) {
                //Ignore 405 on empty text
                return;
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
</body>
</html>

