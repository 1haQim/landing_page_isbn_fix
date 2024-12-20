<div class="row" id="data_berita"></div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('berita') }}", 
                type: 'GET',  
                dataType: 'json',  
                processing: true,  
                serverSide: true,    
                success: function(data) {
                    // Handle the response
                    

                    var htmlContent = ``;
                    data.Items.forEach(function(value) {
                        let tanggal = value.TANGGAL;
                        let dateObj = new Date(tanggal);

                        let monthNumber = dateObj.getMonth(); // Get the numeric month (0-11)
                        let monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

                        let day = String(dateObj.getDate()).padStart(2, '0');
                        let monthName = monthNames[monthNumber]; 
                        let year = dateObj.getFullYear();

                        let formattedDate = `${day} ${monthName} ${year}`; // Format as DD/MM/YYYY
                        
                        htmlContent += `<div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                            <div class="custom-block bg-white shadow-lg">
                                <div class="d-flex">
                                    <h5 class="mb-3">`+ value.JUDUL + `</h5> <br>
                                    <span class="badge rounded-pill ms-auto" style="background-color: #13547a;width: 200px; float:right">`+ formattedDate + `</span>
                                </div>
                                <p class="mb-0">`
                                    + value.BERITA +
                                `</p>
                                <img src="{{ asset('template/images/topics/undraw_Finance_re_gnv2.png') }}" class="custom-block-image img-fluid" alt="">
                            </div>
                        </div>`
                    });
                    document.getElementById('data_berita').innerHTML = htmlContent
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                }
            });
        })
    </script>
@endpush