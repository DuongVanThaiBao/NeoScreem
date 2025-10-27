<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['code'=>'NV001','name'=>'Nguyễn Văn A','department'=>'Rạp phim','position'=>'Nhân viên rạp','phone'=>'0901234567','status'=>'Đang làm','gender'=>'Nam','dob'=>'1995-01-10','address'=>'Q1, TP.HCM','start_date'=>'2023-06-01','base_salary'=>7000000,'avatar'=>'https://i.pravatar.cc/80?img=1'],
            ['code'=>'NV002','name'=>'Trần Thị B','department'=>'Bán vé','position'=>'Thu ngân','phone'=>'0902345678','status'=>'Đang làm','gender'=>'Nữ','dob'=>'1996-03-12','address'=>'Q3, TP.HCM','start_date'=>'2023-07-15','base_salary'=>6800000,'avatar'=>'https://i.pravatar.cc/80?img=2'],
            ['code'=>'NV003','name'=>'Lê Văn C','department'=>'Quầy bắp nước','position'=>'Phục vụ','phone'=>'0903456789','status'=>'Nghỉ việc','gender'=>'Nam','dob'=>'1993-11-02','address'=>'Q5, TP.HCM','start_date'=>'2022-02-20','base_salary'=>6500000,'avatar'=>'https://i.pravatar.cc/80?img=3'],
            ['code'=>'NV004','name'=>'Phạm Thị D','department'=>'Vệ sinh','position'=>'Tạp vụ','phone'=>'0904567890','status'=>'Đang làm','gender'=>'Nữ','dob'=>'1998-08-21','address'=>'Q10, TP.HCM','start_date'=>'2024-01-05','base_salary'=>6000000,'avatar'=>'https://i.pravatar.cc/80?img=4'],
            ['code'=>'NV005','name'=>'Võ Minh E','department'=>'Rạp phim','position'=>'Ca trưởng','phone'=>'0905678901','status'=>'Đang làm','gender'=>'Nam','dob'=>'1992-06-30','address'=>'Q7, TP.HCM','start_date'=>'2021-09-01','base_salary'=>9000000,'avatar'=>'https://i.pravatar.cc/80?img=5'],
            ['code'=>'NV006','name'=>'Đỗ Thảo F','department'=>'Bán vé','position'=>'Nhân viên','phone'=>'0906789012','status'=>'Đang làm','gender'=>'Nữ','dob'=>'1999-12-01','address'=>'Q4, TP.HCM','start_date'=>'2024-05-10','base_salary'=>6500000,'avatar'=>'https://i.pravatar.cc/80?img=6'],
        ];

        foreach ($data as $row) {
            $row['active'] = ($row['status'] ?? 'Đang làm') === 'Đang làm';
            Employee::updateOrCreate(['code'=>$row['code']], $row);
        }
    }
}
