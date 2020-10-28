<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    \DB::table('users')->insert([
      [
        'name' => 'Julio (Admin)',
        'email' => 'julio_1796@hotmail.com',
        'email_verified_at' => now(),
        'password' => Hash::make('secretpassword'),
        'role_id' => 0,
        'remember_token' => Str::random(10),
        'created_at' => now(),
        'updated_at' => now()
      ],
      [
        'name' => 'Julio (User)',
        'email' => 'invitado@hotmail.com',
        'email_verified_at' => now(),
        'password' => Hash::make('secretpassword'),
        'role_id' => 1,
        'remember_token' => Str::random(10),
        'created_at' => now(),
        'updated_at' => now()
      ]
    ]);

    factory(User::class, 5)->create();

    foreach(User::all() as $user)
    {
      $user->questions()->saveMany(
        factory(Question::class, rand(1, 3))->make()
      )
      ->each(function($question) {
        $question->answers()->saveMany(
          factory(Answer::class, rand(0, 3))->make()
        );
      });
    }
  }
}
