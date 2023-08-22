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
                                <h5 class="mb-0">List Izin dan Sakit Pegawai</h5>
                            </div>
                            <a href="/absence-management/create" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">+&nbsp;
                                Pengajuan Baru</a>
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
                                        <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal Izin
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Selama
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Persetujuan
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absences as $key => $absence)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $absence->user->nama }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $absence->status }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($absence->tanggal_izin)->format('d F Y') }}
                                                </span>
                                            </td>
                                            <td style="padding-left: 1.5rem">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    @if ($absence->tipe === 'jam')
                                                        {{ $absence->jumlah_jam }} jam
                                                    @else
                                                        {{ $absence->jumlah_jam / 8 }} hari
                                                    @endif
                                                </p>
                                            </td>
                                            <td>
                                                @if ($absence->approved === 'butuh persetujuan')
                                                    <div class="text-center">
                                                        <i class="fas fa-check-circle text-success cursor-pointer mx-1"
                                                            data-bs-toggle="modal" data-bs-target="#absenceModal"
                                                            data-id="{{ $absence->id }}" data-approved="disetujui"></i>
                                                        <i class="fas fa-times-circle text-danger cursor-pointer mx-1"
                                                            data-bs-toggle="modal" data-bs-target="#absenceModal"
                                                            data-id="{{ $absence->id }}" data-approved="ditolak"></i>
                                                    </div>
                                                @else
                                                    <p class="text-xs font-weight-bold mb-0 text-capitalize text-center">
                                                        {{ $absence->approved }}</p>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="/absence-management/{{ $absence->id }}/show" class="mx-3"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Lihat Absensi">
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
    <div class="modal fade" id="absenceModal" tabindex="-1" role="dialog" aria-labelledby="absenceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="absenceModalLabel">Label</h5>
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
                        <input type="hidden" name="approved" id="absence.approved" value="">
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
                select: [0, 2, 4, 5, 6],
                sortable: false
            }, ],
        });
    </script>
    <script>
        $('#absenceModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang membuka modal
            var userId = button.data('id'); // Ambil data user ID dari tombol
            var approved = button.data('approved')
            var modal = $(this);
            $('#absenceModalLabel').text((approved === 'disetujui' ? 'Setujui' : 'Tolak') + ' Pengajuan')
            $('#buttonYa').addClass(approved === 'disetujui' ? 'bg-gradient-success' : 'bg-gradient-danger')
            $('#buttonYa').removeClass(approved === 'disetujui' ? 'bg-gradient-danger' : 'bg-gradient-success')
            var approvedInput = document.getElementById('absence.approved');
            approvedInput.value = approved
            console.log(approvedInput)
            modal.find('#absence-approved-form').attr('action', 'absence-management/' + userId + '/approved');
        });
    </script>
@endsection
