
@extends('index')
<style>
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
        color: #fff; /* Example color for active link text */
        background-color: red; /* Example color for active background */
    }
    .dataTables_filter {
        display: none;
    }
    .nav-link.active,.nav-pills .show>.nav-link {
        color: red;
        background-color: rgb(1, 34, 105);
    }
    .custom-loader-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .custom-loader {
        border: 8px solid #f3f3f3;
        border-top: 8px solid rgb(1, 34, 105);
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { 
            transform: rotate(0deg); 
        }
        100% { 
            transform: rotate(360deg); 
        }
    }

    #dataTable_paginate {
        margin-top:50px;
        display: flex;
        justify-content: center;
    }
</style>


@section('content')

<section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
    <div class="container">
        <div class="row">
            <!-- <div class="col-lg-3 col-12 mx-auto"></div>
            <div class="col-lg-8 col-12 mx-auto"> -->
                <h1 class="text-white text-center mb-10">Hasil Pencarian</h1>
                
            <!-- </div> -->
        </div>
    </div>
</section>
<div class="custom-loader-backdrop" id="datatable-loader" style="display: none;">
    <div class="custom-loader"></div>
</div>
<section class="explore-section section-padding" id="section_pencarian">
    <div class="container" style="margin-top: -200px">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-12" style="margin-bottom:20px">
                <div class="card bg-white shadow-lg" style=" position: -webkit-sticky; position: sticky; top: 100px; z-index: 1;">
                    <div class="card-body">
                        <center><p>Top 5 Penerbit</p></center>
                        <nav id="navbar-penerbit" class="h-100 flex-column align-items-stretch pe-4 border-end">
                            <nav class="nav nav-pills flex-column" id="top5penerbit">
                               
                            </nav>
                        </nav>
                    </div>
                    <div class="card-body">
                        <center><p>Top 5 Kota, Penerbit Terbanyak</p></center>
                        <nav id="navbar-kota" class="h-100 flex-column align-items-stretch pe-4 border-end">
                            <nav class="nav nav-pills flex-column" id="top5kotapenerbit">
                                
                            </nav>
                        </nav>
                       
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-12">
                <div class="card bg-white shadow-lg">
                    <div class="card-body">
                        <div class="input-group input-group-lg" >
                            <select id="jenis_media" style=" max-width: 200px;"  class="form-control select2 ">
                                <option value="all" {{ $jenis_media == "all" ? 'selected' : '' }}>Semua Media</option>
                                <option value="1" {{ $jenis_media == 1 ? 'selected' : '' }} >Buku Cetak</option>
                                <option value="2" {{ $jenis_media == 2 ? 'selected' : '' }} >Pdf</option>
                                <option value="3" {{ $jenis_media == 3 ? 'selected' : '' }} >Epub</option>
                                <option value="4" {{ $jenis_media == 4 ? 'selected' : '' }} >Audio Book</option>
                                <option value="5" {{ $jenis_media == 5 ? 'selected' : '' }} >Audio Visual</option>
                            </select>
                            <select id="filter_search" style=" max-width: 200px;"  class="form-control select2 ">
                                <option value="all" {{ $filter_by == "all" ? 'selected' : '' }}>Semua Filter</option>
                                <option value="PT.TITLE" {{ $filter_by == "PT.TITLE" ? 'selected' : '' }}>Judul </option>
                                <option value="PT.KEPENG" {{ $filter_by == "PT.KEPENG" ? 'selected' : '' }}>Kepengarangan </option>
                                <option value="P.NAME" {{ $filter_by == "P.NAME" ? 'selected' : '' }}>Penerbit </option>
                                <option value="PI.ISBN_NO" {{ $filter_by == "PI.ISBN_NO" ? 'selected' : '' }}>ISBN </option>
                            </select>
                            <!-- <i class="bi bi-caret-down-fill"></i> -->
                            <input style="margin-left:20px" id="keyword_pencarian" name="" value="{{ $keyword }}" type="search" class="form-control"  placeholder="Masukan kata untuk mencari " aria-label="Search">
                            <button type="button" class="" id="searchButton" onclick="handleClickSearch()" style="background-color:rgb(1, 34, 105);border:none; border-radius:0px 10px 10px 0px">
                                <span class="input-group-text bi-search" id="basic-addon1" style="background-color: rgb(1, 34, 105); color:white; border:none"></span>
                            </button>
                        </div>
                        
                        <div class="data-tables" style="margin-top:50px">
                            <table id="dataTable" class="display responsive dataTable no-footer dtr-inline">
                                <thead>
                                    <tr>
                                        <th class="text-center">Judul</th>
                                        <th>Seri</th>
                                        <th>Kepengarangan</th>
                                        <th>Penerbit</th>
                                        <th class="text-center">ISBN</th>
                                        <th>Tahun</th>
                                        <th style="white-space: nowrap;">Tempat Terbit</th>
                                        <th>Jumlah Jilid</th>
                                        <th>Link Buku</th>
                                        <th>Link KDT</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<input type="hidden" id="kota_filter">
