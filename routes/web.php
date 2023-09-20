<?php

use App\Http\Controllers\Auth\RemoteLoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Matters\FileOpeningController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Download\DownloadDocumentController;
use App\Http\Controllers\Masters\EmployeeController;
use App\Http\Controllers\Masters\CityController;
use App\Http\Controllers\Masters\BrokerageController;
use App\Http\Controllers\Masters\CityDepartmentController;
use App\Http\Controllers\Masters\SolicitorController;
use App\Http\Controllers\Masters\LawFirmController;
use App\Http\Controllers\Select\SelectController;
use App\Http\Controllers\Masters\RealEstateAgentController;
use App\Http\Controllers\Matters\SellerController;
use App\Http\Controllers\Matters\PurchaserController;
use App\Http\Controllers\Matters\FileController;
use App\Http\Controllers\Matters\PropertyController;
use App\Http\Controllers\Masters\PrecedentController;
use App\Http\Controllers\Resource\AttachmentController;
use App\Http\Controllers\Masters\ContactController;
use App\Http\Controllers\Matters\MortgageController;
use App\Http\Controllers\Matters\CondoCorporationController;
use App\Http\Controllers\Matters\CommissionController;
use App\Http\Controllers\Matters\RequisitionResponseController;
use App\Http\Controllers\Matters\StatementAdjustmentController;
use App\Http\Controllers\Masters\TransactionTypeController;
use App\Http\Controllers\Matters\AccountStatementController;
use App\Http\Controllers\Matters\TrustLedgerController;
use App\Http\Controllers\Matters\RedirectionFundController;
use App\Http\Controllers\Matters\FileDocumentController;
use App\Http\Controllers\Matters\ExecutionDocumentController;
use App\Http\Controllers\Payment\CardDetailController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Reports\FileFeeReportController;
use Illuminate\Support\Facades\Auth;

// Route::get('/',function(){
//     return view('app');
// });

Route::get('/', ['middleware' => ['auth'], function () {
    view()->share('signedIn', auth()->check());
    view()->share('user', auth()->user());
    // return view('dashboard.dashboard');
    return view('matters.file_openings');
}]);

Auth::routes();



//Users

Route::get('/users/{user}/changepassword', [UserController::class, 'chngPassword']);
Route::patch('/users/{user}/updatepassword', [UserController::class, 'updatePassword']);
Route::get('/reset-password', [UserController::class, 'getResetPassword']);
Route::get('/users/list', [UserController::class, 'getUsersList']);
Route::post('preferences', [UserController::class, 'savePreferences']);


// roles

Route::get('roles/{role_id}/permissions', [RoleController::class, 'showPermissions']);
Route::post('roles/{role_id}/permissions', [RoleController::class, 'savePermissions']);


Route::post('city/filtered', [SelectController::class, 'getCities']);
Route::post('real-estate-agents/filtered', [SelectController::class, 'getRealEstateAgent']);
Route::post('employees/filtered', [SelectController::class, 'getEmployee']);
Route::post('contacts/filtered', [SelectController::class, 'getContact']);
Route::post('brokerages/filtered', [SelectController::class, 'getBrokerage']);
Route::post('credit-types/filtered', [SelectController::class, 'getCreditType']);
Route::post('law-firms/filtered', [SelectController::class, 'getLawFirms']);
Route::post('solicitors/filtered', [SelectController::class, 'getSolicitors']);
Route::post('canadian-states/filtered', [SelectController::class, 'getCanadianStates']);
Route::post('precedents/filtered', [SelectController::class, 'getPrecedents']);
Route::post('lro/filtered', [SelectController::class, 'getLROs']);
Route::post('document-file-types/filtered', [SelectController::class, 'getDocumentFileTypes']);

Route::post('remote-login', [RemoteLoginController::class, 'login']);

Route::post('attachments/list', [AttachmentController::class, 'showAttachmentList']);
Route::get('attachments-thumbnail/{resource_id}', [AttachmentController::class, 'attachmentThumbnail']);
Route::get('attachments/name/{resource_id}', [AttachmentController::class, 'getFileName']);
Route::get('attachments/download/{resource_id}', [AttachmentController::class, 'downloadAttachment']);

Route::post('commission-file-uploads', [CommissionController::class, 'saveFiles']);
Route::post('execution-file-uploads', [ExecutionDocumentController::class, 'saveFiles']);
Route::post('payments/set-record', [PaymentController::class, 'savePaymentTransaction']);

Route::get('file-rate', [FileController::class, 'fileRate']);


Route::resources([
    'users' => UserController::class,
    'roles' => RoleController::class,
    'file-openings' => FileOpeningController::class,
    'companies' => CompanyController::class,
    'employees' => EmployeeController::class,
    'real-estate-agents' => RealEstateAgentController::class,
    'cities' => CityController::class,
    'city-departments' => CityDepartmentController::class,
    'sellers' => SellerController::class,
    'file-page' => FileController::class,
    'purchasers' => PurchaserController::class,
    'properties' => PropertyController::class,
    'attachments' => AttachmentController::class,
    'contacts' => ContactController::class,
    'mortgages' => MortgageController::class,
    'condo-corporations' => CondoCorporationController::class,
    'commissions' => CommissionController::class,
    'brokerages' => BrokerageController::class,
    'transaction-types' => TransactionTypeController::class,
    'statement-adjustments' => StatementAdjustmentController::class,
    'solicitors' => SolicitorController::class,
    'law-firms' => LawFirmController::class,
    'requisition-responses' => RequisitionResponseController::class,
    'precedents' => PrecedentController::class,
    'account-statements' => AccountStatementController::class,
    'trust-ledgers' => TrustLedgerController::class,
    'redirection-funds' => RedirectionFundController::class,
    'file-documents' => FileDocumentController::class,
    'execution-documents' => ExecutionDocumentController::class,
    'download-documents' => DownloadDocumentController::class,
    'payments' => PaymentController::class,
    'file-fee-report' => FileFeeReportController::class,
    'card-details' => CardDetailController::class

]);
