<?php

namespace App\Imports;

use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class SuppliersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            'name'      => $row[0],
            'email'     => $row[1],
            'phone'     => $row[2],
            'address'   => $row[3],
            'user_id' => Auth::user()->id,
        ]);
    }
}
