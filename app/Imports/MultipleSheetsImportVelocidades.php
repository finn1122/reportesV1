<?php


namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetsImportVelocidades extends VelocidadesImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            //'alarmas' => new CediImport(),
            0 => new VelocidadesImport(),

        ];
    }
}

