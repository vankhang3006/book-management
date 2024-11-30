<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Bản Sao Sách</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

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

    <!-- Form chỉnh sửa bản sao sách -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-center">Chỉnh Sửa Bản Sao Sách</h1>
        <div class="mb-4 text-right">
            <a href="{{ route('admin.book_copies.index') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Quay về danh sách</a>
        </div>
        <form action="{{ route('admin.book_copies.update', $bookCopy) }}" method="POST" class="space-y-6 bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <!-- Chọn sách -->
            <div>
                <label for="book_id" class="block text-gray-700 font-medium mb-2">Chọn Sách</label>
                <select name="book_id" id="book_id" class="w-full border border-gray-300 rounded p-2">
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" {{ $bookCopy->book_id == $book->id ? 'selected' : '' }}>
                            {{ $book->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Mã bản sao -->
            <div>
                <label for="code" class="block text-gray-700 font-medium mb-2">Mã Bản Sao</label>
                <input 
                    type="text" 
                    name="code" 
                    id="code" 
                    value="{{ $bookCopy->code }}" 
                    class="w-full border border-gray-300 rounded p-2"
                    required
                >
            </div>

            <!-- Trạng thái -->
            <div>
                <label for="status" class="block text-gray-700 font-medium mb-2">Trạng Thái</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded p-2">
                    <option value="available" {{ $bookCopy->status == 'available' ? 'selected' : '' }}>Có sẵn</option>
                    <option value="borrowed" {{ $bookCopy->status == 'borrowed' ? 'selected' : '' }}>Đã mượn</option>
                    <option value="damaged" {{ $bookCopy->status == 'damaged' ? 'selected' : '' }}>Hư hỏng</option>
                    <option value="lost" {{ $bookCopy->status == 'lost' ? 'selected' : '' }}>Mất</option>
                </select>
            </div>

            <!-- Nút submit -->
            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                    Cập Nhật
                </button>
            </div>
        </form>
    </div>

</body>
</html>
