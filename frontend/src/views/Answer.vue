<template>
    <v-container fluid fill-height d-block v-if="questionData !== null" class="answer-main">
        <v-layout row wrap justify-center style="text-align: center;" v-show="displayError">
            <v-flex xs8>
                <v-alert id="alert-box" :dismissible="true" @click="closeAlert" :value="true" color="error">
                    {{errorMessage}}
                </v-alert>
            </v-flex>
        </v-layout>
        <waiting :waiting-text="`En attente des autres joueurs`" v-if="questionData !== ''" v-show="isWaiting"/>


        <v-layout row wrap v-if="questionData !== ''" v-show="!isWaiting" class="answer-parent">
            <v-layout align-center justify-center class="answer-container">
                <v-flex style="text-align: center; display:flex; width:100%; justify-content: center;">
                    <h2 v-model="timeToWait" class="remaining-time">Temps restant : {{timeToWait}}</h2>
                </v-flex>
                <v-flex style="text-align: center; display:flex; width:100%; justify-content: center;">
                    <h1 class="question-title">Question à {{questionData.points}} points !</h1>
                </v-flex>
                <v-flex style="text-align: center; display:flex; width:100%; justify-content: center;">
                    <h1 class="question-text">{{questionData.label}}</h1>
                </v-flex>
                <div class="answer-box-container">
                    <v-flex v-for="(value, key) in questionData.propositions"
                            class="answer" :id="`bubble-${key}`" @click="answerQuestion(key)">
                        <answercomponent :propositionNumber="key" :question="questionData"/>
                    </v-flex>
                </div>
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
            sound: null,
            errorImg: new Image(),
            successImg: new Image(),
            defaultImg: new Image(),
            displayError: null,
            errorMessage: "",
        }),
        computed: {

            ...mapGetters(['SessionId', 'UserInfos']),
        },
        methods: {
            answerStyle(propositions) {
                var fontSize = "";

            },
            fillAnswerComponents() {
                this.getActualQuestion(this.SessionId)
                    .done((response) => {
                        this.questionData = response.data;
                        this.answerStyle(response.data.propositions);
                    })
                    .fail((error) => {
                        this.questionData = "";
                        this.isWaiting = true;
                        this.errorMessage = error.responseJSON.message;
                        this.displayError = true;
                        document.querySelector("#alert-box").setAttribute('style', 'display:flex;');
                    })
            },
            answerQuestion(key) {
                if (this.canClick) {
                    if (this.questionData.propositions[key].is_right_answer === 1) {
                        this.sound = new Audio(require('../assets/sounds/success.mp3'));
                        this.sound.play();
                    } else {
                        this.sound = new Audio(require('../assets/sounds/error.mp3'));
                        this.sound.play();
                    }
                    this.canClick = false;
                    for (var i = 0; i < this.questionData.propositions.length; i++) {
                        if (this.questionData.propositions[i].is_right_answer === 0)
                            document.querySelector(`#bubble-${i}`).style.backgroundImage = `url('${this.errorImg.src}')`;
                        else
                            document.querySelector(`#bubble-${i}`).style.backgroundImage = `url('${this.successImg.src}')`;
                    }
                    setTimeout(() => {
                        var infos = {
                            'proposition_id': this.questionData.propositions[key].id,
                            'user_id': this.UserInfos.id,
                            'session_id': this.SessionId,
                        };
                        this.userAnswer(infos)
                            .done((response) => {
                                this.isWaiting = !this.isWaiting;
                            })
                            .fail((error) => {
                                this.canClick = !this.canClick;
                                this.errorMessage = error.responseJSON.message;
                                this.displayError = true;
                                document.querySelector("#alert-box").setAttribute('style', 'display:flex;');
                            })
                            .always(() => {
                                for (var i = 0; i < this.questionData.propositions.length; i++) {
                                    document.querySelector(`#bubble-${i}`).style.backgroundImage = `url('${this.defaultImg.src}')`;
                                }
                            })
                    }, 1000);
                }
            },
            waitingTimeCheck() {
                if (this.timeToWait === 0) {
                    //this.clearTimer();
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
                clearInterval(this.timer);
                this.timeToWait = CONST.TIME_TO_ANSWER;
            },
            closeAlert() {
                this.displayError = false;
            },
            listen() {
                window.Echo.channel(`finish-game-${this.SessionId}`)
                    .listen('FinishGame', () => {
                        window.Echo.leave(`session-${this.SessionId}`);
                        window.Echo.leave(`change-question-${this.SessionId}`);
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
                        this.isWaiting = false;
                        this.timer = setInterval(this.waitingTimeCheck, 1000);
                    });
                window.Echo.channel(`change-question-${this.SessionId}`)
                    .listen('ChangeQuestion', (response) => {
                        console.log('question changée');
                        this.timeToWait = CONST.TIME_TO_ANSWER;
                        this.questionData = response.question;
                        this.answerStyle(response.question.propositions);
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
            this.displayError = false;
            this.fillAnswerComponents();
            this.errorImg.src = require('../assets/img/answer_error.png');
            this.successImg.src = require('../assets/img/answer_success.png');
            this.defaultImg.src = require('../assets/img/answer.png');
        },
        beforeDestroy() {
            this.clearTimer();
        },
        destroyed() {
            this.clearTimer();
            console.log('timer destroyed');
        }

    }
</script>

<style scoped>
    .answer-parent{
        display:flex;
        align-items:center;
    }
    .answer-container{
        display:flex;
        flex-wrap: wrap;
    }
    .answer-box-container{
        display:flex;
        justify-content: center;
        flex-wrap:wrap;
    }
    .answer{
        display:flex;
        align-items: center;
        justify-content: center;
        flex:0;
        margin: 1% 1% 1% 1%;
    }
    .answer-main {
        height: 100%;
    }

    .question-text {
        padding-left: 2rem;
        padding-right: 2rem;
        margin: 1rem 0 1rem 0;
    }

    @media (max-width: 575.98px) {
        .answer {
            min-height: 130px;
            min-width: 250px;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
        }

        .question-text {
            font-size: 1.3rem;
        }

        .remaining-time{
            font-size: 1rem;
        }

        .question-title{
            font-size: 2rem;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .answer {
            min-height: 100px;
            min-width: 200px;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
        }

        .question-text {
            font-size: 1rem;
        }

        .remaining-time{
            font-size:0.8rem;
        }

        .question-title{
            font-size:1.5rem;
        }

    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .answer {
            min-height: 150px;
            min-width: 300px;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
        }

        .question-text {
            font-size: 1.5rem;
        }

        .question-title {
            font-size: 2rem;
        }

        .remaining-time {
            font-size: 1rem;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .answer {
            min-height: 170px;
            min-width: 330px;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
        }

        .question-text {
            font-size: 2rem;
        }

        .question-title {
            font-size: 2.5rem;
        }

        .remaining-time {
            font-size: 1.5rem;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .answer {
            min-height: 150px;
            min-width: 300px;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
        }


        .question-title {
            font-size: 40pt;
        }

        .remaining-time {
            font-size: 20pt;
        }

        .question-text {
            font-size: 23pt;
        }
    }

    @media (orientation: landscape){
        .answer-box-container {
            flex-direction: row;
        }
    }

    @media(orientation:portrait){
        .answer-box-container{
            flex-direction: column;
        }
    }
</style>