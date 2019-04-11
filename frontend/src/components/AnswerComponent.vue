<template>
        <v-img
                :src="require('@/assets/img/bubble.png')"
                class="bubble"
                alt="answer"
                @click="answer"
        >
            <div class="answer-container">
                <p class="answer-text">{{this.question.propositions[this.propositionNumber].label}}</p>
            </div>
        </v-img>
</template>

<script>
    export default {
        name: "AnswerComponent",
        data: () => ({}),
        props:
            ['question', 'propositionNumber'],
        mounted() {
        },
        methods:{
            answer(){
                this.$emit('clicked-from-child', [this.question.propositions[this.propositionNumber].id, this.question.propositions[this.propositionNumber].is_right_answer]);
            }
        }
    }
</script>

<style scoped>
    .bubble {
        width: 400px;
        height:200px;
        position: relative;
        cursor:pointer;
    }

    .answer-container {
        position: absolute;
        top: 50%;
        margin: 0 -50% 0 0;
        transform: translate(-50%, -50%);
        left: 50%;
        width: 57%;
        height: 30%;
    }

    .answer-text {
        position: absolute;
        top: 50%;
        margin: 0 -50% 0 0;
        transform: translate(-50%, -50%);
        left: 50%;
    }
</style>