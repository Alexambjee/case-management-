<template>
    <div>
        <!-- navbar -->
        <Navbar />
        <div id="layoutSidenav">
            <!-- sidebar -->
            <Sidebar />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">REPORT DASHBOARD</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <router-link to="/reports/closed">
                                    <div
                                        class="card bg-primary text-white mb-4">
                                        <div
                                            class="card-body d-flex justify-content-between " >
                                           Closed cases
                                            <!-- <div class=" badge bg-white badge-count ">
                                                <span class="text-danger">{{ this.data.count }}</span>
                                            </div> -->
                                        </div>
                                        <div class=" card-footer  d-flex align-items-center  justify-content-between">
                                            <a class="small text-secondary stretched-link" href="#" >View Details</a>
                                            <div class="small text-primary">
                                                <i class="fas fa-angle-right" ></i>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <router-link to="/reports/numbers">
                                    <div
                                        class="card bg-warning text-white mb-4">
                                        <div
                                            class="card-body d-flex justify-content-between " >
                                           Case Count
                                            <!-- <div class=" badge bg-white badge-count ">
                                                <span class="text-danger">{{ this.data.count }}</span>
                                            </div> -->
                                        </div>
                                        <div class=" card-footer  d-flex align-items-center  justify-content-between">
                                            <a class="small text-secondary stretched-link" href="#" >View Details</a>
                                            <div class="small text-primary">
                                                <i class="fas fa-angle-right" ></i>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>

                            

                            <div class="col-xl-3 col-md-6">
                                <router-link to="/reports/progress">
                                    <div
                                        class="card bg-danger text-white mb-4">
                                        <div
                                            class="card-body d-flex justify-content-between " >
                                           Case Progress
                                            <!-- <div class=" badge bg-white badge-count ">
                                                <span class="text-danger">{{ this.data.count }}</span>
                                            </div> -->
                                        </div>
                                        <div class=" card-footer  d-flex align-items-center  justify-content-between">
                                            <a class="small text-secondary stretched-link" href="#" >View Details</a>
                                            <div class="small text-primary">
                                                <i class="fas fa-angle-right" ></i>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <router-link to="/reports">
                                    <div
                                        class="card bg-greeny text-white mb-4">
                                        <div
                                            class="card-body d-flex justify-content-between " >
                                           Extra
                                            <!-- <div class=" badge bg-white badge-count ">
                                                <span class="text-danger">{{ this.data.count }}</span>
                                            </div> -->
                                        </div>
                                        <div class=" card-footer  d-flex align-items-center  justify-content-between">
                                            <a class="small text-secondary stretched-link" href="#" >View Details</a>
                                            <div class="small text-primary">
                                                <i class="fas fa-angle-right" ></i>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </main>


        <!-- footer -->
        <Footer></Footer>
      </div>
    </div>

  </div>

</template>
<script>
import Footer from "../../components/footer.vue";
import Sidebar from "../../components/sidebar.vue";
import Navbar from "../../components/navbar.vue";
// charts
import chart from "../../components/charts/chart";
import barChart from "../../components/charts/bar-chart";
export default {
  
    
    data() {
        return {
            data:{
                username:this.$store.state.user.USER_NAME,
                role: this.$store.state.userRole,

            },}
  },
  components: {
    Footer,
    Sidebar,
    Navbar,
    chart,
    barChart,
  },
  
    
    async created() {
  
    }
    
}
</script>
