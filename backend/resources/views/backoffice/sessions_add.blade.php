@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            @if(session('result'))
                @if(session('result') == 1)
                    <div class="alert alert-success animated bounceInRight">
                        {{session('message')}}
                    </div>
                @endif
            @endif
            <form method="post" action="/backoffice/post-session">
                @csrf
                <div class="form-group">
                    <label for="session_label">Libellé</label>
                    <input type="text" class="form-control {{$errors->has('session_label') ? 'is-invalid' : ''}}" id="session_label" name="session_label"
                           value="{{old('session_label')}}">
                    @if($errors->has('session_label'))
                        @foreach($errors->get('session_label') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="tag">Catégorie de la session</label>
                    <select name="tag" id="tag" class="form-control {{$errors->has('session_label') ? 'is-invalid' : ''}}">
                        <option value="0" selected>Aucune</option>
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->label}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('tag'))
                        @foreach($errors->get('tag') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" style="width:100%;">Ajouter</button>
                </div>
            </form>

        </div>
    </div>
@endsection