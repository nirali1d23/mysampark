<?php

use App\Http\Controllers\Bussiness_categoryController;
use App\Http\Controllers\BussinessController;
use App\Http\Controllers\createimageController;
use App\Http\Controllers\Image_categoryController;
use App\Http\Controllers\PersonalCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScreenshotController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


// AuthController routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('/');
  

    Route::get('/dashbord', 'dashbord')->name('dashbord');
    Route::post('/login', 'loginn')->name('login');
    Route::post('/logout', 'logout')->name('doLogout');
    Route::get('/userlist', 'userlist')->name('userlist');
    Route::get('/viewuser/{id}', 'viewuser')->name('viewuser');
    Route::get('/edituser/{id}', 'edituser')->name('edituser');
    Route::post('/updateuser', 'updateuser')->name('updateuser');
});

// Bussiness_category  routes
Route::controller(Bussiness_categoryController::class)->group(function () {
    Route::get('/category', 'category');
    Route::post('/category', 'category')->name('category');
    Route::post('/addcategory', 'storebuss')->name('addcategory');
    Route::get('/addcategory', 'storebuss');
    Route::delete('/deletecategory/{id}', 'delete')->name('delete');
});

// Image_category Controller routes
Route::controller(Image_categoryController::class)->group(function () {
    Route::get('/imagecategory', 'imagecategory');
    Route::post('/imagecategory', 'imagecategory')->name('imagecategory');
    Route::delete('/deleteiamgecategory/{id}', 'deleteiamgecategory')->name('deleteiamgecategory');
    Route::post('/addimagecategory', 'store')->name('addimagecategory');
    Route::get('/imagestoree', 'imagestoree')->name('imagestoree');
    Route::get('/image', 'image')->name('image');
    Route::post('/image', 'imagestore');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::post('/updateimage/{id}', 'updateimage')->name('updateimage');
});

// createimageController routes
Route::controller(createimageController::class)->group(function () {
    Route::get('/image', 'display')->name('image');
    Route::get('/createimages', 'createimages')->name('createimages');
    Route::get('/showimage', 'showimage')->name('showimage');
    Route::post('/storeimage', 'storeimage')->name('storeimage');
    Route::delete('/deleteimage/{id}', 'deleteimage')->name('deleteimage');
    Route::delete('/deleteframe/{id}', 'deleteframe')->name('deleteframe');
    Route::get('/editimage/{id}', 'editimage')->name('editimage');
    Route::get('/frame', 'framedisplay')->name('frame');
    Route::post('/storeframe', 'store_frame')->name('storeframe');
    Route::get('/editframe/{id}', 'editframe')->name('editframe');
    Route::post('/updateframe/{id}', 'updateframe')->name('updateframe');
    Route::get('/appparamter/{id}', 'appparamter')->name('appparamter');
    Route::post('/storeappparameter', 'storeappparameter')->name('storeappparameter');
    Route::get('/testframe', 'testframe')->name('testframe');
    Route::post('/testframeadd', 'testframeadd')->name('testframeadd');
    Route::delete('/testframedelete', 'testframedelete')->name('testframedelete');
});

// PersonalCategoryController routes
Route::get('/test', [PersonalCategoryController::class, 'test'])->name('test');

// ScreenshotController routes
Route::controller(ScreenshotController::class)->group(function () {
    Route::get('/nirali', 'takeScreenshot')->name('nirali');
    Route::get('/testing', 'testing')->name('testing');
    Route::get('/msgtesting', 'msgtesting')->name('msgtesting');
    Route::get('/addBottomFramee', 'addBottomFramee')->name('addBottomFramee');


});

// Additional routes
Route::get('/get-categories', [createimageController::class, 'getCategories']);

