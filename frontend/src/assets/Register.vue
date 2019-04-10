<template>
    <v-form v-model="valid">
        <v-container fluid class="test">
            <registerform/>
        </v-container>
    </v-form>
</template>

<script>
    import registerform from '../components/RegisterForm'

    export default {
        name: "Register",
        components: {
            registerform,
        },

    }
</script>

<style scoped>

</style>