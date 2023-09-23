@extends('layouts.user_type.auth')

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
                                <h5 class="mb-0">Daftar Bonus Pegawai</h5>
                            </div>
                            @if ($menuUrl === 'bonus-management')
                            <a href="/bonus-management/create" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">+&nbsp;
                                Bonus Pegawai Baru</a>
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
                                            Pegawai
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bonus
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Periode
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Deskripsi
                                        </th>
                                        @if ($menuUrl === 'bonus-management')
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bonuses as $key => $bonus)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $bonus->user->nama }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    {{ $bonus->bonus }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    {{ date('F Y', strtotime($bonus->periode)) }}
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    {{ $bonus->deskripsi }}</p>
                                            </td>
                                            @if ($menuUrl === 'bonus-management')
                                            <td class="text-center">
                                                <a href="/bonus-management/{{ $bonus->id }}/edit"
                                                    class="mx-1" data-bs-toggle="tooltip"
                                                    data-bs-original-title="Edit Bonus Pegawai">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>
                                                <i class="fas fa-trash text-secondary cursor-pointer mx-1"
                                                    data-bs-toggle="modal" data-bs-target="#userDeleteModal"
                                                    data-id="{{ $bonus->id }}"></i>
                                            </td>
                                            @endif
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
                    <h5 class="modal-title font-weight-normal" id="userDeleteModalLabel">Hapus Bonus Pegawai</h5>
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
        const menuUrl = "{{ $menuUrl }}"
        console.log(menuUrl)
        const dataTableBasic = new simpleDatatables.DataTable("#datatable-basic", {
            searchable: true,
            fixedHeight: true,
            columns: [{
                select: menuUrl === 'bonus' ?  [0, 1, 4] : [0, 4, 5],
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
            modal.find('#user-delete-form').attr('action', 'bonus-management/' + userId);
        });
    </script>
@endsection
