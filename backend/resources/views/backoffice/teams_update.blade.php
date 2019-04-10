@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Modifier une équipe</h3>
            @if(session('result'))
                @if(session('result') == 1)
                    <p class="alert alert-success animated bounceInRight">
                        {{session('message')}}
                    </p>
                @endif
            @endif
            <form action="/backoffice/teams/edit/{{request('id')}}/update" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Nom de l'équipe</label>
                    <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{$team->name}}" required>
                    @foreach($errors->get('name') as $message)
                        <p class="animated shake invalid-feedback">{{$message}}</p>
                    @endforeach
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" style="width:100%">Modifier</button>
                </div>
                <div class="form-group">
                    <h4>Utilisateurs :</h4>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nom d'utilisateur</th>
                            <th scope="col">Email</th>
                            <th scope="col">N° Téléphone</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Date de naissance</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($team->users as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->username}}</td>
                                <td>{{empty($user->email) ? '-' : $user->email}}</td>
                                <td>{{empty($user->phone_number) ? '-' : $user->phone_number}}</td>
                                <td>{{empty($user->name) ? '-' : $user->name}}</td>
                                <td>{{empty($user->surname) ? '-' : $user->surname}}</td>
                                <td>{{empty($user->date_of_birth) ? '-' : $user->date_of_birth}}</td>
                                <td><a href="/backoffice/users/edit/{{$user->id}}"><i class="fas fa-edit"></i></a></td>
                                <td><a href="/backoffice/teams/user/delete/{{$user->id}}"><i class="fas fa-times"
                                                                                        style="color:red;"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@endsection