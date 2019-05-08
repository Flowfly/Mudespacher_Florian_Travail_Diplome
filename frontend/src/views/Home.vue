<template>
    <v-container fluid fill-height @click="play" class="home">
        <h1 class="start">Appuyer pour commencer</h1>
    </v-container>
</template>

<script>
    export default {
        methods:{
            play(){
                this.$router.push('/register');
            }
        }
    }
</script>

<style>
    .home{
        background-image: url("../assets/img/home.png");
        background-position: center;
        background-repeat: no-repeat;
        cursor: pointer;
        text-align: center;
    }
    .start{
        position:absolute;
        width:100%;
    }
    @media (max-width: 575.98px) {
        .home{
            background-size: 35rem;
        }
        .start {
            top: 80%;
            right:1.5%;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .home{
            background-size: 35rem;
        }
        .start{
            top:85%;
            font-size:15pt;
        }
    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .home{
            background-size: 40rem;
        }
        .start{
            font-size: 15pt;
            top:87%;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .home{
            background-size: 80rem;
        }
        .start{
            top:85%;
            font-size:35pt;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .home{
            background-size: 70rem;
        }
        .start {
            top: 90%;
        }
    }
</style>