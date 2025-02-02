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
        <a class="dashboard-button-register" href="{{ route('register') }}">Register</a>
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
            <div class="verlof-slot">
                <h1>Verlofoverzicht</h1>

                <form action="{{ route('verlofVerwijderen', $verlofAanvragen->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="grey-button">Verwijderen</button>
                    <a href="{{ route('verlofOverzicht') }}" class="grey-button">Annuleren</a>
                </form>

                @if(Auth::user()->rol === 'werknemer')
                <a class="grey-button" href="{{ route('verlofUpdaten', $verlofAanvragen->id) }}" class="btn btn-info">Bewerken</a>
                @endif

                <div class="table-holder">
                    <div class="verlof-table">
                        <div class="verlof-table-block">
                            <div class="verlof-table-item">
                                <h4>Aangevraagd door</h4>
                                <p>{{ $verlofAanvragen->user->first_name }} {{ $verlofAanvragen->user->last_name }}</p>
                            </div>
                            <div class="verlof-table-item">
                                <h4>Begin tijd</h4>
                                <p>{{ $verlofAanvragen->begin_tijd }}</p>
                            </div>
                            <div class="verlof-table-item">
                                <h4>Begin datum</h4>
                                <p>{{ $verlofAanvragen->begin_datum }}</p>
                            </div>
                            <div class="verlof-table-item">
                                <h4>Eind tijd</h4>
                                <p>{{ $verlofAanvragen->eind_tijd }}</p>
                            </div>
                            <div class="verlof-table-item">
                                <h4>Eind datum</h4>
                                <p>{{ $verlofAanvragen->eind_datum }}</p>
                            </div>
                            <div class="verlof-table-item">
                                <h4>Reden</h4>
                                <p>{{ $verlofAanvragen->reden }}</p>
                            </div>
                            <div class="verlof-table-item">
                                <h4>Status</h4>
                                <p>{{ $verlofAanvragen->status }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->rol === 'officemanager' || Auth::user()->rol === 'teammanager')
                <form action="{{ route('verlofApprove', $verlofAanvragen->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="accept">Goedkeuren</button>
                </form>

                <form action="{{ route('verlofDeny', $verlofAanvragen->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="dashboard-button">Afwijzen</button>
                </form>
                @endif
            </div>
        </div>
        <!-- <table class="table">
                <thead>
                    <tr>
                        <th>Begin Tijd</th>
                        <th>Begin Datum</th>
                        <th>Eind Tijd</th>
                        <th>Eind Datum</th>
                        <th>Reden</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $verlofAanvragen->begin_tijd }}</td>
                        <td>{{ $verlofAanvragen->begin_datum }}</td>
                        <td>{{ $verlofAanvragen->eind_tijd }}</td>
                        <td>{{ $verlofAanvragen->eind_datum }}</td>
                        <td>{{ $verlofAanvragen->reden }}</td>
                        <td>{{ $verlofAanvragen->status }}</td>
                    </tr>
                </tbody>
            </table> -->
    </div>
</body>

</html>