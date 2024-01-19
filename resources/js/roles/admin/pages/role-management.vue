<template>
  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-4">
        <div class="card detail-card mb-4">
          <div id="Response" class="collapse" aria-labelledby="Response" data-parent="#accordion">
            <div class="card-header bg-dark text-light">
              <div class="row">
                <div class="col">
                  <i class="fa fa-list" aria-hidden="true"></i>&nbsp; Role Management
                </div>
                <div class="col" align="right">
                  <Button type="default" class="btn btn-sm btn-success" @click="addModal = true"><i
                      class="fa fa-user-plus text-dark" aria-hidden="true"></i>&nbsp;Create New Role</Button>
                </div>
              </div>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-striped table-bordered table-hover" style="width:100%">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>ROLE NAME</th>
                    <th>ROLE DESCRIPTION</th>
                    <th>DATE CREATED</th>
                    <th>DATE MODIFIED</th>
                    <th>ACTION</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(r, i) in roles" :key="i">
                    <td>{{ r.id }}</td>
                    <td>{{ r.ROLE_NAME }}</td>
                    <td>{{ r.ROLE_DESC }}</td>
                    <td>{{ moment(String(r.created_at)).format('MM/DD/YYYY HH:mm') }}</td>
                    <td>{{ moment(String(r.updated_at)).format('MM/DD/YYYY HH:mm') }}</td>
                    <td>
                      <Dropdown placement="bottom-start" class="bg-info" style="width:135px;border-radius: 3px;"
                        align="center">
                        <a href="javascript:void(0)" class="btn btn-sm btn-info btn-default">
                          <span class="text-white bg-info" style="width:105px"><i class="fa fa-cog text-dark"
                              aria-hidden="true"></i>&nbsp;Action</span>
                          <Icon type="ios-arrow-down"></Icon>
                        </a>
                        <template #list>
                          <DropdownMenu>
                            <DropdownItem><Button type="primary" ghost size="small" @click="showEditModal(r, i)"
                                style="width:105px">Edit</Button></DropdownItem>
                          </DropdownMenu>
                        </template>
                      </Dropdown>
                    </td>
                  </tr>


                </tbody>

              </table>
            </div>
          </div>
        </div>

      </div>
    </main>

    <Modal v-model="addModal" title="Create New Role" :mask-closable="false" width="400" :styles="{ top: '60px' }"
      :closable="true">

      <div class="card">
        <div class="card card-detail">
          <div class="card-body">
            <form id="roleForm">

              <div class="col-12">
                <div class="form-group ">
                  <label class="label mb-2">Role Name <span class="text-danger ml-2">*</span></label>
                  <!-- <select name="" id="" v-model="data.ROLE_NAME" style="width:100%;font-weight: 100; height: 33px;
                      margin-top: 10px; border: solid 1px #D8D8D8; border-radius: 5px; color: #808080;">
                        <option value="">Select Role</option>
                        
                        <option value="TSOhead">TSO head</option>
                        <option value="TeamLead">Team Lead</option>
                        <option value="SectorManager">Sector Manager</option>
                        <option value="AccountManager">Account Manager</option>
                       

                      </select> -->

                  <Input type="text" v-model="data.ROLE_NAME" placeholder="Role Description..." />

                </div>
              </div>

              <div class="col-12 mt-2">
                <div class="form-group ">
                  <label class="label mb-2">Role Description <span class="text-danger ml-2">*</span></label>
                  <Input type="text" v-model="data.roleDesc" placeholder="Role Description..." />
                </div>
              </div>

            </form>
          </div>
        </div>

      </div>
      <div slot="footer">
        <Button type="success" size="small" @click="add()" :loading="isLoading" :disabled="isLoading"><i
            class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;{{ isLoading ? 'Please Wait..' : 'Submit' }}</Button>
        <Button type="error" @click="addModal = false" size="small">Close &nbsp;<i class="fa fa-times-circle"
            aria-hidden="true"></i></Button>
      </div>
    </Modal>

    <Modal v-model="editModal" title="Edit Role" :mask-closable="false" width="400" :styles="{ top: '60px' }"
      :closable="true">

      <div class="card">
        <div class="card card-detail">
          <div class="card-body">
            <form id="roleForm">

              <div class="col-12">
                <div class="form-group ">
                  <label class="label mb-2">Role Name <span class="text-danger ml-2">*</span></label>

                  <Select name="" id="" v-model="editData.ROLE_NAME" style="width:100%;font-weight: 100; height: 33px;
                      margin-top: 10px; border: solid 1px #D8D8D8; border-radius: 5px; color: #808080;">
                    <Option v-for="(editData, i) in roles" :value='editData.ROLE_NAME' :key="i">{{ editData.ROLE_NAME }}
                    </Option>
                  </Select>
                </div>
              </div>

              <div class="col-12 mt-2">
                <div class="form-group ">
                  <label class="label mb-2">Role Description <span class="text-danger ml-2">*</span></label>
                  <Input type="text" v-model="editData.roleDesc" placeholder="Role Description..." />
                </div>
              </div>

            </form>
          </div>
        </div>

      </div>
      <div slot="footer">
        <Button type="success" size="small" @click="edit()" :loading="isLoading" :disabled="isLoading"><i
            class="fa fa-edit" aria-hidden="true"></i>&nbsp;{{ isLoading ?
              'Please Wait..' : 'Edit'
            }}</Button>
        <Button type="error" @click="editModal = false" size="small">Close &nbsp;<i class="fa fa-times-circle"
            aria-hidden="true"></i></Button>
      </div>
    </Modal>
  </div>
