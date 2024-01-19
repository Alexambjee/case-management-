<template>
    <div >
    <!-- navbar -->
    <Navbar />
         <div id="layoutSidenav">
         <Sidebar />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">CASES</h1>
                          <div class="breadcrumb mb-4 mt-3">
                             <Breadcrumb>
                              <BreadcrumbItem to="/reports" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                              <BreadcrumbItem @click="goBack" class="breadcrumb-item active">My cases</BreadcrumbItem>
                          </Breadcrumb>
                        </div>                   
                                  <div class="card detail-card mb-4">
                              <div class="card-header bg-dark text-light">
                                  <i class="fas fa-table me-1"></i>
                                 Cases
                              </div>
                              <caseTable :path="ApprovedProgress" :username="username" :caseStatus="caseStatus" :action="ApprovedAction" :column="column" :progressPath="progressPath" :role="role"/>
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
  import Footer from '../../components/footer.vue'
  import Sidebar from '../../components/sidebar.vue'
  import Navbar from '../../components/navbar.vue'
  import caseTable from '../../components/pages/caseTable.vue'
  export default {
    data(){
      return{
       
        caseStatus:[20,-14,16,18,14,-1,-2,-3,-12,-5,-6,0,1,2,3,5,6,7,8,12,13,-13,4,-4,9],
        progressPath: '/reports/progress/',
        username:this.$store.state.user.USER_NAME,
        role: this.$store.state.userRole,
        ApprovedAction: 'Details',
        NewAction: 'Start',
        ApprovedProgress:'/reports/progress/'
  
      }
  
    },

    methods : {
      goBack() {
      this.$router.go(-1);
    },
    }, 
    components : {
      Footer,
      Sidebar,
      Navbar,
      caseTable,
    },
    created() {
      
    }
  
  
  }
  </script>
  