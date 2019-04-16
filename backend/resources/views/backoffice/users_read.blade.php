@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="md-form mt-0">
                <input class="form-control" type="text" placeholder="Rechercher" aria-label="Search">
            </div>
            <br>
        </div>
        <div class="col-2">
            @if(request()->route()->getName() == "users_all")
                <p><a href="/backoffice/users/pdf/download">Télécharger en PDF</a> <img style="width:20px; height: 25px;" src="../../../img/backoffice/pdf_logo.png" alt=""></p>
            @endif
        </div>
        <div class="col"></div>
        <div class="col-12" style="text-align: center;">
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
                    <th scope="col"></th>
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
                        <td><a href="/backoffice/users/{{$user->id}}"><i
                                        class="fas fa-eye"></i></a></td>
                        <td><a href="/backoffice/users/edit/{{$user->id}}"><i class="fas fa-edit"></i></a></td>
                        <td><a href="{{request()->route()->getName() == "team_users" ? "/backoffice/teams/user/delete/$user->id" : "/backoffice/users/delete/$user->id"}}"><i class="fas fa-times"
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