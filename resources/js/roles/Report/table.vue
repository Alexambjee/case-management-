<template>
    <div >
    <!-- navbar -->
      <Navbar />
         <div id="layoutSidenav">
         <Sidebar />
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">{{title}}  cases</h1>
                          <div class="breadcrumb mb-4 mt-3">
                             <Breadcrumb>
                              <BreadcrumbItem to="/reports" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                              <BreadcrumbItem to="/reports/numbers" class="breadcrumb-item active">My cases</BreadcrumbItem>
                              <BreadcrumbItem  class="breadcrumb-item active">Case at the stage</BreadcrumbItem>
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
        caseStatus:[],
        title:'',
        progressPath: '/reports/progress/',
        username:this.$store.state.user.USER_NAME,
        role: this.$store.state.userRole,
        ApprovedAction: 'Details',
        NewAction: 'Start',
        ApprovedProgress:'/reports/progress/',

      }
  
    },
   
    components : {
      Footer,
      Sidebar,
      Navbar,
      caseTable,
    },
    created() {
    const acData = this.$route.query.acc
    
    const tlData = this.$route.query.tll
    const smData = this.$route.query.smm
    const tsData = this.$route.query.tso
    const admData = this.$route.query.adm
    const ttData = this.$route.query.ttt


    let caseStatus = [];

if (acData) {
  caseStatus =acData? JSON.parse(acData):null;
} else if (tlData) {
  caseStatus = tlData? JSON.parse(tlData):null;
} else if (smData) {
  caseStatus = smData?JSON.parse(smData):null;
} else if (tsData) {
  caseStatus = tsData? JSON.parse(tsData):null;
} else if (admData) {
  caseStatus = admData? JSON.parse(admData):null;
} else if (ttData) {
  caseStatus =ttData ? JSON.parse(ttData):null;
}

this.caseStatus = caseStatus;

const TData = this.$route.query.t    
this.title =JSON.parse(TData)
    }
  
  
  }
  </script>
  