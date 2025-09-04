<?php

namespace App\Imports;

use App\Models\Camel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CamelImport implements ToModel , WithStartRow
{

    public function model(array $row)
    {

        return new Camel([
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
