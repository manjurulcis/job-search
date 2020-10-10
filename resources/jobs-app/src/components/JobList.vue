<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-6">
        <ul v-if="paginationLinks && paginationLinks.length">
          <li
          v-for="link of paginationLinks"
          :key="link.label"
          v-bind:class="{ active: link.active, hidden: link.label == 'NEXT' || link.label == 'PREVIOUS' || !link.url }">
            <a href="#" @click="goToPage(link.label)"><strong>{{link.label}}</strong></a>
          </li>
        </ul>
      </div>
      <div class="col-6">
      </div>
      <div class="col-12">
          <table class="table table-bordered table-hover">
              <thead>
                  <th>ID</th>
                  <th>Job Title</th>
                  <th>Description</th>
                  <th>Company Name</th>
                  <th>Published On</th>
              </thead>
              <tbody>
                  <tr v-if="!jobs.length">
                      <td colspan="5">No job to display. <a class="btn btn-primary" href="/refreshjobs">Click Here to Refresh Jobs</a></td>
                  </tr>
                  <tr v-for="job of jobs"
                      :key="job.id">
                        <td>{{ job.id }}</td>
                        <td>{{ job.title }}</td>
                        <td class="text-wrap">{{ job.description }}</td>
                        <td class="text-wrap">{{ job.company }}</td>
                        <td>{{ job.created_at }}</td>
                  </tr>
              </tbody>
          </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component'
import axios from 'axios'

@Options({})
export default class JobList extends Vue {
  jobs = []
  paginationLinks = []
  currentPage = 1

  mounted () {
    this.getJobs()
  }

  getJobs () {
    axios.get('http://localhost/?format=JSON')
      .then(response => {
        // JSON responses are automatically parsed.
        this.jobs = response.data.data
        this.paginationLinks = response.data.links
        this.currentPage = response.data.current_page
      })
      .catch(e => {
        console.log(e)
      })
  }

  goToPage (pageno: number) {
    axios.get('http://localhost/?format=JSON&page=' + pageno)
      .then(response => {
        // JSON responses are automatically parsed.
        this.jobs = response.data.data
        this.paginationLinks = response.data.links
        this.currentPage = response.data.current_page
      })
      .catch(e => {
        console.log(e)
      })
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 5px;
  padding: 5px;
}

a {
  color: #42b983;
}

li.active a:visited, li.active a:link {
    color: #42082f !important;
}

li.hidden {
  display: none
}
</style>
