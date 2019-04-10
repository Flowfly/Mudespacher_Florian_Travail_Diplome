<template>
  <v-app>
    <v-content class="content">
      <router-view></router-view>
    </v-content>
  </v-app>
</template>

<script>
import HelloWorld from './components/HelloWorld'

export default {
  name: 'App',
  components: {
    HelloWorld
  },
  data () {
    return {
    }
  },

}
</script>

<style>
  .content{
    background-image: url('assets/background.png');
  }
</style>
