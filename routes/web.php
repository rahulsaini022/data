<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\AdvertiserService;
use App\County;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;
// routes to clear cache
Route::get('/cache-clear', function () {
	Artisan::call('config:cache');
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	die('cache cleared successfully');
});
Route::get('/backup', function () {
	if(Artisan::call('backup:run'))
	{
 return redirect()->route('admin.get_project_backups');}
 else{
	die('not create');
 }
});
Route::get('/plan', function () {
	$stripe = new \Stripe\StripeClient(
		'sk_test_51Hu30EBtWlZKaqgXooijepMd3AsP30SWtDuuXHlwCUt4gPRtAhAu1fume290n1lTnlXWyrPc1aahJURcPix443LT00LeEL7UIE'
	);
	dd($stripe->plans->all(['limit' => 15,'product'=> 'prod_LeiqeUHfcadvdN']));
});


Auth::routes();
Route::get('/advertise/subs/{id}',  function () {
	$county=County::where('state_id',35)->get();
	$category_data=AdvertiserService::where('parent_id',0)->get();
	return view('advertise.create_subs',compact('county' ,'category_data'));
})->name('create_subs');
// following routes are for ajax requests
Route::get('/ajax-states', 'AjaxController@get_states')->name('ajax_get_states');
Route::get('/get-prospect/{case_id}', 'CaseController@getProspect')->name('get_prospect');
Route::post('/ajax-state-counties', 'AjaxController@get_counties_by_state')->name('ajax_get_counties_by_state');
Route::post('/ajax-cause-of-action', 'AjaxController@get_causes_of_action')->name('ajax_get_cause_of_action');
Route::post('/ajax-attorney-reg-num', 'AjaxController@get_attorney_by_reg_num')->name('ajax_get_attorney_by_reg_num');
Route::post('/ajax-get-attorney-by-checkbox', 'AjaxController@get_attorney_by_checkbox')->name('ajax_get_attorney_by_checkbox');
Route::post('/ajax-zip-city-state-county', 'AjaxController@getCityStateCountyByZipCode')->name('ajax_get_city_state_county_by_zip');
Route::post('/ajax-get-response-date', 'AjaxController@getResponseDateByFileDate')->name('ajax_get_response_deadline_by_file_date');
Route::post('/ajax-get-pleading-deadlines', 'AjaxController@getPleadingDeadlines')->name('ajax_get_pleading_deadlines');
Route::post('/ajax-get-months-difference', 'AjaxController@getMonthDifference')->name('ajax_get_months_diff');
Route::post('/ajax-get-period-difference', 'AjaxController@getPeriodDifference')->name('ajax_get_period_diff');
Route::post('/ajax-get-prospect-letter-dropdown', 'AjaxController@getProspectLetterDropdown')->name('ajax_get_prospect_letter_dropdown');
Route::post('/ajax-get-prospect-intake-dropdown', 'AjaxController@getProspectIntakeDropdown')->name('ajax_get_prospect_intake_dropdown');
Route::get('/ajax-get-db-active-states', 'AjaxController@getDBActiveStates')->name('ajax_get_db_active_states');
Route::get('/ajax-get-case-package-details/{package_id}', 'AjaxController@getCasePackageDetailsById')->name('ajax_get_case_package_details');
Route::post('/ajax-get-pleading-popup-select-options', 'AjaxController@getPopupSelectOptions')->name('ajax_get_pleading_popup_select_options');
Route::get('/ajax-get-search-data', 'AjaxController@AjaxGetSearchData')->name('ajax_get_search_data');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/advetiserlogin', 'AdvertiseController@advetiserlogin')->name('advetiserlogin');
Route::get('/advertise', 'AdvertiseController@index')->name('advertise');
Route::get('/advertisenow', 'AdvertiseController@advertisenow')->name('advertisenow');
Route::get('/advertisenow/{id}', 'AdvertiseController@courtreporter')->name('advertisenow.courtreporter');
Route::post('/courtreportersubmit', 'AdvertiseController@courtreportersubmit')->name('courtreportersubmit');
//Route::get('/demoemail','AdvertiseController@demoemail')->name('demoemail');
Route::get('/demotiny', 'HomeController@demotiny')->name('demotiny');
Route::get('/home', 'HomeController@index')->name('home_page');
Route::get('/what-we-offer', 'HomeController@whatWeOffer')->name('what_we_offer');
Route::get('/pricing', 'HomeController@pricing')->name('pricing');
Route::get('/email-us', 'HomeController@showEmailUsForm')->name('email_us');
Route::post('/send-email-to-admin', 'HomeController@getEmailData')->name('send_email_to_admin')->middleware(ProtectAgainstSpam::class);
Route::get('/admin', 'AdminController@admin')->name('admin')->middleware('role:super admin|admin');
// routes for demos
Route::get('/demo', 'HomeController@showDemoPage')->name('demo');
Route::post('/demo', 'HomeController@storeDemo')->name('store_demo')->middleware(ProtectAgainstSpam::class);
// route for how fdd save you money
Route::get('/how-fdd-can-save-you-money', 'HomeController@howFddCanSaveYouMoney')->name('how_fdd_can_save_you_money');
Route::get('/refer-an-attorney-who-uses-fdd', 'HomeController@referAnAttorneyWhoUsesFdd')->name('refer_an_attorney_who_uses_fdd');
Route::post('/store-refer-an-attorney', 'HomeController@storeReferAnAttorney')->name('store_refer_an_attorney')->middleware(ProtectAgainstSpam::class);
Route::get('/inform-my-attorney-to-use-fdd', 'HomeController@informMyAttorneyToUseFdd')->name('inform_my_attorney_to_use_fdd');
Route::post('/store-inform-my-attorney', 'HomeController@storeInformMyAttorney')->name('store_inform_my_attorney')->middleware(ProtectAgainstSpam::class);
// route for handeling stripe webhooks
Route::post(
	'stripe/webhook',
	'\App\Http\Controllers\WebhookController@handleWebhook'
);
// route for dynamic pages
Route::get('/page/{page_slug}', 'HomeController@showPage')->name('dynamic_page');
/**route for change password */
Route::get('change-password', 'HomeController@change_password')->name('change.password')->middleware('auth');
Route::post('update-password', 'HomeController@update_password')->name('update.password')->middleware('auth');;
// following routes are for Advertiser
Route::group(['middleware' => ['auth', 'role:Advertise']], function () {
	
	Route::get('adviserdashboard', 'AdvertiseDashboardController@adviserdashboard')->name('adviserdashboard');
	Route::get('/advertiser/{id}/edit', 'AdvertiseDashboardController@editadvertiser')->name('advertise.edit');
	Route::post('/courtreporterupdate', 'AdvertiseDashboardController@courtreporterupdate')->name('advertise.update');
	Route::get('/new-listing', 'AdvertiseDashboardController@New_listing')->name('advertise.new_listing');
	Route::get('/edit-listing/{id}', 'AdvertiseDashboardController@EditListing')->name('listing.edit');
	Route::post('/get-image', 'AdvertiseDashboardController@getImage')->name('get.images');
	Route::delete('/images/{id}', 'AdvertiseDashboardController@destroyImage')->name('delete.image');

	Route::post('/update', 'AdvertiseDashboardController@UpdateListing')->name('listing.update');
	Route::get('create-new-listing', 'AdvertiseDashboardController@CreateNewListing')->name('advertise.createnew');
	Route::post('get-category-by-county', 'AdvertiseDashboardController@GetCategory')->name('advertise.getCategory');
	Route::get('create-perimum-bid/{id}', 'AdvertiseDashboardController@perimum_bid')->name('advertiser.createbid');
	Route::post('bid-checkout', 'AdvertiseDashboardController@checkout')->name('advertise.checkout');
	Route::post('bid-payment', 'AdvertiseDashboardController@payment')->name('advertise.payment');
	Route::post('ajax-get-advertiser-service-div', 'AdvertiseDashboardController@getadvertiserservicediv')->name('ajax_get_advertiser_service_div');
	Route::post('advertiser-subscribe', 'AdvertiseDashboardController@advertisersubscribe')->name('advertise.afterloginsubscribe');
	Route::post('advertiser-listfilter', 'AdvertiseDashboardController@Filtering')->name('advertiser.listfilter');
	Route::get('listingstatus/{id}/{status}', 'AdvertiseDashboardController@activedeactivelist')->name('advertise.status');
	Route::get('advertise-subscriptions', 'AdvertiseDashboardController@subscription_listing')->name('advertise.subscriptions');
	Route::post('advertise-cancelsubscriptions', 'AdvertiseDashboardController@cancel_subscription')->name('advertiser.cancel_subscription');
	Route::post('advertise-resumesubscriptions', 'AdvertiseDashboardController@resume_subscription')->name('advertiser.resume_subscription');

});
// following routes are for super admin
Route::group(['middleware' => ['auth', 'role:super admin']], function () {
	
	/**Admin Advertiser service management strat*/
	Route::resource('advertiser-services', 'AdminAdvertiserController');
	Route::get('service/{service_id}', 'AdminAdvertiserController@childServices')->name('child.services');
	/** Advertiser listing route */
	Route::get('advertisers', 'AdminAdvertiserController@advertiserList')->name('advertiser.all');
	Route::post('/status', 'AdminAdvertiserController@listingStatus')->name('enable.disable');
	
	Route::get('advertise/{id}', 'AdminAdvertiserController@AdvertiserDetail')->name('advertiser.detail');
	Route::get('subscription-listing', 'AdminAdvertiserController@subscription_listing')->name('advertiser.subscription_listing');
	Route::get('subscription-listing/{id}', 'AdminAdvertiserController@subscriptiondetail')->name('advertiser.subscriptiondetail');
	Route::get('advertiser-bids', 'AdminAdvertiserController@showBids')->name('advertiser.bids');
	Route::get('advertiser-bids/{id}', 'AdminAdvertiserController@bidDetail')->name('bids.detail');
	Route::resource('roles', 'RoleController');
	Route::resource('users', 'UserController');
	Route::get('clients','UserController@clients')->name('all.clients');
	Route::resource('prices', 'PriceController');
	Route::resource('testimonials', 'TestimonialController');
	Route::resource('pages', 'PageController');
	Route::resource('settings', 'SettingController');
	Route::resource('casepaymentpackages', 'CasePaymentPackageController');
	Route::resource('pdfcredits', 'PdfCreditController');
	Route::resource('minmumwage', 'MinWagetableController');
	Route::resource('documenttable', 'DocumentTableController');
	Route::resource('judges', 'JudgeController');
	Route::resource('customeruploads', 'CustomerUploadsController');
	Route::resource('magistrates', 'MagistrateController');
	Route::resource('clerks', 'ClerkController');
	Route::resource('counties', 'CountyController');
	Route::resource('courts', 'CourtController');
	Route::resource('divisions', 'DivisionController');
	Route::resource('attorneytableactive', 'AttorneyTableActiveController');
	Route::get('getTable', 'AttorneyTableActiveController@getTable');
	Route::any('attorneytableactive-filtering', 'AttorneyTableActiveController@Filtering');
	Route::resource('attorneytableactivebeforeedit', 'AttorneyTableActiveBeforeEditController');
	Route::post('attorneytableactivebeforeedit/restore', 'AttorneyTableActiveBeforeEditController@restoreRecord')->name('attorneytableactivebeforeedit.restore');
	Route::post('attorneytableactivebeforeedit/get-records-by-reg-number', 'AttorneyTableActiveBeforeEditController@getRecordsByRegNum')->name('attorneytableactivebeforeedit.get_records_by_reg_number');
	Route::resource('stripeplans', 'StripePlansController');
	Route::get('updatefilestatus/{id}', 'CustomerUploadsController@updatefilestatus')->name('updatefilestatus');
	Route::post('/customer-download-file', 'CustomerUploadsController@download')->name('customer.download.file');
	Route::get('/users/{id}/deactivate', 'UserController@deactivate')->name('users.deactivate');
	Route::get('/users/{id}/activate', 'UserController@activate')->name('users.activate');
	Route::get('/casepaymentpackages/{id}/deactivate', 'CasePaymentPackageController@deactivate')->name('casepaymentpackages.deactivate');
	Route::get('/casepaymentpackages/{id}/activate', 'CasePaymentPackageController@activate')->name('casepaymentpackages.activate');
	Route::resource('permissions', 'PermissionController');
	Route::resource('demos', 'DemoController');
	Route::resource('states', 'StateController');
	Route::get('/states/{id}/deactivate', 'StateController@deactivate')->name('states.deactivate');
	Route::get('/states/{id}/activate', 'StateController@activate')->name('states.activate');
	Route::post('/get-stats', 'AdminController@getStats')->name('get.stats');
	// for users charts
	Route::get('/show-user-reports', 'AdminController@get_user_reports')->name('get_user_reports');
	Route::get('/get-users-by-day-chart-data', 'AdminController@get_users_by_day_chart_data')->name('get_users_by_day_chart_data');
	Route::get('/get-users-by-week-chart-data', 'AdminController@get_users_by_week_chart_data')->name('get_users_by_week_chart_data');
	// for advertisers charts
	Route::get('/show-advertiser-reports', 'AdminAdvertiserController@get_advertiser_reports')->name('get_advertiser_reports');
	Route::get('/get-advertisers-by-day-chart-data', 'AdminAdvertiserController@get_advertisers_by_day_chart_data')->name('get_advertisers_by_day_chart_data');
	Route::get('/get-advertisers-by-week-chart-data', 'AdminAdvertiserController@get_advertisers_by_week_chart_data')->name('get_advertisers_by_week_chart_data');
	// for attorneys charts
	Route::get('/show-attorney-reports', 'AdminController@get_attorney_reports')->name('get_attorney_reports');
	Route::get('/get-attorneys-by-day-chart-data', 'AdminController@get_attorney_users_by_day_chart_data')->name('get_attorney_users_by_day_chart_data');
	Route::get('/get-attorneys-by-week-chart-data', 'AdminController@get_attorney_users_by_week_chart_data')->name('get_attorney_users_by_week_chart_data');
	// for clients charts
	Route::get('/show-client-reports', 'AdminController@get_client_reports')->name('get_client_reports');
	Route::get('/get-clients-by-day-chart-data', 'AdminController@get_client_users_by_day_chart_data')->name('get_client_users_by_day_chart_data');
	Route::get('/get-clients-by-week-chart-data', 'AdminController@get_client_users_by_week_chart_data')->name('get_client_users_by_week_chart_data');
	// for cases charts
	Route::get('/show-case-reports', 'AdminController@get_case_reports')->name('get_case_reports');
	Route::get('/get-cases-by-day-chart-data', 'AdminController@get_cases_by_day_chart_data')->name('get_cases_by_day_chart_data');
	Route::get('/get-cases-by-week-chart-data', 'AdminController@get_cases_by_week_chart_data')->name('get_cases_by_week_chart_data');
	// for user logins charts
	Route::get('/show-user-login-reports', 'AdminController@get_user_login_reports')->name('get_user_login_reports');
	Route::get('/get-user-logins-by-day-chart-data', 'AdminController@get_user_logins_by_day_chart_data')->name('get_user_logins_by_day_chart_data');
	Route::get('/get-user-logins-week-chart-data', 'AdminController@get_user_logins_by_week_chart_data')->name('get_user_logins_by_week_chart_data');
	// for failed user logins charts
	Route::get('/show-failed-user-login-reports', 'AdminController@get_failed_user_login_reports')->name('get_failed_user_login_reports');
	Route::get('/get-failed-user-logins-by-day-chart-data', 'AdminController@get_failed_user_logins_by_day_chart_data')->name('get_failed_user_logins_by_day_chart_data');
	Route::get('/get-failed-user-logins-week-chart-data', 'AdminController@get_failed_user_logins_by_week_chart_data')->name('get_failed_user_logins_by_week_chart_data');
	// payments view related ajax routes
	Route::get('/show-all-payments', 'AdminController@showAllPayments')->name('show_all_payments');
	Route::get('/current-month-all-payments', 'AdminController@getCurrentMonthAllPayments')->name('get_current_month_all_payments');
	Route::get('/show-last-{months}-months-all-payments', 'AdminController@getMonthBasedAllPayments')->name('get_month_based_all_payments');
	Route::post('/show-all-payments-between-two-dates', 'AdminController@getDateBasedAllPayments')->name('get_date_based_all_payments');
	Route::get('/show-case-payments', 'AdminController@showCasePayments')->name('show_case_payments');
	Route::get('/current-month-case-payments', 'AdminController@getCurrentMonthCasePayments')->name('get_current_month_case_payments');
	Route::get('/show-last-{months}-months-case-payments', 'AdminController@getMonthBasedCasePayments')->name('get_month_based_case_payments');
	Route::post('/show-case-payments-between-two-dates', 'AdminController@getDateBasedCasePayments')->name('get_date_based_case_payments');
	Route::get('/show-all-stripe-payments', 'AdminController@showAllStripePayments')->name('show_all_stripe_payments');
	Route::get('/show-all-stripe-refunds', 'AdminController@showAllStripeRefunds')->name('show_all_stripe_refunds');
	// Route::get('/show-state-seat-license-payments', 'AdminController@showStateSeatLicensePayments')->name('show_state_seat_license_payments');
	// Route::get('/current-month-state-seat-license-payments', 'AdminController@getCurrentMonthStateSeatLicensePayments')->name('get_current_month_state_seat_license_payments');
	// Route::get('/show-last-{months}-months-state-seat-license-payments', 'AdminController@getMonthBasedStateSeatLicensePayments')->name('get_month_based_state_seat_license_payments');
	// Route::post('/show-state-seat-license-payments-between-two-dates', 'AdminController@getDateBasedStateSeatLicensePayments')->name('get_date_based_state_seat_license_payments');
	Route::get('/show-user-credits-payments', 'AdminController@showUserCreditsPayments')->name('show_user_credits_payments');
	Route::get('/current-month-user-credits-payments', 'AdminController@getCurrentMonthUserCreditsPayments')->name('get_current_month_user_credits_payments');
	Route::get('/show-last-{months}-months-user-credits-payments', 'AdminController@getMonthBasedUserCreditsPayments')->name('get_month_based_user_credits_payments');
	Route::post('/show-user-credits-payments-between-two-dates', 'AdminController@getDateBasedUserCreditsPayments')->name('get_date_based_user_credits_payments');
	// routes for downloading project backups
	Route::get('/project-backups', 'AdminController@getProjectBackupFiles')->name('admin.get_project_backups');
	Route::post('/download-project-backup-file', 'AdminController@downloadProjectBackupFile')->name('admin.download_project_backup');
	Route::get('/users-subscriptions', 'AdminController@showUserSubscriptions')->name('admin.show_users_subscriptions');
	// to show cases list and activate/deactivate case
	Route::get('/all-cases', 'CaseController@allCasesList')->name('cases.all');
	Route::post('/cases/{id}/change-payment-status', 'CaseController@changeCasePaymentStatus')->name('cases.change_case_payment_status');
});

