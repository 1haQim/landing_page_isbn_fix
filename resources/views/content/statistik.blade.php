@extends('index')
@section('content')

<section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-12 mx-auto">
                <h1 class="text-white text-center">Statistik</h1>
                <h6 class="text-white text-center">International Standard Book Number</h6>
            </div>
        </div>
    </div>
</section>

<section class="featured-section">
    <div class="container" >
        <div class="row ">
            <div class="col-lg-12 col-md-12 col-12 mb-12 mb-lg-12">
                <div class="custom-block bg-white shadow-lg">
                    <div class="d-flex">
                        <div>
                            <h5 class="mb-20">Pendahuluan</h5>
                            <p class="copyright-text" style="margin-top:30px">
                                Informasi tentang Prosedur Pendaftaran Penerbit dan Permohonan ISBN
                            </p>
                            <div id="intro" class="space-2-bottom active">
                                <p class="copyright-text">Perpustakaan Nasional RI Sebagai badan yang ditunjuk oleh International ISBN Agency untuk mengelola International Standard Book Number (ISBN) di Indonesia sejak tahun 1986, telah menjalankan tugasnya mengelola dan mendistribusikan penomoran ISBN kepada seluruh penerbit yang ada di wilayah negara kesatuan Republik Indonesia.</p>
                                <p class="copyright-text">Indonesia sudah tiga kali menerima Group Identifier, yaitu 979 pada tahun 1985, 602 pada tahun 2003 dan 623 pada tahun 2018. Berikut Struktur ISBN untuk Indonesia</p>
                                <img src="{{ asset('template/images/statistik_1.jpg') }}" class="img-responsive img-fluid" alt="stat_1">
                                <br><br>
                                <p class="copyright-text">Berdasarkan block number tersebut, Perpustakaan Nasional RI sudah mendistribusikan registrant element dan rentang ISBN, sebanyak :</p>
                                <br>
                                <img src="{{ asset('template/images/statistik_2.jpg') }}" class="img-responsive img-fluid" alt="stat_1">
                                <br>
                                <br>
                                <br>
                                <p class="copyright-text">Data ini menunjukkan bahwa penerbit Indonesia sudah menggunakan 13.510 registrant elemant pada group identifier 979, dan 24.607 registrant element pada group identifier 602. Sedangkan penggunaan registrant element pada block number 623 belum menjadi hitungan karena masih terus dikembangkan bersamaan dengan kondisi penerbitan di Indonesia. Jika diperhatikan, sejak diterapkannya sistem ISBN di Indonesia sejak tahun 1986, penerbit di Indonesia telah menerbitkan buku sebanyak 2.000.000 judul buku ber-ISBN (diluar hitungan buku berjilid)</p>
                                <p class="copyright-text">Layanan pengurusan ISBN Perpustakaan Nasional RI telah memenuhi persyaratan SNI ISO 9001 : 2015 dan terdaftar dalam MUTU Certification. Berdasarkan Surat edaran Kepala Direktorat Deposit Bahan Pustaka Perpustakaan Nasional RI no. 224/3.1/DBP.05/II.2018, berlaku mulai April 2018 layanan ISBN dinyatakan online dan tidak ada lagi pengajuan ISBN secara onsite.</p>
                                <p class="copyright-text">Perpustakaan Nasional RI berusaha menyediakan informasi hasil layanan ISBN secara terbuka dan real time. Layanan tersebut merupakan pertanggungjawaban lembaga dalam mewujudkan layanan publik yang transparan dan akuntabel.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="explore-section">
    <div class="container" >
        <div class="col-12 text-center">
            <h2 class="mt-5 mb-4">Grafik Statistik</h1>
        </div>
    </div>

    <div class="container mb-4">
        <div style="position: relative; width: 100%; height: 600px; margin: 50px 0;">
            <!-- Dropdown filter -->
            @php
                $currentYear = date('Y'); // Mendapatkan tahun berjalan
                $startYear = $currentYear - 5; // Tahun mulai (5 tahun ke belakang)
            @endphp
            <select id="yearFilterPeta" style="position: absolute; top: 10px; left: 10px; z-index: 1000;" onchange="fetctIsbnPerProvinsi(this.value)">
                @for ($year = $currentYear; $year >= $startYear; $year--)
                    <option class="mb-0 text-center" value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }} >
                        {{ $year }} 
                    </option>
                @endfor
            </select>
            
            <!-- Peta -->
            <div id="tesMaps" style="width: 100%; height: 100%;"></div>
        </div>
    </div>

    <!-- grafik  media dan kckr -->
    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                <div class="custom-block bg-white shadow-lg">
                                    <div>
                                        <h5 class="mb-3 text-center">Data Jenis Media </h5>
                                        <p class="mb-0 copyright-text text-center">
                                            Statistik jumlah ISBN per Jenis Media tahun 
                                        </p>
                                    </div>
                                    <center>
                                        @php
                                            $currentYear = date('Y'); // Mendapatkan tahun berjalan
                                            $startYear = $currentYear - 5; // Tahun mulai (5 tahun ke belakang)
                                        @endphp
                                        <select id="filter_jenis_cetak_isbn" style="width: 50%;" class="form-control select2 mt-3" onchange="fetctJenisCetak(this.value)">
                                            @for ($year = $currentYear; $year >= $startYear; $year--)
                                                <option class="mb-0 text-center" value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }} >
                                                    {{ $year }} 
                                                </option>
                                            @endfor
                                        </select>
                                    </center>
                                    <div id='jenis_cetak_isbn'></div>
                                    <p class="mb-0 copyright-text text-center" >
                                        data terakhir pada pukul {{ date('H:i')}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                <div class="custom-block bg-white shadow-lg">
                                    <div>
                                        <h5 class="mb-3 text-center">Data status KCKR </h5>
                                        <p class="mb-0 copyright-text text-center">
                                            Statistik jumlah ISBN per status KCKR tahun
                                        </p>
                                    </div>
                                    <center>
                                        @php
                                            $currentYear = date('Y'); // Mendapatkan tahun berjalan
                                            $startYear = $currentYear - 5; // Tahun mulai (5 tahun ke belakang)
                                        @endphp
                                        <select id="filter_status_kcrk" style="width: 50%;" class="form-control select2 mt-3" onchange="fetctStatusKCKR(this.value)">
                                            @for ($year = $currentYear; $year >= $startYear; $year--)
                                                <option class="mb-0 text-center" value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }} >
                                                    {{ $year }} 
                                                </option>
                                            @endfor
                                        </select>
                                    </center>
                                    <div id='status_kcrk'></div>
                                    <p class="mb-0 text-center copyright-text">
                                        Data terakhir pada pukul {{ date('H:i')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- grafik  isbn -->
    <div class="container mb-4" >
        <div class="col-12 text-center d-flex justify-content-between gap-3">
            <div class="col-lg-12 col-md-12 col-12 mb-12 mb-lg-12">
                <div class="custom-block bg-white shadow-lg">
                    <div>
                        <div>
                            <h5 class="mb-3 text-center">Data ISBN </h5>
                            <p class="mb-3 text-center copyright-text">
                                Informasi tentang Data ISBN yang sudah didaftaran berdasarkan Tahun<span id="ket_dt_isbn"></span>
                            </p>
                        </div>
                    </div>
                    <canvas id="barChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">
                        <div class="row">
                            <div class="custom-block bg-white shadow-lg">
                                <h5 class="mb-3 text-center">Data ISBN </h5>
                                <div class="d-flex">
                                    <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                        <div class="">
                                            <div>
                                                <p class="mb-0 text-center">
                                                    Total Data ISBN Per Provinsi
                                                </p>

                                            </div>
                                        </div>
                                        <h1 class="count text-center" data-count="2426616" id='isbn_perprov'></h1>

                                        <p class="mb-0 text-center" >
                                            data terakhir pada pukul {{ date('H:i')}}
                                        </p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                        <div class="">
                                            <div>
                                                <p class="mb-0 text-center">
                                                    Total Data ISBN Per Kota
                                                </p>
                                            </div>
                                        </div>
                                        <h1 class="count text-center" data-count="2426616" id='isbn_perkota'></h1>
                                        <p class="mb-0 text-center">
                                            Data terakhir pada pukul {{ date('H:i')}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- terbitan isbn -->
    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                <div class="custom-block bg-white shadow-lg">
                                    <div>
                                        <h5 class="mb-3 text-center">Data Terbitan terbanyak </h5>
                                        <p class="mb-0 text-center copyright-text">
                                            Daftar 10 kota teratas Data Terbitan terbanyak tahun. 
                                            <!-- Dengan total data 80.000 dari 10 kota teratas -->
                                            <center>
                                                @php
                                                    $currentYear = date('Y'); // Mendapatkan tahun berjalan
                                                    $startYear = $currentYear - 5; // Tahun mulai (5 tahun ke belakang)
                                                @endphp
                                                <select id="filter_status_kcrk" style="width: 50%;" class="form-control select2 mt-3" onchange="fetchTerbitan(this.value)">
                                                    @for ($year = $currentYear; $year >= $startYear; $year--)
                                                        <option class="mb-0 text-center" value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }} >
                                                            {{ $year }} 
                                                        </option>
                                                    @endfor
                                                </select>
                                            </center>
                                        </p>
                                    </div>
                                    <div id='terbitan_terbanyak'></div>
                                    <p class="mb-0 text-center copyright-text" >
                                        data terakhir pada pukul {{ date('H:i')}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12 mb-4 mb-lg-0">
                                <div class="custom-block bg-white shadow-lg">
                                    <div>
                                        <h5 class="mb-3 text-center">Data Kota penerbit terbanyak </h5>
                                        <p class="mb-0 text-center copyright-text">
                                            Daftar 10 kota teratas Data kota penerbit terbanyak tahun. 
                                            <center>
                                                @php
                                                    $currentYear = date('Y'); // Mendapatkan tahun berjalan
                                                    $startYear = $currentYear - 5; // Tahun mulai (5 tahun ke belakang)
                                                @endphp
                                                <select id="filter_status_kcrk" style="width: 50%;" class="form-control select2 mt-3" onchange="fetctKotaPenerbit(this.value)">
                                                    @for ($year = $currentYear; $year >= $startYear; $year--)
                                                        <option class="mb-0 text-center" value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }} >
                                                            {{ $year }} 
                                                        </option>
                                                    @endfor
                                                </select>
                                            </center>
                                            <!-- Dengan total data 80.000 dari 10 kota teratas -->
                                        </p>
                                    </div>
                                    <div id='kota_penerbit_terbanyak'></div>
                                    <p class="mb-0 text-center copyright-text">
                                        Data terakhir pada pukul {{ date('H:i')}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
<script src= "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src= "https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/id/id-all.js"></script> <!-- Indonesia map -->
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetctIsbnPerProvinsi()
        fetctJenisCetak()
        fetctStatusKCKR()
        fetchTerbitan()
        fetctKotaPenerbit()
        fetchDataIsbn(null)
        isbn_chart()
        data_isbn_propinsi();

    })

    function fetctIsbnPerProvinsi(params = null) {
        $.ajax({
            url: "{{ route('peta_provinsi') }}", // Replace with your API endpoint
            type: 'GET', // Or 'POST' depending on your API
            dataType: 'json',
            processing: true, // Show processing indicator
            serverSide: true, // Enable server-side proces
            data: {
                year: params, // Kirim nilai dari dropdown
            },
            success: function(response) {
                console.log(response)
                var isbnData = JSON.parse(response.content);

                petaIsbnPerProvinsi(isbnData,isbnData[response.content.lenght - 1], isbnData[0])
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }

    function petaIsbnPerProvinsi(params, minScale, maxScale) {
        // Load the Highcharts map
        console.log(maxScale,'max');
        console.log(params,'peta')

        Highcharts.mapChart('tesMaps', {
            chart: {
                map: 'countries/id/id-all' // Indonesia map
            },
            title: {
                text: 'ISBN Data per Province di Indonesia'
            },
            subtitle: {
                text: 'Source: perpusnas ISBN'
            },
            mapNavigation: {
                enabled: true,
                enableButtons: true
            },
            colorAxis: {
                min: minScale,
                // max: maxScale,
                minColor: '#E6E7E8',
                maxColor: '#0071A7',
                stops: [
                    [0, '#f1f1ff'],     // Color for 0
                    [0.25, '#ffed80'],  // Color for ~100k
                    [0.5, '#ffd700'],   // Color for ~150k (new stop)
                    [0.75, '#ffc000'],  // Color for ~200k
                    [1, '#ff4d4d']      // Color for 300k
                ],
                tickPositions: [0, 10000, 20000, 30000, 50000], // Define positions for the ticks
                labels: {
                    format: '{value}k', // Add "k" for thousands
                    formatter: function () {
                        return this.value === 0 ? '0' : this.value / 1000 + 'k'; // Format as "0", "100k", "200k", "300k"
                    }
                }
            },
            series: [{
                data: params,
                mapData: Highcharts.maps['countries/id/id-all'],
                joinBy: 'hc-key', // Link the map data to your data
                name: 'ISBN per Province',
                states: {
                    hover: {
                        color: '#BADA55'
                    }
                },
                tooltip: {
                    valueSuffix: ' ISBN Per Provinsi'
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }],
            
            plotOptions: {
                series: {
                    point: {
                        events: {
                            click: function() {
                                // alert(this.name + ': ' + this.value + ' ISBN Per Provinsi');
                            }
                        }
                    }
                }
            }
        });
    }

    function fetctJenisCetak(params = null) {
        $.ajax({
            url: "{{ route('jenis_cetak_isbn') }}", // Replace with your API endpoint
            type: 'GET', // Or 'POST' depending on your API
            dataType: 'json',
            processing: true, // Show processing indicator
            serverSide: true, // Enable server-side proces
            data: {
                year: params, // Kirim nilai dari dropdown
            },
            success: function(response) {
                jenisCetak(response.content);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    //set data grafik
    function jenisCetak(seriesData) {
        var chartJenisCetak = {
        "type":"pie",
        "legend":{
            "x":"70%",
            "y":"15%",
            "border-width":1,
            "border-color":"gray",
            "border-radius":"5px",
            "header":{
                "text":"Notations",
                "font-family":"Georgia",
                "font-size":12,
                "font-color":"#3333cc",
                "font-weight":"normal"
            },
            "marker":{
                "type":"circle"
            },
            "toggle-action":"remove",
            "minimize":true,
            "icon":{
            "line-color":"#9999ff"
            },
            "max-items":10,
            "overflow":"scroll"
        },
        "plotarea":{
            "margin-right":"30%",
        },
        "plot":{
            "animation":{
                "on-legend-toggle": true, //set to true to show animation and false to turn off
                "effect": 10,
                "method": 1,
                "sequence": 1,
                "speed": 1
            },
            "value-box":{
                "text":"%npv%",
                "font-size":12,
                "font-family":"Georgia",
                "font-weight":"normal",
                "placement":"out",
                "font-color":"gray",
            },
            "tooltip":{
                "text":"%t: %v (%npv%)",
                "font-color":"black",
                "font-family":"Georgia",
                "text-alpha":1,
                "background-color":"white",
                "alpha":0.7,
                "border-width":1,
                "border-color":"#cccccc",
                "line-style":"dotted",
                "border-radius":"10px",
                "padding":"10%",
                "placement":"node:center"
            },
            "border-width":1,
            "border-color":"#cccccc",
            "line-style":"dotted"
        },
        "series": seriesData
        };

        zingchart.render({ 
            id : 'jenis_cetak_isbn', 
            data : chartJenisCetak, 
            height: 500, 
            width: "100%" 
        });
    }   

    function fetctStatusKCKR(params = null) {
        $.ajax({
            url: "{{ route('berdasarkan_kckr') }}", // Replace with your API endpoint
            type: 'GET', // Or 'POST' depending on your API
            dataType: 'json',
            processing: true, // Show processing indicator
            serverSide: true, // Enable server-side proces
            data: {
                year: params, // Kirim nilai dari dropdown
            },
            success: function(response) {
                statusKckr(response.content);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    //set data grafik
    function statusKckr(seriesData) {
        var chart_status_kcrk = {
        "type":"pie",
        "legend":{
            "x":"70%",
            "y":"15%",
            "border-width":1,
            "border-color":"gray",
            "border-radius":"5px",
            "header":{
                "text":"Notations",
                "font-family":"Georgia",
                "font-size":12,
                "font-color":"#3333cc",
                "font-weight":"normal"
            },
            "marker":{
                "type":"circle"
            },
            "toggle-action":"remove",
            "minimize":true,
            "icon":{
            "line-color":"#9999ff"
            },
            "max-items":10,
            "overflow":"scroll"
        },
        "plotarea":{
            "margin-right":"30%",
        },
        "plot":{
            "animation":{
                "on-legend-toggle": true, //set to true to show animation and false to turn off
                "effect": 10,
                "method": 1,
                "sequence": 1,
                "speed": 1
            },
            "value-box":{
                "text":"%npv%",
                "font-size":12,
                "font-family":"Georgia",
                "font-weight":"normal",
                "placement":"out",
                "font-color":"gray",
            },
            "tooltip":{
                "text":"%t: %v (%npv%)",
                "font-color":"black",
                "font-family":"Georgia",
                "text-alpha":1,
                "background-color":"white",
                "alpha":0.7,
                "border-width":1,
                "border-color":"#cccccc",
                "line-style":"dotted",
                "border-radius":"10px",
                "padding":"10%",
                "placement":"node:center"
            },
            "border-width":1,
            "border-color":"#cccccc",
            "line-style":"dotted"
        },
        "series": seriesData
        };

        zingchart.render({ 
            id : 'status_kcrk', 
            data : chart_status_kcrk, 
            height: 500, 
            width: "100%" 
        });
    }   

    function fetchTerbitan(params = null) {
        $.ajax({
            url: "{{ route('kota_terbitan_terbanyak') }}", // Replace with your API endpoint
            type: 'GET', // Or 'POST' depending on your API
            dataType: 'json',
            processing: true, // Show processing indicator
            serverSide: true, // Enable server-side proces
            data: {
                year: params, // Kirim nilai dari dropdown
            },
            success: function(response) {
                updateChart(response.content);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    function updateChart(seriesData) {
        var chart_terbitan = {
        "type":"pie",
        "legend":{
            "x":"70%",
            "y":"15%",
            "border-width":1,
            "border-color":"gray",
            "border-radius":"5px",
            "header":{
                "text":"Notations",
                "font-family":"Georgia",
                "font-size":12,
                "font-color":"#3333cc",
                "font-weight":"normal"
            },
            "marker":{
                "type":"circle"
            },
            "toggle-action":"remove",
            "minimize":true,
            "icon":{
            "line-color":"#9999ff"
            },
            "max-items":10,
            "overflow":"scroll"
        },
        "plotarea":{
            "margin-right":"30%",
        },
        "plot":{
            "animation":{
                "on-legend-toggle": true, //set to true to show animation and false to turn off
                "effect": 10,
                "method": 1,
                "sequence": 1,
                "speed": 1
            },
            "value-box":{
                "text":"%npv%",
                "font-size":12,
                "font-family":"Georgia",
                "font-weight":"normal",
                "placement":"out",
                "font-color":"gray",
            },
            "tooltip":{
                "text":"%t: %v (%npv%)",
                "font-color":"black",
                "font-family":"Georgia",
                "text-alpha":1,
                "background-color":"white",
                "alpha":0.7,
                "border-width":1,
                "border-color":"#cccccc",
                "line-style":"dotted",
                "border-radius":"10px",
                "padding":"10%",
                "placement":"node:center"
            },
            "border-width":1,
            "border-color":"#cccccc",
            "line-style":"dotted"
        },
        "series": seriesData
        };

        zingchart.render({ 
            id : 'terbitan_terbanyak', 
            data : chart_terbitan, 
            height: 500, 
            width: "100%" 
        });
    }

    function fetctKotaPenerbit(params = null) {
        $.ajax({
            url: "{{ route('kota_penerbit_terbanyak') }}", // Replace with your API endpoint
            type: 'GET', // Or 'POST' depending on your API
            dataType: 'json',
            processing: true, // Show processing indicator
            serverSide: true, // Enable server-side proces
            data: {
                year: params, // Kirim nilai dari dropdown
            },
            success: function(response) {
                kotaPenerbit(response.content);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    //set data grafik
    function kotaPenerbit(seriesData) {
        var chart_kota_penerbit = {
        "type":"pie",
        "legend":{
            "x":"70%",
            "y":"15%",
            "border-width":1,
            "border-color":"gray",
            "border-radius":"5px",
            "header":{
                "text":"Notations",
                "font-family":"Georgia",
                "font-size":12,
                "font-color":"#3333cc",
                "font-weight":"normal"
            },
            "marker":{
                "type":"circle"
            },
            "toggle-action":"remove",
            "minimize":true,
            "icon":{
            "line-color":"#9999ff"
            },
            "max-items":10,
            "overflow":"scroll"
        },
        "plotarea":{
            "margin-right":"30%",
        },
        "plot":{
            "animation":{
                "on-legend-toggle": true, //set to true to show animation and false to turn off
                "effect": 10,
                "method": 1,
                "sequence": 1,
                "speed": 1
            },
            "value-box":{
                "text":"%npv%",
                "font-size":12,
                "font-family":"Georgia",
                "font-weight":"normal",
                "placement":"out",
                "font-color":"gray",
            },
            "tooltip":{
                "text":"%t: %v (%npv%)",
                "font-color":"black",
                "font-family":"Georgia",
                "text-alpha":1,
                "background-color":"white",
                "alpha":0.7,
                "border-width":1,
                "border-color":"#cccccc",
                "line-style":"dotted",
                "border-radius":"10px",
                "padding":"10%",
                "placement":"node:center"
            },
            "border-width":1,
            "border-color":"#cccccc",
            "line-style":"dotted"
        },
        "series": seriesData
        };

        zingchart.render({ 
            id : 'kota_penerbit_terbanyak', 
            data : chart_kota_penerbit, 
            height: 500, 
            width: "100%" 
        });
    }   

    function fetchDataIsbn(params) {
        $.ajax({
            url: "{{ route('isbn_periode') }}", // Replace with your API endpoint
            type: 'GET', // Or 'POST' depending on your API
            dataType: 'json',
            processing: true, // Show processing indicator
            serverSide: true, // Enable server-side proces
            success: function(response) {
                // console.log(response.content,'hakim ')
                dataIsbn(response.content);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
            }
        });
    }
    function dataIsbn(data){
        var canvas = document.getElementById("barChart");
        var ctx = canvas.getContext("2d");

        // Global Options:
        Chart.defaults.global.defaultFontColor = "#2097e1";
        Chart.defaults.global.defaultFontSize = 11;

        // Data with datasets options
        var data = {
            labels: data.label,
            datasets: [
                {
                    label: "Judul",
                    fill: true,
                    backgroundColor: [
                        "#2097e1",
                        "#2097e1",
                        "#2097e1",
                        "#2097e1",
                        "#2097e1",
                        "#2097e1",
                    ],
                    data: data.judul
                },
                {
                    label: "ISBN",
                    fill: true,
                    backgroundColor: [
                        "#bdd9e6",
                        "#bdd9e6",
                        "#bdd9e6",
                        "#bdd9e6",
                        "#bdd9e6",
                        "#bdd9e6"
                    ],
                    data: data.isbn
                }
            ]
        };

        // Notice how nested the beginAtZero is
        var options = {
            title: {
                display: true,
                text: "Data ISBN per tahun",
                position: "bottom"
            },
            scales: {
                xAxes: [
                    {
                        gridLines: {
                            display: true,
                            drawBorder: true,
                            drawOnChartArea: false
                        }
                    }
                ],
                yAxes: [
                    {
                        ticks: {
                            beginAtZero: true
                        }
                    }
                ]
            }
        };

        // added custom plugin to wrap label to new line when \n escape sequence appear
        var labelWrap = [
            {
                beforeInit: function (chart) {
                    chart.data.labels.forEach(function (e, i, a) {
                        if (/\n/.test(e)) {
                            a[i] = e.split(/\n/);
                        }
                    });
                }
            }
        ];

        // Chart declaration:
        var myBarChart = new Chart(ctx, {
            type: "bar",
            data: data,
            options: options,
            plugins: labelWrap
        });
    }

    function isbn_chart() {
        var points = 450;
        var maxPoints = 600;
        var percent = points / maxPoints * 100;
        var ratio = percent / 100;
        var pie = d3.layout
        .pie()
        .value(function(d) {
            return d;
        })
        .sort(null);
        var w = 150,
        h = 150;
        var outerRadius = w / 2 - 10;
        var innerRadius = 75;
        var color = ["#ececec", "rgba(156,78,176,1)", "#888888"];
        var colorOld = "#F00";
        var colorNew = "#0F0";
        var arc = d3.svg
        .arc()
        .innerRadius(innerRadius)
        .outerRadius(outerRadius)
        .startAngle(0)
        .endAngle(Math.PI);

        var arcLine = d3.svg
        .arc()
        .innerRadius(innerRadius)
        .outerRadius(outerRadius)
        .startAngle(0);

        var svg = d3
        .select("#loyalty")
        .append("svg")
        .attr({
            width: w,
            height: h,
            class: "shadow"
        })
        .append("g")
        .attr({
            transform: "translate(" + w / 2 + "," + h / 2 + ")"
        });

        var path = svg
        .append("path")
        .attr({
            d: arc,
            transform: "rotate(-90)"
        })
        .style({
            fill: color[0]
        });

        var pathForeground = svg
        .append("path")
        .datum({ endAngle: 0 })
        .attr({
            d: arcLine,
            transform: "rotate(-90)"
        })
        .style({
            fill: function(d, i) {
            return color[1];
            }
        });

        var middleCount = svg
        .append("text")
        .datum(0)
        .text(function(d) {
            return d;
        })
        .attr({
            class: "middleText",
            "text-anchor": "middle",
            dy: 0,
            dx: 5
        })
        .style({
            fill: d3.rgb("#000000"),
            "font-size": "36px"
        });

        var oldValue = 0;
        var arcTween = function(transition, newValue, oldValue) {
        
        transition.attrTween("d", function(d) {
            var interpolate = d3.interpolate(d.endAngle, Math.PI * (newValue / 100));
            var interpolateCount = d3.interpolate(oldValue, newValue);

            return function(t) {
            d.endAngle = interpolate(t);
            // change percentage to points before rendering text
            middleCount.text(Math.floor(interpolateCount(t)/100*maxPoints));

            return arcLine(d);
            };
        });
        };

        pathForeground
        .transition()
        .duration(750)
        .ease("cubic")
        .call(arcTween, percent, oldValue, points);
    }
    
    function data_isbn_propinsi(params) {
        $(function(){
        $(".count").hide(0).fadeIn(3000)
            $('.count').each(function() {
            var $this = $(this),
                countTo = $this.attr('data-count');
            $({ countNum: $this.text()}).animate({
                countNum: countTo
            },
            {
                duration: 3000,
                easing:'linear',
                step: function() {
                $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                $this.text(this.countNum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                }
            });
            });
        });
    }


</script>


