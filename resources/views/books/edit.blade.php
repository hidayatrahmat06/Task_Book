@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Buku</h1>
            <p class="text-gray-600 mt-1">Perbarui informasi buku</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('books.update', $book) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-book mr-2 text-blue-600"></i>Judul Buku
                    </label>
                    <input 
                        type="text" 
                        id="title"
                        name="title" 
                        value="{{ old('title', $book->title) }}"
                        placeholder="Masukkan judul buku"
                        @if($errors->has('title'))
                            class="w-full px-4 py-2 border border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        @else
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        @endif
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Author -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-blue-600"></i>Penulis
                    </label>
                    @if($errors->has('author'))
                        <input 
                            type="text" 
                            id="author"
                            name="author" 
                            value="{{ old('author', $book->author) }}"
                            placeholder="Masukkan nama penulis"
                            class="w-full px-4 py-2 border border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    @else
                        <input 
                            type="text" 
                            id="author"
                            name="author" 
                            value="{{ old('author', $book->author) }}"
                            placeholder="Masukkan nama penulis"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    @endif
                    @error('author')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- ISBN & Publisher Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-barcode mr-2 text-blue-600"></i>ISBN
                        </label>
                        @if($errors->has('isbn'))
                            <input 
                                type="text" 
                                id="isbn"
                                name="isbn" 
                                value="{{ old('isbn', $book->isbn) }}"
                                placeholder="Masukkan ISBN"
                                class="w-full px-4 py-2 border border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        @else
                            <input 
                                type="text" 
                                id="isbn"
                                name="isbn" 
                                value="{{ old('isbn', $book->isbn) }}"
                                placeholder="Masukkan ISBN"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        @endif
                        @error('isbn')
                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Publisher -->
                    <div>
                        <label for="publisher" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-building mr-2 text-blue-600"></i>Penerbit
                        </label>
                        @if($errors->has('publisher'))
                            <input 
                                type="text" 
                                id="publisher"
                                name="publisher" 
                                value="{{ old('publisher', $book->publisher) }}"
                                placeholder="Masukkan nama penerbit"
                                class="w-full px-4 py-2 border border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        @else
                            <input 
                                type="text" 
                                id="publisher"
                                name="publisher" 
                                value="{{ old('publisher', $book->publisher) }}"
                                placeholder="Masukkan nama penerbit"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        @endif
                        @error('publisher')
                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category & Year Published Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-2 text-blue-600"></i>Kategori
                        </label>
                        @if($errors->has('category_id'))
                            <select 
                                id="category_id"
                                name="category_id"
                                class="w-full px-4 py-2 border border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <select 
                                id="category_id"
                                name="category_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Year Published -->
                    <div>
                        <label for="year_published" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-calendar mr-2 text-blue-600"></i>Tahun Terbit
                        </label>
                        @if($errors->has('year_published'))
                            <input 
                                type="number" 
                                id="year_published"
                                name="year_published" 
                                value="{{ old('year_published', $book->year_published) }}"
                                min="1900"
                                max="{{ date('Y') }}"
                                placeholder="Contoh: 2024"
                                class="w-full px-4 py-2 border border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        @else
                            <input 
                                type="number" 
                                id="year_published"
                                name="year_published" 
                                value="{{ old('year_published', $book->year_published) }}"
                                min="1900"
                                max="{{ date('Y') }}"
                                placeholder="Contoh: 2024"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        @endif
                        @error('year_published')
                            <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-boxes mr-2 text-blue-600"></i>Stok Buku
                    </label>
                    @if($errors->has('stock'))
                        <input 
                            type="number" 
                            id="stock"
                            name="stock" 
                            value="{{ old('stock', $book->stock) }}"
                            min="0"
                            placeholder="Masukkan jumlah stok"
                            class="w-full px-4 py-2 border border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    @else
                        <input 
                            type="number" 
                            id="stock"
                            name="stock" 
                            value="{{ old('stock', $book->stock) }}"
                            min="0"
                            placeholder="Masukkan jumlah stok"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    @endif
                    @error('stock')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-2 text-blue-600"></i>Deskripsi Buku
                    </label>
                    @if($errors->has('description'))
                        <textarea 
                            id="description"
                            name="description" 
                            rows="4"
                            placeholder="Masukkan deskripsi atau sinopsis buku (opsional)"
                            class="w-full px-4 py-2 border border-red-500 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >{{ old('description', $book->description) }}</textarea>
                    @else
                        <textarea 
                            id="description"
                            name="description" 
                            rows="4"
                            placeholder="Masukkan deskripsi atau sinopsis buku (opsional)"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >{{ old('description', $book->description) }}</textarea>
                    @endif
                    @error('description')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image mr-2 text-blue-600"></i>Sampul Buku
                    </label>
                    
                    <!-- Current Image Preview -->
                    @if($book->cover_image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Sampul saat ini:</p>
                            <img 
                                src="{{ asset('storage/' . $book->cover_image) }}" 
                                alt="{{ $book->title }}"
                                class="w-32 h-40 object-cover rounded-lg"
                            >
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition" id="imageDropZone">
                        <input 
                            type="file" 
                            id="cover_image"
                            name="cover_image" 
                            accept="image/*"
                            class="hidden"
                        >
                        <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-3 block"></i>
                        <p class="text-gray-600 font-medium">Klik atau drag gambar baru di sini</p>
                        <p class="text-gray-400 text-sm mt-1">Maksimal 2MB (JPEG, PNG, JPG, GIF)</p>
                    </div>
                    <div id="imagePreview" class="mt-3 hidden">
                        <img id="previewImg" class="w-32 h-40 object-cover rounded-lg mx-auto">
                    </div>
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-4 border-t">
                    <button 
                        type="submit"
                        class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                    >
                        <i class="fas fa-save mr-2"></i>Perbarui Buku
                    </button>
                    <a 
                        href="{{ route('books.show', $book) }}"
                        class="flex-1 px-6 py-3 bg-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-400 transition text-center"
                    >
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const imageDropZone = document.getElementById('imageDropZone');
    const imageInput = document.getElementById('cover_image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    // Click to upload
    imageDropZone.addEventListener('click', () => imageInput.click());

    // Drag and drop
    imageDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageDropZone.classList.add('border-blue-500', 'bg-blue-50');
    });

    imageDropZone.addEventListener('dragleave', () => {
        imageDropZone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    imageDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        imageDropZone.classList.remove('border-blue-500', 'bg-blue-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            previewImage();
        }
    });

    // File input change
    imageInput.addEventListener('change', previewImage);

    function previewImage() {
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
