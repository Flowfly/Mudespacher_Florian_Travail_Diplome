<!--
 Florian Mudespacher
 Quiz interactif - Diploma work
 CFPT - T.IS-E2A - 2019
-->
<template>
    <v-container v-model="valid" class="hcenter">
            <registerform v-show="!isWaiting" v-on:btn-play-clicked="userClicked"/>
            <waiting :waiting-text="`Chargement en cours`" v-show="isWaiting"/>
    </v-container>
</template>

<script>
    import registerform from '../components/RegisterForm'
    import waiting from '../components/Waiting'

    export default {
        name: "Register",
        data: () => ({
            valid: false,
            isWaiting: false,
        }),
        components: {
            registerform,
            waiting,
        },
        methods:{
            userClicked(value){
                this.isWaiting = value;
            },
        }
    }
</script>

<style scoped>
    .hcenter {
        position: absolute;
        top: 50%;
        margin: 0 -50% 0 0;
        transform: translate(-50%, -50%);
        left: 50%;
    }
    /*.v-input .input-register .v-text-field .v-text-field--enclosed .v-text-field--outline {
        color:white !important;
        caret-color: white !important;
    }*/
</style>