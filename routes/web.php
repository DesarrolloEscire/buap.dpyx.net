<?php

use App\Models\Answer;
use App\Models\Evaluation;
use App\Models\User;
use App\Synchronizers\AnswerSynchronizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('welcome');

Route::get('/registrarse', \App\Http\Livewire\Users\Register::class)->name('users.register');
Route::post('registrarse/crear', \App\Http\Controllers\Users\RegisterAccountController::class)->name('users.register.store');
Route::post('registrarse/solicitar', \App\Http\Controllers\Users\RequestAccountController::class)->name('users.register.requests');
Route::get('users/{user}/verify', \App\Http\Controllers\Users\VerifyAccountController::class)->name('users.verify');

Route::get('synchronize/answers', function () {
    foreach (Answer::get() as $answer) {
        (new AnswerSynchronizer($answer))->execute();
    }
    return "synchronized";
});


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::prefix('answers')->middleware(['auth', 'verified'])->group(function () {
    Route::get('{answer}/show', \App\Http\Livewire\Answers\Show::class)->name('answers.show');
});



Route::prefix('/course')->middleware(['auth', 'verified'])->group(function () {
    Route::prefix('/panel')->group(function () {
        Route::get('/', function () {
            return redirect()->route('course.panel.home');
        });
        Route::get('/home', \App\Http\Livewire\Courses\Panel\Home::class)->name('course.panel.home');
        Route::get('/progress', \App\Http\Livewire\Courses\Board\Teacher::class)->name("course.panel.progress");
        Route::get('/topics/{topic}', \App\Http\Livewire\Courses\Panel\Topic::class)->name('course.panel.topic.view');
        Route::get('/topics/{topic}/module/{module}', \App\Http\Livewire\Courses\Panel\Module::class)->name('course.panel.module.view');
        Route::get('/topics/{topic}/module/{module}/task/{task}', \App\Http\Livewire\Courses\Panel\Task::class)->name('course.panel.task.view');
    });

    // Board
    Route::prefix('/board')->group(function () {
        Route::get('/', \App\Http\Livewire\Courses\Board\Index::class)->name('course.board.home');
        Route::get('/excel/{search?}/{searchAcademicUnit?}/{userStatus?}', \App\Http\Controllers\Reports\DownloadReaCourseReportController::class)->name('course.board.excel');
        Route::get('/teacher/{teacher_id}/{origin}',\App\Http\Livewire\Courses\Board\Teacher::class)->name('course.board.teacher');
    });

    // Manage
    Route::prefix('/manage')->group(function () {
        // Task activity evidences
        Route::get('/file-evidences/{fileEvidence}', App\Http\Controllers\FileEvidence\Download::class)->name('file-evidences.download');

        // Master view
        Route::get('/{tab?}/{pill?}', \App\Http\Livewire\Courses\Manage\Index::class)->name('course.manage');
        Route::put('/{course}', \App\Http\Controllers\Courses\Manage\UpdateCourseController::class)->name('course.manage.update');


        // Sections
        Route::put('/{section}/section', \App\Http\Controllers\Courses\Manage\ManageSectionController::class)->name('course.manage.section');

        // Consultant
        Route::post('/{course}/consultant', \App\Http\Controllers\Courses\Manage\StoreConsultantController::class)->name('course.manage.consultant.store');
        Route::put('/{course}/consultant/{consultant}', \App\Http\Controllers\Courses\Manage\UpdateConsultantController::class)->name('course.manage.consultant.update');
        Route::patch('/{course}/consultant', \App\Http\Controllers\Courses\Manage\SortConsultantController::class)->name('course.manage.consultant.sort');
        Route::delete('/{course}/consultant/{consultant}', \App\Http\Controllers\Courses\Manage\DeleteConsultantController::class)->name('course.manage.consultant.delete');

        // Topic
        Route::post('/{course}/topic', \App\Http\Controllers\Courses\Manage\StoreTopicController::class)->name('course.manage.topic.store');
        Route::put('/{course}/topic/{topic}', \App\Http\Controllers\Courses\Manage\UpdateTopicController::class)->name('course.manage.topic.update');
        Route::delete('/{course}/topic/{topic}', \App\Http\Controllers\Courses\Manage\DeleteTopicController::class)->name('course.manage.topic.delete');

        // Module
        Route::post('/{course}/topic/{topic}/module', \App\Http\Controllers\Courses\Manage\StoreModuleController::class)->name('course.manage.module.store');
        Route::put('/{course}/topic/{topic}/module/{module}', \App\Http\Controllers\Courses\Manage\UpdateModuleController::class)->name('course.manage.module.update');
        Route::delete('/{course}/topic/{topic}/module/{module}', \App\Http\Controllers\Courses\Manage\DeleteModuleController::class)->name('course.manage.module.delete');

        // Task
        Route::get('/{course}/topic/{topic}/module/{module}/task/{task?}', \App\Http\Livewire\Courses\Manage\Tasks::class)->name('course.manage.task.view');
        Route::post('/{course}/topic/{topic}/module/{module}/task/', \App\Http\Controllers\Courses\Manage\StoreTaskController::class)->name('course.manage.task.store');
        Route::put('/{course}/topic/{topic}/module/{module}/task/{task}', \App\Http\Controllers\Courses\Manage\UpdateTaskController::class)->name('course.manage.task.update');
        Route::delete('/{course}/topic/{topic}/module/{module}/task/{task}', \App\Http\Controllers\Courses\Manage\DeleteTaskController::class)->name('course.manage.task.delete');

        // Task resource
        Route::post('/{course}/topic/{topic}/module/{module}/task/{task}/resource', App\Http\Controllers\Courses\Manage\StoreTaskResourceController::class)->name('course.manage.resource.store');
        Route::put('/{course}/topic/{topic}/module/{module}/task/{task}/resource/{resource}', App\Http\Controllers\Courses\Manage\UpdateTaskResourceController::class)->name('course.manage.resource.update');
        Route::delete('/{course}/topic/{topic}/module/{module}/task/{task}/resource/{resource}', App\Http\Controllers\Courses\Manage\DeleteTaskResourceController::class)->name('course.manage.resource.delete');

        // Task activity
        Route::post('/{course}/topic/{topic}/module/{module}/task/{task}/activity', App\Http\Controllers\Courses\Manage\StoreTaskActivityController::class)->name('course.manage.activity.store');
        Route::put('/{course}/topic/{topic}/module/{module}/task/{task}/activity/{activity}', App\Http\Controllers\Courses\Manage\UpdateTaskActivityController::class)->name('course.manage.activity.update');
        Route::delete('/{course}/topic/{topic}/module/{module}/task/{task}/activity/{activity}', App\Http\Controllers\Courses\Manage\DeleteTaskActivityController::class)->name('course.manage.activity.delete');
        Route::delete('/{course}/topic/{topic}/module/{module}/task/{task}/activity/{activity}/document', App\Http\Controllers\Courses\Manage\DeleteTaskActivityController::class)->name('course.manage.activity.delete.document');
        // Task activity questions
        Route::get('/{course}/topic/{topic}/module/{module}/task/{task}/activity/{activity}/question', \App\Http\Livewire\Courses\Manage\TaskQuestions::class)->name('course.manage.question.view');
        Route::post('/{course}/topic/{topic}/module/{module}/task/{task}/activity/{activity}/question', \App\Http\Controllers\Courses\Manage\StoreTaskActivityQuestionController::class)->name('course.manage.question.store');
        Route::put('/{course}/topic/{topic}/module/{module}/task/{task}/activity/{activity}/question/{question}', \App\Http\Controllers\Courses\Manage\UpdateTaskActivityQuestionController::class)->name('course.manage.question.update');
        Route::delete('/{course}/topic/{topic}/module/{module}/task/{task}/activity/{activity}/question/{question}', \App\Http\Controllers\Courses\Manage\DeleteTaskActivityQuestionController::class)->name('course.manage.question.delete');

        Route::post('/question/{question}/responses', \App\Http\Controllers\Courses\Manage\StoreResponseController::class)->name('course.manage.question.response.store');
    });
});

