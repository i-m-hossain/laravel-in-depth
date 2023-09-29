<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="{{ route('password.reset') }}">

        <input type="text" name="email" placeholder="Enter your email">
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="password" name="password" placehoder="Enter your password">
        <input type="password" name="password_confirmation" placeholder="Enter your password again">
    </form>

</body>

</html>
