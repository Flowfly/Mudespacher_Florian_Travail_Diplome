<template>
        <p class="hcenter answer-text">{{ this.question.propositions[this.propositionNumber].label
            }}</p>

</template>

<script>
    import CONST from '../CONST';

    export default {
        name: "AnswerComponent",
        data: () => ({}),
        props:
            ['question', 'propositionNumber'],
        mounted() {
            //console.log(this.question.propositions[this.propositionNumber].label.length > 30);
            /*if (this.question.propositions[this.propositionNumber].label.length > 30) {
                document.querySelector(".answer-text").setAttribute('style', 'font-size: 170%;');
            }*/
            //console.log(document.querySelector('#bubble').style.backgroundImage)
        },
        methods: {
        }
    }
</script>

<style scoped>

    /*.answer-container {
        position: absolute;
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

    }*/
    .answer-text{
        width:70%;
    }

    /* Extra small devices (portrait phones, less than 576px)*/
    @media (max-width: 575.98px) {
        .answer-text{
            font-size: 15pt;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .answer-text{
            font-size: 10pt;
        }
    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .answer-text{
            font-size: 20pt;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .answer-text{
            font-size: 30pt;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .answer-text{
            font-size: 15pt;
        }
    }


</style>