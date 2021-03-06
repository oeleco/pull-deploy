<?php

namespace oeleco\PullDeploy\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class PullDeployCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'pull:deploy
                            {--r|remote=origin : name of remote repository}
                            {--b|branch=master : branch name to deploy}
                            {--without-assets : Ignore run npm prod command}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Deploy your code from branch in remote repository';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $config = (object) Config::get('pull-deploy');

        $remote = $this->option('remote');
        $branch = $this->option('branch');

        $url    = shell_exec("git remote get-url {$remote}");
        $url    = str_replace("https://", "https://{$config->username}:{$config->personal_access_token}@", $url);

        $this->info("Reset to {$remote} {$branch}");
        echo exec("git reset --hard {$remote}/{$branch}");
        echo exec('git clean -n -f');
        $this->line('');

        $this->info("Pull from {$remote} {$branch}");
        echo exec("git pull {$url}");
        $this->line('');

        $this->info('Setup folder permissions');
        echo exec('chown -R www-data.www-data storage');
        echo exec('chown -R www-data.www-data bootstrap/cache');
        $this->line('');

        $this->info('Clean composer autoload');
        echo exec('composer dump-autoload');
        $this->line('');

        $this->info('Clean and make cache');
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('clear-compiled');
        $this->call('optimize');

        if (! $this->option('without-assets')) {
            $this->info('Generate production assets');
            echo exec('npm run prod');
            $this->line('');
        }
    }
}
