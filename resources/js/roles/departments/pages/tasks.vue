<template>
  <div>
    <!-- navbar -->
    <Navbar/>
    <div id="layoutSidenav">
      <Sidebar />
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
           <h1 class="mt-4" style="text-transform: uppercase;">{{this.$route.params.department}}'s Tasks</h1>
            <div class="breadcrumb mb-4 mt-3">
              <Breadcrumb>
              <BreadcrumbItem :to="'/department/' + $route.params.department" class="breadcrumb-item">Dashboard</BreadcrumbItem>
              <BreadcrumbItem :to="'/department/' + $route.params.department + '/tasks'" class="breadcrumb-item active">My cases</BreadcrumbItem>
          </Breadcrumb>
        </div>

            <div class="card shadow">
              <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
                <caseTable :path="ApprovedPath" :username="username" :caseStatus="caseStatus" :action="ApprovedAction"
                 :role="role" :column="role_desc" :role_desc="role_desc"/>
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

      caseStatus: [1],
      role:this.$store.state.userRole,
      username:this.$store.state.user.user_name,
      role_desc:this.$store.state.user.role.role_desc,
      progressPath: `/department/${this.$route.params.department}/tasks`,
      ApprovedAction: 'View',
      NewAction: 'start',
      ApprovedProgress: `/department/${this.$route.params.department}/tasks/`,
      ApprovedPath: `/department/${this.$route.params.department}/tasks/`,

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
  