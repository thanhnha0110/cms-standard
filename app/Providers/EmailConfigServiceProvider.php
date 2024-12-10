<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EmailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $config = $this->app->make('config');

            $config->set([
                'mail' => array_merge($config->get('mail'), [
                    'default' => setting('mailer', $config->get('mail.default')),
                    'from' => [
                        'address' => setting('sender_email', $config->get('mail.from.address')),
                        'name' => setting('sender_name', $config->get('mail.from.name')),
                    ],
                    'stream' => [
                        'ssl' => [
                            'allow_self_signed' => true,
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        ],
                    ],
                ]),
            ]);

            switch (setting('mailer', $config->get('mail.default'))) {
                case 'smtp':
                    $config->set([
                        'mail.mailers.smtp' => array_merge($config->get('mail.mailers.smtp'), [
                            'transport' => 'smtp',
                            'host' => setting('smtp_host', $config->get('mail.mailers.smtp.host')),
                            'port' => (int)setting('smtp_port', $config->get('mail.mailers.smtp.port')),
                            'encryption' => setting('smtp_encryption', $config->get('mail.mailers.smtp.encryption')),
                            'username' => setting('smtp_username', $config->get('mail.mailers.smtp.username')),
                            'password' => setting('smtp_password', $config->get('mail.mailers.smtp.password')),
                        ]),
                    ]);

                    break;
                case 'ses':
                    $config->set([
                        'services.ses' => [
                            'key' => setting('ses_key', $config->get('services.ses.key')),
                            'secret' => setting('ses_secret', $config->get('services.ses.secret')),
                            'region' => setting('ses_region', $config->get('services.ses.region')),
                        ],
                    ]);

                    break;
            }
        });
    }
}