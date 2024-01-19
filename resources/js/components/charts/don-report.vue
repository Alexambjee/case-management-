<template>
  <div v-if="dept" class="chart-wrapper">
    <apexchart ref="bar" width="500" type="donut" :options="chartOptions" :series="series"></apexchart>
  </div>
  <div v-else class="chart-wrapper">
    <apexchart ref="bar" width="500" type="donut" :options="chartOptions1" :series="series"></apexchart>
  </div>
</template>

<script>
export default {
  props: ['column', 'username', 'dept'],
  data: function () {
    return {
      chartOptions: {
        labels: ["Case awaiting processing", "Cases in progress", "Cases under review", "Completed cases"],
        colors: ['#0341AE','#FF971C','#FF3213D9','#018667']
      },
      chartOptions1: {
        labels: ["Case awaiting processing", "Pending cases", "Completed cases"],
        colors: ['#0341AE', '#FF3213D9', '#018667']
      },
      role: this.$store.state.userRole,
      series: [],
    };
  },

  async created() {
    if (this.dept) {
      const resDon = await this.callApi('get', `/api/fetchReportData`);
      if (resDon.status == 200) {
        this.series = resDon.data;
      } else {
        this.swr('Something went wrong!');
      }
    } else {
      const resDon = await this.callApi('get', `/api/fetchReportDataDept/${this.role}`);
      if (resDon.status == 200) {
        this.series = resDon.data;
        
      } else {
        this.swr('Something went wrong!');
      }
    }
  },
}

</script>
