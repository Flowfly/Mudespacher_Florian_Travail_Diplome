@extends('backoffice/layout')
@section('content')
    <div class="row">
        <form action="/backoffice/change-theme" method="post" style="margin-right: 1%; display: flex;" class="col-12">

            <div class="col-2"></div>
            <div class="col-2">
                <h5>Changer de thème</h5>
            </div>
            <div class="col-4">

                @csrf
                <select name="theme" class="form-control">
                    <option value="1">Basique</option>
                    <option value="2">Darkly</option>
                    <option value="3">Flatly</option>
                    <option value="4">Slate</option>
                </select>
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Changer</button>
            </div>
            <div class="col"></div>
        </form>
        <div class="col-12">
            <hr style="margin: 2% 0 2% 0;">
        </div>
        @if(session('result'))
            @if(session('result') == 1)
                <div class="alert alert-success animated bounceInRight col-12">
                    {{session('message')}}
                </div>
            @endif
        @endif
        <form action="/backoffice/change-password" method="post" class="col-12" style="display: flex;">
            @csrf
            <div class="col-2"></div>
            <div class="col-2">
                <h5>Changer le mot de passe</h5>
            </div>
            <div class="col-4">
                <input type="password" name="password"
                       class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                       placeholder="Mot de passe">
                @foreach($errors->get('password') as $message)
                    <p class="invalid-feedback">{{$message}}</p>
                @endforeach
                <input type="password" name="password_confirmation" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                       placeholder="Confirmez le mot de passe" style="margin-top: 2%;">
                @foreach($errors->get('password_confirmation') as $message)
                    <p class="invalid-feedback">{{$message}}</p>
                @endforeach
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Changer</button>
            </div>
            <div class="col"></div>
        </form>
    </div>
@endsection