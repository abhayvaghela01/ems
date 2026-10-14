<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\userPayslipController;
use App\Http\Controllers\UserProjectController;

// Main Page Route
Route::get('/', [Analytics::class, 'index'])->name('dashboard-analytics');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic')->middleware('guest');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic')->middleware('guest');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// 
Route::post('/auth/register-basic', [RegisterBasic::class, 'store']);
Route::post('/auth/login-basic', [LoginBasic::class, 'authenticate']);
Route::post('/logout', [LoginBasic::class, 'logout'])->middleware('auth');

// todo
Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
Route::middleware(['auth'])->group(function () {
  Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
  Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
  Route::post('/todos/{todo}/toggle-status', [TodoController::class, 'toggleStatus'])->name('todos.toggle-status');
  Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
  Route::put('/todos/{todo}', [TodoController::class, 'update']);
  Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
  Route::get('/todos/filter', [TodoController::class, 'filter'])->name('todos.filter');
});

//notes
Route::middleware(['auth'])->group(function () {
  Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
  Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
  Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
  Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
  Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
  // Route::post('/notes/destroySelected', [NoteController::class, 'destroySelected'])->name('notes.destroySelected');
});

//users

Route::middleware(['auth', 'role:admin|hr'])->group(function () {
  Route::get('/users', [UserController::class, 'index'])->name('users.index');
  Route::get('/users-search', [UserController::class, 'search'])->name('users.search');
  Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
  Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// payslips

Route::middleware(['auth', 'role:hr|admin'])->group(function () {
  Route::get('/payslips', [PayslipController::class, 'index'])->name('payslips.index');
  Route::get('/payslips-search', [PayslipController::class, 'search'])->name('payslip.search');
  Route::get('/payslips/create', [PayslipController::class, 'create'])->name('payslips.create');
  Route::post('/payslips', [PayslipController::class, 'store'])->name('payslips.store');
  Route::get('/payslips/{payslip}/edit', [PayslipController::class, 'edit'])->name('payslips.edit');
  Route::put('/payslips/{payslip}', [PayslipController::class, 'update'])->name('payslips.update');
  Route::delete('/payslips/{payslip}', [PayslipController::class, 'destroy'])->name('payslips.destroy');
});

// user payslip
Route::get('/payslip', [userPayslipController::class, 'index'])->name('userPayslip.index');

// Project
Route::middleware(['auth', 'role:hr|admin'])->group(function () {
  Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
  Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
  Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
  Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
  Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
  Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
  Route::get('/projects/filter', [ProjectController::class, 'filter'])->name('projects.filter');
});

// user Project
Route::middleware(['auth'])->group(function () {
  Route::get('/project', [UserProjectController::class, 'index'])->name('userProject.index');
  Route::get('/project/{id}/update-status', [UserProjectController::class, 'updateStatus'])->name('userProject.update');
});

Route::post('/notifications/{notification}/mark-as-read', [ProjectController::class, 'markAsRead']);
