@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            @if(session('result'))
                @if(session('result') == 1)
                    <div class="alert alert-success animated bounceInRight col-12">
                        {{session('message')}}
                    </div>
                @endif
            @endif
            <h3>
                Ajouter une nouvelle question :
            </h3>
            <form action="../post-question" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="question_type">Type :</label>
                    <select class="form-control {{$errors->has('question_type') ? 'is-invalid' : ''}}" name="question_type" id="question_type" required>
                        @foreach($types as $type)
                            <option {{old('question_type') == $type->id ? 'selected' : ''}} value="{{$type->id}}">{{$type->label}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('question_type'))

                        @foreach($errors->get('question_type') as $message)
                            <div class="col-6">
                                <p class="animated shake invalid-feedback">{{$message}}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="question_label">Texte :</label>
                    <input type="text" name="question_label" id="question_label" class="form-control {{$errors->has('question_label') ? 'is-invalid' : ''}}" required
                           value="{{old('question_label')}}">
                    @if($errors->has('question_label'))
                        @foreach($errors->get('question_label') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="question_points">Points :</label>
                    <input type="number" class="form-control {{$errors->has('question_points') ? 'is-invalid' : ''}}" min="0" max="100" id="question_points"
                           name="question_points" required value="{{old('question_points')}}">

                    @if($errors->has('question_points'))
                    @foreach($errors->get('question_points') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="question_tag">Catégorie :</label>
                    <select class="form-control {{$errors->has('question_tag') ? 'is-invalid' : ''}}" name="question_tag" id="question_tag" required>
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}">{{$tag->label}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('question_tag'))
                        @foreach($errors->get('question_tag') as $message)
                            <div class="col-6">
                                <p class="animated shake invalid-feedback">{{$message}}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="form-group" id="optional-field">

                </div>

                <div class="col-12">
                    <span>Nombre de réponses : </span>
                    <span id="proposition-number">2</span>
                    <span>
                            <span class="btn btn-success" id="add-proposition"><i class="fas fa-plus"></i></span>
                            <span class="btn btn-danger" id="remove-proposition"><i
                                        class="fas fa-minus"></i></span>
                        </span>
                </div>
                <br>
                <div id="proposition-group">
                    <div id="prop-0" style="display:flex;" class="form-group">
                        <input type="text" class="form-control col-10" name="prop-0" required
                               value="{{old('prop-0')}}">
                        <input name="isGoodAnswer" value="0" type="radio" class="form-control col-1" checked> Bonne
                        réponse
                    </div>
                    <div id="prop-1" style="display:flex; " class="form-group">
                        <input type="text" class="form-control col-10" name="prop-1" required
                               value="{{old('prop-1')}}">
                        <input name="isGoodAnswer" value="1" type="radio" class="form-control col-1"> Bonne réponse
                    </div>
                </div>
                @if(!$errors->get('question_label') && !$errors->get('question_points') && !$errors->get('question_tag') && !$errors->get('question_type') && !$errors->get('tag_name') && !$errors->get('type_name'))
                    @foreach($errors->all() as $message)
                        <div class="col-10">
                            <br>
                            <p class="animated shake alert alert-danger">{{$message}}</p>
                        </div>
                    @endforeach
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
            <br>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('../../js/scripts.js')}}"></script>
    <script>
        $(document).ready(() => {
            checkQuestionType(document.querySelector('#question_type').value, $('#optional-field'), false);
            $("#question_type").on('change', () => {
                checkQuestionType(document.querySelector('#question_type').value, $('#optional-field'), false);
            });
            $('#add-proposition').on('click', () => {
                addProposition(document.querySelector('#proposition-group'), false);
            });
            $('#remove-proposition').on('click', () => {
                removeProposition(document.querySelector('#proposition-group'));
            })
        });
    </script>
@endsection