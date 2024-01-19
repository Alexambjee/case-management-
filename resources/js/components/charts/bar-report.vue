
<template>
  <div class="chart-wrapper">
    <apexchart width="500" type="bar" :options="options" ref="bar" :series="series">
    </apexchart>
  </div>
  <!-- #7E36AF -->
</template>

<script>
export default {
  props: ['column', 'username'],
  data() {
    return {

      // chart
      options: {
        chart: {
          width: '100%'
        },
        bar: {
          barWidth: '20px'
        },
        animations: {
          speed: 200
        },
        noData: {
          text: 'Loading...'
        },
        xaxis: {
          categories: this.departments
        },
        title: {
          align: 'left',
          style: {
            fontSize: '16px',
          },

        },
        plotOptions: {
          bar: {
            distributed: true,
            vertical: true,
            barHeight: "5%"
          }
        },

        opacity: 0.5,
        stroke: {
          show: true,
          curve: 'smooth',
          lineCap: 'butt',
          colors: undefined,
          width: 2,
          dashArray: 0,
          barHeight: "50%",
          distributed: true,

        },

      },
      series: [],
      departments: []

    }
  },
  async created() {
    //   fetching the bargraph data
    const resBar = await this.callApi('get', `/api/getReportBarData`)
    if (resBar.status == 200) {
      var deptValues = [];
      var exitsValues = [];

      seriesData.forEach(function (item) {
        deptValues.push(item.dept);
        exitsValues.push(item.exits);
      });

      this.departments = deptValues;

      this.$refs.chart.updateSeries([{
        name: 'StaffExits',
        data: exitsValues
      }]);
    }
    else {
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
