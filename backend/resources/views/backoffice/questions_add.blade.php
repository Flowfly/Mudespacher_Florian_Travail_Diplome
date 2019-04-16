@extends('backoffice/layout')
@section('content')
    <div class="row">
        <div class="col-12">
            <h3>
                Ajouter une nouvelle question :
            </h3>
            @if(session('result'))
                @if(session('result') == 1)
                    <div class="alert alert-success animated bounceInRight col-12">
                        {{session('message')}}
                    </div>
                @endif
            @endif
            <form action="../post-question" method="post">
                @csrf
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
                    <label for="question_type">Type :</label>
                    <select class="form-control {{$errors->has('question_type') ? 'is-invalid' : ''}}" name="question_type" id="question_type" required>
                        @foreach($types as $type)
                            <option value="{{$type->id}}">{{$type->label}}</option>
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

                <div class="col-12">
                    <span>Nombre de réponses : </span>
                    <span id="proposition-number">2</span>
                    <span>
                            <span class="btn btn-success" onclick="addProposition()"><i class="fas fa-plus"></i></span>
                            <span class="btn btn-danger" onclick="removeProposition()"><i
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
    <script>
        const MIN_PROPOSITION_NUMBER = 1; //0 means 1 answer, 1 means 2 answers etc.
        const MAX_PROPOSITION_NUMBER = 3; //3 means 4 answers, 5 means 6 answers etc.

        function addProposition() {
            var group = document.querySelector('#proposition-group');
            var lastId = (parseInt(group.lastElementChild.id.split('-')[1]) + 1);
            if (lastId <= MAX_PROPOSITION_NUMBER) {
                //Creation of the text input that allows to add the text of the proposition
                var inputTextToAdd = document.createElement('input');
                inputTextToAdd.setAttribute('type', 'text');
                inputTextToAdd.setAttribute('class', 'form-control col-10');
                inputTextToAdd.setAttribute('name', 'prop-' + lastId);
                inputTextToAdd.setAttribute('required', true);

                //Creation of the radio input that allows to set if the proposition is the right one or not
                var inputRadioToAdd = document.createElement('input');
                inputRadioToAdd.setAttribute('type', 'radio');
                inputRadioToAdd.setAttribute('name', 'isGoodAnswer');
                inputRadioToAdd.setAttribute('class', 'form-control col-1');
                inputRadioToAdd.setAttribute('value', lastId);

                //Creation of the container
                var container = document.createElement('div');
                container.setAttribute('id', 'prop-' + lastId);
                container.setAttribute('style', 'display:flex;');
                container.setAttribute('class', 'form-group');

                //Adding the elements into the container
                container.appendChild(inputTextToAdd);
                container.appendChild(inputRadioToAdd);
                container.innerHTML += "Bonne réponse";
                //Adding the container to the group
                group.appendChild(container);


                //Changing the text "Number of elements"
                document.querySelector('#proposition-number').innerHTML = parseInt(lastId) + 1;
            }

        }

        function removeProposition() {
            var group = document.querySelector('#proposition-group');
            var lastId = group.lastElementChild.id.split('-')[1];
            if (lastId > MIN_PROPOSITION_NUMBER) {
                var lastElement = group.lastElementChild;
                group.removeChild(lastElement);
                document.querySelector('#proposition-number').innerHTML = lastId;
            }
        }
    </script>
@endsection