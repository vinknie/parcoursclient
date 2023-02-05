<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Parcour Client</title>
</head>
<body>
    <h1>Hello {{ $user->name }}!</h1>
    <p>Your account has been created on our website. Your login information is as follows:</p>
    <p>Email: {{ $user->email }}</p>
    <p>Password: {{ $password }}</p>
    <p>We hope you enjoy using our website!</p>
</body>
</html>
