<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h3>Hi there,</h3>
        <p>Thank you for registering on <a href="http://www.moneytablet.com/">moneytablet.com</a>.</p>
        <p>To confirm your account please click on this link: <a href="{{ URL::to('account/confirm', array($confirmation)) }}">{{ URL::to('account/confirm', array($confirmation)) }}</a>.</p>
    </body>
</html>
