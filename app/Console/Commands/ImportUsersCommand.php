<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Quizz;
use App\Models\RemoteCourse;
use App\Models\RemoteEvaluation;
use App\Models\RemoteQuizz;
use App\Models\RemoteRepository;
use App\Models\RemoteUser;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:import {identifier?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users to the database from asignaturas.buap.mx';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        RemoteUser::whereNull('identifier')->get()->map(function ($remoteUser) {
            $remoteUser->identifier = Str::random(5);
            $remoteUser->save();
        });

        RemoteUser::get()->map(function ($remoteUser) {

            $role = $remoteUser->roles()->first();

            $user = User::updateOrCreate([
                'identifier' => $remoteUser->identifier,
            ], [
                'email' => $remoteUser->email,
                'name' => $remoteUser->name,
                'phone' => $remoteUser->phone,
                'email_verified_at' => $remoteUser->email_verified_at,
                'password' => $remoteUser->password,
                'remember_token' => $remoteUser->remember_token,
                'profile_photo_path' => $remoteUser->profile_photo_path,
                'last_login_at' => $remoteUser->last_login_at,
            ]);

            if($role){
                $user->assignRole($role->name);
            }
        });

        RemoteRepository::get()->map(function ($remoteRepository) {

            $remoteUser = $remoteRepository->remoteUser;

            try {
                //code...
                Repository::updateOrCreate(
                    [
                        'id' => $remoteRepository->id
                    ],
                    [
                        'name' => $remoteRepository->name,
                        'responsible_id' => $remoteUser->user->id,
                        'status' => $remoteRepository->status
                    ]
                );
            } catch (\Throwable $th) {
                throw $th;
                dd(RemoteUser::find($remoteRepository->responsible_id));
                //throw $th;
            }
        });


        RemoteEvaluation::get()->map(function ($remoteEvaluation) {

            try {
                //code...
                Evaluation::updateOrCreate([
                    'id' => $remoteEvaluation->id
                ], [
                    'repository_id' => $remoteEvaluation->remoteRepository->repository->id,
                    'evaluator_id' => $remoteEvaluation->remoteEvaluator->user->id,
                    'status' => $remoteEvaluation->status,
                ]);
            } catch (\Throwable $th) {
                throw $th;
                dd($remoteEvaluation->remoteRepository);
            }
        });

        RemoteQuizz::get()->map(function ($remoteQuizz) {

            $remoteUser = RemoteUser::find($remoteQuizz->user_id);

            if(!$remoteUser){
                return;
            }

            try {
                //code...
                Quizz::updateOrCreate([
                    'id' => $remoteQuizz->id
                ], [
                    "user_id" => $remoteUser->user->id,
                    "answer" => $remoteQuizz->answer,
                    "answer_description" => $remoteQuizz->answer_description,
                    "question" => $remoteQuizz->question,
                    "question_description" => $remoteQuizz->question_description
                ]);
            } catch (\Throwable $th) {
                // throw $th;
                dd($remoteQuizz);
            }
        });

        RemoteCourse::get()->map(function ($remoteCourse) {

            $remoteUser = RemoteUser::find($remoteCourse->user_id);
            
            Course::updateOrCreate([
                'id' => $remoteCourse->id
            ], [
                'user_id' => $remoteUser->user->id
            ]);
        });

        $this->importDatabase('announcements');
        $this->importDatabase('categories');
        $this->importDatabase('subcategories');
        $this->importDatabase('questions');
        $this->importDatabase('choices');
        $this->importDatabase('answers');
        $this->importDatabase('observations');
        $this->importDatabase('evaluations_history');
        $this->importDatabase('answers_history');
        $this->importDatabase('observations_history');
        $this->importDatabase('sections');

        return 0;
    }

    private function importDatabase(string $name)
    {
        DB::connection('mysql')->table($name)->get()->map(function ($remoteRecord) use ($name) {
            $record = DB::table($name)->where('id', $remoteRecord->id)->first();

            if ($record) {
                return;
            }

            DB::table($name)->insert((array)$remoteRecord);
        });
    }
}
