<template>
    <div>
        <div class="card bg-dark">
            <div class="card-body d-flex flex-row justify-content-between">
                <div class="form-group">
                    <div class="d-flex flex-row justify-content-between">
                        <Input v-model="createdBy" type="text" style="width: 30%" placeholder="Username" />
                        <Select v-model="selectedValue" class="px-3" clearable filterable style="width: 30%"
                            placeholder="Date">
                            <Option v-for="(d, i) in date" :value='i' :key="i">{{ d }}</Option>
                        </Select>

                        <!-- Conditionally render components based on selected value -->
                        <div v-if="selectedValue === 0">
                            <!-- Render a calendar for selecting a specific day -->
                            <DatePicker v-model="selectedDate" type="date" placeholder="Select date" />
                        </div>

                        <div v-else-if="selectedValue === 1">
                            <!-- Render a month picker -->
                            <DatePicker v-model="selectedDate" type="month" placeholder="Select month" />
                        </div>

                        <div v-else-if="selectedValue === 2">
                            <!-- Render a year picker -->
                            <DatePicker v-model="selectedDate" type="year" placeholder="Select year" />
                        </div>

                        <Select v-model="selectedStatus" class="px-3" clearable filterable style="width: 30%"
                            placeholder="Status">
                            <Option v-for="(s, i) in status" :value='s' :key="i">{{ s }}</Option>
                        </Select>
                        <div class="px-5" style="display: flex; align-items: center;">
                            <span class=" badge" style="font-size:14px; width:30px !important; height:30px !important;
                                            background:#fff !important; color:black; display: flex; justify-content: center; align-items:center; text-align:center;
                                            border-radius:50%; padding: auto;">{{ total }}</span>
                        </div>
                        <div class="px-3">
                            <Button type="success" @click="getCases()" :loading="isLoading" :disabled="isLoading">&nbsp;{{
                                isLoading ? 'Loading..' : 'Submit' }} <i class="fa-regular fa-circle-check"
                                    aria-hidden="true"></i></Button>
                        </div>
                        <div class="px-2">
                            <Button type="primary" @click="print()" :loading="isLoadingP" :disabled="isLoadingP">&nbsp;Print
                                <i class="far fa-circle fa-file" aria-hidden="true"></i></Button>
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
            createdBy: '',
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
            date: ["Day", "Month", "Year"],
            status: ["All", "New Tasks", "In Progress", "Under review", "Completed"],
            selectedValue: null,
            selectedDate: null,
            selectedStatus: '',
            searchQuery: '',
            casesPerPage: 10,
            page: 1,
            index: -1,
            // maxPages: 0,


        }

    },

    computed: {
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
        page(val) {
            this.changePage(val)
        },
        searchQuery: {
            handler(newQuery, oldQuery) {
                this.getCases();
            },
            immediate: true
        }

    },

    methods: {

        changePage(page) {
            this.page = page;
            this.getCases();
        },


        remove() {
            this.isLoading = false;
            this.createModal = false;
            this.SearchPno = false
            this.option = false;
            this.isfound = false;
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
        getStatus() {
            switch (this.selectedStatus) {
                case 'New Tasks':
                    return [0]
                case 'In Progress':
                    return [1, 4]
                case 'Under review':
                    return [3]
                case 'Completed':
                    return [2]
                default:
                    return [0, 1, 2, 3, 4]
            }
        },
        formattedDate() {
            if (this.selectedDate) {
                const date = new Date(this.selectedDate);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                if (this.selectedValue === 0) {
                    return `${year}-${month}-${day}`;
                }
                else if (this.selectedValue === 1) {
                    return `${year}-${month}`;
                } else if (this.selectedValue === 2) {
                    return `${year}`;
                }
            } else {
                return null;
            }
        },
        async getCases() {
            this.isLoading = true;
            var res = ''
            var apiUrl = `/api/reportData/${[this.createdBy, this.formattedDate(), this.getStatus()]}?page=${this.page}`
            if (this.searchQuery) { apiUrl += `&query=${this.searchQuery}`; }
            res = await this.callApi('get', apiUrl);

            if (res.status === 200) {
                this.cases = res.data[0]
                this.total = res.data[1]
                this.isLoading = false;
            } else {
                this.isLoading = false;
                this.swr("something went wrong");
            }
        },



    },
    async created() {
    }

}
</script>