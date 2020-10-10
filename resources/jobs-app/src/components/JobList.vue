<template>
  <div class="container-fluid" v-if="jobs.length">
    <div class="row">
      <div class="col-6">
        <h1>Available Jobs</h1>
        <p>
            Displaying {{totalDisplayJobsCount}} of {{ totalJobsCount }} job(s).
        </p> 
        <ul class="pagination" v-if="paginationLinks && paginationLinks.length">
          <li
          v-for="link of paginationLinks"
          :key="link.label"
          v-bind:class="{ active: link.active, hidden: !link.url }">
            <a href="#" @click="goToPage(link.label)"><strong>{{link.label}}</strong></a>
          </li>
        </ul>
        <a href="http://localhost" class="button" style="clear: both; text-align:left">See Laravel Eloquoent Version</a>
      </div>
      <div class="col-3">
          <input type="text" name="search" v-model="search" maxlength="200" @blur="searchJobs()">
      </div>

      <div class="col-1">
        <select v-model="sort_by" @change="searchJobs()">
          <option disabled value="">Sort By</option>
          <option value="Title">Title</option>
          <option value="company">Company</option>
          <option value="created_at">Date</option>
        </select>
      </div>

      <div class="col-1">
        <select v-model="direction" @change="searchJobs()">
          <option value="asc">Ascending</option>
          <option value="desc">Descending</option>
        </select>
      </div>

      <div class="col-1">
        <button type="submit" class="btn btn-sm btn-primary" @click="searchJobs()"> Search</button>
      </div>
      <div class="col-12">
          <div v-if="loading" class="alert alert-warning">Processing...Please wait</div>
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
  loading = false
  jobs = []
  paginationLinks = []
  currentPage = 1
  direction = 'asc'
  sort_by = ''
  totalDisplayJobsCount = 10
  totalJobsCount = 0

  search = ''

  mounted () {
    this._jobQuery('')
  }

  goToPage (pageno: any) {
    if (pageno === 'Next') pageno = this.currentPage + 1
    if (pageno === 'Previous') pageno = this.currentPage - 1

    let queryText = '&page=' + pageno

    if (this.search) queryText = queryText + '&search=' + this.search
    if (this.sort_by) queryText = queryText + '&sort=' + this.sort_by + '&direction=' + this.direction
    this._jobQuery(queryText)
  }

  searchJobs () {
    let queryText = '&search=' + this.search
    if (this.search === '') queryText = ''
    this._jobQuery(queryText)
  }

  private _jobQuery (query: string) {
    this.loading = true
    axios.get(this.API_URL + query)
      .then(response => {
        // JSON responses are automatically parsed.
        this.jobs = response.data.data
        this.paginationLinks = response.data.links
        this.currentPage = response.data.current_page
        this.totalJobsCount = response.data.total
        this.totalDisplayJobsCount = response.data.per_page
        this.loading = false
      })
      .catch(e => {
        console.log(e)
      })
    return false
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
