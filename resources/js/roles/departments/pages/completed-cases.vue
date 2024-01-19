<template>
  <div>
    <!-- navbar -->
    <Navbar/>
    <div id="layoutSidenav">
      <Sidebar/>
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4" style="text-transform: uppercase;">{{this.$route.params.department}}'s Completed</h1>
            <div class="breadcrumb mb-4 mt-3">
                                <Breadcrumb>
                                <BreadcrumbItem :to="'/department/' + $route.params.department" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                                <BreadcrumbItem :to="'/department/' + $route.params.department + '/completed-cases'" class="breadcrumb-item active">Completed-cases</BreadcrumbItem>
                          
                                </Breadcrumb>
                                            </div>
            <div class="card shadow">
              <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
                <caseTable :path="ApprovedPath" :username="username" :caseStatus="caseStatus" :action="ApprovedAction"
                :role="role" :role_desc="role_desc" :column="role_desc" />
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
      caseStatus: [2],
      ApprovedAction: 'Details',
      NewAction: 'View',
      username:this.$store.state.user.user_name,
      role_desc:this.$store.state.user.role.role_desc,
      role:this.$store.state.userRole,
      progressPath: `/department/${this.$route.params.department}/completed-cases`,
      manualPath: `/department/${this.$route.params.department}/Manual-cases`,
      channel: `/department/${this.$route.params.department}/progress-reports`,
      messagePath: `/department/${this.$route.params.department}/messages`,
      ApprovedProgress: `/department/${this.$route.params.department}/completed-cases/`,
      ApprovedPath: `/department/${this.$route.params.department}/completed-cases/`,
    
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
  