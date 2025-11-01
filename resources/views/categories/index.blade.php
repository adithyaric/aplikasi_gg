@extends('layouts.master')
@section('header')
<!-- Nav Header Component Start -->
<div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
        <div class="row">
            <div class="col-md-12">
                <div class="flex-wrap d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $title }}</h3>
                        <p>SPKT POLRES PACITAN</p>
                    </div>
                    <div>
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        <a href="#" class="btn btn-link btn-soft-light" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            Tambah Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- -------------------- MODAL TAMBAH (persis style-mu) -------------------- --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modalTambahLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- -------------------- MODAL EDIT (style persis) -------------------- --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius:15px; border:1px solid #ddd; box-shadow:0 8px 20px rgba(0,0,0,0.2);">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="modalEditLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <form id="formEdit" method="POST" action="{{ route('categories.update', ['category' => '__id__']) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" id="edit_id">

                                <div class="form-group mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="name" id="edit_name" class="form-control" required>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px; border: 1px solid #ddd; box-shadow: 0 8px 20px rgba(0,0,0,0.2);">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalDeleteLabel">Apakah Kamu Yakin ?</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kategori <strong id="delete_name"></strong>?</p>
                    <form id="formDelete" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="delete_id">

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="iq-header-img">
        <img src="{{ asset('assets/images/dashboard/top-header.png') }}" alt="header" class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
    </div>
</div>


@endsection
@section('container')
<div class="conatiner-fluid content-inner mt-n5 py-0">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Data Kategori</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="custom-datatable-entries">
                        <table id="datatable" class="table table-striped" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        {{-- DETAIL --}}
                                        <a title="Detail" href="#" class="btn btn-icon btn-info">
                                            <span class="btn-inner">
                                                {{-- gunakan svg icon mu (atau biarkan seperti ini) --}}
                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 11.9993C2 6.48027 6.48 1.99927 12 1.99927C17.53 1.99927 22 6.48027 22 11.9993C22 17.5203 17.53 21.9993 12 21.9993C6.48 21.9993 2 17.5203 2 11.9993ZM11.12 8.20927C11.12 7.73027 11.52 7.32927 12 7.32927C12.48 7.32927 12.87 7.73027 12.87 8.20927V12.6293C12.87 13.1103 12.48 13.4993 12 13.4993C11.52 13.4993 11.12 13.1103 11.12 12.6293V8.20927ZM12.01 16.6803C11.52 16.6803 11.13 16.2803 11.13 15.8003C11.13 15.3203 11.52 14.9303 12 14.9303C12.49 14.9303 12.88 15.3203 12.88 15.8003C12.88 16.2803 12.49 16.6803 12.01 16.6803Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </a>

                                        {{-- EDIT --}}
                                        <a title="Edit" href="#" class="btn btn-icon btn-success"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}">
                                            <span class="btn-inner">
                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.3764 20.0279L18.1628 8.66544C18.6403 8.0527 18.8101 7.3443 18.6509 6.62299C18.513 5.96726 18.1097 5.34377 17.5049 4.87078L16.0299 3.69906C14.7459 2.67784 13.1541 2.78534 12.2415 3.95706L11.2546 5.23735C11.1273 5.39752 11.1591 5.63401 11.3183 5.76301C11.3183 5.76301 13.812 7.76246 13.8651 7.80546C14.0349 7.96671 14.1622 8.1817 14.1941 8.43969C14.2471 8.94493 13.8969 9.41792 13.377 9.48242C13.1329 9.51467 12.8994 9.43942 12.7297 9.29967L10.1086 7.21422C9.98126 7.11855 9.79025 7.13898 9.68413 7.26797L3.45514 15.3303C3.0519 15.8355 2.91395 16.4912 3.0519 17.1255L3.84777 20.5761C3.89021 20.7589 4.04939 20.8879 4.24039 20.8879L7.74222 20.8449C8.37891 20.8341 8.97316 20.5439 9.3764 20.0279ZM14.2797 18.9533H19.9898C20.5469 18.9533 21 19.4123 21 19.9766C21 20.5421 20.5469 21 19.9898 21H14.2797C13.7226 21 13.2695 20.5421 13.2695 19.9766C13.2695 19.4123 13.7226 18.9533 14.2797 18.9533Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </a>

                                        {{-- DELETE --}}
                                        <a title="Hapus" href="#" class="btn btn-icon btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDelete"
                                            data-id="{{ $category->id }}"
                                            data-name="{{ $category->name }}">
                                            <span class="btn-inner">
                                                <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.2871 5.24297C20.6761 5.24297 21 5.56596 21 5.97696V6.35696C21 6.75795 20.6761 7.09095 20.2871 7.09095H3.71385C3.32386 7.09095 3 6.75795 3 6.35696V5.97696C3 5.56596 3.32386 5.24297 3.71385 5.24297H6.62957C7.22185 5.24297 7.7373 4.82197 7.87054 4.22798L8.02323 3.54598C8.26054 2.61699 9.0415 2 9.93527 2H14.0647C14.9488 2 15.7385 2.61699 15.967 3.49699L16.1304 4.22698C16.2627 4.82197 16.7781 5.24297 17.3714 5.24297H20.2871ZM18.8058 19.134C19.1102 16.2971 19.6432 9.55712 19.6432 9.48913C19.6626 9.28313 19.5955 9.08813 19.4623 8.93113C19.3193 8.78413 19.1384 8.69713 18.9391 8.69713H5.06852C4.86818 8.69713 4.67756 8.78413 4.54529 8.93113C4.41108 9.08813 4.34494 9.28313 4.35467 9.48913C4.35646 9.50162 4.37558 9.73903 4.40755 10.1359C4.54958 11.8992 4.94517 16.8102 5.20079 19.134C5.38168 20.846 6.50498 21.922 8.13206 21.961C9.38763 21.99 10.6811 22 12.0038 22C13.2496 22 14.5149 21.99 15.8094 21.961C17.4929 21.932 18.6152 20.875 18.8058 19.134Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    // EDIT
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.addEventListener('show.bs.modal', function(event) {
        const btn = event.relatedTarget;
        const id = btn.getAttribute('data-id');

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = btn.getAttribute('data-name') || '';

        const form = document.getElementById('formEdit');
        form.action = "{{ route('categories.update', ['category' => '__id__']) }}".replace('__id__', id);
    });

    // DELETE
    document.addEventListener('DOMContentLoaded', function() {
        const modalDelete = document.getElementById('modalDelete');
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const btn = event.relatedTarget;
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');

            document.getElementById('delete_id').value = id;
            document.getElementById('delete_name').textContent = name;

            const formDelete = document.getElementById('formDelete');
            formDelete.action = `/categories/${id}`;
        });
    });
</script>
@endpush
