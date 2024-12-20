@extends('index')
@section('content')

<style>
    .dropdown {
        position: relative;
        display: inline-block;
        margin-top:2.5px;
    }

    .dropdown-button {
        display: inline-flex;
        align-items: center;
        column-gap: 0.5rem;
        border-radius: 0.375rem;
        background: white;
        padding: 0.625rem 0.875rem;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 600;
        color: #13547a;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border: none;
        outline: 1px solid #13547a;
        cursor: pointer;
        border-radius:20px
    }
    .dropdown-button:hover {
        background: #13547a;
        color: #fff;
    }

    .chevron-icon {
        width: 1rem;
        height: 1rem;
        transform: rotate(0);
        transition: transform 0.3s ease;
    }
    .chevron-icon.rotate {
        transform: rotate(-180deg);
    }

</style>

<section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-12 mx-auto">
                <h1 class="text-white text-center">ISBN</h1>
                <form action="{{route('pencarian.index') }}" method="POST">
                @csrf
                    <h6 class="text-white text-center mb-4">International Standard Book Number</h6>
                        <div class="input-group input-group-lg">
                        <!-- <select id="filter_search" style="border-radius:100px; max-width: 250px;"  class="form-control select2">
                            <option value="all" >Semua</option>
                            <option value="PT.TITLE" >Judul </option>
                            <option value="PT.KEPENG" >Kepengarangan </option>
                            <option value="P.NAME" >Penerbit </option>
                            <option value="PI.ISBN_NO" >ISBN </option>
                        </select> -->
                        <!-- <div class="dropdown">
                            <button type="button" class="dropdown-button btn-lg" data-toggle="modal" data-target="#filter">
                                Filter
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="chevron" class="chevron-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </div> -->
                        <div class="input-group input-group-lg" >
                            <select id="jenis_media" style=" max-width: 200px; border-radius:30px 0px 0px 30px" name="jenis_media"  class="form-control select2 ">
                                <option value="all">Semua Media</option>
                                <option value="1" >Buku Cetak</option>
                                <option value="2" >Pdf</option>
                                <option value="3" >Epub</option>
                                <option value="4" >Audio Book</option>
                                <option value="5" >Audio Visual</option>
                            </select>
                            <select id="filter_by" style=" max-width: 200px;" name="filter_by"  class="form-control select2 ">
                                <option value="all" >Semua Filter</option>
                                <option value="PT.TITLE">Judul </option>
                                <option value="PT.KEPENG" >Kepengarangan </option>
                                <option value="P.NAME">Penerbit </option>
                                <option value="PI.ISBN_NO">ISBN </option>
                            </select>
                            <input style="margin-left:20px" name="keyword" type="search" class="form-control" id="keyword_pencarian" placeholder="Masukan kata untuk mencari Judul, Pengarang, Penerbit, ISBN ..." aria-label="Search">
                            <button type="submit" class="">
                            <!-- <a  class="btn custom-btn mt-2 mt-lg-3" style="background-color: #13547a;" onclick="handleClickSearch()"><span class="input-group-text bi-search" id="basic-addon1" style="color:white"></span></a> -->
                                <!-- <a class="nav-link" onclick="handleClickSearch()"><span class="input-group-text bi-search" id="basic-addon1" style="color:white"></span></a> -->
                                <a class="nav-link"><span class="input-group-text bi-search" id="basic-addon1" style="color:white"></span></a>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="featured-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-12 mb-4 mb-lg-0">
                <div class="custom-block bg-white shadow-lg">
                    <div class="d-flex">
                        <div>
                            <h5 class="mb-2">ISBN</h5>
                            <p class="mb-0">
                                ISBN (International Standard Book Number) adalah deretan angka 13 digit sebagai pemberi identifikasi unik secara internasional terhadap satu buku maupun produk seperti buku yang diterbitkan oleh penerbit. Setiap nomor memberikan identifikasi unik untuk setiap terbitan buku dari setiap penerbit, sehingga keunikan tersebut memungkinkan pemasaran produk yang 
                                selengkapnya ...
                            </p>
                        </div>
                    </div>
                    <div>
                        <center>
                            <a href="{{ url('isbn_info') }}" class="btn btn-outline-success mt-2 mt-lg-3" style="padding: 10px 20px; border-radius:100px">Selengkapnya</a>
                            <a href="{{ url('pendaftaran_online') }}" class="btn custom-btn mt-2 mt-lg-3">Daftar Online</a>
                        </center>
                    </div>
                    <!-- /<img src="{{ asset('template/images/icon_1.png') }}" class="custom-block-image img-fluid" alt=""> -->
                </div>
            </div>
            <div class="col-lg-3 col-12">
                <div class="custom-block custom-block-overlay">
                    <div class="d-flex flex-column h-100">
                        <img src="{{ asset('template/images/icon_1.png') }}" class="custom-block-image img-fluid" alt="">
                        <div class="custom-block-overlay-text">
                            <h5 class="text-white mt-2">Prosedur</h5> 
                            <p class="text-white">
                                Informasi tentang Prosedur Pendaftaran Penerbit dan Permohonan ISBN
                            </p>
                            <center>
                                <a href="{{ url('prosedur') }}" class="btn custom-btn mt-2 mt-lg-3">Selengkapnya</a>
                            </center>
                        </div>
                        <div class="section-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="explore-section section-padding" id="section_2">
    <div class="container">
            <div class="col-12 text-center">
                <h2 class="mb-4">Cari Topik Tentang</h1>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance-tab-pane" type="button" role="tab" aria-controls="finance-tab-pane" aria-selected="false">Berita</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="education-tab" data-bs-toggle="tab" data-bs-target="#education-tab-pane" type="button" role="tab" aria-controls="education-tab-pane" aria-selected="false">Statistik</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="marketing-tab" data-bs-toggle="tab" data-bs-target="#marketing-tab-pane" type="button" role="tab" aria-controls="marketing-tab-pane" aria-selected="false">BIP</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="music-tab" data-bs-toggle="tab" data-bs-target="#music-tab-pane" type="button" role="tab" aria-controls="music-tab-pane" aria-selected="false">Surat</button>
                </li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="finance-tab-pane" role="tabpanel" aria-labelledby="finance-tab" tabindex="0">   
                       @include('content.home_berita')
                    </div>
                    <div class="tab-pane fade " id="education-tab-pane" role="tabpanel" aria-labelledby="education-tab" tabindex="0">
                        <div class="row">
                            <!-- detail statistik singkat-->
                            <div class="col-lg-12 col-md-12 col-12 mb-12 mb-lg-12" id="statistik_singkat">
                                <div class="custom-block bg-white shadow-lg">
                                    <div class="d-flex">
                                        <div>
                                            <h5 class="mb-2">Statistik</h5>
                                            <p class="mb-0">
                                                Informasi tentang penomoran Isbn dan data-data statistik per tahun, per bulan, per provinsi dan data lainnya <br> <br>
                                                <!-- <b> 1. Pendahuluan </b><br> -->
                                                Perpustakaan Nasional RI Sebagai badan yang ditunjuk oleh International ISBN Agency untuk mengelola International Standard Book Number (ISBN) di Indonesia sejak tahun 1986, telah menjalankan tugasnya mengelola dan mendistribusikan penomoran ISBN kepada seluruh penerbit yang ada di wilayah negara kesatuan Republik Indonesia.
                                            </p>
                                            <a href="{{ url('statistik') }}" class="btn custom-btn mt-2 mt-lg-3" style="background-color: #13547a;">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- BIP PAGE --}}
                    <div class="tab-pane fade" id="marketing-tab-pane" role="tabpanel" aria-labelledby="marketing-tab" tabindex="0">
                        @include('content.home_bip')
                    </div>
                    <div class="tab-pane fade" id="music-tab-pane" role="tabpanel" aria-labelledby="music-tab" tabindex="0">
                        @include('content.home_surat')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- section alur daftar -->