// Metadta
Route::prefix('metadata')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Http\Livewire\Metadata\Index::class)->name('metadata.index');
    Route::post('/', \App\Http\Controllers\Metadata\Store::class)->name('metadata.store');
    Route::put('/{metadata}', \App\Http\Controllers\Metadata\Update::class)->name('metadata.update');
    Route::delete('/{metadata}', \App\Http\Controllers\Metadata\Delete::class)->name('metadata.delete');
});

Route::prefix('reas')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('course.panel.home');
    })->name('reas.iframe');
    Route::get('/xlearning', \App\Http\Livewire\XLearning\Iframe::class)->name('xlearning.iframe');
});

Route::prefix('recursos-digitales')->middleware(['auth', 'verified'])->group(function (){
    Route::get('/{digitalResource}/metadatos/requeridos', \App\Http\Livewire\DigitalResources\Metadata\Required\Index::class)->name('digital-resources.metadata.required.index');
    Route::get('/{digitalResource}/metadatos/opcionales', \App\Http\Livewire\DigitalResources\Metadata\Optional\Index::class)->name('digital-resources.metadata.optional.index');
    Route::put('/{digitalResource}/metadatos', \App\Http\Controllers\DigitalResources\Metadata\UpdateMetadataController::class)->name('digital-resources.metadata.update');
});

