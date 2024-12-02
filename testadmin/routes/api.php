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

    Route::post('/product_add', 'product_add');
    Route::post('/service_add', 'service_add');
    Route::post('/product_list', 'product_list');
    Route::post('/service_list', 'service_list');


    Route::post('/testimonial_add', 'testimonial_add');
    Route::post('/testimonial_display', 'testimonial_display');
    Route::post('/add_socialmedia_links', 'add_socialmedia_links');
    Route::post('/display_social_media_links', 'display_social_media_links');
    Route::post('/base64Image', 'base64Image');
    Route::post('/add_bussiness_images', 'add_bussiness_images');
    Route::post('/display_bussiness_images', 'display_bussiness_images');

    Route::post('/store_bussiness_time', 'store_bussiness_time');
    Route::post('/display_bussiness_time', 'display_bussiness_time');

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
Route::post('/store_replica_image', [createimageController::class, 'store_replica_image_api']);

Route::post('/create_imagecategory', [Image_categoryController::class, 'imagecategory_api']);

Route::post('/imagecategory_delete', [Image_categoryController::class, 'imagecategory_delete']);

Route::post('/update_image_category', [Image_categoryController::class, 'update_image_category']);

Route::get('/display_image_category', [Image_categoryController::class, 'display_image_category']);



Route::post('/create_framecategory', [Image_categoryController::class, 'framecategory_api']);

Route::post('/framecategory_delete', [Image_categoryController::class, 'framecategory_delete']);

Route::get('/display_frame_category', [Image_categoryController::class, 'display_frame_category']);
Route::post('/framecategory_update_api', [Image_categoryController::class, 'framecategory_update_api']);










Route::get('/userlist', [AuthController::class, 'userlist_api']);

Route::post('/userdetails', [AuthController::class, 'userdetails_api']);

Route::get('/dashbord_api', [AuthController::class, 'dashbord_api']);

Route::post('/login_api', [AuthController::class, 'login_api']);













