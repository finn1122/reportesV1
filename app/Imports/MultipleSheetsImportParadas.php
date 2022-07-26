<?php


namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetsImportParadas extends ParadasImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            //'alarmas' => new CediImport(),
            2 => new ParadasImport(),

        ];
    }
}

