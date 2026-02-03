<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RawArrayImport;

class ReadExcelCommand extends Command
{
    protected $signature = 'excel:read {file}';
    protected $description = 'Read Excel file and output JSON';

    public function handle()
    {
        $file = $this->argument('file');
        $sheets = Excel::toArray(new RawArrayImport(), $file);
        
        $this->info(json_encode([
            'rows' => count($sheets[0]),
            'all_data' => $sheets[0]
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
