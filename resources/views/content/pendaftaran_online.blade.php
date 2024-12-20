@extends('index')

@push('styles')
    <link href="{{ asset('template/css/pendaftaran/pendaftaran.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/pendaftaran/pendaftaran_styling.css') }}" rel="stylesheet">
    <link href="{{ asset('template/css/pendaftaran/dropzone.min.css') }}" rel="stylesheet" >
     <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <link href="{{ asset('template/css/pendaftaran/select2.min.css') }}" rel="stylesheet" />
    
    <style>
        #captcha .preview{
            color: #555;
            width: 100%;
            text-align: center;
            height: 40px;
            line-height: 40px;
            letter-spacing: 8px;
            border: 1px dashed #888;
            border-radius: 0.5em;
            margin-bottom: 1.6em;

        }
        .select2-selection--single {
            height: 37px !important;
            line-height: 37px !important; /* Ensures the text is vertically centered */
        }

        .select2-selection__rendered {
            line-height: 37px !important; /* Ensures the text is vertically centered */
        }
        
        .inputcontainer {
            position: relative;
        }

        .icon-container {
            position: absolute;
            right: 10px;
            top: calc(50% - 10px);
        }
        .loader {
            position: relative;
            height: 20px;
            width: 20px;
            display: inline-block;
            animation: around 5.4s infinite;
        }

        @keyframes around {
            0% {
                transform: rotate(0deg)
            }
            100% {
                transform: rotate(360deg)
            }
        }

        .loader::after, .loader::before {
            content: "";
            background: white;
            position: absolute;
            display: inline-block;
            width: 100%;
            height: 100%;
            border-width: 2px;
            border-color: #333 #333 transparent transparent;
            border-style: solid;
            border-radius: 20px;
            box-sizing: border-box;
            top: 0;
            left: 0;
            animation: around 0.7s ease-in-out infinite;
        }

        .loader::after {
            animation: around 0.7s ease-in-out 0.1s infinite;
            background: transparent;
        }
        /* icon checklis berhasil  */
        .checkmark {
            width: 23px;
            height: 23px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            box-shadow: inset 0px 0px 0px #7ac142;
            animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
        }
        .checkmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #7ac142;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        .checkmark__check {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }
        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }
        @keyframes scale {
            0%, 100% {
                transform: none;
            }
            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }
        @keyframes fill {
            100% {
                box-shadow: inset 0px 0px 0px 30px #7ac142;
                /* box-shadow: inset 0px 0px 0px 30px  transparent; */
            }
        }
        /* end icon centang */

        .checkmark1 {
            width: 23px;
            height: 23px;
            border-radius: 50%;
            display: block;
            stroke-width: 2;
            stroke: #fff;
            stroke-miterlimit: 10;
            box-shadow: inset 0px 0px 0px red;
            animation: fill1 0.4s ease-in-out 0.4s forwards, scale1 0.3s ease-in-out 0.9s both;
        }
        .checkmark__circle1 {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 2;
            stroke-miterlimit: 10;
            stroke: #fff;
            fill: none;
            animation: stroke1 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        @keyframes stroke1 {
            100% {
                stroke-dashoffset: 0;
            }
        }
        @keyframes scale1 {
            0%, 100% {
                transform: none;
            }
            50% {
                transform: scale3d(1.1, 1.1, 1);
            }
        }
        @keyframes fill1 {
            100% {
                box-shadow: inset 0px 0px 0px 30px red;
            }
        }

        /* loader page */
        #loader {
            border: 10px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #4CAF50;
            width: 50px;
            height: 50px;
            -webkit-animation: spin 1s linear infinite; /* Safari */
            animation: spin 1s linear infinite;
        }
        

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* form pendaftaran */
        @media only screen and (min-width: 350px) and (max-width: 767px) {
            #jenis_penerbit {
                margin-top: 120px
            }
        }

        @media only screen and (min-width: 768px) {
            #jenis_penerbit {
                margin-top: 15%;
            }
        }
        /* checkbox  */
        /* Reset the default checkbox appearance */
        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #fff;
            cursor: pointer;
            position: relative;
        }

        /* Add custom styles for the checked state */
        input[type="checkbox"]:checked {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        /* Add a checkmark when checked */
        input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 5px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Flexbox container to align checkbox and label */
        .checkbox-container {
            display: flex;
            align-items: center;
        }

        /* Style the label */
        .checkbox-container label {
            margin-left: 8px;
            font-size: 16px;
            color: #333;
            cursor: pointer;
        }
    </style>
    
    <script>
        function reloadSuggestions() {
            location.reload(); // Reload the page to generate new suggestions
        }
    </script>
    
@endpush

@section('content')
<section class="hero-section justify-content-center align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12 mx-auto">
                <h1 class="text-white text-center">Pendaftaran Online</h1>
                <h6 class="text-white text-center">International Standard Book Number</h6>
            </div>
        </div>
    </div>
</section>

<section class="featured-section" style="background-color: #f0f8ff;">
    <div class="container_pendaftaran">
        <div class="row ">
            <div class="col-lg-12 col-md-12 col-12 mb-12 mb-lg-12">
                <div class="custom-block bg-white shadow-lg">
                    <form id="contact" action="#">
                        <div>
                            <h3>Penerbit</h3>
                            <section>
                                <label for="name" class="flex-row">Penerbit <p style="color:red; display:inline;">*</p></label> <br>
                                @foreach ($kategori as $kat)
                                <label>
                                    <input type="radio" id="{{ $kat['NAME']}}" value="{{ $kat['ID']}}" onclick="kat_penerbit(this)" name="kategori_penerbit" required/>
                                    <span>{{ $kat['NAME']}}</span>
                                </label>
                                <br>
                                @endforeach
                            </section>
                            <h3>Jenis Penerbit</h3>
                            <section>
                                <div class="col-lg-12 col-md-12 col-12 mb-12 mb-lg-12">
                                    <div class="row" id="jenis_penerbit">
                                        <div class="col-lg-4 col-md-4 col-12 mb-6 mb-lg-6">
                                            <label for="name" class="flex-row">Jenis Penerbit  <p style="color:red; display:inline;">*</p></label> 
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-12 mb-6 mb-lg-6" id="if_swasta">
                                            <!-- data diambil dari ajax -->
                                            <center>
                                                <div id="loading_kategori" style="display:none">
                                                    <div id="loader"></div>
                                                    <span>Mohon Tunggu..</span>
                                                </div>
                                            </center>
                                            <div id="pilihan_jenis_penerbit"></div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="jenis_penerbit">
                                    <div class="col-lg-4 col-md-4 col-12 mb-6 mb-lg-6">
                                        <label for="name" class="flex-row">File Pernyataan  <p style="color:red; display:inline;">*</p></label> 
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-12 mb-6 mb-lg-6">
                                        <div id="dropzone1" class="dropzone">
                                            <div class="dz-message" data-dz-message><span style="color: rgb(22 163 74)">Drop file pernyataan disini atau <span style="color: #00005c"><i><u>click</u></i></span> untuk upload.</span></div>
                                        </div>
                                        <span style="font-size: 11px; margin: 1%">Dibubuhi materai, ditanda tangani, distempel, dan dipindai (scan) ke dalam bentuk file pdf dengan ukuran tidak lebih dari 2MB. Setelah diunduh, diisi dan discan lakukan unggah surat pernyataan  </span>
                                        <button type="button" class="btn btn-outline-danger btn-sm" style="float: right; margin: 1%; border-radius: 10px; color:white">
                                            <!-- <a id="pernyataan_1" href="{{  config('app.url').'/dokumen_surat/Surat Pernyataan Penerbit - 20220813.docx'}}" class="u-label u-label--xs u-label--primary float-right">Unduh Formulir disini»</a> -->
                                            <a id="pernyataan_1" href="{{  asset('sp/Surat Pernyataan Penerbit - 20220813.docx') }}" class="u-label u-label--xs u-label--primary float-right">Unduh Formulir disini»</a>
                                        </button>
                                    </div>
                                </div>
                                <div id="form-akta" >
                                    <div class="row" id="jenis_penerbit" >
                                        <div class="col-lg-4 col-md-4 col-12 mt-6 mt-lg-6">
                                            <label for="name" class="flex-row">File Akta  <p style="color:red; display:inline;">*</p></label>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-12 mb-6 mb-lg-6">
                                            <div id="dropzone2" class="dropzone">
                                                <div class="dz-message" data-dz-message><span style="color: rgb(22 163 74)">Drop file pernyataan disini atau <span style="color: #00005c"><i><u>click</u></i></span> untuk upload.</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p>(*) Mandatory</p>
                            </section>
                            <h3>Identitas</h3>
                            <section>
                                <div class="form-row row" style="margin-top:90px">
                                    <div class="col">
                                        <label for="name" class="flex-row">Nama Penerbit  <p style="color:red; display:inline;">*</p></label> 
                                        <div class="inputcontainer">
                                            <input type="text" placeholder="Nama Penerbit" class="form-control" onchange="checkDataExisting('nama_penerbit',this.value)" id="nama_penerbit" name="nama_penerbit"  required>
                                            <div class="icon-container">
                                                <i class="loader" id="loader_nama_penerbit" style="display: none"></i>
                                                <svg class="checkmark" id="success_nama_penerbit" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                </svg>
                                                <svg class="checkmark1" id="error_nama_penerbit" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                    <circle class="checkmark__circle1" cx="26" cy="26" r="25" fill="none" />
                                                    <path class="checkmark__circle1" fill="none" d="M16 16 36 36 M36 16 16 36" />
                                                </svg>
                                            </div>
                                        </div>
                                        <span id="ket_nama_penerbit" style="font-size:11px; color:red"></span>
                                        <!-- <input type="text" placeholder="Nama Penerbit" class="form-control" id="penerbit" name="nama_penerbit"  required> -->
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col">
                                        <label for="nm_gedung" style="color:black">Nama Gedung (jika ada)</label>
                                        <input type="text" placeholder="Nama Gedung" class="form-control" id="nm_gedung" name="nama_gedung"  >
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col">
                                        <label for="name" class="flex-row">Nama Jalan  <p style="color:red; display:inline;">*</p></label> 
                                        <input type="text" placeholder="Nama Jalan" class="form-control" id="nm_jalan" name="alamat_penerbit" required >
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col">
                                        <label for="name" class="flex-row">Provinsi <p style="color:red; display:inline;">*</p></label> 
                                        <select id="provinsi" style="width: 100%;" class="form-control select2" name="province_id" onchange="get_wilayah_prov('kab_kot',this.value)" required>
                                            <option value="" disabled="disabled" selected>Pilih Provinsi </option>
                                            @foreach($provinsi as $prov)
                                            <option value="{{ $prov['ID']}}"> {{$prov['NAMAPROPINSI']}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="name" class="flex-row">Kabupaten / Kota <p style="color:red; display:inline;">*</p></label> 
                                        <select id="kab_kot" style="width: 100%;" class="form-control select2" name="city_id" onchange="get_wilayah_prov('kec',this.value)" required>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="name" class="flex-row">Kecamatan <p style="color:red; display:inline;">*</p></label> 
                                        <select id="kec" style="width: 100%;" class="form-control select2" name="district_id" onchange="get_wilayah_prov('kel',this.value)" required>
                                           
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="name" class="flex-row">Kelurahan <p style="color:red; display:inline;">*</p></label> 
                                        <select id="kel" style="width: 100%;" class="form-control select2" name="village_id" required>
                                           
                                        </select>
                                        {{-- <input type="text" placeholder="" class="form-control" id="" name="" > --}}
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="name" class="flex-row">Telephone <p style="color:red; display:inline;">*</p></label> 
                                        <input type="number" placeholder="Telephone" class="form-control" id="" name="admin_phone" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="confirm_password" style="color:black">Kode Pos  <p style="color:red; display:inline;">*</p></label>
                                        <input type="number" placeholder="Kode Pos" class="form-control" id="" name="kodepos" required>
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col">
                                        <label for="name" class="flex-row">Nama Admin <p style="color:red; display:inline;">*</p></label> 
                                        <input type="text" placeholder="Nama Admin" class="form-control" id="nm_admin" name="admin_contact_name" required>
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="form-holder">
                                        <label for="" style="color:black">Admin Alternatif</label>
                                        <input type="text" placeholder="Admin Alternatif" class="form-control" id="" name="alternate_contact_name">
                                    </div>
                                    <div class="form-holder">
                                        <label for="" style="color:black">Telephone Alternatif</label>
                                        <input type="number" placeholder="Telephone Alternatif" class="form-control" id="" name="alternate_phone"  >
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="form-holder form-holder-2">
                                        <label for="name" class="flex-row">Website <p style="color:red; display:inline;">*</p></label> 
                                        <input type="text" placeholder="Website" class="form-control" id="website" name="website_url" required>
                                    </div>
                                </div>
                                <p>(*) Mandatory</p>
                            </section>
                            <h3>Akun</h3>
                            <section>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col">
                                        <label for="name" class="flex-row">Username <p style="color:red; display:inline;">*</p></label> 
                                        <div class="inputcontainer">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon2" onclick="GenerateUsername()"  style="cursor: pointer;">Generate</span>
                                                <input type="" placeholder="Generate Username" class="form-control" id="hasilGenerateUsername" name="user_name" readonly required>
                                                <div class="icon-container">
                                                    <i class="loader" id="loader_username" style="display: none"></i>
                                                    <svg class="checkmark" id="success_username" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                    </svg>
                                                    <svg class="checkmark1" id="error_username" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                        <circle class="checkmark__circle1" cx="26" cy="26" r="25" fill="none" />
                                                        <path class="checkmark__circle1" fill="none" d="M16 16 36 36 M36 16 16 36" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <!-- <input type="text" placeholder="Username" class="form-control" onchange="checkDataExisting('username',this.value)" id="username" name="user_name"  required> -->
                                        </div>
                                        <span id="ket_username" style="font-size:11px; color:red"></span>
                                    </div>
                                </div>  
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="name" class="flex-row">Email <p style="color:red; display:inline;">*</p></label> 
                                        <div class="inputcontainer">
                                            <input type="text" placeholder="Email" class="form-control" id="email" name="admin_email" onchange="checkDataExisting('admin_email',this.value)" required>
                                            <div class="icon-container">
                                                <i class="loader" id="loader_admin_email" style="display: none"></i>
                                                <svg class="checkmark" id="success_admin_email" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                </svg>
                                                <svg class="checkmark1" id="error_admin_email" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                    <circle class="checkmark__circle1" cx="26" cy="26" r="25" fill="none" />
                                                    <path class="checkmark__circle1" fill="none" d="M16 16 36 36 M36 16 16 36" />
                                                </svg>
                                            </div>
                                        </div>
                                        <span id="ket_admin_email" style="font-size:11px; color:red"></span>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="name" class="flex-row">Email Alternatif<p style="color:red; display:inline;">*</p></label> 
                                        <div class="inputcontainer">
                                            <input type="text" placeholder="Email Alternatif" class="form-control" id="email_alternatif" name="alternate_email" onchange="checkDataExisting('alternatif_email',this.value)" required>
                                            <div class="icon-container">
                                                <i class="loader" id="loader_alternatif_email" style="display: none"></i>
                                                <svg class="checkmark" id="success_alternatif_email" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                                </svg>
                                                <svg class="checkmark1" id="error_alternatif_email" style="display: none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                                    <circle class="checkmark__circle1" cx="26" cy="26" r="25" fill="none" />
                                                    <path class="checkmark__circle1" fill="none" d="M16 16 36 36 M36 16 16 36" />
                                                </svg>
                                            </div>
                                        </div>
                                        <span id="ket_alternatif_email" style="font-size:11px; color:red"></span>
                                    </div>
                                </div>
                                <div class="form-row row" style="margin-top:108px">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="name" class="flex-row">Password<p style="color:red; display:inline;">*</p></label> 
                                        <div class="input-group mb-3">
                                            <input type="password" placeholder="Password" class="form-control" id="password" name="password"  onchange="validasi_password(this.value)" required>
                                            <span class="input-group-text">
                                                <i class="bi-eye-slash" id="togglePassword" onclick="passwordShowHide('password')" style="cursor: pointer;"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <label for="name" class="flex-row">Confirm Password<p style="color:red; display:inline;">*</p></label> 
                                        <div class="input-group mb-3">
                                        <input type="password" placeholder="Confirm Password" class="form-control" id="confirm_password" name="password2" onchange="confirm_password_onchange(this.value)" required>
                                            <span class="input-group-text">
                                                <i class="bi-eye-slash" id="togglePassword1" onclick="passwordShowHide('confirm_password')" style="cursor: pointer;"></i>
                                            </span>
                                        </div>
                                        
                                    </div>
                                    <span id="ket_password" style="font-size:11px; color:red"></span>
                                </div>

                                <div class="form-row row" style="margin-top:108px">
                                    <div id="captcha" >
                                        <div class="preview"></div>
                                        <input type="hidden" id="preview_captcha" value="">
                                        <div class="captcha_form"> 
                                            <input type="text" id="captcha_form" class="form_input_captcha" placeholder=" " required>

                                            <button class="captcha_refersh" style="display:none"></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="checkbox-container">
                                    <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required">
                                    <label for="acceptTerms" class="mt-2">I agree with the Terms and Conditions.</label>
                                </div>
                                <center>
                                    <div id="loading" style="display:none">
                                        <div id="loader"></div>
                                        <span>Mohon Tunggu..</span>
                                    </div>
                                </center>
                                <div id="text_error" style="margin-top:20px; display:none ">

                                </div>
                            <section>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Form container -->
@push('scripts')

generate username
<script>
    function GenerateUsername(){
        var nm_penerbit = document.getElementById('nama_penerbit').value;
        var nm_jalan = document.getElementById('nm_jalan').value;

        let wordsArrayPenerbit = nm_penerbit.split(' ');
        let wordsArrayJalan = nm_jalan.split(' ');

        let nameList = wordsArrayPenerbit.concat(wordsArrayJalan); 
        var finalName = randName(nameList)
        document.getElementById('hasilGenerateUsername').value = finalName;

        checkDataExisting('username',finalName)
    }

    function randName(nameList){
        let finalName = '';
        do {
            finalName = nameList[Math.floor( Math.random() * nameList.length )];
            finalName += nameList[Math.floor( Math.random() * nameList.length )];
            if ( Math.random() > 0.5 ) {
                finalName += nameList[Math.floor( Math.random() * nameList.length )];
            }

            while (finalName.length < 6) {
                finalName += nameList[Math.floor( Math.random() * nameList.length )];
            }
            //membatasi 6 charakter dari huruf
            if (finalName.length > 6) {
                finalName = finalName.substring(0, 6);
            }
            // Generate a random 2-digit number (between 10 and 99)
            const randomTwoDigitNumber = Math.floor(Math.random() * 90) + 10;
            finalName += randomTwoDigitNumber;
        } while (finalName.length !== 8);

        return finalName;
    };
</script>

<!-- hide and show password -->
<script>
    function passwordShowHide(value){
        var passwordInput = document.getElementById('confirm_password');
        var eyeIcon = document.getElementById('togglePassword1');
        if (value == "password") {
            passwordInput = document.getElementById('password');
            eyeIcon = document.getElementById('togglePassword');
        } 

        // Toggle the type attribute
        if (passwordInput.type === 'password') {
            passwordInput.type = ''; // Show the password
            eyeIcon.classList.remove('bi-eye'); // Remove eye icon
            eyeIcon.classList.add('bi-eye-slash'); // Add eye-slash icon
        } else {
            passwordInput.type = 'password'; // Hide the password
            eyeIcon.classList.remove('bi-eye-slash'); // Remove eye-slash icon
            eyeIcon.classList.add('bi-eye'); // Add eye icon
        }
    }
</script>

<script>
    (function(){
        const fonts = ["cursive"];
        let captchaValue = "";
        function gencaptcha()
        {
            let value = btoa(Math.random()*1000000000);
            value = value.substr(0,5 + Math.random()*5);
            captchaValue = value;
        }

        function setcaptcha()
        {
            let html = captchaValue.split("").map((char)=>{
                const rotate = -20 + Math.trunc(Math.random()*30);
                const font = Math.trunc(Math.random()*fonts.length);
                return`<span
                style="
                transform:rotate(${rotate}deg);
                font-family:${font[font]};
                "
            >${char} </span>`;
            }).join("");
            document.querySelector("#captcha .preview").innerHTML = html;
            //input captcha in value
            document.getElementById('preview_captcha').value = captchaValue;
        }

        function initCaptcha()
        {
            document.querySelector("#captcha .captcha_refersh").addEventListener("click",function(){
                gencaptcha();
                setcaptcha();
            });

            gencaptcha();
            setcaptcha();
        }
        initCaptcha();
    })();

    // Fungsi untuk mengubah huruf pertama menjadi kapital
    function capitalizeFirstLetter(input) {
        // Jika input tidak kosong
        if (input.length > 0) {
            // Mengubah huruf pertama menjadi kapital dan menggabungkan dengan sisa string
            return input.charAt(0).toUpperCase() + input.slice(1);
        }
        return input; // Mengembalikan input asli jika kosong
    }

    // Event listener untuk memastikan DOM telah dimuat sepenuhnya
    document.addEventListener('DOMContentLoaded', function() {
        // Mendapatkan semua elemen input dengan kelas 'form-control'
        const inputElements = document.querySelectorAll('.form-control');

        // Menambahkan event listener untuk setiap input dengan onkeyup
        inputElements.forEach(function(inputElement) {
            // Cek apakah input bukan bertipe number
            if (inputElement.type !== 'number' &&
                inputElement.id !== 'email' &&
                inputElement.id !== 'email_alternatif' && 
                inputElement.id !== 'hasilGenerateUsername' && 
                inputElement.id !== 'confirm_password' && 
                inputElement.id !== 'website' && 
                inputElement.id !== 'password') {
                inputElement.addEventListener('keyup', function() {
                    this.value = capitalizeFirstLetter(this.value); // Mengubah huruf pertama menjadi kapital
                });
            }
        });
    });

</script>

<!-- Select2 JS -->
<script src="{{ asset('template/js/pendaftaran/select2.min.js') }}"></script>
<script>
    var kategoriPenerbitGlobal = 0; // 0 adalah penerbit swasta
    var nextStep = true; // validasi next step
    var nextStepKet = ''; // validasi next step
    var finishValidate = true; // validasi finish

    // validasi kategori penerbit
    function kat_penerbit(radio) {
        if (radio.value == 1) { //pada master pemerintah adalah id 1
            document.getElementById('form-akta').style.display = 'none';
            kategoriPenerbitGlobal = 1;
        } else {
            document.getElementById('form-akta').style.display = 'block';
        }
        //untuk get data jenis penerbit
        function fetchData() {
            nextStepKet = ''
            nextStep = true;
            $.ajax({
                url: "{{ route('jenis_penerbit') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data : {
                    'kategori' : radio.value
                },
                beforeSend: function() {
                    // Tampilkan loader saat request dimulai
                    const loader = document.getElementById('loading_kategori');
                    loader.style.display = 'block';
                },
                success: function(data) {
                    
                    var htmlJenis = '';
                    if (data.code == 200) {
                        const loader = document.getElementById('loading_kategori');
                        loader.style.display = 'none';
                        data.content.forEach(function(item) {
                            htmlJenis += `
                                <label>
                                    <input type="radio" value="`+item.ID+`" name="jenis" required/>
                                    <span>`+item.NAME+`</span>
                                </label><br>
                            `
                        });
                        document.getElementById('pilihan_jenis_penerbit').innerHTML = htmlJenis
                    } else {
                        alert('error get jenis penerbit')
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    const userConfirmed = confirm('Periksa koneksi Anda. Apakah Anda ingin mencoba lagi?');
                    if (userConfirmed) {
                        fetchData(); // Jika pengguna ingin mencoba lagi, jalankan ulang request
                    } else {
                        nextStep = false;
                        nextStepKet = "periksa konesi anda";
                        const loader = document.getElementById('loading_kategori');
                        loader.style.display = 'none'; // Sembunyikan loader
                    }
                    console.error('AJAX error:', textStatus, errorThrown);
                }
            })
        }
        fetchData();
    }

    //select2 pemilihan wilayah
    $(function () {
        $('.select2').select2()
    })
    
    //huruf besar diawal dan setelah spasi
    function toTitleCase(str) {
        let words = str.toLowerCase().trim().split(/\s+/); // Ubah ke huruf kecil, hapus spasi di awal/akhir, dan pisahkan berdasarkan spasi
        let result = ''; // Tempat untuk menyimpan hasil

        words.forEach(function(word) {
            if (word.length > 0) { // Pastikan kata tidak kosong
                result += word.charAt(0).toUpperCase() + word.slice(1) + ' '; // Ubah huruf pertama menjadi besar dan tambahkan ke hasil
            }
        });

        return result.trim();
    }
    //get kabupaten -> kec -> kel
    function get_wilayah_prov(name, value) {
        //condition req data 
        if (name == 'kab_kot') {
            var req_data = { 'kab_kot' : value }
            var item_var = 'NAMAKAB'
        }else if(name == 'kec') {
            var req_data = { 'kec' : value }
            var item_var = 'NAMAKEC'
        } else if(name ==  'kel'){
            var req_data = { 'kel' : value }
            var item_var = 'NAMAKEL'
        } else {
            var req_data = {} 
            var item_var = 'NAMAPROPINSI'
        }
        //get api data berdasarkan filter req
        function fetchData() {
            nextStepKet = ''
            nextStep = true;
            $.ajax({
                url: "{{ route('get_wilayah') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                data: req_data,
                success: function(data) {
                    nextStepKet = ''
                    var selectElement = document.getElementById(name);
                    // Clear existing options
                    selectElement.innerHTML = '';
                    // Tambahkan opsi default "Pilih Wilayah"
                    var defaultOption = document.createElement('option');
                    defaultOption.text = 'Pilih Wilayah';
                    defaultOption.value = ''; 
                    defaultOption.disabled = true; 
                    defaultOption.selected = true; 
                    selectElement.add(defaultOption);
                    // Use forEach to loop through each item in the array
                    data.forEach(function(item) {
                        // Create a new option element
                        var newOption = document.createElement('option');
                        newOption.text = toTitleCase(item[item_var]);
                        newOption.value = item.ID;
                        // Add the option to the select element
                        selectElement.add(newOption);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    const userConfirmed = confirm('Periksa koneksi Anda. Apakah Anda ingin mencoba lagi?');
                    if (userConfirmed) {
                        fetchData(); // Jika pengguna ingin mencoba lagi, jalankan ulang request
                    } else {
                        const loader = document.getElementById('loading');
                        loader.style.display = 'none'; // Sembunyikan loader
                        nextStep = false;
                        nextStepKet = "periksa konesi anda";
                    }
                    console.error('AJAX error:', textStatus, errorThrown);
                }
            })
        }
        fetchData();
    }
    //end pemilihan wilayah

    //valdiasi email
    function validateEmail(email) {
        const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regex.test(email);
    }
    //end valdiasi email

    function validateDtExisting(name, ket, sts) { //name = nama field ket = set keterangan sts = gagal(0)/success (1)
        //loader
        document.getElementById('error_'+name).style.display = 'none';
        document.getElementById('success_'+name).style.display = 'none';
        document.getElementById('loader_'+name).style.display = 'block';
        //end loader
        if (sts == 1) {
            document.getElementById('loader_'+ name).style.display = 'none';
            document.getElementById('success_'+ name).style.display = 'block';
            document.getElementById('error_'+ name).style.display = 'none';
            document.getElementById('ket_'+ name).innerHTML = '';
            document.getElementById('ket_'+ name).style.display = 'none';
            
        } else {
            document.getElementById('ket_'+ name).innerHTML = ket;
            document.getElementById('ket_'+ name).style.display = 'block';
            document.getElementById('loader_'+ name).style.display = 'none';
            document.getElementById('success_'+ name).style.display = 'none';
            document.getElementById('error_'+ name).style.display = 'block';
            
            validate = 'error';
            nextStep = false;
            finishValidate = false;
        }
    }

    //check data existing username and email
    function checkDataExisting(name, value) {
        //loader
        document.getElementById('error_'+name).style.display = 'none';
        document.getElementById('success_'+name).style.display = 'none';
        document.getElementById('loader_'+name).style.display = 'block';
        //end loader

        var validate = ''
        switch (name) {
            case 'username':
                var req_data = { 'username' : value }
                validate = validasi_username(value)
                break;
            case 'admin_email':
                //send params fecth api
                var req_data = { 'admin_email' : value }
                //validasi Email
                var email = document.getElementById('email').value
                var email_alternatif = document.getElementById('email_alternatif').value
                if (validateEmail(email)) {
                    if (email_alternatif != "" && email == email_alternatif) {
                        var ket = ' Email utama dan email alternatif tidak boleh sama';
                        validateDtExisting(name, ket, 0) //load validasi 
                        validate = 'error';
                        nextStep = false;
                        finishValidate = false;
                    } else {
                        var ket = ''
                        validateDtExisting(name, ket, 1)
                        validate = '';
                        nextStep = true;
                        finishValidate = true;
                    }
                } else {
                    var ket = 'Email tidak valid'
                    validateDtExisting(name, ket, 0)
                    validate = 'error';
                    nextStep = false;
                    finishValidate = false;
                }
                break;
            case 'alternatif_email':
                //send params fecth api
                var req_data = { 'alternatif_email' : value }
                //validasi Email
                var email = document.getElementById('email').value
                var email_alternatif = document.getElementById('email_alternatif').value
                if (validateEmail(email_alternatif)) {
                    if (email != "" && email_alternatif == email) {
                        var ket = ' Email utama dan email alternatif tidak boleh sama';
                        validateDtExisting(name, ket, 0) //load validasi 
                        validate = 'error';
                        nextStep = false;
                        finishValidate = false;
                    } else {
                        var ket = ''
                        validateDtExisting(name, ket, 1)
                        validate = '';
                        nextStep = true;
                        finishValidate = true;
                    }
                } else {
                    var ket = 'Email tidak valid'
                    validateDtExisting(name, ket, 0)
                    validate = 'error';
                    nextStep = false;
                    finishValidate = false;
                }

                break;
            case 'nama_penerbit':
                //send params fecth api
                var req_data = { 'nama_penerbit' : value }
                //validasi nama
                // var nama_penerbit_id = document.getElementById('nama_penerbit').value
                // if (nama_penerbit_id.length < 8) {
                //     document.getElementById('ket_'+ name).innerHTML = ' Nama Penerbit Harus melebihi 8 karakter';
                //     document.getElementById('loader_'+ name).style.display = 'none';
                //     document.getElementById('error_'+ name).style.display = 'block';
                //     var ket = 'Nama Penerbit Kurang Dari 8 karakter ';
                //     validateDtExisting(name, ket, 0)
                //     validate = 'error';
                //     nextStep = false;
                // } else {
                //     var ket = ''
                //     validateDtExisting(name, ket, 1)
                //     validate = '';
                //     nextStep = true;
                //     finishValidate = true;
                // }
                break;
            default:
                break;
        }

        //End validasi Email

        if (validate != 'error') {
            function fetchData() {
                $.ajax({
                    url: "{{ route('checking_data_existing') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    serverSide: true,
                    data: req_data,
                    success: function(data) {
                        nextStepKet = ''
                        if (data.length > 0) {
                            const ket = name +' sudah digunakan';
                            validateDtExisting(name, ket, 0) //load validasi 
                            nextStep = false;
                            finishValidate = false;
                        } else {
                            var ket = ''
                            validateDtExisting(name, ket, 1)
                            nextStep = true;
                            finishValidate = true;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        const userConfirmed = confirm('Periksa koneksi Anda. Apakah Anda ingin mencoba lagi?');
                        if (userConfirmed) {
                            fetchData(); // Jika pengguna ingin mencoba lagi, jalankan ulang request
                        } else {
                            const loader = document.getElementById('loading');
                            loader.style.display = 'none'; // Sembunyikan loader
                            nextStep = false;
                            finishValidate = false;
                            nextStepKet = "periksa konesi anda";
                        }
                        console.error('AJAX error:', textStatus, errorThrown); // Log any errors
                    }
                });
            }
            fetchData();
        }
    }
    // END check data existing username and email
    //validasi username
    function validasi_username(username) {
        var errorMessage = '';
        // Check if the username contains only letters and numbers
        var validUsername = /^[a-zA-Z0-9]+$/.test(username);
        if (!validUsername) {
            nextStepKet = "Username tidak boleh mengandung spasi atau karakter khusus.";
            errorMessage = 'Username tidak boleh mengandung spasi atau karakter khusus.';
        }
        // Check if the username has at least 6 characters
        if (username.length < 6) {
            nextStepKet = "Username harus memiliki minimal 6 karakter.";
            errorMessage = 'Username harus memiliki minimal 6 karakter.';
        }

        if (errorMessage) {
            document.getElementById('loader_username').style.display = 'none';
            document.getElementById('error_username').style.display = 'block';
            document.getElementById('ket_username').innerHTML = errorMessage;
            nextStepKet = errorMessage
            finishValidate = false;
            return 'error';
        } else {
            nextStepKet = ''
            finishValidate = true;
            return 'success';
        }        
    }
    //end validasi username
    //validasi password
    function validasi_password(value) {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{8,}$/;
        if (passwordRegex.test(value)) {
            finishValidate = true;
            document.getElementById('ket_password').style.display = 'none';
            document.getElementById('ket_password').innerHTML = '';
        } else {
            finishValidate = false;
            document.getElementById('ket_password').style.display = 'block';
            document.getElementById('ket_password').innerHTML = 'Password harus terdiri dari setidaknya 8 karakter, mengandung huruf besar dan kecil, angka, dan karakter khusus.';
        }
    }
    function confirm_password_onchange(pass2) {
        pass1 = document.getElementById('password').value;
        console.log(pass1, pass2)
        if (pass1 == pass2) {
            finishValidate = true;
            document.getElementById('ket_password').innerHTML = '';
            document.getElementById('ket_password').style.display = 'none';
        } else {
            finishValidate = false;
            document.getElementById('ket_password').style.display = 'block';
            document.getElementById('ket_password').innerHTML = 'password tidak sama';
        }
    }
    //end validasi password
</script>

<!-- validasi form -->
<script src="{{ asset('template/js/pendaftaran/jquery.steps.min.js') }}"></script>
<script src="{{ asset('template/js/pendaftaran/jquery.validate.js') }}"></script>
<script>
    //form data pendaftaran
    var form = $("#contact");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            confirm: {
                equalTo: "#password"
            }
        }
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            form.validate().settings.ignore = ":disabled,:hidden";
            // Check if it's moving to the next step
            if (currentIndex == 1 && newIndex > currentIndex) {
                // Add custom validation for Dropzone (image upload)
                if (!uploadedImages1) {
                    alert("Upload surat pernyataan terlebih dahulu");
                    return false; // Prevent moving to the next step
                }
                if (!uploadedImages2 && kategoriPenerbitGlobal != 1) { // != 1 adalah bukan pemerintah
                    alert("Upload surat akta terlebih dahulu");
                    return false; // Prevent moving to the next step
                }
            }
            if (newIndex > currentIndex) {
                if (nextStep == false) { // != 1 adalah bukan pemerintah
                    if (nextStepKet != "" ) {
                        alert("periksa konesi anda");
                    } else {
                        alert("Harap lengkapi dan periksa semua kolom sebelum melanjutkan.");
                    }
                    return false; // Prevent moving to the next step
                }
            }
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {

            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            const loader = document.getElementById('loading');
            loader.style.display = 'block'; // Show the loader

            let inputcaptchavalue = document.getElementById("captcha_form").value;
            let captchaValue = document.getElementById('preview_captcha').value;

            if (inputcaptchavalue === captchaValue && finishValidate == true) 
            {
                $('#contact').append('<input type="hidden" id="" name="nama_kota" value="' + $('#kab_kot option:selected').text() + '">');
                function fetchData() {
                    nextStepKet = ''
                    nextStep = true;
                    finishValidate = true;
                    $.ajax({
                        url: "{{ route('submit_pendaftaran') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        data: $('#contact').serialize(),
                        beforeSend: function() {
                            // Tampilkan loader saat request dimulai
                            const loader = document.getElementById('loading');
                            loader.style.display = 'block';
                            finishValidate = false;
                        },
                        success: function(data) {
                            nextStepKet = ''
                            console.log(data, 'hakim1234 submit')
                            if(data.status != "error"){
                                openNewWindowWithParams() //redirect halaman otp
                            }else{
                                const textError = document.getElementById('text_error');
                                textError.style.display = 'block';
                                const loader = document.getElementById('loading');
                                loader.style.display = 'none';
                                document.getElementById('text_error').innerHTML = data.message;
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            const userConfirmed = confirm('Periksa koneksi Anda. Apakah Anda ingin mencoba lagi?');
                            if (userConfirmed) {
                                fetchData(); // Jika pengguna ingin mencoba lagi, jalankan ulang request
                            } else {
                                const loader = document.getElementById('loading');
                                loader.style.display = 'none'; // Sembunyikan loader
                                nextStep = false;
                                finishValidate = false;
                                nextStepKet = "periksa konesi anda";
                            }
                            console.log(textStatus, errorThrown)
                            // console.error('AJAX error:', textStatus, errorThrown);
                        }
                    })
                }
                fetchData();
            }
            else
            {
                alert("Invalid Captcha atau periksa data anda kembali");
                loader.style.display = 'none';
            }
        }
    });


    //redirect verifikasi halaman input otp
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }
    function openNewWindowWithParams() {
        // URL of the new window
        const url = "{{ route('verifikasi_pendaftaran') }}";

        // Create a form element
        const form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", url);

        // Create hidden input fields for the parameters
        const params = {
            'admin_email': $('#email').val(),
            'user_name': $('#hasilGenerateUsername').val()
        };

        for (const key in params) {
            if (params.hasOwnProperty(key)) {
                const hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }
        }

        // Add CSRF token
        const csrfToken = getCsrfToken();
        const csrfField = document.createElement("input");
        csrfField.setAttribute("type", "hidden");
        csrfField.setAttribute("name", "_token");
        csrfField.setAttribute("value", csrfToken);
        form.appendChild(csrfField);

        // Append the form to the body
        document.body.appendChild(form);
        // Submit the form
        form.submit();

        // Remove the form from the DOM after submitting
        document.body.removeChild(form);
    }
</script>

<!-- dropzone -->
<script src="{{ asset('template/js/pendaftaran/dropzone.min.js') }}"></script>
<script>
    //upload file  file_pernyataan
    var uploadedImages1 = false;
    Dropzone.autoDiscover = false;
    var dropzone1 = new Dropzone("#dropzone1", {
        url: "{{ route('media-one') }}",
        paramName: "file",
        maxFiles: 1,
        maxFilesize: 2, // MB
        acceptedFiles: ".pdf",
        autoProcessQueue: false,
        addRemoveLinks: true, // Option to remove files from the dropzone
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for Laravel
        },
        init: function() {
            var dropzone1 = this;
            this.on("addedfile", function(file) {
                uploadedImages1 = true;
                // Automatically process the file when it is added
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
                
                dropzone1.processFile(file);
            });
            this.on("removedfile", function() {
                if (this.files.length === 0) {
                    uploadedImages1 = false;
                    dropzone1.options.maxFiles = 1;
                }
            });
            this.on("sending", function(file, xhr, formData) {
                // Additional data can be sent here if required
                console.log('Sending file:', file);
            });
            this.on("success", function(file, response) {
                $('#contact').append('<input type="hidden" id="file_pernyataan" name="file_surat_pernyataan" value="' + response[0]['name'] + '" required>');
                // Handle the response from the server after the file is uploaded
                console.log('File uploaded successfully', response);
            });
            this.on("error", function(file, response) {
                // Handle the errors
                console.error('Upload error', response);
            });
            this.on("queuecomplete", function() {
                // Called when all files in the queue have been processed
                console.log('All files have been uploaded');
            });
            this.on("removedfile", function(file) {
                console.log(file, 'hakim delete', file.serverFileName)
                if (file.serverFileName) {
                    $.ajax({
                        url: "{{ route('media-one-delete') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { 
                            filename: file.serverFileName[0]['name']
                        },
                        success: function(data) {
                            $('#file_pernyataan').remove();
                            console.log("File deleted successfully");
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.error('Failed to delete file:', errorThrown);
                        }
                    });
                }
            });
            this.on("success", function(file, response) {
                // Store the server file name for deletion purposes
                file.serverFileName = response;
            });
        }
       
    });
    //upload file  file_akta
    var uploadedImages2 = false;
    var dropzone2 = new Dropzone("#dropzone2", {
        url: "{{ route('media-one') }}",
        paramName: "file",
        maxFiles: 1,
        maxFilesize: 2, // MB
        acceptedFiles: ".pdf",
        autoProcessQueue: false,
        addRemoveLinks: true, // Option to remove files from the dropzone
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token for Laravel
        },
        init: function() {
            var dropzone2 = this;
            this.on("addedfile", function(file) {
                // Automatically process the file when it is added
                uploadedImages2 = true;
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
                
                dropzone2.processFile(file);
            });
            this.on("removedfile", function() {
                if (this.files.length === 0) {
                    uploadedImages2 = false; // Set to false if no files
                    dropzone2.options.maxFiles = 1;
                }
            });
            this.on("sending", function(file, xhr, formData) {
                // Additional data can be sent here if required
                console.log('Sending file:', file);
            });
            this.on("success", function(file, response) {
                $('#contact').append('<input type="hidden" id="file_akta" name="file_akte_notaris" value="' + response[0]['name'] + '" required>');
                // Handle the response from the server after the file is uploaded
                console.log('File uploaded successfully', response);
            });
            this.on("error", function(file, response) {
                // Handle the errors
                console.error('Upload error', response);
            });
            this.on("queuecomplete", function() {
                // Called when all files in the queue have been processed
                console.log('All files have been uploaded');
            });
            this.on("removedfile", function(file) {
                if (file.serverFileName) {
                    $.ajax({
                        url: "{{ route('media-one-delete') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: { 
                            filename: file.serverFileName[0]['name']
                        },
                        success: function(data) {
                            $('#file_akta').remove();
                            console.log("File deleted successfully");
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.error('Failed to delete file:', errorThrown);
                        }
                    });
                }
            });
            this.on("success", function(file, response) {
                // Store the server file name for deletion purposes
                file.serverFileName = response;
            });
        }
    });
</script>
@endpush
