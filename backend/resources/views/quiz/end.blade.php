@extends('quiz/layout')
@section('content')
    <div>
        <div>
            <h1 class="ranking-title">Partie terminée !</h1>
        </div>
        <hr>
        <div>
            <h1 class="ranking-title">Classement : </h1>
            @if(count($ranking) == 0)
                <h3 class="ranked-user">Personne n'a participé à cette partie</h3>
            @else
                @for($i = 0; $i<count($ranking); $i++)
                    <h3 class="ranked-user">{{$i+1}}. {{$ranking[$i][0]}} avec {{$ranking[$i][1]}} points !</h3>
                @endfor
            @endif
        </div>
        <hr>
        <div>
            <h4 class="instructions-text">Veuillez s'il vous plaît rendre les tablettes au responsable</h4>
        </div>
        <div style="display: none">{{ \App\Http\Controllers\SessionController::restartSession(request()) }}</div>
    </div>

@endsection
@section('scripts')
    <script>
        setTimeout(() => {
            document.location.href = "/{!! request('session_id') !!}";
        }, 20000);
    </script>
@endsection