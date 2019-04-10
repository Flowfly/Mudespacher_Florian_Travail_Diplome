@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{request('id')}}/update" method="post">
                @csrf
                <div class="form-group">
                    <h3>
                        <label label for="type_name">Modifier le type :</label>
                    </h3>
                    @if(session('result'))
                        @if(session('result') == 1)
                            <p class="alert alert-success animated bounceInRight">
                                {{session('message')}}
                            </p>
                        @endif
                    @endif
                </div>
                <div class="form-group">
                    <input class="form-control {{$errors->has('type_name') ? 'is-invalid' : ''}}" type="text" required
                           name="type_name" id="type_name"
                           value="{{$type->label}}">

                    @if($errors->has('type_name'))
                        @foreach($errors->get('type_name') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Modifier</button>
                </div>
            </form>
        </div>
    </div>
@endsection