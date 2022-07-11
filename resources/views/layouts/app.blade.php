<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="{{ asset('favicon.ico') }}" rel="icon">
        <title>{{ config('app.name', 'MyAppsZ') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">

        <link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet">
        @yield('css')

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                @include('layouts.navigation')
                <!-- Page Heading -->
                <section id="main-content">
                    <header>
                        <br>
                        <div class="row">
                            <div class="col-lg-12">
                                {{ $header }}
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main>
                        <div class="row">
                            <div class="col-lg-12">
                                {{ $slot }}
                            </div>
                        </div>
                    </main>
                </section>
            </div>

        </div>

<div id="footer" style="
    width: 100%;
    height: 10px;
    background: #bbe2ff;
    position: absolute;
    bottom: 0;
"></div>


@if (Session::has('message'))
    <div id="info-show" class="alert-info-cst" style="display: none;width: 200px;
    position: absolute;
    bottom: 20px;
    left: 20px;">
      <div class="alert" style="background: #ffb100; color: #000;"><i class="fa fa-info" aria-hidden="true"></i> info : {{ Session::get('message') }}</div>
    </div>
@endif

        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous" defer></script>
        <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
        
        {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  
        <script type="text/javascript" src="{{ asset('js/helpers.js') }}"></script>
        <script type="text/javascript">
            let global_length_src = 3;
            var global_hash;

            var global_params = [];

            var hideinfo = function(){
              $('#info-show').hide(1000);
            };

            var showinfo = function(){
              $('#info-show').show(1000);
              setTimeout(hideinfo, 9000);
            };
            setTimeout(showinfo, 1000);

            function reloadpg(){
                location.reload();
            }
        </script>

        @yield('script')
        @yield('script1')
        @yield('script2')
        @yield('script3')

    </body>
</html>
