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

    <!-- form for register en logout -->
        @csrf
        @if(Auth::user()->rol === 'officemanager')
         <!-- Only show the leave request links when the users role is 'officemanager'-->
        <a class="dashboard-button-register" href="{{ route('register') }}">Register</a>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dashboard-button" type="submit">Logout</button>
        </form>

    </div>

     <!-- nav links -->
    <div class="dashboard-nav-container">
        <ul class="dashboard-nav-list">
            <a class="dashboard-nav-link" href="{{ route('verlofOverzicht') }}">verlof overzicht</a>
            <!-- Only show the leave request links when the users role is 'werknemer'. -->
            @if(Auth::user()->rol === 'werknemer')
            <a class="dashboard-nav-link" href="{{ route('verlofAanvraag') }}">verlof aanvragen</a>
            @endif
        </ul>
    </div>
    <div class="dashboard-info">
        <div class="verlof-container">
            <div class="verlof-slot">
                <h1>Verlofoverzicht</h1>

                <!-- Delete method -->
                <form action="{{ route('verlofVerwijderen', $verlofAanvragen->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('verlofOverzicht') }}" class="grey-button">Annuleren</a>
                    @if(Auth::user()->rol === 'werknemer')
                    <!-- Only show the link when the users role is 'werknemer'. -->
                    <a class="grey-button" href="{{ route('verlofUpdaten', $verlofAanvragen->id) }}" class="btn btn-info">Bewerken</a>
                    @endif
                    <button type="submit" class="dashboard-button">Verwijderen</button>
                </form>

            <!-- Display the leave request data for one specific request. -->
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
                 <!-- Only show the apporve & deny links when the users role is 'officemanager' or 'teammanager'. -->
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
    </div>
</body>

</html>