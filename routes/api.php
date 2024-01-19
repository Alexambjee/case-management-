<?php

// use mail;
use App\Http\Controllers\NewPdfController;
use App\Http\Controllers;
use App\Mail\emailTaxpayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IroUserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TaxpayerController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\IroMappingController;
use App\Http\Controllers\BlobController;
use App\Http\Controllers\AdminPdf;
use App\Http\Controllers\SystemManagerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 Route::get('/getMessageUsers/{username}',[MessageController::class, 'getMessageUsers']);


// ======================= ADMIN ROUTES ==========================
Route::get('/logout',[LoginController::class, 'Logout']);

//Getting taxpayer setails
Route::get('/getTaxpayerDetails/{tPin}',[TaxpayerController::class,'getTaxpayerDetails']);
Route::get('/isPinExist/{tPin}',[TaxpayerController::class,'isPinExist']);
Route::get('/getAuditTrail',[AuditTrailController::class,'getAuditTrail']);
Route::get('/getStationId/{tStation}',[TaxpayerController::class,'getStationId']);

//user routes
Route::get('/getAllUsers',[UserController::class,'getAllUsers']);
Route::get('/getAllUsersWithout',[UserController::class,'getAllUsersWithout']);
Route::get('/getUserInfoWhere/{userName}',[UserController::class,'getUserInfoWhere']);
Route::get('/getUserInfo/{userName}', [UserController::class, 'getUserInfo']);
Route::post('/createUser',[UserController::class,'createUser']);
Route::post('/uploadMapping',[IroMappingController::class,'uploadMapping']);
Route::post('/uploadDwMapping',[IroMappingController::class,'uploadDwMapping']);
Route::get('/getUserMapping',[IroMappingController::class,'getUserMapping']);
Route::post('/activateDeactivateUser',[UserController::class,'activateDeactivateUser']);
Route::post('/changeUserRole',[UserController::class,'changeUserRole']);

Route::get('/getUserDept',[UserController::class,'getUserDept']);

// roles routes
Route::get('/fetchRoles',[RoleController::class,'fetchRoles']);
Route::get('/fetchRolesWithout',[RoleController::class,'fetchRolesWithout']);
Route::post('/storeRoles',[RoleController::class,'store']);
Route::post('/updateRole',[RoleController::class,'updateRole']);
Route::delete('/deleteRole',[RoleController::class,'deleteRole']);

// cases routes
// Route::get('/getA',[CaseController::class,'getA']);
Route::get('/getAllCases',[CaseController::class,'getAllCases']);
Route::get('/getCases/{data}',[CaseController::class,'getCases']);
Route::get('/getReassignedCases',[CaseController::class,'getReassignedCases']);
Route::get('/fetchDetails/{caseId}',[CaseController::class,'fetchDetails']);
Route::get('/getTypeId/{caseId}',[CaseController::class,'fetchTypeID']);
Route::get('/getTypeName/{typeId}',[CaseController::class,'getTypeName']);
Route::get('/getTypeName/{typeId}',[CaseController::class,'fetchTypeName']);
// ferching taxpayer responses status
Route::get('/getResponsedCases/{data}',[CaseController::class,'fetchRespondedCases']);

Route::post('/createManualCase',[CaseController::class,'createManualCase']);

Route::post('/createAutoCase',[CaseController::class,'createAutoCase']);


Route::post('/updateCase',[CaseController::class,'updateCase']);
Route::post('/updateLib',[CaseController::class,'updateLib']);
//getting station
Route::get('/getStations',[CaseController::class,'getStations']);
//getting Obligation

// officer total cases
Route::get('/TotalOfficerCases/{username}',[CaseController::class,'getOfficerTotalCases']);
Route::get('/ResponseTotalCases/{username}',[CaseController::class,'getOfficerTotalResponses']);
Route::get('/ForwardTotalCases/{username}',[CaseController::class,'getOfficerTotalForward']);
Route::get('/RejectedTotalCases/{username}',[CaseController::class,'getOfficerTotalRejected']);
// responses
Route::get('/getOfficerTotalResponsed/{username}',[CaseController::class,'getOfficerTotalResponsed']);
Route::get('/getOfficerTotalNotResponded/{username}',[CaseController::class,'getOfficerTotalNotResponded']);
Route::get('/getOfficerTotalAwaitingResponse/{username}',[CaseController::class,'getOfficerTotalAwaitingResponse']);

