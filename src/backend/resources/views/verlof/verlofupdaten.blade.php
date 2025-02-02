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
        <div class="verlof-container">
            <div class="login-box">
                <h1>Verlof Bewerken</h1>

                <form action="{{ route('verlofUpdatenFunc', $verlofAanvragen->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="BeginTijd">Begin Tijd</label>
                        <input type="time" name="begin_tijd" id="begin_tijd" value="{{ $verlofAanvragen->begin_tijd }}" required>
                    </div>

                    <div>
                        <label for="BeginDatum">Begin Datum</label>
                        <input type="date" name="begin_datum" id="begin_datum" value="{{ $verlofAanvragen->begin_datum }}" required>
                    </div>

                    <div>
                        <label for="EindTijd">Eind Tijd</label>
                        <input type="time" name="eind_tijd" id="eind_tijd" value="{{ $verlofAanvragen->eind_tijd }}" required>
                    </div>

                    <div>
                        <label for="EindDatum">Eind Datum</label>
                        <input type="date" name="eind_datum" id="eind_datum" value="{{ $verlofAanvragen->eind_datum }}" required>
                    </div>

                    <div>
                        <label for="Reden">Reden</label>
                        <br>
                        <textarea name="reden" class="textarea-fixed" id="reden" required>{{ $verlofAanvragen->reden }}</textarea>
                    </div>

                    <input type="hidden" name="status" id="status" value="pending">

                    <button type="submit" class="btn btn-primary">Bijwerken</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>