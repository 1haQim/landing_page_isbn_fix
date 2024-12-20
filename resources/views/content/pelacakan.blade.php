@extends('index')

@push('styles')
    <style>
        .table-container {
            display: flex;
        }
        .table-container .table-wrapper {
            flex: 1;
        }
        .table-container .side-content {
            width: 200px; /* Adjust as needed */
            margin-right: 20px; /* Space between the table and the side content */
        }
    </style>
@endpush

@section('content')

<section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-12 mx-auto">
                <h1 class="text-white text-center">Lacak Permohonan ISBN</h1>

                <h6 class="text-white text-center mb-4" >International Standard Book Number</h6>

                <div class="input-group input-group-lg">
                    <span class="input-group-text bi-search" id="basic-addon1">
                        
                    </span>
                    <input name="keyword" type="search" class="form-control" id="tracking" placeholder="Tracking pengajuan ISBN berdasarkan No Resi Pengajuan ..." aria-label="Search">
                    <button type="submit" class="form-control">
                        <a class="nav-link" onclick="handleClickTracking()">Cari</a>
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="featured-section" style="background-color:white; display: none" id="card_tracking_pencarian">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-12 mb-4 mb-lg-0">
                <div class="custom-block bg-white shadow-lg">
                    <div>
                        <center><h5 class="mb-4 ">Hasil Pencarian</h5></center>
                    </div>
                    <div class="table-container">
                        <div class="side-content table-wrapper">
                            <table class="table table-bordered">
                                <tbody id="result_tracking">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')

    <script>
        function handleClickTracking() {
            //show card
            document.getElementById('card_tracking_pencarian').style.display = 'block';
            //get value
            let no_resi =  $('#tracking').val();
            //get ajax
            if (no_resi) {
                $.ajax({
                    url: "{{ route('tracking.resi') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    serverSide: true,
                    data : {
                        resi : no_resi
                    },
                    success: function(data) {
                        var bodyTbl = ``;
                        if (data.Items.length > 0) {
                            if (data.Items[0].STATUS) {
                                var sts = data.Items[0].STATUS;
                            } else {
                                var sts = "Permohanan";
                            }
                            bodyTbl += `
                                <tr>
                                    <th>No Resi</th>
                                    <td>`+ data.Items[0].NORESI + `</td>
                                </tr>
                                <th>Status</th>
                                    <td>`+ sts + ` </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>`+ data.Items[0].MOHON_DATE + `</td>
                                </tr>
                                <tr>
                                <tr>
                                    <th>Penerbit</th>
                                    <td>`+ data.Items[0].NAMA_PENERBIT + ` </td>
                                </tr>
                                <tr>
                                    <th>Judul</th>
                                    <td>`+ data.Items[0].TITLE + `</td>
                                </tr>
                                <th>Kepengarangan</th>
                                    <td>`+ data.Items[0].KEPENG + ` </td>
                                </tr>
                                <tr>
                                    <th>Tempat Terbit</th>
                                    <td>`+ data.Items[0].TEMPAT_TERBIT + `</td>
                                </tr>
                                <tr>
                                <tr>
                                    <th>Tahun Terbit</th>
                                    <td>`+ data.Items[0].TAHUN_TERBIT + ` </td>
                                </tr>
                               
                            `
                        } else {
                            bodyTbl += `
                                <center><p class="mb-0">Data Tidak Ditemukan</p></center>
                            `
                        }
                        
                        document.getElementById('result_tracking').innerHTML = bodyTbl
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown); // Log any errors
                    }
                });
            } else {
                alert('masukkan no resi')
            }
        }
    </script>
@endpush

<!-- <tr> -->
    <!-- <th>Jilid Volume</th> -->
    <!-- <td>`+ data.Items[0].JILID_VOLUME + ` </td> -->
<!-- </tr> -->