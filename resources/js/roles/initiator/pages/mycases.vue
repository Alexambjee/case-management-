<template>
  <div>
    <!-- navbar -->
    <Navbar />
    <div id="layoutSidenav">
      <Sidebar/>
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4">Tasks</h1>
            <div class="breadcrumb mb-4 mt-3">
              <Breadcrumb>
              <BreadcrumbItem to="/initiator" class="breadcrumb-item">Dashboard</BreadcrumbItem>
              <BreadcrumbItem to="/initiator/my-cases" class="breadcrumb-item active">My cases</BreadcrumbItem>
          </Breadcrumb>
        </div>
            <div class="card shadow">
              <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
                <caseTable :path="ApprovedPath" :username="username" :caseStatus="caseStatus" :action="ApprovedAction" :role ="role"/>
              </div>
            </div>
          </div>
        </main>
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
      caseStatus: [0],
      path: '/initiator/my-cases/',
      role:this.$store.state.userRole,
      username:this.$store.state.user.user_name,
      progressPath: 'initiator/cases-progress',
      ApprovedAction: 'View',
      NewAction: 'Start',
      ApprovedPath: '/initiator/my-cases/',
      completedPath: '/initiator/completed-cases/',
    }

  },
  components: {
    Footer,
    Sidebar,
    Navbar,
    caseTable,
  },
  created() {
    console.log(this.$store.state)
  }


}
</script>
