@extends('layouts.user_type.guest')

@section('content')
    <link href="{{ asset('assets/css/_quill.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/plugins/quill.min.js') }}"></script>
    <script>
        let id=-1;
    </script>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-85" style="position: relative">
                <div class="bg-gradient-danger" style="position: absolute; 
                top:0; left:0; width:100%; height:100%;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto"">
                            <div class="card card-plain mt-8 bg-white">
                                <div class="card-body">
                                    <form role="form" method="POST" action="/session">
                                        @csrf
                                        <label>Username</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control" name="username" id="username"
                                                placeholder="Username" value="admin" aria-label="Username"
                                                aria-describedby="username-addon">
                                            @error('username')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password" value="secret" aria-label="Password"
                                                aria-describedby="password-addon">
                                            @error('password')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-danger w-100 mt-4 mb-0">Sign
                                                in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                    style="background-image:url('{{asset('assets/img/bg.jpg')}}')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($announcements) > 0)
            <div class="container py-5">
                <div class="row">
                    <h5 class="text-center mb-4">Pengumuman Terbaru</h5>
                    @foreach($announcements as $key=> $announcement)
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card card-blog p-2">
                            <div class="position-relative">
                                <a class="d-block shadow-xl border-radius-xl" style="width: 100%; height:200px">
                                    <img 
                                    src="@if($announcement->banner){{$announcement->banner}}@else{{asset('assets/img/white-curved.jpeg')}}@endif" 
                                    alt="img-blur-shadow" class="img-fluid shadow border-radius-xl w-100 h-100"
                                    style="object-fit:cover;">
                                </a>
                            </div>
                            <div class="card-body px-1 pb-0">
                                <h5 style="height: 82.5px; overflow:hidden;display: -webkit-box;
                                -webkit-line-clamp: 3;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                text-overflow: ellipsis;">
                                    {{$announcement->judul}}
                                </h5>
                                <div class="d-flex align-items-end justify-content-end">
                                    <button class="btn btn-outline-primary btn-sm mb-0 mb-2" onclick="onClickCarousel({{$key}})">Lihat Pengumuman</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </section>
    </main>
    <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="announcementModalLabel">Modal title</h5>
                <div style="text-align: end">
                    <i class="fas fa-chevron-circle-left mx-2" style="font-size: 28px; cursor: pointer;" id="btnPrev"></i>
                    <i class="fas fa-chevron-circle-right mx-2" style="font-size: 28px; cursor: pointer;" id="btnNext"></i>
                </div>
            </div>
            <div class="modal-body" style="height: 358px; overflow:auto">
                <div id="carouselAnnouncements" class="carousel slide" >
                    <div class="carousel-inner">
                        @foreach($announcements as $key => $announcement)
                        <div class="carousel-item @if($key === 0) active @endif">
                            @if(!!$announcement->banner)
                                <img src="{{ asset($announcement->banner) }}" class="d-block w-100 mb-3" alt="..." style="object-fit:cover; height:320px">
                            @endif
                            <div id="deskripsi-{{$announcement->id}}"></div>
                        </div>
                        <script>
                            id = '{{$announcement->id}}'
                            var quill = new Quill('#deskripsi-'+id, {
                                readOnly: true,
                                theme: 'bubble'  // or 'bubble'
                            });
                            var editorContent = @json($announcement->deskripsi);
                            quill.setContents(JSON.parse(editorContent));
                        </script>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var carousel = null
        var myModal = null
        var index = 0
        var judul = null
        const announcements = @json($announcements);
        document.addEventListener('DOMContentLoaded', function () {
            myModal = new bootstrap.Modal(document.getElementById('announcementModal'));
            if(announcements.length > 0){
                myModal.show();
                    carousel = new bootstrap.Carousel(document.getElementById('carouselAnnouncements'), {
                    interval: 0
                });
                judul = document.getElementById("announcementModalLabel")
                judul.textContent = announcements[index].judul
            }

            document.getElementById('btnPrev').addEventListener('click', function (e) {
                carousel.prev();
                if(index === 0){
                    index = announcements.length - 1
                }else{
                    index--
                }
                judul.textContent = announcements[index].judul
            });

            document.getElementById('btnNext').addEventListener('click', function () {
                carousel.next();
                if(index === (announcements.length - 1)){
                    index = 0
                }else{
                    index++
                }
                judul.textContent = announcements[index].judul
            });
        });
        function onClickCarousel(to){
            carousel.to(to)
            index = to
            judul.textContent = announcements[index].judul
            myModal.show()
        }
    </script>
@endsection