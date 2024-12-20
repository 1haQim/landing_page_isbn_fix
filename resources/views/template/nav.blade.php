<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }} ">
        <img src="{{ asset('template/images/logo.png') }}" class="" alt="" style="width: 280px;">
            <!-- <img src="{{ asset('template/images/logo.jpg') }}" class="" alt="" style="width: 120px;"> -->
        </a>

        <div class="d-lg-none ms-auto me-4">
            <a href="{{config('app.penerbit')}}" class="navbar-icon bi-person smoothscroll"></a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-5 me-lg-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }} text-center"  href="{{ url('/home') }}">Home</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link {{ Request::is('home#section_2') ? 'active' : '' }} text-center" href="{{ url('home#section_2') }}" onclick="clickMenus('statistik')">Topik</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ url('home#section_2') }}" onclick="clickMenus('berita')">Berita</a></li>
                        <li><a class="dropdown-item" href="{{ url('home#section_2') }}"  onclick="clickMenus('bip')">BIP</a></li>
                        <li><a class="dropdown-item" href="{{ url('home#section_2') }}"  onclick="clickMenus('surat')">Surat</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('isbn_info') ? 'active' : '' }} text-center" href="{{ url('isbn_info') }}">Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('statistik') ? 'active' : '' }} text-center" href="{{ url('statistik') }}">Statistik</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('detail_fnq') ? 'active' : '' }} text-center" href="{{ url('detail_fnq') }}">FAQs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('panduan_layanan') ? 'active' : '' }} text-center" href="{{ url('panduan_layanan') }}">Panduan Layanan</a>
                    <!-- <a class="nav-link " href="#" onclick="openModal(this)">Panduan Layanan</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('pelacakan') ? 'active' : '' }} text-center" href="{{ url('pelacakan') }}">Lacak Pengajuan</a>
                </li>
            </ul>

            <div class="d-none d-lg-block">
                <a href="{{config('app.penerbit')}}" class="navbar-icon bi-person smoothscroll"></a>
            </div>
        </div>
    </div>
</nav>
