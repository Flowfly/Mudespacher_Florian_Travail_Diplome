<template>
    <v-container fluid fill-height @click="play" class="home">
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
    }
    @media (max-width: 575.98px) {
        .home{
            background-size: 35rem;
        }
    }

    /* Small devices (landscape phones, 576px and up)*/
    @media (min-width: 576px) and (max-width: 767.98px) {
        .home{
            background-size: 35rem;
        }
    }

    /* Medium devices (tablets, 768px and up)*/
    @media (min-width: 768px) and (max-width: 991.98px) {
        .home{
            background-size: 40rem;
        }
    }

    /* Large devices (desktops, 992px and up)*/
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .home{
            background-size: 80rem;
        }
    }

    /* Extra large devices (large desktops, 1200px and up)*/
    @media (min-width: 1200px) {
        .home{
            background-size: 80rem;
        }
    }
</style>