<!DOCTYPE html>
<html>

<head>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <title>Dashboard</title>
</head>

<body class="dashboard-body">
    <div class="dashboard-header">
        <h1 class="dashboard-header-text">Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
    </div>
    <div class="dashboard-form">

        @csrf
        @if(Auth::user()->rol === 'officemanager')
        <a class="dashboard-button" href="{{ route('register') }}">Register</a>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dashboard-button" type="submit">Logout</button>
        </form>

    </div>
    <div class="dashboard-nav-container">
        <ul class="dashboard-nav-list">
            <a class="dashboard-nav-link" href="{{ route('verlofOverzicht') }}">verlof overzicht</a>
            @if(Auth::user()->rol === 'werknemer')
            <a class="dashboard-nav-link" href="{{ route('verlofAanvraag') }}">verlof aanvragen</a>
            @endif
        </ul>
    </div>
    <div class="dashboard-info">

    </div>
</body>

</html>