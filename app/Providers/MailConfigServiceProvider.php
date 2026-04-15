<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Avoid errors during migrations or when table doesn't exist yet
        if (!app()->runningInConsole() || app()->runningUnitTests()) {
            if (Schema::hasTable('system_settings')) {
                $settings = SystemSetting::where('key', 'like', 'mail_%')->get()->keyBy('key');

                if ($settings->has('mail_host') && !empty($settings['mail_host']->value)) {
                    $config = [
                        'transport' => 'smtp',
                        'host'      => $settings['mail_host']->value,
                        'port'      => $settings['mail_port']->value ?? 587,
                        'encryption'=> $settings['mail_encryption']->value === 'null' ? null : ($settings['mail_encryption']->value ?? 'tls'),
                        'username'  => $settings['mail_username']->value ?? null,
                        'password'  => $settings['mail_password']->value ?? null,
                        'timeout'   => null,
                        'auth_mode' => null,
                    ];

                    Config::set('mail.mailers.smtp', array_merge(Config::get('mail.mailers.smtp', []), $config));
                    Config::set('mail.default', 'smtp');

                    if ($settings->has('mail_from_address')) {
                        Config::set('mail.from.address', $settings['mail_from_address']->value);
                    }
                    if ($settings->has('mail_from_name')) {
                        Config::set('mail.from.name', $settings['mail_from_name']->value);
                    }
                }
            }
        }
    }
}
