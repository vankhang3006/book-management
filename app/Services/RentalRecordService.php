<?php


namespace App\Services;

use App\Http\Requests\RentalRecord\CreateRentalRecordRequest;
use App\Models\RentalRecord;
use App\Models\BookCopy;
use App\Models\User;

class RentalRecordService
{
    
    public function getRentalRecords($search = null)
    {
        $query = RentalRecord::query();

        // Nếu có tìm kiếm, thêm điều kiện vào query
        if ($search) {
            $query->where('book_copy_id', 'LIKE', "%{$search}%");
        }

        // Trả về kết quả phân trang
        return $query->paginate(10);
    }
    
    public function create(CreateRentalRecordRequest $request)
    {
        // Lấy thông tin book_copy_id từ request
        $bookCopy = BookCopy::findOrFail($request->book_copy_id);
        
        // Kiểm tra nếu bản sao sách đã có người mượn rồi thì không cho mượn
        if ($bookCopy->status === 'borrowed') {
            throw new \Exception('Bản sao sách này đã được mượn!');
        }

        // Cập nhật trạng thái của bản sao sách thành "borrowed"
        $bookCopy->status = 'borrowed';
        $bookCopy->save();

        // Tạo mới RentalRecord
        return RentalRecord::create([
            'book_copy_id' => $request->book_copy_id,
            'user_id' => $request->user_id,
            'rented_at' => $request->rented_at,
            'due_date' => $request->due_date,
        ]);
    }

    public function updateRentalRecord(RentalRecord $rentalRecord, $data)
    {
        // Cập nhật thông tin thuê sách
        $rentalRecord->update($data);

        // Nếu ngày trả thực tế đã được điền, cập nhật trạng thái bản sao sách
        if ($rentalRecord->returned_at) {
            $rentalRecord->bookCopy->update(['status' => 'available']);
        }

        return $rentalRecord;
    }
}
