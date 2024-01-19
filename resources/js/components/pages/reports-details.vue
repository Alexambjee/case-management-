<template>
<div>
<!-- table card -->
 <div class="card-body">
    <table id="cmt-data-table" class="table table-striped table-bordered table-hover" style="width:100%">
    <thead>
        <tr>
            
            <th>Response from Taxpayer</th>
            <th>Appealed Cases</th>
            <th>Completed cases</th>                               
            <th>Reassigned Cases</th> 
            <th>Rejected Cases</th> 
        </tr>
    </thead>
          <tbody>
            <tr>
                <td>{{ data.response }}</td>
                <td>{{ data.appealed }}</td>
                <td>{{ data.completed }}</td>
                <td>{{ data.reassigned }}</td>
                <td>{{ data.rejected }}</td>
            </tr>
          </tbody>
            </table>
            <div class="card-body">
                     <barChart/>
                </div>
        

    </div>
<!-- table card ends-->
</div>
</template>

<script>
import Footer from '../../components/footer.vue'
import Sidebar from '../../components/sidebar.vue'
import Navbar from '../../components/navbar.vue'
// barchart
import barChart from '../../components/charts/bar-chart'

export default {
  data(){
        return {
            data: {
                response:'',
                appealed:'',
                completed:'',
                reassigned:'',
                rejected:'',
                username:this.$store.state.user.USER_NAME,
            }             
    }
     },
  components : {
    Footer,
    Sidebar,
    Navbar,
    barChart
     },
    async created(){
        const [resResponse, resAppealed,resCompleted, resReassigned, resRejected]= await Promise.all([
            this.callApi('get',`/api/ResponseTotal/${this.data.username}`),
            this.callApi('get',`/api/AppealedTotal/${this.data.username}`),
            this.callApi('get',`/api/CompletedTotal/${this.data.username}`),
            this.callApi('get',`/api/ReassignedTotal/${this.data.username}`),
            this.callApi('get',`/api/RejectedTotal/${this.data.username}`),
      ])
    //   total response
      if(resResponse.status==200){
          this.data.response = resResponse.data
      }
      else{
        this.swr('Something went wrong!')
      }
    //   total appealed
      if(resAppealed.status==200){
          this.data.appealed = resAppealed.data
      }
      else{
        this.swr('Something went wrong!')
      }

    //  total completed
      if(resCompleted.status==200){
          this.data.completed = resCompleted.data
      }
      else{
        this.swr('Something went wrong!')
      }
       //   total reassigned
      if(resReassigned.status==200){
          this.data.reassigned= resReassigned.data
      }
      else{
        this.swr('Something went wrong!')
      }
       //   total rejected
      if(resRejected.status==200){
          this.data.rejected = resRejected.data
      }
      else{
        this.swr('Something went wrong!')
      }

    }
}
</script>
