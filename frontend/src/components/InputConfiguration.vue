<template>
    <v-layout row wrap>
        <v-flex xs2></v-flex>
        <v-flex xs8>
            <v-card>
                <v-toolbar
                        card
                        color="blue-grey"
                        dark
                >
                    <v-toolbar-title>Choisir les informations utilisateur à demander</v-toolbar-title>
                </v-toolbar>

                <v-card-text>
                    <v-layout row wrap align-center>
                        <v-switch v-model="password" :label="`Mot de passe`"></v-switch>
                        <v-switch v-model="name" :label="`Prénom`"></v-switch>
                        <v-switch v-model="surname" :label="`Nom`"></v-switch>
                    </v-layout>
                    <v-layout row wrap align-center>
                        <v-switch v-model="date" :label="`Date de naissance`"></v-switch>
                        <v-switch v-model="email" :label="`Email`"></v-switch>
                        <v-switch v-model="phone" :label="`Téléphone`"></v-switch>
                    </v-layout>
                </v-card-text>
                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            color="success"
                            depressed
                            @click="goToQuiz"
                    >
                        Valider
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
        <v-flex xs2></v-flex>
    </v-layout>
</template>

<script>
    import {mapMutations} from 'vuex'

    export default {
        name: "InputConfiguration",
        data: () => ({
            password: false,
            name: false,
            surname: false,
            date: false,
            email: false,
            phone: false,
        }),
        methods:{
            goToQuiz()
            {
                this.setInterface({
                   'password': this.password,
                   'name': this.name,
                   'surname': this.surname,
                   'date': this.date,
                   'email': this.email,
                   'phone': this.phone,
                });
                this.$router.push('/register');
            },
            ...mapMutations(['setInterface'])
        }
    }
</script>

<style scoped>

</style>