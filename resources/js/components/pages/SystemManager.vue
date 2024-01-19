<template>
    <div>
        <!-- table card -->
        <Modal v-model="department" title="Add New Department" :mask-closable="false" width="400" :styles="{ top: '60px' }"
            :closable="true">
            <div class="p-4"> <!-- Added padding to the entire content -->
                <form id="roleForm">
                    <div class="form-group mb-3">
                        <Input type="text" v-model="departmentData.name" placeholder="Department name" />
                    </div>
                    <div class="form-group">
                        <Input type="text" v-model="departmentData.email" placeholder="Department email" />
                    </div>
                </form>
            </div>

            <!-- Modal footer -->
            <div slot="footer" class="text-right p-3"> <!-- Added padding to the footer -->
                <Button type="success" @click="isEditing ? updateDepartment(departmentId) : addDepartment()"
                    :loading="isLoading" :disabled="isLoading">
                    {{ isLoading ? 'Loading...' : (isEditing ? 'Update' : 'Save') }}
                </Button>
                <Button type="error" @click="remove()">Close</Button>
            </div>
        </Modal>

        <Modal v-model="division" title="Add New Division" :mask-closable="false" width="400" :styles="{ top: '60px' }"
            :closable="true">
            <div class="p-4"> <!-- Added padding to the entire content -->
                <form id="roleForm">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <Select v-model="divisionData.department_id" clearable filterable style="width: 100%"
                                placeholder="Department">
                                <Option v-for="(dept, i) in fetchedDeptData" :value='dept.department_id' :key="i">
                                    {{ dept.department_name }}
                                </Option>
                            </Select>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <Input type="text" v-model="divisionData.name" placeholder="Division name" />
                    </div>
                    <div class="form-group">
                        <Input type="text" v-model="divisionData.email" placeholder="Division email" />
                    </div>
                </form>
            </div>
            <div slot="footer" class="text-right p-3"> <!-- Added padding to the footer -->
                <Button type="success" @click="isEditing ? updateDivision(divisionId) : addDivision()" :loading="isLoading"
                    :disabled="isLoading">
                    {{ isLoading ? 'Loading...' : (isEditing ? 'Update' : 'Save') }}
                </Button>
                <Button type="error" @click="remove()">Close</Button>
            </div>
        </Modal>

        <Modal v-model="designation" title="Add New Designation" :mask-closable="false" width="400"
            :styles="{ top: '60px' }" :closable="true">
            <div class="p-4"> <!-- Added padding to the entire content -->
                <form id="roleForm">
                    <div class="form-group mb-3">
                        <Input type="text" v-model="designationData.name" placeholder="Designation name" />
                    </div>
                </form>
            </div>

            <div slot="footer" class="text-right p-3"> <!-- Added padding to the footer -->
                <Button type="success" @click="isEditing ? updateDesignation(designationId) : addDesignation()"
                    :loading="isLoading" :disabled="isLoading">
                    {{ isLoading ? 'Loading...' : (isEditing ? 'Update' : 'Save') }}
                </Button>
                <Button type="error" @click="remove()">Close</Button>
            </div>
        </Modal>


        <div class="card">
            <!-- headers -->
            <div class="d-flex justify-content-around">
                <div class=" col-md-3 text-center ml-auto mr-5" id="headingOne">
                    <h5 class="mb-0 shadow" style="border:1px solid blue;">
                        <button class="btn" data-toggle="collapse" data-target="#dept" aria-expanded="true"
                            aria-controls="collapseOne">
                            Departments
                        </button>
                    </h5>
                </div>

                <div class=" col-md-3 text-center  mr-auto ml-5" id="">
                    <h5 class="mb-0 shadow" style="border:1px solid blue;">
                        <button class="btn collapsed" data-toggle="collapse" data-target="#div" aria-expanded="false"
                            aria-controls="#Response">
                            Divisions
                        </button>
                    </h5>
                </div>
                <div class=" col-md-3 text-center  mr-auto ml-5" id="">
                    <h5 class="mb-0 shadow" style="border:1px solid blue;">
                        <button class="btn collapsed" data-toggle="collapse" data-target="#design" aria-expanded="false"
                            aria-controls="#Response">
                            Designations
                        </button>
                    </h5>
                </div>

            </div>
            <!-- headers ends -->
            <div id="accordion" class="col-lg-12 mt-3" style="width:100%">
                <!-- Departments -->
                <div class="card shadow">
                    <div id="dept" class="collapse" aria-labelledby="awaiting" data-parent="#accordion">
                        <div class="container">
                            <div class="card-header bg-dark text-muted d-flex align-items-center justify-content-between">
                                <div class="text-left">
                                    Department Records
                                </div>
                                <div class="text-right">
                                    <button type="info" ghost @click="department = true" class="btn btn-primary">Add
                                        Department</button>
                                </div>
                            </div>
                            <div class="table-responsive"> <!-- Use table-responsive container -->
                                <table style="border-style:none !important; width: 100%;"
                                    class="table no-wrap email-table table-striped table-hover">
                                    <thead class="text-black">
                                        <tr>
                                            <th class="text-black text-center">ID</th>
                                            <th class="text-black text-center">NAME</th>
                                            <th class="text-black text-center">EMAIL</th>
                                            <th class="text-black text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-body" style="font-size: 12px;">
                                        <tr v-for="(dept, i) in fetchedDeptData" v-if="fetchedDeptData.length">
                                            <td class="text-center">{{ dept.department_id }}</td>
                                            <td class="text-center">{{ dept.department_name }}</td>
                                            <td class="text-center">{{ dept.department_email }}</td>
                                            <td class="text-center">
                                                <Button type="info" @click="getDepartment(dept.department_id)">Edit</Button>
                                                <Button type="error"
                                                    @click="confirmModal(dept.department_id, 'dept')">Delete</Button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Departments ends-->

                <!-- Divisions -->
                <div class="card shadow">
                    <div id="div" class="collapse" aria-labelledby="awaiting" data-parent="#accordion">
                        <div class="container">
                            <div class="card-header bg-dark text-muted d-flex align-items-center justify-content-between">
                                <div class="text-left">
                                    Division Records
                                </div>
                                <div class="text-right">
                                    <button type="info" ghost @click="division = true" class="btn btn-primary">Add
                                        Division</button>
                                </div>
                            </div>
                            <table style="border-style:none !important;width:100%;"
                                class="table no-wrap email-table table-striped table-hover">
                                <thead class="text-black">
                                    <tr>
                                        <th class="text-black text-center">ID</th>
                                        <th class="text-black text-center">NAME</th>
                                        <th class="text-black text-center">DEPARTMENT</th>
                                        <th class="text-black text-center">EMAIL</th>
                                        <th class="text-black text-center">Action</th>

                                    </tr>
                                </thead>
                                <tbody class="table-body" style="font-size:12px;">
                                    <tr v-for="(div, i) in fetchedDivData" v-if="fetchedDivData.length">
                                         <td class="text-center">{{ div.division_id }}</td>
                                         <td class="text-center">{{ div.division_name }}</td>
                                         <td class="text-center">{{ div.department_name }}</td>
                                         <td class="text-center">{{ div.division_email }}</td>
                                         <td class="text-center">
                                            <Button type="info" @click="getDivision(div.division_id)">Edit</Button>
                                            <Button type="error"
                                                @click="confirmModal(div.division_id, 'div')">Delete</Button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Divisions end -->
                <!--Designation -->
                <div class="card shadow">
                    <div id="design" class="collapse" aria-labelledby="awaiting" data-parent="#accordion">
                        <div class="container">
                            <div class="card-header bg-dark text-muted d-flex align-items-center justify-content-between">
                                <div class="text-left">
                                    Designation Records
                                </div>
                                <div class="text-right">
                                    <button type="info" ghost @click="designation = true" class="btn btn-primary">Add
                                        Designation</button>
                                </div>
                            </div>
                            <table style="border-style:none !important;width:100%;"
                                class="table no-wrap email-table table-striped table-hover">
                                <thead class="text-black">
                                    <tr>
                                        <th class="text-black text-center">ID</th>
                                        <th class="text-black text-center">NAME</th>
                                        <th class="text-black text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body" style="font-size:12px;">
                                    <tr v-for="(desig, i) in fetchedDesigData" v-if="fetchedDesigData.length">
                                         <td class="text-center">{{ desig.designation_id }}</td>
                                         <td class="text-center">{{ desig.designation_name }}</td>
                                         <td class="text-center">
                                            <Button type="info" @click="getDesignation(desig.designation_id)">Edit</Button>
                                            <Button type="error"
                                                @click="confirmModal(desig.designation_id, 'desig')">Delete</Button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Designation end -->



            </div>
        </div>

        <!-- table card ends-->
    </div>
