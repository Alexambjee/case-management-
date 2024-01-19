<template>
      <!-- <div class="card mb-4 shadow">
          <div class="card-header">
              <i class="fas fa-chart-bar me-1"></i>
              Revenue Amount
          </div>
          <div class="card-body"> -->
          <!-- chart wrapper -->
            <div class="chart-wrapper">
              <apexchart 
              ref="donut" width="500" type="donut" :options="chartOptions" :series="series">
            </apexchart>  
          </div>
          <!-- chart wrapper ends-->
          <!-- </div>
      </div> -->
  <!-- </div> -->
                          


</template>

<script>
export default {
  props:['column','username'],
  data: function() {
    return {
      chartOptions: {
        labels: [ "Assigned", "InProgress","Completed"],
      },
      series:[]
    }
  },
  async created(){
    //   fetching the donught data
    const resDon = await this.callApi('get',`/api/donData/${[this.column,this.username]}`)
    if(resDon.status==200){
      this.series = resDon.data
    }
    else{
      this.swr('Something went wrong!')
    }
  }
   
}
</script>

<style scoped>
div.chart-wrapper {
  display: flex;
  align-items: center;
  justify-content: center
}
</style>