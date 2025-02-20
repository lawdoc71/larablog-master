<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;


/**
 * FRONTEND ROUTES
 */
Route::get('/',[BlogController::class,'index'])->name('home');
Route::get('/post/{slug}',[BlogController::class,'readPost'])->name('read_post');
Route::get('/posts/category/{slug}',[BlogController::class,'categoryPosts'])->name('category_posts');
Route::get('/posts/author/{username}',[BlogController::class,'authorPosts'])->name('author_posts');
Route::get('/posts/tag/{any}',[BlogController::class,'tagPosts'])->name('tag_posts');
Route::get('/search',[BlogController::class,'searchPosts'])->name('search_posts');

Route::get('/contact',[BlogController::class,'contactPage'])->name('contact');
Route::post('/contact',[BlogController::class,'sendEmail'])->name('send_email');

Route::get('/{slug}',[BlogController::class,'showPage'])->name('show_page');

/**
 * ADMIN ROUTES
 */
Route::prefix('admin')->name('admin.')->group(function(){
     Route::middleware(['guest','preventBackHistory'])->group(function(){
         Route::controller(AuthController::class)->group(function(){
            Route::get('/login','loginForm')->name('login');
            Route::post('/login','loginHandler')->name('login_handler');
            Route::get('/forgot-password','forgotForm')->name('forgot');
            Route::post('/send-password-reset-link','sendPasswordResetLink')->name('send_password_reset_link');
            Route::get('/password/reset/{token}','resetForm')->name('reset_password_form');
            Route::post('/reset-password-handler','resetPasswordHandler')->name('reset_password_handler');
         });
     });

     Route::middleware(['auth','preventBackHistory'])->group(function(){
        Route::controller(AdminController::class)->group(function(){
            Route::get('/dashboard','adminDashboard')->name('dashboard');
            Route::post('/logout','logoutHandler')->name('logout');
            Route::get('/profile','profileView')->name('profile');
            Route::post('/update-profile-picture','updateProfilePicture')->name('update_profile_picture');

            Route::middleware(['onlySuperAdmin'])->group(function(){
                Route::get('/settings','generalSettings')->name('settings');
                Route::post('/update-logo','updateLogo')->name('update_logo');
                Route::post('/update-favicon','updateFavicon')->name('update_favicon');
                Route::get('/categories','categoriesPage')->name('categories');
                Route::get('/slider','manageSlider')->name('slider');
            });
        });

        Route::controller(PostController::class)->group(function(){
            Route::get('/post/new','addPost')->name('add_post');
            Route::post('/post/create','createPost')->name('create_post');
            Route::get('/posts','allPosts')->name('posts');
            Route::get('/post/{id}/edit','editPost')->name('edit_post');
            Route::post('/post/update','updatePost')->name('update_post');
        });

        Route::controller(PageController::class)->group(function(){
            Route::get('/page/new','addPage')->name('add_page');
            Route::post('/page/create','createPage')->name('create_page');
            Route::get('/pages','allPages')->name('pages');
            Route::get('/page/{id}/edit','editPage')->name('edit_page');
            Route::post('/page/update','updatePage')->name('update_page');
        });

     });
});

/**
 * * fallback route for non-existing routes
 * Add a back or home button for user to return to defined route.
 * Add a error page....
 */
Route::fallback(function() {
    return "Sorry. We do not know what you are looking for.";
});
