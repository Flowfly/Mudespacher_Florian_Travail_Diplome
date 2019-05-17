<template>
    <v-layout row wrap align-center justify-center @keydown.enter="submitUser">
        <v-flex v-show="displayAlert" xs8></v-flex>
        <v-flex v-show="displayAlert" xs3>
            <v-alert id="alert-box" :dismissible="true" @click="closeAlert" :value="true" color="error">
                {{alertMessage}}
            </v-alert>
        </v-flex>
        <v-flex v-show="displayAlert" xs1></v-flex>
        <v-flex xs1></v-flex>
        <v-flex xs10 style="text-align: center;">
            <v-btn
                    color="white"
                    large
                    fab
                    style="color:#181945; font-weight: bold;"
                    @click="submitUser">
                JOUER
            </v-btn>
        </v-flex>
        <v-flex xs1></v-flex>
        <v-flex xs1></v-flex>
        <v-flex xs10>
            <v-text-field
                    v-model="username"
                    label="Nom d'utilisateur"
                    prepend-icon="fas fa-user"
                    color="white"
                    outline
                    :rules="usernameRules"
            ></v-text-field>
        </v-flex>
        <v-flex xs1></v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.password"></v-flex>
        <v-flex xs10 v-if="this.InterfaceSettings.password">
            <v-text-field
                    v-model="password"
                    label="Mot de passe"
                    prepend-icon="fas fa-lock"
                    outline
                    color="white"
                    :rules="passwordRules"
                    :append-icon="show_password ? 'fas fa-eye' : 'fas fa-eye-slash'"
                    :type="show_password ? 'text' : 'password'"
                    @click:append="show_password = !show_password"
            ></v-text-field>
        </v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.password"></v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.password"></v-flex>
        <v-flex xs10 v-if="this.InterfaceSettings.password">
            <v-text-field
                    v-model="passwordConfirmation"
                    label="Mot de passe (confirmation)"
                    prepend-icon="fas fa-lock"
                    color="white"
                    outline
                    :rules="passwordConfirmationRules"
                    :append-icon="show_passwordConfirmation ? 'fas fa-eye' : 'fas fa-eye-slash'"
                    :type="show_passwordConfirmation ? 'text' : 'password'"
                    @click:append="show_passwordConfirmation = !show_passwordConfirmation"
            ></v-text-field>
        </v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.password"></v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.name"></v-flex>
        <v-flex xs10 v-if="this.InterfaceSettings.name">
            <v-text-field
                    v-model="name"
                    label="Prénom"
                    prepend-icon="fas fa-address-book"
                    outline
                    color="white"
                    :rules="nameRules"
                    required
            ></v-text-field>
        </v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.name"></v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.surname"></v-flex>
        <v-flex xs10 v-if="this.InterfaceSettings.surname">
            <v-text-field
                    v-model="surname"
                    label="Nom de famille"
                    prepend-icon="fas fa-address-book"
                    outline
                    color="white"
                    :rules="surnameRules"
                    required
            ></v-text-field>
        </v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.surname"></v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.date"></v-flex>
        <v-flex xs10 v-if="this.InterfaceSettings.date">
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
                            color="white"
                            outline
                            readonly
                            v-on="on"
                    ></v-text-field>
                </template>
                <v-date-picker v-model="date" @input="menu = false" :allowed-dates="allowedDates"></v-date-picker>
            </v-menu>
        </v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.date"></v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.email"></v-flex>
        <v-flex xs10 v-if="this.InterfaceSettings.email">
            <v-text-field
                    v-model="email"
                    label="Email"
                    prepend-icon="fas fa-at"
                    outline
                    :rules="emailRules"
                    required
            ></v-text-field>
        </v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.email"></v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.phone"></v-flex>
        <v-flex xs10 v-if="this.InterfaceSettings.phone">
            <v-text-field
                    v-model="phone"
                    label="Téléphone"
                    prepend-icon="fas fa-phone"
                    outline
                    :rules="phoneRules"
                    required
            ></v-text-field>
        </v-flex>
        <v-flex xs1 v-if="this.InterfaceSettings.phone"></v-flex>
    </v-layout>
</template>

