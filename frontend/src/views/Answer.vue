<template>
    <v-container fluid fill-height d-block v-if="questionData !== null" style="height: 100%;">
        <waiting v-if="isWaiting"/>
        <v-layout row wrap v-if="!isWaiting">
            <v-layout align-center justify-center d-inline-block class="hcenter">
                <v-flex style="text-align: center;">
                    <h1>Question à {{questionData.points}} points !</h1>
                    <h1>{{questionData.label}}</h1>
                </v-flex>
                <v-layout row wrap align-center justify-center v-for="(value, key) in questionData.propositions"
                          style="height:160px;">
                    <div style="text-align: -webkit-center;">
                        <answercomponent :propositionNumber="key" :question="questionData"
                                         @clicked-from-child="answerQuestion"
                        />
                    </div>
                </v-layout>
            </v-layout>
        </v-layout>
    </v-container>
</template>

<script>
    import waiting from '../components/Waiting';
    import answercomponent from '../components/AnswerComponent';
    import {mapActions, mapGetters, mapMutations} from 'vuex';

    export default {
        name: "Answer",
        components: {
            waiting,
            answercomponent,
        },
        data: () => ({
            questionData: null,
            isWaiting: false,
        }),
        computed: {
            ...mapGetters(['SessionId', 'UserInfos']),
        },
        methods: {
            fillAnswerComponents() {
                this.setSessionId(1);
                this.getActualQuestion(this.SessionId)
                    .done((response) => {
                        this.questionData = response.data;
                    })
                    .fail((error) => {
                        console.log(error);
                    })
            },
            answerQuestion(event) {
                this.isWaiting = !this.isWaiting;
                var infos = {
                    'proposition_id': event[0],
                    'user_id': /*this.UserInfos.id*/ 24,
                    'session_id': this.SessionId,
                };
                this.userAnswer(infos)
                    .done((response) => {
                        if(response.status === 'success')
                        {

                        }
                        else{
                            this.isWaiting = !this.isWaiting;
                        }
                    })
                    .fail((error) => {
                        this.isWaiting = !this.isWaiting;
                        console.log(error);
                    })
                //this.isWaiting = !this.isWaiting;
            },
            ...mapActions(['getActualQuestion', 'userAnswer']),
            ...mapMutations(['setSessionId']),
        },
        mounted() {
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