@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <h3>Ajouter une équipe</h3>
            @if(session('result'))
                @if(session('result') == 1)
                    <p class="alert alert-success animated bounceInRight">
                        {{session('message')}}
                    </p>
                @endif
            @endif
            <form action="/backoffice/post-team" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Nom de l'équipe</label>
                    <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" id="name" name="name" value="{{old('name')}}" required>
                    @foreach($errors->get('name') as $message)
                        <p class="animated shake invalid-feedback">{{$message}}</p>
                    @endforeach
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" style="width:100%">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
@endsection