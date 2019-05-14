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
            AndroidFullScreen.immersiveMode();
            document.addEventListener("backbutton", () => {
                //used to cancel the back button
                console.log('back button canceled');
            }, false);
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
