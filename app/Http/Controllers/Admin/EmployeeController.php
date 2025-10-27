<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $department = $request->get('department');
        $status = $request->get('status');

        $employees = Employee::query()
            ->when($q !== '', function($query) use ($q){
                $query->where(function($qq) use ($q){
                    $qq->where('name', 'like', "%$q%")
                       ->orWhere('code', 'like', "%$q%");
                });
            })
            ->when($department, function($query) use ($department){
                $query->where('department', $department);
            })
            ->when($status, function($query) use ($status){
                $query->where('status', $status);
            })
            ->orderBy('name')
            ->paginate(10)
            ->appends($request->query());

        $departments = ['Rạp phim','Bán vé','Quầy bắp nước','Vệ sinh'];
        $statuses = ['Đang làm','Nghỉ việc'];

        return view('admin.hr.employees', compact('employees','departments','statuses','q','department','status'));
    }

    public function show(Employee $employee)
    {
        return view('admin.hr.employee-show', compact('employee'));
    }

    public function create()
    {
        $departments = ['Rạp phim','Bán vé','Quầy bắp nước','Vệ sinh'];
        $statuses = ['Đang làm','Nghỉ việc'];
        return view('admin.hr.employee-create', compact('departments','statuses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:employees,code',
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'position' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'required|string|max:50',
            'gender' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'cccd' => 'nullable|string|max:50',
            'start_date' => 'nullable|date',
            'base_salary' => 'nullable|integer',
            'bank_account' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:100',
            'avatar' => 'nullable|string|max:255',
        ]);
        $data['active'] = ($data['status'] ?? 'Đang làm') === 'Đang làm';

        Employee::create($data);
        return redirect()->route('admin.hr.employees.index')->with('success', 'Tạo nhân viên thành công');
    }

    public function edit(Employee $employee)
    {
        $departments = ['Rạp phim','Bán vé','Quầy bắp nước','Vệ sinh'];
        $statuses = ['Đang làm','Nghỉ việc'];
        return view('admin.hr.employee-edit', compact('employee','departments','statuses'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50|unique:employees,code,' . $employee->id,
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:100',
            'position' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'status' => 'required|string|max:50',
            'gender' => 'nullable|string|max:10',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'cccd' => 'nullable|string|max:50',
            'start_date' => 'nullable|date',
            'base_salary' => 'nullable|integer',
            'bank_account' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:100',
            'avatar' => 'nullable|string|max:255',
        ]);
        $data['active'] = ($data['status'] ?? 'Đang làm') === 'Đang làm';

        $employee->update($data);
        return redirect()->route('admin.hr.employees.index')->with('success', 'Cập nhật nhân viên thành công');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.hr.employees.index')->with('success', 'Đã xóa nhân viên');
    }
}
