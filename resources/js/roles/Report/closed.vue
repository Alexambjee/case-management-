<template>
    <div >
    <!-- navbar -->
      <Navbar />
         <div id="layoutSidenav">
         <Sidebar />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">CLOSED CASES</h1>
                          <div class="breadcrumb mb-4 mt-3">
                             <Breadcrumb>
                              <BreadcrumbItem to="/reports" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                              <BreadcrumbItem to="/reports/closed" class="breadcrumb-item active">My cases</BreadcrumbItem>
                          </Breadcrumb>
                        </div>                   
                                  <div class="card detail-card mb-4">
                              <div class="card-header bg-dark text-light">
                                  <i class="fas fa-table me-1"></i>
                                 Cases
                              </div>
                              <caseTable :path="ApprovedProgress" :username="username" :caseStatus="caseStatus" :action="ApprovedAction" :column="column" :progressPath="progressPath" :role="role" />
                          </div>                  
                    </div>
                </main>
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
       
        caseStatus:[11],
        progressPath: '/reports/closed',
        username:this.$store.state.user.USER_NAME,
        role: this.$store.state.userRole,
        ApprovedAction: 'Details',
        NewAction: 'Start',
        ApprovedProgress:'/reports/closed'
  
      }
  
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
  