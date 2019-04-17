@extends('quiz/layout')
@section('content')
    <div class="col-12" v-show="isGameStarting">
        <h1>La partie va commencer dans :</h1>
        <div id="left-time-container">
            <h2 id="left-time" class="animated fadeIn">@{{ leftTime }}</h2>
        </div>
    </div>
    <div class="col-12" v-show="!isGameStarting">
        <div class="col-12">
            <h1>Bienvenue dans le quiz de Digital Turn !</h1>
            <h1>Veuillez vous munir d'une tablette et vous inscrire pour participer</h1>
        </div>
        <hr>
        <div class="col-12">
            <h2>Participants :</h2>
            @if(count($users) == 0)
                <h3 v-if="users.length <= 0">Aucun participant pour le moment</h3>
                <h3 class="animated bounceInRight" v-else v-for="(value, key) in users">
                    @{{users[key].user.username }}</h3>
            @else
                <div>
                    @for($i = 0; $i < count($users); $i++)
                        <h3 class="animated {{$i % 2 == 0 ? 'bounceInRight' : 'bounceInLeft'}}">{{$users[$i]->username}}</h3>
                    @endfor
                    <h3 class="animated bounceInRight" v-if="users.length > 0" v-for="(value, key) in users">
                        @{{users[key].user.username }}</h3>
                </div>
            @endif
        </div>
        <div class="col-12">
        <!--<form action="/{{request('session_id')}}" method="post">
            csrf
            <input type="image" src="" alt="button start" class="btn-start">
        </form>-->
            <input type="image" src="{{asset('../../img/quiz/btn_play.png')}}" id="btn_start" class="btn-start" @click="startGame">
            </input>
        </div>
    </div>

@endsection
@section('scripts')
    <script
            src="https://code.jquery.com/jquery-3.4.0.min.js"
            integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
            crossorigin="anonymous"></script>
    <script defer>
        const TIME_BEFORE_START = 3;
        const URI = "/api/session/{!! request('session_id') !!}/start/";
        const app = new Vue({
            el: '#app',
            data: () => ({
                users: [],
                isGameStarting: false,
                leftTime: TIME_BEFORE_START,
                gameTimer: null,
            }),
            methods: {
                listen() {
                    Echo.channel('user-registration-{!! request('session_id') !!}')
                        .listen('UserRegistred', (user) => {
                            this.users.push(user);
                        })
                },
                startGame(){
                    this.isGameStarting = true;
                    this.gameTimer = setInterval(this.timerCheck, 1000);
                },
                timerCheck(){
                    if(this.leftTime === 0)
                    {
                        var settings = {
                            "url": URI,
                            "async": true,
                            "crossDomain": true,
                            "method": "POST",
                        };
                        $.ajax(settings)
                            .done((response) => {
                                if(response.status === 'success')
                                {
                                    clearInterval(this.gameTimer);
                                    document.location.href="/{!! request('session_id') !!}/question";
                                }
                            });
                    }
                    else {
                        var container = document.querySelector('#left-time-container');
                        container.removeChild(document.querySelector('#left-time'));
                        this.leftTime = this.leftTime - 1;
                        var leftTime = document.createElement('h2');
                        leftTime.setAttribute('class', 'animated fadeIn');
                        leftTime.setAttribute('id', 'left-time');
                        leftTime.innerHTML = this.leftTime;
                        container.appendChild(leftTime);
                    }
                }
            },
            mounted() {
                this.listen();
            }
        });
    </script>

@endsection
