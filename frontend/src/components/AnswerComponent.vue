<template>
        <p class="answer-text">{{ this.question.propositions[this.propositionNumber].label
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
    .answer-text{
        display:flex;
        text-align: center;
        justify-content: center;
    }

    /* Extra small devices (portrait phones, less than 576px)*/
    @media (max-width: 575.98px) {
        .answer-text{
            font-size: 1.5rem;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .answer-text{
            font-size: 1rem;
        }
    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .answer-text{
            font-size: 1.5rem;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .answer-text{
            font-size: 2rem;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .answer-text{
            font-size: 2rem;
        }
    }


</style>