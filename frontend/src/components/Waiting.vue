<template>
    <v-layout row wrap class="waiting-container">
            <v-layout align-center justify-center>
                <div style="text-align: -webkit-center;">
                    <h1>En attente des autres joueurs</h1>
                    <v-img
                            class="item"
                            :src="require('@/assets/img/waiting.gif')"
                            alt="waiting">
                    </v-img>
                </div>

            </v-layout>
    </v-layout>
</template>

<script>
    export default {
        name: "Waiting"
    }
</script>

<style scoped>
    .item {
        max-height: 200px;
        max-width: 200px;
        margin: 10px;
    }
    
</style>