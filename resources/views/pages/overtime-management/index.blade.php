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
                                <h5 class="mb-0">Daftar Lembur Pegawai</h5>
                            </div>
                            @if ($menuUrl !== 'overtime')
                                <a href="/overtime-management/create" class="btn bg-gradient-primary btn-sm mb-0"
                                    type="button">+&nbsp;
                                    Pengajuan Baru</a>
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
                                            Tanggal Lembur
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Selama
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Pegawai
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Pengawas
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Manajer
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($overtimes as $key => $overtime)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $overtime->user->nama }}</p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($overtime->tanggal)->format('d F Y') }}
                                                </span>
                                            </td>
                                            <td style="padding-left: 1.5rem">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $overtime->jumlah_jam }} jam
                                                </p>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center text-sm align-items-center">
                                                    @if ($menuUrl === 'overtime' && $overtime->approved_user === 'butuh persetujuan')
                                                        <i class="fas fa-check-circle text-success mx-1 cursor-pointer"
                                                            data-bs-toggle="modal" data-bs-target="#overtimeModal"
                                                            data-id="{{ $overtime->id }}" data-approved="disetujui"
                                                            data-by="user"></i>
                                                        <i class="fas fa-times-circle text-danger mx-1 cursor-pointer"
                                                            data-bs-toggle="modal" data-bs-target="#overtimeModal"
                                                            data-id="{{ $overtime->id }}" data-approved="ditolak"
                                                            data-by="user"></i>
                                                    @else
                                                        <span
                                                            class="badge badge-sm 
                                                            @if ($overtime->approved_user === 'disetujui') bg-gradient-success
                                                            @elseif($overtime->approved_user === 'ditolak') 
                                                            bg-gradient-warning 
                                                            @else
                                                            bg-gradient-secondary @endif @if ($menuUrl === 'overtime') cursor-pointer @endif"
                                                            @if ($menuUrl === 'overtime') data-bs-toggle="modal" data-bs-target="#overtimeModal"
                                                            data-id="{{ $overtime->id }}" data-approved="butuh persetujuan"
                                                            data-by="user" @endif>
                                                            {{ $overtime->approved_user === 'butuh persetujuan' ? '-' : $overtime->approved_user }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center text-sm align-items-center">
                                                    <span
                                                        class="badge badge-sm 
                                                        @if ($overtime->approved_pengawas === 'disetujui') bg-gradient-success 
                                                        @elseif($overtime->approved_pengawas === 'ditolak') 
                                                        bg-gradient-warning 
                                                        @else
                                                        bg-gradient-secondary @endif">
                                                        {{ $overtime->approved_pengawas === 'butuh persetujuan' ? '-' : $overtime->approved_pengawas }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center text-sm align-items-center">
                                                    <span
                                                        class="badge badge-sm 
                                                        @if ($overtime->approved_manajer === 'disetujui') bg-gradient-success 
                                                        @elseif($overtime->approved_manajer === 'ditolak') 
                                                        bg-gradient-warning 
                                                        @else
                                                        bg-gradient-secondary @endif">
                                                        {{ $overtime->approved_manajer === 'butuh persetujuan' ? '-' : $overtime->approved_manajer }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="/overtime-management/{{ $overtime->id }}" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Lihat Lembur">
                                                    <i class="fas fa-eye text-secondary"></i>
                                                </a>
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
    <div class="modal fade" id="overtimeModal" tabindex="-1" role="dialog" aria-labelledby="overtimeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="overtimeModalLabel">Label</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tidak</button>
                    <form id="absence-approved-form" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="approved" id="overtime.approved" value="">
                        <input type="hidden" name="by" id="overtime.by" value="">
                        <button type="submit" class="btn" id="buttonYa">Ya</button>
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
                select: [0, 3, 4, 5, 6, 7],
                sortable: false
            }, ],
            perPageSelect: [10, 25, 50, 100, 200]
        });
    </script>
    <script>
        $('#overtimeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang membuka modal
            var overtimeID = button.data('id'); // Ambil data user ID dari tombol
            var approved = button.data('approved')
            var by = button.data('by')
            var modal = $(this);
            if (approved === "disetujui") {
                $('#overtimeModalLabel').text('Setujui Pengajuan')
                $('#buttonYa').addClass('bg-gradient-success')
                $('#buttonYa').removeClass('bg-gradient-danger')
                $('#buttonYa').removeClass('bg-gradient-info')
            } else if (approved === "ditolak") {
                $('#overtimeModalLabel').text('Tolak Pengajuan')
                $('#buttonYa').addClass('bg-gradient-danger')
                $('#buttonYa').removeClass('bg-gradient-success')
                $('#buttonYa').removeClass('bg-gradient-info')
            } else {
                $('#overtimeModalLabel').text('Batalkan Persetujuan Pengajuan')
                $('#buttonYa').addClass('bg-gradient-info')
                $('#buttonYa').removeClass('bg-gradient-success')
                $('#buttonYa').removeClass('bg-gradient-danger')
            }

            var approvedInput = document.getElementById('overtime.approved');
            approvedInput.value = approved
            var approvedBy = document.getElementById('overtime.by');
            approvedBy.value = by
            modal.find('#absence-approved-form').attr('action', '{{ $menuUrl }}/' + overtimeID + '/approved');
        });
    </script>
@endsection
