<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoriesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'name'      => $row[0],
            'slug'      => Str::slug($row[0]),
            'parent_id' => $row[1],
            'user_id'   => Auth::user()->id,
            'depth'     => 0,
        ]);
    }
}
