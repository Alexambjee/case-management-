<template>
  <div>
    <!-- navbar -->
    <Navbar />
    <div id="layoutSidenav">
      <Sidebar />
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4">Completed</h1>
            <div class="breadcrumb mb-4 mt-3">
              <Breadcrumb>
                <BreadcrumbItem to="/reports" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                <BreadcrumbItem to="/reports/completed-cases" class="breadcrumb-item active">Completed cases
                </BreadcrumbItem>
              </Breadcrumb>
            </div>


            <div class="card shadow">
              <!-- <div class="card-header bg-dark text-muted ">
                <i class="fas fa-refresh text-warning me-1"></i>
                Completed cases
              </div> -->
              <!-- card-header ends -->
              <caseTable :path="completedPath" :username="username" :caseStatus="caseStatus" :action="ApprovedAction"
                :role="role" />
              <!-- awaiting response table ends -->

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
      caseStatus: [2],
      role: this.$store.state.userRole,
      username: this.$store.state.user.user_name,
      completedPath: '/reports/completed-cases/',
      ApprovedAction: 'Details',
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
  