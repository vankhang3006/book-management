<?php

namespace App\Http\Controllers\Admin\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\CreateRequest;
use App\Http\Requests\Book\UpdateRequest;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Services\BookService;
use App\Models\Category;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    // Hiển thị danh sách sách
    public function index(Request $request)
    {
        $search = $request->get('search');
        // Eager load category để tránh truy vấn N+1
        $books = $this->bookService->getList($search); 
    
        return view('admin.books.list', compact('books')); // Truyền 'books' vào view
    }
    
    

    // Hiển thị form thêm mới sách
    public function create()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    // Lưu sách mới
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'copies_count' => 'nullable|integer|min:0',
        ]);

        // Gọi service để lưu sách
        $book = $this->bookService->create($validatedData);

        // Kiểm tra nếu thành công
        if ($book) {
            return redirect()->route('admin.books.list')->with('success', 'Sách đã được thêm thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể tạo sách!');
        }
    }

    // Hiển thị form chỉnh sửa sách
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    // Cập nhật sách
    public function update(Request $request, Book $book)
    {
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'copies_count' => 'nullable|integer|min:0',
        ]);

        // Gọi service để cập nhật sách
        $updated = $this->bookService->update($book, $validatedData);

        // Kiểm tra nếu thành công
        if ($updated) {
            return redirect()->route('admin.books.index')->with('success', 'Sách đã được cập nhật thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể cập nhật sách!');
        }
    }

    // Xóa sách
    public function destroy(Book $book)
    {
        // Gọi service để xóa sách
        $deleted = $this->bookService->delete($book);

        // Kiểm tra nếu thành công
        if ($deleted) {
            return redirect()->route('admin.books.index')->with('success', 'Sách đã được xóa thành công!');
        } else {
            return redirect()->back()->with('error', 'Không thể xóa sách!');
        }
    }
}
