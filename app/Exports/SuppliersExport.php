<?php

namespace App\Exports;

use App\Models\Supplier;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SuppliersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Supplier::all();
    }

    public function map($suppliers) : array {
        return [
            $suppliers->name,
            $suppliers->email,
            $suppliers->phone,
            $suppliers->address,
            Carbon::parse($suppliers->created_at)->toFormattedDateString(),
            Carbon::parse($suppliers->updated_at)->toFormattedDateString()
        ] ;
    }

    public function headings(): array
    {
        return [
            'Tên nhà cung cấp',
            'Email',
            'Số điện thoại',
            'Địa chỉ',
            'Ngày tạo',
            'Ngày cập nhật',
        ];
    }
}
