<?php

namespace App\Services;

use App\Models\category;
use Exception;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    protected $category;

    public function __construct(category $category)
    {
        $this->category = $category;
    }

    public function getList($search = null, $perPage = 5)
    {
        $query = $this->category->query();
    
        // Tìm kiếm theo tên nếu có từ khóa
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }
    
        // Phân trang
        return $query->paginate($perPage);
    }
    

    public function update($category, $params)
    {
        return $category->update($params);
    }

    public function createcategory(array $data)
    {
        try {
            return $this->category->create($data);
        } catch (Exception $exception) {
            Log::error($exception);
            return false;
        }
    }

    public function delete($category)
    {
        try {
            return $category->delete();
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }
    }

}
