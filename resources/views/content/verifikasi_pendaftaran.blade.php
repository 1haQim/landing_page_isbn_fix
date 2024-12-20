@extends('index')
@section('content')

<style>
    .content_otp h3{
        justify-content: center;
        margin-bottom: 1rem;
    }

    .otp-input {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .otp-input input {
        width: 70px;
        height: 70px;
        margin: 0 5px;
        text-align: center;
        font-size: 1.2rem;
        border: 1px solid #444;
        border-radius: 4px;
        background-color:  #fff;
        color: rgb(1, 34, 105);;
        font-size : 30px
        /* color: #ffffff; */
    }
    .otp-input input::-webkit-outer-spin-button,
    .otp-input input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .otp-input input[type=number] {
        -moz-appearance: textfield;
    }
    button {
        justify-content: center;
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        border-radius: 4px;
        cursor: pointer;
        margin: 5px;
    }
    button:hover {
        background-color: #45a049;
    }
    button:disabled {
        background-color: #cccccc;
        color: #666666;
        cursor: not-allowed;
    }
    #timer {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        color: #ff9800;
    }
</style>

<section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
    <div class="container">
        <div class="row">
            <div class="col-lg-11 col-12 mx-auto">
                <h1 class="text-white text-center">Verifikasi Pendaftaran</h1>
                <h6 class="text-white text-center">International Standard Book Number</h6>
            </div>
        </div>
    </div>
</section>

<section class="explore-section section-padding" >
    <div class="container" style="margin-top: -180px">
        <div class="row ">
            <div class="col-lg-8 col-8 mt-3 mx-auto">
                <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5 ">
                        <center>
                            <h3>OTP Verifikasi</h3>
                            <p>Masukan code 6-digit yang telah dikirimkan ke email {{ isset($email) ? $email : '';  }}</p>
                            <div id="timer">Kirim ulang OTP dalam : 3:00</div>
                            <div id="alert"></div>
                        </center>
                        <div class="otp-input">
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                            <input type="number" min="0" max="9" required>
                        </div>
                        <center>
                            <div style="margin-top:50px">
                                <button id="resendButton" onclick="resendOTP()" disabled>Kirim Ulang kode</button>
                                <button id="btn_verify" onclick="verifyOTP()">Verifikasi</button>
                            </div>
                        </center>
                    </div>    
                </div>
            </div>
        </div>
    </div>

</section>


@push('scripts')
<script>
    $(document).ready(function() {
        console.log(123)
        // Initial push to the history
        window.history.pushState(null, null, window.location.href);

        // Function to handle popstate event
        function preventBackForward() {
            // Push state again to prevent going back
            window.history.pushState(null, null, window.location.href);
        }

        // Bind popstate event to prevent back navigation
        $(window).on('popstate', preventBackForward);

        // Prevent back and forward navigation
        $(window).on('beforeunload', function() {
            // This triggers the popstate event if you refresh or navigate away
            preventBackForward();
        });
    });
</script>
@endpush

<script>
    
    const inputs = document.querySelectorAll('.otp-input input');
    const timerDisplay = document.getElementById('timer');
    const resendButton = document.getElementById('resendButton');
    //   let timeLeft = 180; // 3 minutes in seconds
    let timeLeft = "{{ $timeOtp }}" ; // 3 minutes in seconds
    let timerId;
    const username = "{{ $username }}" ; 
    const email = "{{ $email }}" ;

    function startTimer() {
        timerId = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timerId);
                timerDisplay.textContent = "Code expired";
                resendButton.disabled = false;
                inputs.forEach(input => input.disabled = true);
            } else {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerDisplay.textContent = `Kirim ulang OTP dalam : ${minutes}:${seconds.toString().padStart(2, '0')}`;
                timeLeft--;
            }
        }, 1000);
    }

    function resendOTP() {
        // Here you would typically call your backend to resend the OTP
        alert("New OTP sent!");
        timeLeft = "{{ $timeOtp }}";
        inputs.forEach(input => {
            input.value = '';
            input.disabled = false;
        });
        resendButton.disabled = true;
        inputs[0].focus();
        clearInterval(timerId);
        $.ajax({
            url: "{{ route('verifikasi_pendaftaran') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({
                'username' : username,
                'admin_email' : email,
                'tipe' : 'generate'
            }),
            success: function(data) {
                if (data.status == 1) {
                    // Create a form element to perform a POST request
                    alert('Kode OTP baru Telah dikirim ke email Anda')
                    document.getElementById('btn_verify').disabled = false;
                } else {
                    document.getElementById('btn_verify').disabled = true;
                    document.getElementById('alert').innerHTML = '<p>' + data.message + '</p>';
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', textStatus, errorThrown);
            }
        })
        startTimer();
    }

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length > 1) {
                e.target.value = e.target.value.slice(0, 1);
            }
            if (e.target.value.length === 1) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value) {
                if (index > 0) {
                    inputs[index - 1].focus();
                }
            }
            if (e.key === 'e') {
                e.preventDefault();
            }
        });
    });

    function verifyOTP() {
    document.getElementById('btn_verify').disabled = true;
        const otp = Array.from(inputs).map(input => input.value).join('');
        if (otp.length === 6) {
            if (timeLeft > 0) {
            $.ajax({
                url: "{{ route('verifikasi_pendaftaran') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    'username' : username,
                    'admin_email' : email,
                    'kode_otp' : otp,
                    'tipe' : 'submit'
                }),
                success: function(data) {
                    if (data.status == 1) {
                        // Create a form element to perform a POST request
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = 'http://demo321.online:8212/isbn-bopenerbit/page/redirect';

                        // Create hidden input fields for the required parameters
                        var pesanInput = document.createElement('input');
                        pesanInput.type = 'hidden';
                        pesanInput.name = 'pesan';
                        pesanInput.value = data.message;  
                        form.appendChild(pesanInput);

                        var statusInput = document.createElement('input');
                        statusInput.type = 'hidden';
                        statusInput.name = 'status';
                        statusInput.value = 200;  
                        form.appendChild(statusInput);

                        var actionInput = document.createElement('input');
                        actionInput.type = 'hidden';
                        actionInput.name = 'action';
                        actionInput.value = '';  
                        form.appendChild(actionInput);

                        var tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = 'token';
                        tokenInput.value = 'xYjJgfpor3d87dfcvoklwas';  
                        form.appendChild(tokenInput);

                        // Append the form to the body and submit it
                        document.body.appendChild(form);
                        form.submit(); 
                        
                    } else {
                        document.getElementById('btn_verify').disabled = false;
                        document.getElementById('alert').innerHTML = '<p>' + data.message + '</p>';
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                }
            })
        } else {
            alert('OTP has expired. Please request a new one.');
        }
        } else {
            alert('Please enter a 6-digit OTP');
        }
    }

    startTimer();
</script>

