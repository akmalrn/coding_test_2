@extends('layouts.app')
@section('title', 'Author')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>List Of Authors</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAuthorModal">
            Add Author
        </button>
    </div>

    <div class="col-5 mb-3">
        <form action="{{ route('authors.search') }}" method="GET" class="d-flex">
            <input type="text" name="query" id="searchInput" class="form-control me-2" placeholder="Search authors..." required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>    

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($authors as $author)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $author->first_name }}</td>
                    <td>{{ $author->last_name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('authors.show', $author->id) }}" class="btn btn-sm btn-info" title="Lihat">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editAuthorModal-{{ $author->id }}" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        
                        <form method="POST" action="{{ route('authors.destroy', $author->id) }}" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>                                           
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editAuthorModal-{{ $author->id }}" tabindex="-1"
                    aria-labelledby="editAuthorModalLabel-{{ $author->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('authors.update', $author->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editAuthorLabel-{{ $author->id }}">Edit Penulis ID
                                        {{ $author->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="text" value="{{ $author->id }}">
                                    <div class="mb-3">
                                        <label for="first_name_{{ $author->id }}" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name_{{ $author->id }}"
                                            name="first_name" value="{{ old('first_name', $author->first_name) }}"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="last_name_{{ $author->id }}" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name_{{ $author->id }}"
                                            name="last_name" value="{{ old('last_name', $author->last_name) }}">
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
                    <td colspan="3" class="text-center">Belum ada penulis</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal Create -->
    <div class="modal fade" id="createAuthorModal" tabindex="-1" aria-labelledby="createAuthorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('authors.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAuthorLabel">Tambah Penulis Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="first_name_create" class="form-label">
                                First Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="first_name_create" name="first_name" value="{{ old('first_name') }}" required>
                            @if ($errors->has('first_name'))
                                <div class="text-danger small">{{ $errors->first('first_name') }}</div>
                            @endif
                        </div>                        
                        <div class="mb-3">
                            <label for="last_name_create" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name_create" name="last_name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Penulis</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
