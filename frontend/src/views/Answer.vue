<template>
    <v-container fluid fill-height d-block v-if="questionData !== null" class="answer-main">
        <waiting v-show="isWaiting"/>
        <v-layout row wrap v-show="!isWaiting" class="answer-container">
            <v-layout align-center justify-center d-inline-block class="hcenter">
                <v-flex style="text-align: center;">
                    <h2 v-model="timeToWait">Temps restant : {{timeToWait}}</h2>
                </v-flex>
                <v-flex style="text-align: center;">
                    <h1>Question à {{questionData.points}} points !</h1>
                    <h1>{{questionData.label}}</h1>
                </v-flex>
                <center>
                    <v-flex v-for="(value, key) in questionData.propositions"
                            style="height:160px;" class="answer" :id="`bubble-${key}`">
                            <answercomponent :propositionNumber="key" :question="questionData"
                                             @clicked-from-child="answerQuestion"
                            />
                    </v-flex>
                </center>

            </v-layout>
        </v-layout>
    </v-container>
</template>

<script>
    import waiting from '../components/Waiting';
    import CONST from '../CONST';
    import answercomponent from '../components/AnswerComponent';
    import {mapActions, mapGetters, mapMutations} from 'vuex';
    import Echo from 'laravel-echo';

    window.Pusher = require('pusher-js');
    window.Echo = new Echo({
        broadcaster: CONST.WEB_SOCKET_SERVICE.broadcaster,
        key: CONST.WEB_SOCKET_SERVICE.key,
        cluster: CONST.WEB_SOCKET_SERVICE.cluster,
        encrypted: CONST.WEB_SOCKET_SERVICE.encrypted,
    });
    var timerTest = null;

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
            timeToWait: CONST.TIME_TO_ANSWER,
            timer: null,
            falseAnswerId: null,
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
                console.log(this.canClick);
                if (this.canClick) {

                    this.canClick = false;
                    for (var i = 0; i < this.questionData.propositions.length; i++) {
                        if (this.questionData.propositions[i].is_right_answer === 0)
                            document.querySelector(`#bubble-${i}`).style.backgroundImage = `url('../${require('../assets/img/answer_error.png')}')`;
                        else
                            document.querySelector(`#bubble-${i}`).style.backgroundImage = `url('../${require('../assets/img/answer_success.png')}')`;
                    }
                    setTimeout(() => {
                        var infos = {
                            'proposition_id': event[0],
                            'user_id': this.UserInfos.id,
                            'session_id': this.SessionId,
                        };
                        this.userAnswer(infos)
                            .done((response) => {
                                if (response.status === 'success') {
                                    this.clearTimer();
                                } else {
                                    this.canClick = !this.canClick;
                                }
                            })
                            .fail((error) => {

                                this.canClick = !this.canClick;
                                console.log(error);
                            })
                            .always(() => {
                                this.isWaiting = !this.isWaiting;
                                for (var i = 0; i < this.questionData.propositions.length; i++) {
                                    document.querySelector(`#bubble-${i}`).style.backgroundImage = `url('../${require('../assets/img/answer.png')}')`;
                                }
                            })
                    }, 1000);
                }
            },
            waitingTimeCheck() {
                if (this.timeToWait === 0) {
                    console.log('timer fini');
                    this.clearTimer();
                    for (var i = 0; i < this.questionData.propositions.length; i++) {
                        if (this.questionData.propositions[i].is_right_answer === 0) {
                            this.falseAnswerId = this.questionData.propositions[i].id;
                            break;
                        }
                    }
                    let infos = {
                        'proposition_id': this.falseAnswerId,
                        'user_id': this.UserInfos.id,
                        'session_id': this.SessionId,
                    };
                    this.userAnswer(infos)
                        .done((response) => {
                            if (response.status === 'success') {
                                this.isWaiting = !this.isWaiting;
                            }
                        })
                        .fail((error) => {
                            console.log(error);
                        });
                } else {
                    console.log('timer -1');
                    this.timeToWait = this.timeToWait - 1;
                }
            },
            clearTimer() {
                console.log('timer cleared');
                clearInterval(this.timer);
                this.timeToWait = CONST.TIME_TO_ANSWER;
            },
            listen() {
                window.Echo.channel(`finish-game-${this.SessionId}`)
                    .listen('FinishGame', () => {
                        window.Echo.leave(`session-${this.SessionId}`);
                        window.Echo.leave(`change-question-${this.SessionId}`);
                        console.log('partie terminée');
                        this.clearTimer();
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
                window.Echo.channel(`session-${this.SessionId}`)
                    .listen('StartSession', () => {
                        console.log('session démarrée');
                        this.isWaiting = false;
                        this.timer = window.setInterval(this.waitingTimeCheck, 1000);
                    });
                window.Echo.channel(`change-question-${this.SessionId}`)
                    .listen('ChangeQuestion', (response) => {
                        console.log('question changée');
                        this.timer = setInterval(this.waitingTimeCheck, 1000);
                        this.questionData = response.question;
                        this.isWaiting = !this.isWaiting;
                        this.canClick = true;
                    });
            },
            ...mapActions(['getActualQuestion', 'userAnswer', 'getScore']),
            ...mapMutations(['setSessionId', 'setUserResult']),
        },
        mounted() {
            this.listen();
            this.isWaiting = true;
            this.fillAnswerComponents();
        },
        beforeMount() {
            //console.log(require('../assets/img/bubble_error.png'))
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

    .answer-main {
        height: 100%;
    }

    @media (max-width: 575.98px) {
        .answer{
            height:70%;
            width:70%;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position:relative;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .answer{
            height:90%;
            width:70%;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position:relative;
        }
    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .answer{
            height:90%;
            width:70%;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position:relative;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .answer{
            height:90%;
            width:70%;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position:relative;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .answer{
            height:77%;
            width:65%;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position:relative;
        }
    }
</style>