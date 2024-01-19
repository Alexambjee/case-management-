<template>
  <div>
    <!---+++++++++++++++++++Modals++++++++++++++++++++++--->
    <Modal v-model="editModal" title="Block / Unblock User" :mask-closable="false" width="400" :styles="{ top: '60px' }"
      :closable="true">
      <!-- new message body -->
      <div class="card">
        <div class="card card-detail">
          <div class="card-body">
            <form>
              <!-- row -->
              <div class="row">
                <!-- col-md-4 -->
                <div class="col-md-12">
                  <div class="form-group ">
                    <label class="label">Username <span class="text-danger ml-2">*</span></label>
                    <Input type="text" v-model="editData.userName" placeholder="Username" />
                  </div>
                </div>
                <!-- col-md-4 ends -->
              </div>
              <!-- row ends -->
              <!-- row -->
              <div class="row">
                <!-- col-md-4 -->
                <div class="col-md-12 mt-2">
                  <div class="form-group ">
                    <label class="label">Name <span class="text-danger ml-2">*</span></label>
                    <Input placeholder="Other Names.." v-model="editData.name" readonly />
                  </div>
                  <div class="form-group ">
                    <label class="label">Select Action <span class="text-danger ml-2">*</span></label>
                    <select class="form-control" v-model="editData.action" placeholder="Select Action">
                      <option value="0">Deactivate</option>
                      <option value="1">Activate</option>
                    </Select>
                  </div>
                  <div class="form-group ">
                    <label class="label">Reason <span class="text-danger ml-2">*</span></label>
                    <!-- <Textarea placeholder="Enter reason" class="form-control"  v-model="editData.reason" cols="30" rows="5">
                </Textarea> -->
                    <Input placeholder="Reason.." v-model="editData.reason" />
                  </div>
                </div>
                <!-- col-md-4 ends -->
              </div>
              <!-- row ends -->

            </form>
          </div>
        </div>

      </div>
      <!--new  message body  ends-->
      <div slot="footer" align="center">
        <Button type="success" size="small" @click="edit()" :loading="isLoading" :disabled="isLoading"
          style="width:170px">
          <i class="fa fa-toggle-on"></i>
          {{ isLoading ? 'Please Wait..' : 'Change Status' }}</Button>
        <Button type="error" @click="editModal = false" size="small" style="width:170px">Close <i
            class="fa fa-times-circle" aria-hidden="true"></i></Button>
      </div>
    </Modal>
    <Modal v-model="modalChangeRole" title="Change User Role" :mask-closable="false" width="400" :styles="{ top: '60px' }"
      :closable="true">
      <!-- new message body -->
      <div class="card">
        <div class="card card-detail">
          <div class="card-body">
            <form>
              <!-- row -->
              <div class="row">
                <!-- col-md-4 -->
                <div class="col-md-12">
                  <div class="form-group ">
                    <label class="label">Username<span class="text-danger ml-2">*</span></label>
                    <Input type="text" v-model="roleData.userName" placeholder="Username" />
                  </div>
                </div>
                <!-- col-md-4 ends -->
              </div>
              <!-- row ends -->
              <!-- row -->
              <div class="row">
                <!-- col-md-4 -->
                <div class="col-md-12 mt-2">
                  <div class="form-group ">
                    <label class="label">Name <span class="text-danger ml-2">*</span></label>
                    <Input placeholder="First Name.." v-model="roleData.name" readonly />
                  </div>
                  <div class="col-md-12 mt-2">
                    <div class="form-group ">
                      <label class="label">Primary Role<span class="text-danger ml-2">*</span></label>
                      <Select v-model='roleData.roleId' placeholder="Select User Role.." style="width:100%;">
                        <Option v-for="(roleData, i) in roles" :value='roleData.role_id' :key="i">{{ roleData.role_desc
                        }}</Option>
                      </Select>
                    </div>
                  </div>
                  <div v-if="roleData.roleId ==11" class="col-md-12 mt-2">
                    <div class="form-group ">
                      <label class="label">Department<span class="text-danger ml-2">*</span></label>
                      <Select v-model='roleData.onDepartment' placeholder="Select User Role.." style="width:100%;">
                        <Option v-for="(depData, i) in deparments" :value='depData.department_id' :key="i">{{
                          depData.department_name
                        }}</Option>
                      </Select>
                    </div>
                  </div>
                </div>
                <!-- col-md-4 ends -->
              </div>
              <!-- row ends -->

            </form>
          </div>
        </div>

      </div>
      <!--new  message body  ends-->
      <div slot="footer" align="center">
        <Button type="success" size="small" @click="changeRole()" :loading="isLoading" :disabled="isLoading"
          style="width:170px">
          <i class="fa fa-toggle-on"></i>
          {{ isLoading ? 'Please Wait..' : 'Change Status' }}</Button>
        <Button type="error" @click="modalChangeRole = false" size="small" style="width:170px">Close <i
            class="fa fa-times-circle" aria-hidden="true"></i></Button>
      </div>
    </Modal>

    <!-- create user modal -->
    <Modal v-model="addModal" title="Create New User" :mask-closable="false" width="600" :styles="{ top: '60px' }"
      :closable="true">
      <div class="card">
        <div class="card card-detail">
          <div class="card-body">
            <form>
              <div>
                <div class="row">
                  <div class="col-md-12 mt-2">
                    <div class="form-group ">
                      <label class="label">Last Name <span class="text-danger ml-2">*</span></label>
                      <Input placeholder="First Name.." v-model="data.firstName" />
                    </div>

                    <div class="form-group ">
                      <label class="label">User Id <span class="text-danger ml-2">*</span></label>
                      <Input placeholder="" v-model="data.nationalId" />
                    </div>
                    <div class="form-group ">
                      <label class="label">Other Names <span class="text-danger ml-2">*</span></label>
                      <Input placeholder="Other Names.." v-model="data.otherNames" />
                    </div>
                    <div class="form-group ">
                      <label class="label">Staff Mail <span class="text-danger ml-2">*</span></label>
                      <Input type="email" placeholder="Email.." v-model="data.email" />
                    </div>
                    <!-- <div class="form-group ">
                            <label class="label">Phone <span class="text-danger ml-2">*</span></label>
                            <Input placeholder="Phone Number.." v-model="data.phone" />
                          </div> -->
                    <div class="col-md-12 mt-2">
                      <div class="form-group ">
                        <label class="label">Primary Role<span class="text-danger ml-2">*</span></label>
                        <Select v-model='data.roleId' placeholder="Select User Role.." style="width:100%;">
                          <Option v-for="(roleData, i) in roles" :value='roleData.role_id' :key="i">{{ roleData.role_desc
                          }}</Option>
                        </Select>
                      </div>
                    </div>
                    <div v-if="data.roleId == 11" class="col-md-12 mt-2">
                      <div class="form-group ">
                        <label class="label">Department<span class="text-danger ml-2">*</span></label>
                        <Select v-model='data.onDepartment' placeholder="Select User Role.." style="width:100%;">
                          <Option v-for="(depData, i) in deparments" :value='depData.department_id' :key="i">{{
                            depData.department_name
                          }}</Option>
                        </Select>
                      </div>
                    </div>
                    <!-- col-md-4 ends -->
                  </div>
                  <!-- row ends -->
                </div>
                <!-- col-md-4 -->
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--new  message body  ends-->
      <div slot="footer">
        <Button type="success" size="small" @click="add()"><i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;{{
          isLoading ? 'Loading..' : 'Create'
        }}</Button>
      </div>
    </Modal>
    <!---+++++++++++++++++++End Modals++++++++++++++++++++++--->

    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="row">
          <!-- taxpayer details -->
          <div class="taxpayer-details col-sm-6 col-md-6 col-lg-6">
            <div class="card shadow">
              <div class="card-header headings" style="text-transform:uppercase; font-size:12px;">
                Search Details
              </div>
              <div class="card-body">
                <div class="card-content">
                  <div class="card-items">
                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="form-group ">
                          <label class="label">Username <span class="text-danger ml-2">*</span></label>
                          <input type="text" v-model="data.userName" class="form-control" placeholder="Username"
                            onkeyup="this.value = this.value.toUpperCase();" />
                        </div>
                      </div>
                      <br />

                      <Button type="success" size="small" @click="getUser()">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;{{
                          isLoading ? 'Loading..' : 'Submit'
                        }}</Button>
                      <div class="form-group " :loading="isLoading" :disabled="isLoading" v-if="isfound">
                        <label class="label">Roles <span class="text-danger ml-2">*</span></label>
                        <Select v-model='data.roleId' placeholder="Select User Role.." style="width:100%;">
                          <Option v-for="(roleData, i) in roles" :value='roleData.role_id' :key="i">{{
                            roleData.role_desc.toUpperCase()
                          }}</Option>
                        </Select>
                        <label v-if="data.roleId == 11" class="label">Department<span
                            class="text-danger ml-2">*</span></label>
                        <Select v-if="data.roleId == 11" v-model='data.onDepartment' placeholder="Select Department.."
                          style="width:100%;">
                          <Option v-for="(dept, i) in deparments" :value='dept.department_id' :key="i">{{
                            dept.department_name
                          }}</Option>
                        </Select>
                        <br /><br />
                        <Button type="success" size="small" @click="add()"><i class="fa fa-user-plus"
                            aria-hidden="true"></i> &nbsp;{{
                              isLoading ? 'Loading..' : 'Create'
                            }}</Button>
                      </div>
                      <!-- <Button type="error" @click="addModal = false" size="small">Close &nbsp;<i class="fa fa-user-times" aria-hidden="true"></i></Button> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="-details col-sm-6 col-md-6 col-lg-6">
            <div class="card shadow">
              <div class="card-header headings" style="text-transform:uppercase; font-size:12px;">
                User Details
              </div>
              <div class="card-body">
                <div class="card-content">
                  <div class="card-items">
                    <span class="text-left">LastName</span>
                    <p class="text-left">{{ data.firstName }}</p>
                  </div>
                  <div class="card-items">
                    <span class="text-left">OtherNames</span>
                    <p class="text-left">{{ data.otherNames }}</p>
                  </div>
                  <div class="card-items">
                    <span class="text-left">Email</span>
                    <p class="">{{ data.email }}</p>
                  </div>
                  <div class="card-items">
                    <span class="text-left">Nation Id</span>
                    <p class="">{{ data.nationalId }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body table-responsive">

          <table class="table table-striped  table-bordered table-responsive table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>USER_NAME</th>
                <th>NAME</th>
                <th>EMAIL_ADDRESS</th>
                <th>ROLE</th>
                <th>CREATED_BY</th>
                <th>STATUS</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(u, i) in users" :key="i">
                <td>{{ u.user_name }}</td>
                <td>{{ u.last_name }} {{ u.other_names }}</td>
                <td>{{ u.email_address }}</td>
                <td>
                  <span v-if="u.role_desc === 'own_department'">Dept/{{ u.department_name.toUpperCase() }}</span>
                  <span v-else>{{ u.role_desc.toUpperCase() }}</span>
                </td>
                <td>{{ u.created_by }}</td>
                <td>
                  <div v-if="u.status === '0'" class="text-danger">
                    <div class="btn btn-danger btn-sm" style="width:90px"><i class="fa fa-toggle-off text-dark"
                        aria-hidden="true"></i>&nbsp; Inactive
                    </div>
                  </div>
                  <div v-else-if="u.status === '1'" class="text-info">
                    <div class="btn btn-success btn-sm" style="width:90px"><i class="fa fa-toggle-on text-dark"
                        aria-hidden="true"></i>&nbsp; Active </div>
                  </div>
                </td>
                <td>
                  <Dropdown placement="bottom-start" class="bg-info" style="width:135px;border-radius: 3px;"
                    align="center">
                    <a href="javascript:void(0)" class="btn btn-sm btn-info btn-default">
                      <span class="text-white bg-info" style="width:105px"><i class="fa fa-cog text-dark"
                          aria-hidden="true"></i>&nbsp;Action</span>
                      <Icon type="ios-arrow-down"></Icon>
                    </a>
                    <template #list>
                      <DropdownMenu class="bg-dark">
                        <DropdownItem>
                          <Button type="error" ghost size="small" @click="showEditModal(u, index)" style="width:105px">
                            Change Status
                          </Button>
                        </DropdownItem>
                        <DropdownItem>
                          <Button type="primary" ghost size="small" @click="changeRoleModal(u, index)"
                            style="width:105px">
                            Change Role
                          </Button>
                        </DropdownItem>
                      </DropdownMenu>
                    </template>
                  </Dropdown>
                </td>
              </tr>
            </tbody>
          </table>
          <div style="margin: 10px;">
            <div style="float: right;">
              <ul class="pagination d-flex" style="list-style-type: none">
                <li v-if="page > 1">
                  <Button @click="page = page - 1">Previous</Button>
                </li>
                <li v-for="pagex in Math.ceil(users.length / usersPerPage)" :key="page">
                  <Button @click="page = page" :class="'btn btn-primary'">{{ page }}</Button>
                  <Button @click="page = pagex + page" :class="pagex + page === page ? 'btn btn-primary ' : ''">{{ pagex +
                    page }}</Button>
                </li>
                <li v-if="page < users.length">
                  <Button @click="page = page + 1">Next</Button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- case details component -->
</template>
<script>
import Footer from '../../../components/footer.vue'
import Sidebar from '../../../components/sidebar.vue'
import Navbar from '../../../components/navbar.vue'
export default {
  data() {
    return {
      page: 1,
      usersPerPage: 10,
      data: {
        userName: '',
        nationalId: '',
        firstName: '',
        otherNames: '',
        email: '',
        roleId: null,
        onDepartment: 0,
        createdBy: this.$store.state.user.user_name,

      },
      editData: {
        id: null,
        userName: '',
        name: '',
        action: '',
        createdBy: this.$store.state.user.user_name,
        reason: '',
      },
      roleData: {
        roleId: null,
        userName: '',
        lastName: '',
        createdBy: this.$store.state.user.user_name,
        onDepartment: 0,

      },
      isfound: false,
      option: false,
      users: [],
      roles: [],
      deparments: [],
      addModal: false,
      isLoading: false,
      modalChangeRole: false,
      editModal: false,
      index: -1,


    }

  },
  components: {
    Footer,
    Sidebar,
    Navbar
  },
  watch: {
    page() {
      this.getDetails().then(() => void 0).catch(console.error)
    }
  },
  methods: {
    async getDetails() {
      const [resRoles, resDept, resUsers] = await Promise.all([
        this.callApi('get', '/api/fetchRoles'),
        this.callApi('get', '/api/getAllDepartments'),
        this.callApi('get', '/api/getAllUsersWithout'),
      ])
      if (resRoles.status == 200 && resDept.status == 200) {
        this.roles = resRoles.data;
        this.deparments = resDept.data;
      }
      else {
        this.swr('something went wrong')
      }
      if (resUsers.status == 200) {
        this.users = resUsers.data;
      }
      else {
        this.swr('something went wrong')
      }
    },

    async add() {
      if (this.data.userName.trim() == '') return this.error('Username is required')
      this.isLoading = true
      const resUser = await this.callApi('post', '/api/createUser', this.data)
      if (resUser.status == 200 || resUser.status == 201) {
        this.users.unshift(resUser.data);
        this.success('User Created Successfully!')
        this.isLoading = false
        this.addModal = false
        this.data.userName = ''
        this.data.roleId = ''
        window.location.reload();
      }
      else {
        // invalid credentials

        if (resUser.status === 401) {
          this.warning(resUser.data.msg)
          this.isLoading = false
        }
        // return errors
        else if (resUser.status === 422) {
          for (let i in resUser.data.errors) {
            this.error(resUser.data.errors[i][0])
          }
          this.isLoading = false
        }
        else {
          this.swr()
        }

      }
      this.isLoading = false
    },

    //Editing begins////////////////////////////////////////////////////////////////////
    async edit() {
      this.isLoading = true
      const resEdit = await this.callApi('post', '/api/activateDeactivateUser', this.editData)
      console.log(this.editData)
      if (resEdit.status == 200) {
        this.success('User status updated successfully')
        this.isLoading = false
        this.editModal = false
        this.editData = ''
        //window.location.reload();
      }
      else {
        if (resEdit.status == 422) {
          if (resEdit.data.errors) {
            this.error(resEdit.data.errors)
          }
        }

        else {
          this.swr()
        }
        this.isLoading = false

      }


    },

    showEditModal(u, index) {
      let obj = {
        userName: u.user_name,
        name: u.last_name + u.other_names,
        action: u.status,
        reason: u.status_reason,
        createdBy: this.$store.state.user.user_name,
        id: u.user_id

      }
      this.editModal = true
      this.editData = obj
      this.index = index
    },
    //Editing ends////////////////////////////////////////////////////////////////////////////////////
    //Change Role Begins//////////////////////////////////////////////////////////////////////////////
    async changeRole() {
      this.isLoading = true
      const resRoleData = await this.callApi('post', '/api/changeUserRole', this.roleData)
      if (resRoleData.status == 200) {
        this.success('Role successfully Changed')
        this.isLoading = false
        this.modalChangeRole = false
        this.editData = ''
        window.location.reload();
      }
      else {
        if (resRoleData.status == 422) {
          this.error(resRoleData.data.errors)
        }

        else {
          this.swr()
        }
        this.isLoading = false
        this.modalChangeRole = false
        this.editData = ''
      }


    },

    changeRoleModal(u, index) {
      let obj = {
        id: u.user_id,
        userName: u.user_name,
        name: u.last_name + u.other_names,
        roleId: u.role_id,
        onDepartment: u.onDepartment,
        createdBy: this.$store.state.user.user_name


      }
      this.modalChangeRole = true
      this.roleData = obj
      this.index = index
    },
    //Change Role Ends////////////////////////////////////////////////////////////////////////////////
    async getUser() {

      if (this.data.userName.trim() == '')
        return this.error('Username is required');
      // if (this.data.userName.trim().length < 9 || this.data.userName.trim().length > 9)
      //   return this.error('Username cannot be more or less than 9 characters in length');
      var getIndexZero = Array.from(this.data.userName.trim())[0];
      console.log(getIndexZero)
      this.isLoading = true
      const res = await this.callApi('get', `/api/getUserInfo/${this.data.userName}`)
      if (res.status == 200) {
        this.isLoading = false
        this.option = true
        this.isfound = true

        console.log(res.data[0])
        this.data.firstName = res.data[0]['surname']
        this.data.otherNames = res.data[0]['othernames']
        this.data.email = res.data[0]['email_address']
        this.data.status = res.data[0]['status']
        this.data.nationalId = res.data[0]['id_number']
        console.log(this.data)
      }
      else {
        if (res.status === 401) {
          this.isLoading = false;
          this.option = true
          this.option = true
          this.isfound = false
          this.data.userName = this.data.userName
          this.data.firstName = ""
          this.data.otherNames = ""
          this.data.email = ""
          this.data.status = ""
          this.data.nationalId = ""

          this.error('User Not found')
          this.addModal = true
        } else {
          this.isLoading = false;
          this.error('User Exists')
        }
      }

    },

    async add() {
      if (this.data.userName.trim() == '') return this.error('Username is required')
      this.isLoading = true
      const resUser = await this.callApi('post', '/api/createUser', this.data)
      if (resUser.status == 200 || resUser.status == 201) {
        this.users.unshift(resUser.data);
        this.success('User Created Successfully!')
        this.option = false
        this.isLoading = false
        this.addModal = false
        this.data.userName = ''
        this.data.roleId = null
        this.data.onDepartment = null
        // getthisandthat()
        window.location.reload();
      }
      else {
        // invalid credentials

        if (resUser.status === 401) {
          this.warning(resUser.data.msg)
          this.isLoading = false
        }
        // return errors
        else if (resUser.status === 422) {
          for (let i in resUser.data.errors) {
            this.error(resUser.data.errors[i][0])
          }
          this.isLoading = false
        }
        else {
          this.swr()
        }

      }
      // window.location.reload();
      this.isLoading = false
    },
  },
  async created() {
    this.getDetails()
  }

}
</script>