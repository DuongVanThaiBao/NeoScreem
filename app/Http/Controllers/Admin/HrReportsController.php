<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Schedule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class HrReportsController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $range = $request->get('range', 'month');
        $department = $request->get('department');
        $role = $request->get('role');

        // Determine date range
        [$from, $to] = match ($range) {
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'quarter' => [$now->copy()->firstOfQuarter(), $now->copy()->lastOfQuarter()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };

        // Basic metrics
        $employeesQuery = Employee::query();
        if ($department) $employeesQuery->where('department', $department);
        if ($role) $employeesQuery->where('role', $role);
        $totalEmployees = (clone $employeesQuery)->count();

        $newEmployeesThisMonth = Employee::whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])->count();

        $schedulesQuery = Schedule::query()->whereBetween('date', [$from->toDateString(), $to->toDateString()]);
        if ($department) $schedulesQuery->where('department', $department);

        $totalSchedules = (clone $schedulesQuery)->count();
        $leaveSchedules = (clone $schedulesQuery)->where('status', 'Nghỉ phép')->count();
        $leaveRate = $totalSchedules > 0 ? round(($leaveSchedules / $totalSchedules) * 100, 1) : 0;

        // Total working hours (sum of end_time - start_time over schedules)
        $schedulesForHours = (clone $schedulesQuery)->get(['start_time','end_time']);
        $totalWorkingHours = 0.0;
        foreach ($schedulesForHours as $s) {
            try {
                $start = Carbon::createFromFormat('H:i:s', $s->start_time);
                $end = Carbon::createFromFormat('H:i:s', $s->end_time);
                $diffHours = max(0, $end->floatDiffInHours($start));
                $totalWorkingHours += $diffHours;
            } catch (\Throwable $e) {}
        }
        $totalWorkingHours = round($totalWorkingHours, 1);

        // Charts datasets
        // Department distribution (employees by department)
        $deptRows = Employee::selectRaw('department, COUNT(*) as cnt')
            ->when($role, fn($q)=>$q->where('role', $role))
            ->groupBy('department')->orderBy('department')
            ->get();
        $deptLabels = $deptRows->pluck('department')->map(fn($v)=>$v ?: 'Khác')->values();
        $deptData = $deptRows->pluck('cnt')->values();

        // Hiring trend last 6 months
        $trendLabels = [];
        $trendData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $startM = $month->copy()->startOfMonth();
            $endM = $month->copy()->endOfMonth();
            $trendLabels[] = $month->format('m/Y');
            $trendData[] = Employee::whereBetween('created_at', [$startM, $endM])->count();
        }

        // Attendance stacked: last 7 days from today
        $attLabels = [];
        $attPresent = [];
        $attAbsent = [];
        $period = CarbonPeriod::create($now->copy()->subDays(6)->startOfDay(), $now->copy()->startOfDay());
        foreach ($period as $d) {
            $attLabels[] = $d->format('d/m');
            $present = Schedule::whereDate('date', $d->toDateString())
                ->when($department, fn($q)=>$q->where('department', $department))
                ->count();
            $attPresent[] = $present;
            // Without explicit absence table, set absent to 0 (no fake data)
            $attAbsent[] = 0;
        }

        // Attendance table with filters
        $tableMonth = $request->get('month'); // format YYYY-MM
        $tableQuery = Schedule::with('employee');
        if ($tableMonth) {
            try {
                $m = Carbon::createFromFormat('Y-m', $tableMonth);
                $tableQuery->whereBetween('date', [$m->copy()->startOfMonth()->toDateString(), $m->copy()->endOfMonth()->toDateString()]);
            } catch (\Throwable $e) {}
        } else {
            $tableQuery->whereBetween('date', [$now->copy()->startOfMonth()->toDateString(), $now->copy()->endOfMonth()->toDateString()]);
        }
        if ($department) $tableQuery->where('department', $department);
        if ($request->filled('employee')) {
            $empSearch = $request->get('employee');
            $tableQuery->whereHas('employee', function($q) use ($empSearch){
                $q->where('name', 'like', '%'.$empSearch.'%');
            });
        }
        $attendancePage = $tableQuery->orderBy('date','desc')->orderBy('start_time','asc')->paginate(10)->appends($request->query());

        // Payroll and performance placeholders from available fields (using schedules count as a proxy)
        $payrollBudget = 0; $bonusTotal = 0; $penaltyTotal = 0; // No payroll tables -> keep 0 (real, not fake)
        $avgKpi = 0; $completionRate = 0; $managerNotes = null; // No KPI tables
        $avgLeaveDays = 0; $lateEarlyRate = 0; $topWorkerName = null; // No leave or timesheet tables

        // Success toasts for apply/reset
        if ($request->boolean('applied')) {
            session()->flash('success', 'Áp dụng thành công');
        }
        if ($request->boolean('reset')) {
            session()->flash('success', 'Đã xóa bộ lọc');
        }

        return view('admin.hr.reports', [
            'totalEmployees' => $totalEmployees,
            'newEmployeesThisMonth' => $newEmployeesThisMonth,
            'leaveRate' => $leaveRate,
            'totalWorkingHours' => $totalWorkingHours,
            'deptLabels' => $deptLabels,
            'deptData' => $deptData,
            'trendLabels' => $trendLabels,
            'trendData' => $trendData,
            'attLabels' => $attLabels,
            'attPresent' => $attPresent,
            'attAbsent' => $attAbsent,
            'attendancePage' => $attendancePage,
            'payrollBudget' => $payrollBudget,
            'bonusTotal' => $bonusTotal,
            'penaltyTotal' => $penaltyTotal,
            'avgKpi' => $avgKpi,
            'completionRate' => $completionRate,
            'managerNotes' => $managerNotes,
            'avgLeaveDays' => $avgLeaveDays,
            'lateEarlyRate' => $lateEarlyRate,
            'topWorkerName' => $topWorkerName,
        ]);
    }

    public function exportCsv(Request $request)
    {
        // Reuse index filters for range/department/role/month/employee
        $now = Carbon::now();
        $range = $request->get('range', 'month');
        [$from, $to] = match ($range) {
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'quarter' => [$now->copy()->firstOfQuarter(), $now->copy()->lastOfQuarter()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };
        $department = $request->get('department');
        $employee = $request->get('employee');

        $q = Schedule::with('employee')->whereBetween('date', [$from->toDateString(), $to->toDateString()]);
        if ($department) $q->where('department', $department);
        if ($employee) {
            $q->whereHas('employee', function($qq) use ($employee){ $qq->where('name', 'like', '%'.$employee.'%'); });
        }
        $rows = $q->orderBy('date','desc')->orderBy('start_time','asc')->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="hr_attendance_'.date('Ymd_His').'.csv"',
        ];
        $callback = function() use ($rows) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM for Excel
            fwrite($out, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($out, ['Nhân viên','Bộ phận','Ngày','Bắt đầu','Kết thúc','Giờ làm','Trạng thái']);
            foreach ($rows as $r) {
                try {
                    $start = Carbon::createFromFormat('H:i:s', $r->start_time);
                    $end = Carbon::createFromFormat('H:i:s', $r->end_time);
                    $hrs = max(0, $end->floatDiffInHours($start));
                } catch (\Throwable $e) { $hrs = 0; }
                fputcsv($out, [
                    optional($r->employee)->name,
                    $r->department ?: optional($r->employee)->department,
                    Carbon::parse($r->date)->format('d/m/Y'),
                    substr($r->start_time,0,5),
                    substr($r->end_time,0,5),
                    number_format($hrs, 1),
                    $r->status,
                ]);
            }
            fclose($out);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportPrint(Request $request)
    {
        // simple printable HTML using same datasets as CSV
        $now = Carbon::now();
        $range = $request->get('range', 'month');
        [$from, $to] = match ($range) {
            'week' => [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()],
            'quarter' => [$now->copy()->firstOfQuarter(), $now->copy()->lastOfQuarter()],
            'year' => [$now->copy()->startOfYear(), $now->copy()->endOfYear()],
            default => [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()],
        };
        $department = $request->get('department');
        $employee = $request->get('employee');

        $q = Schedule::with('employee')->whereBetween('date', [$from->toDateString(), $to->toDateString()]);
        if ($department) $q->where('department', $department);
        if ($employee) {
            $q->whereHas('employee', function($qq) use ($employee){ $qq->where('name', 'like', '%'.$employee.'%'); });
        }
        $rows = $q->orderBy('date','desc')->orderBy('start_time','asc')->get();
        return view('admin.hr.reports_print', [ 'rows' => $rows, 'range' => [$from, $to] ]);
    }

    public function storeSchedule(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'cadence' => 'required|in:daily,weekly,monthly',
        ]);
        $filters = $request->only(['range','department','role','month','employee']);
        \App\Models\ReportSchedule::create([
            'email' => $data['email'],
            'cadence' => $data['cadence'],
            'filters' => $filters,
            'next_run_at' => now(),
        ]);
        return back()->with('success', 'Đã lập lịch gửi báo cáo');
    }

    public function storeTemplate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);
        \App\Models\ReportTemplate::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'config' => $request->only(['range','department','role']),
        ]);
        return back()->with('success', 'Đã lưu mẫu báo cáo');
    }
}
