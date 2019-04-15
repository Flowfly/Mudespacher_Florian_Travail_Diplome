<template>
    <v-app>
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

    }
</script>

<style>
    .content {
        background-image: url('../src/assets/img/background.png');
        color:#fff3cc;
    }
</style>