// following routes are for attornies
Route::get('/attorneys', 'AttorneyController@index')->name('attorneys.index')->middleware('role:admin|super admin');
Route::post('/attorneys', 'AttorneyController@store')->name('attorneys.store')->middleware(ProtectAgainstSpam::class);
Route::get('/attorneys/create', 'AttorneyController@create')->name('attorneys.create');
Route::get('/attorneys/{attorney}', 'AttorneyController@show')->name('attorneys.show')->middleware('role:attorney|admin|super admin');
Route::get('/attorneys/{attorney}/edit', 'AttorneyController@edit')->name('attorneys.edit')->middleware('role:attorney|super admin');
Route::put('/attorneys/{attorney}', 'AttorneyController@update')->name('attorneys.update')->middleware('role:attorney|super admin');
Route::delete('/attorneys/{attorney}', 'AttorneyController@destroy')->name('attorneys.destroy')->middleware('role:admin|super admin');
Route::get('/attorneys/{id}/subscription', 'AttorneyController@subscription')->name('attorneys.subscription');
Route::post('/attorneys-subscribe', 'AttorneyController@subscribe')->name('attorneys.subscribe');
Route::post('/advertise-subscribe', 'AdvertiseController@subscribe')->name('advertise.subscribe');
Route::get('/attorneys/{id}/thanks', 'AttorneyController@thanks')->name('attorneys.thanks');
Route::get('/advertise/{id}/thanks', 'AdvertiseController@thanks')->name('advertise.thanks');
Route::get('/advertise/subscription/{id}/{category_id}', 'AdvertiseController@subscription')->name('advertise.subscription');
Route::post('/cases/{id}/deactivate', 'CaseController@deactivateCase')->name('cases.deactivate');
Route::post('/cases/{id}/activate', 'CaseController@activateCase')->name('cases.activate');
Route::group(['middleware' => ['auth', 'role:attorney']], function () {
	Route::get('/attorneys-downloads', 'AttorneyController@getDownloads')->name('attorney.downloads');
	Route::post('/attorneys-download-file', 'AttorneyController@download')->name('attorney.download.file');
	Route::post('/attorneys/delete-download-file', 'AttorneyController@deleteDownloadFile')->name('attorney.delete_download_file');
	Route::get('/state-seat-license', 'AttorneyController@getSeatLicensePaymentForm')->name('attorneys.state_seat_license');
	Route::post('/purchase-state-seat-license', 'AttorneyController@purchaseSeatLicensePaymentForm')->name('attorney.purchase_state_seat_license');
	Route::post('/update-state-and-state-number', 'AttorneyController@updateStateAndStateNumber')->name('attorney.update_state_and_state_number');
	Route::post('/update-state-and-state-number', 'AttorneyController@updateStateAndStateNumber')->name('attorney.update_state_and_state_number');
	Route::post('/cancel-state-seat-license-subscription', 'AttorneyController@cancelStateSeatLicenseSubscription')->name('attorney.cancel_state_seat_license_subscription');
	Route::post('/resume-cancelled-state-seat-license-subscription', 'AttorneyController@resumeCancelledStateSeatLicenseSubscription')->name('attorney.resume_cancelled_state_seat_license_subscription');
	Route::get('/caseResources', 'AttorneyController@caseResources')->name('resources');
	// routes for prospects
	Route::resource('prospects', 'ProspectsController');
	Route::post('/draft-prospect', 'ProspectsController@draftProspect')->name('draft_prospect');
	Route::get('/create-case/{prospect_id}', 'ProspectsController@create_case')->name('prospect_create_case');
	// following routes are for fdd tools page
	Route::get('/fdd-tools', 'FddToolsController@index')->name('fdd_tools');
	Route::post('/squeez-pdf', 'FddToolsController@squeezPdf')->name('squeez_pdf');
	Route::get('/attorneys-pdf-tools-downloads', 'FddToolsController@getPdfToolsDownloads')->name('fdd_tools.pdf_tools_downloads');
	// Route::post('/fdd-pdf-ocr-ripper', 'FddToolsController@pdfOcrRipper')->name('pdf_ocr_ripper');
	Route::post('/fdd-pdf-scrubber', 'FddToolsController@pdfScrubber')->name('pdf_scrubber');
	Route::post('/fdd-pdf-fixer', 'FddToolsController@pdfFixer')->name('pdf_fixer');
	Route::get('/fdd-quick-child-support-worksheets/{show}', 'FddToolsController@fddQuickChildSupportWorksheetsTool')->name('fdd_tools.fdd_quick_child_support_worksheets');
	Route::get('/fdd-annual-income-calculator', 'FddToolsController@fddAnnualIncomeCalculatorTool')->name('fdd_tools.fdd_annual_income_calculator');
	Route::get('/fdd-loan-finance-calculator', 'FddToolsController@fddLoanFinanceCalculatorTool')->name('fdd_tools.fdd_loan_finance_calculator');
	Route::get('/fdd-annuity-value-calculator', 'FddToolsController@fddAnnuityValueCalculatorTool')->name('fdd_tools.fdd_annuity_value_calculator');
	Route::get('/fdd-pension-value-calculator', 'FddToolsController@fddPensionValueCalculatorTool')->name('fdd_tools.fdd_pension_value_calculator');
	Route::get('/fdd-pdf-tools', 'FddToolsController@getFddPDFToolList')->name('fdd_tools.pdf_tools');
	Route::post('/fdd-tools-buy-pdf-credits', 'FddToolsController@buyPDFCredits')->name('fdd_tools.buy_pdf_credits');
	Route::get('/fdd-quick-affidavit-of-basic-information-income-and-expenses/{show}', 'FddToolsController@fddQuickAffidavitOfBasicInformation')->name('fdd_tools.fdd_quick_affidavit_of_basic_information_income_and_expenses');
	Route::post('/fdd-quick-affidavit-of-basic-information-income-and-expenses', 'AffidavitController@showAffidavitOfBasicInformationSheetForm')->name('show_affidavit_of_basic_information_sheet_form');
	Route::get('/affidavit-sheet/{id}/deactivate', 'AffidavitController@deactivate')->name('affidavit_sheet.deactivate');
	Route::get('/affidavit-sheet/{id}/activate', 'AffidavitController@activate')->name('affidavit_sheet.activate');
	Route::get('/open-fdd-quick-cs-sheet-using-affidavit-sheet-data/{aff_att_sub_id}/', 'AffidavitController@openFddQuickCSSheet')->name('affidavit_sheet.open_cs_sheet');
	Route::get('/fdd-quick-coverture-calculator', 'FddToolsController@fddQuickCovertureCalculatorTool')->name('fdd_tools.fdd_quick_coverture_calculator');
	// Orchard Searching ....
	Route::get('orchard-search', 'HomeController@demorecoll')->name('orchard_search');
	Route::post('orchard-search', 'HomeController@demorecoll')->name('orchard_search');
	Route::get('uploadnewdocument', 'HomeController@UploadNewDocument')->name('uploadnewdocument');
	Route::post('uploaddocument', 'HomeController@UploadDocument')->name('uploaddocument');
	// following routs are for computation sheets and case registration steps
	Route::post('/computations/sole-shared', 'ComputationController@soleSharedSheet')->name('computations.sole-shared');
	Route::post('/computations/split', 'ComputationController@splitSheet')->name('computations.split');
	Route::get('/computations-sheet/{id}/deactivate', 'ComputationController@deactivate')->name('computations_sheet.deactivate');
	Route::get('/computations-sheet/{id}/activate', 'ComputationController@activate')->name('computations_sheet.activate');
	Route::post('/computed-computations/sole-shared', 'ComputedComputationController@soleSharedSheet')->name('computed_computations.sole-shared');
	Route::post('/computed-computations/split', 'ComputedComputationController@splitSheet')->name('computed_computations.split');
	Route::post('/ajax-update-obligee-obligor-dr-children', 'AjaxController@updateObligeeObligorDrChildren')->name('ajax_update_obligee_obligor_dr_children');
	Route::post('/update-custody-arrangement-dr-children', 'AjaxController@updateCustodyArrangementDrChildren')->name('ajax_update_custody_arrangement_dr_children');
	Route::post('/update-children-will-reside-with-dr-children', 'AjaxController@updateChildrenWillResideWithDrChildren')->name('ajax_update_children_will_reside_with_dr_children');
	// following routes are for case registration
	Route::resource('cases', 'CaseController');
	Route::get('/ajax-languages', 'AjaxController@getLanguages')->name('ajax_get_languages');
	Route::get('/ajax-active-states', 'AjaxController@getActiveStates')->name('ajax_get_active_states');
	Route::post('/ajax-court-by-county-state', 'AjaxController@getCourtByCountyState')->name('ajax_get_court_by_county_state');
	Route::post('/ajax-division-by-court', 'AjaxController@getDivisionByCourt')->name('ajax_get_division_by_court');
	Route::post('/ajax-judge-magistrate-casetype-by-court-div', 'AjaxController@getJudgeMagistrateCaseTypeByCourtDiv')->name('ajax_get_judge_magistrate_casetype_by_court_div');
	Route::post('/ajax-clerk-data-by-court-div', 'AjaxController@getClerkdatabyclerkid')->name('ajax_clerk_data_by_court_div');
	Route::get('/cases/{id}/payment', 'CaseController@getPaymentForm')->name('cases.payment');
	Route::post('/cases-payment', 'CaseController@casePayment')->name('cases.makepayment');
	Route::post('/ajax-affidavit-court-by-county-state', 'AjaxController@getAffidavitCourtByCountyState')->name('ajax_get_affidavit_court_by_county_state');
	Route::post('/ajax-affidavit-division-by-court', 'AjaxController@getAffidavitDivisionByCourt')->name('ajax_get_affidavit_division_by_court');
	// following routes are for upgrading case package
	Route::get('/cases/{id}/upgrade-package', 'CaseController@getUpgradePackagePaymentForm')->name('cases.get_upgrade_package_payment_form');
	Route::post('/cases-upgrade-package', 'CaseController@upgradeCasePackagePayment')->name('cases.make_upgrade_package_payment');
	// folowing routes are for new case registration forms
	Route::get('/cases/{id}/edit-case-data', 'CaseController@edit_case_data')->name('cases.edit_case_data');
	// Route::get('/cases/{id}/family-law-interview-data', 'CaseController@familyLawInterviewData')->name('cases.family_law_interview_tabs');
	Route::post('/cases/store-case', 'CaseController@store_case')->name('cases.store_case');
	Route::put('/cases/{case_id}/update-case', 'CaseController@update_case')->name('cases.update_case');
	Route::get('/cases/{id}/show-party-reg-form', 'CaseController@show_party_reg_form')->name('cases.show_party_reg_form');
	Route::post('/cases/store-party', 'CaseController@store_party')->name('cases.store_party');
	Route::get('/cases/{user_id}/{case_id}/{type}/{number}/edit-party-info-form', 'CaseController@edit_party_info_form')->name('cases.edit_party');
	Route::get('/cases/{user_id}/{case_id}/{type}/{party_group}/delete-party', 'CaseController@delete_party')->name('cases.delete_party');
	Route::put('/cases/{user_id}/{case_id}/update-party', 'CaseController@update_party')->name('cases.update_party');
	Route::get('/cases/{party_id}/{case_id}/{number}/show-attorney-reg-form', 'CaseController@show_attorney_reg_form')->name('cases.show_attorney_reg_form');
	Route::post('/cases/store-attorney', 'CaseController@store_attorney')->name('cases.store_attorney');
	Route::get('/cases/{party_id}/{case_id}/{attorney_id}/{party_number}/delete-party-attorney', 'CaseController@delete_party_attorney')->name('cases.delete_party_attorney');
	Route::get('/cases/{party_id}/{case_id}/{attorney_id}/{party_number}/update-party-attorney', 'CaseController@getUpdatePartyAttorneyForm')->name('cases.show_update_party_attorney_form');
	Route::post('/cases/update-attorney', 'CaseController@updateAttorney')->name('cases.update_attorney');
	Route::post('/cases/computations-sheet', 'CaseController@showComputationSheet')->name('cases.computations_sheet');
	Route::post('/cases/prefilled-computations-sheet', 'CaseController@showPrefilledFromDatabaseComputationSheet')->name('cases.prefill_from_db_computations_sheet');
	Route::post('/cases/party/trial-attorney', 'CaseController@updatePartyTrialAttorney')->name('cases.party.trial_attorney');
	Route::post('/cases/party/activate-deactivate', 'CaseController@activateDeactivateParty')->name('cases.party.activate_deactivate');
	Route::delete('/cases/{id}', 'CaseController@destroy')->name('cases.destroy');
	Route::post('/cases/{id}/show-hide', 'CaseController@showHideCase')->name('cases.show_hide');
	// following routes are for Case Motions
	Route::get('/cases/{case_id}/motions', 'MotionController@getCaseMotions')->name('cases.motions');
	Route::get('/cases/{case_id}/motions/create', 'MotionController@createCaseMotions')->name('cases.motions.create');
	Route::post('/cases/motions/store', 'MotionController@storeCaseMotions')->name('cases.motions.store');
	Route::get('/cases/{case_id}/motions/{motion_id}/edit', 'MotionController@editCaseMotions')->name('cases.motions.edit');
	Route::put('/cases/motions/update', 'MotionController@updateCaseMotions')->name('cases.motions.update');
	Route::post('/cases/motions/subordinate/create', 'MotionController@createSubordinateCaseMotions')->name('cases.motions.subordinate.create');
	Route::post('/cases/motions/subordinate/store', 'MotionController@storeSubordinateCaseMotions')->name('cases.motions.subordinate.store');
	Route::get('/cases/{case_id}/motions/{motion_id}/subordinate/edit', 'MotionController@editSubordinateCaseMotions')->name('cases.motions.subordinate.edit');
	Route::put('/cases/motions/subordinate/update', 'MotionController@updateSubordinateCaseMotions')->name('cases.motions.subordinate.update');
	Route::post('/cases/motions/changestatus/', 'MotionController@changeMotionStatus')->name('cases.motions.changestatus');
	Route::post('/cases/motions/extenddeadline/', 'MotionController@extendDeadline')->name('cases.motions.extenddeadline');
	Route::post('/cases/motions/agreedentry/', 'MotionController@agreedEntry')->name('cases.motions.agreedentry');
	Route::post('/cases/motions/staymotion/', 'MotionController@stayMotion')->name('cases.motions.staymotion');
	// routes for motion aux
	Route::get('/cases/{case_id}/motionaux/{motion_id}/create', 'MotionAuxController@create')->name('cases.motionaux.create');
	Route::post('/cases/motionaux/store', 'MotionAuxController@store')->name('cases.motionaux.store');
	// following routes are for Case Pleadings
	Route::get('/cases/{case_id}/pleadings', 'PleadingController@getCasePleadings')->name('cases.pleadings');
	Route::get('/cases/{case_id}/pleadings/complete-family-law-interview', 'PleadingController@redirectToCompleteInItialInterview')->name('cases.pleadings.completefamlawinterview');
	Route::get('/cases/{case_id}/pleadings/create', 'PleadingController@createCasePleadings')->name('cases.pleadings.create');
	Route::post('/cases/pleadings/store', 'PleadingController@storeCasePleadings')->name('cases.pleadings.store');
	Route::get('/cases/{case_id}/pleadings/{pleading_id}/edit', 'PleadingController@editCasePleadings')->name('cases.pleadings.edit');
	Route::put('/cases/pleadings/update', 'PleadingController@updateCasePleadings')->name('cases.pleadings.update');
	Route::get('/cases/{case_id}/{action}/{pleading_id}/pleadings/has-new-third-party', 'PleadingController@pleadingHasNewThirdparties')->name('cases.pleadings.pleadinghasnewthirdparties');
	Route::get('/cases/{case_id}/pleadings/added-new-third-party', 'PleadingController@pleadingHasAddedThirdparties')->name('cases.pleadings.pleadinghasaddedthirdparties');
	Route::post('/cases/pleadings/subordinate/create', 'PleadingController@createSubordinateCasePleading')->name('cases.pleadings.subordinate.create');
	Route::post('/cases/pleadings/subordinate/store', 'PleadingController@storeSubordinateCasePleading')->name('cases.pleadings.subordinate.store');
	Route::get('/cases/{case_id}/pleadings/{motion_id}/subordinate/edit', 'PleadingController@editSubordinateCasePleading')->name('cases.pleadings.subordinate.edit');
	Route::put('/cases/pleadings/subordinate/update', 'PleadingController@updateSubordinateCasePleading')->name('cases.pleadings.subordinate.update');
	Route::post('/draft-case-practice-aids', 'PleadingController@draftCasePracticeAids')->name('draft_case_practice_aids');
	Route::post('/draft-complaint-package', 'PleadingController@draftComplaintPackage')->name('draft_complaint_package');
	// test doc table and aux table routs
	Route::get('/get-popup-form', 'DocAuxController@getPopupDynamicForm')->name('get_popup_form');
	Route::post('/get-popup-form-fields', 'DocAuxController@getPopupDynamicFormFields')->name('get_popup_form_fields');
	Route::post('/store-dynamic-popup-form-data', 'DocAuxController@storeDynamicPopupFormData')->name('store_dynamic_popup_form_data');
	// routes for practice aids
	Route::post('/draft-practice-aids', 'AttorneyController@draftPracticeAids')->name('draft_practice_aids');
	Route::get('/attorneys-practice-aids-downloads', 'AttorneyController@getPracticeAidsDownloads')->name('get_practice_aids_downloads');
	Route::post('/check-new-attorneys-downloads', 'AttorneyController@checkNewDownloads')->name('check_new_downloads');
	//routes for adds service
	Route::get('/Ads-Details/{id}', 'AttorneyController@AdDetails')->name('ads_details');
	Route::get('/services&products', 'AttorneyController@AdListing')->name('ads_listing');
    Route::any('/filter', 'AttorneyController@Filtering')->name('attorney.listfilter');
    Route::any('/search', 'AttorneyController@searchRemember')->name('attorney.filter-back');
});
// routes for clients
Route::group(['middleware' => ['auth', 'role:client']], function () {
	Route::get('/client/cases', 'ClientController@index')->name('client.cases');
	// Route::get('/client/cases/{id}/family-law-interview-data', 'ClientController@familyLawInterviewData')->name('client.cases.family_law_interview_tabs');
});
// routes for clients and attornies
Route::group(['middleware' => ['auth', 'role:client|attorney']], function () {
	Route::get('/cases/{id}/family-law-interview-data', 'CaseController@familyLawInterviewData')->name('cases.family_law_interview_tabs');
	// following routes are for dr_Aux_Tables
	Route::get('drpersonalinfo/{case_id}', 'drControllers\DrPersonalInfoController@index')->name('drpersonalinfo.index');
	Route::get('drpersonalinfo/{case_id}/create', 'drControllers\DrPersonalInfoController@create')->name('drpersonalinfo.create');
	Route::post('drpersonalinfo/store', 'drControllers\DrPersonalInfoController@store')->name('drpersonalinfo.store');
	Route::get('drpersonalinfo/{case_id}/edit', 'drControllers\DrPersonalInfoController@edit')->name('drpersonalinfo.edit');
	Route::put('drpersonalinfo/update/{id}', 'drControllers\DrPersonalInfoController@update')->name('drpersonalinfo.update');
	Route::get('drchildren/{case_id}', 'drControllers\DrChildrenController@index')->name('drchildren.index');
	Route::get('drchildren/{case_id}/create', 'drControllers\DrChildrenController@create')->name('drchildren.create');
	Route::post('drchildren/store', 'drControllers\DrChildrenController@store')->name('drchildren.store');
	Route::get('drchildren/{case_id}/edit', 'drControllers\DrChildrenController@edit')->name('drchildren.edit');
	Route::put('drchildren/update/{id}', 'drControllers\DrChildrenController@update')->name('drchildren.update');
	Route::get('drtemporaryorders/{case_id}', 'drControllers\DrTemporaryOrdersController@index')->name('drtemporaryorders.index');
	Route::get('drtemporaryorders/{case_id}/create', 'drControllers\DrTemporaryOrdersController@create')->name('drtemporaryorders.create');
	Route::post('drtemporaryorders/store', 'drControllers\DrTemporaryOrdersController@store')->name('drtemporaryorders.store');
	Route::get('drtemporaryorders/{case_id}/edit', 'drControllers\DrTemporaryOrdersController@edit')->name('drtemporaryorders.edit');
	Route::put('drtemporaryorders/update/{id}', 'drControllers\DrTemporaryOrdersController@update')->name('drtemporaryorders.update');
	Route::get('drinsurance/{case_id}', 'drControllers\DrInsuranceController@index')->name('drinsurance.index');
	Route::get('drinsurance/{case_id}/create', 'drControllers\DrInsuranceController@create')->name('drinsurance.create');
	Route::post('drinsurance/store', 'drControllers\DrInsuranceController@store')->name('drinsurance.store');
	Route::get('drinsurance/{case_id}/edit', 'drControllers\DrInsuranceController@edit')->name('drinsurance.edit');
	Route::put('drinsurance/update/{id}', 'drControllers\DrInsuranceController@update')->name('drinsurance.update');
	Route::get('drmonthlyhousingexpenses/{case_id}', 'drControllers\DrMonthlyHousingExpensesController@index')->name('drmonthlyhousingexpenses.index');
	Route::get('drmonthlyhousingexpenses/{case_id}/create', 'drControllers\DrMonthlyHousingExpensesController@create')->name('drmonthlyhousingexpenses.create');
	Route::post('drmonthlyhousingexpenses/store', 'drControllers\DrMonthlyHousingExpensesController@store')->name('drmonthlyhousingexpenses.store');
	Route::get('drmonthlyhousingexpenses/{case_id}/edit', 'drControllers\DrMonthlyHousingExpensesController@edit')->name('drmonthlyhousingexpenses.edit');
	Route::put('drmonthlyhousingexpenses/update/{id}', 'drControllers\DrMonthlyHousingExpensesController@update')->name('drmonthlyhousingexpenses.update');
	Route::get('drmonthlyhealthcareexpenses/{case_id}', 'drControllers\DrMonthlyHealthCareExpensesController@index')->name('drmonthlyhealthcareexpenses.index');
	Route::get('drmonthlyhealthcareexpenses/{case_id}/create', 'drControllers\DrMonthlyHealthCareExpensesController@create')->name('drmonthlyhealthcareexpenses.create');
	Route::post('drmonthlyhealthcareexpenses/store', 'drControllers\DrMonthlyHealthCareExpensesController@store')->name('drmonthlyhealthcareexpenses.store');
	Route::get('drmonthlyhealthcareexpenses/{case_id}/edit', 'drControllers\DrMonthlyHealthCareExpensesController@edit')->name('drmonthlyhealthcareexpenses.edit');
	Route::put('drmonthlyhealthcareexpenses/update/{id}', 'drControllers\DrMonthlyHealthCareExpensesController@update')->name('drmonthlyhealthcareexpenses.update');
	Route::get('drmonthlyeducationexpenses/{case_id}', 'drControllers\DrMonthlyEducationExpensesController@index')->name('drmonthlyeducationexpenses.index');
	Route::get('drmonthlyeducationexpenses/{case_id}/create', 'drControllers\DrMonthlyEducationExpensesController@create')->name('drmonthlyeducationexpenses.create');
	Route::post('drmonthlyeducationexpenses/store', 'drControllers\DrMonthlyEducationExpensesController@store')->name('drmonthlyeducationexpenses.store');
	Route::get('drmonthlyeducationexpenses/{case_id}/edit', 'drControllers\DrMonthlyEducationExpensesController@edit')->name('drmonthlyeducationexpenses.edit');
	Route::put('drmonthlyeducationexpenses/update/{id}', 'drControllers\DrMonthlyEducationExpensesController@update')->name('drmonthlyeducationexpenses.update');
	Route::get('drgiftinheritance/{case_id}', 'drControllers\DrGiftInheritanceController@index')->name('drgiftinheritance.index');
	Route::get('drgiftinheritance/{case_id}/create', 'drControllers\DrGiftInheritanceController@create')->name('drgiftinheritance.create');
	Route::post('drgiftinheritance/store', 'drControllers\DrGiftInheritanceController@store')->name('drgiftinheritance.store');
	Route::get('drgiftinheritance/{case_id}/edit', 'drControllers\DrGiftInheritanceController@edit')->name('drgiftinheritance.edit');
	Route::put('drgiftinheritance/update/{id}', 'drControllers\DrGiftInheritanceController@update')->name('drgiftinheritance.update');
	Route::get('drmonthlylivingexpenses/{case_id}', 'drControllers\DrMonthlyLivingExpensesController@index')->name('drmonthlylivingexpenses.index');
	Route::get('drmonthlylivingexpenses/{case_id}/create', 'drControllers\DrMonthlyLivingExpensesController@create')->name('drmonthlylivingexpenses.create');
	Route::post('drmonthlylivingexpenses/store', 'drControllers\DrMonthlyLivingExpensesController@store')->name('drmonthlylivingexpenses.store');
	Route::get('drmonthlylivingexpenses/{case_id}/edit', 'drControllers\DrMonthlyLivingExpensesController@edit')->name('drmonthlylivingexpenses.edit');
	Route::put('drmonthlylivingexpenses/update/{id}', 'drControllers\DrMonthlyLivingExpensesController@update')->name('drmonthlylivingexpenses.update');
	Route::get('drmonthlydebtpayments/{case_id}', 'drControllers\DrMonthlyDebtPaymentsController@index')->name('drmonthlydebtpayments.index');
	Route::get('drmonthlydebtpayments/{case_id}/create', 'drControllers\DrMonthlyDebtPaymentsController@create')->name('drmonthlydebtpayments.create');
	Route::post('drmonthlydebtpayments/store', 'drControllers\DrMonthlyDebtPaymentsController@store')->name('drmonthlydebtpayments.store');
	Route::get('drmonthlydebtpayments/{case_id}/edit', 'drControllers\DrMonthlyDebtPaymentsController@edit')->name('drmonthlydebtpayments.edit');
	Route::put('drmonthlydebtpayments/update/{id}', 'drControllers\DrMonthlyDebtPaymentsController@update')->name('drmonthlydebtpayments.update');
	Route::get('drmarriageinfo/{case_id}', 'drControllers\DrMarriageInfoController@index')->name('drmarriageinfo.index');
	Route::get('drmarriageinfo/{case_id}/create', 'drControllers\DrMarriageInfoController@create')->name('drmarriageinfo.create');
	Route::post('drmarriageinfo/store', 'drControllers\DrMarriageInfoController@store')->name('drmarriageinfo.store');
	Route::get('drmarriageinfo/{case_id}/edit', 'drControllers\DrMarriageInfoController@edit')->name('drmarriageinfo.edit');
	Route::put('drmarriageinfo/update/{id}', 'drControllers\DrMarriageInfoController@update')->name('drmarriageinfo.update');
	Route::get('drspousalsupportthismarriage/{case_id}', 'drControllers\DrSpousalSupportThisMarriageController@index')->name('drspousalsupportthismarriage.index');
	Route::get('drspousalsupportthismarriage/{case_id}/create', 'drControllers\DrSpousalSupportThisMarriageController@create')->name('drspousalsupportthismarriage.create');
	Route::post('drspousalsupportthismarriage/store', 'drControllers\DrSpousalSupportThisMarriageController@store')->name('drspousalsupportthismarriage.store');
	Route::get('drspousalsupportthismarriage/{case_id}/edit', 'drControllers\DrSpousalSupportThisMarriageController@edit')->name('drspousalsupportthismarriage.edit');
	Route::put('drspousalsupportthismarriage/update/{id}', 'drControllers\DrSpousalSupportThisMarriageController@update')->name('drspousalsupportthismarriage.update');
	Route::get('drmonthlyexpenseschildrenofthismarriage/{case_id}', 'drControllers\DrMonthlyExpensesChildrenOfThisMarriageController@index')->name('drmonthlyexpenseschildrenofthismarriage.index');
	Route::get('drmonthlyexpenseschildrenofthismarriage/{case_id}/create', 'drControllers\DrMonthlyExpensesChildrenOfThisMarriageController@create')->name('drmonthlyexpenseschildrenofthismarriage.create');
	Route::post('drmonthlyexpenseschildrenofthismarriage/store', 'drControllers\DrMonthlyExpensesChildrenOfThisMarriageController@store')->name('drmonthlyexpenseschildrenofthismarriage.store');
	Route::get('drmonthlyexpenseschildrenofthismarriage/{case_id}/edit', 'drControllers\DrMonthlyExpensesChildrenOfThisMarriageController@edit')->name('drmonthlyexpenseschildrenofthismarriage.edit');
	Route::put('drmonthlyexpenseschildrenofthismarriage/update/{id}', 'drControllers\DrMonthlyExpensesChildrenOfThisMarriageController@update')->name('drmonthlyexpenseschildrenofthismarriage.update');
	Route::get('drfundsondeposit/{case_id}', 'drControllers\DrFundsOnDepositController@index')->name('drfundsondeposit.index');
	Route::get('drfundsondeposit/{case_id}/create', 'drControllers\DrFundsOnDepositController@create')->name('drfundsondeposit.create');
	Route::post('drfundsondeposit/store', 'drControllers\DrFundsOnDepositController@store')->name('drfundsondeposit.store');
	Route::get('drfundsondeposit/{case_id}/edit', 'drControllers\DrFundsOnDepositController@edit')->name('drfundsondeposit.edit');
	Route::put('drfundsondeposit/update/{id}', 'drControllers\DrFundsOnDepositController@update')->name('drfundsondeposit.update');
	Route::get('drstocksinvestments/{case_id}', 'drControllers\DrStocksInvestmentsController@index')->name('drstocksinvestments.index');
	Route::get('drstocksinvestments/{case_id}/create', 'drControllers\DrStocksInvestmentsController@create')->name('drstocksinvestments.create');
	Route::post('drstocksinvestments/store', 'drControllers\DrStocksInvestmentsController@store')->name('drstocksinvestments.store');
	Route::get('drstocksinvestments/{case_id}/edit', 'drControllers\DrStocksInvestmentsController@edit')->name('drstocksinvestments.edit');
	Route::put('drstocksinvestments/update/{id}', 'drControllers\DrStocksInvestmentsController@update')->name('drstocksinvestments.update');
	Route::get('drrealestate/{case_id}', 'drControllers\DrRealEstateController@index')->name('drrealestate.index');
	Route::get('drrealestate/{case_id}/create', 'drControllers\DrRealEstateController@create')->name('drrealestate.create');
	Route::post('drrealestate/store', 'drControllers\DrRealEstateController@store')->name('drrealestate.store');
	Route::get('drrealestate/{case_id}/edit', 'drControllers\DrRealEstateController@edit')->name('drrealestate.edit');
	Route::put('drrealestate/update/{id}', 'drControllers\DrRealEstateController@update')->name('drrealestate.update');
	Route::get('drretirementaccts/{case_id}', 'drControllers\DrRetirementAcctsController@index')->name('drretirementaccts.index');
	Route::get('drretirementaccts/{case_id}/create', 'drControllers\DrRetirementAcctsController@create')->name('drretirementaccts.create');
	Route::post('drretirementaccts/store', 'drControllers\DrRetirementAcctsController@store')->name('drretirementaccts.store');
	Route::get('drretirementaccts/{case_id}/edit', 'drControllers\DrRetirementAcctsController@edit')->name('drretirementaccts.edit');
	Route::put('drretirementaccts/update/{id}', 'drControllers\DrRetirementAcctsController@update')->name('drretirementaccts.update');
	Route::get('drvehicles/{case_id}', 'drControllers\DrVehiclesController@index')->name('drvehicles.index');
	Route::get('drvehicles/{case_id}/create', 'drControllers\DrVehiclesController@create')->name('drvehicles.create');
	Route::post('drvehicles/store', 'drControllers\DrVehiclesController@store')->name('drvehicles.store');
	Route::get('drvehicles/{case_id}/edit', 'drControllers\DrVehiclesController@edit')->name('drvehicles.edit');
	Route::put('drvehicles/update/{id}', 'drControllers\DrVehiclesController@update')->name('drvehicles.update');
	Route::get('drpensions/{case_id}', 'drControllers\DrPensionController@index')->name('drpensions.index');
	Route::get('drpensions/{case_id}/create', 'drControllers\DrPensionController@create')->name('drpensions.create');
	Route::post('drpensions/store', 'drControllers\DrPensionController@store')->name('drpensions.store');
	Route::get('drpensions/{case_id}/edit', 'drControllers\DrPensionController@edit')->name('drpensions.edit');
	Route::put('drpensions/update/{id}', 'drControllers\DrPensionController@update')->name('drpensions.update');
	Route::get('drincome/{case_id}', 'drControllers\DrIncomeController@index')->name('drincome.index');
	Route::get('drincome/{case_id}/create', 'drControllers\DrIncomeController@create')->name('drincome.create');
	Route::post('drincome/store', 'drControllers\DrIncomeController@store')->name('drincome.store');
	Route::get('drincome/{case_id}/edit', 'drControllers\DrIncomeController@edit')->name('drincome.edit');
	Route::put('drincome/update/{id}', 'drControllers\DrIncomeController@update')->name('drincome.update');
	Route::get('drcaseoverview/{case_id}', 'drControllers\DrCaseOverviewController@index')->name('drcaseoverview.index');
	Route::get('drcaseoverview/{case_id}/create', 'drControllers\DrCaseOverviewController@create')->name('drcaseoverview.create');
	Route::post('drcaseoverview/store', 'drControllers\DrCaseOverviewController@store')->name('drcaseoverview.store');
	Route::get('drcaseoverview/{case_id}/edit', 'drControllers\DrCaseOverviewController@edit')->name('drcaseoverview.edit');
	Route::put('drcaseoverview/update/{id}', 'drControllers\DrCaseOverviewController@update')->name('drcaseoverview.update');
});
