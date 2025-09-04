<?php

namespace App\Imports;

use App\Models\Modammer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
class ModammerImport implements  ToModel , WithStartRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {

        return new Modammer([
            'name'   => $row[0],
            'mobile' => $row[1],
            'type'   => $row[6],

        ]);
    }
    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
