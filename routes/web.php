<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Redirect to profile for non-admin and non-manager users

Route::get('/dashboard', function () {

    if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'manager') {

        return redirect()->route('home');

    }

    return redirect()->route('admin.category');

})->middleware(['auth', 'verified'])->name('dashboard.redirect');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Create user (only accessible by admin)
    Route::middleware(['auth', 'CheckRole'])->group(function () {
        Route::get('/dashboard/createUser', [ProfileController::class, 'createUser'])->name('admin.createUser');
        Route::post('/dashboard/storeUser', [ProfileController::class, 'storeUser'])->name('admin.storeUser');
        // admin user list / edit page route
        Route::get('/dashboard/user-list', [ProfileController::class, 'getUsers'])->name('admin.getUsers');
        Route::get('/dashboard/user-list/edit/{id_user}', [ProfileController::class, 'editUser'])->name('admin.editUser');
        Route::post('/dashboard/user-list/update/{id_user}', [ProfileController::class, 'updateUser'])->name('admin.updateUser');
        Route::get('/dashboard/user-list/delete/{id_user}', [ProfileController::class, 'deleteUser'])->name('admin.deleteUser');
        Route::get('/dashboard/user-list/restore/{id_user}', [ProfileController::class, 'restoreUser'])->name('admin.restoreUser');
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


    Route::get('dashboard/category/deletecategory/{id_category}', [CategoryController::class, 'deleteCat'])->name('admin.deleteCat');

    Route::delete('dashboard/category/deleteVerba/{id_verbatim}', [CategoryController::class, 'deleteVerba'])->name('admin.deleteVerba');

    Route::get('/dashboard/createCategory/createDialogue/getVerbatim/{id_category}', [CategoryController::class, 'getVerbatim'])->name('getVerbatim');

    Route::get('/dashboard/note/{id_category}', [NoteController::class, 'show'])->name('admin.noteVerba');

    Route::patch('/dashboard/updatepositif/{id_verbatim}', [NoteController::class, 'updatepositif'])->name('admin.updatepositif');
    Route::patch('/dashboard/updateneutre/{id_verbatim}', [NoteController::class, 'updateneutre'])->name('admin.updateneutre');
    Route::patch('/dashboard/updatenegatif/{id_verbatim}', [NoteController::class, 'updatenegatif'])->name('admin.updatenegatif');
    Route::patch('/dashboard/decreasepositif/{id_verbatim}', [NoteController::class, 'decreasepositif'])->name('admin.decreasepositif');
    Route::patch('/dashboard/decreaseneutre/{id_verbatim}', [NoteController::class, 'decreaseneutre'])->name('admin.decreaseneutre');
    Route::patch('/dashboard/decreasenegatif/{id_verbatim}', [NoteController::class, 'decreasenegatif'])->name('admin.decreasenegatif');

    Route::post('/dashboard/category/update-category-positions', [CategoryController::class, 'updateCategoryPositions'])->name('admin.updateCategoryPositions');



    Route::post('/dashboard/note/update-verbatim-positions', [NoteController::class, 'updatePositionVerba'])->name('admin.updatePositionVerba');

    Route::post('/dashboard/note/get-dialogues', [NoteController::class, 'getDialogues']);
    Route::patch('/dashboard/resetvalues/{id_verbatim}', [NoteController::class, 'resetValues'])->name('admin.resetvalues');


    Route::delete('/dashboard/note/deleteDialogue/{id_dialogue}', [NoteController::class, 'deleteDialogue']);



    // historique routes
    Route::get('/dashboard/historique', [HistoriqueController::class, 'getHistorique'])->name('admin.historique');
    Route::get('/dashboard/historique/fetchChart/{month_year}', [HistoriqueController::class, 'getHistoriqueyByMonth'])->name('admin.historiqueByMonth');

    // chart
    Route::get('/chart/full', [DashboardController::class, 'fullChart'])->name('fullChart');
    // chart modal popup route
    Route::get('/fullchart/popup/{id_verbatim}', [DashboardController::class, 'popup_chart'])->name('fullchart.popup');
    // test chart
    Route::get('/chart/fulltest', [DashboardController::class, 'test'])->name('fullcharttest');

    // Event Route
    Route::get('/dashboard/createEvent', [EventController::class, 'createEvent'])->name('admin.createEvent');
    Route::post('/dashboard/storeEvent', [EventController::class, 'storeEvent'])->name('admin.storeEvent');
    Route::get('/dashboard/event', [EventController::class, 'getEvent'])->name('admin.getEvent');
    Route::post('/dashboard/event/{id}', [EventController::class, 'updateEvent'])->name('admin.updateEvent');
    Route::delete('/dashboard/event/{id}', [EventController::class, 'deleteEvent'])->name('admin.deleteEvent');


    // Home Route
    Route::get('/accueil', [HomeController::class, 'index'])->name('home');
    Route::post('/submit-event', [HomeController::class, 'submitEvent'])->middleware(['auth', 'verified'])->name('submitEvent');

    // Satisfaction Route
    Route::get('/satisfaction', [HomeController::class, 'satisfaction'])->middleware('auth')->name('satisfaction');
    Route::patch('/satisfaction/updatepositif/{id_verbatim}', [HomeController::class, 'updatepositif'])->name('satisfaction.updatepositif');
    Route::patch('/satisfaction/updateneutre/{id_verbatim}', [HomeController::class, 'updateneutre'])->name('satisfaction.updateneutre');
    Route::patch('/satisfaction/updatenegatif/{id_verbatim}', [HomeController::class, 'updatenegatif'])->name('satisfaction.updatenegatif');

    Route::get('/dashboard/result', [ResultController::class, 'index'])->name('admin.result');
    Route::get('/admin/result/categories', [ResultController::class, 'getCategories']);

});

Route::fallback(function () {
    return view('admin.page-not-found');
});

require __DIR__ . '/auth.php';
