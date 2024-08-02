<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;
use App\Models\Adjustment;
use DOMDocument;

/**
 * Class EacImporter
 * Class to import and process EAC tariff data.
 */

 class EacImporter
 {
     public function importAdjustmentData(): array
    {
        static $adjustmentUrl = env('EAC_ADJUSTMENT_URL');
        $response = Http::get($adjustmentUrl);
        $htmlString = (string) $response->getBody();
        $pattern = '/<table\b[^>]*>(.*?)<\/table>/s';

        if (preg_match($pattern, $htmlString, $matches)) {
            $tableHtml = $matches[0];
        } else {
            return [];
        }
        $adjustments = array();

        $doc = new DOMDocument();
        $doc->loadHTML($tableHtml);
        $rows = $doc->getElementsByTagName('tr');

        $year ='';
        $month = '';
        $weighted_fuel_price = '';

        foreach ($rows as $id => $row) {
            if ($id == 0) {
                continue;
            } else if ($id == 1) {
                $values = $row->getElementsByTagName('td');
                $year = trim($values[2]->nodeValue);
                $year = iconv('UTF-8', 'ASCII//IGNORE', $year);
            } else {
                $values = $row->getElementsByTagName('td');
                $voltage = trim($values[0]->nodeValue);
                $voltage = iconv('UTF-8', 'ASCII//IGNORE', $voltage);
                if ($voltage == 'HIGH') {
                    $month = trim($values[3]->nodeValue);
                    $month = iconv('UTF-8', 'ASCII//IGNORE', $month);
                    $weighted_fuel_price = trim($values[4]->nodeValue);
                    $weighted_fuel_price = str_replace(',', '.', $weighted_fuel_price);

                } else if ($voltage == 'LOW'){
                    $fuel_adjustment_coefficient = trim($values[1]->nodeValue);
                    $fuel_adjustment_coefficient = iconv('UTF-8', 'ASCII//IGNORE', $fuel_adjustment_coefficient);
                    $fuel_adjustment_coefficient =  str_replace(',', '.', $fuel_adjustment_coefficient);

                    $total = trim($values[3]->nodeValue);
                    $total = iconv('UTF-8', 'ASCII//IGNORE', $total);
                    $total = str_replace(',', '.', $total);
                    $total = (float) $total/100;

                    $fuel = trim($values[4]->nodeValue);
                    $fuel = iconv('UTF-8', 'ASCII//IGNORE', $fuel);
                    $fuel = str_replace(',', '.', $fuel);
                    $fuel = (float) $fuel/100;

                    $co2_emissions = trim($values[5]->nodeValue);
                    $co2_emissions = iconv('UTF-8', 'ASCII//IGNORE', $co2_emissions);
                    $co2_emissions = str_replace(',', '.', $co2_emissions);
                    $co2_emissions = (float) $co2_emissions/100;

                    $cosmos = trim($values[6]->nodeValue);
                    $cosmos = iconv('UTF-8', 'ASCII//IGNORE', $cosmos);
                    $cosmos = str_replace(',', '.', $cosmos);
                    $cosmos = (float) $cosmos/100;

                    $revised_fuel_adjustment_price = trim($values[7]->nodeValue);
                    $revised_fuel_adjustment_price = iconv('UTF-8', 'ASCII//IGNORE', $revised_fuel_adjustment_price);
                    $revised_fuel_adjustment_price = str_replace(',', '.', $revised_fuel_adjustment_price);
                    $revised_fuel_adjustment_price = (float) $revised_fuel_adjustment_price/100;

                    if ($total != 0) {
                        $adjustments[] = array (
                            'date' => $month . ' ' . $year,
                            'consumer' => 'Bi-Monthly',
                            'voltage' => $voltage,
                            'fuel_adjustment_coefficient' => $fuel_adjustment_coefficient,
                            'weighted_fuel_price' => $weighted_fuel_price,
                            'total' => $total,
                            'fuel' =>  $fuel,
                            'co2_emissions' => $co2_emissions,
                            'cosmos' => $cosmos,
                            'revised_fuel_adjustment_price' => $revised_fuel_adjustment_price,
                        );
                    }
                }
            }
        }
        return $adjustments;
    }

    public function saveAdjustmentData(array $adjustments)
    {
        $created = 0;
        foreach ($adjustments as $adjustment) {
            $dates = $this->getFirstLastDayOfMonth($adjustment['date']);
            $record = Adjustment::updateOrCreate(
                [
                    'start_date' => $dates[0],
                    'end_date' => $dates[1],
                    'consumer_type' => $adjustment['consumer'],
                    'voltage_type' => $adjustment['voltage'],
                ],
                [
                    'user_id' => 1,
                    'weighted_average_fuel_price' => $adjustment['weighted_fuel_price'],
                    'fuel_adjustment_coefficient' => $adjustment['fuel_adjustment_coefficient'],
                    'total' => $adjustment['total'],
                    'fuel' => $adjustment['fuel'],
                    'co2_emissions' => $adjustment['co2_emissions'],
                    'cosmos' => $adjustment['cosmos'],
                    'revised_fuel_adjustment_price' => $adjustment['revised_fuel_adjustment_price'],
                    'source' => env('EAC_ADJUSTMENT_URL'),
                    'source_name' => 'EAC - Fuel Price Adjustment',
                ]
            );
            if ($record->wasRecentlyCreated) {
                $created++;
            }
        }
        return $created;
    }

    private function getFirstLastDayOfMonth(string $date): array
    {
        $firstDay = date('Y-m-01', strtotime($date));
        $lastDay = date('Y-m-t', strtotime($date));
        return array($firstDay, $lastDay);
    }
 }