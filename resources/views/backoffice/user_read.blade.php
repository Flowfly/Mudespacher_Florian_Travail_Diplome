@extends('backoffice/layout')
@section('content')
    <div class="row" style="text-align: center;">
        <div class="col-12">
            <h3>Détails de {{$user->username}}</h3>
            @if(session('result'))
                @if(session('result') == 1)
                    <p class="alert alert-success animated bounceInRight">
                        {{session('message')}}
                    </p>
                @endif
            @endif
            <hr>
            <br>
        </div>
        <div class="col"></div>
        <div class="col-6">
            <div class="row">
                <div class="col-6">
                    <h5>Nom d'utilisateur</h5>
                    <p>{{$user->username}}</p>
                </div>
                <div class="col-6">
                    <h5>Date de naissance</h5>
                    <p>{{empty($user->date_of_birth) ? 'Non renseigné' : $user->date_of_birth}}</p>
                </div>
                <div class="col-6">
                    <h5>Prénom</h5>
                    <p>{{empty($user->name) ? 'Non renseigné' : $user->name}}</p>
                </div>
                <div class="col-6">
                    <h5>Nom</h5>
                    <p>{{empty($user->surname) ? 'Non renseigné' : $user->surname}}</p>
                </div>
                <div class="col-6">
                    <h5>Email</h5>
                    <p>{{empty($user->email) ? 'Non renseigné' : $user->email}}</p>
                </div>
                <div class="col-6">
                    <h5>Numéro de téléphone</h5>
                    <p>{{empty($user->phone_number) ? 'Non renseigné' : $user->phone_number}}</p>
                </div>
            </div>
        </div>

        <div class="col"></div>

        <div class="col-12">
            <br>
            <hr>
            <h5>Équipe(s)</h5>
            <br>
            @if(count($user->teams) == 0)

                <h5>Aucune équipe pour le momment</h5>
            @else
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
                    @foreach($user->teams as $team)
                        <tr>
                            <th scope="row">{{$team->id}}</th>
                            <td>{{$team->name}}</td>
                            <td><a href="/backoffice/teams/{{$team->id}}/users">{{count($team->users) }} <i
                                            class="fas fa-eye"></i></a></td>
                            <td><a href="/backoffice/teams/edit/{{$team->id}}"><i class="fas fa-edit"></i></a></td>
                            <td><a href="/backoffice/teams/user/delete/{{$user->id}}"><i class="fas fa-times"
                                                                                         style="color:red;"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection