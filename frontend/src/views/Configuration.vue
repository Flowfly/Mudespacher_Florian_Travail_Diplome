<!--
 Florian Mudespacher
 Quiz interactif - Diploma work
 CFPT - T.IS-E2A - 2019
-->
<template>
  <v-container fluid fill-height>
    <inputconfiguration />
  </v-container>
</template>

<script>
  import inputconfiguration from '../components/InputConfiguration'

  export default {
    components: {
      inputconfiguration
    },
  }
</script>
<style>
  input{
    text-align: left;
  }
</style>