<template>
    <v-container fluid fill-height d-block v-if="questionData !== null" style="height: 100%;">
        <waiting v-show="isWaiting"/>
        <v-layout row wrap v-show="!isWaiting">
            <v-layout align-center justify-center d-inline-block class="hcenter">
                <v-flex style="text-align: center;">
                    <h1>Question à {{questionData.points}} points !</h1>
                    <h1>{{questionData.label}}</h1>
                </v-flex>
                <v-layout row wrap align-center justify-center v-for="(value, key) in questionData.propositions"
                          style="height:160px;">
                    <center style="width:100%; height:100%;">
                        <answercomponent :propositionNumber="key" :question="questionData"
                                         @clicked-from-child="answerQuestion"
                        />
                    </center>

                </v-layout>
            </v-layout>
        </v-layout>
    </v-container>
</template>

<script>
    import waiting from '../components/Waiting';
    import answercomponent from '../components/AnswerComponent';
    import {mapActions, mapGetters, mapMutations} from 'vuex';
    import Echo from 'laravel-echo';
    window.Pusher = require('pusher-js');
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'c04beebc0bd8d8c9866f',
        cluster: 'eu',
        encrypted: true,
    });

    export default {
        name: "Answer",
        components: {
            waiting,
            answercomponent,
        },
        data: () => ({
            questionData: null,
            isWaiting: false,
            canClick: true,
        }),
        computed: {
            ...mapGetters(['SessionId', 'UserInfos']),
        },
        methods: {
            fillAnswerComponents() {
                this.getActualQuestion(this.SessionId)
                    .done((response) => {
                        this.questionData = response.data;
                    })
                    .fail((error) => {
                        console.log(error);
                    })
            },
            answerQuestion(event) {
                if(this.canClick)
                {
                    for(var i = 0; i < this.questionData.propositions.length; i++)
                    {
                        //success = bc5a2691
                        //error = 15813d9f
                        //normal = ff91df6b
                        if(this.questionData.propositions[i].is_right_answer === 0)
                            document.querySelector(`#bubble-${i}`).style.backgroundImage = "url('../img/bubble_error.15813d9f.png')";
                        else
                            document.querySelector(`#bubble-${i}`).style.backgroundImage = "url('../img/bubble_success.bc5a2691.png')";
                    }
                    setTimeout(()=>{
                        for(var i = 0; i < this.questionData.propositions.length; i++)
                        {
                            document.querySelector(`#bubble-${i}`).style.backgroundImage = "url('../img/bubble.ff91df6b.png')";
                        }
                    }, 500);
                    this.canClick = false;
                    /**/
                    var infos = {
                        'proposition_id': event[0],
                        'user_id': this.UserInfos.id,
                        'session_id': this.SessionId,
                    };
                    this.userAnswer(infos)
                        .done((response) => {
                            if(response.status === 'success')
                            {
                                this.isWaiting = !this.isWaiting;
                            }
                            else{
                                this.isWaiting = !this.isWaiting;
                                this.canClick = !this.canClick;
                            }
                        })
                        .fail((error) => {
                            this.isWaiting = !this.isWaiting;
                            this.canClick = !this.canClick;
                            console.log(error);
                        })
                }
                //this.isWaiting = !this.isWaiting;
            },
            listen() {
                window.Echo.channel(`session-${this.SessionId}`)
                    .listen('StartSession', () => {
                        this.isWaiting = false;
                    });
                window.Echo.channel(`change-question-${this.SessionId}`)
                    .listen('ChangeQuestion', (response) => {
                        console.log(response);
                        this.isWaiting = !this.isWaiting;
                        this.questionData = response.question;
                        this.canClick = true;
                    });
                window.Echo.channel(`finish-game-${this.SessionId}`)
                    .listen('FinishGame', () => {
                        var infos = {
                            'user_id': this.UserInfos.id,
                            'session_id': this.SessionId,
                        };
                        this.getScore(infos)
                            .done((response) => {
                                this.setUserResult({
                                    numberOfCorrectAnswers: response.correctAnswers,
                                    score: response.score,
                                });
                                this.$router.push('/end');
                            })
                            .fail((error) => {
                                console.log(error);
                            });
                    });
            },
            ...mapActions(['getActualQuestion', 'userAnswer', 'getScore']),
            ...mapMutations(['setSessionId', 'setUserResult']),
        },
        mounted(){
            this.listen();
            this.isWaiting = true;
            this.fillAnswerComponents();
        },
        beforeMount() {
        },

    }
</script>

<style scoped>
    .hcenter {
        position: absolute;
        top: 50%;
        margin: 0 -50% 0 0;
        transform: translate(-50%, -50%);
        left: 50%;
    }
</style>