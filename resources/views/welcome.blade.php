<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('favicon.ico') }}" rel="icon">
        <title>MyAppsZ</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link href="{{ asset('css/stylec.css') }}" type="text/css" rel="stylesheet">
    </head>
    <body>

<div class="header">
  @if (Route::has('login'))
      <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
          @auth
              <a href="{{ url('/dashboard') }}" style="font-family: 'Lato', sans-serif; float: right; margin-right: 25px; background: #fff; padding: 5px 15px; border-radius: 5px; text-decoration: none; color: #467fb9;">Dashboard</a>
          @else
              <a href="{{ route('login') }}" style="font-family: 'Lato', sans-serif; float: right; margin-right: 25px; background: #fff; padding: 5px 15px; border-radius: 5px; text-decoration: none; color: #467fb9;">Log in</a>
          @endauth
      </div>
  @endif
</div>
<div class="content">
  <div class="content__container">
    <p class="content__container__text">
      :D
    </p>
    
    <ul class="content__container__list">
      <li class="content__container__list__item">Hello World !</li>
      <li class="content__container__list__item">Hello Everybody !</li>
      <li class="content__container__list__item">Welcome !</li>
      <li class="content__container__list__item">to MyappsZ !</li>
    </ul>
  </div>
</div>

<span class="usechrome">Use Chrome for a better experience</span>
    </body>
</html>
