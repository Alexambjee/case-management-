<template>
    <div>

    <div class="card-body table-responsive">
        
        <!-- <div class="control d-flex justify-content-between mb-3">
            <div class="form-group">
                <label class="label">Show</label>
                <Select v-model="length" @change="resetPagination()" placeholder="select.." style="width:100px;">
                    <Option value="10">10</Option>
                    <Option value="20">20</Option>
                    <Option value="30">30</Option>
                </Select>
                <label class="label">Entries</label>
            </div>
            <div class="form-group">
                <Input class="input" type="text" v-model="search" placeholder="Search..."
                    @input="resetPagination()" style="width: 250px;" />
            </div>
        
        </div> -->
    
        <table class="table table-striped table-bordered table-hover " >
            
            <!-- <thead> -->
                <!-- <tr> -->
                    <!-- <th v-for="column in columns" :key="column.name" >
                    {{column.label}}
                    </th> -->
                    <!-- <th v-for="column in columns" :key="column.name" @click="sortBy(column.name)"
                    :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                    style="width: 40%; cursor:pointer;">
                    {{column.label}}
                    </th> -->
                    <!-- <th>ACTION</th> -->
                <!-- </tr> -->
            <!-- </thead> -->
        <tbody>
        <tr v-for="user in users" :key="user.id">
            <!-- <tr> -->
                <td>1</td>
                <td>23oppj</td>
                <td>john </td>
                <td>manual</td>
                <td>3/4/2022</td>
             
                <td>
                <router-link to="/Account manager/my cases">
                    <button class="btn btn-circle btn-success text-white btn-sm "
                        style="display: flex;align-items: center;justify-content: center;gap: 5px;">
                        <i class="fa fa-eye mr-3"></i>
                        {{ action }}
                        </button>
                </router-link>

               
                </td>
                
                
            <!-- </tr> -->
            <!-- use paginatedUsers -->
            <!-- <td>{{user.case_id}}</td>
            <td>{{user.pin}}</td>
            <td>{{user.tpname}}</td>
            <td>{{user.source}}</td>
            <td>{{user.created_at}}</td>
            <td>
                <router-link to="/Account manager/my cases">
                    <button class="btn btn-circle btn-success text-white btn-sm "
                        style="display: flex;align-items: center;justify-content: center;gap: 5px;">
                        <i class="fa fa-eye mr-3"></i>
                        start
                        </button>
                </router-link>
            </td> -->
        </tr>
        </tbody>
        </table>
    </div>
    <!-- <div> -->
    <!-- <nav class="pagination" v-if="!tableShow.showdata" style="justify-content: flex-end !important;">
    <span class="page-stats" style="align-items: center; margin-right: 5px;">{{pagination.from}} - {{pagination.to}} of {{pagination.total}}</span>
    <a v-if="pagination.prevPageUrl" class="btn btn-sm btn-primary pagination-previous" @click="--pagination.currentPage"> Prev </a>
    <a class="btn btn-sm btn-primary pagination-previous" v-else disabled> Prev </a>
    <a v-if="pagination.nextPageUrl" class="btn btn-sm pagination-next" @click="++pagination.currentPage"> Next </a>
    <a class="btn btn-sm btn-primary pagination-next" v-else disabled> Next </a>
    </nav> -->
    <!-- <nav class="pagination" v-else>
    <span class="page-stats">
    {{pagination.from}} - {{pagination.to}} of {{filteredUsers.length}}
    <span v-if="`filteredUsers.length < pagination.total`"></span>
    </span>
    <a v-if="pagination.prevPage" class="btn btn-sm btn-primary pagination-previous" @click="--pagination.currentPage"> Prev </a>
    <a class="btn btn-sm pagination-previous btn-primary" v-else disabled> Prev </a>
    <a v-if="pagination.nextPage" class="btn btn-sm btn-primary pagination-next" @click="++pagination.currentPage"> Next </a>
    <a class="btn btn-sm pagination-next btn-primary"  v-else disabled> Next </a>
    </nav> -->
    <!-- </div> -->
    </div>
    </template>
    <script>
    export default {
        props:['path','bath','username','caseStatus','action','column'],
        created() {
        // this.getUsers();
        // Fire.$on('reloadUsers', () => {
        // this.getUsers();
        // })
    },
    data() {
        let sortOrders = {};
        let columns = [
        {label: 'CASE ID', name: 'case_id' },
        {label: 'PIN', name: 'pin'},
        {label: 'TAXPAYER NAME', name: 'tpname'},
        {label: 'SOURCE', name: 'source'},
        {label: 'DATE CREATED', name: 'created_at'},
        ];
        columns.forEach((column) => {
        sortOrders[column.name] = -1;
        });
    return {
        users: [
            {
                case_id:'c001',
                pin:'P099EJKSSIUS',
                tpname:'john osogo',
                source:'manuak',
                created_at:'2022-12-29'
            }
        ],
        columns: columns,
        sortKey: 'created_at',
        sortOrders: sortOrders,
        length: 10,
        search: '',
        tableShow: {
        showdata: true,
        },
        pagination: {
        currentPage: 1,
        total: '10',
        nextPage: '',
        prevPage: '',
        from: '',
        to: ''
        },
    }
    },
    methods: {
        // deleteUser(id) {
        // axios.delete(`/users/${id}/delete`).then(() => {
        // Fire.$emit('reloadUsers')
        // swal(
        // 'Success!',
        // 'User deleted',
        // 'success'
        // )
        // }).catch(() => {
        // swal('Failed', 'There was something wrong', 'warning');
        // });
    // },
    getUsers() {
        // axios.get('/users/', {params: this.tableShow})
        // .then(response => {
        // console.log('The data: ', response.data)
        // this.users = response.data;
        // this.pagination.total = this.users.length;
        // })
        // .catch(errors => {
        // console.log(errors);
        // });
    },
    // paginate(array, length, pageNumber) {
    //     this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
    //     this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
    //     this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
    //     this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
    //     return array.slice((pageNumber - 1) * length, pageNumber * length);
    // },
    resetPagination() {
    //     this.pagination.currentPage = 1;
    //     this.pagination.prevPage = '';
    //     this.pagination.nextPage = '';
    },
    sortBy(key) {
    //     this.resetPagination();
    //     this.sortKey = key;
    //     this.sortOrders[key] = this.sortOrders[key] * -1;
    },
    // getIndex(array, key, value) {
    //     return array.findIndex(i => i[key] == value)
    // },
    // },
    // computed: {
    //     filteredUsers() {
    //     let users = this.users;
    //     if (this.search) {
    //     users = users.filter((row) => {
    //     return Object.keys(row).some((key) => {
    //         return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
    //     })
    //     });
    // }
    // let sortKey = this.sortKey;
    // let order = this.sortOrders[sortKey] || 1;
    // if (sortKey) {
    //     users = users.slice().sort((a, b) => {
    //     let index = this.getIndex(this.columns, 'name', sortKey);
    //     a = String(a[sortKey]).toLowerCase();
    //     b = String(b[sortKey]).toLowerCase();
    //     if (this.columns[index].type && this.columns[index].type === 'date') {
    //         return (a === b ? 0 : new Date(a).getTime() > new Date(b).getTime() ? 1 : -1) * order;
    //     } else if (this.columns[index].type && this.columns[index].type === 'number') {
    //         return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
    //     } else {
    //         return (a === b ? 0 : a > b ? 1 : -1) * order;
    //     }
    //     });
    // }
    // return users;
    // },
    // paginatedUsers() {
    //     return this.paginate(this.filteredUsers, this.length, this.pagination.currentPage);
    // }
    // }
    };
    </script>