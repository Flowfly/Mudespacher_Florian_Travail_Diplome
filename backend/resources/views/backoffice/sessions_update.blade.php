@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            @if(session('result'))
                <div class="alert alert-{{session('result') == 'success' ? 'success' : 'danger'}} animated bounceInRight">
                    {{session('message')}}
                </div>
            @endif
            <form action="/backoffice/sessions/edit/{{request('id')}}/update" method="post">
                @csrf
                <div class="form-group">
                    <label for="session_label">Libellé</label>
                    <input type="text" class="form-control {{$errors->has('session_label') ? 'is-invalid' : ''}}"
                           id="session_label" name="session_label"
                           value="{{$session->label}}">
                    @if($errors->has('session_label'))
                        @foreach($errors->get('session_label') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="tag">Catégorie de la session</label>
                    <select name="tag" id="tag"
                            class="form-control {{$errors->has('tag') ? 'is-invalid' : ''}}">
                        <option value="0" {{$session->tag_id == null ? 'selected' : ''}}>Aucune</option>
                        @foreach($tags as $tag)
                            @if($session->tag != null)
                                <option value="{{$tag->id}}" {{$tag->id == $session->tag->id ? 'selected' : ''}}>{{$tag->label}}</option>
                            @else
                                <option value="{{$tag->id}}">{{$tag->label}}</option>
                            @endif
                        @endforeach
                    </select>
                    @if($errors->has('tag'))
                        @foreach($errors->get('tag') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" style="width: 100%;">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
@endsection