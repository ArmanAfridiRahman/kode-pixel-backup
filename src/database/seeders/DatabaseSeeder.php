<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Core\Setting;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Admin\FrontendSeeder;
use Database\Seeders\Admin\MailSeeder;
use Database\Seeders\Admin\PaymentMethodSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\SeoSeeder;
use Database\Seeders\Admin\SmsSeeder;
use Database\Seeders\Admin\TemplateSeeder;
use Database\Seeders\Core\LangSeeder;
use Database\Seeders\Core\SettingsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SettingsSeeder::class,
            LangSeeder::class,
            RoleSeeder::class,
            PaymentMethodSeeder::class,
            TemplateSeeder::class,
            SmsSeeder::class,
            MailSeeder::class,
            FrontendSeeder::class,
            SeoSeeder::class
  
        ]);
    }
}
