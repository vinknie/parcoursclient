<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Create user (only accessible by admin)
    Route::middleware(['auth', 'CheckRole'])->group(function () {
        Route::get('/dashboard/createUser', [ProfileController::class, 'createUser'])->name('admin.createUser');
        Route::post('/dashboard/storeUser', [ProfileController::class, 'storeUser'])->name('admin.storeUser');
    });

    // Category routes
    Route::get('/dashboard/createCategory', [CategoryController::class, 'createCategory'])->name('admin.createCategory');
    Route::get('/dashboard/category', [CategoryController::class, 'category'])->name('admin.category');
    Route::get('/dashboard/verbatim', [CategoryController::class, 'verbatim'])->name('admin.verbatim');
    Route::post('/dashboard/createCategory/createCat', [CategoryController::class, 'createCat']);
    Route::post('/dashboard/createCategory/createVerba', [CategoryController::class, 'createVerba']);
    Route::get('/dashboard/category/editcategory/{id_category}', [CategoryController::class, 'editCategory'])->name('admin.editCategory');
    Route::post('/dashboard/category/updatecategory/{id_category}', [CategoryController::class, 'updateCat'])->name('admin.updateCat');
    Route::post('/dashboard/category/updateVerbatim', [CategoryController::class, 'updateVerba'])->name('admin.updateVerba');
    Route::get('/dashboard/category/editverbatim', [CategoryController::class, 'editVerbatimWithoutCat'])->name('admin.verbatimsWithoutCategory');
    Route::post('/dashboard/category/updateVerbatimWithoutCat', [CategoryController::class, 'updateVerbatimWithoutCat'])->name('admin.updateVerbatimWithoutCat');

    Route::post('/dashboard/createCategory/createDialogue', [CategoryController::class, 'createDialogue']);
  

    Route::get('/dashboard/note/{id_category}', [NoteController::class, 'show'])->name('admin.noteVerba');

    Route::patch('/dashboard/updatepositif/{id_verbatim}', [NoteController::class, 'updatepositif'])->name('admin.updatepositif');
    Route::patch('/dashboard/updateneutre/{id_verbatim}', [NoteController::class, 'updateneutre'])->name('admin.updateneutre');
    Route::patch('/dashboard/updatenegatif/{id_verbatim}', [NoteController::class, 'updatenegatif'])->name('admin.updatenegatif');
    Route::patch('/dashboard/decreasepositif/{id_verbatim}', [NoteController::class, 'decreasepositif'])->name('admin.decreasepositif');
    Route::patch('/dashboard/decreaseneutre/{id_verbatim}', [NoteController::class, 'decreaseneutre'])->name('admin.decreaseneutre');
    Route::patch('/dashboard/decreasenegatif/{id_verbatim}', [NoteController::class, 'decreasenegatif'])->name('admin.decreasenegatif');

    Route::post('/dashboard/category/update-category-positions', [CategoryController::class, 'updateCategoryPositions'])->name('admin.updateCategoryPositions');

    Route::post('/dashboard/note/update-verbatim-positions', [NoteController::class, 'updatePositionVerba'])->name('admin.updatePositionVerba');


});
// test
Route::get('/chart/full', [DashboardController::class, 'fullChart'])->name('fullChart');

require __DIR__ . '/auth.php';
