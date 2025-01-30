<div class="container">
    <h1>Verlofoverzicht</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('verlofAanvraag') }}" class="btn btn-primary mb-3">Nieuw Verlof Aanvragen</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Begin Tijd</th>
                <th>Begin Datum</th>
                <th>Eind Tijd</th>
                <th>Eind Datum</th>
                <th>Reden</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            @foreach($verlofAanvragen as $item)
                <tr onclick="navigateToVerlof({{ $item->id }})" style="cursor: pointer;">
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->begin_tijd }}</td>
                    <td>{{ $item->begin_datum }}</td>
                    <td>{{ $item->eind_tijd }}</td>
                    <td>{{ $item->eind_datum }}</td>
                    <td>{{ $item->reden }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function navigateToVerlof(id) {
        window.location.href = "{{ url('api/verlof') }}/" + id;
    }
</script>
