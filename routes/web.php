<?php
use App\User;
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

Route::get('/',function(){
  $users = User::all();
  //if there are users
  if(count ($users) > 0) {
    Auth::logout();
        return view('auth.login');
    }
  //if there are no users
    if(count ($users) == 0) {
      Auth::logout();
          return redirect('/Welcome');
      }
    Auth::logout();
    return '/';
}) -> name('/');

    Auth::routes();

    //Free Routes Here
    Route::get('/Welcome', 'CustomRegisterController@index');
    Route::post('/Welcome/Submit', 'CustomRegisterController@one_time_register_submit');

    //Super Admin Routes Here

    Route::get('/superadmin/home', 'HomeController@index')->name('superadminhome');

    Route::get('/superadmin/queues', 'HomeController@queues')->name('superadminqueues');
    Route::get('/superadmin/queues/view', 'HomeController@queueView')->name('superadminqueueView');
    Route::get('/superadmin/queues/new', 'HomeController@newQueue')->name('superadminnewQueue');
    Route::post('/superadmin/queue/new/submit_1', 'QueueDesigner1Controller@newQueue_submit_1')->name('superadminnewQueue_submit_1');
    Route::get('/superadmin/queues/new/modify', 'QueueDesigner2Controller@index')->name('superadminnewQueue_modify');
    Route::resource('/superadmin/queues/new/modify', 'QueueDesigner2Controller');
    Route::post('/superadmin/queues/new/modify/save', 'QueuesRecordController@recordQueueDesign')->name('recordQueueDesign');

    Route::get('/superadmin/accounts', 'HomeController@accounts')->name('superadminaccounts');
    Route::get('/superadmin/accounts/view/queue_administrators', 'HomeController@viewQueueAdminAccounts')->name('viewQueueAdminAccounts');
    Route::get('/superadmin/accounts/view/station_administrators', 'HomeController@viewStationAdminAccounts')->name('viewStationAdminAccounts');
    Route::get('/superadmin/accounts/new', 'HomeController@newAccounts')->name('superadminnewAccounts');
    Route::post('/superadmin/accounts/new/submit', 'HomeController@newAccountSubmit')->name('superadminnewAccountSubmit');
    Route::get('/superadmin/archives', 'HomeController@archives')->name('superadminarchives');
    Route::get('/superadmin/announcements', 'HomeController@announcements')->name('superadminannouncements');

    Route::post('/edit/addStation', 'HomeController@addStation')->name('SAaddStation.submit');

    //Queue Admin Routes Here
    Route::get('/queueadmin/home', 'QueueAdminController@index')->name('queueadminhome');

    Route::get('/queueadmin/queues', 'QueueAdminController@queues')->name('queueadminqueues');
    Route::get('/queueadmin/queues/view', 'QueueAdminController@queueView')->name('queueadminqueueView');
    Route::get('/queueadmin/queues/new', 'QueueAdminController@newQueue')->name('queueadminnewQueue');
    Route::post('/queueadmin/queue/new/submit_1', 'QueueDesigner_1Controller@newQueue_submit_1')->name('queueadminnewQueue_submit_1');
    Route::get('/queueadmin/queues/new/modify', 'QueueDesigner_2Controller@index')->name('queueadminnewQueue_modify');
    Route::resource('/queueadmin/queues/new/modify', 'QueueDesigner_2Controller');
    Route::post('/queueadmin/queues/new/modify/save', 'QueuesRecord_QueueAdmin_Controller@recordQueueDesign')->name('queueadmin_recordQueueDesign');

    Route::get('/queueadmin/accounts', 'QueueAdminController@accounts')->name('queueadminaccounts');
    Route::get('/queueadmin/accounts/{record_name}', 'QueueAdminController@pick_queue_from_table')->name('queueadminpick_queue_from_table');
    Route::get('/queueadmin/accounts/{record_name}/{record_number}', 'QueueAdminController@pick_station_admin_from_table')->name('pick_station_admin_from_table');
    //Station Admin Routes Here
    Route::get('/stationadmin/home', 'StationAdminController@index')->name('stationadminhome');

    //Window Admin Routes Here
    Route::get('/windowadmin/home', 'WindowAdminController@index')->name('windowadminhome');

    //Flashboard Routes Here
    Route::get('/flashboard/home', 'FlashboardController@index')->name('flashboardhome');

    //Kiosk Routes Here
    Route::get('/kiosk/home', 'KioskController@index')->name('kioskhome');

    //Pool Routes Here
    Route::resource('pools', 'PoolsController');
    Route::post('/Queue/custom', 'PoolsController@custom');
    Route::post('/Queue/noteCheck', 'PoolsController@noteCheck');
    Route::post('/Queue/transfer', 'PoolsController@transfer');
    Route::get('/Queue/getNumber', 'PoolsController@getNumber');
    Route::get('/Queue/getOnHold-{id}','PoolsController@getOnHold');

    //Queue Control Routes Here
    Route::resource('queue', 'QueueController');
    Route::post('/Queue/rename-{id}', 'QueueController@renameQueue');
    Route::post('/Queue/reset-{id}', 'QueueController@resetQueue');
    Route::post('/Queue/delete-{id}', 'QueueController@deleteQueue');
    Route::post('/Queue/deactivate-{id}', 'QueueController@deactivateQueue');
    Route::post('/Queue/activate-{id}', 'QueueController@activateQueue');


    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
