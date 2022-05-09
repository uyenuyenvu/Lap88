<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

    public function map($users) : array {
        if ($users->role == 0){
            $role = 'Quản lý';
        } elseif ($users->role == 1){
            $role = 'Nhân viên';
        } else {
            $role = 'Khách hàng';
        }
        return [
            $users->name,
            $users->email,
            $users->phone,
            $users->address,
            $role,
            Carbon::parse($users->created_at)->toFormattedDateString(),
            Carbon::parse($users->updated_at)->toFormattedDateString()
        ] ;
    }

    public function headings(): array
    {
        return [
            'Tên nhân viên',
            'Email',
            'Số điện thoại',
            'Địa chỉ',
            'Quyền hạn',
            'Ngày tạo',
            'Ngày cập nhật',
        ];
    }
}
