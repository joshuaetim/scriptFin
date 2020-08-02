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

Route::view('check', 'fakeHome');

// GET ROUTES

Route::get('/', function () {
    if(isset($_GET['ref'])){
        session(['referral' => $_GET['ref']]);
    }
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login/admin', 'Auth\LoginController@showAdminLogin');

Route::get('/referral', 'HomeController@referral');

// Route::get('/admin', 'AdminController@home');

Route::get('/admin', 'AdminController@home');

Route::get('/play', 'PlayController@play');

Route::get('/regMail', function() {
    $admin = auth('admin')->user();
    return new App\Mail\Registered($admin);
});

Route::get('/download/{download}', 'PaymentLogController@download');

Route::get('/paymentPage/{withdraw}', 'WithdrawController@showPayment');

Route::get('/newInvestment', 'InvestmentController@create');

Route::get('/activationPaymentPage/{investment}', 'InvestmentController@showPayment');

Route::get('/activate', 'InvestmentController@activate');

Route::get('like', function(){
    event(new App\Events\StatusLiked('Someone'));
    return 'Liked';
});

Route::get('/viewPayment/{investment}', 'AdminController@paymentShow');

Route::get('/profile', 'HomeController@profile');

Route::get('/withdraw_show', 'InvestmentController@showMaturedInvestments');

Route::get('/withdraw/{investment}', 'WithdrawController@store');

Route::get('/support', 'SupportController@create');

Route::get('/complain', 'ComplainController@create');


// POST ROUTES

Route::post('/touch', 'PlayController@trap')->name('trap');

Route::post('/login/admin', 'Auth\LoginController@adminLogin');

Route::post('/makeActivationPayment', 'PaymentLogController@store')->name('activationPay');

Route::post('/makePayment', 'WithdrawController@submitPayment')->name('pay');

Route::post('/confirmPayment', 'WithdrawController@confirmPayment')->name('confirmPayment');

Route::post('/confirmPaymentAdmin', 'AdminController@confirm');

Route::post('/updateProfile', 'HomeController@updateProfile')->name('update');

Route::post('/addInvestment', 'InvestmentController@store')->name('addInvestment');

Route::post('/withdrawInvestment', 'InvestmentController@withdrawInvestment')->name('withdrawInvestment');

Route::post('/addSupport', 'SupportController@store')->name('addSupport');

Route::post('/addComplain', 'ComplainController@store')->name('addComplain');

Route::post('/deleteUsers', 'AdminController@deleteUsers');

Auth::routes();

// GROUP 

Route::middleware('auth:admin')->group(function() {

    Route::get('/activeUsers', 'AdminController@showActiveUsers');
    Route::get('/viewSupport', 'SupportController@showSupport');
    Route::get('/viewComplaints', 'ComplainController@showComplaints');
    Route::get('/showInvestments', 'AdminController@showAllInvestments');
    Route::get('/merged', 'AdminController@showMergedWithdrawals');
    Route::get('/manualMerge', 'AdminController@manualMerge');
    Route::get('/adminReferral', 'AdminController@referral');
    Route::get('/blockedUsers', 'AdminController@showBlockedUsers');
    Route::get('/createUser', 'AdminController@createUser');


    Route::post('/storeUser', 'AdminController@storeUser')->name('storeUser');
    Route::post('/deleteUser', 'AdminController@deleteUser');
    Route::post('/blockUser', 'AdminController@blockUser');
    Route::post('/unblockUser', 'AdminController@unblockUser');
    Route::post('/replySupport', 'SupportController@replySupport');
    Route::post('/replyComplain', 'ComplainController@replyComplain');
    Route::post('/mergeManually', 'AdminController@mergeManually')->name('merge');
});