<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Sách</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

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

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Danh sách Sách</h1>
        <div class="mb-4 text-right">
            <a href="{{ route('admin.books.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Thêm Sách</a>
        </div>
        <form action="{{ route('admin.books.index') }}" method="GET" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm sách theo tên"
                   class="w-1/3 p-2 border rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
        </form>

        <table class="w-full bg-white rounded shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 text-left">ID</th>
                    <th class="p-2 text-left">Tiêu đề</th>
                    <th class="p-2 text-left">Tác giả</th>
                    <th class="p-2 text-left">Thể loại</th>
                    <th class="p-2 text-left">Hình ảnh</th>
                    <th class="p-2 text-left">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td class="p-2">{{ $book->id }}</td>
                        <td class="p-2">{{ $book->title }}</td>
                        <td class="p-2">{{ $book->author }}</td>
                        <td class="p-2">{{ $book->category ? $book->category->name : 'Không có' }}</td> <!-- Hiển thị tên thể loại -->
                        <td class="p-2">
                            <!-- Hiển thị hình ảnh -->
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Hình ảnh sách" class="h-16">
                            @else
                                <p>Không có hình ảnh</p>
                            @endif
                        </td>
                        <td class="p-2">
                            <a href="{{ route('admin.books.edit', $book) }}" class="text-blue-500">Sửa</a> |
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Xóa</button>
                            </form>
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
            
        </table>

        <div class="mt-4">
            {{ $books->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </div>

</body>
</html>
