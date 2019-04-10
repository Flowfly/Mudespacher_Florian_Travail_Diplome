<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"
          type="text/css">
    <link rel="stylesheet" href="{{asset('../../css/style.css')}}" type="text/css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-12" style="text-align: center;">
            <br>
            <h2>Coordonnées des utilisateurs</h2>
            <br>
            <table class="table table-striped" style="border: solid black 1px;">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom d'utilisateur</th>
                    <th scope="col">Email</th>
                    <th scope="col">N° Téléphone</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Date de naissance</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->username}}</td>
                        <td>{{empty($user->email) ? '-' : $user->email}}</td>
                        <td>{{empty($user->phone_number) ? '-' : $user->phone_number}}</td>
                        <td>{{empty($user->name) ? '-' : $user->name}}</td>
                        <td>{{empty($user->surname) ? '-' : $user->surname}}</td>
                        <td>{{empty($user->date_of_birth) ? '-' : $user->date_of_birth}}</td>
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
    </div>
</div>
</body>
</html>