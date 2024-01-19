<template>
    <div>
    <!-- table card -->
     <div class="card-body table-responsive">
        <div class="control d-flex justify-content-between mb-3">
            <!-- <div class="form-group">
                <label class="label">Show</label>
                <Select v-model="length" @change="resetPagination()" placeholder="select.." style="width:100px;">
                    <Option value="10">10</Option>
                    <Option value="20">20</Option>
                    <Option value="30">30</Option>
                </Select>
                <label class="label">Entries</label>
            </div> -->
            <div class="form-group">
                <Input class="input" type="text" v-model="search" placeholder="Search..."
                    @input="resetPagination()" style="width: 250px;" />
                    <Button type="default" @click="print" >Export Csv</Button>
                    <Button type="default" >Print</Button>
            </div>
        
        </div>
        <!-- table -->
        <Table :border="showBorder" :stripe="showStripe" :show-header="showHeader" :height="fixedHeader ? 250 : ''" 
        :size="tableSize" :data="cases" :columns="Columns" ref="table" id="table"></Table>

        <div style="margin: 10px;overflow: hidden">
            <div style="float: right;">
                <Page :total="total" :current="1" @on-change="changePage" show-sizer show-total 
                prev-text="Previous" next-text="Next"></Page>
            </div>
        </div>
        <!-- table ends-->
       
        </div>
    <!-- table card ends-->
    </div>
    </template>
    
    <script>
    export default {
        props:['path','username','caseStatus','approveAction','column','role','rejectAction'],
    data() {
        return {
            cases: [
               
            ],
            Assignmodal: false,
            editData: {},
            
            total: '3',
            index:-1,
            cases: this.fetchData(),
            showBorder: false,
            showStripe: true,
            showHeader: true,
            showIndex: false,
            showCheckbox: false,
            fixedHeader: true,
            tableSize: 'default'
            
        }
            
    },
    computed: {
            Columns () {
            let columns = [];
                this.loading = false
                columns.push({
                    title: 'ACCOUNT MANAGER REQUESTING',
                    key: 'ACC_REQUESTER',
                    sortable: true,
                    filterMultiple: false,
                    filters: [
                        {
                            label: 'K0001234',
                            value: 'K0001234'
                        },
                        
                    ],
                    filterMethod (value, row) {
                        return row.ACC_REQUESTER.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'ACCOUNT MANAGER REQUESTED',
                    key: 'ACC_REQUESTED',
                    filterMultiple: true,
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: 'K003434',
                            value: 'K003434'
                        },
                       
                    ],
                    filterMethod (value, row) {
                        return row.ACC_REQUESTED.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'START DATE',
                    key: 'START_DATE',
                    sortable: true,
                    filterable: true,
                    filterMultiple: true,
                    filters: [
                        {
                            label: '2022-03-12',
                            value: '2022-03-12'
                        },
                        
                    ],
                    filterMethod (value, row) {
                        return row.START_DATE.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'END DATE',
                    key: 'END_DATE',
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: '2022-04-12',
                            value: '2022-04-12'
                        },
                       
                        
                    ],
                    filterMethod (value, row) {
                        return row.END_DATE.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'REASON GIVEN',
                    key: 'REASON_GIVEN',
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: 'Sick leave',
                            value: 'Sick leave'
                        },
                        {
                            label: 'On Official Leave',
                            value: 'On Official Leave'
                        }
                        
                    ],
                    filterMethod (value, row) {
                        return row.REASON_GIVEN.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'DATE REQUESTED',
                    key: 'created_at',
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: '2022-03-12',
                            value: '2022-03-12'
                        },
                        
                        
                    ],
                    filterMethod (value, row) {
                        return row.created_at.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'STATUS',
                    key: 'STATUS',
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: 'Pending',
                            value: 'Pending'
                        },
                        
                        
                    ],
                    filterMethod (value, row) {
                        return row.STATUS.indexOf(value) > -1;
                    }
                });
                // show is action prop is sent
            if (this.approveAction) {
                          
                columns.push({
                        title: 'APPROVE',
                    key: 'Approve',
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'info',
                                        size: 'small'
                                    },
                                    // style: {
                                    //     marginRight: '5px'
                                    // },
                                    on: {
                                        click: () => {

                                            this.approve(params.index)
                                        }
                                    }
                                }, this.approveAction),
                            ]);
                            }
                        
                    }); 
                columns.push({
                    title: 'REJECT',
                    key: 'Reject',
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small',
                                        ghost:true
                                    },
                                    // style: {
                                    //     marginRight: '5px'
                                    // },
                                    on: {
                                        click: () => {

                                            this.reject(params.index)
                                        }
                                    }
                                }, this.rejectAction),
                            ]);
                            }
                        
                    }); 
            }
                else{}
             
                return columns;
            }
        },

    methods: {
        print() {
            this.$refs.table.exportCsv({
            filename: 'Case Export Table',
            original: true
             });
            
        },
        fetchData() {
            let data = []
            data.push(
                    {
                        id: '1',
                        ACC_REQUESTER: 'K0001234',
                        ACC_REQUESTED: 'K003434',
                        created_at: '2022-03-12',
                        START_DATE: '2022-03-12',
                        STATUS: 'Pending',
                        REASON_GIVEN:'Sick leave',
                        END_DATE:'2022-04-12'
                       
                    },
                    
            )
            return data;
        },

        changePage() {
            this.cases = this.fetchData();
        },
        approve(index) {
            // if (this.action == 'Appro') {
            //     let obj = {
            //     caseId: this.cases[index].CASE_ID,
            //     officer: this.cases[index].CASE_ID,
            // }
            // this.editData = obj
            // this.index = index
            // this.Assignmodal = true
            // }
            // else {
                
            //     this.$router.push({path:this.path + `${this.cases[index].CASE_ID}`})
            // }
        },
        reject(index) {
            // if (this.action == 'Appro') {
            //     let obj = {
            //     caseId: this.cases[index].CASE_ID,
            //     officer: this.cases[index].CASE_ID,
            // }
            // this.editData = obj
            // this.index = index
            // this.Assignmodal = true
            // }
            // else {
                
            //     this.$router.push({path:this.path + `${this.cases[index].CASE_ID}`})
            // }
        },
    
    },
    
    async created() {
        console.log(this.action)
          
            // const res = await this.callApi('get',`/api/getCases/${[this.data.caseStatus +"*"+ this.data.Data]}`)
    
            // if(res.status===200){
            //     this.cases = res.data
            // }
            // else{
            //     this.swr('something went wrong')
    
            // }
           
      }
    
    }
    </script>