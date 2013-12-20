<!DOCTYPE html>
<html lang="en">
    @section('head')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Simple app for managing personal finances">
        <meta name="author" content="Andrei Boar">
        <title>MoneyTablet.com - Hack your personal finances</title>

        {{ HTML::style('css/bootstrap.css') }}
        {{ HTML::style('css/custom.css') }}
        {{ HTML::style('css/auth-buttons.css') }}
    </head>
    @show
    <body style="padding-top: 50px; padding-bottom: 20px;">
        @section('navbar')
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand active" href="{{ URL::to('/') }}">MoneyTablet</a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ URL::to('how-to') }}">How does it work</a></li>
                    </ul>
                    @section('login')
                    <?php if (!Auth::check()): ?>
                    <?php $route = Route::currentRouteName();
                    $nowAllowedPaths = array('get password/getRemind', 'get password/reset/{token}', 'get account/create', 'get reset/success');
                    ?>
                        <?php if (!in_array($route, $nowAllowedPaths)): ?>
                            <form action="{{ URL::to('account/loginPost') }}" class="navbar-form navbar-right" method="POST">
                                <div class="form-group">
                                    <input name="email" type="text" placeholder="Email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input name="password" type="password" placeholder="Password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success">Sign in</button>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="checkbox">
                                            <input type="checkbox" value="1" name="remember" id="remember-checkbox-front">
                                            <label for="remember-checkbox-front" id="remember-label-front">Keep me signed in</label><br>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-md-offset-1">
                                        <div class="checkbox">
                                            <a id="remember-front" href="{{URL::to('password/getRemind')}}">Forgot your password?</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>
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
                <p>&copy; MoneyTablet.com {{date('Y')}}. This app was created by <a href="http://www.andreiboar.com/" target="_blank">Andrei Boar</a>. Feel free to <a href="mailto:hello@moneytablet.com" target="_blank">e-mail</a> us or <a href="https://github.com/zuzuleinen/moneytablet" target="_blank">contribute</a> to the project.</p>
            </footer>
            @show
        </div>
        @section('footer-js-scripts')
        {{ HTML::script('js/jquery-2.0.3.min.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        @show
    </body>
</html>
