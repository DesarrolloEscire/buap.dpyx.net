<?php

use App\Models\Course;
use App\Models\Quizz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// dpyx.buap.net/api/test
Route::post('/quizzes/create', function (Request $request) {
    // TODO store the question
    Quizz::updateOrCreate([
        'user_id' => $request->user_id,
        'question' => $request->question
    ], [
        'answer' => $request->answer,
        'answer_description' => $request->answer_description,
        'question_description' => $request->question_description
    ]);
});

Route::post('/courses/start', function (Request $request) {
    Course::firstOrCreate([
        'user_id' => $request->user_id
    ]);
});
