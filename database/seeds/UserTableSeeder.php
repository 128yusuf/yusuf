<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = $this->getUsers();
        foreach($users as $key =>  $value) {
            \App\User::updateOrCreate(
                [ 'username' => $value['username'] ],
                $value
            );
        }
    }

    protected function getUsers() {
        $currency = config('constant.currency');
        $roles = config('constant.roles');
        return [
            [
                'name' => 'Shop1',
                'email' => 'shop1@devrepublic.nl',
                'role' => $roles['Shop'],
                'username' => 'shop1',
                'language' => 'en',
                'currency' => $currency['USD'],
                'password' => bcrypt('devhero'),
                'active' => true,

            ],[
                'name' => 'Shop2',
                'email' => 'shop2@devrepublic.nl',
                'role' => $roles['Shop'],
                'username' => 'shop2',
                'language' => 'en',
                'currency' => $currency['USD'],
                'password' => bcrypt('devhero'),
                'active' => true,

            ],[
                'name' => 'User1',
                'email' => 'user1@devrepublic.nl',
                'role' => $roles['User'],
                'username' => 'user1',
                'language' => 'en',
                'currency' => $currency['USD'],
                'password' => bcrypt('devhero'),
                'active' => true,

            ],[
                'name' => 'User2',
                'email' => 'user2@devrepublic.nl',
                'role' => $roles['User'],
                'username' => 'user2',
                'language' => 'nl',
                'currency' => $currency['EUR'],
                'password' => bcrypt('devhero'),
                'active' => true,

            ],
        ];
    }
}
