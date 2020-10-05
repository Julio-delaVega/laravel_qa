<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
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
        factory(Question::class, rand(2, 5))->make()
      )
      ->each(function($question) {
        $question->answers()->saveMany(
          factory(Answer::class, rand(2, 5))->make()
        );
      });
    }
  }
}
