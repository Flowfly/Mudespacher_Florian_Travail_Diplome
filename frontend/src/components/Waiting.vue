<!--
 Florian Mudespacher
 Quiz interactif - Diploma work
 CFPT - T.IS-E2A - 2019
-->
<template>
    <v-layout row wrap class="waiting-container">
            <v-layout align-center justify-center>
                <div style="text-align: -webkit-center;">
                    <h1>{{text}}</h1>
                    <div class="spinner">
                        <div class="cube1"></div>
                        <div class="cube2"></div>
                    </div>
                </div>

            </v-layout>
    </v-layout>
</template>

<script>
    export default {
        name: "Waiting",
        data: () => ({
            text: "",
        }),
        props:{
            waitingText: String,
        },
        mounted() {
            this.text = this.waitingText;
        }
    }
</script>

<style scoped>
    .item {
        max-height: 200px;
        max-width: 200px;
        margin: 10px;
    }
    .spinner {
        margin: 100px auto;
        width: 40px;
        height: 40px;
        position: relative;
    }

    .cube1, .cube2 {
        width: 25px;
        height: 25px;
        position: absolute;
        top: 0;
        left: 0;

        -webkit-animation: sk-cubemove 1.8s infinite ease-in-out;
        animation: sk-cubemove 1.8s infinite ease-in-out;
    }
    .cube1{
        background-color: #67aff7;
    }
    .cube2 {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
        background-color: #2b77db;
    }

    @-webkit-keyframes sk-cubemove {
        25% { -webkit-transform: translateX(42px) rotate(-90deg) scale(0.5) }
        50% { -webkit-transform: translateX(42px) translateY(42px) rotate(-180deg) }
        75% { -webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5) }
        100% { -webkit-transform: rotate(-360deg) }
    }

    @keyframes sk-cubemove {
        25% {
            transform: translateX(42px) rotate(-90deg) scale(0.5);
            -webkit-transform: translateX(42px) rotate(-90deg) scale(0.5);
        } 50% {
              transform: translateX(42px) translateY(42px) rotate(-179deg);
              -webkit-transform: translateX(42px) translateY(42px) rotate(-179deg);
          } 50.1% {
                transform: translateX(42px) translateY(42px) rotate(-180deg);
                -webkit-transform: translateX(42px) translateY(42px) rotate(-180deg);
            } 75% {
                  transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);
                  -webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);
              } 100% {
                    transform: rotate(-360deg);
                    -webkit-transform: rotate(-360deg);
                }
    }

    
</style>