</template>
<script>
import Footer from '../../../components/footer.vue'
import Sidebar from '../../../components/sidebar.vue'
import Navbar from '../../../components/navbar.vue'
export default {
  data() {
    return {

      data: {
        id: '',
        ROLE_NAME: '',
        roleDesc: '',
        roleDesc: "",
        role: "",
        // USER_NAME
      },

      delData: {
        id: '',
        ROLE_NAME: '',
        roleDesc: '',
        username: "",
        role: "",
      },

      roles: [],
      addModal: false,
      isLoading: false,
      editData: {
        ROLE_NAME: '',
        roleDesc: '',
        username: "",
        role: "",
      },
      delData: {
        id: '',
        ROLE_NAME: '',
        roleDesc: '',
        username: "",
        role: "",
      },
      editModal: false,
      index: -1

    }

  },
  components: {
    Footer,
    Sidebar,
    Navbar
  },
  methods: {

    async add() {

      if (this.data.ROLE_NAME.trim() == '') return this.error('Role name is required')
      if (this.data.roleDesc.trim() == '') return this.error('Role Description is required')
      this.isLoading = true

      const resRole = await this.callApi('post', '/api/storeRoles', this.data)
      if (resRole.status === 201) {
        this.roles.unshift(resRole.data);
        this.success('Role Created Successfully!')
        this.data.ROLE_NAME = "Select Role";
        this.isLoading = false
        this.addModal = false
        this.data.roleDesc = ''
      }
      else {
        if (resRole.status == 422) {
          if (resRole.data.errors.ROLE_NAME) {
            this.error(resRole.data.errors.ROLE_NAME[0])
          }

        }

        else {
          this.swr()
        }
        this.isLoading = false

      }
    },
    async edit() {
      this.isLoading = true
      console.log(this.editData)
      const res = await this.callApi('post', '/api/updateRole', this.editData)
      if (res.status == 200) {
        this.roles[this.index].ROLE_NAME = this.editData.ROLE_NAME
        this.roles[this.index].ROLE_DESC = this.editData.roleDesc
        this.success('Role Edited Successfully!')
        this.isLoading = false
        this.editModal = false
        this.data = ''
      }
      else {
        if (res.status == 422) {
          if (res.data.errors.roleName) {
            this.error(res.data.errors.ROLE_NAME[0])
          }
        }

        else {
          this.swr()
        }
        this.isLoading = false

      }
    },
    showEditModal(r, index) {
      let obj = {
        id: r.id,
        ROLE_NAME: r.ROLE_NAME,
        roleDesc: r.ROLE_DESC

      }
      this.editModal = true
      this.editData = obj
      this.delData = obj
      this.index = index
    },
  },
  // async created() {
  //   if (this.$store.state.user) {
  //     const res = await this.callApi('get', '/api/fetchRoles')
  //     if (res.status === 200) {
  //       this.roles = res.data
  //     }
  //     else {
  //       this.swr('something went wrong')
  //     }

  //   }
  //   else {
  //     this.warning("Access Denied. You Don't Have Enough Permissions to Access This Route!")
  //     window.location = '/'
  //   }

  // }




}
</script>
