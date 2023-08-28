@php
    use Illuminate\Support\Facades\Auth;
    $sectionMenu = [
        [
            'section' => '',
            'role' => 'user',
            'menus' => [
                [
                    'label' => 'Dashboard',
                    'icon' => 'fa-home',
                    'url' => 'dashboard',
                ],
                [
                    'label' => 'Absensi',
                    'icon' => 'fa-calendar-minus',
                    'url' => 'absence',
                ],
                [
                    'label' => 'Lembur',
                    'icon' => 'fa-user-clock',
                    'url' => 'overtime',
                ],
            ],
        ],
        [
            'section' => 'Menu Admin',
            'role' => 'admin',
            'menus' => [
                [
                    'label' => 'Data Pegawai',
                    'icon' => 'fa-users',
                    'url' => 'user-management',
                ],
                [
                    'label' => 'Absensi Pegawai',
                    'icon' => 'fa-calendar-check',
                    'url' => 'absence-management',
                ],
                [
                    'label' => 'Lembur Pegawai',
                    'icon' => 'fa-business-time',
                    'url' => 'overtime-management',
                ],
            ],
        ],
        [
            'section' => 'Menu Pengawas',
            'role' => 'pengawas',
            'menus' => [
                [
                    'label' => 'Persetujuan Lembur',
                    'icon' => 'fa-business-time',
                    'url' => 'overtime-approval',
                ],
            ],
        ],
        [
            'section' => 'Menu Manajer',
            'role' => 'manajer',
            'menus' => [
                [
                    'label' => 'Persetujuan Lembur',
                    'icon' => 'fa-business-time',
                    'url' => 'overtime-approval',
                ],
            ],
        ],
    ];
@endphp
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas custom-i-sm fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="/dashboard">
            <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="...">
            <span class="ms-3 font-weight-bold">Soft UI Dashboard Laravel</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @foreach ($sectionMenu as $section)
                @if ($section['role'] === 'user' || $section['role'] === Auth::user()->role)
                    <li class="nav-item mt-2">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                            {{ $section['section'] }}
                        </h6>
                    </li>
                    @foreach ($section['menus'] as $menu)
                        <li class="nav-item pb-2">
                            <a class="nav-link {{ Request::segment(1) === $menu['url'] ? 'active' : '' }}"
                                href="{{ url($menu['url']) }}">
                                <div
                                    class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                                    <i style="font-size: 1rem;"
                                        class="fas custom-i-sm fa-lg {{ $menu['icon'] }} ps-2 pe-2 text-center text-dark {{ Request::segment(1) === $menu['url'] ? 'text-white' : 'text-dark' }} "
                                        aria-hidden="true"></i>
                                </div>
                                <span class="nav-link-text ms-1">{{ $menu['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </div>
</aside>
