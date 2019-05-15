@extends('quiz/layout')
@section('content')
    <div class="row">
        <div class="col"></div>
        <div class="col-10">
            <h1 id="question-label" style="font-weight: bold;">{{$question->label}}</h1>
            <hr>
        </div>
        <div class="col"></div>
    </div>
        <div class="row">
            <div class="col"></div>
            <div class="propositions col-10" id="propositions">
                @for($i = 0; $i < count($question->propositions); $i++)
                    <div class="bubble-container col-{{12/count($question->propositions)}}"
                         style="background-image: url({{asset("../../img/quiz/answer" . ($i+1) . ".png")}})">
                        <p class="hcenter bubble-text"
                           id="proposition-{{$i}}">{{$question->propositions[$i]->label}}</p>
                    </div>
                @endfor
            </div>
            <div class="col"></div>
        </div>


@endsection

@section('scripts')
    <script>
        const app = new Vue({
            el: '#app',
            data: () => ({
                question: {},
            }),
            methods: {
                listen() {
                    Echo.channel('change-question-{!! request('session_id') !!}')
                        .listen('ChangeQuestion', (result) => {
                            this.question = result.question;
                            document.querySelector('#question-label').innerHTML = this.question.label;
                            var propositions = document.querySelector('#propositions');
                            propositions.innerHTML = "";
                            for (var i = 0; i < this.question.propositions.length; i++) {
                                var col12 = document.createElement('div');
                                col12.setAttribute('class', 'col-12');
                                var center = document.createElement('center');
                                var bubbleContainer = document.createElement('div');
                                bubbleContainer.setAttribute('class', 'bubble-container');
                                bubbleContainer.setAttribute('style', `background-image: url(../../img/quiz/answer${parseInt(i + 1)}.png)`);
                                var bubbleText = document.createElement('div');
                                bubbleText.setAttribute('class', 'hcenter bubble-text');
                                var proposition = document.createElement('p');
                                proposition.setAttribute('class', 'hcenter');
                                proposition.innerHTML = this.question.propositions[i].label;
                                bubbleText.appendChild(proposition);
                                bubbleContainer.appendChild(bubbleText);
                                center.appendChild(bubbleContainer);
                                col12.appendChild(center);
                                propositions.appendChild(col12);
                            }
                        });
                    Echo.channel('finish-game-{!! request('session_id') !!}')
                        .listen('FinishGame', () => {
                            document.location.href = "/{!! request('session_id') !!}/end";
                        });
                }
            },
            mounted() {
                this.listen();
            }
        })
    </script>


@endsection