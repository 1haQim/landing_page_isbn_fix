@extends('index')
@section('content')

<section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-12 mx-auto">
                <h1 class="text-white text-center">Pertanyaan yang sering diajukan</h1>
                <h6 class="text-white text-center mb-20">International Standard Book Number</h6>
                <div class="input-group input-group-lg mt-20">
                    <span class="input-group-text bi-search" id="basic-addon1">
                        
                    </span>
                    <input name="keyword" type="search" class="form-control" id="keyword_pencarian" placeholder="Cari Pertanyaan ..." aria-label="Search">
                    <button type="submit" class="form-control">
                        <a class="nav-link click-scroll" onclick="handleClickPencarianFaq()">Cari</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="explore-section section-padding" >
    <div class="container" style="margin-top: -220px">
        <div class="row">
            <div class="col-lg-11 col-11 mt-3 mx-auto" id="card_detail_faq">
                
            </div>
        </div>
    </div>
</section>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            getData();
        })
        
        // Menambahkan event listener untuk menangani tombol Enter
        document.getElementById('keyword_pencarian').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Mencegah form disubmit secara default
                handleClickPencarianFaq(); // Memanggil fungsi handleClickSearch
            }
        });

        function handleClickPencarianFaq() {
            //keyword pencarian
            var keyword_pencarian = $("#keyword_pencarian").val();
            var keyword = "";
            if (keyword_pencarian) {
                keyword = keyword_pencarian
            }
            getData(keyword) 
        }

        function getData(keyword = null) {
            $.ajax({
                url: "{{ route('faq.get')}}",
                type: 'Get',
                dataType: 'json',
                serverSide: true,
                data: {
                    keyword : keyword
                },
                success: function(data) {
                    if (data.faq) {
                        document.getElementById('card_detail_faq').innerHTML = data.faq;
                    } else {
                        alert('data tidak ditemukan')
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown); // Log any errors
                }
            });
        }

    </script>
@endpush