<input type="hidden" id="penerbit_filter">


<!-- Modal pengumuman-->
<div class="modal fade" id="imageModalPengumuman" tabindex="-1" aria-labelledby="imageModalLabelPengumuman" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body" id="modalBody">
                <div id="modalContent">
                    Loading content...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- // Event untuk memicu pencarian custom saat input berubah
$('#customSearchField').on('keyup', function() {
    $('#example').DataTable().ajax.reload();
}); -->

<!-- js data table pencarian-->
@push('scripts')
<script>
    $(document).ready(function() {
      
        //load datatable
        const keyword = "{{ $keyword }}" ; 
        const filter = "{{ $filter_by }}" ;
        const jenis_media = "{{ $jenis_media }}" ;

        // console.log(filter, keyword, jenis_media, 'hakim');
        dataTables(filter, keyword, jenis_media);
        //end loaddata
    })
    function generateDataPenerbitTerbanyak() {
		$.ajax({
            url: '{{ url("searchval/penerbit-terbanyak") }}',
            type: 'GET',
            contentType: false,
            processData: false,
			async :false,
            beforeSend: function() {
                $('#datatable-loader').show();  // Tampilkan loader sebelum data dimuat
            },
            complete: function() {
                $('#datatable-loader').hide();  // Sembunyikan loader setelah data selesai dimuat
            },
            success: function(response) {
                for (var d = 0; d < response.length; d++) {
                    $('#top5penerbit').append('<a class="nav-link" href="">'+ response[d]['NAMA_PENERBIT'] + '</a>');
				}

            },
        });
	};
    function generateDataKotaPenerbitTerbanyak() {
		$.ajax({
            url: '{{ url("searchval/kota-penerbit-terbanyak") }}',
            type: 'GET',
            contentType: false,
            processData: false,
			async :false,
            beforeSend: function() {
                $('#datatable-loader').show();  // Tampilkan loader sebelum data dimuat
            },
            complete: function() {
                $('#datatable-loader').hide();  // Sembunyikan loader setelah data selesai dimuat
            },
            success: function(response) {
                for (var d = 0; d < response.length; d++) {
                    $('#top5kotapenerbit').append('<a class="nav-link" href=""><li class="list-group-item d-flex justify-content-between align-items-center">' +
                    response[d]['CITY'] + '</li></a>');
				}
            },
        });
	};
    generateDataPenerbitTerbanyak();
    generateDataKotaPenerbitTerbanyak();

    //link aktif untuk menu penerbit
    const navLinksPenerbit = document.querySelectorAll('#navbar-penerbit .nav-link');
    // Function to remove active class from all nav links
    function removeActiveClass() {
        navLinksPenerbit.forEach(link => link.classList.remove('active'));
    }

    // Function to add active class to the clicked nav link
    function setActiveLink(index) {
        const clickedLink = navLinksPenerbit[index];
        if (clickedLink.classList.contains('active')) { //klik di aktif yang sama
            clickedLink.classList.remove('active');
            document.getElementById('penerbit_filter').value = ""; //set value untuk filter by

            var filter2 = document.getElementById('filter_search').value
            var keyword2 = document.getElementById('keyword_pencarian').value
            var jenis_media2 = document.getElementById('jenis_media').value 

            
            
            dataTables(filter2, keyword2,jenis_media2); //load data table
            
        } else {
            removeActiveClass();
                // filter data table
            const nm_penerbit = clickedLink.textContent;
            document.getElementById('penerbit_filter').value = nm_penerbit; //set value untuk filter by
            var filter2 = document.getElementById('filter_search').value = 'all'
            var keyword2 = document.getElementById('keyword_pencarian').value = ''
            var jenis_media2 = document.getElementById('jenis_media').value = 'all'
            // dataTables(filter2, keyword2); //load data table
            dataTables();

            
            clickedLink.classList.add('active');
        }
    }

    navLinksPenerbit.forEach((link, index) => {
        link.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default anchor behavior
            // Update the active link
            setActiveLink(index);
        });
    });


    
    //link aktif untuk menu kota 
    const navLinksKota = document.querySelectorAll('#navbar-kota .nav-link');
    // Function to remove active class from all nav links
    function removeActiveClassKota() {
        navLinksKota.forEach(link => link.classList.remove('active'));
    }

    // Function to add active class to the clicked nav link
    function setActiveLinkKota(index) {
        const clickedLinkKota = navLinksKota[index];
        if (clickedLinkKota.classList.contains('active')) { //klik di aktif yang sama
            clickedLinkKota.classList.remove('active');
            document.getElementById('kota_filter').value = ""; //set value untuk filter by
            var filter1 = document.getElementById('filter_search').value
            var keyword1 = document.getElementById('keyword_pencarian').value
            var jenis_media1 = document.getElementById('jenis_media').value
            
            
            dataTables(filter1, keyword1, jenis_media1); //load data table
        } else {
            removeActiveClassKota(); //remove aktif
            clickedLinkKota.classList.add('active'); // add new aktif

            const listItem = document.querySelector('#navbar-kota .nav-link.active .list-group-item ');
            const nm_kota = listItem.childNodes[0].textContent.trim();
            document.getElementById('kota_filter').value = nm_kota; //set value untuk filter by

            var filter1 = document.getElementById('filter_search').value = 'all';
            var keyword1 = document.getElementById('keyword_pencarian').value = '';
            var jenis_media1 = document.getElementById('jenis_media').value = 'all'
            
            // dataTables(filter1, keyword1); //load data table
            dataTables();
        }
    }

    navLinksKota.forEach((link, index) => {
        link.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default anchor behavior

            // Update the active link
            setActiveLinkKota(index);
        });
    });

    function dataTables(params = null, keyword = null, jenis_media = null) {
        
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        var table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
			//processing: true,
			//"searching": true,
			//filter: false,
			//serverSide: true,
			destroy: true,
            ajax: {
                url: "{{ route('pencarian.search') }}", 
                type: 'GET', 
                data: function(d) {
                    // Calculate the current page and send it to the server
                    d.page = (d.start / d.length) + 1; // Current page (1-based)
                    d.pageSize = d.length; // Number of records per page
                    d.search = keyword; // Pencarian global
                    d.filter_by = params;
                    d.jenis_media = jenis_media;
                    d.by_penerbit = document.getElementById('penerbit_filter').value;
                    d.by_kota = document.getElementById('kota_filter').value;
                },
                beforeSend: function() {
                    $('#datatable-loader').show();  // Tampilkan loader sebelum data dimuat
                },
                complete: function() {
                    $('#datatable-loader').hide();  // Sembunyikan loader setelah data selesai dimuat
                }
            },
            pageLength: 10, // Default number of records per page
            lengthMenu: [5, 10, 25, 50],
            columns: [
                { 
                    data: 'TITLE',
                    render: function(data, type, row) {
                        return '<span style="width:200px">' + data + '</span>';
                    }
                },
                { data: 'SERI' },
                { data: 'KEPENG' },
                { data: 'NAMA_PENERBIT' },
                { 
                    data: 'ISBN_NO',
                    render: function(data, type, row) {
                        return '<span style="white-space: nowrap;">' + data + '</span>';
                    }
                },
                { data: 'TAHUN_TERBIT' },
                { data: 'TEMPAT_TERBIT' },
                
                { data: 'JML_JILID' },
                
                { 
                    data: 'LINK_BUKU',
                    render: function(data, type, row) {
                        if (data) {
                            return '<a href="'+ data +'">'+ data +'</a>';
                        } else {
                            return '';
                        }
                    },
                },
                { 
                    data: 'IS_KDT_VALID',
                    render: function(data, type, row) {
                        if (data == '1') {
                            return '<span style="width:200px; color:blue" onclick="showKdt(\'' + row.ID + '\')">LINK KDT</span>';
                        } else {
                            return '';
                        }
                    },
                }
            ],
            search: {
                search: document.getElementById('keyword_pencarian') 
            },
            drawCallback: function(settings) {
                // document.getElementById('totalRowsSurat').innerHTML = settings._iRecordsTotal;
            }
        });

        $('#searchButton').on('click', function() {
            table.ajax.reload(); // Reload DataTable with the current value of customSearchField
        });

    }

    function showKdt(value) {
        console.log(value)
        var myModal = new bootstrap.Modal(document.getElementById('imageModalPengumuman'));
        myModal.show();
        
        $.ajax({
            url: 'http://demo321.online:8212/isbn-bopenerbit/penerbit/isbn/data/view-kdt/'+value+'?bo_penerbit=1',
            type: 'GET',
            success: function(response) {
                // Load the response into the modalContent div
                $('#modalContent').html(response);
            },
            error: function() {
                // Handle error case
                $('#modalContent').html('Error loading content.');
            }
        });
    }

    // Menambahkan event listener untuk menangani tombol Enter
    document.getElementById('keyword_pencarian').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Mencegah form disubmit secara default

            var filter_by = document.getElementById('filter_search').value;
            if (filter_by == null || filter_by == '') {
                filter_by = 'all';
            }

            var jenis_media = document.getElementById('jenis_media').value;
            if (jenis_media == null || jenis_media == '') {
                jenis_media = 'all';
            }
                
            dataTables(filter_by, document.getElementById('keyword_pencarian').value, jenis_media); //load data table
            // handleClickSearch(); // Memanggil fungsi handleClickSearch
        }
    });

    function handleClickSearch() {
        //keyword pencarian
        var filter_by = document.getElementById('filter_search').value;
        if (filter_by == null || filter_by == '') {
            filter_by = 'all';
        }
        var keyword_pencarian = document.getElementById('keyword_pencarian').value;

        var jenis_media = document.getElementById('jenis_media').value;
        if (jenis_media == null || jenis_media == '') {
            jenis_media = 'all';
        }

        dataTables(filter_by, keyword_pencarian, jenis_media); //load data table
       
    }
    
</script>

@endpush
  