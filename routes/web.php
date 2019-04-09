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

//Route::get('/', 'LoginController@index');
Route::get('/', function () {
    return view('login');
});

Route::get('/login', ['as'=>'login_page','uses'=>'LoginController@index']);
Route::post('/login/login', ['as'=>'login','uses'=>'LoginController@login']);
Route::get('/login/logout', ['as'=>'logout','uses'=>'LoginController@logout']);


Route::get('/console', ['as'=>'console','uses'=>'ConsoleController@console']);
Route::get('/error', ['as'=>'error','uses'=>'ConsoleController@error']);

Route::get('/profile/{id}', ['as'=>'profile','uses'=>'ConsoleController@profile']);
Route::post('/profile/update', ['as'=>'profile_update','uses'=>'ConsoleController@profile_update']);
// Route::get('/userinterface', ['as'=>'ui','uses'=>'ConsoleController@ui']);
Route::get('/resident',['as'=>'resident','uses'=>'ResidentController@index']);
Route::get('/room',['as'=>'room','uses'=>'ResidentController@room']);
/*Resident & Room*/
Route::post('/resident/add/resident',['as'=>'add_resident','uses'=>'ResidentController@add_resident']);
Route::post('/resident/add/room',['as'=>'add_room','uses'=>'ResidentController@add_room']);
Route::post('/resident/update',['as'=>'update_resident','uses'=>'ResidentController@update_resident']);
Route::post('/resident/update/resident',['as'=>'update_resident','uses'=>'ResidentController@update_resident']);
Route::post('/resident/update/room',['as'=>'update_room','uses'=>'ResidentController@update_room']);
Route::get('/resident/delete/resident',['as'=>'delete_resident','uses'=>'ResidentController@delete_resident']);
Route::get('/resident/delete/room',['as'=>'delete_room','uses'=>'ResidentController@delete_room']);
Route::get('/resident/mail',['as'=>'verifymail','uses'=>'ResidentController@registration_email']);
Route::get('register/{id}/{token}','ResidentController@user_registration')->name('register');

/*Resident & Room*/


//package routes
Route::get('/package',['as'=>'package','uses'=>'PackageController@index']);
Route::get('/package/getupdate/',['as'=>'get_update_package','uses'=>'PackageController@get_update_package']);
Route::get('/package/{id}/{packid}','PackageController@pack_confirm')->name('packconfirmed');
Route::post('/package/add',['as'=>'add_package','uses'=>'PackageController@add_package']);
Route::post('/package/remove',['as'=>'remove_package','uses'=>'PackageController@remove_package']);
Route::post('/package/update',['as'=>'update_package','uses'=>'PackageController@update_package']);


Route::get('repair','pageController@getRepair');
Route::get('services','PostsController@services');
Route::resource('posts','PostsController');

//lostfoundroutes
Route::get('/LostFoundTopicsAdmin',['as'=>'LostFoundTopicsAdmin','uses'=>'LostFoundController@indexAdmin']);
Route::get('/LostFoundTopicsAdmin/{id}',['as'=>'LostFoundReplysAdmin','uses'=>'LostFoundController@index_reply_admin']);

Route::get('/LostFoundTopics',['as'=>'LostFoundTopics','uses'=>'LostFoundController@index']);
Route::post('/LostFoundTopics/add',['as'=>'add_topic','uses'=>'LostFoundController@add_topic']);
Route::get('/LostFoundTopics/remove',['as'=>'remove_topic','uses'=>'LostFoundController@remove_topic']);
Route::get('/LostFoundTopics/search',['as'=>'search_lostfound','uses'=>'LostFoundController@searchLostFound']);
Route::get('/LostFoundTopics/getedit/',['as'=>'get_edit_topic','uses'=>'LostFoundController@get_edit_topic']);
Route::post('/LostFoundTopics/edit',['as'=>'edit_topic','uses'=>'LostFoundController@edit_topic']);

Route::get('/LostFoundTopics/r/{id}',['as'=>'LostFoundReplys','uses'=>'LostFoundController@index_reply']);
Route::post('/LostFoundTopics/r/{id}/reply',['as'=>'reply','uses'=>'LostFoundController@add_reply']);
Route::get('/LostFoundTopics/r/{id}/geteditreply',['as'=>'get_edit_reply','uses'=>'LostFoundController@get_edit_reply']);
Route::post('/LostFoundTopics/r/{id}/editreply',['as'=>'edit_reply','uses'=>'LostFoundController@edit_reply']);
Route::get('/LostFoundTopics/r/{id}/removereply',['as'=>'remove_reply','uses'=>'LostFoundController@remove_reply']);

