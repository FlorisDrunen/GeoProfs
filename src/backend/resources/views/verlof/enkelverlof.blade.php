
<div class="container">
        <h1>Verlofoverzicht</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ url('/api/verlof-delete/' . $verlofAanvragen->id) }}" method="POST">
     @csrf
      @method('DELETE') 
       <button type="submit" class="btn btn-danger">Verwijderen</button>
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
                    <th>Status omschrijving</th>
                </tr>
            </thead>
            <tbody>

                    <tr>
                        <td>{{ $verlofAanvragen->begin_tijd }}</td>
                        <td>{{ $verlofAanvragen->begin_datum }}</td>
                        <td>{{ $verlofAanvragen->eind_tijd }}</td>
                        <td>{{ $verlofAanvragen->eind_datum }}</td>
                        <td>{{ $verlofAanvragen->reden }}</td>
                        <td>{{ $verlofAanvragen->naam }}</td>

                    </tr>


            </tbody>
        </table>
    </div>