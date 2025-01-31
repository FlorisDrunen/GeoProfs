<!DOCTYPE html>
<html>
<head>
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <title>Register</title>
</head>
<body class="register-body">
    <div class="register-box">
         <h1>Register</h1>
    <form method="POST" action="{{ route(name: 'register') }}">
        @csrf
        <label for="name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
        <br>
        <label for="name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <br>
        <button type="submit">Register</button>
    </form>
    </div>
   
</body>
</html>
