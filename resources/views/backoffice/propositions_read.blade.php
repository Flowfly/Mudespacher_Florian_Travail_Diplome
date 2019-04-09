@extends('backoffice/layout')
@section('content')
    <div class="col-12">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Réponse</th>
                <th scope="col">Bonne réponse ?</th>
                <th scope="col">Question associée</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($propositions as $proposition)
                <tr>
                    <th scope="row">{{$proposition->id}}</th>
                    <td>{{$proposition->label}}</td>
                    <td>{{$proposition->is_right_answer == 1 ? "Oui" : "Non"}}</td>
                    <td>{{$proposition->question->label}}</td>
                    <td><a href="/backoffice/questions/edit/{{$proposition->question->id}}"><i class="fas fa-edit"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection