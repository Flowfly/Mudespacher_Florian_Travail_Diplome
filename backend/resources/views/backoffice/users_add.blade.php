@extends('backoffice/layout')
@section('content')
<div class="row">
    <div class="col-12">
        <h3>Ajouter un utilisateur</h3>
        @if(session('result'))
            @if(session('result') == 1)
                <div class="alert alert-success animated bounceInRight col-12">
                    {{session('message')}}
                </div>
            @endif
        @endif
        <form action="/backoffice/post-user" method="post">
            @csrf
            <div class="form-group">
                <label for="username">Nom d'utilisateur : *</label>
                <input type="text" class="form-control {{$errors->has('username') ? 'is-invalid' : ''}}" name="username" id="username" value="{{old('username')}}">
                @foreach($errors->get('username') as $message)
                    <p class="invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" id="password" name="password">
                @foreach($errors->get('password') as $message)
                    <p class="invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="form-group">
                <label for="password_confirmation">Mot de passe (confirmation):</label>
                <input type="password" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid' : ''}}" id="password_confirmation" name="password_confirmation">
                @foreach($errors->get('password_confirmation') as $message)
                    <p class="invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" id="email" name="email" value="{{old('email')}}">
                @foreach($errors->get('email') as $message)
                    <p class="invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="form-group">
                <label for="phone">Téléphone :</label>
                <input type="number" class="form-control {{$errors->has('phone') ? 'is-invalid' : ''}}" id="phone" name="phone" value="{{old('phone')}}">
                @foreach($errors->get('phone') as $message)
                    <p class="animated shake invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="form-group">
                <label for="name">Prénom :</label>
                <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{old('name')}}">
                @foreach($errors->get('name') as $message)
                    <p class="animated shake invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="form-group">
                <label for="surname">Nom :</label>
                <input type="text" class="form-control {{$errors->has('surname') ? 'is-invalid' : ''}}" id="surname" name="surname" value="{{old('name')}}">
                @foreach($errors->get('surname') as $message)
                    <p class="animated shake invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="form-group">
                <label for="date">Date de naissance :</label>
                <input type="date" class="form-control {{$errors->has('date') ? 'is-invalid' : ''}}" id="date" name="date" value="{{old('date')}}">
                @foreach($errors->get('date') as $message)
                    <p class="animated shake invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" style="width: 100%;">Ajouter</button>
            </div>
        </form>
    </div>
</div>
@endsection