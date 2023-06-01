<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class setAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:set {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = [
            'name' => 'Admin',
            'role' => '1',
            'email' => $email,
            'password' => Hash::make($password)
        ];
        User::create($user);
        echo "Admin set up successfully";
    }
}
