<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h3>Hi there,</h3>
        <p>You recently asked to reset your <a href="http://www.moneytablet.com/">moneytablet.com</a> password. If you don't remind doing that, please ignore this e-mail.</p>
        <p>To reset your password, complete this form: <a href="{{ URL::to('password/getReset', array($token)) }}">{{ URL::to('password/getReset', array($token)) }}</a>.</p>
    </body>
</html>
