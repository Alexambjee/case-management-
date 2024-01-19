<template>
  <div>
    <!-- navbar -->
    <Navbar/>
    <div id="layoutSidenav">
      <Sidebar/>
      <div id="layoutSidenav_content">
               <main>
            <div class="container-fluid px-4">
              <h1 class="mt-4">Under review cases</h1>
              <div class="breadcrumb mb-4 mt-3">
              <Breadcrumb>
              <BreadcrumbItem to="/reports" class="breadcrumb-item">Dashboard</BreadcrumbItem>
              <BreadcrumbItem to="/reports/under-review-cases" class="breadcrumb-item active">Under review cases</BreadcrumbItem>
          </Breadcrumb>
        </div>
              <div class="card shadow">
                <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
                  <caseTable :path="completedPath" :username="username" :caseStatus="caseStatus" :action="ApprovedAction" :role="role"/>
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
      caseStatus: [3],
      role:this.$store.state.userRole,
      username:this.$store.state.user.user_name,
      completedPath: '/reports/under-review-cases/',
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
  