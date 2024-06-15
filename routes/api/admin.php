<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\BinderyAttributeController;
use App\Http\Controllers\BinderyAttributeOptionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NormalAttributeController;
use App\Http\Controllers\NormalAttributeOptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialRecordController;
use App\Http\Controllers\ProductTagController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\SocialLinkesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [AdminController::class, 'Login']);
Route::post('/add_state', [StateController::class, 'Create']);
Route::post('/active_or_not_state', [StateController::class, 'ActiveOrNot']);
Route::delete('/delete_state', [StateController::class, 'Delete']);
Route::get('/show_one_state', [StateController::class, 'ShowById']);
Route::get('/show_states', [StateController::class, 'ShowAll']);
Route::post('/update_state', [StateController::class, 'Update']);


Route::post('/add_category', [CategoryController::class, 'Create']);
Route::post('/active_or_not_category', [CategoryController::class, 'ActiveOrNot']);
Route::delete('/delete_category', [CategoryController::class, 'Delete']);
Route::get('/show_one_category', [CategoryController::class, 'ShowById']);
Route::get('/show_categories', [CategoryController::class, 'ShowAll']);
Route::post('/update_category', [CategoryController::class, 'Update']);
Route::post('/update_category_attributes', [CategoryController::class, 'UpdateCategoryAttributes']);

Route::post('/add_product', [ProductController::class, 'Create']);
Route::post('/active_or_not_product', [ProductController::class, 'ActiveOrNot']);
Route::delete('/delete_product', [ProductController::class, 'Delete']);
Route::post('/update_product', [ProductController::class, 'Update']);
Route::post('/change_quantity_price', [ProductController::class, 'UpdateQuantityPrice']);
Route::post('/add_product_images', [ProductController::class, 'AddExtraImages']);
Route::delete('/delete_product_image', [ProductController::class, 'DeleteProductImage']);


Route::post('/add_bindery_att', [BinderyAttributeController::class, 'Create']);
Route::get('/show_one_bindery_att', [BinderyAttributeController::class, 'ShowById']);
Route::post('/update_bindery_att', [BinderyAttributeController::class, 'Update']);
Route::get('/show_bindery_atts', [BinderyAttributeController::class, 'ShowAll']);
Route::delete('/delete_bindery_att', [BinderyAttributeController::class, 'Delete']);


Route::post('/add_normal_att', [NormalAttributeController::class, 'Create']);
Route::get('/show_one_normal_att', [NormalAttributeController::class, 'ShowById']);
Route::post('/update_normal_att', [NormalAttributeController::class, 'Update']);
Route::get('/show_normal_atts', [NormalAttributeController::class, 'ShowAll']);
Route::delete('/delete_normal_att', [NormalAttributeController::class, 'Delete']);


Route::get('/show_permissions', [AdminController::class, 'ShowAllPermission']);


Route::group(['middleware' => ['auth:Admin', 'scope:Admin']], function () {
    Route::controller(AdminController::class)->group(function () {
        Route::post('/add_admin', 'Create');
        Route::delete('/delete_admin', 'DeleteById');
        Route::post('/active_or_not_admin', 'ActiveOrNot');
        Route::get('/show_one_admin', 'ShowById');
        Route::get('/show_admin_permissions', 'ShowAdminPermissions');
        Route::post('/update_admin_permissions', 'UpdateAdminPermissions');
        Route::get('/show_admins', 'ShowAll');
        Route::post('/update_admin', 'Update');
        Route::post('/logout', 'Logout');
        //Route::post('/update_password', 'ChangePassword');
    });

    Route::post('/update_homePromo', [SettingController::class, 'UpdateHomePromo']);
    Route::post('/update_aboutUs', [SettingController::class, 'UpdateAboutUs']);
    Route::get('/show_aboutUs', [SettingController::class, 'ShowAboutUs']);
    Route::get('/show_homePromo', [SettingController::class, 'ShowHomePromo']);

    Route::get('/show_paginate_users', [UserController::class, 'show_paginate_users']);
    Route::get('/show_ContactUs', [ContactUsController::class, 'show']);
    Route::delete('/delete_ContactUs', [ContactUsController::class, 'destroy']);
    Route::get('/active_or_not_user', [UserController::class, 'ActiveOrNotUser']);
    Route::delete('/delete_user', [UserController::class, 'Delete']);
    Route::get('/user', [UserController::class, 'show_user']);


    Route::post('/add_bindery_option', [BinderyAttributeOptionController::class, 'Create']);
    Route::post('/update_bindery_option', [BinderyAttributeOptionController::class, 'Update']);
    Route::get('/show_bindery_options', [BinderyAttributeOptionController::class, 'ShowAll']);
    Route::delete('/delete_bindery_option', [BinderyAttributeOptionController::class, 'Delete']);

    Route::post('/add_normal_option', [NormalAttributeOptionController::class, 'Create']);
    Route::post('/update_normal_option', [NormalAttributeOptionController::class, 'Update']);
    Route::get('/show_normal_options', [NormalAttributeOptionController::class, 'ShowAll']);
    Route::delete('/delete_normal_option', [NormalAttributeOptionController::class, 'Delete']);


    Route::get('/ShowSocial', [SocialController::class, 'ShowPlatforms']);
    Route::post('/AddSocial', [SocialController::class, 'AddPlatform']);
    Route::post('/ShowSocialPlatform', [SocialController::class, 'ShowById']);
    Route::post('/UpdateSocialPlatform', [SocialController::class, 'UpdateSocialPlatform']);
    Route::delete('/DeleteSocialPlatform', [SocialController::class, 'destroy']);

    Route::post('/AddSocialLink', [SocialLinkesController::class, 'AddSocialLink']);
    Route::post('/UpdateSocialLink', [SocialLinkesController::class, 'EditSocialLink']);
    Route::delete('/DeleteSocialLink', [SocialLinkesController::class, 'destroy']);

    Route::post('/ChangePassword', [PasswordController::class, 'SelfChangePassword']);
    Route::post('/ChangeAdminPassword', [PasswordController::class, 'ChangeِAdminPassword']);

    Route::post('/add_tag', [TagController::class, 'create']);
    Route::delete('/delete_tag', [TagController::class, 'destroy']);
    Route::post('/update_tag', [TagController::class, 'update']);
    Route::delete('/delete_product_tag', [ProductTagController::class, 'destroy']);


    Route::post('/create_material', [MaterialController::class, 'create']);
    Route::post('/update_material', [MaterialController::class, 'update']);
    Route::get('/show_materials', [MaterialController::class, 'index']);
    Route::get('/show_records_material', [MaterialController::class, 'show']);
    Route::delete('/delete_material', [MaterialController::class, 'destroy']);

    Route::post('/add_material_records', [MaterialRecordController::class, 'create']);

    Route::get('/show_products', [ProductController::class, 'ShowAll']);
    Route::get('/show_one_product', [ProductController::class, 'ShowById']);


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    Route::post('/change_quote_status', [QuoteController::class, 'ChangeQuoteStatus']);
    Route::get('/show_quotes', [QuoteController::class, 'ShowAll']);
    Route::get('/show_one_quote', [QuoteController::class, 'ShowById']);

});
