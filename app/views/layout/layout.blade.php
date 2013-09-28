<!DOCTYPE html>
<html lang="en">
    @section('head')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Simple app for personal finances">
        <meta name="author" content="Andrei Boar">
        <title>MoneyTablet.com - The simplest app for personal finances</title>

        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/jumbotron.css') }}
        {{ HTML::style('css/custom.css') }}
    </head>
    @show
    <body>
        @section('navbar')
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ URL::to('/') }}">MoneyTablet</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
<!--                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#contact">Contact us</a></li>-->
                    </ul>
                    @section('login')
                    <?php if (!Auth::check()): ?>
                        <form action="{{ URL::to('account/loginPost') }}" class="navbar-form navbar-right" method="POST">
                            <div class="form-group">
                                <input name="email" type="text" placeholder="Email" class="form-control">
                            </div>
                            <div class="form-group">
                                <input name="password" type="password" placeholder="Password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-success">Sign in</button>
                        </form>
                    <?php else: ?>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{ URL::to('account/logOut')}}">Log Out</a></li>
                        </ul>
                    <?php endif; ?>
                    @show
                </div>
            </div>
        </div>
        @show
        <div class="container">
            @yield('content')
            <hr>
            @section('footer')
            <footer>
                <p>&copy; MoneyTablet.com 2013</p>
            </footer>
            @show
        </div>
        @section('footer-js-scripts')
        {{ HTML::script('js/jquery-2.0.3.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        @show
    </body>
</html>
