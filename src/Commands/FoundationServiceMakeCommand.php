<?php

namespace Wiltechsteam\FoundationServiceSingle\Commands;

use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Console\Command;

class FoundationServiceMakeCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'foundation:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Foundation Make';

    protected $loggerHandler;

    /**
     * FoundationServiceCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Handle
     *
     */
    public function handle()
    {
        $this->createDirectories();
        if(!file_exists(base_path('config/foundation.php')))
        {
            copy(
                __DIR__.'/stubs/config/foundation.stub',
                base_path('config/foundation.php')
            );
        }

        copy(
            __DIR__.'/stubs/migrations/2018_05_15_095650_create_staffs_table.stub',
            database_path('migrations/2018_05_15_095650_create_staffs_table.php')
        );

        copy(
            __DIR__.'/stubs/migrations/2018_05_15_100005_create_positions_table.stub',
            database_path('migrations/2018_05_15_100005_create_positions_table.php')
        );

        copy(
            __DIR__.'/stubs/migrations/2018_05_15_100033_create_units_table.stub',
            database_path('migrations/2018_05_15_100033_create_units_table.php')
        );


        file_put_contents(
            base_path(config('foundation.models_namespace').'/Staff.php'),
            $this->compileStaffCNModelStub()
        );

        file_put_contents(
            base_path(config('foundation.models_namespace').'/Position.php'),
            $this->compilePositionCNModelStub()
        );

        file_put_contents(
            base_path(config('foundation.models_namespace').'/Unit.php'),
            $this->compileUnitCNModelStub()
        );

        $this->info('successfully.');
    }

    /**
     * 创建目录
     */
    protected function createDirectories()
    {
        if (! is_dir($directory = base_path(config('foundation.models_namespace')))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = 'database\migrations')) {
            mkdir($directory, 0755, true);
        }
    }

    protected function compileStaffCNModelStub()
    {
        return str_replace(
            '{{namespace}}',
            config('foundation.models_namespace'),
            file_get_contents(__DIR__.'/stubs/models/Staff.stub')
        );
    }


    protected function compilePositionCNModelStub()
    {
        return str_replace(
            '{{namespace}}',
            config('foundation.models_namespace'),
            file_get_contents(__DIR__.'/stubs/models/Position.stub')
        );
    }

    protected function compileUnitCNModelStub()
    {
        return str_replace(
            '{{namespace}}',
            config('foundation.models_namespace'),
            file_get_contents(__DIR__.'/stubs/models/Unit.stub')
        );
    }

}