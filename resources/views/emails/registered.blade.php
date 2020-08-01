<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <h2>Thanks for Registering with us, {{ $admin->fullname }}!</h2>
    <img src="{{ $message->embed('images/image.jpg') }}" alt="" style="height:300px; width:500px">
</body>
</html>