<?php


namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetsImportAlertamientos extends AlertamientosImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            //'alarmas' => new CediImport(),
            1 => new AlertamientosImport(),

        ];
    }
}

