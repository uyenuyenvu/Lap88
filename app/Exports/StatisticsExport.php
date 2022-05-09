<?php

namespace App\Exports;

use App\Models\Statistic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatisticsExport implements FromCollection, WithHeadings
{
    protected $fromDate;
    protected $toDate;

    function __construct($fromDate, $toDate) {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Statistic::whereBetween('order_date', [$this->fromDate, $this->toDate])->get(['order_date', 'revenue', 'profit', 'quantity', 'total_order']);
    }

    public function headings() : array {
        return [
            'Thời gian',
            'Doanh thu',
            'Lợi nhuận',
            'Sản phẩm đã bán',
            'Tổng đơn hàng'
        ] ;
    }
}
