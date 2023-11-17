@extends('layouts.user_type.auth')

@section('content')
    <style>
        .ql-container{
            height: auto !important;
        }
    </style>
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
                                <h5 class="mb-0">Daftar Pengumuman</h5>
                            </div>
                            @if($menuUrl !== 'announcement')
                            <a href="/announcement-management/create" class="btn bg-gradient-primary btn-sm mb-0"
                                type="button">+&nbsp;
                                Pengumuman
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
                                            Judul
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Oleh
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($announcements as $key => $announcement)
                                        <tr>
                                            <td class="ps-4">
                                                <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $announcement->judul }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    {{ $announcement->user->nama }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-center font-weight-bold mb-0">
                                                    {{ $announcement->active ? 'Aktif' : 'Nonaktif' }}</p>
                                            </td>
                                            @if($menuUrl === 'announcement')
                                                <td class="text-center">
                                                    <a href="#" onclick="onPreviewAnnouncement({{$key}})" class="mx-3"
                                                        data-bs-toggle="tooltip" data-bs-original-title="Lihat Pengumuman">
                                                        <i class="fas fa-eye text-secondary"></i>
                                                    </a>
                                                </td>
                                            @else
                                            <td class="text-center">
                                                @if ($announcement->user->id === auth()->user()->id)
                                                    <a href="/announcement-management/{{ $announcement->id }}/edit"
                                                        class="mx-1" data-bs-toggle="tooltip"
                                                        data-bs-original-title="Edit pengumuman">
                                                        <i class="fas fa-edit text-secondary"></i>
                                                    </a>
                                                    <i class="fas fa-trash text-secondary cursor-pointer mx-1"
                                                        data-bs-toggle="modal" data-bs-target="#userDeleteModal"
                                                        data-id="{{ $announcement->id }}"></i>
                                                @endif
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
                    <h5 class="modal-title font-weight-normal" id="userDeleteModalLabel">Hapus Data Pengumuman</h5>
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
    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="announcementModalLabel">Modal title</h5>
            </div>
            <div class="modal-body" style="height: 358px; overflow:auto">
                <img id="banner" class="w-100 mb-3" alt="..." style="object-fit:cover; height:320px">
                <div id="deskripsi"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    @php
        $active = false;
        $data = [
            'user_id' => Auth::user()->id,
            'label' => 'Pengumuman',
            'icon' => 'fa-newspaper',
            'url' => $menuUrl,
        ];
        if(in_array($data, $favorites)){
            $active = true;
        }
    @endphp
    @include('components.fixed-plugin', [
        'active' => $active,
        ...$data
    ])
@endsection
@section('page-content')
    <script type="text/javascript">
        const dataTableBasic = new simpleDatatables.DataTable("#datatable-basic", {
            searchable: true,
            fixedHeight: true,
            columns: [{
                select: [0, 3, 4],
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
            modal.find('#user-delete-form').attr('action', 'announcement-management/' + userId);
        });
    </script>
    <script>
        var quill = new Quill('#deskripsi', {
            readOnly: true,
            theme: 'bubble'  // or 'bubble'
        });
    </script>
    <script>
        const announcements = @json($announcements);
        var myModal = null
        document.addEventListener('DOMContentLoaded', function () {
            myModal = new bootstrap.Modal(document.getElementById('announcementModal'));
        });
        function onPreviewAnnouncement(index){
            var baseUrl = window.location.origin;
            const announcement = announcements[index]
            var judul = document.getElementById("announcementModalLabel")
            judul.textContent = announcement.judul
            var banner = document.getElementById("banner")
            banner.style.display = 'none'
            if(!!announcement.banner){
                banner.style.display = 'block'
                banner.src = baseUrl + '/' + announcement.banner
            }
            var editorContent = announcement.deskripsi;
            quill.setContents(JSON.parse(editorContent));
            myModal.show()
        }
    </script>
@endsection
