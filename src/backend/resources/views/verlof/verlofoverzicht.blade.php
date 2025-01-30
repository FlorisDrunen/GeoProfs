<div class="container">
    <h1>Verlofoverzicht</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('verlofAanvraag') }}" class="btn btn-primary mb-3">Nieuw Verlof Aanvragen</a>

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