Route::prefix('categories')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Http\Livewire\Categories\Index::class)->middleware('can:index categories')->name('categories.index');
    Route::get('create', \App\Http\Livewire\Categories\Create::class)->middleware('can:create categories')->name('categories.create');
    Route::get('{category}/edit', \App\Http\Livewire\Categories\Edit::class)->middleware('can:edit categories')->name('categories.edit');
    Route::post('/', \App\Http\Controllers\Categories\StoreCategoryController::class)->middleware('can:create categories')->name('categories.store');
    Route::put('{category}', \App\Http\Controllers\Categories\UpdateCategoryController::class)->middleware('can:edit categories')->name('categories.update');
    Route::delete('{category}', \App\Http\Controllers\Categories\DestroyCategoryController::class)->middleware('can:delete categories')->name('categories.destroy');
});

Route::prefix('users')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Http\Livewire\Users\Index::class)->middleware('can:index users')->name('users.index');
    Route::get('create', \App\Http\Livewire\Users\Create::class)->middleware('can:create users')->name('users.create');
    Route::get('account/edit', \App\Http\Livewire\Users\Account\Edit::class)->name('users.account.edit');
    Route::get('{user}/edit', \App\Http\Livewire\Users\Edit::class)->middleware('can:edit users')->name('users.edit');
    Route::get('account', \App\Http\Livewire\Users\Account::class)->name('users.account');
    Route::post('{user}/account', \App\Http\Controllers\Users\StoreAccountController::class)->name('users.account.store');
    Route::post('/', \App\Http\Controllers\Users\StoreUserController::class)->middleware('can:create users')->name('users.store');
    Route::put('{user}', \App\Http\Controllers\Users\UpdateUserController::class)->middleware('can:edit users')->name('users.update');
    Route::delete('{user}', \App\Http\Controllers\Users\DestroyUserController::class)->middleware('can:delete users')->name('users.destroy');
});

Route::prefix('questions')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Http\Livewire\Questions\Index::class)->middleware('can:index questions')->name('questions.index');
    Route::get('create', \App\Http\Livewire\Questions\Create::class)->middleware('can:create questions')->name('questions.create');
    Route::get('{question}/edit', \App\Http\Livewire\Questions\Edit::class)->middleware('can:edit questions')->name('questions.edit');
    Route::get('export', \App\Http\Controllers\Questions\ExportQuestionController::class)->middleware('can:index questions')->name('questions.export');
    Route::post('/', \App\Http\Controllers\Questions\StoreQuestionController::class)->middleware('can:create questions')->name('questions.store');
    Route::put('{question}', \App\Http\Controllers\Questions\UpdateQuestionController::class)->middleware('can:edit questions')->name('questions.update');
    Route::delete('{question}', \App\Http\Controllers\Questions\DestroyQuestionController::class)->middleware('can:delete questions')->name('questions.destroy');
});

Route::prefix('subcategories')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Http\Livewire\Subcategories\Index::class)->middleware('can:index subcategories')->name('subcategories.index');
    Route::get('create', \App\Http\Livewire\Subcategories\Create::class)->middleware('can:create subcategories')->name('subcategories.create');
    Route::get('{subcategory}/edit', \App\Http\Livewire\Subcategories\Edit::class)->middleware('can:edit subcategories')->name('subcategories.edit');
    Route::post('/', \App\Http\Controllers\Subcategories\StoreSubcategoryController::class)->middleware('can:create subcategories')->name('subcategories.store');
    Route::put('{subcategory}', \App\Http\Controllers\Subcategories\UpdateSubcategoryController::class)->middleware('can:edit subcategories')->name('subcategories.update');
    Route::delete('{subcategory}', \App\Http\Controllers\Subcategories\DestroySubcategoryController::class)->middleware('can:delete subcategories')->name('subcategories.destroy');
});

Route::prefix('observations')->middleware(['auth', 'verified'])->group(function () {
    Route::post('store', \App\Http\Controllers\Observations\StoreObservationController::class)->middleware('can:create observations')->name('observations.store');
    Route::get('{observation}/files/{file}/download', \App\Http\Controllers\Observations\Files\DownloadFileController::class)->name('observations.files.download');
    Route::delete('{observation}/store', \App\Http\Controllers\Observations\DeleteObservationController::class)->middleware('can:create observations')->name('observations.delete');
});

