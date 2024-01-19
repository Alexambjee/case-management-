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
        props:['path','bath','username','caseStatus','action','column'],
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
                    title: 'CASE ID',
                    key: 'CASE_ID',
                    sortable: true,
                    filterMultiple: false,
                    filters: [
                        {
                            label: 'C001',
                            value: 'C001'
                        },
                        {
                            label: 'C002',
                            value: 'C002'
                        }
                    ],
                    filterMethod (value, row) {
                        return row.CASE_ID.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'TAXPAYER PIN',
                    key: 'PIN',
                    filterMultiple: true,
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: 'P000011',
                            value: 'P000011'
                        },
                        {
                            label: 'P000012',
                            value: 'P000012'
                        }
                    ],
                    filterMethod (value, row) {
                        return row.PIN.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'TAXPAYER NAME',
                    key: 'TP_NAME',
                    sortable: true,
                    filterable: true,
                    filterMultiple: true,
                    filters: [
                        {
                            label: 'Johnson Limited',
                            value: 'Johnson Limited'
                        },
                        {
                            label: 'Kamau Foreing',
                            value: 'Kamau Foreing'
                        }
                    ],
                    filterMethod (value, row) {
                        return row.TP_NAME.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'SOURCE',
                    key: 'SOURCE',
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: 'Manual',
                            value: 'Manual'
                        },
                        {
                            label: 'Risk profile',
                            value: 'Risk profile'
                        }
                        
                    ],
                    filterMethod (value, row) {
                        return row.SOURCE.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'STATUS',
                    key: 'STATUS',
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: 'Contacting Taxpayer',
                            value: 'Contacting Taxpayer'
                        },
                        {
                            label: 'Manual Case Approved',
                            value: 'Manual Case Approved'
                        }
                        
                    ],
                    filterMethod (value, row) {
                        return row.STATUS.indexOf(value) > -1;
                    }
                });
                columns.push({
                    title: 'DATE CREATED',
                    key: 'created_at',
                    sortable: true,
                    filterable: true,
                    filters: [
                        {
                            label: '2022-03-12',
                            value: '2022-03-12'
                        },
                        {
                            label: '2022-04-12',
                            value: '2022-04-12'
                        }
                        
                    ],
                    filterMethod (value, row) {
                        return row.created_at.indexOf(value) > -1;
                    }
                });
                
            columns.push({
                    title: 'ACTION',
                    key: 'Action',
                    render: (h, params) => {
                        return h('div', [
                            h('Button', {
                                props: {
                                    type: 'info',
                                    size: 'small',
                                    ghost:true
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
                        CASE_ID: 'C001',
                        PIN: 'P000011',
                        TP_NAME: 'Johnson Limited',
                        created_at: '2022-03-12',
                        SOURCE: 'Manual',
                        STATUS: 'Contacting Taxpayer',
                       
                    },
                    {
                        CASE_ID: 'C002',
                        PIN: 'P000012',
                        TP_NAME: 'Kamau Foreing',
                        created_at: '2022-04-12',
                        SOURCE: 'Risk profile',
                        STATUS: 'Manual Case Approved',
                       
                    },
                    {
                        CASE_ID: 'C003',
                        PIN: 'P000013',
                        TP_NAME: 'Johnson Limited',
                        created_at: '2022-04-12',
                        SOURCE: 'Manual',
                        STATUS: 'Contacting Taxpayer',
                       
                    },
                   
                    
            )
            return data;
        },

        changePage() {
            this.cases = this.fetchData();
        },
        show(index) {
            if (this.action == 'Assign') {
                let obj = {
                caseId: this.cases[index].CASE_ID,
                officer: this.cases[index].CASE_ID,
            }
            this.editData = obj
            this.index = index
            this.Assignmodal = true
            }
            else {
                
                this.$router.push({path:this.path + `${this.cases[index].CASE_ID}`})
            }
        },
    
    },
    
    async created() {
          
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