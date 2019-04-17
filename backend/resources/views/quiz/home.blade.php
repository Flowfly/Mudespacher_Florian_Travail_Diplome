@extends('quiz/layout')
@section('content')
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
        <form action="/{{request('session_id')}}" method="post">
            @csrf
            <input type="image" src="{{asset('../../img/quiz/btn_play.png')}}" alt="button start" class="btn-start">
        </form>
    </div>
@endsection
@section('scripts')
    <script defer>
        const app = new Vue({
            el: '#app',
            data: () => ({
                users: [],
            }),
            methods: {
                listen() {
                    Echo.channel('user-registration-{!! request('session_id') !!}')
                        .listen('UserRegistred', (user) => {
                            this.users.push(user);
                        })
                }
            },
            mounted() {
                this.listen();
            }
        });
    </script>

@endsection
