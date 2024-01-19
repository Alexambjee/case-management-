<template>
<div>
    <table  style="border:none !important;width:100%;" class="table table-bordered table-striped mb-3" >
        <thead class="table-header bg-dark">
            <tr>
                <th class="text-white">CASE ID</th>
                <th class="text-white">STAFF_NAME</th>
                <th class="text-white">P_NUMBER</th>
                <th class="text-white">DEPARTMENT</th>
                <th class="text-white">STATION</th>
                <th class="text-white">EMAIL</th>
                <th class="text-white">STATUS</th>
            </tr>
        </thead>
        <tbody class="table-body">
                <tr>
                    <td>{{ details.case_id}}</td>
                    <td>{{ details.employee_name }}</td>
                    <td>{{ details.user_name }}</td>
                    <td>{{ details.department_name }}</td>
                    <td>{{ details.station }}</td>
                    <td>{{ details.email }}</td>
                    <td>{{details.status_name }}</td>
                </tr>
            </tbody>
    </table>
    <hr/>

    <!-- case details -->
    <div class="case-details">
        <div class="row">
                <!-- taxpayer details -->
                <div class="taxpayer-details col-sm-6 col-md-6 col-lg-6">
                    <div class="card shadow">
                        <div class="card-header headings text-white"
                            style="text-transform:uppercase;background: #212529; font-size:12px;">
                            Personal Details
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <div class="card-items">
                                    <span class="text-left">Exit Date</span>
                                    <p class="text-left">{{ details.exit_date }}</p>
                                </div>
                                <div class="card-items">
                                    <span class="text-left">Appointment_Date</span>
                                    <p class="text-left">{{ details.join_date }}</p>
                                </div>
                                <div class="card-items">
                                    <span class="text-left">Division</span>
                                    <p class="">{{ details.division_name }}</p>
                                </div>
                                <div class="card-items">
                                    <span class="text-left">Designation</span>
                                    <p class="">{{ details.designation_name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- taxpayer details ends-->
                <!-- obligation details -->
                <div class="taxpayer-details col-sm-6 col-md-6 col-lg-6">
                    <div class="card shadow">
                        <div class="card-header headings text-white"
                            style="text-transform:uppercase; background: #212529;font-size:12px;">
                            Contact Details
                        </div>
                        <div class="card-body">
                            <div class="card-content">
                                <!-- <div class="card-items">
                                    <span class="text-left">Station</span>
                                    <p class="">{{ details.station }}</p>
                                </div> -->
                                <div class="card-items">
                                    <span class="text-left">Address</span>
                                    <p class="">{{ details.address }}</p>
                                </div>
                                <div class="card-items">
                                    <span class="text-left">Email</span>
                                    <p class="">{{ details.email }}</p>
                                </div>
                                <div class="card-items">
                                    <span class="text-left">Telephone</span>
                                    <p class="">{{ details.phone }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
</template>

<script>
export default {
    props: ['details', 'role', 'opt', 'rejectionId', 'ReasonName', 'stage'],

    data() {
        return {
            historyModal: false,
            caseId: this.$route.params.caseId
        }
    },

    methods: {
        formatDate(date) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(date).toLocaleDateString('en-GB', options);
        },
 
    },

    computed: {

        formattedDetails() {
            return this.details || null.map(staff => {
                 staff.EMAIL = staff.EMAIL.toLowerCase();
                 staff.p_no = staff.P_NO.toUpperCase();
                
                return staff;
            });
        },
    },

    created() {

    }
}
</script>
