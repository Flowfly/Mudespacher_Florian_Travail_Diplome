<template>
    <v-layout row wrap>
        <v-flex xs9 v-if="displayAlert"></v-flex>
        <v-flex xs3 v-if="displayAlert">
            <v-alert
                    v-model="displayAlert"
                    v-if="displayAlert"
                    dismissible
                    type="success"
                    id="alert"
            >
                {{alertMessage}}
            </v-alert>
        </v-flex>
        <v-flex xs3></v-flex>
        <v-flex xs6>
            <v-text-field
                    v-model="username"
                    label="Nom d'utilisateur"
                    prepend-icon="fas fa-user"
                    color="white"
                    :rules="usernameRules"
                    class="input-register"
            ></v-text-field>
        </v-flex>
        <v-flex xs3></v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.password"></v-flex>
        <v-flex xs6 v-if="this.InterfaceSettings.password">
            <v-text-field
                    v-model="password"
                    label="Mot de passe"
                    prepend-icon="fas fa-lock"
                    :append-icon="show_password ? 'fas fa-eye' : 'fas fa-eye-slash'"
                    :type="show_password ? 'text' : 'password'"
                    @click:append="show_password = !show_password"
            ></v-text-field>
        </v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.password"></v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.password"></v-flex>
        <v-flex xs6 v-if="this.InterfaceSettings.password">
            <v-text-field
                    v-model="passwordConfirmation"
                    label="Mot de passe (confirmation)"
                    prepend-icon="fas fa-lock"
                    :append-icon="show_passwordConfirmation ? 'fas fa-eye' : 'fas fa-eye-slash'"
                    :type="show_passwordConfirmation ? 'text' : 'password'"
                    @click:append="show_passwordConfirmation = !show_passwordConfirmation"
            ></v-text-field>
        </v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.password"></v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.name"></v-flex>
        <v-flex xs6 v-if="this.InterfaceSettings.name">
            <v-text-field
                    v-model="name"
                    label="Prénom"
                    prepend-icon="fas fa-address-book"
                    required
            ></v-text-field>
        </v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.name"></v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.surname"></v-flex>
        <v-flex xs6 v-if="this.InterfaceSettings.surname">
            <v-text-field
                    v-model="surname"
                    label="Nom de famille"
                    prepend-icon="fas fa-address-book"
                    required
            ></v-text-field>
        </v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.surname"></v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.date"></v-flex>
        <v-flex xs6 v-if="this.InterfaceSettings.date">
            <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    lazy
                    transition="scale-transition"
                    offset-y
                    full-width
                    min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                            v-model="date"
                            prepend-icon="event"
                            readonly
                            v-on="on"
                    ></v-text-field>
                </template>
                <v-date-picker v-model="date" @input="menu = false" :allowed-dates="allowedDates"></v-date-picker>
            </v-menu>
        </v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.date"></v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.email"></v-flex>
        <v-flex xs6 v-if="this.InterfaceSettings.email">
            <v-text-field
                    v-model="email"
                    label="Email"
                    prepend-icon="fas fa-at"
                    :rules="emailRules"
                    required
            ></v-text-field>
        </v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.email"></v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.phone"></v-flex>
        <v-flex xs6 v-if="this.InterfaceSettings.phone">
            <v-text-field
                    v-model="phone"
                    label="Téléphone"
                    prepend-icon="fas fa-phone"
                    required
            ></v-text-field>
        </v-flex>
        <v-flex xs3 v-if="this.InterfaceSettings.phone"></v-flex>
        <v-flex xs3></v-flex>
        <v-flex xs6>
            <v-btn
                    color="white"
                    large
                    outline
                    @click="submitUser">
                JOUER
            </v-btn>
        </v-flex>
        <v-flex xs3></v-flex>
    </v-layout>
</template>

