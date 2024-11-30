<?php

namespace App\Http\Controllers\Admin\BookCopy;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookCopy\CreateBookCopyRequest;
use App\Http\Requests\BookCopy\UpdateBookCopyRequest;
use App\Models\Book;
use App\Services\BookCopyService;
use App\Models\BookCopy;

use Illuminate\Http\Request;

class BookCopyController extends Controller
{
    protected $bookCopyService;

    public function __construct(BookCopyService $bookCopyService)
    {
        $this->bookCopyService = $bookCopyService;
    }

    // Hiển thị danh sách bản sao sách
    public function index(Request $request)
    {
        $copies = $this->bookCopyService->getList($request->search);

        return view('admin.book_copies.list', ['copies' => $copies]);
    }

    // Trang thêm bản sao sách
    public function create()
    {
        $books = Book::all(); // Lấy danh sách sách để hiển thị trong dropdown
        return view('admin.book_copies.create', ['books' => $books]);
    }

    // Xử lý lưu bản sao sách
    public function store(CreateBookCopyRequest $request)
    {
        $this->bookCopyService->create($request->validated());

        return redirect()->route('admin.book_copies.index')->with('success', 'Bản sao sách đã được thêm thành công!');
    }

    // Trang chỉnh sửa bản sao sách
    public function edit(BookCopy $bookCopy)
    {
        $books = Book::all(); // Lấy danh sách sách để hiển thị trong dropdown
        return view('admin.book_copies.edit', [
            'bookCopy' => $bookCopy,
            'books' => $books
        ]);
    }

    // Xử lý cập nhật bản sao sách
    public function update(UpdateBookCopyRequest $request, BookCopy $bookCopy)
    {
        // Gửi toàn bộ dữ liệu được xác thực để cập nhật
        $this->bookCopyService->update($bookCopy, $request->validated());
    
        return redirect()->route('admin.book_copies.index')->with('success', 'Bản sao sách đã được cập nhật thành công!');
    }

    // Xử lý xóa bản sao sách
    public function destroy(BookCopy $bookCopy)
    {
        $this->bookCopyService->delete($bookCopy);

        return redirect()->route('admin.book_copies.index')->with('success', 'Bản sao sách đã được xóa!');
    }
}
