<template>
  <div v-if="($store.state.user) && ($store.state.userRole == 'Admin' || $store.state.userRole =='Super')">
  <!-- navbar -->
    <Navbar v-if="$store.state.user" :user="$store.state.user" :messagePath="messagePath"/>
       <div id="layoutSidenav">
       <Sidebar v-if="$store.state.user" :user="$store.state.user" :messagePath="messagePath" :channel="channel" />
          <div id="layoutSidenav_content">
              <main>
                  <div class="container-fluid px-4">
                      <h1 class="mt-4">MESSAGE INBOX</h1>
                        <div class="breadcrumb mb-4 mt-3">
                           <Breadcrumb>
                            <BreadcrumbItem to="/admin" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                            <BreadcrumbItem to="/admin/messages" class="breadcrumb-item">Messages</BreadcrumbItem>
                        </Breadcrumb>
                      </div>
                      <!-- include message component -->
                      <message/>
                      <!-- include message component ends-->

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
          <!-- error card -->
              <div id="layoutSidenav_content">
                  <main>
                      <div class="container-fluid px-4">
                    <span class="text-danger">Access Denied. You Don't Have Enough
                    Permissions to Access This Route!</span>
                      </div>
                  </main>
            <!-- footer -->
          </div>
          <!-- error card ends -->

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
import message from '../../../components/pages/message.vue'
export default {
  data(){
    
    return {
      data:{
           
           manualPath: 'admin/Manual-cases',
           RolePath:'/admin/Temporary-role-change', 
           closedPath:'/admin/closed-cases',
           progressPath: 'admin/cases-progress',
           messagePath:'/admin/messages',
      channel: '/admin/progress-reports',
        },

      messagePath:'/admin/messages',
      channel: '/admin/progress-reports',

    }


  },

  components : {
    Footer,
    Sidebar,
    Navbar,
    message
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
