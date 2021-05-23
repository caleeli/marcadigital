<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>

        <link href="{{ mix('css/welcome.css') }}" rel="stylesheet">
        @foreach (config('plugins.css') as $css)
        <link href="{{ $css }}?{{filemtime(public_path($css))}}" rel="stylesheet">
        @endforeach
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">{{ __('Home') }}</a>
                    @else
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content d-flex flex-row flex-nowrap">
                <div class="align-self-center">
                    <h1 class="title m-b-md">
                        <img src="{{ url('images/logo.svg') }}">
                    </h1>
                    <h2 class="subtitle m-b-md text-white">
                        {{ __('Digital brand') }}
                    </h2>
                </div>
                <div>
                    @include('auth.login_card')
                </div>
            </div>
        </div>
    </body>
</html>
