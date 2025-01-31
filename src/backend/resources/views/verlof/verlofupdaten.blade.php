<div class="container">
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
            <textarea name="reden" id="reden" required>{{ $verlofAanvragen->reden }}</textarea>
        </div>

        <input type="hidden" name="status" value="{{ $verlofAanvragen->status }}">

        <button type="submit" class="btn btn-primary">Bijwerken</button>
    </form>
</div>
