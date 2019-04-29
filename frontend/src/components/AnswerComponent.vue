<template>

    <div class="answer-container"
         @click="answer">
        <p class="answer-text">{{ this.question.propositions[this.propositionNumber].label }}</p>
    </div>
</template>

<script>
    import CONST from '../CONST';

    export default {
        name: "AnswerComponent",
        data: () => ({}),
        props:
            ['question', 'propositionNumber'],
        mounted() {
            //console.log(document.querySelector('#bubble').style.backgroundImage)
        },
        methods: {
            answer() {
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
        height:100%;
        width:100%;
    }

    .answer-text {
        position: absolute;
        top: 50%;
        margin: 0 -50% 0 0;
        transform: translate(-50%, -50%);
        left: 50%;
        color: #fff3cc;
        font-size: 20pt;
    }

    /* Extra small devices (portrait phones, less than 576px)*/


</style>