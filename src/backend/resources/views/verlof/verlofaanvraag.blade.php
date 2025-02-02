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
            <a class="dashboard-nav-link" href="{{ route('verlofAanvraag') }}">verlof aanvragen</a>
        </ul>
    </div>
    <div class="dashboard-info">
        <div class="container">
            <h1>Nieuw Verlof Aanmaken</h1>

            <form action="{{ route('verlofNieuw') }}" method="POST">
                @csrf

                <div>
                    <label for="BeginTijd">Begin Tijd</label>
                    <input type="time" name="begin_tijd" id="begin_tijd" required>
                </div>

                <div>
                    <label for="BeginDatum">Begin Datum</label>
                    <input type="date" name="begin_datum" id="begin_datum" required>
                </div>

                <div>
                    <label for="EindTijd">Eind Tijd</label>
                    <input type="time" name="eind_tijd" id="eind_tijd" required>
                </div>

                <div>
                    <label for="EindDatum">Eind Datum</label>
                    <input type="date" name="eind_datum" id="eind_datum" required>
                </div>

                <div>
                    <label for="Reden">Reden</label>
                    <textarea name="reden" id="reden" required></textarea>
                </div>
                <div>
                    <input type="hidden" name="status" id="status" value="pending">
                </div>
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">




                <button type="submit" class="btn btn-primary">Aanvragen</button>
            </form>
        </div>
        
    </div>
</body>

</html>