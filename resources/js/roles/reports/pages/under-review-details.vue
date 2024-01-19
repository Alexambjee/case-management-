<template>
    <div>
        <!-- navbar -->
        <Navbar :messagePath="data.messagePath" />
        <div id="layoutSidenav">
            <Sidebar :messagePath="data.messagePath" :channel="data.channel" />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">CASE DETAILS</h1>
                        <div class="breadcrumb mb-4 mt-3">
                            <Breadcrumb>
                                <BreadcrumbItem to="/reports" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                                <BreadcrumbItem to="/reports/under-review-cases" class="breadcrumb-item">Under review
                                    cases
                                </BreadcrumbItem>
                                <BreadcrumbItem :to="`/reports/sent-back-cases/${data.caseId}`"
                                    class="breadcrumb-item active">Case Details</BreadcrumbItem>
                            </Breadcrumb>
                        </div>
                        <!-- case details-->
                        <CaseDetails :case_id="data.caseId" :role="data.role" :Rstatus="data.Rstatus" :stage="data.stage"
                            :Astatus="data.Astatus" :Fstatus="data.Fstatus" :username="data.username" :Path="data.LocPath"
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
                channel: '/reports/progress-reports',
                actionTitle: 'VIEW',
                role: this.$store.state.userRole,
                username: this.$store.state.user.user_name,
                role_desc: this.$route.params.department,
                messagePath: '/reports/messages'

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
        //     window.location = '/'
        // }
        // else {

        // }
    }





}
</script>
