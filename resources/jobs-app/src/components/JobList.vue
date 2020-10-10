<template>
  <div class="container-fluid" v-if="jobs.length">
    <div class="row">
      <div class="col-6">
        <ul class="pagination" v-if="paginationLinks && paginationLinks.length">
          <li
          v-for="link of paginationLinks"
          :key="link.label"
          v-bind:class="{ active: link.active, hidden: !link.url }">
            <a href="#" @click="goToPage(link.label)"><strong>{{link.label}}</strong></a>
          </li>
        </ul>
      </div>
      <div class="col-4">
          <input type="text" name="search" v-model="search" maxlength="200">
      </div>

      <div class="col-1">
        <button type="submit" class="btn btn-sm btn-primary" @click="searchJobs()"> Search</button>
      </div>

      <div class="col-1">
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
import { Prop } from 'vue-property-decorator'
import axios from 'axios'

@Options({})
export default class JobList extends Vue {
  API_URL = 'http://localhost/?format=JSON'
  jobs = []
  paginationLinks = []
  currentPage = 1

  search = ''

  mounted () {
    this._jobQuery('')
  }

  goToPage (pageno: any) {
    if (pageno === 'Next') pageno = this.currentPage + 1
    if (pageno === 'Previous') pageno = this.currentPage - 1

    let queryText = '&page=' + pageno

    if (this.search) queryText = queryText + '&search=' + this.search
    this._jobQuery(queryText)
  }

  searchJobs () {
    if (this.search === '') return false
    this._jobQuery('&search=' + this.search)
  }

  private _jobQuery (query: string) {
    axios.get(this.API_URL + query)
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
  text-align: left;
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
