<?php

namespace GeneaLabs\CashierPaypal\Console\Commands;

use Illuminate\Console\Command;

class CashierInstall extends Command
{
    protected $signature = 'cashier:install
        {--T|template : include publishing the invoice template}';
    protected $description = 'Install Cashier Mollie';

    public function handle() : void
    {
        if (app()->environment('production')) {
            $this->alert('Running in production mode.');
            if ($this->confirm('Proceed installing Cashier?')) {
                return;
            }
        }

        $this->comment('Publishing Cashier migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'cashier-migrations']);

        $this->comment('Publishing Cashier configuration files...');
        $this->callSilent('vendor:publish', ['--tag' => 'cashier-configs']);

        if ($this->option('template')) {
            $this->callSilent('vendor:publish', ['--tag' => 'cashier-views']);
        } else {
            $this->info(
                'You can publish the Cashier invoice template so you can modify it. '
                    . 'Note that this will exclude your template copy from updates by the package maintainers.'
            );

            if ($this->confirm('Publish Cashier invoice template?')) {
                $this->comment('Publishing Cashier invoice template...');
                $this->callSilent('vendor:publish', ['--tag' => 'cashier-views']);
            }
        }

        $this->info('Cashier was installed successfully.');
    }
}
