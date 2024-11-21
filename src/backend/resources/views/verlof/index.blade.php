
    <div class="container">
        <h1>Verlofoverzicht</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('verlof.create') }}" class="btn btn-primary mb-3">Nieuw Verlof Aanvragen</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Begin Tijd</th>
                    <th>Begin Datum</th>
                    <th>Eind Tijd</th>
                    <th>Eind Datum</th>
                    <th>Reden</th>
                    <th>Status</th>
                    <th>Status omschrijving</th>
                </tr>
            </thead>
            <tbody>
                @foreach($verlof as $item)
                    <tr>
                        <td>{{ $item->BeginTijd }}</td>
                        <td>{{ $item->BeginDatum }}</td>
                        <td>{{ $item->EindTijd }}</td>
                        <td>{{ $item->EindDatum }}</td>
                        <td>{{ $item->Reden }}</td>
                        <td>{{ $item->Naam }}</td>
                        <td>{{ $item->Omschrijving }}</td>
                    </tr>
                    @endforeach

            </tbody>
        </table>
    </div>

<!-- <div class="container">
    <h1>Pagina bereikt</h1>
    <table>
        <thead>
            <tr>
                <th>Reden:</th>
                <th>BeginTijd:</th>

            </tr>
        </thead>
        <tbody>
            @foreach($verlof as $verlofonderdeel)
            <tr>
                <td>{{ $verlofonderdeel->Reden }}</td>
                <td>{{ $verlofonderdeel->BeginTijd }}</td>


            </tr>
            @endforeach
        </tbody>
    </table>
</div>
 -->
