<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobSearcheController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostActionController;
use App\Http\Controllers\PostingsController;


Route::get('/', [UserController::class, 'index'])->name('users.index');
Route::get('/register', [UserController::class, 'create'])->name('users.create');
Route::get('create', [PostingsController::class, 'create'])->name('posting.create');
Route::get('/employer/search', [PostingsController::class, 'search'])->name('posting.ss');
Route::get('/candidate/search', [CandidateController::class, 'search'])->name('candidate.search');
Route::post('/auth', [AuthController::class, 'check'])->name('auth.check');
Route::get('/auth/index', [AuthController::class, 'index'])->name('auth.index');
Route::post('/logout', [EmployerController::class, 'logout'])->name('employer.logout');
Route::post('/auth/{id}', [EmployerController::class, 'index'])->name('employer.index');
Route::get('/candidate/portfolio/{id}', [CandidateController::class, 'portfolio'])->name('portfolio');
Route::get('/portfolio/{id}/admin', [AdminController::class, 'portfolio'])->name('admin.portfolio');
Route::get('/portfolio/{id}/admin/myPortfolio', [AdminController::class, 'specificPortfolio'])->name('admin.specific.portfolio');
Route::post('notification/{id}', [ApplicationController::class, 'store'])->name('application.store');
Route::get('notification', [ApplicationController::class, 'show'])->name('application.show');
Route::post('/{application}/applications/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
Route::post('/applications/{id}/refuse', [ApplicationController::class, 'refuse'])->name('applications.refuse');
Route::get('/{postId}/applications/search', [ApplicationController::class, 'search'])->name('application.search');
Route::apiResource('/users', UserController::class);
Route::apiResource('employer', EmployerController::class);
Route::apiResource('candidate', CandidateController::class);
// Route::apiResource('posting', PostingsController::class);
Route::post('/like', [PostActionController::class, 'like'])->name('like');
Route::post('/comment', [PostActionController::class, 'comment'])->name('comment');
Route::post('/share', [PostActionController::class, 'share'])->name('share');
Route::post('/posting/store', [PostingsController::class, 'store'])->name('posting.store');
Route::delete('/posting/{id}/delete', [PostingsController::class, 'destroy'])->name('posting.destroy');
// web.php
Route::get('/profile/edit', [CandidateController::class, 'edit'])->name('profile.edit');
Route::put('/profile/canndidate/update', [CandidateController::class, 'update_profile'])->name('profile.update');
Route::get('/notifications/{id}/candidate', [NotificationController::class, 'candidateShow'])->name('notifications.show');
Route::get('/notifications/employer/{id}', [NotificationController::class, 'employerShow'])->name('notifications.employer');
// Route::post('/notifications/{id}/read', [CandidateController::class, 'markAsRead']);
Route::get('/notifications/number/test/count', [CandidateController::class, 'count'])->name('count');
Route::get('/posting/{jobId}/notification/{notificationId}', [PostingsController::class, 'open'])->name('posting.open');
Route::get('/posting/{jobId}/list/admin', [PostingsController::class, 'list'])->name('posting.list');
Route::get('/posting/{jobId}/app', [PostingsController::class, 'application'])->name('posting.application');
Route::get('/posting/{id}/edit', [PostingsController::class, 'edit'])->name('posting.edit');
Route::put('/posting/update/{id}', [PostingsController::class, 'update'])->name('posting.update');
Route::put('/admin/update/{id}', [AdminController::class, 'post_update'])->name('admin.post.update');
Route::get('/admin/{id}/edit/post', [AdminController::class, 'post_edit'])->name('admin.post.edit');
Route::get('/application/notifiy/{id}', [ApplicationController::class, 'app'])->name('application.app');
Route::get('/employer/test/edit', [EmployerController::class, 'edit'])->name('employer.edit');
Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/edit/portfolio', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/edit/portfolio/updated', [AdminController::class, 'update'])->name('admin.update');

Route::put('/admin/posts/accept/{id}', [AdminController::class, 'accept'])->name('admin.posts.accept');
Route::put('/admin/posts/refuse/{id}', [AdminController::class, 'refuse'])->name('admin.posts.refuse');


// Route::middleware('auth')->group(function () {
//     Route::get('/chat/{receiverId}', [MessageController::class, 'index'])->name('chat.index');
//     Route::get('/chat/messages/{userId}', [MessageController::class, 'fetchMessages'])->name('chat.fetchMessages');
//     Route::post('/chat/send', [MessageController::class, 'sendMessage'])->name('chat.sendMessage');
// });

Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
Route::get('/chat/{user}', [MessageController::class, 'show'])->name('chat.show');
Route::post('/chat/{user}/send', [MessageController::class, 'send'])->name('chat.send');

Route::get('/admin/delete/{comment_id}/comment', [AdminController::class, 'delete_comment'])->name('admin.delete.comment');
Route::get('/admin/block/{user_id}', [AdminController::class, 'block'])->name('admin.block');

Route::get('/admin/change-password', [AdminController::class, 'showChangePasswordForm'])->name('admin.password.change');
Route::post('/admin/change-password/updated', [AdminController::class, 'changePassword'])->name('admin.password.update');

Route::get('/user/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.password.change');
Route::post('/user/change-password/updated', [userController::class, 'changePassword'])->name('user.password.update');

Route::get('/candidate/change/password', [CandidateController::class, 'showChangePasswordForm'])->name('candidate.password.change');
Route::post('/candidate/change-password/updated', [CandidateController::class, 'changePassword'])->name('candidate.password.update');

Route::get('/employer/change/password', [EmployerController::class, 'showChangePasswordForm'])->name('employer.password.change');
Route::post('/employer/change-password/updated', [EmployerController::class, 'changePassword'])->name('employer.password.update');

Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
Route::get('/applications/edit/{application}', [ApplicationController::class, 'edit'])->name('applications.edit');
Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');

Route::get('/admin/ss/search', [AdminController::class, 'search'])->name('admin.search');
Route::get('/postings/application/acceptance/{jobId}/{notificationId}', [EmployerController::class, 'notifyAcceptance'])->name('employer.acceptance');

Route::get('/about',[CandidateController::class,'about'])->name('about');












// Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
// // routes/web.php
// Route::post('/notifications/read', [NotificationController::class, 'markAsRead']);

// Route to show notification details

// Route to mark notification as read
// Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
// Route to mark notification as read