<script>
    import {mapActions, mapGetters, mapMutations} from 'vuex';
    import CONST from '../CONST';

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
                v => !!v || CONST.REGISTRATION_ERROR_MESSAGES.username.required,
                v => v.length <= CONST.REGISTRATION_RULES.username.max || CONST.REGISTRATION_ERROR_MESSAGES.username.max,
                v => v.length >= CONST.REGISTRATION_RULES.username.min || CONST.REGISTRATION_ERROR_MESSAGES.username.min,
            ],
            password: "",
            passwordRules: [
                v => !!v || CONST.REGISTRATION_ERROR_MESSAGES.password.required,
                v => v.length <= CONST.REGISTRATION_RULES.password.max || CONST.REGISTRATION_ERROR_MESSAGES.password.max,
                v => v.length >= CONST.REGISTRATION_RULES.password.min || CONST.REGISTRATION_ERROR_MESSAGES.password.min,
            ],
            passwordConfirmation: "",
            passwordConfirmationRules: [
                v => !!v || CONST.REGISTRATION_ERROR_MESSAGES.password.required,
                v => v.length <= CONST.REGISTRATION_RULES.password.max || CONST.REGISTRATION_ERROR_MESSAGES.password.max,
                v => v.length >= CONST.REGISTRATION_RULES.password.min || CONST.REGISTRATION_ERROR_MESSAGES.password.min,
            ],
            name: "",
            nameRules: [
                v => !!v || CONST.REGISTRATION_ERROR_MESSAGES.name.required,
                v => v.length <= CONST.REGISTRATION_RULES.name.max || CONST.REGISTRATION_ERROR_MESSAGES.name.max,
                v => v.length >= CONST.REGISTRATION_RULES.name.min || CONST.REGISTRATION_ERROR_MESSAGES.name.min,
            ],
            surname: "",
            surnameRules: [
                v => !!v || CONST.REGISTRATION_ERROR_MESSAGES.password.required,
                v => v.length <= CONST.REGISTRATION_RULES.surname.max || CONST.REGISTRATION_ERROR_MESSAGES.surname.max,
                v => v.length >= CONST.REGISTRATION_RULES.surname.min || CONST.REGISTRATION_ERROR_MESSAGES.surname.min,
            ],
            email: "",
            emailRules: [
                v => !!v || CONST.REGISTRATION_ERROR_MESSAGES.email.required,
                v => /.+@.+/.test(v) || "L'email doit être valide"
            ],
            phone: "",
            phoneRules: [
                v => !!v || CONST.REGISTRATION_ERROR_MESSAGES.phone.required,
            ],
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
                    this.canClick = false;
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
                            if (response.status === 'success') {
                                this.setUserInfos(response.user);
                                this.subscribeUser({
                                    'user_id': response.user.id,
                                    'session_id': this.SessionId,
                                })
                                    .done((subscribeResponse) => {
                                        console.log('ca va jusquici');
                                        if (subscribeResponse.status === 'success') {
                                            this.$router.push('/answer');
                                        }
                                    }).fail((error) => {
                                    this.displayAlert = true;
                                    document.querySelector("#alert-box").setAttribute("style", "display:flex;");
                                    this.alertMessage = error.responseJSON.message;
                                    this.canClick = true;
                                    this.deleteUser({
                                        'user_id': response.user.id,
                                    })
                                        .fail((error) => {
                                            console.log(error);
                                            this.canClick = true;
                                        })
                                });
                            }
                        })
                        .fail((error) => {
                            this.displayAlert = true;
                            document.querySelector("#alert-box").setAttribute("style", "display:flex;");
                            var errorMessage = "";
                            for(var key in error.responseJSON){
                                for(var i = 0; i < error.responseJSON[key].length; i++){
                                    errorMessage += error.responseJSON[key][i] + "\n";
                                }
                            }
                            this.alertMessage = errorMessage;
                            this.canClick = true;
                        });
                }

            },
            closeAlert() {
                this.displayAlert = false;
            },
            ...mapActions(['addUser', 'deleteUser', 'subscribeUser']),
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
    .input-register {
        /*color:white;
        caret-color: white;*/
    }
</style>