<section class="timeline-section section-padding" id="section_3">
    <div class="section-overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white mb-4">Alur Pendaftaran ISBN Online?</h1>
            </div>
            <div class="col-lg-10 col-12 mx-auto">
                <div class="timeline-container">
                    <ul class="vertical-scrollable-timeline" id="vertical-scrollable-timeline" style="margin-top: 10px;">
                        <div class="list-progress">
                            <div class="inner"></div>
                        </div>
                        <li>
                            <h4 class="text-white mb-3">Daftar Online ISBN</h4>
                            <p class="text-white">Mulai dengan unggah berkas yang akan dimintakan nomornya</p>
                            <div class="icon-holder">
                                <i class="bi-search"></i>
                            </div>
                        </li>
                        <li>
                            <h4 class="text-white mb-3">Verifikasi Berkas</h4>
                            <p class="text-white">Berkas akan diverifikasi dan diinput sesuai dengan permintaan penerbit.</p>
                            <div class="icon-holder">
                                <i class="bi-bookmark"></i>
                            </div>
                        </li>
                        <li>
                            <h4 class="text-white mb-3">Nomor ISBN selesai</h4>
                            <p class="text-white">Nomor ISBN yang diminta akan keluar dan bisa diunduh mandiri di akun penerbit.</p>
                            <div class="icon-holder">
                                <i class="bi-book"></i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-12 text-center mt-5">
                <p class="text-white">
                    <a href="{{ url('prosedur') }}" class="btn custom-btn custom-border-btn ms-3">Pelajari Lebih Lanjut</a>
                </p>
            </div>
        </div>
    </div>
