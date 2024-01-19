<template>
    <div>
        <!-- navbar -->
        <Navbar :messagePath="data.messagePath" />
        <div id="layoutSidenav">
            <Sidebar :messagePath="data.messagePath" :channel="data.channel" />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Details</h1>
                        <div class="breadcrumb mb-4 mt-3">
                                <Breadcrumb>
                                <BreadcrumbItem :to="'/department/' + $route.params.department" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                                <BreadcrumbItem :to="'/department/' + $route.params.department + '/pending'" class="breadcrumb-item">pending</BreadcrumbItem>
                                <BreadcrumbItem :to="'/department/' + $route.params.department + '/pending/'+ $data.caseId " class="breadcrumb-item active">Case Details</BreadcrumbItem>
                                </Breadcrumb>
                                            </div>
                        <!-- case details-->
                        <CaseDetails :case_id="data.caseId" :role="data.role" :stage="data.stage" :stage2="data.stage2"
                           :title="data.title" :username="data.username"
                            :Path="data.LocPath" :actionTitle="data.actionTitle" />

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
                LocPath: `/department/${this.$route.params.department}/pending`,
                actionTitle: 'CLEAR',
                stage: 'pending',
                stage2:'pending',
                role:this.$store.state.userRole,
                username:this.$store.state.user.user_name,
                action: 'Details',
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
