<div class="table-responsive mt-3">
    <table class="table table-bordered display" id="dataTableStandings" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Entrenador</th>
                <th>Equipo</th>
                <th title="Partidos Jugados">PJ</th>
                <th title="Partidos Ganados">PG</th>
                <th title="Partidos Empatados">PE</th>
                <th title="Partidos Perdidos">PP</th>
                <th title="Puntos">PTS</th>
                <th title="Touchdowns Anotados">Touchdowns</th>
                <th title="Cartas Obtenidas">Cartas</th>
                <th title="Lesiones Provocadas">Lesiones</th>
            </tr>
        </thead>
    </table>
</div>


<!-- Incluir el JS de DataTables en tu vista -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTableStandings').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            lengthChange: false,
            ajax: "{{ route('standings', ['league' => $league->id]) }}",
            order: [
                [6, 'desc']
            ], // Ordena por la columna de puntos (7ª columna, índice 6) en orden descendente
            columns: [{
                    data: 'team.coach_name',
                    name: 'team.coach_name'
                },
                {
                    data: 'team.name',
                    name: 'team.name'
                },
                {
                    data: 'matches',
                    name: 'matches'
                },
                {
                    data: 'wins',
                    name: 'wins'
                },
                {
                    data: 'draws',
                    name: 'draws'
                },
                {
                    data: 'losses',
                    name: 'losses'
                },
                {
                    data: 'points',
                    name: 'points'
                },
                {
                    data: 'touchdowns',
                    name: 'touchdowns'
                },
                {
                    data: 'cards',
                    name: 'cards'
                },
                {
                    data: 'injuries',
                    name: 'injuries'
                }
            ]
        });
    });
</script>