//message routes
Route::get('/message',['as'=>'message','uses'=>'MessageController@index']);
Route::post('/message/send',['as'=>'send_message','uses'=>'MessageController@send_message']);
Route::get('/message/read',['as'=>'read_message','uses'=>'MessageController@read']);
Route::get('/message/messagessent',['as'=>'MessagesSent','uses'=>'MessageController@index_sent']);
//Valerie - Announcement & Booking
Route::get('/announcement',['as'=>'announcement','uses'=>'AnnouncementController@index']);
Route::post('/announcement/add/announcement',['as'=>'add_announcement','uses'=>'AnnouncementController@add_announcement']);
Route::post('/announcement/update/announcement',['as'=>'update_announcement','uses'=>'AnnouncementController@update_announcement']);
Route::get('/announcement/delete/announcement',['as'=>'delete_announcement','uses'=>'AnnouncementController@delete_announcement']);

Route::get('/facility_booking',['as'=>'facility_booking','uses'=>'FacilityBookingController@index']);

Route::post('/facility_booking/add',['as'=>'add_facility_booking','uses'=>'FacilityBookingController@add_facility_booking']);
Route::get('/facility_booking/delete',['as'=> 'delete_facility_booking','uses'=>'FacilityBookingController@delete_facility_booking']);
Route::get('/facility_booking/error', ['as'=>'error','uses'=>'FacilityBookingController@error']);


Route::post('/facility_booking/add/facility_booking',['as'=>'add_facility_booking','uses'=>'FacilityBookingController@add_facility_booking']);
Route::post('/facility_booking/update/facility_booking',['as'=>'update_facility_booking','uses'=>'FacilityBookingController@update_facility_booking']);
Route::get('/facility_booking/delete/facility_booking',['as'=> 'delete_facility_booking','uses'=>'FacilityBookingController@delete_facility_booking']);


Route::get('/console/readNoti/{id}',['as'=>'read_Noti','uses'=>'NotificationController@read_noti']);

//Valerie-payment
Route::get('/payment',['as'=>'payment','uses'=>'PaymentController@index']);

Route::get('/payment/pay_fee',['as'=>'pay_fee','uses'=>'PaymentController@pay_fee']);
//Dorothy Hao for Visitors
Route::get('/visitor',['as'=>'visitor','uses'=>'VisitorController@index']);
Route::post('/visitor/search/visitor',['as'=>'search_visitor','uses'=>'VisitorController@searchVisitor']);

//Dorothy Hao for send email to resident
Route::get('/sendForm',['as'=>'send_from','uses'=>'SendEmailController@index']);
Route::post('/sendEmail',['as'=>'send_email','uses'=>'SendEmailController@sendMessage']);

//Dorothy Hao for Parking
Route::get('/availableParking',['as'=>'parking_space','uses'=>'ParkingController@index']);

//Dorothy Hao for Visitors(user side)
Route::get ('/VisitorLogin', ['as'=>'visitorLogin','uses'=>'VisitorController@logIn']);
Route::post ('/VisitorLoginConfirm', ['as'=>'visitorLoginSubmit','uses'=>'VisitorController@sendVisitorNotification']);
Route::get('/myVisitorList',['as'=>'myVisitorList','uses'=>'VisitorController@myVisitorList']);

//Dorothy Hao verify_visitor_true
Route::get('/console/readVisitorNotiYes/{id}/{name}/{email}/{phone}/{roomNumber}',['as'=>'verify_visitor_true','uses'=>'VisitorController@verifyVisitorTrue']);

//Dorothy Hao verify_visitor_false
Route::get('/console/readVisitorNotiNo/{id}',['as'=>'verify_visitor_false','uses'=>'VisitorController@verifyVisitorFalse']);
Route::get('/myVisitor/logOut',['as'=>'visitorLogOut','uses'=>'VisitorController@logOut']);
//User repair requests
Route::get('/userRepair',['as'=>'userRepair','uses'=>'userRepairController@userIndex']);
Route::post('/repair/add/userRepair',['as'=>'add_userRepairs','uses'=>'userRepairController@add_userRepairs']);
//User event
Route::get('/userEvent',['as'=>'userEvent','uses'=>'userEventController@userIndex']);

//admin event
Route::get('/event',['as'=>'event','uses'=>'EventController@index']);
Route::post('/event/add/event',['as'=>'add_event','uses'=>'EventController@add_event']);
Route::post('/event/update/event',['as'=>'update_event','uses'=>'EventController@update_event']);
Route::get('/event/delete/event',['as'=>'delete_event','uses'=>'EventController@delete_event']);

//admin lendings
Route::get('/lendings',['as'=>'lendings','uses'=>'LendingsController@index']);
Route::post('/lendings/add/lendings',['as'=>'add_lendings','uses'=>'LendingsController@add_lendings']);
Route::post('/lendings/update/lendings',['as'=>'update_lendings','uses'=>'LendingsController@update_lendings']);
Route::get('/lendings/delete/lendings',['as'=>'delete_lendings','uses'=>'LendingsController@delete_lendings']);

//admin repair posts
Route::get('/repair',['as'=>'repair','uses'=>'RepairController@index']);
Route::post('/repair/add/repair',['as'=>'add_repairs','uses'=>'RepairController@add_repairs']);
Route::post('/repair/update/repair',['as'=>'update_repairs','uses'=>'RepairController@update_repairs']);
Route::get('/repair/delete/repair',['as'=>'delete_repairs','uses'=>'RepairController@delete_repairs']);
