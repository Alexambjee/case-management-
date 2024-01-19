<template>
    <div>
        <!-- navbar -->
        <Navbar />
        <div id="layoutSidenav">
            <Sidebar/>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Details</h1>
                        <div class="breadcrumb mb-4 mt-3">
                                <Breadcrumb>
                                <BreadcrumbItem :to="'/department/' + $route.params.department" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                                <BreadcrumbItem :to="'/department/' + $route.params.department + '/completed-cases'" class="breadcrumb-item">Completed-cases</BreadcrumbItem>
                                <BreadcrumbItem :to="'/department/' + $route.params.department + '/completed-cases/'+ $data.caseId " class="breadcrumb-item active">Case Details</BreadcrumbItem>
                                </Breadcrumb>
                                            </div>

                        <!-- case details-->
                        <CaseDetails :case_id="data.caseId" :role="data.role"  :stage="data.stage"
                             :username="data.username" :Path="data.LocPath"
                            :actionTitle="data.actionTitle" />

                        <!-- case details ends-->
                    </div>

                    <!--details ends -->
                </main>

                <!-- footer -->
                <Footer></Footer>
            </div>
        </div>
    </div>

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
                stage: 'Details',
                LocPath: '/manager/mycases',
                channel: '/initiator/progress-reports',
                actionTitle: 'PRELIMINARY REPORT FINDINGS',
                progressPath: '/initiator/completed-cases',
                role:this.$store.state.userRole,
                username:this.$store.state.user.user_name,
                role_desc:this.$store.state.user.role.role_desc,
                messagePath: '/initiator/messages'

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
