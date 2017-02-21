<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div >
    <nav class="nav">
        <div class="nav-left">
            <a class="nav-item">
                <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma logo">
            </a>
        </div>

        <div class="nav-center">
            <a class="nav-item">
      <span class="icon">
        <i class="fa fa-github"></i>
      </span>
            </a>
            <a class="nav-item">
      <span class="icon">
        <i class="fa fa-twitter"></i>
      </span>
            </a>
        </div>

        <!-- This "nav-toggle" hamburger menu is only visible on mobile -->
        <!-- You need JavaScript to toggle the "is-active" class on "nav-menu" -->
        <span class="nav-toggle">
    <span></span>
    <span></span>
    <span></span>
  </span>

        <!-- This "nav-menu" is hidden on mobile -->
        <!-- Add the modifier "is-active" to display it on mobile -->
        <div class="nav-right nav-menu">
            <a class="nav-item">
                Home
            </a>
            <a class="nav-item">
                Documentation
            </a>
            <a class="nav-item">
                Blog
            </a>

            <span class="nav-item">
      <a class="button" >
        <span class="icon">
          <i class="fa fa-twitter"></i>
        </span>
        <span>Tweet</span>
      </a>
      <a class="button is-primary">
        <span class="icon">
          <i class="fa fa-download"></i>
        </span>
        <span>Download</span>
      </a>
    </span>
        </div>
    </nav>
    @yield('content')
    @if(Auth::check())
        <input style="display: none" id="user_id" value="{{ Auth::user()->id }}">
        <input style="display: none" id="api_token" value="{{ Auth::user()->api_token }}">
    @endif

</div>

<!-- Scripts -->
<script src="{{ elixir('js/app.js') }}"></script>

<script>

    document.onreadystatechange = () => {
        if (document.readyState === 'complete') {
            console.log("doc is ready");
            @if(Auth::check())
                Echo.private('App.User.1')
                .listen('UserDataInformationLoaded', (e) => {
                    console.log(e);
                });
            @endif
        }
    };

</script>
</body>
</html>
