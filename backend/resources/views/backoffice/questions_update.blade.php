@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Modifier la question</h2>
        </div>
        <div class="col-12">
            @if(session('result'))
                @if(session('result') == 1)
                    <div class="alert alert-success animated bounceInRight col-12">
                        {{session('message')}}
                    </div>
                @endif
            @endif
            <form action="{{request('id')}}/update" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="question_label">Question :</label>
                    <input type="text" class="form-control {{$errors->has('question_label') ? 'is-invalid' : ''}}"
                           id="question_label" name="question_label"
                           value="{{$question->label}}">
                    @if($errors->has('question_label'))
                        @foreach($errors->get('question_label') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="question_points">Points :</label>
                    <input type="number" class="form-control {{$errors->has('question_points') ? 'is-invalid' : ''}}"
                           id="question_points" name="question_points" min="0"
                           max="100" value="{{$question->points}}">
                    @if($errors->has('question_points'))
                        @foreach($errors->get('question_points') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="question_type">Type :</label>
                    <select type="text" class="form-control {{$errors->has('question_type') ? 'is-invalid' : ''}}"
                            id="question_type" name="question_type">
                        @foreach($types as $type)
                            <option value="{{$type->id}}" {{$type->id == $question->type->id ? "selected" : ""}}>{{$type->label}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('question_type'))
                        @foreach($errors->get('question_type') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                    <label for="question_tag">Catégorie :</label>
                    <select type="text" class="form-control {{$errors->has('question_tag') ? 'is-invalid' : ''}}"
                            id="question_tag" name="question_tag">
                        @foreach($tags as $tag)
                            <option value="{{$tag->id}}" {{$tag->id == $question->tag->id ? "selected" : ""}}>{{$tag->label}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('question_tag'))
                        @foreach($errors->get('question_tag') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group" id="optional-field">

                </div>
                <div class="form-group">
                    <label>Propositions :</label>
                    <span id="proposition-number">{{count($question->propositions)}}</span>
                    <span>
                            <span class="btn btn-success" id="add-proposition"><i class="fas fa-plus"></i></span>
                        </span>
                </div>

                @if(count($question->propositions) == 0)
                    <p>Aucune réponse pour cette question.</p>
                @else
                    <div id="proposition-group">
                        @for($i = 0; $i < count($question->propositions); $i++)
                            <div class="form-group" id="prop-{{$i}}" style="display: flex;">
                                <input type="text"
                                       class="form-control {{$errors->has("prop-" . $question->propositions[$i]->id) ? 'is-invalid' : ''}} col-10"
                                       name="prop-{{$question->propositions[$i]->id}}"
                                       value="{{$question->propositions[$i]->label}}">
                                <input type="radio" name="isGoodAnswer"
                                       {{$question->propositions[$i]->is_right_answer == 1 ? 'checked' : ''}} value="{{$question->propositions[$i]->id}}"
                                       class="form-control col-1"> Bonne réponse
                                @if($errors->has('isGoodAnswer'))
                                    @foreach($errors->get("isGoodAnswer") as $message)
                                        <p class="animated shake invalid-feedback">{{$message}}</p>
                                    @endforeach
                                @endif
                                <br>
                            </div>
                        @endfor
                    </div>

                @endif
                @if($errors->has("prop"))
                    @foreach($errors->get("prop") as $message)
                        <div class="form-group">
                            <p style="color:#DC3545">{{$message}}</p>
                        </div>
                    @endforeach
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Modifier</button>
                </div>
            </form>

        </div>

        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach

    </div>
@endsection
@section('scripts')
    <script src="{{asset('../../js/scripts.js')}}"></script>
    <script>
        $(document).ready(() => {
            checkQuestionType(document.querySelector('#question_type').value, $('#optional-field'));
            $('#question_type').on('change', () => {
                checkQuestionType(document.querySelector('#question_type').value, $('#optional-field'));
            });
            $('#add-proposition').on('click', () => {
                addProposition(document.querySelector('#proposition-group'));
            });
        });
    </script>
@endsection