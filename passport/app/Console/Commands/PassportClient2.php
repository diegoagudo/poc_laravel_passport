<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Laravel\Passport\Passport;

class PassportClient2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:clientv2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a client v2 for issuing access tokens';

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
        $input = [];
        $input['name'] = $this->ask('Qual o nome do "Client" ou Aplicação que irá se integrar?');
        $input['redirect'] = $this->ask('Informe a URL de redirecionamento após o Login');
        $input['redirect_logout'] = $this->ask('Informe a URL de redirecionamento após o Logout');

        if (!filter_var($input['redirect'], FILTER_VALIDATE_URL)) {
            $this->error('Formato da URL de Login inválido.');
            return;
        }
        if (!filter_var($input['redirect_logout'], FILTER_VALIDATE_URL)) {
            $this->error('Formato da URL de Logout inválido.');
            return;
        }

        $clientSecret = Str::random(40);
        $client = Passport::client()->forceFill([
            'name' => $input['name'] ?? null,
            'secret' => $clientSecret,
            'redirect' => $input['redirect'],
            'redirect_logout' => $input['redirect_logout'],
            'personal_access_client' => 0,
            'password_client' => 0,
            'revoked' => false,
        ]);

        $client->save();

        $this->info('********************************');
        $this->info('* Aplicação criada com sucesso *');
        $this->info(' ');
        $this->info(' Client Id '. $input['name']);
        $this->info(' Client Secret: '. $clientSecret);
        $this->info(' URL Login Redirect: '. $input['redirect']);
        $this->info(' URL Logout Redirect: '. $input['redirect_logout']);
        $this->info(' ');
        $this->info(' Lembre-se de utilizar a URLs informada, caso contrário a requisição será negada. ');
        $this->info('********************************');

        return Command::SUCCESS;
    }
}
