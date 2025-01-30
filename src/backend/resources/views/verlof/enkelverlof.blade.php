<div class="container">
    <h1>Verlofoverzicht</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('verlofVerwijderen', $verlofAanvragen->id) }}" method="POST">
        @csrf
        @method('DELETE') 
        <button type="submit" class="btn btn-danger">Verwijderen</button>
        <a href="{{ route('verlofOverzicht') }}" class="btn btn-primary mb-3">Annuleren</a>
    </form>

    <!-- Knoppen voor status update -->
    <form action="{{ route('verlofApprove', $verlofAanvragen->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-success">Goedkeuren</button>
    </form>

    <form action="{{ route('verlofDeny', $verlofAanvragen->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-warning">Afwijzen</button>
    </form>

    <table class="table">
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
    </table>
</div>
