<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Requests\Category\CreateRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ request
        $search = $request->input('search');
    
        // Lấy danh sách categories với tìm kiếm và phân trang
        $categories = $this->categoryService->getList($search);
    
        return view('admin.categories.list', [  // Sửa lại đường dẫn view
            'items' => $categories,
            'search' => $search // Truyền lại từ khóa tìm kiếm để hiển thị
        ]);
    }
    

    public function show(Category $category)
    {
        return view('admin.categories.show', ['Category' => $category]);  // Sửa lại đường dẫn view
    }

    public function edit(Category $Category)
    {
        return view('admin.categories.edit', ['Category' => $Category]);  // Sửa lại đường dẫn view
    }

    public function update(UpdateRequest $updateRequest, Category $Category)
    {
        $request = $updateRequest->validated();
        $result = $this->categoryService->update($Category, $request);

        if ($result) {
            return redirect()->route('admin.categories.index')->with('success','update success');  // Sửa lại route
        }

        return redirect()->route('admin.categories.index')->with('error','update failed');  // Sửa lại route
    }

    public function create()
    {
        return view('admin.categories.create');  // Sửa lại đường dẫn view
    }

    // Thêm Category mới
    public function store(CreateRequest $createRequest)
    {
        // Lấy dữ liệu đã được xác thực từ CreateRequest
        $data = $createRequest->validated();

        // Gọi service để tạo category
        $result = $this->categoryService->createCategory($data);

        // Kiểm tra nếu tạo category thành công
        if ($result) {
            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');  // Sửa lại route
        }

        return redirect()->back()->with('error', 'Failed to create Category');
    }

    public function destroy(Category $Category)
    {
        $result = $this->categoryService->delete($Category);

        if ($result) {
            return response()->json(['message' => 'delete success'], 200);
        }
    
        return response()->json(['message' => 'delete failed'], 500);
    }
}