</template>

<script>
import caseTable from './caseTable.vue'

export default {
    props: ['path', 'username', 'caseStatus', 'column', 'ApprovedAction',],
    data() {
        return {
            departmentData: {
                name: '',
                email: '',
            },
            fetchedDeptData: [],
            fetchedDesigData: [],
            fetchedDivData: [],
            divisionData: {
                name: '',
                department_id: null,
                email: '',
            },
            designationData: {
                name: ''
            },
            department: false,
            division: false,
            designation: false,
            departmentId: null,
            designationId: null,
            divisionId: null,
            isEditing: false,
            isLoading: false
        }
    },
    components: {
        caseTable
    },
    methods: {
        confirmModal(Id, tag) {
            this.$Modal.confirm({
                title: 'Confirm Deletion ',
                content: '<p>Are you Sure You want to Delete</p>',
                okText: 'Delete',
                cancelText: 'Cancel',

                loading: true,
                onOk: () => {
                    setTimeout(() => {
                        this.$Modal.remove();
                        switch (tag) {
                            case 'desig':
                                this.deleteDesignation(Id);
                                break;
                            case 'dept':
                                this.deleteDepartment(Id);
                                break;
                            case 'div':
                                this.deleteDivision(Id);
                                break;
                            default: this.$Modal.remove(); break;

                        }
                    }, 2000);
                }
            });
        },

        remove() {
            this.department = false;
            this.designation = false;
            this.division = false;
            this.departmentData.name = '';
            this.departmentData.email = '';
            this.designationData.name = '';
            this.divisionData.name = '';
            this.divisionData.email = '';
            this.divisionData.department_id = null;
            this.isEditing = false;
            this.isLoading = false;
        },
        //Department functions
        async addDepartment() {
            this.isLoading = true;
            const res = await this.callApi('post', '/api/addDepartment', this.departmentData)
            if (res.status === 200) {
                this.fetchedDeptData = res.data.slice().reverse();
                this.success("Added Successfully!");
                this.isLoading = false;

            } else {
                this.swr('something went wrong')
            }
            this.remove();
        },

        async updateDepartment(Id) {
            this.isLoading = true;
            const res = await this.callApi('post', `/api/updateDepartment?id=${Id}`, this.departmentData)
            if (res.status === 200) {
                this.fetchedDeptData = res.data.slice().reverse();
                this.success("Updated Successfully!");
                this.isLoading = false;
            } else {
                this.swr('something went wrong')
            }
            this.remove();

        },

        async deleteDepartment(Id) {
            const res = await this.callApi('delete', `/api/deleteDepartment?id=${Id}`)
            if (res.status === 200) {
                this.fetchedDeptData = res.data;
                this.success("Deleted Successfully!");
            } else {
                this.swr('something went wrong')
            }
            this.remove();

        },
        async getDepartment(Id) {
            this.department = true;
            this.departmentId = Id;
            this.isEditing = true;
            const res = await this.callApi('get', `/api/getDepartment/?id=${Id}`)
            if (res.status == 200) {
                this.departmentData.name = res.data["department_name"];
                this.departmentData.email = res.data["department_email"];
            }
            else {
                this.swr('something went wrong')
            }

        },

        //Designation functions
        async addDesignation() {
            this.isLoading = true;
            const res = await this.callApi('post', '/api/addDesignation', this.designationData)
            if (res.status === 200) {
                this.fetchedDesigData = res.data.slice().reverse();
                this.success("Added Successfully!");
                this.isLoading = false;

            } else {
                this.swr('something went wrong')
            }
            this.remove();
        },

        async updateDesignation(Id) {
            this.isLoading = true;
            const res = await this.callApi('post', `/api/updateDesignation?id=${Id}`, this.designationData)
            if (res.status === 200) {
                this.fetchedDesigData = res.data.slice().reverse();
                this.success("Updated Successfully!");
                this.isLoading = false;
            } else {
                this.swr('something went wrong')
            }
            this.remove();

        },

        async deleteDesignation(Id) {
            const res = await this.callApi('delete', `/api/deleteDesignation?id=${Id}`)
            if (res.status === 200) {
                this.fetchedDesigData = res.data;
                this.success("Deleted Successfully!");
            } else {
                this.swr('something went wrong')
            }
            this.remove();

        },
        async getDesignation(Id) {
            this.designation = true;
            this.designationId = Id;
            this.isEditing = true;
            const res = await this.callApi('get', `/api/getDesignation/?id=${Id}`)
            if (res.status == 200) {
                this.designationData.name = res.data["designation_name"];
            }
            else {
                this.swr('something went wrong')
            }

        },
        //Division functions
        async addDivision() {
            this.isLoading = true;
            const res = await this.callApi('post', '/api/addDivision', this.divisionData)
            if (res.status === 200) {
                this.fetchedDivData = res.data.slice().reverse();
                this.success("Added Successfully!");
                this.isLoading = false;

            } else {
                this.swr('something went wrong')
            }
            this.remove();
        },

        async updateDivision(Id) {
            this.isLoading = true;
            const res = await this.callApi('post', `/api/updateDivision?id=${Id}`, this.divisionData)
            if (res.status === 200) {
                this.fetchedDivData = res.data.slice().reverse();
                this.success("Updated Successfully!");
                this.isLoading = false;
            } else {
                this.swr('something went wrong')
            }
            this.remove();

        },

        async deleteDivision(Id) {
            const res = await this.callApi('delete', `/api/deleteDivision?id=${Id}`)
            if (res.status === 200) {
                this.fetchedDivData = res.data;
                this.success("Deleted Successfully!");
            } else {
                this.swr('something went wrong')
            }
            this.remove();

        },
        async getDivision(Id) {
            this.division = true;
            this.divisionId = Id;
            this.isEditing = true;
            const res = await this.callApi('get', `/api/getDivision/?id=${Id}`)
            if (res.status == 200) {
                this.divisionData.department_id = res.data["department_id"];
                this.divisionData.name = res.data["division_name"];
                this.divisionData.email = res.data["division_email"];
            }
            else {
                this.swr('something went wrong')
            }

        },


    },


    async created() {
        const resDept = await this.callApi('get', '/api/getAllDepartments')
        const resDesig = await this.callApi('get', '/api/getAllDesignations')
        const resDiv = await this.callApi('get', '/api/getAllDivisions')
        if (resDept.status === 200 && resDesig.status === 200 && resDiv.status === 200) {
            this.fetchedDeptData = resDept.data
            this.fetchedDesigData = resDesig.data
            this.fetchedDivData = resDiv.data
        }
        else {
            this.swr('something went wrong')
        }
    }

}
</script>