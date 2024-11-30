<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Bản sao Sách</title>
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

    <!-- Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">Danh sách Bản sao Sách</h1>
        <div class="mb-4 text-right">
            <a href="{{ route('admin.book_copies.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Thêm bản sao sách</a>
        </div>
        <form action="{{ route('admin.book_copies.index') }}" method="GET" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm..."
                   class="w-1/3 p-2 border rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
        </form>

        <table class="w-full bg-white rounded shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">ID</th>
                    <th class="p-2">Mã Code</th>
                    <th class="p-2">Sách</th>
                    <th class="p-2">Trạng thái</th>
                    <th class="p-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($copies as $copy)
                    <tr>
                        <td class="p-2">{{ $copy->id }}</td>
                        <td class="p-2">{{ $copy->code }}</td>
                        <td class="p-2">{{ $copy->book->title }}</td>
                        <td class="p-2">
                            @switch($copy->status)
                                @case('available')
                                    Có sẵn
                                    @break
                                @case('borrowed')
                                    Đã mượn
                                    @break
                                @case('damaged')
                                    Hư hỏng
                                    @break
                                @case('lost')
                                    Mất
                                    @break
                                @default
                                    Không xác định
                            @endswitch
                        </td>
                        <td class="p-2">
                            <a href="{{ route('admin.book_copies.edit', $copy) }}" class="text-blue-500">Sửa</a> |
                            <form action="{{ route('admin.book_copies.destroy', $copy) }}" method="POST" class="inline-block">
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
            {{ $copies->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </div>

</body>
</html>
