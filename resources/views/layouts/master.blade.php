<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }} </title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
        @yield('before-css')
        {{-- theme css --}}
        <link id="gull-theme" rel="stylesheet" href="{{  asset('assets/styles/css/themes/lite-purple.min.css')}}">

        <link rel="stylesheet" href="{{asset('assets/styles/vendor/perfect-scrollbar.css')}}">
        @if (Session::get('layout')=="vertical")
        <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome-free-5.10.1-web/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/styles/vendor/metisMenu.min.css') }}">
        

        @endif

        {{-- page specific css --}}
        @yield('page-css')
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    </head>


    <body class="text-left">
        @php
        $layout = session('layout');
        @endphp

        <!-- Pre Loader Strat  -->
        <div class='loadscreen' id="preloader">

            <div class="loader spinner-bubble spinner-bubble-primary">


            </div>
        </div>
        <!-- Pre Loader end  -->



        <!-- ============ Horizontal Layout start ============= -->


        <div class="app-admin-wrap layout-horizontal-bar clearfix">
            @include('layouts.header-menu')

            <!-- ============ end of header menu ============= -->

            <!-- ============ end of left sidebar ============= -->

            <!-- ============ Body content start ============= -->
            <div class="main-content-wrap  d-flex flex-column">
                <div class="main-content">
                    @yield('main-content')
                </div>

                @include('layouts.footer')
            </div>
            <!-- ============ Body content End ============= -->
        </div>
        <!--=============== End app-admin-wrap ================-->

        <!-- ============ Search UI Start ============= -->
        @include('layouts.search')
        <!-- ============ Search UI End ============= -->

      
        {{-- common js --}}
        <script src="{{  asset('assets/js/common-bundle-script.js')}}"></script>
        {{-- page specific javascript --}}
        @yield('page-js')

        {{-- theme javascript --}}
        {{-- <script src="{{mix('assets/js/es5/script.js')}}"></script> --}}
        <script src="{{asset('assets/js/script.js')}}"></script>


        @if ($layout=='compact')
        <script src="{{asset('assets/js/sidebar.compact.script.js')}}"></script>


        @elseif($layout=='normal')
        <script src="{{asset('assets/js/sidebar.large.script.js')}}"></script>


        @elseif($layout=='horizontal')
        <script src="{{asset('assets/js/sidebar-horizontal.script.js')}}"></script>
        @elseif($layout=='vertical')



        <script src="{{asset('assets/js/tooltip.script.js')}}"></script>
        <script src="{{asset('assets/js/es5/script_2.js')}}"></script>
        <script src="{{asset('assets/js/vendor/feather.min.js')}}"></script>
        <script src="{{asset('assets/js/vendor/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/js/layout-sidebar-vertical.js')}}"></script>


        @else
        <script src="{{asset('assets/js/sidebar.large.script.js')}}"></script>

        @endif



        <script src="{{asset('assets/js/customizer.script.js')}}"></script>


        {{-- laravel js --}}
        {{-- <script src="{{mix('assets/js/laravel/app.js')}}"></script> --}}

        @yield('bottom-js')
       <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
       <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
       <script src="{{asset('assets/js/build/core.js')}}"></script>
       <script src="{{asset('assets/js/build/sugarpak.js')}}"></script>
       <script src="{{asset('assets/js/build/time.js')}}"></script>
       <script src="{{asset('assets/js/build/extras.js')}}"></script>
    </body>

  <script>
    $(function() {
          $('input[name="daterange"]').daterangepicker({
            opens: 'left'
          }, function(start, end, label) {
                $( ".chart-call" ).removeClass( "btn-raised btn-raised-primary" ).addClass( "btn-outline-primary" );
                $("#daterange").attr("date-from", start.format('YYYY-MM-DD'));
                $("#daterange").attr("date-to", end.format('YYYY-MM-DD'));

          });

        
          $("#search-by-date").trigger('click');



    });
</script>

</html>