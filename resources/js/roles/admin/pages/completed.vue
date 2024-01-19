<template>
  <div v-if="($store.state.user) && ($store.state.userRole == 'admin')">
    <!-- navbar -->
     <Navbar />
    <div id="layoutSidenav">
      <Sidebar />
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4">Completed cases</h1>
            <div class="breadcrumb mb-4 mt-3">
              <Breadcrumb>
                <BreadcrumbItem to="/admin" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                <BreadcrumbItem to="/admin/completed-cases" class="breadcrumb-item active">Completed cases
                </BreadcrumbItem>
              </Breadcrumb>
            </div>

            <div class="card">
              <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
                <caseTable :path="ApprovedPath" :username="username" :caseStatus="caseStatus" :action="ApprovedAction"
                  :column="column" :initiator="initiator" :role="role" />
              </div>
            </div>

          </div>

          <!--details ends -->
        </main>

        <!-- footer -->
        <Footer></Footer>
      </div>
    </div>
  </div>
  <!-- if not authorized -->
  <div v-else>
    <div class="col-md-5" style="margin:auto ">
      <div class="card shadow mt-5">
        <div class="card-body">
          <div id="layoutSidenav_content">
            <main>
              <div class="container-fluid px-4">
                <span class="text-danger">Access Denied. You Don't Have Enough
                  Permissions to Access This Profile!</span>
              </div>
            </main>
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- if not authorized  ends-->
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
      completedPath: '/admin/completed-cases/',
      ApprovedAction: 'View',
      ApprovedPath: '/admin/completed-cases/',
      initiator: false,
    }


  },

  components: {
    Footer,
    Sidebar,
    Navbar,
    caseTable,
    // name:casesPrgress

  },
  created() {
    if (!this.$store.state.user) {
      window.location = '/'
      this.warning("Access Denied. You Don't Have Enough Permissions to Access This Profile!")

    }
    else {

    }
  }




}
</script>
