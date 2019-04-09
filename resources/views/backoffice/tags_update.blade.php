@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{request('id')}}/update" method="post">
                <div class="form-group">
                    @csrf
                    <h3>
                        <label for="tag_name">Nom de la catégorie : </label>
                    </h3>
                    @if (session('result'))
                        @if(session('result') == 1)
                            <p class="alert alert-success animated bounceInRight">
                                {{session('message')}}
                            </p>
                        @endif
                    @endif
                </div>
                <div class="form-group">
                    <input class="form-control {{$errors->has('tag_name') ? 'is-invalid' : ''}}" type="text" name="tag_name" id="tag_name" required
                           value="{{$tag->label}}">

                    @if($errors->has('tag_name'))
                        @foreach($errors->get('tag_name') as $message)
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