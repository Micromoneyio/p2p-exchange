<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<div>
    Hi {{ $email }},
    <br>
    Reset your password!
    <br>
    Please click on the link below or copy it into the address bar of your browser to continue:
    <br>

    <a href="{{ route('password.request', $verification_code)}}">Reset my password </a>

    <br/>
</div>

</body>
</html>
