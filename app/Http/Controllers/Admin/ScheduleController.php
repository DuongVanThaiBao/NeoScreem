<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('view', 'week');
        $department = $request->get('department');
        $startDate = $request->get('start') ? Carbon::parse($request->get('start')) : Carbon::now()->startOfWeek();
        if ($view !== 'month') { $view = 'week'; }

        $dates = [];
        if ($view === 'week') {
            for ($i = 0; $i < 7; $i++) {
                $dates[] = (clone $startDate)->addDays($i);
            }
            $from = $dates[0]->toDateString();
            $to = $dates[6]->toDateString();
        } else {
            $from = $startDate->copy()->startOfMonth()->toDateString();
            $to = $startDate->copy()->endOfMonth()->toDateString();
            $period = new \DatePeriod(new \DateTime($from), new \DateInterval('P1D'), (new \DateTime($to))->modify('+1 day'));
            foreach ($period as $d) { $dates[] = Carbon::instance($d); }
        }

        $schedules = Schedule::with('employee')
            ->whereBetween('date', [$from, $to])
            ->when($department, function($q) use ($department){ $q->where('department', $department); })
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $grouped = [];
        foreach ($dates as $d) { $grouped[$d->toDateString()] = []; }
        foreach ($schedules as $s) { $grouped[$s->date->toDateString()][] = $s; }

        $employees = Employee::orderBy('name')->get(['id','name','department']);
        $departments = ['Rạp phim','Bán vé','Quầy bắp nước','Vệ sinh'];

        if ($request->boolean('applied')) {
            session()->flash('success', 'Áp dụng thành công');
        }
        if ($request->boolean('reset')) {
            session()->flash('success', 'Đã xóa bộ lọc');
        }

        return view('admin.hr.schedules', [
            'view' => $view,
            'department' => $department,
            'start' => $startDate->toDateString(),
            'dates' => $dates,
            'grouped' => $grouped,
            'employees' => $employees,
            'departments' => $departments,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'department' => 'nullable|string|max:100',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'shift' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);
        $data['status'] = 'Đã tạo';
        Schedule::create($data);
        return redirect()->route('admin.hr.schedules', ['applied' => 1])->with('success', 'Đã thêm lịch làm việc');
    }
}
