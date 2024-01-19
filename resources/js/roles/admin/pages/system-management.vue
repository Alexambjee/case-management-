<template>
    <div v-if="($store.state.user) && ($store.state.userRole == 'admin')">
        <!-- navbar -->
        <Navbar :messagePath="messagePath" />
        <div id="layoutSidenav">
            <Sidebar :messagePath="messagePath" :channel="channel" :closedPath="closedPath" />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">System management</h1>
                        <div class="breadcrumb mb-4 mt-3">
                            <Breadcrumb>
                                <BreadcrumbItem to="/admin" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                                <BreadcrumbItem to="/admin/system-management" class="breadcrumb-item active">System
                                    management</BreadcrumbItem>
                            </Breadcrumb>
                        </div>

                        <!-- reverted cases -->
                        <SystemManager :path="SentbackPath" :username="username" :caseStatus="caseStatus"
                            :caseStatusM="caseStatusM" :caseStatusF="caseStatusF" :ApprovedAction="ApprovedAction"
                            :column="column" />


                    </div>
                </main>

                <!-- footer -->
            </div>
        </div>
    </div>
    <div v-else>
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
    </div>
</template>
<script>
import Footer from '../../../components/footer.vue'
import Sidebar from '../../../components/sidebar.vue'
import Navbar from '../../../components/navbar.vue'
import SystemManager from '../../../components/pages/SystemManager.vue'

export default {
    data() {
        return {
            caseStatus: [-1],
            caseStatusF: [-3, -5],
            caseStatusM: [-12],
            SentbackPath: '/Account-manager/sent-back-cases/',
            // username: this.$store.state.user.USER_NAME,
            // role: this.$store.state.userRole,
            column: 'AM_PNO',
            channel: '/Account-manager/progress-reports',
            messagePath: '/manager/messages',
            ApprovedAction: 'Details',
            closedPath: '/Account-manager/closed-cases/'
        }


    },
    components: {
        Footer,
        Sidebar,
        Navbar,
        SystemManager
    },
    created() {

        if (!this.$store.state.user) {
            this.warning("Access Denied. You Don't Have Enough Permissions to Access This Route!")
            window.location = '/'
        }
        else {

        }

    }



}
</script>