</section>
<!-- end alur daftar -->

<!-- section pertanyaan -->
<section class="faq-section section-padding" id="section_4">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <h2 class="mb-4">Pertanyaan yang sering di ajukan</h2>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-5 col-12">
                <img src="{{ asset('template/images/icon_5.png') }}" class="img-fluid" alt="FAQs">
            </div>
            <div class="col-lg-6 col-12 m-auto">
                <div class="accordion" id="accordionExample">
                    @php $no = 1; @endphp
                    @foreach($dataFaq as $v)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{$no}}">
                            <button class="accordion-button @if($no > 1) collapsed @endif"  type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$no}}" aria-expanded="true" aria-controls="collapse{{$no}}">
                            {!! $v['JUDUL'] !!}
                            </button>
                        </h2>
                        <div id="collapse{{$no}}" class="accordion-collapse collapse @if($no == 1) show @endif" aria-labelledby="heading{{$no}}" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            {!! $v['ISI'] !!}
                                
                            </div>
                        </div>
                    </div>
                    @php $no++; @endphp
                    @endforeach

                    
                </div>
                <center>
                <a href="{{ url('detail_fnq') }}" class="btn custom-btn mt-2 mt-lg-3" style="background-color: #13547a;">Lihat semua pertanyaan</a>
                </center>
            </div>
        </div>
    </div>
</section>
<!-- end pertanyaan -->

<!-- Modal pengumuman-->
<div class="modal fade" id="imageModalPengumuman" tabindex="-1" aria-labelledby="imageModalLabelPengumuman" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <img id="modalImage" src="" alt="Image Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Modal pengumuman-->
<div class="modal fade" id="filter" tabindex="-1" aria-labelledby="filter" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <!-- <form action="{{route('pencarian.index') }}" method="POST">
                @csrf -->
                <div class="modal-header">
                    <center><h5 class="text-center">Filter Berdasarkan</h5></center>
                </div>
                <div class="modal-body">
                    <div class="row d-flex mb-3">

                        <div class="col-lg-12 col-md-12">
                            <label class="form-label mb-2">Jenis Media</label>
                            <select class="form-control "  name="jenis_media" id="options" required>
                                <option>-- Semua --</option>
                                <option value="1">Buku</option>
                                <option value="2">Pdf</option>
                                <option value="3">Epub</option>
                                <option value="4">Audio Book</option>
                                <option value="5">Audio Visual</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 mt-3">
                            <label class="form-label mb-2">Berdasarkan</label>
                            <select class="form-control "  name="filter_by" id="options" required>
                                <option value="all" >-- Semua -- </option>
                                <option value="PT.TITLE" >Judul </option>
                                <option value="PT.KEPENG" >Kepengarangan </option>
                                <option value="P.NAME" >Penerbit </option>
                                <option value="PI.ISBN_NO" >ISBN </option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 mt-3">
                            <label class="form-label mb-2">Keyword</label>
                            <input class="form-control " placeholder="Masukan kata untuk mencari Judul, Pengarang, Penerbit, No ISBN" id="" name="keyword" value="" required/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <center>
                    <div class="dropdown">
                        <button type="submit" class="dropdown-button btn-lg">
                            Filter
                        </button>
                    </div>
                    </center>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>


@push('scripts')
    <!-- modal pengumuman -->
    <script>
        function EmptyString(value) {
            return value == null || value == undefined || value.trim() == '';
        }
        // flyer
        document.addEventListener('DOMContentLoaded', (event) => {
            var url = window.location.href;
            // Extract the fragment identifier
            var fragment = window.location.hash;
            // You can also remove the '#' character if needed
            var section = fragment.substring(1);
            const appUrl = @json(config('app.url'));
            if (EmptyString(section)) {
                $.ajax({
                    url: "{{ route('flyer') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    serverSide: true,
                    success: function(data) {
                        const pathParts = data.split('/');
                        const filename = pathParts[pathParts.length - 1]; //krn dari server folder ikut tersimpan
                        // var data1 = appUrl + "/template/images/HasilSKMISBN2024Periode1.jpg" 
                        var data1 = appUrl + "/images/"+ filename //kalau live dihapus
                        showPengumuman(data1)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown); // Log any errors
                    }
                });
            }
        })
        function showPengumuman(imageUrl) {
            // Set the image source
            var imageElement = document.getElementById('modalImage');
            imageElement.src = imageUrl;
            // Wait for the image to load before showing the modal
            imageElement.onload = function() {
                var myModal = new bootstrap.Modal(document.getElementById('imageModalPengumuman'));
                myModal.show();
            };
        }
        //end flyer
    </script>
    
@endpush

@stack('scripts')

