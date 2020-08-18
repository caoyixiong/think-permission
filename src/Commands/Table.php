<?php

namespace ForeverEson\Permission\Commands;


use think\console\Command;
use think\helper\Str;
use think\migration\Creator;
use RuntimeException;

class Table extends Command
{

    protected function configure()
    {
        $this->setName('permission:table')
            ->setDescription('Create a migration for the permission control database table');
    }

    public function handle()
    {
        if (!$this->app->has('migration.creator')) {
            $this->output->error('Install think-migration first please');
            return;
        }

        $table = 'permission';

        $className = Str::studly("create_{$table}_table");

        /** @var Creator $creator */
        $creator = $this->app->get('migration.creator');

        $path = $creator->create($className);

        // Load the alternative template if it is defined.
        $contents = file_get_contents(__DIR__ . '/stubs/permission.stub');

        if (false === file_put_contents($path, $contents)) {
            throw new RuntimeException(sprintf('The file "%s" could not be written to', $path));
        }

        $this->output->info('Migration created successfully!');
    }
}
