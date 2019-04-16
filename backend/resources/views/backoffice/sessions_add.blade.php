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
                <input type="text" class="form-control" id="session_label" name="session_label" value="{{old('session_label')}}">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" style="width:100%;">Ajouter</button>
            </div>
        </form>

    </div>
</div>
@endsection