<template>
    <div>
        <Modal v-model="SearchPno" title="Search for Staff" :mask-closable="false" width="350" :styles="{ top: '20%' }"
            :closable="true">
            <div class="card">
                <div class="card card-detail">
                    <div class="card-body">
                        <form id="SearchForm">
                            <div class="form-group">
                                <label class="label">Enter Personal No:<span class="text-danger ml-2">*</span></label>
                                <span>
                                    <input type="text" class="form-control" v-model="manual_case.p_no"
                                        placeholder="Personal Number" onkeyup="this.value = this.value.toUpperCase();" />
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div slot="footer">
                <Button type="primary" @click="getStaffDetails()" :loading="isLoading" :disabled="isLoading">&nbsp;{{
                    isLoading ? 'Loading..' : 'Submit' }} <i class="fa-regular fa-circle-check"
                        aria-hidden="true"></i></Button>
                <Button type="error" @click="remove()">Close &nbsp;<i class="fa fa-times-circle"
                        aria-hidden="true"></i></Button>
            </div>
        </Modal>

        <Modal v-model="createModal" title="Create New Case" :mask-closable="false" width="600" :styles="{ top: '60px' }"
            :closable="true">
            <div class="card">
                <hr class="solid">
                <div class="card card-detail">
                    <div class="card-body">
                        <form id="roleForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <span><label class="label">Personal No:<span
                                                    class="text-danger ml-2">*</span></label></span>
                                        <input type="text" class="form-control" v-model="manual_case.p_no"
                                            placeholder="Personal Number"
                                            onkeyup="this.value = this.value.toUpperCase();" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Station<span class="text-danger ml-2">*</span></label>
                                        <Input type="text" v-model="manual_case.station" placeholder="Station" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Name<span class="text-danger ml-2">*</span></label>
                                        <Input type="text" v-model="manual_case.staff_name" placeholder="Names" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Address<span class="text-danger ml-2">*</span></label>
                                        <Input type="text" v-model="manual_case.address" placeholder="Address" />
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Department<span class="text-danger ml-2">*</span></label>
                                        <Select v-model="manual_case.dept_id" clearable filterable style="width: 100%"
                                            placeholder="department">
                                            <Option v-for="(dept, i) in departments" :value='dept.department_id'
                                             :key="i">{{ dept.department_name }}
                                            </Option>
                                        </Select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Telephone<span class="text-danger ml-2">*</span></label>
                                        <Input v-model="manual_case.phone" placeholder="Phone Number"></Input>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Designation<span class="text-danger ml-2">*</span></label>
                                        <Select v-model="manual_case.designation" clearable filterable style="width: 100%"
                                            placeholder="designation">
                                            <Option v-for="(desig, i) in designations" :value='desig.designation_id'
                                                :key="i">{{ desig.designation_name }}</Option>
                                        </Select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Email<span class="text-danger ml-2">*</span></label>
                                        <Input type="text" v-model="manual_case.mail" placeholder="E-Mail" />
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label class="label">Appointment Date<span class="text-danger ml-2">*</span></label>
      <div v-if="manual_case.app_date == null" >
        <input type="date" class="form-control" v-model="manual_case.app_date" @change="updateFormattedAppDate" />
        </div>
  <div v-else>

      <input  type="text" class="form-control" :value="formatted_app_date" placeholder="mm/dd/yyyy" @input="updateManualAppDate" />
    </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label class="label">Exit Date<span class="text-danger ml-2">*</span></label>
      <input v-if="manual_case.exit_date == null" type="date" class="form-control" v-model="manual_case.exit_date" @change="updateFormattedExitDate" />
      <input v-else type="text" class="form-control" :value="formatted_exit_date" placeholder="mm/dd/yyyy" @input="updateManualExitDate" />
    </div>
  </div>
