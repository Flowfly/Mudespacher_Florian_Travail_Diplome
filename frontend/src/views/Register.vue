<template>
    <v-container v-model="valid">
        <v-container fluid fill-height hcenter>
            <registerform/>
        </v-container>
    </v-container>
</template>

<script>
    import registerform from '../components/RegisterForm'

    export default {
        name: "Register",
        data: () => ({
            valid: false,
        }),
        components: {
            registerform,
        },
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