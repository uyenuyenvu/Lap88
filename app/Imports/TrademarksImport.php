<?php

namespace App\Imports;

use App\Models\Trademark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class TrademarksImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Trademark([
            'name' => $row[0],
            'slug' => Str::slug($row[0]),
            'user_id' => Auth::user()->id,
        ]);
    }
}
