@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="md-form mt-0">
                <input class="form-control" type="text" placeholder="Rechercher" aria-label="Search">
            </div>
            <br>
        </div>
        <div class="col-12" style="text-align: center;">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom de l'équipe</th>
                    <th scope="col">Joueurs</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($teams as $team)
                    <tr>
                        <th scope="row">{{$team->id}}</th>
                        <td>{{$team->name}}</td>
                        <td><a href="/backoffice/teams/{{$team->id}}/users">{{count($team->users) }} <i
                                        class="fas fa-eye"></i></a></td>
                        <td><a href="/backoffice/teams/edit/{{$team->id}}"><i class="fas fa-edit"></i></a></td>
                        <td><a href="/backoffice/teams/delete/{{$team->id}}"><i class="fas fa-times"
                                                                                style="color:red;"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if(session('result'))
                @if(session('result') == 1)
                    <div class="alert alert-success animated bounceInRight">
                        {{session('message')}}
                    </div>
                @endif
            @endif
        </div>
        <div class="col"></div>
        <div class="col-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col"></div>
    </div>
@endsection