Route::prefix('announcements')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Http\Livewire\Announcements\Index::class)->name('announcements.index');
    Route::get('create', \App\Http\Livewire\Announcements\Create::class)->middleware('can:create announcements')->name('announcements.create');
    Route::get('{announcement}/edit', \App\Http\Livewire\Announcements\Edit::class)->middleware('can:edit announcements')->name('announcements.edit');
    Route::post('/', \App\Http\Controllers\Announcements\StoreAnnouncementController::class)->middleware('can:create announcements')->name('announcements.store');
    Route::put('{announcement}', \App\Http\Controllers\Announcements\UpdateAnnouncementController::class)->middleware('can:edit announcements')->name('announcements.update');
    Route::delete('{announcement}', \App\Http\Controllers\Announcements\DestroyAnnouncementController::class)->middleware('can:delete announcements')->name('announcements.destroy');
});

Route::prefix('repositories')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Http\Livewire\Repositories\Index::class)->name('repositories.index');
    Route::get('/{repository}/metadatos/obligatorios', \App\Http\Livewire\Repositories\Show::class)->name('repositories.metadata.required.index');
    Route::get('/{repository}/metadatos/opcionales/{page}', \App\Http\Livewire\Repositories\Metadata\Optional\Index::class)->name('repositories.metadata.optional.index');
    Route::get('/statistics', \App\Http\Livewire\Repositories\Statistics\All::class)->name('repositories.statistics.all');
    Route::get('/{repository}/estadisticas', \App\Http\Livewire\Repositories\Statistics\Show::class)->name('repositories.statistics.show');
    Route::post('/{repository}/enviar', \App\Http\Controllers\Repositories\SendRepositoryController::class)->middleware('can:edit evaluations')->name('repositories.send');
    Route::put('/{repository}/metadata', \App\Http\Controllers\Repositories\Metadata\UpdateMetadataController::class)->name('repositories.metadata.update');
    Route::post('/{repository}/publicar', \App\Http\Controllers\Repositories\Publish::class)->name('repositories.publish');
    Route::get('/{repository}/recursos-digitales', \App\Http\Livewire\Repositories\DigitalResources::class)->name('repositories.digital-resources.index');
    Route::post('/{repository}/recursos-digitales', \App\Http\Controllers\Repositories\DigitalResources\Store::class)->name('repositories.digital-resources.store');
    Route::get('/excel-download/{search}/{search_filter}/{publish_filter}/{evaluator_filter}/{progress_filter}',\App\Http\Controllers\Reports\DownloadRepositoryReportController::class)->name('repositories.download.excel');
    Route::patch('/evaluation-status/{repository}',\App\Http\Controllers\Repositories\EvaluationStatusChangeController::class)->name('repositories.evaluation.status.change');
});

Route::prefix('evaluations')->middleware(['auth', 'verified'])->group(function () {
    Route::get('{evaluation}/categories/{category}/questions', \App\Http\Livewire\Evaluations\Categories\Questions\Index::class)->name('evaluations.categories.questions.index')->middleware('evaluations.categories.questions.index');
    Route::get('{evaluation}/user/{user}/assign', \App\Http\Livewire\Evaluations\Assign::class)->middleware('can:edit evaluations')->name('evaluations.assign');
    Route::get('{evaluation}/pdf', \App\Http\Controllers\Evaluations\ExportEvaluationController::class)->name('evaluations.pdf');
    Route::post('{evaluation}/categories/{category}/questions', \App\Http\Controllers\Evaluations\Categories\Questions\StoreQuestionController::class)->name('evaluations.categories.questions.store');
    Route::post('{evaluation}/send', \App\Http\Controllers\Evaluations\SendEvaluationController::class)->name('evaluations.send');
});

Route::prefix('files')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{file}/download', \App\Http\Controllers\Files\DownloadFileController::class)->name('files.download');
    Route::delete('/{file}/delete', \App\Http\Controllers\Files\DeleteFileController::class)->name('files.delete');
});

Route::prefix('reports')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', \App\Http\Controllers\Reports\DownloadReportController::class)->name('reports.download');
});

Route::prefix('constancies')->middleware(['auth', 'verified'])->group(function () {
    Route::get('edit', \App\Http\Livewire\Constancies\Edit::class)->name('constancies.edit');
    Route::get('show', \App\Http\Controllers\Constancies\ShowConstancyController::class)->name('constancies.pdf');
});

Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

Route::get('/platforms/subjects', function () {
    return redirect()->away(external_route('subjects.index'));
})->middleware(['auth', 'verified']);

Route::get('redirect', function (Request $request) {
    return redirect()->route($request->route, json_decode($request->params));
})->name('autologin');

Route::get('autologin/{identifier}', function (string $identifier) {
    $user = User::whereIdentifier($identifier)->first();
    Auth::login($user);
    return redirect()->route('dashboard');
});
