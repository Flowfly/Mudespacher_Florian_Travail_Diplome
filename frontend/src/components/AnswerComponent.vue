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
    /* Extra small devices (portrait phones, less than 576px)*/

    @media (max-width: 575.98px) {
        .bubble{
            height:70%;
            width:70%;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .bubble{
            height:90%;
            width:70%;
        }
    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .bubble{
            height:90%;
            width:70%;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .bubble{
            height:90%;
            width:70%;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .bubble{
            height:90%;
            width:70%;
        }
    }

</style>