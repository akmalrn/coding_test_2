@extends('layouts.app')
@section('title', 'Books')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>List Of Books</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBookModal">
            Add Book
        </button>
    </div>

    <div class="d-flex gap-3 mb-3">
        <div class="row d-flex gap-3 flex-wrap mb-3">
            <!-- Form Pencarian Buku Berdasarkan Kata Kunci -->
            <div class="col-md-6">
                <form action="{{ route('books.search') }}" method="GET" class="d-flex">
                    <input type="text" name="query" id="searchInput" class="form-control me-2"
                           placeholder="Search books..." value="{{ request('query') }}" required>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        
            <!-- Form Pencarian Buku Berdasarkan Penulis -->
            <div class="col-md-6">
                <form action="{{ route('books.search.by.author') }}" method="GET" class="d-flex">
                    <select name="author_id" id="authorSelect" class="form-select me-2" required>
                        <option value="">Pilih Penulis</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}"
                                {{ request('author_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->first_name . ' ' . $author->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-success">Cari Buku</button>
                </form>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $book->isbn }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ optional($book->author)->first_name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editBookModal-{{ $book->id }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                        <form method="POST" action="{{ route('books.destroy', $book->id) }}" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>                                           
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editBookModal-{{ $book->id }}" tabindex="-1"
                    aria-labelledby="editBookModalLabel-{{ $book->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('books.update', $book->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBookLabel-{{ $book->id }}">Edit Buku ID {{ $book->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="isbn_{{ $book->id }}" class="form-label">ISBN</label>
                                        <input type="text" class="form-control" id="isbn_{{ $book->id }}" name="isbn"
                                               value="{{ old('isbn', $book->isbn) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="title_{{ $book->id }}" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title_{{ $book->id }}" name="title"
                                               value="{{ old('title', $book->title) }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="author_id_{{ $book->id }}" class="form-label">Author</label>
                                        <select name="author_id" id="author_id_{{ $book->id }}" class="form-select" required>
                                            @foreach (\App\Models\Author::all() as $author)
                                                <option value="{{ $author->id }}" {{ $author->id == $book->author_id ? 'selected' : '' }}>
                                                    {{ $author->first_name . ' ' . $author->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada buku</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal Create -->
    <div class="modal fade" id="createBookModal" tabindex="-1" aria-labelledby="createBookLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('books.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createBookLabel">Tambah Buku Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="isbn_create" class="form-label">ISBN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="isbn_create" name="isbn" value="{{ old('isbn') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="title_create" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title_create" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="author_id_create" class="form-label">Author <span class="text-danger">*</span></label>
                            <select name="author_id" id="author_id_create" class="form-select" required>
                                @foreach (\App\Models\Author::all() as $author)
                                    <option value="{{ $author->id }}">{{ $author->first_name . ' ' . $author->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Buku</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection