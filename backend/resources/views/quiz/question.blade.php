@extends('quiz/layout')
@section('content')
    <div>
        <div style="width:100%;">
            <h1 class="question-title" id="question-label" style="font-weight: bold;">{{$question->label}}</h1>
            <div hidden id="question-type" value="{{$question->type_id}}"></div>
            <hr>
        </div>
        <div class="propositions" id="propositions">
            @for($i = 0; $i < count($question->propositions); $i++)
                <div class="bubble-container"
                     style="background-image: url({{asset("../../img/quiz/answer" . ($i+1) . ".png")}})">
                    <p class="bubble-text"
                       id="proposition-{{$i}}">{{$question->propositions[$i]->label}}</p>
                </div>
            @endfor
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const app = new Vue({
            el: '#app',
            data: () => ({
                question: {},
                sound: new Audio(),
            }),
            methods: {
                listen() {
                    Echo.channel('change-question-{!! request('session_id') !!}')
                        .listen('ChangeQuestion', (result) => {
                            this.question = result.question;
                            this.sound.pause();
                            var fontSize = "";

                            document.querySelector('#question-label').innerHTML = this.question.label;
                            var propositions = document.querySelector('#propositions');
                            propositions.innerHTML = "";
                            for (var i = 0; i < this.question.propositions.length; i++) {
                                if (this.question.propositions[i].label.length <= 15) {
                                    fontSize = `font-size:2.7rem`;
                                } else if (this.question.propositions[i].label.length <= 25) {
                                    fontSize = `font-size:2.5rem`;
                                } else if (this.question.propositions[i].label.length <= 35) {
                                    fontSize = `font-size:2rem`;
                                } else {
                                    fontSize = `font-size:1.5rem`;
                                }
                                var bubbleContainer = document.createElement('div');
                                bubbleContainer.setAttribute('class', `bubble-container col-${12 / parseInt(this.question.propositions.length)}`);
                                bubbleContainer.setAttribute('style', `background-image: url(../../img/quiz/answer${parseInt(i + 1)}.png);`);
                                var proposition = document.createElement('p');
                                proposition.setAttribute('class', 'hcenter bubble-text');
                                proposition.setAttribute('style', `${fontSize}`);
                                proposition.innerHTML = this.question.propositions[i].label;
                                bubbleContainer.appendChild(proposition);
                                propositions.appendChild(bubbleContainer);
                                this.questionTypeCheck();
                            }
                        });
                    Echo.channel('finish-game-{!! request('session_id') !!}')
                        .listen('FinishGame', () => {
                            document.location.href = "/{!! request('session_id') !!}/end";
                        });
                },
                questionTypeCheck() {
                    if (document.querySelector('#question-type').getAttribute('value') === '3') {
                        this.sound.setAttribute('src', '{!! asset('../../assets/sounds/questions/' . $question->file) !!}');
                        console.log(this.sound);
                        this.sound.load();
                        this.sound.play();
                    } else {
                        console.log(document.querySelector('#question-type').getAttribute('value'));
                    }
                },
            },
            mounted() {
                this.questionTypeCheck();
                this.listen();
            }
        })
    </script>


@endsection