</div> -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Appointment Date<span class="text-danger ml-2">*</span></label>
                                        <input v-if="manual_case.app_date == null" type="date" class="form-control"
                                            v-model="manual_case.app_date" />
                                        <input v-else type="text" class="form-control" v-model="formatted_app_date"
                                            placeholder="mm/dd/yyyy" />

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Exit Date<span class="text-danger ml-2">*</span></label>
                                        <input v-if="manual_case.exit_date == null" type="date" class="form-control"
                                            v-model="manual_case.exit_date" />
                                        <input v-else type="text" class="form-control" v-model="formatted_exit_date"
                                            placeholder="mm/dd/yyyy" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Division<span class="text-danger ml-2">*</span></label>
                                        <Select v-model="manual_case.div_id" clearable filterable style="width: 100%"
                                            placeholder="division">
                                            <Option v-for="(dept, i) in divisions" :value='dept.division_id' :key="i">{{
                                                dept.division_name }}</Option>
                                        </Select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="label">Contract Type<span class="text-danger ml-2">*</span></label>
                                        <Input type="text" v-model="manual_case.contract" placeholder="Contract Type" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-3 label mb-2">Remarks <span class="text-danger ml-2">*</span></label>
                                    <Input v-model="manual_case.remarks" placeholder="Enter Remarks" type="textarea"
                                        :Row="10" :col="6" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--new  message body  ends-->

            <div slot="footer">
                <Button type="success" @click="createCase()" :loading="isLoading" :disabled="isLoading">&nbsp;{{ isLoading ?
                    'Loading..' : 'Trigger' }} <i class="fa fa-check-circle" aria-hidden="true"></i></Button>
                <Button type="error" @click="remove()">Close &nbsp;<i class="fa fa-times-circle"
                        aria-hidden="true"></i></Button>
            </div>
        </Modal>
 


        <div class="card bg-dark">
            <div class="card-body">
                <div class="form-group">
                    <div class="float-left">
                        <Input type="text" v-model="searchQuery" placeholder="Search cases..." style="width: 250px;" />
                        <div class="float-right">
                            <button v-if="role == 'hr'" type="info" ghost @click="SearchPno = true"
                                class="btn btn-primary">Initiate</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body table-responsive">
            <Table :border="showBorder" :stripe="showStripe" :show-header="showHeader" :height="fixedHeader ? 250 : ''"
                :size="tableSize" :data="cases" :columns="Columns" ref="table" class="table"></Table>

            <div style="margin: 10px;overflow: hidden">
                <div style="float: right;">
                    <ul class="pagination d-flex" style="list-style-type: none">
                        <ul class="pagination d-flex" style="list-style-type: none">
                            <li v-if="page > 1">
                                <Button @click="page = page - 1">Previous</Button>
                            </li>
                            <li v-for="pagex in Math.min(Math.ceil(total / casesPerPage), maxPages)" :key="pagex">
                                <Button @click="page = pagex">{{ pagex }}</Button>
                            </li>
                            <li v-if="page < Math.ceil(total / casesPerPage)">
                                <Button @click="page = page + 1">Next</Button>
                            </li>
                        </ul>
                    </ul>
                </div>
            </div>




            <!-- assign modal ends-->

        </div>
        <!-- table card ends-->
    </div>
</template>

