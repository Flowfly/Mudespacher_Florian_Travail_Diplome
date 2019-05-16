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
                            var fontSize = "";

                            document.querySelector('#question-label').innerHTML = this.question.label;
                            var propositions = document.querySelector('#propositions');
                            propositions.innerHTML = "";
                            for (var i = 0; i < this.question.propositions.length; i++) {
                                if(this.question.propositions[i].label.length <= 10)
                                {
                                    fontSize = `font-size:30pt`;
                                }
                                else if(this.question.propositions[i].label.length <= 20)
                                {
                                    fontSize = `font-size:25pt`;
                                }
                                else if(this.question.propositions[i].label.length <= 30)
                                {
                                    fontSize = `font-size:20pt`;
                                }
                                else if(this.question.propositions[i].label.length <= 40)
                                {
                                    fontSize = `font-size:15pt`;
                                }
                                else{
                                    fontSize = `font-size:10pt`;
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