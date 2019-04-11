<template>
    <v-container fluid fill-height d-block>
        <v-layout row wrap>
            <v-layout align-center justify-center>
                <div style="text-align: center;">
                    <h1 class="first-sentence">Partie terminée avec 3 réponses correctes et 50 points !</h1>
                    <v-divider></v-divider>
                    <h1 class="second-sentence">Nous espérons que vous avez passé un bon moment <i class="far fa-smile"></i></h1>
                    <h1>Veuillez maintenant s'il vous plaît rendre la tablette au responsable du stand</h1>
                </div>

            </v-layout>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        name: "End"
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