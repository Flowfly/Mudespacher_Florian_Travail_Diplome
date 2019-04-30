@extends('quiz/layout')
@section('content')
    <div class="col-12">
        <h1 id="question-label" style="font-weight: bold;">{{$question->label}}</h1>
    </div>
    <hr>
    <div class="col-12" id="propositions">
        @for($i = 0; $i < count($question->propositions); $i++)
            <div class="col-12">
                <center>
                    <div class="bubble-container" style="background-image: url({{asset("../../img/quiz/answer" . ($i+1) . ".png")}})">
                        <div class="hcenter bubble-text">
                            <p class="hcenter" id="proposition-{{$i}}">{{$question->propositions[$i]->label}}</p>
                        </div>
                    </div>
                </center>
            </div>
        @endfor
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
                            for(var i = 0; i < this.question.propositions.length; i++)
                            {
                                var col12 = document.createElement('div');
                                col12.setAttribute('class', 'col-12');
                                var center = document.createElement('center');
                                var bubbleContainer = document.createElement('div');
                                bubbleContainer.setAttribute('class', 'bubble-container');
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
                            document.location.href="/{!! request('session_id') !!}/end";
                        });
                }
            },
            mounted() {
                this.listen();
            }
        })
    </script>


@endsection