<?php


namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetsImport extends CediImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        
        return [
            //'alarmas' => new CediImport(),
            0 => new CediImport(),


        ];
    }
}

