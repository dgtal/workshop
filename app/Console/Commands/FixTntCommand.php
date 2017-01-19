<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class FixTntCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tntsearch:fix {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix total_documents index';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $class = $this->argument('model');

        $model = new $class();
        $tnt = new \TeamTNT\TNTSearch\TNTSearch();
        $driver = config('database.default');
        $config = config('scout.tntsearch') + config("database.connections.$driver");

        $tnt->loadConfig($config);
        $tnt->setDatabaseHandle(app('db')->connection()->getPdo());

        $tnt->selectIndex($model->searchableAs().'.index');
        $indexer = $tnt->getIndex();

        $total_documents = (int) $indexer->prepareAndExecuteStatement("SELECT COUNT(DISTINCT(doc_id)) AS total_documents FROM doclist;")->fetchColumn(0);

        $this->info(sprintf('%d documents where found', $total_documents));

        $indexer->updateInfoTable('total_documents', $total_documents);
    }
}