// chnging response status
Route::post('/changeResponseStatus',[CaseController::class,'changeResponseStatus']);
Route::post('/invalidateCase',[MessageController::class,'invalidateCase']);


//response form updatecase
Route::post('/updateCase',[CaseController::class,'updateCase']);
Route::get('/get_liabilities/{data}',[CaseController::class,'get_liabilities']);

// case background
Route::post('/background',[CaseController::class,'background']);

//sent back cases route
Route::post('/ResubmitReport',[CaseController::class,'ResubmitReport']);

// =================attachment routes ==========
Route::get('/fetchAttachments/{caseId}',[AttachmentController::class,'fetchAttachments']);
// Route::get('/getAttachments/{tPin}',[AttachmentController::class,'getAttachment']);
Route::get('/getTaxpayerAttachments/{tPin}',[AttachmentController::class,'getTaxpayerAttachments']);
Route::get('/fetchAssessment/{caseId}',[CaseController::class,'fetchAssessment']);

// user routes
// Route::get('/getUsers',[UserController::class,'getUsers']);


// manager routes
Route::get('/TotalManagerCases/{username}',[CaseController::class,'getTotalManagerCases']);
Route::get('/ReassignTotalCases/{username}',[CaseController::class,'getManagerReassignCases']);
Route::get('/RejectedCases/{username}',[CaseController::class,'getManagerTotalRejected']);
Route::get('/ManagerTotalDecisions/{username}',[CaseController::class,'getManagerTotalDecisions']);


// chief manager routes
Route::get('/TotalChiefCases/{username}',[CaseController::class,'getTotalChiefCases']);
Route::get('/ChiefReassignTotalCases/{username}',[CaseController::class,'getChiefReassignCases']);
Route::get('/ChiefTotalInbox/{username}',[CaseController::class,'getChiefTotalInbox']);
Route::get('/ChiefTotalDecisions/{username}',[CaseController::class,'getChiefTotalDecisions']);

//Reassign cases routes
Route::get('/fetchOfficers/{Fdata}',[CaseController::class,'fetchOfficers']);
Route::post('/ReassignCase',[CaseController::class,'ReassignCase']);
Route::post('/AdminReassignCase',[CaseController::class,'AdminReassignCase']);


// approve/reject selection routes
Route::get('/fetchApprovals/{approvalType}',[CaseController::class,'fetchApprovals']);
Route::get('/getForwardOption/{approvalType}',[CaseController::class,'getForwardOption']);
Route::get('/fetchRejections/{approvalType}',[CaseController::class,'fetchRejections']);
Route::get('/getOptionName/{optionName}',[CaseController::class,'getOptionName']);
Route::get('/fetchReasons/{ReasonType}',[CaseController::class,'fetchReasons']);
// =================== approve, forward and reject case routes ====================
// approve case
Route::post('/ApproveCase',[CaseController::class,'ApproveCase']);
// reject case
Route::post('/RejectCase',[CaseController::class,'RejectCase']);
// forward to cm case
Route::post('/ForwardCaseToCM',[CaseController::class,'ForwardCaseToCM']);
// forwarding case decision
Route::post('/ForwardCaseDecision',[CaseController::class,'ForwardCaseDecision']);
Route::post('/ForwardCaseDecision',[CaseController::class,'ForwardCaseDecision']);

// ====================== INDEPENDENT ROUTES ==================
Route::post('/login',[LoginController::class,'Login']);

//messaging routes