<script>
export default {
    props: ['path', 'bath', 'username', 'caseStatus', 'action', 'column', 'role', 'role_desc'],
    data() {
        return {
            isLoading: false,
            cases: [],
            manual_case: {
                p_no: '',
                station: '',
                staff_name: '',
                address: '',
                dept_id: '',
                phone: '',
                designation: '',
                remarks: '',
                app_date: null,
                exit_date: null,
                remarks: '',
                status: '',
                div_id: '',
                contract: '',
                username: this.username,
            },
            Assignmodal: false,
            departmentData: false,
            designationData: false,
            editData: {},
            total: 0,
            index: -1,
            showBorder: false,
            showStripe: true,
            showHeader: true,
            showIndex: false,
            showCheckbox: false,
            fixedHeader: false,
            tableSize: 'default',
            createModal: false,
            SearchPno: false,
            divisions: [],
            departments: [],
            designations: [],
            searchQuery: '',
            casesPerPage: 10,
            page: 1,
            index: -1,
            // maxPages: 0,
            // formatted_app_date: null,
            // formatted_exit_date: null


        }

    },

    computed: {
        // formatted_app_date() {
        //     return this.manual_case.app_date != null ? this.formatDate(this.manual_case.app_date) : null;
        // },
        // formatted_exit_date() {
        //     return this.manual_case.exit_date != null ? this.formatDate(this.manual_case.exit_date) : null;
        // },

        maxPages() {
            return Math.ceil(this.total / this.casesPerPage);
        },
        Columns() {
            let columns = [];
            this.loading = false
            columns.push({
                title: 'CASE_ID',
                key: 'case_id',
                sortable: true,
                filterMultiple: false,
                filters: [],
                filterMethod(value, row) {
                    return row.staff_name.indexOf(value) > -1;
                }
            });
            columns.push({
                title: 'STAFF_NAME',
                key: 'employee_name',
                sortable: true,
                filterMultiple: false,
                filters: [],
                filterMethod(value, row) {
                    return row.staff_name.indexOf(value) > -1;
                }
            });
            columns.push({
                title: 'P_NUMBER',
                key: 'user_name',
                filterMultiple: true,
                sortable: true,
                filterable: true,
                filters: [],
                filterMethod(value, row) {
                    return row.p_no.indexOf(value) > -1;
                }
            });
            columns.push({
                title: 'STATUS',
                key: 'status_name',
                sortable: true,
                filterable: true,
                filterMultiple: true,
                filters: [],
                filterMethod(value, row) {
                    return row.dept_div.indexOf(value) > -1;
                }
            });
            columns.push({
                title: 'STATION',
                key: 'station',
                sortable: true,
                filterable: true,
                filters: [],
                filterMethod(value, row) {
                    return row.station.indexOf(value) > -1;
                }
            });
            columns.push({
                title: 'EMAIL',
                key: 'email',
                sortable: true,
                filterable: true,
                filters: [],
                filterMethod(value, row) {
                    return row.status.indexOf(value) > -1;
                }
            });
            columns.push({
                title: 'EXIT_DATE',
                key: 'exit_date',
                sortable: true,
                filterable: true,
                filters: [],
                filterMethod(value, row) {
                    return row.exit_date.indexOf(value) > -1;
                }
            });

            columns.push({
                title: 'Action',
                key: 'view',
                render: (h, params) => {
                    return h('div', [
                        h('Button', {
                            props: {
                                type: 'info',
                                size: 'small',
                                ghost: true
                            },
                            style: {
                                marginRight: '5px'
                            },
                            on: {
                                click: () => {

                                    this.show(params.index)
                                }
                            }
                        }, this.action)
                    ]);
                }

            });

            return columns;
        },
    },

    watch: {

        'manual_case.dept_id': function (newDeptId) {
            if (newDeptId) {
                this.getDiv_(newDeptId)
            }
        },
        page(val) {
            this.changePage(val)
        },
        searchQuery: {
            handler(newQuery, oldQuery) {
                this.getCases();
            },
            immediate: true
        },
        'manual_case.app_date'(newVal) {
                this.updateFormattedAppDate();
        },
        'manual_case.exit_date'(newVal) {
            this.updateFormattedExitDate();
        }

    },

    methods: {
            updateFormattedAppDate() {
            this.formatted_app_date = this.manual_case.app_date != null ? this.formatDate(this.manual_case.app_date) : null;
            },
            updateFormattedExitDate() {
            this.formatted_exit_date = this.manual_case.exit_date != null ? this.formatDate(this.manual_case.exit_date) : null;
            },
  
            updateManualAppDate(event) {
                //this.manual_case.app_date = event.target.value;
                this.updateFormattedAppDate();
            },
            updateManualExitDate(event) {
               // this.manual_case.exit_date = event.target.value;
                this.updateFormattedExitDate();
            },
        formatDate(date) {
            const d = new Date(date);
            return d.toLocaleDateString('en-US');
        },
        departmentId(departmentName) {
            const department = this.departments.find(dept => dept.department_name === departmentName);
            return department ? department.department_id : null;
        },
        divisionId(divisionName) {
            const division = this.divisions.find(div => div.division_name === divisionName);
            return division ? division.division_id : null;
        },
        designationId(designationName) {
            const designation = this.designations.find(desig => desig.designation_name === designationName);
            return designation ? designation.designation_id : null;
        },
        changePage(page) {
            this.page = page;
            this.getCases();
        },
        async getAllDivisions() {
            const resDiv = await this.callApi('get', '/api/getAllDivisions')
            if (resDiv.status === 200) {
                this.divisions = resDiv.data
              
            }
            else {
                this.swr('something went wrong')
            }
        },
        async getStaffDetails() {
            this.isLoading = true;
            if (this.manual_case.p_no.trim() == "")
                return this.error("Staff Number is Required.");

            const res = await this.callApi('get', `/api/getUserInfoWhere/${this.manual_case.p_no}`)
            if (res.status == 200) {
                this.isLoading = false;
                this.option = true;
                this.isfound = true;
                this.manual_case.phone = res.data.TEL_NUMBER;
                this.manual_case.staff_name = res.data.OTHER_NAMES + " " + res.data.LAST_NAME + " " + res.data.FIRST_NAME;
                this.manual_case.station = res.data.STATION
                this.manual_case.mail =res.data.EMAIL
                this.manual_case.address = res.data.address;
                this.manual_case.dept_id = this.departmentId(res.data.DEPARTMENT);
                this.manual_case.div_id = this.divisionId(res.data.DIVISION);
                this.manual_case.designation = this.designationId(res.data.DESIGNATION);
                this.manual_case.remarks = res.data.remarks;
                this.manual_case.app_date = res.data.APPOINTMENT_DATE == "" || res.data.APPOINTMENT_DATE =="0000-00-00"?null : this.toDate1(res.data.APPOINTMENT_DATE);
                this.manual_case.exit_date = res.data.EXIT_DATE =="" || res.data.EXIT_DATE =="0000-00-00" ? null: this.toDate1(res.data.EXIT_DATE) ;
                this.manual_case.contract = res.data.CONTRACT_TYPE == 1 ? 'CONTRACT' : 'PERMANENT';
                this.createModal = true
                this.SearchPno = false

            } else {
                if (res.status === 401) {
                    this.isLoading = false;
                    this.createModal = true
                    this.SearchPno = false
                    this.error(res.data.msg)
                }
                else {
                    this.isLoading = false;
                    this.swr()
                }
            }
        

        },
        async createCase() {
            this.isLoading = true;
            if (this.manual_case.p_no.trim() == "")
                return this.error("Staff Number is required!");
            if (this.manual_case.remarks.trim() == "")
                return this.error("remarks is required");

            this.isLoading = true;

         

            const resCase = await this.callApi("post", "/api/createManualCase", this.manual_case);
            if (resCase.status == 200) {
                this.cases.unshift(resCase.data);
                this.success("Case Triggered Successfully!");
                this.remove()
                this.isLoading = false;
            } else {
                if (resCase.status == 422) {
                    if (resCase.data.errors) {
                        this.error(resCase.data.errors[0]);
                    }
                } else {
                    this.swr();
                }
                this.isLoading = false;
                // this.remove()
            }

        },
        // toDate1(dateString) {
        //     console.log(dateString);
        //     if (dateString != '') {
        //         const year = parseInt(dateString.substring(0, 4), 10);
        //         const month = parseInt(dateString.substring(4, 6), 10) - 1;
        //         const day = parseInt(dateString.substring(6, 8), 10);
        //         const d = new Date(year, month, day);
        //         return d;
        //     }

        // },
        toDate1(dateString) {
  
            if (dateString !== '') {
                const [year, month, day] = dateString.split('-').map(Number);
                const d = new Date(year, month - 1, day);
                return d;
            }
            return null;
        },

        remove() {
            this.isLoading = false;
            this.createModal = false;
            this.SearchPno = false
            this.option = false;
            this.isfound = false;
            this.manual_case.phone = '';
            this.manual_case.staff_name = '';
            this.manual_case.station = '';
            this.manual_case.mail = '';
            this.manual_case.address = '';
            this.manual_case.dept_id = '';
            this.manual_case.div_id = '';
            this.manual_case.designation = '';
            this.manual_case.remarks = '';
            this.manual_case.app_date = '';
            this.manual_case.exit_date = '';
        },

        print() {
            this.$refs.table.exportCsv({
                filename: 'Case Export Table',
                original: true
            });

        },


        show(index) {
            if (this.action == 'Assign') {
                let obj = {
                    caseId: this.cases[index].case_id,
                    officer: this.cases[index].case_id,
                }
                this.editData = obj
                this.index = index
                this.Assignmodal = true
            }
            else {

                this.$router.push({ path: this.path + `${this.cases[index].case_id}` })
            }
        },


        async getCases() {
            var res = ''
            if (this.role == 'hr' || this.role == 'reports') {
                var apiUrl = `/api/getCases/${[[this.caseStatus]]}?page=${this.page}&role=hr`
                if (this.searchQuery) { apiUrl += `&query=${this.searchQuery}`; }
                res = await this.callApi('get', apiUrl);
            } else if (this.role == 'admin') {
                var apiUrl = `/api/getCases/${[[this.caseStatus]]}?page=${this.page}&role=admin`
                if (this.searchQuery) { apiUrl += `&query=${this.searchQuery}` }
                res = await this.callApi('get', apiUrl);
            }
            // else if (this.role == 'own_department') {
            //     var apiUrl = `/api/getCases/${[this.caseStatus, this.role, this.role_desc]}?page=${this.page}&role=${this.role_desc}`
            //     if (this.searchQuery) { apiUrl += `&query=${this.searchQuery}`; }
            //     res = await this.callApi('get', apiUrl);
            // }
            else {
                var apiUrl = `/api/getCases/${[this.caseStatus, this.role, this.role_desc]}?page=${this.page}&role=${this.role_desc}`
                if (this.searchQuery) { apiUrl += `&query=${this.searchQuery}`; }
                res = await this.callApi('get', apiUrl);
            }
            if (res.status === 200) {

                this.cases = res.data[0]
                this.total = res.data[1]
                if (this.role == 'own_department') {
                    this.cases = this.cases.filter((item) => item.department === this.$store.state.user.department_id);

                }

            } else {
                this.swr("something went wrong");
            }

        },
        async getDept_() {
            const res = await this.callApi('get', `/api/getDept`)
            if (res.status === 200) {
                this.departments = res.data
             
            }
            else {
                this.swr('something went wrong')
            }
        },
        async getDesig_() {
            const res = await this.callApi('get', `/api/getDesig`)
            if (res.status === 200) {
                this.designations = res.data
              

            }
            else {
                this.swr('something went wrong')
            }
        },
        async getDiv_(newDeptId) {
            const res = await this.callApi('get', `/api/getDiv/?id=${newDeptId}`)
            if (res.status === 200) {
                this.divisions = res.data
            }
            else {
                this.swr('something went wrong')
            }
        },
    },
    async created() {
        await this.getCases()
        await this.getDept_()
        await this.getDesig_()
        await this.getAllDivisions()
    }

}
</script>