<!--
 Florian Mudespacher
 Quiz interactif - Diploma work
 CFPT - T.IS-E2A - 2019
-->
<template>
    <v-container fluid fill-height @click="play" class="home">
        <h1 class="start scale-in-center">Appuyer pour commencer</h1>
    </v-container>
</template>

<script>
    export default {
        methods: {
            play() {
                this.$router.push('/register');
            }
        }
    }
</script>

<style>
    .home {
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        cursor: pointer;
        text-align: center;
    }

    .start {
        position: absolute;
        width: 100%;
    }

    .scale-in-center {
        -webkit-animation: scale-in-center 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        animation: scale-in-center 1s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
        animation-iteration-count: infinite;
        animation-direction: alternate;
    }

    @media (max-width: 575.98px) {
        .start {
            right: 1.5%;
            font-size:20pt;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .start {
            font-size: 15pt;
        }
    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .start {
            font-size: 25pt;
            right: 0.5%;
        }
    }
    @media (min-width: 768px) and (max-width: 991.98px) and (min-height: 1024px) and (max-height: 1260px){
        .start {
            font-size: 35pt;
            right: 0.5%;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .start {
            font-size: 45pt;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .start{
            font-size:30pt;
        }
    }

    @media (orientation: landscape) {
        .home {
            background-image: url("../assets/img/home_landscape.png");
        }

        .start {
            top: 85%;
        }
    }

    @media (orientation: portrait) {
        .home {
            background-image: url("../assets/img/home_portrait.png");
        }

        .start {
            top: 20%;
        }
    }

    /**
     * ----------------------------------------
     * animation scale-in-center
     * ----------------------------------------
     */
    @-webkit-keyframes scale-in-center {
        0% {
            -webkit-transform: scale(0.8);
            transform: scale(0.8);
            opacity: 1;
        }
        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
    }
    @keyframes scale-in-center {
        0% {
            -webkit-transform: scale(0.8);
            transform: scale(0.8);
            opacity: 1;
        }
        100% {
            -webkit-transform: scale(1);
            transform: scale(1);
            opacity: 1;
        }
    }

</style>