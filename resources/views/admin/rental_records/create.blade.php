<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Bản ghi Thuê Sách</title>
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
        <h1 class="text-2xl font-bold mb-4 text-center">Thêm Bản ghi Thuê Sách</h1>
        <div class="mb-4 text-right">
            <a href="{{ route('admin.rental_records.index') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Quay về danh sách</a>
        </div>
        <form action="{{ route('admin.rental_records.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="book_copy_id">Chọn Bản sao Sách</label>
                <select name="book_copy_id" id="book_copy_id" class="block w-full">
                    @foreach ($bookCopies as $copy)
                        <option value="{{ $copy->id }}">{{ $copy->book->title }} (Mã: {{ $copy->code }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="user_id">Chọn Người Thuê</label>
                <select name="user_id" id="user_id" class="block w-full">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="rented_at">Ngày Thuê</label>
                <input type="date" name="rented_at" id="rented_at" class="block w-full">
            </div>

            <div class="mb-4">
                <label for="due_date">Ngày Hạn Trả</label>
                <input type="date" name="due_date" id="due_date" class="block w-full">
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tạo Mới</button>
        </form>
    </div>

</body>
</html>
