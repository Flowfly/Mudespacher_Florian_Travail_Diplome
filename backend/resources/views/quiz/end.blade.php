@extends('quiz/layout')
@section('content')
    <div class="col-12">
        <h1>Partie terminée !</h1>
    </div>
    <hr>
    <div class="col-12">
        <h1>Classement : </h1>
        @if(count($ranking) == 0)
            <h3>Personne n'a participé à cette partie</h3>
        @else
            @for($i = 0; $i<count($ranking); $i++)
                <h3>{{$i+1}}. {{$ranking[$i][0]}} avec {{$ranking[$i][1]}} points !</h3>
            @endfor
        @endif
    </div>
    <hr>
    <div class="col-12">
        <h4>Veuillez s'il vous plaît rendre les tablettes au responsable</h4>
    </div>
    <div style="display: none">{{ \App\Http\Controllers\SessionController::restartSession(request()) }}</div>
@endsection