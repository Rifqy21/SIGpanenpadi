<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatControllers;
use App\Http\Controllers\AdminChatController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AuthentificationController;


// group route with guest middleware
Route::get('/logout', [AuthentificationController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/', [LandingPageController::class, 'index']);
    Route::get('/login', [AuthentificationController::class, 'login'])->name('login');
    Route::get('/register', [AuthentificationController::class, 'register'])->name('register');
    Route::post('/authLogin', [AuthentificationController::class, 'authLogin'])->name('authLogin');
    Route::post('/authRegis', [AuthentificationController::class, 'authRegis'])->name('authRegis');
});

Route::middleware('auth')->group(function () {
    Route::get('/validateRole', [AuthentificationController::class, 'validateRole'])->name('validateRole');
    Route::get('/chat', [ChatControllers::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatControllers::class, 'send'])->name('chat.send');
    Route::get('/chat/messages', [ChatControllers::class, 'messages'])->name('chat.messages');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user', [UserDashboardController::class, 'index'])->name('user');
    Route::get('/tambah', [UserDashboardController::class, 'tambah'])->name('user.tambah');
    Route::post('/insertPanen', [UserDashboardController::class, 'insertPanen'])->name('insertPanen');
    Route::get('/panen/show/{id}', [UserDashboardController::class, 'show'])->name('panen.show');
    Route::get('/panen/edit/{id}', [UserDashboardController::class, 'edit'])->name('panen.edit');
    Route::put('/panen/update/{id}', [UserDashboardController::class, 'update'])->name('panen.update');
    Route::delete('/panen/delete/{id}', [UserDashboardController::class, 'delete'])->name('panen.delete');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin');
    Route::get('/aduan', [AdminDashboardController::class, 'aduan'])->name('aduan');
    Route::get('/createDataPanen', [AdminDashboardController::class, 'createDataPanen'])->name('createDataPanen');
    Route::post('/insertDataPanen', [AdminDashboardController::class, 'insertDataPanen'])->name('insertDataPanen');
    Route::get('/admin/panen/show/{id}', [AdminDashboardController::class, 'show'])->name('admin.panen.show');
    Route::get('/admin/panen/edit/{id}', [AdminDashboardController::class, 'edit'])->name('admin.panen.edit');
    Route::put('/admin/panen/update/{id}', [AdminDashboardController::class, 'update'])->name('admin.panen.update');
    Route::delete('/admin/panen/delete/{id}', [AdminDashboardController::class, 'delete'])->name('admin.panen.delete');

    Route::get('/admin/user/create', [AdminDashboardController::class, 'createUser'])->name('admin.user.create');
    Route::post('/admin/user/insert', [AdminDashboardController::class, 'insertUser'])->name('admin.user.insert');
    Route::get('/admin/user/edit/{id}', [AdminDashboardController::class, 'editUser'])->name('admin.user.edit');
    Route::put('/admin/user/update/{id}', [AdminDashboardController::class, 'updateUser'])->name('admin.user.update');
    Route::delete('/admin/user/delete/{id}', [AdminDashboardController::class, 'deleteUser'])->name('admin.user.delete');

    Route::get('/admin/chat', [AdminChatController::class, 'index'])->name('admin.chat.index');
    Route::get('/admin/chat/{userId}', [AdminChatController::class, 'viewConversation'])->name('admin.chat.viewConversation');
    Route::get('/admin/chat/messages/{userId}', [AdminChatController::class, 'fetchMessage'])->name('admin.chat.fetchMessage');
    Route::post('/admin/chat/send/{userId}', [AdminChatController::class, 'send'])->name('admin.chat.send');
});
