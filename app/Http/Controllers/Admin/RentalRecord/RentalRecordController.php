<?php

namespace App\Http\Controllers\Admin\RentalRecord;

use App\Http\Controllers\Controller;
use App\Http\Requests\RentalRecord\CreateRentalRecordRequest;
use App\Http\Requests\RentalRecord\UpdateRentalRecordRequest;
use App\Models\BookCopy;
use App\Models\RentalRecord;
use App\Models\User;
use App\Services\RentalRecordService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalRecordController extends Controller
{
    protected $rentalRecordService;

    public function __construct(RentalRecordService $rentalRecordService)
    {
        $this->rentalRecordService = $rentalRecordService;
    }

    // Hiển thị danh sách các bản ghi thuê sách

    public function index(Request $request, RentalRecordService $rentalRecordService)
    {
        $search = $request->input('search');
        $rentalRecords = $rentalRecordService->getRentalRecords($search);
    
        // Lấy danh sách các bản ghi
        $records = $rentalRecords->items();
    
        // Định dạng ngày tháng
        foreach ($records as $record) {
            $record->rented_at = Carbon::parse($record->rented_at)->format('d/m/Y');
            $record->due_date = Carbon::parse($record->due_date)->format('d/m/Y');
        }
    
        return view('admin.rental_records.index', compact('rentalRecords', 'search'));
    }
    

    // Trang tạo mới rental record
    public function create()
    {
        $bookCopies = BookCopy::where('status', 'available')->get(); // Chỉ lấy bản sao có sẵn
        $users = User::all(); // Lấy danh sách người dùng
        return view('admin.rental_records.create', compact('bookCopies', 'users'));
    }

    // Lưu thông tin thuê sách
    public function store(CreateRentalRecordRequest $request)
    {
        try {
            $this->rentalRecordService->create($request);
            return redirect()->route('admin.rental_records.index')->with('success', 'Bản sao sách đã được cho mượn!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    

    // Trang chỉnh sửa rental record
    public function edit(RentalRecord $rentalRecord)
    {
        $bookCopies = BookCopy::all();
        $users = User::all();
    
        // Chuyển đổi ngày từ định dạng d/m/Y sang Y-m-d để hiển thị trong input
        $rentalRecord->rented_at = Carbon::parse($rentalRecord->rented_at)->format('Y-m-d');
        $rentalRecord->due_date = Carbon::parse($rentalRecord->due_date)->format('Y-m-d');
    
        return view('admin.rental_records.edit', compact('rentalRecord', 'bookCopies', 'users'));
    }
    
    

    // Cập nhật rental record
    public function update(UpdateRentalRecordRequest $request, RentalRecord $rentalRecord)
    {
        try {
            $this->rentalRecordService->updateRentalRecord($rentalRecord, $request->validated());
            return redirect()->route('admin.rental_records.index')->with('success', 'Cập nhật thông tin thuê sách thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.rental_records.edit', $rentalRecord)->with('error', $e->getMessage());
        }
    }

    // Xóa rental record
    public function destroy(RentalRecord $rentalRecord)
    {
        $rentalRecord->delete();
        return redirect()->route('admin.rental_records.index')->with('success', 'Đã xóa thông tin thuê sách!');
    }
}
