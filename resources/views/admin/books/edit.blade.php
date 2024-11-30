<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Sách</title>
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
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4 text-center" >Chỉnh sửa Sách</h1>
        <div class="mb-4 text-right">
            <a href="{{ route('admin.books.index') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Quay về danh sách</a>
        </div>
        <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
            @csrf
            @method('PUT')
            
            <!-- Tên sách -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium">Tên sách</label>
                <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" class="w-full p-2 border border-gray-300 rounded" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tác giả -->
            <div class="mb-4">
                <label for="author" class="block text-gray-700 font-medium">Tác giả</label>
                <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" class="w-full p-2 border border-gray-300 rounded" required>
                @error('author')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Chọn Thể loại -->
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-medium">Thể loại</label>
                <select id="category_id" name="category_id" class="w-full p-2 border border-gray-300 rounded" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == old('category_id', $book->category_id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mô tả -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium">Mô tả</label>
                <textarea id="description" name="description" rows="4" class="w-full p-2 border border-gray-300 rounded">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hình ảnh -->
            <div class="mb-4">
                <label for="image" class="block text-gray-700 font-medium">Hình ảnh</label>
                <input type="file" id="image" name="image" class="w-full p-2 border border-gray-300 rounded">
                
                @if ($book->image)
                    <p class="text-sm text-gray-500 mt-1">Hình ảnh hiện tại:</p>
                    <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image" class="h-32 mt-2">
                @else
                    <p class="text-gray-500 mt-2">Không có hình ảnh.</p>
                @endif

                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit button -->
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cập nhật</button>
        </form>
    </div>

</body>
</html>
