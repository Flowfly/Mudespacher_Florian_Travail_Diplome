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
                <input type="text" class="form-control" id="session_label" name="session_label" value="{{$session->label}}">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" style="width: 100%;">Ajouter</button>
            </div>
        </form>
    </div>
</div>
@endsection