// uploading files
Route::post('/upload',[AttachmentController::class,'upload']);
// fetching user messages
Route::get('/getMessages/{username}',[MessageController::class,'fetchMessages']);
// Route::get('/getUserTotalMessages/{username}',[MessageController::class,'getUserTotalMessages']);
//  fetching unread messages
Route::get('/unreadMessages/{username}',[MessageController::class,'unreadMessages']);
Route::post('/changeMessageStatus',[MessageController::class,'changeMessageStatus']);
// fetch select options based on type
Route::get('/fetchSelectOption/{type}',[CaseController::class,'fetchSelectOption']);
Route::get('/fetchDecisions/{decisiontype}',[CaseController::class,'fetchDecisions']);
// comments routes
Route::get('/get_comments/{caseId}',[CommentController::class,'getComments']);
// contacting taxpayer route
Route::post('/contactTaxpayer',[MessageController::class,'contactTaxpayer']);
// fetching taxpayer communication
Route::get('/getTaxpayerMessages/{caseId}',[MessageController::class,'fetchTaxpayerMmessages']);
//COMMENTS ROUTES
Route::get('/getComments',[CommentController::class,'getComments']);
// compose message route
Route::post('/composeMail',[MessageController::class,'composeMail']);
Route::post('/replyMail',[MessageController::class,'replyMail']);
// pdf routes
Route::get('/pdfCertificate/{caseId}', [NewPdfController::class, 'printCertificate']);
Route::get('/pdfClearance/{caseId}', [NewPdfController::class, 'printClearance']);


Route::get('/getDept',[CaseController::class,'getDept']);
Route::get('/getDiv',[CaseController::class,'getDiv']);
Route::get('/getDesig',[CaseController::class,'getDesig']);


Route::get('/ResponseTotal/{username}',[CaseController::class,'getResponseTotal']);
Route::get('/AppealedTotal/{username}',[CaseController::class,'getAppealedTotal']);
Route::get('/CompletedTotal/{username}',[CaseController::class,'getCompletedTotal']);
Route::get('/ReassignedTotal/{username}',[CaseController::class,'getReassignedTotal']);
Route::get('/RejectedTotal/{username}',[CaseController::class,'getRejectedTotal']);

Route::get('/InProgress/{username}',[CaseController::class,'getInprogress']);
Route::get('/Assigned/{username}',[CaseController::class,'getAssigned']);
Route::get('/donData/{data}',[CaseController::class,'getDonData']);
Route::get('/barData/{data}',[CaseController::class,'getBarData']);

// ===================fetching reports++++==================
Route::get('/getProgress/{data}',[CaseController::class,'getProgress']);

// ===================fetching Admin reports++++==================
// Route::get('/getAdminProgress',[CaseController::class,'getAdminProgress']);
Route::get('/getAdminProgress',[CaseController::class,'getAdminProgress']);
Route::get('/fetchCompletedCases',[CaseController::class,'fetchCompletedCases']);
Route::get('/fetchInProgress',[CaseController::class,'fetchInProgress']);
Route::get('/revertedCases',[CaseController::class,'revertedCases']);
Route::get('/fetchReportData',[CaseController::class,'fetchReportData']);
Route::get('/fetchReportDataDept/{dept}',[CaseController::class,'fetchReportDataDept']);
Route::get('/getReportBarData',[CaseController::class,'getBarData']);
Route::get('/reportData/{data}', [CaseController::class, 'reportData']);




// get reason for rejection
Route::get('/getReasonName/{reasonId}',[CaseController::class,'getReasonName']);

//System management
Route::post('/addDepartment', [SystemManagerController::class, 'addDepartment']);
Route::get('/getAllDepartments', [SystemManagerController::class, 'getAllDepartments']);
Route::get('/getDepartment', [SystemManagerController::class, 'getDepartment']);
Route::post('/updateDepartment', [SystemManagerController::class, 'updateDepartment']);
Route::delete('/deleteDepartment', [SystemManagerController::class, 'deleteDepartment']);

Route::post('/addDesignation', [SystemManagerController::class, 'addDesignation']);
Route::get('/getAllDesignations', [SystemManagerController::class, 'getAllDesignations']);
Route::get('/getDesignation', [SystemManagerController::class, 'getDesignation']);
Route::post('/updateDesignation', [SystemManagerController::class, 'updateDesignation']);
Route::delete('/deleteDesignation', [SystemManagerController::class, 'deleteDesignation']);

Route::post('/addDivision', [SystemManagerController::class, 'addDivision']);
Route::get('/getAllDivisions', [SystemManagerController::class, 'getAllDivisions']);
Route::get('/getDivision', [SystemManagerController::class, 'getDivision']);
Route::post('/updateDivision', [SystemManagerController::class, 'updateDivision']);
Route::delete('/deleteDivision', [SystemManagerController::class, 'deleteDivision']);
