<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $credential->title }}</title>

  <script>
    function format(str) {
      try {
        const date = new Date(`${str} 00:00:00`);
        const formatter = new Intl.DateTimeFormat([], {
          dateStyle: "long",
        });
        return formatter.format(date);
      } catch (e) {
        return str;
      }
    };
  </script>

  <style>
    .titulo {
      font-size: 2vw;
    }

    .orga {
      font-size: 1.5vw;
    }

    .serif * {
      font-family: "Times New Roman", Times, serif;
    }

    .sans-serif * {
      font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
    }

    .cert-frame {
      -webkit-box-shadow: 0 0 16px 0px gray;
      box-shadow: 0 0 16px 0px gray;
    }

    .d-flex {
      display: flex;
    }

    .flex-row {
      flex-direction: row !important;
    }

    .p-4 {
      padding: 1.5rem!important;
    }

    .toolbar {
      text-align: right;
      background: rgb(85, 76, 232);
      background: linear-gradient(
          9deg,
          rgba(85, 76, 232, 0.3) 0%,
          rgba(116, 116, 255, 0.3) 35%,
          rgba(220, 249, 255, 0.3) 100%
      );
      border-bottom: 1px solid gray;
      padding: 0.5rem;
    }
    body {
      padding: 0px;
      margin: 0px;
    }
  </style>
</head>

<body>
  <div class="toolbar">
    <a href="{{ url('/') }}">
      <img src="{{ url('/images/logo.svg') }}" height="48px">
    </a>
  </div>
  <div class="d-flex flex-row p-4">
    <div style="width:{{ $credential->width }}%">
      <img src="{{ $credential->image['url'] }}" width="100%" class="cert-frame">
    </div>
    <div class="{{ $credential->style }} p-4" style="width:{{ 100 - $credential->width }}%">
      <h1 class="titulo">
        {{ $credential->user->name }}
      </h1>
      <h1 class="titulo">
        <b>{{ $credential->title }}</b>
      </h1>
      <h2 class="orga">
        {{ $credential->organization }}
      </h2>
      <a href="{{ $credential->organization_url }}">
        {{ $credential->organization_url }}
      </a>
      <p>
        {{ $credential->place . ($credential->place ? ',' : '') }}
        <script>
          document.write(format(@json($credential-> date)))
        </script>
      </p>
      <p>
        <img src="{{ $credential->qrcode }}" width="128px">
      </p>
    </div>
  </div>
</body>

</html>