<script>
    import {mapActions, mapGetters, mapMutations} from 'vuex';

    export default {
        name: "RegisterForm",
        data: () => ({
            show_password: false,
            show_passwordConfirmation: false,
            today_date: "",
            max_date_string: "",
            date: "",
            menu: false,
            username: "",
            usernameRules: [
                v => !!v || "Le nom d'utilisateur est obligatoire",
                v => v.length <= 15 || "Le nom d'utilisateur ne doit pas dépasser les 15 caractères",
                v => v.length >= 4 || "Le nom d'utilisateur doit dépasser les 4 caractères",
            ],
            password: "",
            passwordRules: [],
            passwordConfirmation: "",
            passwordConfirmationRules: [],
            name: "",
            nameRules: [],
            surname: "",
            surnameRules: [],
            email: "",
            emailRules: [],
            phone: "",
            phoneRules: [],
            allowed_dates: [],
            displayAlert: false,
            alertMessage: '',
            canClick: true,
        }),
        computed: {...mapGetters(['InterfaceSettings', 'SessionId'])},
        methods: {
            getDates() {
                var dates = [];
                var currentDate = new Date('1900-02-01');
                var endDate = new Date(this.max_date_string);
                var result = [];

                var addDays = function (days) {
                    var date = new Date(this.valueOf());
                    date.setDate(date.getDate() + days);
                    return date
                };

                while (currentDate <= endDate) {
                    dates.push(currentDate);
                    currentDate = addDays.call(currentDate, 1)
                }
                for (var i = 0; i < dates.length; i++) {
                    var day = dates[i].getDate() <= 9 ? '0' + dates[i].getDate() : dates[i].getDate();
                    var month = dates[i].getMonth() <= 9 ? '0' + dates[i].getMonth() : dates[i].getMonth();
                    var year = dates[i].getFullYear();
                    result.push(`${year}-${month}-${day}`)
                }
                return result;
            },
            allowedDates(val) {
                return this.allowed_dates.indexOf(val) !== -1
            },
            submitUser() {
                if (this.canClick) {
                    console.log('il a click');
                    this.canClick = false;
                    this.displayAlert = true;
                    this.alertMessage = '';
                    var datas = {
                        'username': this.username,
                        'password': this.password,
                        'passwordConfirmation': this.passwordConfirmation,
                        'name': this.name,
                        'surname': this.surname,
                        'date': this.date,
                        'phone': this.phone,
                    };
                    this.addUser({datas})
                        .done((response) => {
                            document.querySelector('#alert').setAttribute('class', `v-alert ${response.status}`);
                            for (var property in response.message) {
                                for (var i = 0; i < response.message[property].length; i++) {
                                    this.alertMessage += response.message[property][i].toString() + '\n';
                                }
                            }
                            if (response.status === 'success') {
                                this.setUserInfos(response.user);
                                this.subscribeUser({
                                    'user_id': response.user.id,
                                    'session_id': this.SessionId,
                                })
                                    .done((subscribeResponse) => {
                                        if (subscribeResponse.status === 'success') {
                                            this.$router.push('/answer');
                                        }
                                    }).fail((error) => {
                                    document.querySelector('#alert').setAttribute('class', 'v-alert error');
                                    this.alertMessage = "Une erreur s'est produite, veuillez contacter un administrateur";
                                    console.log(error);
                                });
                            }
                        })
                        .fail((error) => {
                            document.querySelector('#alert').setAttribute('class', 'v-alert error');
                            this.alertMessage = "Une erreur s'est produite, veuillez contacter un administrateur";
                            console.log(error);
                        });
                }

            },
            ...mapActions(['addUser', 'subscribeUser']),
            ...mapMutations(['setUserInfos']),
        },
        mounted() {
            this.today_date = new Date();
            this.max_date_string = `${parseInt(this.today_date.getFullYear() - 5)}-${this.today_date.getMonth() <= 8 ? '0' + parseInt(this.today_date.getMonth() + 2) : parseInt(this.today_date.getMonth() + 2)}-${this.today_date.getDate() <= 9 ? '0' + this.today_date.getDate() : this.today_date.getDate()}`;
            this.allowed_dates = this.getDates();
            var displayed_max_date = this.max_date_string.split('-');
            displayed_max_date[1] = (parseInt(displayed_max_date[1]) - 1).toString();
            this.date = new Date(displayed_max_date).toISOString().substr(0, 10);
        },
    }
</script>

<style scoped>


</style>