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
                <a class="grey-button" href="{{route('dashboard')}}">Dashboard</a>
                @if(Auth::user()->rol === 'werknemer')
                <a  href="{{ route('verlofAanvraag') }}"><button class="grey-button"> Nieuw Verlof Aanvragen </button></a>
                @endif
              
    
                <!-- Filter Form -->
                <form method="GET" action="{{ route('verlofOverzicht') }}" class="mb-3">
                    <label for="statusFilter">Filter op status:</label>
                    <select name="status" id="statusFilter" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Alle</option>
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="denied" {{ $status == 'denied' ? 'selected' : '' }}>Denied</option>
                    </select>
                </form>
                        <div class="table-holder">                            
                            @foreach($verlofAanvragen as $item)
                                <div class="verlof-table" onclick="navigateToVerlof({{ $item->id }})" style="cursor: pointer;">
    
                                    <div class="verlof-table-block">
                                        <div class="verlof-table-item"><h4>Aangevraagd door</h4> <p>{{ $item->user->first_name }} {{ $item->user->last_name }}</p> </div>
                                        <div class="verlof-table-item"><h4>Begin tijd</h4> <p>{{ $item->begin_tijd }}</p> </div>
                                        <div class="verlof-table-item"><h4>Begin datum</h4> <p>{{ $item->begin_datum }}</p> </div>
                                        <div class="verlof-table-item"><h4>Eind tijd</h4> <p>{{ $item->eind_tijd }}</p> </div>
                                        <div class="verlof-table-item"><h4>Eind datum</h4> <p>{{ $item->eind_datum }}</p> </div>
                                        <div class="verlof-table-item"><h4>Reden</h4> <p>{{ $item->reden }}</p> </div>
                                        <div class="verlof-table-item"><h4>Status</h4> <p>{{ $item->status }}</p> </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    <!-- </tbody> -->
                <!-- </table> -->
            </div>
        </div>
    </div>
</body>
  

    <script>
        function navigateToVerlof(id) {
            window.location.href = "{{ url('api/verlof') }}/" + id;
        }
    </script>
</html>
