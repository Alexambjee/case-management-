<template>
    <div>
        <Navbar />
        <div id="layoutSidenav">
            <Sidebar />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4" style="text-transform: uppercase;">{{ title }}</h1>
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <router-link :to="tasksPath">
                                    <div class="card  text-white mb-4 shadow" style="background: #0341AE;">
                                        <div class="card-body d-flex justify-content-between ">
                                            Tasks
                                            <span v-if="role != 'own_department'" class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
                                            background:#fff !important; color:#0341AE; display: flex; justify-content: center; align-items:center; text-align:center;
                                            border-radius:50%; padding: auto;">

                                                {{ count[0] }}
                                            </span>

                                        </div>
                                        <div class=" card-footer  d-flex align-items-center  justify-content-between">
                                            <a class="small text-secondary stretched-link" href="#">View Details</a>
                                            <div class="small text-primary">
                                                <i class="fas fa-angle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>

                            <div class="col-xl-4 col-md-6">
                                <router-link :to="pendingPath">
                                    <div class="card  text-white mb-4" style="background:#FF3213D9;">
                                        <div class=" card-body d-flex justify-content-between">
                                            Pending
                                            <span v-if="role != 'own_department'" class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
                                            background:#fff !important; color:#FF3213D9; display: flex; justify-content: center; align-items:center; text-align:center;
                                            border-radius:50%; padding: auto;">

                                                {{ count[1] }}
                                            </span>
                                        </div>
                                        <div class=" card-footer d-flex align-items-center justify-content-between ">
                                            <a class="small  text-secondary stretched-link " href="#">View Details</a>
                                            <div class="small text-danger">
                                                <i class="fas fa-angle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>

                            <div class="col-xl-4 col-md-6">
                                <router-link :to="completedPath">
                                    <div class="card text-white mb-4" style="background: #018667;">
                                        <div class="card-body d-flex justify-content-between">
                                            Completed
                                            <span v-if="role != 'own_department'" class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
                                            background:#fff !important; color:#018667; display: flex; justify-content: center; align-items:center; text-align:center;
                                            border-radius:50%; padding: auto;">

                                                {{ count[2] }}
                                            </span>
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-secondary stretched-link" href="#">View Details</a>
                                            <div class="small text-success"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>



                        </div>
                        <!-- row ends/ -->

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Progress of Cases
                                    </div>
                                    <div class="card-body">
                                        <chart :column="data.column" :username="data.username" :AsStatus="data.AsStatus"
                                            :dept="false" />
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-xl-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Staff exit per departments
                                    </div>
                                    <div class="card-body">
                                        <barChart :column="data.column" :username="data.username" />
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>


                </main>


                <!-- footer -->
                <Footer></Footer>
            </div>
        </div>
        <!-- home test ends-->
    </div>
</template>
<script>
import Footer from "../../components/footer.vue";
import Sidebar from "../../components/sidebar.vue";
import Navbar from "../../components/navbar.vue";
// charts
import chart from "../../components/charts/don-report";
import barChart from "../../components/charts/bar-chart";


export default {
    data() {
        return {
            data: {
                column: ['AM_PNO'],
                username: "",
                role: "",
                AsStatus: [26],

            },
            count: [],
            department: this.$route.params.department,
            messagePath: `/department/${this.$route.params.department}/messages`,
            title: this.$route.params.department,
            tasksPath: `/department/${this.$route.params.department}/tasks`,
            completedPath: `/department/${this.$route.params.department}/completed-cases`,
            pendingPath: `/department/${this.$route.params.department}/pending`,
            RolePath: `/department/${this.$route.params.department}/Temporary-role-change`,
            role: this.$store.state.userRole,

        }
    },
    async created() {

        const resDon = await this.callApi('get', `/api/fetchReportDataDept/${this.role}`);

        if (resDon.status == 200) {
            this.count = resDon.data;
        } else {
            this.swr('Something went wrong!');
        }


    },

    components: {
        Footer,
        Sidebar,
        Navbar,
        chart,
        barChart,
    },




}
</script>
