@extends('backoffice/layout')
@section('content')

    <div class="row">
        <div class="col-12">
            <form action="../post-type" method="post">
                @csrf
                <div class="form-group">
                    @if(session('result'))
                        @if(session('result') == 1)
                            <p class="alert alert-success animated bounceInRight">
                                {{session('message')}}
                            </p>
                        @endif
                    @endif
                    <h3>
                        <label label for="name">Ajouter un nouveau type :</label>
                    </h3>
                </div>
                <div class="form-group">
                    <input class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" type="text" required name="name" id="name"
                           value="{{old('name')}}">
                    @if($errors->has('name'))
                        @foreach($errors->get('name') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Ajouter</button>


                </div>
            </form>
        </div>
    </div>

@endsection