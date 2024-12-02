<?php



use App\Http\Controllers\API\BussinessController;

use App\Http\Controllers\API\DownloadController;

use App\Http\Controllers\API\ImageController;

use App\Http\Controllers\createimageController;

use App\Http\Controllers\Image_categoryController;



use App\Http\Controllers\AuthController;







use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\API\BussinesscategortController;

use App\Http\Controllers\API\BrandingController;







/*

|--------------------------------------------------------------------------

| API Routes

|--------------------------------------------------------------------------

|

| Here is where you can register API routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| is assigned the "api" middleware group. Enjoy building your API!

|

*/





// UserController routes

Route::controller(UserController::class)->group(function () {

    Route::post('/registration', 'registration');

    Route::post('/verifyotp', 'verifyemail');

    Route::post('/login', 'login');

    Route::post('/getdatabyuser', 'getdata');

    Route::delete('/deletealluserdata', 'deletealluserdata');

    Route::post('/updateuser', 'updateuser');

    Route::post('/addpersonaldetails', 'personaldetails');

    Route::post('/userdata', 'userdata');

    Route::post('/resendotp', 'resendotp');

    Route::post('/updatepuersonaldetails', 'updatepuersonaldetails');

    Route::post('/verifymobile', 'verifymobile');

});



// BussinessController routes

Route::controller(BussinessController::class)->group(function () {

    Route::post('/bussiness_add', 'bussiness_add');

    Route::post('/changebussiness', 'changebussiness');

    Route::post('/bussiness_data_get', 'getbussinessdata'); 

    Route::post('/bussinessupdate', 'updateBusiness');

    Route::post('/deltebussiness', 'deltebuussiness');

    Route::get('/bussiness_category', 'allbussinesscategory');

    Route::post('/show', 'show');

});



// ImageController routes

Route::controller(ImageController::class)->group(function () {

    Route::get('/all_image_data', 'allimages');

    Route::get('/frames', 'frames');

    Route::post('/datefilterimage', 'datefilterimage');

    Route::get('/resizeMissingImages', 'resizeMissingImages');
    Route::post('/f11', 'f11');

});



// DownloadController routes

Route::controller(DownloadController::class)->group(function () {

    Route::post('/download', 'download');

    Route::delete('/delete_download_image', 'delete_download_image'); 

    Route::post('/get_download_details', 'get_download_details'); 

    Route::delete('/clear_data', 'clear_data'); 

});



//BrandingController Routes



Route::controller(BrandingController::class)->group(function () {

    Route::get('/brandinglist', 'brandinglist');

   

});



// PersonalCategoryController routes

Route::post('/personalallimages', [PersonalCategoryController::class, 'personalallimages']);





Route::post('/store_frame_api', [createimageController::class, 'store_frame_api2']);

Route::post('/update_frame_api', [createimageController::class, 'update_frame_api']);

Route::post('/storeimage', [createimageController::class, 'storeimage_api']);

Route::post('/deleteimage', [createimageController::class, 'deleteimage_api']);

Route::post('/frame_delete', [createimageController::class, 'frame_delete']);

Route::post('/updateimage_api', [createimageController::class, 'updateimage_api']);

Route::get('/dispalyimage', [createimageController::class, 'dispalyimage_api']);
Route::post('/store_frame_excel', [createimageController::class, 'store_frame_excel']);

Route::post('/create_imagecategory', [Image_categoryController::class, 'imagecategory_api']);

Route::post('/imagecategory_delete', [Image_categoryController::class, 'imagecategory_delete']);

Route::post('/update_image_category', [Image_categoryController::class, 'update_image_category']);

Route::get('/display_image_category', [Image_categoryController::class, 'display_image_category']);

Route::get('/userlist', [AuthController::class, 'userlist_api']);

Route::post('/userdetails', [AuthController::class, 'userdetails_api']);

Route::get('/dashbord_api', [AuthController::class, 'dashbord_api']);

Route::post('/login_api', [AuthController::class, 'login_api']);













