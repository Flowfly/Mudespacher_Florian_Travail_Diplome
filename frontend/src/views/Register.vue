<template>
    <v-form v-model="valid">
        <v-container fluid fill-height>
            <registerform/>
        </v-container>
    </v-form>
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
    .register-container {
        height: 100%;
    }
    /*.v-input .input-register .v-text-field .v-text-field--enclosed .v-text-field--outline {
        color:white !important;
        caret-color: white !important;
    }*/
</style>