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