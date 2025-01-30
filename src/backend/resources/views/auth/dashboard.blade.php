<!DOCTYPE html>
<html>

<head>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <title>Dashboard</title>
</head>

<body class="dashboard-body">
    <div class="dashboard-header">
        <h1 class="dashboard-header-text">Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
        <form class="dashboard-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dashboard-button" type="submit">Logout</button>
        </form>
    </div>
</body>

</html>