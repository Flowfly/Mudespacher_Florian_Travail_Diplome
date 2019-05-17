<template>
    <v-container fluid fill-height d-block v-if="questionData !== null" class="answer-main">
        <v-layout row wrap justify-center style="text-align: center;" v-show="displayError">
            <v-flex xs8>
                <v-alert id="alert-box" :dismissible="true" @click="closeAlert" :value="true" color="error">
                    {{errorMessage}}
                </v-alert>
            </v-flex>
        </v-layout>
        <waiting v-if="questionData !== ''" v-show="isWaiting"/>


        <v-layout row wrap v-if="questionData !== ''" v-show="!isWaiting" class="answer-container">
            <v-layout align-center justify-center d-inline-block class="hcenter">
                <v-flex style="text-align: center;">
                    <h2 v-model="timeToWait" class="remaining-time">Temps restant : {{timeToWait}}</h2>
                </v-flex>
                <v-flex style="text-align: center;">
                    <h1 class="question-title">Question à {{questionData.points}} points !</h1>
                    <h1 class="question-text">{{questionData.label}}</h1>
                </v-flex>
                <center class="answer-box-container">
                    <v-flex v-for="(value, key) in questionData.propositions"
                            class="answer" :id="`bubble-${key}`" @click="answerQuestion(key)">
                        <answercomponent :propositionNumber="key" :question="questionData"/>
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
                for (var i = 0; i < propositions.length; i++) {
                    if (propositions[i].label.length <= 10) {
                        fontSize = `font-size:30pt`;
                    } else if (propositions[i].label.length <= 20) {
                        fontSize = `font-size:25pt`;
                    } else if (propositions[i].label.length <= 30) {
                        fontSize = `font-size:20pt`;
                    } else if (propositions[i].label.length <= 40) {
                        fontSize = `font-size:15pt`;
                    } else {
                        fontSize = `font-size:10pt`;
                    }
                    var div = document.querySelector(`#bubble-${i}`);
                    if (div !== null)
                        div.setAttribute('style', fontSize);
                }
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
                                this.clearTimer();
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
                if (this.$route.name === 'answer') {
                    if (this.timeToWait === 0) {
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
                } else {
                    this.clearTimer();
                    this.timer =
                        null;
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
                        this.timer = setInterval(this.waitingTimeCheck, 1000);
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
            this.isWaiting = false;
            this.displayError = false;
            this.fillAnswerComponents();
            this.errorImg.src = require('../assets/img/answer_error.png');
            this.successImg.src = require('../assets/img/answer_success.png');
            this.defaultImg.src = require('../assets/img/answer.png');
        },
        destroyed() {
            this.clearTimer();
            console.log('timer destroyed');
        }

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

    .question-text {
        padding-left: 2rem;
        padding-right: 2rem;
        margin: 1rem 0 1rem 0;
    }

    @media (max-width: 575.98px) {
        .answer {
            height: 11rem;
            width: 25rem;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position: relative;
        }

        .question-text {
            font-size: 15pt;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .answer {
            height: 14rem;
            width: 12rem;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position: relative;
        }

        .answer-box-container {
            display: flex;
        }

        .question-text {
            font-size: 15pt;
        }

    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .answer {
            height: 13rem;
            width: 30rem;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position: relative;
        }

        .question-text {
            font-size: 25pt;
        }

        .question-title {
            font-size: 40pt;
        }

        .remaining-time {
            font-size: 20pt;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .answer {
            height: 20rem;
            width: 40rem;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position: relative;
        }

        .question-text {
            font-size: 30pt;
        }

        .question-title {
            font-size: 50pt;
        }

        .remaining-time {
            font-size: 30pt;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .answer {
            height: 15rem;
            width: 25rem;
            cursor: pointer;
            background-image: url("../assets/img/answer.png");
            background-position: center;
            background-size: cover;
            position: relative;
        }

        .answer-box-container {
            display: flex;
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
</style>