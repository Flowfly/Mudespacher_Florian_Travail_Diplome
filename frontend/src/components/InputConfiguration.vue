<template>
    <v-layout row wrap align-center justify-center>
        <v-flex xs2></v-flex>
        <v-flex xs8>
            <v-card>
                <v-toolbar
                        card
                        color="indigo darken-1"
                        dark
                >
                    <v-toolbar-title>Configuration de la partie</v-toolbar-title>
                </v-toolbar>

                <v-card-text>
                    <h3 class="headline mb-0"><i class="fas fa-info-circle" style="color:#3d5aff; margin-right:1%;"></i> Séléction des informations à demander au client</h3>
                    <v-layout row wrap align-center>
                        <v-switch v-model="password" :label="`Mot de passe`" color="primary"></v-switch>
                        <v-switch v-model="name" :label="`Prénom`" color="primary"></v-switch>
                        <v-switch v-model="surname" :label="`Nom`" color="primary"></v-switch>
                    </v-layout>
                    <v-layout row wrap align-center>
                        <v-switch v-model="date" :label="`Date de naissance`" color="primary"></v-switch>
                        <v-switch v-model="email" :label="`Email`" color="primary"></v-switch>
                        <v-switch v-model="phone" :label="`Téléphone`" color="primary"></v-switch>
                    </v-layout>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-text>
                    <h3 class="headline mb-0"><i class="fas fa-spinner fa-spin" style="color:#3d5aff; margin-right:1%;"></i> Séléctionner la partie</h3>
                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-combobox
                                    v-model="select"
                                    :items="items"
                                    label="Laisser vide pour prendre une aléatoire"
                            ></v-combobox>
                        </v-flex>
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
    import {mapMutations, mapGetters, mapActions} from 'vuex'

    export default {
        name: "InputConfiguration",
        data: () => ({
            password: false,
            name: false,
            surname: false,
            date: false,
            email: false,
            phone: false,
            items: [],
            select: "",
        }),
        methods: {
            goToQuiz() {
                this.setInterface({
                    'password': this.password,
                    'name': this.name,
                    'surname': this.surname,
                    'date': this.date,
                    'email': this.email,
                    'phone': this.phone,
                });
                this.setSessionId(this.select.split('.')[0]);
                this.$router.push('/register');
            },
            isEmpty(obj) {
                for (var key in obj) {
                    if (obj.hasOwnProperty(key))
                        return false;
                }
                return true;
            },
            fillSessionCombobox(){
                this.getAllNotStartedSessions()
                    .done((response) => {
                        var result = response[0];
                        for(var i = 0; i < result.length; i++)
                        {
                            this.items.push(`${result[i].id}.${result[i].label}`);
                        }
                    })
            },
            ...mapMutations(['setInterface', 'setSessionId']),
            ...mapActions(['getAllNotStartedSessions'])
        },
        computed: {
            ...mapGetters(['InterfaceSettings'])
        },
        mounted() {
            if (!this.isEmpty(this.InterfaceSettings)) {
                this.password = this.InterfaceSettings.password;
                this.name = this.InterfaceSettings.name;
                this.surname = this.InterfaceSettings.surname;
                this.date = this.InterfaceSettings.date;
                this.email = this.InterfaceSettings.email;
                this.phone = this.InterfaceSettings.phone;
            }
            this.fillSessionCombobox();
        }
    }
</script>

<style scoped>

</style>