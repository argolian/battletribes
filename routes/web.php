<?php

use App\Http\Controllers\Auth\ActivateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RestoreUserController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\LaravelBlockerController;
use App\Http\Controllers\LaravelBlockerDeletedController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\SoftDeletesController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\ThemesManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersManagementController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

// Homepage Route
Route::group(['middleware' => ['web', 'checkblocked']], function ()
{

    Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');
    Route::get('/terms', [TermsController::class, 'terms'])->name('terms');
});




Route::group([
                 'middleware' => ['web', 'checkblocked'],
                 'as'         => 'laravelblocker.',
             ], function ()
{
    Route::resource('blocker',LaravelBlockerController::class);
    Route::get('blocker-deleted', [LaravelBlockerDeletedController::class, 'index'])->name('blocker-deleted');
    Route::get('blocker-deleted/{id}',[LaravelBlockerDeletedController::class ,'show'])->name('blocker-item-show-deleted');
    Route::put('blocker-deleted/{id}', [LaravelBlockerDeletedController::class ,'restoreBlockedItem'])->name('blocker-item-restore');
    Route::post('blocker-deleted-restore-all', [LaravelBlockerDeletedController::class,'restoreAllBlockedItems'])->name('blocker-deleted-restore-all');
    Route::delete('blocker-deleted/{id}', [LaravelBlockerDeletedController::class,'destroy'])->name('blocker-item-destroy');
    Route::delete('blocker-deleted-destroy-all', [LaravelBlockerDeletedController::class, 'destroyAllItems'])->name('destroy-all-blocked');
    Route::post('search-blocked', [LaravelBlockerController::class,'search'])->name('search-blocked');
    Route::post('search-blocked-deleted', [LaravelBlockerDeletedController::class,'search'])->name('search-blocked-deleted');
});

Route::group(['middleware'=>['web','activity','checkblocked']], function(){

    // Activation Routes
    Route::get('/activate', ['as' => 'activate', 'uses' => [ActivateController::class, 'initial']]);

    Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => [ActivateController::class, 'activate']]);
    Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => [ActivateController::class, 'resend']]);
    Route::get('/exceeded', ['as' => 'exceeded', 'uses' => [ActivateController::class,'exceeded']]);

    // Socialite Register Routes
    Route::get('/social/redirect/{provider}', ['as' => 'social.redirect', 'uses' => [SocialController::class, 'getSocialRedirect']]);
    Route::get('/social/handle/{provider}', ['as' => 'social.handle', 'uses' => [SocialController::class ,'getSocialHandle']]);

    // Route to for user to reactivate their user deleted account.
    Route::get('/re-activate/{token}', ['as' => 'user.reactivate', 'uses' => [RestoreUserController::class. 'userReActivate']]);

});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'checkblocked']], function () {

    // Activation Routes
    Route::get('/activation-required', ['uses' => [ActivateController::class, 'activationRequired']])->name('activation-required');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Registered and Activated User Routes
Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep', 'checkblocked']], function () {

    //  Homepage Route - Redirect based on user role is in controller.
    Route::get('/home', [UserController::class,'index'])->name('home');

    // Show users profile - viewable by other users.
    Route::get('profile/{username}', [
        'as'   => '{username}',
        'uses' => [ProfilesController::class,'show'],
    ]);
});

// Registered, activated, and is current user routes.
Route::group(['middleware' => ['auth', 'activated', 'currentUser', 'activity', 'twostep', 'checkblocked']], function () {

    // User Profile and Account Routes
    Route::resource(
        'profile',
        ProfilesController::class,
        [
            'only' => [
                'show',
                'edit',
                'update',
                'create',
            ],
        ]
    );
    Route::put('profile/{username}/updateUserAccount', [
        'as'   => '{username}',
        'uses' => [ProfilesController::class, 'updateUserAccount'],
    ]);
    Route::put('profile/{username}/updateUserPassword', [
        'as'   => '{username}',
        'uses' => [ProfilesController::class, 'updateUserPassword'],
    ]);
    Route::delete('profile/{username}/deleteUserAccount', [
        'as'   => '{username}',
        'uses' => [ProfilesController::class,'deleteUserAccount'],
    ]);

    // Route to show user avatar
    Route::get('images/profile/{id}/avatar/{image}', [
        'uses' => [ProfilesController::class,'userProfileAvatar'],
    ]);

    // Route to upload user avatar.
    Route::post('avatar/upload', ['as' => 'avatar.upload', 'uses' => [ProfilesController::class,'upload']]);
});

// Registered, activated, and is admin routes.
Route::group(['middleware' => ['auth', 'activated', 'role:admin', 'activity', 'twostep', 'checkblocked']], function () {
    Route::resource('/users/deleted', SoftDeletesController::class, [
        'only' => [
            'index', 'show', 'update', 'destroy',
        ],
    ]);

    Route::resource('users', UsersManagementController::class, [
        'names' => [
            'index'   => 'users',
            'destroy' => 'user.destroy',
        ],
        'except' => [
            'deleted',
        ],
    ]);
    Route::post('search-users', [UsersManagementController::class,'search'])->name('search-users');

    Route::resource('themes', ThemesManagementController::class, [
        'names' => [
            'index'   => 'themes',
            'destroy' => 'themes.destroy',
        ],
    ]);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    Route::get('routes', 'App\Http\Controllers\AdminDetailsController@listRoutes');
    Route::get('active-users', 'App\Http\Controllers\AdminDetailsController@activeUsers');
});

Route::group([
                 'middleware'    => ['web'],
                 'as'            => 'laravelroles::'
             ], function () {

    // Dashboards and CRUD Routes
    Route::resource('roles', 'LaravelRolesController');
    Route::resource('permissions', 'LaravelPermissionsController');

    // Deleted Roles Dashboard and CRUD Routes
    Route::get('roles-deleted', 'LaravelRolesDeletedController@index')->name('roles-deleted');
    Route::get('role-deleted/{id}', 'LaravelRolesDeletedController@show')->name('role-show-deleted');
    Route::put('role-restore/{id}', 'LaravelRolesDeletedController@restoreRole')->name('role-restore');
    Route::post('roles-deleted-restore-all', 'LaravelRolesDeletedController@restoreAllDeletedRoles')->name('roles-deleted-restore-all');
    Route::delete('roles-deleted-destroy-all', 'LaravelRolesDeletedController@destroyAllDeletedRoles')->name('destroy-all-deleted-roles');
    Route::delete('role-destroy/{id}', 'LaravelRolesDeletedController@destroy')->name('role-item-destroy');

    // Deleted Permissions Dashboard and CRUD Routes
    Route::get('permissions-deleted', 'LaravelpermissionsDeletedController@index')->name('permissions-deleted');
    Route::get('permission-deleted/{id}', 'LaravelpermissionsDeletedController@show')->name('permission-show-deleted');
    Route::put('permission-restore/{id}', 'LaravelpermissionsDeletedController@restorePermission')->name('permission-restore');
    Route::post('permissions-deleted-restore-all', 'LaravelpermissionsDeletedController@restoreAllDeletedPermissions')->name('permissions-deleted-restore-all');
    Route::delete('permissions-deleted-destroy-all', 'LaravelpermissionsDeletedController@destroyAllDeletedPermissions')->name('destroy-all-deleted-permissions');
    Route::delete('permission-destroy/{id}', 'LaravelpermissionsDeletedController@destroy')->name('permission-item-destroy');
});


Route::redirect('/php', '/phpinfo', 301);


