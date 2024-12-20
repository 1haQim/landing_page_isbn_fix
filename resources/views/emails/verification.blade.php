Selamat Datang di {{ config('app.name') }} ! berikut data Anda:
Waktu	    :	{{ date('d F Y H:i') }} WIB <br>
Username	:	{{$data['username']}} <br>
Email	    :	{{$data['email_admin']}} <br>
OTP	        :	{{$data['kode_otp']}} <br>

Segera masukkan kode OTP pada halaman verifikasi.
<br>
<br>
Terima kasih.

Hormat Kami,
<br>
<br>
<br>
<br>
Tim ISBN