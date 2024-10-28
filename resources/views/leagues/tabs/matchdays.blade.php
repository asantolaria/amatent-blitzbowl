<div class="table-responsive mt-3">
    <table class="table table-bordered" id="dataTableMatchdays" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Fecha</th>
                @if(Auth::user() && Auth::user()->admin)
                <th>Acciones</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($league->matchdays as $matchday)
            <tr>
                <td>
                    <a href="{{ route('matchdays.show', ['matchday' => $matchday->id]) }}">{{$matchday->description}}</a>
                </td>
                <td>{{ $matchday->date }}</td>
                @if (Auth::user() && Auth::user()->admin)
                <td class="d-flex">

                    <!-- edit buttton showing modal -->
                    <button type="button" class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#editMatchdayModal{{ $matchday->id }}" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>

                    <!-- Delete form -->
                    <form action="{{ route('matchdays.destroy', ['matchday' => $matchday->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach

            <!-- Create new matchday -->
            @if(Auth::user() && Auth::user()->admin)

            <tr>

                <form action="{{ route('matchdays.store') }}" method="post">
                    @csrf
                    <td>
                        <input type="hidden" name="league_id" value="{{ $league->id }}">

                        <input type="text" name="description" class="form-control" placeholder="Descripción" required>
                    </td>
                    <td>
                        <input type="date" name="date" class="form-control" placeholder="Fecha" required>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i>
                        </button>
                    </td>
                </form>
            </tr>
            @endif
        </tbody>
    </table>
</div>