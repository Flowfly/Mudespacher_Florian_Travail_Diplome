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
        background-size: cover;
        background-repeat: no-repeat;
        cursor: pointer;
    }
</style>