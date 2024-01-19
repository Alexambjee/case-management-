<template>
  <div v-if="($store.state.user) && ($store.state.userRole == 'admin')">
    <!-- navbar -->
    <Navbar  />
    <div id="layoutSidenav">
      <Sidebar />
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h1 class="mt-4">USER MANAGEMENT</h1>
            <div class="breadcrumb mb-4 mt-3">
              <Breadcrumb>
                <BreadcrumbItem to="/admin" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                <BreadcrumbItem to="/admin/user-management" class="breadcrumb-item active">User management</BreadcrumbItem>
              </Breadcrumb>
            </div>

            <div class="card">
              <!-- headers -->
              <!-- <div class="d-flex justify-content-around">
                            <div class=" col-md-2 text-center ml-auto mr-5" id="headingOne">
                                <h5 class="mb-0 shadow" style="border:1px solid orange;">
                                    <button class="btn" data-toggle="collapse" data-target="#awaiting"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    <i class="fas fa-refresh text-warning me-1"></i>
                                    user management -->
              <!-- <span class=" badge" style="font-size:13px; width:22px !important; height:22px !important;
                                    background:orange !important; color:#fff ;  align-items:center; text-align:center;
                                    position:absolute; border-radius:50%; margin-top:-5px;">
                                   1
                                    </span> -->
              <!-- </button>
                                </h5>
                            </div> -->
              <!-- 
                            <div class=" col-md-2 text-center  mr-auto ml-5" id="">
                                <h5 class="mb-0 shadow" style="border:1px solid skyblue;">
                                    <button class="btn collapsed" data-toggle="collapse"
                                    data-target="#Response" aria-expanded="false" aria-controls="#Response">
                                     <i class="fa fa-check text-success fa-1x me-1"></i>
                                     Role Management
                                  <span class=" badge" style="font-size:14px; width:22px !important; height:22px !important;
                                    background:skyblue !important; color:#fff ;  align-items:center; text-align:center;
                                    position:absolute; border-radius:50%; margin-top:-5px;">
                                    1</span> 
                                    </button>
                                </h5>
                            </div> -->

              <!-- </div> -->
              <!-- headers ends -->
              <!-- <div id="accordion" class="col-lg-12 mt-3" style="width:100%"> -->
              <!-- awaiting taxpayer response -->
              <!-- <div class="card shadow"> -->
              <!-- <div id="awaiting" class="collapse" aria-labelledby="awaiting" data-parent="#accordion"> -->

              <!-- <div class="card-header bg-dark text-muted "> -->
              <!-- <i class="fas fa-refresh text-warning me-1"></i> -->
              <!-- user management -->
              <!-- </div> -->
              <!-- Role assignment tab -->
              <Role_as />

              <!-- </div> -->
              <!-- </div> -->
              <!-- Role Allocation -->
              <!-- <Role_ui/> -->
              <!-- </div> -->
            </div>
          </div>
        </main>
        <!-- footer -->
        <Footer />
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
import Role_ui from './role-management.vue'
import Role_as from './AssignRole.vue'
export default {
  data() {
    return {
      data: {
        id: '',
        ROLE_NAME: '',
        roleDesc: '',
        username: "",
        role: "",
        // USER_NAME
      },

    }
  },
  components: {
    Footer,
    Sidebar,
    Navbar,
    Role_ui,
    Role_as
  },
}
</script>