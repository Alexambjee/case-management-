<template>
    <div>
        <!-- navbar -->
        <Navbar />
        <div id="layoutSidenav">
            <Sidebar />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">ADMIN DASHBOARD</h1>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <router-link to="/admin/progress-cases">
                                    <div class="card  text-white mb-4 shadow" style="background: #0341AE;">
                                            <div class="card-body d-flex justify-content-between ">
                                            Cases
                                            <span class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
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
                            <div class="col-xl-3 col-md-6">
                                <router-link to="/admin/user-management">
                                    <div class="card bg-warning text-white mb-4">
                                        <div class=" card-body d-flex justify-content-between">
                                            User and role Management
                                            <!-- <div class=" badge bg-white badge-count">
                                                <span class="text-danger">0</span>
                                            </div> -->
                                        </div>
                                        <div class=" card-footer d-flex align-items-center justify-content-between ">
                                            <a class="small  text-secondary stretched-link " href="#">View Details</a>
                                            <div class="small text-warning">
                                                <i class="fas fa-angle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <router-link to="/admin/system-management">
                                    <div class="card bg-danger text-white mb-4">
                                        <div class="card-body d-flex justify-content-between">
                                            System Management
                                            <!-- <div class="badge bg-white badge-count"><span class="text-danger">0</span></div> -->
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="#">View Messages</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <router-link to="/admin/completed-cases">
                                    <div class="card text-white mb-4" style="background: #018667;">
                                        <div class="card-body d-flex justify-content-between">
                                            Completed cases
                                            <span class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
                                            background:#fff !important; color:#018667; display: flex; justify-content: center; align-items:center; text-align:center;
                                            border-radius:50%; padding: auto;">

                                                {{ count[3] }}
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
                                            :dept="true" />
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
    <!-- if not authorized -->

    <!-- if not authorized  ends-->
</template>
<script>
import Footer from "../../components/footer.vue";
import Sidebar from "../../components/sidebar.vue";
import Navbar from "../../components/navbar.vue";
// charts
import chart from "../../components/charts/don-report";
import barChart from "../../components/charts/bar-report";
export default {
    // props: ['user', 'role'],

    data() {
        return {
            data: {
                column: ['AM_PNO'],
                username: "",
                role: "",
                AsStatus: [26],
                messagePath: '/admin/messages',
                manualPath: 'admin/Manual-cases',
                RolePath: '/admin/Temporary-role-change',
                closedPath: '/admin/closed-cases',
                progressPath: 'admin/cases-progress',
            },
            count:[]
        }
    },
    components: {
        Footer,
        Sidebar,
        Navbar,
        chart,
        barChart,
    },


    async created() {
        const resDon = await this.callApi('get', `/api/fetchReportData`);
        if (resDon.status == 200) {
            this.count = resDon.data;
        } else {
            this.swr('Something went wrong!');
        }

    }


}
</script>
