@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <h2>Modifier la question</h2>
        </div>
        <div class="col-12">
            <form action="{{request('id')}}/update" method="post">
                @csrf
                <div class="form-group">
                    <label for="question_label">Question :</label>
                    <input type="text" class="form-control {{$errors->has('question_label') ? 'is-invalid' : ''}}" id="question_label" name="question_label"
                           value="{{$question->label}}">
                    @if($errors->has('question_label'))
                        @foreach($errors->get('question_label') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="question_points">Points :</label>
                    <input type="number" class="form-control {{$errors->has('question_points') ? 'is-invalid' : ''}}" id="question_points" name="question_points" min="0"
                           max="100" value="{{$question->points}}">
                    @if($errors->has('question_points'))
                        @foreach($errors->get('question_points') as $message)
                            <p class="animated shake invalid-feedback">{{$message}}</p>
                        @endforeach
                    @endif
                </div>
                <div class="form-group">
                    <label for="question_type">Type :</label>
                    <select type="text" class="form-control {{$errors->has('question_type') ? 'is-invalid' : ''}}" id="question_type" name="question_type">
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
                    <select type="text" class="form-control {{$errors->has('question_tag') ? 'is-invalid' : ''}}" id="question_tag" name="question_tag">
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

                <label>Propositions :</label>
                @if(count($question->propositions) == 0)
                    <p>Aucune réponse pour cette question.</p>
                @else
                    @foreach($question->propositions as $proposition)
                        <div class="form-group" style="display: flex;">
                            <input type="text" class="form-control {{$errors->has("prop-$proposition->id") ? 'is-invalid' : ''}} col-10" id="prop-{{$proposition->id}}"
                                   name="prop-{{$proposition->id}}" value="{{$proposition->label}}">
                            <input type="radio" name="isGoodAnswer"
                                   {{$proposition->is_right_answer == 1 ? 'checked' : ''}} value="{{$proposition->id}}"
                                   class="form-control col-1"> Bonne réponse
                            @if($errors->has('isGoodAnswer'))
                                @foreach($errors->get("isGoodAnswer") as $message)
                                    <p class="animated shake invalid-feedback">{{$message}}</p>
                                @endforeach
                            @endif
                            <br>
                        </div>
                    @endforeach
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
            @if(session('result'))
                @if(session('result') == 1)
                    <div class="alert alert-success animated bounceInRight col-12">
                        {{session('message')}}
                    </div>
                @endif
            @endif
        </div>

        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach

    </div>
@endsection