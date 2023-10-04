@extends('layouts.user_type.auth')
@php
    use Illuminate\Support\Facades\Auth;
    $isAdmin = (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
@endphp
@section('content')
    <div>
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                    <div class="mt-3 mb-4 mx-4 alert alert-primary alert-dismissible fade show" role="alert">
                        <span class="alert-text text-white">
                            {{ session('error') }}</span>
                        <button type="button" class="btn-close p-3" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                @if (session('success'))
                    <div class="m-3 mb-4 mx-4 alert alert-success alert-dismissible fade show" id="alert-success"
                        role="alert">
                        <span class="alert-text text-white">
                            {{ session('success') }}</span>
                        <button type="button" class="btn-close p-3" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                @endif
                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Daftar Pegawai</h5>
                            </div>
                            @if($isAdmin)
                            <a href="/user-management/create" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">+&nbsp;
                                Pegawai
                                Baru</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="datatable-basic">
                                <caption></caption>
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Jabatan
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Mulai Bekerja
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->nama }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $user->jabatan }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($user->mulai_bekerja)->format('d F Y') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($isAdmin)
                                                <a href="/user-management/{{ $user->id }}/edit" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Edit user">
                                                    <i class="fas fa-user-edit text-secondary"></i>
                                                </a>
                                                <i class="fas fa-trash text-secondary cursor-pointer" data-bs-toggle="modal"
                                                    data-bs-target="#userDeleteModal" data-id="{{ $user->id }}"></i>
                                                @else
                                                <a href="/user-management/{{ $user->id }}" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Lihat Absensi">
                                                    <i class="fas fa-eye text-secondary"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="userDeleteModal" tabindex="-1" role="dialog" aria-labelledby="userDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="userDeleteModalLabel">Hapus Data Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tidak</button>
                    <form id="user-delete-form" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn bg-gradient-primary">Ya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-content')
    <script type="text/javascript">
        const dataTableBasic = new simpleDatatables.DataTable("#datatable-basic", {
            searchable: true,
            fixedHeight: true,
            columns: [{
                select: [0, 3, 5],
                sortable: false
            }, ],
            perPageSelect: [10, 25, 50, 100, 200]
        });
    </script>
    <script>
        $('#userDeleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang membuka modal
            var userId = button.data('id'); // Ambil data user ID dari tombol
            var modal = $(this);
            modal.find('#user-delete-form').attr('action', 'user-management/' + userId);
        });
    </script>
@endsection
