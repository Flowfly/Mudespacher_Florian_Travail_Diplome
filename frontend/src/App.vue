<!--
 Florian Mudespacher
 Quiz interactif - Diploma work
 CFPT - T.IS-E2A - 2019
-->
<template>
    <v-app dark>
        <v-content class="content">
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>


    export default {
        name: 'App',
        components: {},
        data() {
            return {}
        },
        mounted() {

            document.addEventListener("backbutton", () => {
                //used to cancel the back button
                console.log('back button canceled');
            }, false);

            document.addEventListener("keyboardWillShow", () => {
                AndroidFullScreen.leanMode();
                console.log('keyboard show');
            });
            document.addEventListener("keyboardWillHide", () => {
                AndroidFullScreen.immersiveMode();
                console.log('keyboard hide');
            });
        }

    }
</script>

<style>
    .content {
        /*background-image: url('../src/assets/img/background.png');*/
        color: #fff3cc;
        font-family: 'Font';
        background-image: url("assets/img/background.png");
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    @font-face {
        font-family: "Font";
        src: url("assets/font.otf");
    }
</style>
