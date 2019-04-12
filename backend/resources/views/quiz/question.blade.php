@extends('quiz/layout')
@section('content')
    <div class="col-12">
        <h1>{{$question->label}}</h1>
    </div>
    <hr>
    @foreach($question->propositions as $proposition)
        <div class="col-12">
            <center>
                <div class="bubble-container">
                    <div class="hcenter bubble-text">
                        <p class="hcenter">{{$proposition->label}}</p>
                    </div>
                </div>
            </center>
        </div>
    @endforeach
@endsection