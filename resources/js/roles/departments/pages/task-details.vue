<template>
    <div>
        <!-- navbar -->
        <Navbar />
        <div id="layoutSidenav">
            <Sidebar />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Details</h1>
                        <div class="breadcrumb mb-4 mt-3">
              <Breadcrumb>
              <BreadcrumbItem :to="'/department/' + $route.params.department" class="breadcrumb-item">Dashboard</BreadcrumbItem>
              <BreadcrumbItem :to="'/department/' + $route.params.department + '/tasks'" class="breadcrumb-item active">My cases</BreadcrumbItem>
            <BreadcrumbItem :to="'/department/' + $route.params.department + '/tasks/'+ $data.caseId " class="breadcrumb-item active">Case Details</BreadcrumbItem>

                            </Breadcrumb>
                        </div>

                        <!-- case details-->
                        <CaseDetails :case_id="data.caseId" :role="data.role" :Rstatus="data.Rstatus" :stage="data.stage"
                            :Astatus="data.Astatus" :Fstatus="data.Fstatus" :username="data.username" :Path="data.LocPath"
                            :actionTitle="data.actionTitle" :initiator="data.initiator" :other="data.other" />

                        <!-- case details ends-->
                    </div>

                    <!--details ends -->
                </main>

                <!-- footer -->
                <Footer></Footer>
            </div>
        </div>
    </div>
    <!-- if not authorized -->
    <!-- <div v-else>
            <div class="col-md-5" style="margin:auto ">
            <div class="card shadow mt-5">
            <div class="card-body">
                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid px-4">
                        <span class="text-danger">Access Denied. You Don't Have Enough
                        Permissions to Access This Route!</span>
                        </div>
                    </main>
                    </div>

                </div>
            </div>
            </div>
        </div> -->
    <!-- if not authorized  ends-->
</template>
<script>
import Footer from '../../../components/footer.vue'
import Sidebar from '../../../components/sidebar.vue'
import Navbar from '../../../components/navbar.vue'
import CaseDetails from '../../../components/pages/casedetails.vue'

export default {
    data() {
        return {
            data: {
                caseId: this.$route.params.caseId,
                initiator: false,
                other: true,
                stage: 'view_dept',
                LocPath: `/department/${this.$route.params.department}/mycases`,
                actionTitle: 'CLEAR',
                progressPath: `/department/${this.$route.params.department}/cases-progress`,
                username:this.$store.state.user.user_name,
                role:  this.$store.state.userRole,

            },
        };
    },
    components: {
        Footer,
        Sidebar,
        Navbar,
        CaseDetails

    },
    methods: {

    },
    created() {
        // if (!this.$store.state.user) {
        //     this.warning("Access Denied. You Don't Have Enough Permissions to Access This Route!")
        //     window.location ='/'
        // }
        // else {

        // }
    }





}
</script>
