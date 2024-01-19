<template>
    <div >
    <!-- navbar -->
      <Navbar/>
         <div id="layoutSidenav">
         <Sidebar />

            <div id="layoutSidenav_content">
            <main>
                    <div class="container-fluid px-4">
                      <h1 class="mt-4">CASE SUMMARY</h1>
                                        <div class="breadcrumb mb-4 mt-3">
                                        <Breadcrumb>
                                        <BreadcrumbItem to="/reports" class="breadcrumb-item">Dashboard</BreadcrumbItem>
                                        <BreadcrumbItem to="/reports/numbers" class="breadcrumb-item active">My cases</BreadcrumbItem>
                                        </Breadcrumb>
                                        </div>                   
                                        <div class="card detail-card mb-4">
                                        <div class="card-header bg-dark text-light">
                                        <i class="fas fa-table me-1"></i>
                                        My Cases
                                        </div>
                                        <div class="card mb-4 detail-card">

                                        <div class="form-group row">
                                        <div class="col-4" align="left">
                                        <Button type="default" @click="print" >Export Csv</Button>
                                        <Button type="default" >Print</Button>
                                        </div>
                                        </div>
                                        <div class="card-body table-responsive">
                                        <table
                                        class="table table-striped table-bordered table-hover"
                                        style="width: 100%" ref="table" id="table"
                                        >
                                        <thead>
                                        <tr>
                                        <th>Total Cases </th>
                                        <th>Cases at Account Manager</th>
                                        <th>Cases at Team Lead</th>
                                        <th>Cases at Sector manager</th>
                                        <th>Cases at Tso</th>
                                        <!-- <th>Cases at the Admin </th> -->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <td><router-link :to="{path:`/reports/cases/${ttt}`,query:{ttt:JSON.stringify(caseStatus),t:JSON.stringify('Total Cases')}}">{{ ttt }}</router-link></td>
                                        <td><router-link :to="{path:`/reports/cases/${acc}`,query:{acc:JSON.stringify(AC),t:JSON.stringify('Account Managers')}}">{{acc}}</router-link></td>
                                        <td><router-link :to="{path:`/reports/cases/${tll}`,query:{tll:JSON.stringify(TL),t:JSON.stringify('Team Leads')}}">{{tll}}</router-link></td>
                                        <td><router-link :to="{path:`/reports/cases/${smm}`,query:{smm:JSON.stringify(SM),t:JSON.stringify('Sector Managers')}}">{{smm}}</router-link></td>
                                        <td><router-link :to="{path:`/reports/cases/${tso}`,query:{tso:JSON.stringify(TS),t:JSON.stringify('TSOs')}}">{{tso}}</router-link></td>
                                        <!-- <td><router-link :to="{path:`/reports/cases/${adm}`,query:{adm:JSON.stringify(AD)},data:{t:JSON.stringify("Admin")}}">{{adm}}</router-link></td> -->
                                        </tr>
                                        </tbody>
                                        </table>
                                        <div style="margin: 10px;overflow: hidden">
                                        <div style="float: right;">
                                        </div>
                                        </div>
                                        </div>
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
  import Footer from '../../components/footer.vue'
  import Sidebar from '../../components/sidebar.vue'
  import Navbar from '../../components/navbar.vue'
  import caseTable from '../../components/pages/caseTable.vue'
  export default {
    data(){
      return{
       
        caseStatus:[20,-14,16,18,11,14,27,-1,-2,-3,-12,-5,-6,0,1,2,3,5,6,7,8,12,13,-13,4,-4,9],
        progressPath: '/reports/numbers',
        username:this.$store.state.user.USER_NAME,
        role: this.$store.state.userRole,
        ApprovedAction: 'Details',
        NewAction: 'Start',
        ApprovedProgress:'/reports/numbers/',
        AC: [0,-1,20,-3,-5,3,7,-12,9],
        TL:[1,-2,-13,-6,5,12],
        SM:[2,-14,6,13,-4,13],
        TS:[16,14,4],
        AD:[27],
        TT:[2,8],
        acc:'',
        tll:'',
        smm:'',
        tso:'',
        adm:'',
        ttt:'',

      }
  
    },
    components : {
      Footer,
      Sidebar,
      Navbar,
      caseTable,
    },
    methods :{
  async fetchData(){


    const [acc,tll,smm,tso,adm,ttt] = await Promise.all([
      this.callApi("get", `/api/getNumbers/${this.AC}`),
      this.callApi("get", `/api/getNumbers/${this.TL}`),
      this.callApi("get",  `/api/getNumbers/${this.SM}`),
      this.callApi("get",  `/api/getNumbers/${this.TS}`),
      this.callApi("get",  `/api/getNumbers/${this.AD}`),
      this.callApi("get",  `/api/getNumbers/${this.TT}?data=5`),
    ]);
        this.acc = this.get_res(acc)
        this.tll = this.get_res(tll)
        this.smm = this.get_res(smm)
        this.tso = this.get_res(tso)
        this.adm = this.get_res(adm)
        this.ttt = this.get_res(ttt)
  
    },
      get_res(res){
        if (res.status === 200) {
            console.log(res.data);
            return res.data
          } else {
            throw new Error("Something went wrong");
          }
      },
      print() {
            this.$refs.table.exportCsv({
            filename: 'Case Export Table',
            original: true
             });
            
        },
  },
    created() {
      this.fetchData()
    }
  
  
  }
  </script>
  