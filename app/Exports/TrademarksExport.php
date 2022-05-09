<?php

namespace App\Exports;

use App\Models\Trademark;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrademarksExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Trademark::with('user')->get();
    }

    public function map($trademarks) : array {
        return [
            $trademarks->name,
            $trademarks->user->name,
            Carbon::parse($trademarks->created_at)->toFormattedDateString(),
            Carbon::parse($trademarks->updated_at)->toFormattedDateString()
        ] ;
    }

    public function headings() : array {
        return [
            'Tên thương hiệu',
            'Người tạo',
            'Ngày tạo',
            'Ngày cập nhật',
        ] ;
    }
}
