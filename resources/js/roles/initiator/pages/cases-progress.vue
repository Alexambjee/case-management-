<template>
  <div>
    <!-- navbar -->
    <Navbar :messagePath="messagePath" />
    <div id="layoutSidenav">
      <Sidebar :channel="channel" :manualPath="manualPath" :progressPath="progressPath" />
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4">Progress</h1>

            <div class="breadcrumb mb-4 mt-3">
              <Breadcrumb>
              <BreadcrumbItem to="/initiator" class="breadcrumb-item">Dashboard</BreadcrumbItem>
              <BreadcrumbItem to="/initiator/cases-progress" class="breadcrumb-item active">Progress</BreadcrumbItem>
          </Breadcrumb>
          </div>

            <div class="card shadow">
              <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
                <caseTable :path="progressPath" :username="username" :caseStatus="caseStatus" :action="ApprovedAction"
                  :column="column" :initiator="initiator" :role ="role"/>
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
import Footer from '../../../components/footer.vue'
import Sidebar from '../../../components/sidebar.vue'
import Navbar from '../../../components/navbar.vue'
import caseTable from '../../../components/pages/caseTable.vue'
export default {
  data() {
    return {

      caseStatus: [4,3],
      progressPath: '/initiator/cases-progress/',
      role:this.$store.state.userRole,
      username:this.$store.state.user.user_name,
      column: 'MANAGER_PNO',
      manualPath: 'initiator/Manual-cases',
      channel: '/initiator/progress-reports',
      messagePath: '/initiator/messages',
      ApprovedAction: 'Details',
      NewAction: 'Start',
      ApprovedProgress: '/initiator/cases-progress/',
      initiator: false
    }

  },
  components: {
    Footer,
    Sidebar,
    Navbar,
    caseTable,
  },
  created() {

  }


}
</script>
  