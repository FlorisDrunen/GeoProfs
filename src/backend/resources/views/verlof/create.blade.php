
    <div class="container">
        <h1>Nieuw Verlof Aanmaken</h1>

        <form action="{{ route('verlof.store') }}" method="POST">
            @csrf

            <div >
                <label for="BeginTijd">Begin Tijd</label>
                <input type="time" name="BeginTijd" id="BeginTijd" required>
            </div>

            <div >
                <label for="BeginDatum">Begin Datum</label>
                <input type="date" name="BeginDatum" id="BeginDatum" required>
            </div>

            <div >
                <label for="EindTijd">Eind Tijd</label>
                <input type="time" name="EindTijd" id="EindTijd" required>
            </div>

            <div >
                <label for="EindDatum">Eind Datum</label>
                <input type="date" name="EindDatum" id="EindDatum" required>
            </div>

            <div >
                <label for="Reden">Reden</label>
                <textarea name="Reden" id="Reden" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Aanmaken</button>
        </form>
    </div>

