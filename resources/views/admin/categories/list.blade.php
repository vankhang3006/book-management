<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Thể loại</title>
    <!-- Liên kết Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gray-800 p-4">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <a href="{{ route('admin.dashboard') }}" class="text-white text-xl font-semibold">Admin Panel</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a>
                    <a href="{{ route('admin.categories.index') }}" class="text-gray-300 hover:text-white">Categories</a>
                    <a href="{{ route('admin.books.index') }}" class="text-gray-300 hover:text-white">Books</a>
                    <a href="{{ route('admin.book_copies.index') }}" class="text-gray-300 hover:text-white">Book Copies</a>
                    <a href="{{ route('admin.rental_records.index') }}" class="text-gray-300 hover:text-white">Rental Records</a>
                    <a href="{{ route('admin.users.index') }}" class="text-gray-300 hover:text-white">Users</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Danh sách Thể loại</h1>

        <!-- Nút thêm mới -->
        <div class="mb-4 text-right">
            <a href="{{ route('admin.categories.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Thêm mới thể loại</a>
        </div>
        
        <!-- Form tìm kiếm -->
        <form action="{{ route('admin.categories.index') }}" method="GET" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" class="w-1/3 p-2 border rounded" placeholder="Tìm kiếm thể loại...">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
        </form>

        <!-- Bảng danh sách thể loại -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tên</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $category)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $category->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $category->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700">Sửa</a> | 
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="mt-4 flex justify-center">
            {{ $items->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </div>

</body>
</html>
