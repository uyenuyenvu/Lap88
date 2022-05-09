<?php

namespace App\Exports;

use App\Models\Category;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CategoriesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Category::with(['user', 'parent'])->get();
    }

    public function map($categories) : array {
        if ($categories->parent == null){
            $parent = 'Không có';
        } else {
            $parent = $categories->parent->name;
        }

        return [
            $categories->name,
            $parent,
            $categories->user->name,
            Carbon::parse($categories->created_at)->toFormattedDateString(),
            Carbon::parse($categories->updated_at)->toFormattedDateString()
        ] ;
    }

    public function headings() : array {
        return [
            'Tên danh mục',
            'Danh mục cha',
            'Người tạo',
            'Ngày tạo',
            'Ngày cập nhật',
        ] ;
    }
}
