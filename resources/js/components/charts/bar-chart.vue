
<template>
<div class="chart-wrapper">
    <apexchart
     width="500" type="bar" :options="options" ref="chart" :series="series" >
   </apexchart>
</div>
<!-- #7E36AF -->
</template>

<script>
export default {
  props:['column','username'],
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
          categories: [
            "Assessment Amt",
            "Objected Amt",
            "Accepted Amt",
            "Rejected Amt",
          ]
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
        colors: ['#0E86D4',
          "#FFA500",
          "#009900",
          "#F32013"
          // "#7DBA59",
          // "#13d8aa",
          // "#90ee7e"


        ],
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

    }
  },
  async created() {
    //   fetching the bargraph data
    const resBar = await  this.callApi('get',`/api/barData/${[this.column,this.username]}`)
    if (resBar.status == 200) {
          this.$refs.chart.updateSeries([{
            name: 'Revenue',
            data: resBar.data
          }])
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
