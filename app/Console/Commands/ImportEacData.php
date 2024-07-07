<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\EacImporter;
use App\Models\Parserlog;

class ImportEacData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-eac-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import EAC data from the EAC website.';

    protected $eacImporter;

    public function __construct(EacImporter $eacImporter)
    {
        parent::__construct();
        $this->eacImporter = $eacImporter;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $eacData = [];
        try {
            $eacData = $this->eacImporter->importAdjustmentData();
            $this->info('EAC Fuel Adjustment data  paresed successfully.');
            Parserlog::create([
                'type' => 'Fuel Adjustment Parse',
                'status' => 'success',
                'message' => 'Fuel Adjustment data parsed from EAC website successfully.'
            ]);
        } catch (\Exception $e) {
            $this->error('An error occurred while parsing the EAC Fuel Adjustment data from the site: ' . $e->getMessage());
            Parserlog::create([
                'type' => 'Fuel Adjustment Parse',
                'status' => 'error',
                'message' => 'Error parsing Fuel Adjustment data: ' . $e->getMessage(),
            ]);
            return;
        }

        try {
            $this->eacImporter->saveAdjustmentData($eacData);
            $this->info('EAC Fuel Adjustment data imported successfully.');
            Parserlog::create([
                'type' => 'Fuel Adjustment Import',
                'status' => 'success',
                'message' => 'EAC Fuel Adjustment data imported successfully.'
            ]);
        } catch (\Exception $e) {
            $this->error('An error occurred while importing the Fuel Adjustment data: ' . $e->getMessage());
            Parserlog::create([
                'type' => 'EAC Import',
                'status' => 'error',
                'message' => 'Error importing EAC Fuel Adjustment data: ' . $e->getMessage(),
            ]);
        }
    }
}
