<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $bookId = $this->route('book')->id ?? null;

        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $bookId . '|max:20',
            'category_id' => 'required|integer|exists:categories,id',
            'publisher' => 'required|string|max:255',
            'year_published' => 'required|integer|min:1900|max:' . date('Y'),
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul buku harus diisi.',
            'title.max' => 'Judul buku tidak boleh lebih dari 255 karakter.',
            'author.required' => 'Nama penulis harus diisi.',
            'author.max' => 'Nama penulis tidak boleh lebih dari 255 karakter.',
            'isbn.required' => 'ISBN harus diisi.',
            'isbn.unique' => 'ISBN sudah terdaftar di sistem.',
            'isbn.max' => 'ISBN tidak boleh lebih dari 20 karakter.',
            'category_id.required' => 'Kategori harus dipilih.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'publisher.required' => 'Penerbit harus diisi.',
            'publisher.max' => 'Penerbit tidak boleh lebih dari 255 karakter.',
            'year_published.required' => 'Tahun terbit harus diisi.',
            'year_published.integer' => 'Tahun terbit harus berupa angka.',
            'year_published.min' => 'Tahun terbit minimal 1900.',
            'year_published.max' => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
            'stock.required' => 'Stok buku harus diisi.',
            'stock.integer' => 'Stok harus berupa angka.',
            'stock.min' => 'Stok tidak boleh kurang dari 0.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 1000 karakter.',
            'cover_image.image' => 'File harus berupa gambar.',
            'cover_image.mimes' => 'Gambar harus dalam format JPEG, PNG, JPG, atau GIF.',
            'cover_image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ];
    }
}
