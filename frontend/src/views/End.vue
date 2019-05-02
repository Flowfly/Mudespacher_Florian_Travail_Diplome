<template>
    <v-container fluid fill-height d-block>
        <v-layout row wrap>
            <v-layout align-center justify-center >
                <div style="text-align: center;">
                    <h1 class="first-sentence">Partie terminée avec {{UserResult.numberOfCorrectAnswers}} réponses correctes et {{UserResult.score}} points !</h1>
                    <v-divider></v-divider>
                    <h1 class="second-sentence">Nous espérons que vous avez passé un bon moment <i class="far fa-smile"></i></h1>
                    <h1>Veuillez maintenant s'il vous plaît rendre la tablette au responsable du stand</h1>
                </div>

            </v-layout>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import Echo from 'laravel-echo';
    import CONST from '../CONST';

    window.Pusher = require('pusher-js');
    window.Echo = new Echo({
        broadcaster: CONST.WEB_SOCKET_SERVICE.broadcaster,
        key: CONST.WEB_SOCKET_SERVICE.key,
        cluster: CONST.WEB_SOCKET_SERVICE.cluster,
        encrypted: CONST.WEB_SOCKET_SERVICE.encrypted,
    });

    export default {
        name: "End",
        data: () => ({
            ajaxQueryTerminated: false,
        }),
        computed: {
          ...mapGetters(['UserResult', 'SessionId'])
        },
        methods:{

        },
        mounted(){
            setTimeout(() => {
                this.$router.push('/home');
            }, 10000)
        },
        beforeMount() {
        },
        beforeCreate() {
            window.Echo.leave(`finish-game-${this.SessionId}`);
            window.Echo.leave(`session-${this.SessionId}`);
            window.Echo.leave(`change-question-${this.SessionId}`);
        }
    }
</script>

<style scoped>
    .first-sentence{
        font-size: 45pt;
        margin-bottom: 1%;
    }
    .second-sentence{
        font-size: 30pt;
        margin-top: 1%;
    }
</style>