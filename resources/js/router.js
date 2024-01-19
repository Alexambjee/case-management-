import Vue from 'vue'
import Router from 'vue-router';
Vue.use(Router);
// project pages
import login from './components/pages/login'
// =================== admin pages=========================
import admin from './roles/admin/admin'
import adminrolemanagment from './roles/admin/pages/role-management'
import adminUserManagement from './roles/admin/pages/user-management'
import admininbox from './roles/admin/pages/inbox'
import adminProgressCases from './roles/admin/pages/admin-progress'
import adminCompletedCases from './roles/admin/pages/completed'
import adminSystemManagement from './roles/admin/pages/system-management.vue'
import adminProgressDetails from './roles/admin/pages/admin-progress-details'
import adminCompletedDetails from './roles/admin/pages/completed-details'


// =================== department pages=========================
import departmentAc from './roles/departments/department'
import departmentAcTasks from './roles/departments/pages/tasks'
import departmentAcTaskDetails from './roles/departments/pages/task-details'
import departmentAcPending from './roles/departments/pages/pending'
import departmentAcPendingDetails from './roles/departments/pages/pending-details'
import departmentAcCompletedCases from './roles/departments/pages/completed-cases'
import departmentAcCompletedDetails from './roles/departments/pages/completed-details'

// =================== initiator pages=========================
import initiatorAc from './roles/initiator/Initiator'
import initiatorAcCases from './roles/initiator/pages/mycases'
import initiatorAcCaseDetails from './roles/initiator/pages/case-details'
import initiatorAcSentback from './roles/initiator/pages/under-review-cases'
import initiatorAcSentbackDetails from './roles/initiator/pages/under-review-details'
import initiatorAcCasesProgress from './roles/initiator/pages/cases-progress'
import initiatorAcProgressDetails from './roles/initiator/pages/progress-details'
import initiatorAcCompletedCases from './roles/initiator/pages/completed-cases'
import initiatorAcCompletedDetails from './roles/initiator/pages/completed-details'

// ============================= End initiator pages ========================

// =================== reports pages=========================
import reportsAc from './roles/reports/reports'
import reportsAcCases from './roles/reports/pages/mycases'
import reportsAcCaseDetails from './roles/reports/pages/case-details'
import reportsAcSentback from './roles/reports/pages/under-review-cases'
import reportsAcSentbackDetails from './roles/reports/pages/under-review-details'
import reportsAcCasesProgress from './roles/reports/pages/cases-progress'
import reportsAcProgressDetails from './roles/reports/pages/progress-details'
import reportsAcCompletedCases from './roles/reports/pages/completed-cases'
import reportsAcCompletedDetails from './roles/reports/pages/completed-details'
import reportsAcFilter from './roles/reports/pages/reports-filtered'
import reportsAcFilterDetails from './roles/reports/pages/reports-filtered-details'

// ============================= End reports pages ========================




const routes = [
    //project routes

    {
        path: '/',
        component: login,
        name: 'login',
        meta: 'Login'

    },

    //  =================== admin routes================
    {
        path: '/admin',
        component: admin,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },

    {
        path: '/admin/role-management',
        component: adminrolemanagment,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },
    {
        path: '/admin/progress-cases',
        component: adminProgressCases,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },
    {
        path: '/admin/progress-cases/:caseId',
        component: adminProgressDetails,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },
    {
        path: '/admin/completed-cases',
        component: adminCompletedCases,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },
    {
        path: '/admin/completed-cases/:caseId',
        component: adminCompletedDetails,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },
    {
        path: '/admin/user-management',
        component: adminUserManagement,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },
    {
        path: '/admin/system-management',
        component: adminSystemManagement,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },

    {
        path: '/admin/inbox',
        component: admininbox,
        // meta: {
        //     isAuth: true,
        //     permitted: 'Admin',
        // },

    },

    //  =================== initiator routes================
    {
        path: '/initiator',
        component: initiatorAc,
    },
    {
        path: '/initiator/my-cases',
        component: initiatorAcCases,
    },
    {
        path: '/initiator/my-cases/:caseId',
        component: initiatorAcCaseDetails,
    },
    // sent back cases
    {
        path: '/initiator/under-review-cases',
        component: initiatorAcSentback,
    },
    // sent back details
    {
        path: '/initiator/under-review-cases/:caseId',
        component: initiatorAcSentbackDetails,
    },

    // cases Progress
    {
        path: '/initiator/cases-progress',
        component: initiatorAcCasesProgress,
    },
    {
        path: '/initiator/cases-progress/:caseId',
        component: initiatorAcProgressDetails,
    },
    // closed cases
    {
        path: '/initiator/completed-cases',
        component: initiatorAcCompletedCases,
    },
    // completed-cases details
    {
        path: '/initiator/completed-cases/:caseId',
        component: initiatorAcCompletedDetails,
    },

    //  =================== reports routes================
    {
        path: '/reports',
        component: reportsAc,
    },
    {
        path: '/reports/my-cases',
        component: reportsAcCases,
    },
    {
        path: '/reports/my-cases/:caseId',
        component: reportsAcCaseDetails,
    },
    // sent back cases
    {
        path: '/reports/under-review-cases',
        component: reportsAcSentback,
    },
    // sent back details
    {
        path: '/reports/under-review-cases/:caseId',
        component: reportsAcSentbackDetails,
    },

    // cases Progress
    {
        path: '/reports/cases-progress',
        component: reportsAcCasesProgress,
    },
    {
        path: '/reports/cases-progress/:caseId',
        component: reportsAcProgressDetails,
    },
    // closed cases
    {
        path: '/reports/completed-cases',
        component: reportsAcCompletedCases,
    },
    // completed-cases details
    {
        path: '/reports/completed-cases/:caseId',
        component: reportsAcCompletedDetails,
    },
    {
        path: '/reports/filtered/',
        component: reportsAcFilter,
    },
    {
        path: '/reports/filtered/:caseId',
        component: reportsAcFilterDetails,
    },
    //  =================== department routes================
    {
        path: '/department/:department',
        component: departmentAc,
    },
    {
        path: '/department/:department/tasks',
        component: departmentAcTasks,
    },
    {
        path: '/department/:department/tasks/:caseId',
        component: departmentAcTaskDetails,
    },
    // sent back cases
    {
        path: '/department/:department/pending',
        component: departmentAcPending,
    },
    // sent back details
    {
        path: '/department/:department/pending/:caseId',
        component: departmentAcPendingDetails,
    },

    // closed cases
    {
        path: '/department/:department/completed-cases',
        component: departmentAcCompletedCases,
    },
    // completed-cases details
    {
        path: '/department/:department/completed-cases/:caseId',
        component: departmentAcCompletedDetails,
    },
    // ============================= End department pages ========================

   
]

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})