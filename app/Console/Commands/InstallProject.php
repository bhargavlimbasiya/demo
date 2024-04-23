<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Controller;

class InstallProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install-project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Migrations, seeders and create admin';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->runMigrations();
        $this->runSeeders();
        $this->createAdmin();
    }

    public function runMigrations()
    {
        $confirm = $this->ask('Do you want to run all migrations? Yes/No');
        if ($confirm == 'Yes' || $confirm == 'yes' || $confirm == 'y' || $confirm == 'Y') {
            $this->call('migrate');
        }
    }

    public function runSeeders()
    {
        $confirm = $this->ask('Do you want to run all Seeders? Yes/No');
        if ($confirm == 'Yes' || $confirm == 'yes' || $confirm == 'y' || $confirm == 'Y') {
            $this->call('db:seed');
        }
    }

    public function createAdmin()
    {
        $name = $this->ask('Provide name');
        $email = $this->ask('Provide email ');
        $phone = $this->ask('Provide Phone Number');
        $password = $this->ask('Provide password ');

        $adminUser = new Controller();
        $response = $adminUser->createAdminUser([
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone,
            'password' => $password
        ]);

        if ($response['status']) {
            foreach ($response['message'] as $message) {
                $this->info($message);
                $this->newLine();
            }
        } else {
            foreach ($response['message'] as $message) {
                $this->error($message);
                $this->newLine();
            }
        }
    }
}
