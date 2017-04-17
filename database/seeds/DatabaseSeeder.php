<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('users')->insert([
            'name' => 'Usuário da Rede Social',
            'email' => 'user@social.com',
            'password' => bcrypt('password'),
            'remember_token' => str_random(100),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        $faker = Faker\Factory::create();
        for ($i=0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'password' => bcrypt('secret'),
                'remember_token' => str_random(100),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }

        for ($i=0; $i < 10; $i++) {
            DB::table('friends')->insert([
                'user0_id' => 1,
                'user1_id' => 2+$i,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
        }

        for ($i=0; $i < 10; $i++) {
            DB::table('posts')->insert([
                'title' => $faker->name,
                'text' => $faker->text(500),
                'user_id' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

            for ($j=0; $j < 5; $j++) {
                DB::table('comments')->insert([
                    'text' => $faker->text(150),
                    'post_id' => 1+$i,
                    'user_id' => 2+$j,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
            }
        }


    }
}
