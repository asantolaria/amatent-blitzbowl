<div class="table-responsive mt-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="bg-gray-200">Equipo</th>
                @foreach(array_keys($pairings) as $team)
                <th class="bg-gray-200">{{ $team }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($pairings as $teamA => $row)
            <tr>
                <td class="bg-gray-200"><strong>{{ $teamA }}</strong></td>
                @foreach($row as $teamB => $count)
                <td class="{{ $count === '-' ? 'bg-gray-300' : ($count > 0 ? 'bg-green-300' : '') }}">
                    {{ $count }}
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>