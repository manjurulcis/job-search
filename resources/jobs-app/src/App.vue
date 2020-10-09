<template>
  <img alt="Vue logo" :src="url + '/img/logo.png'">
  <JobList @changeUserName="changeUserName($event)" msg="Welcome to Your Vue.js + TypeScript App"/>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component'
import JobList from './components/JobList.vue'

@Options({
  components: {
    JobList
  }
})
export default class App extends Vue {
  url = '/dist'

  jobs = []

  created () {
    console.log('created')
  }

  mounted () {
    console.log('mounted')
  }

  changeUserName($event) {
    console.log($event.value)
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
