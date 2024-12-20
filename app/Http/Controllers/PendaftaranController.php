<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use \Illuminate\Http\UploadedFile;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    function index() {
        //get data kategori
        $kategori = [];
        $data = kurl('get','getlist', 'PENERBIT_KATEGORI', null , 'KriteriaFilter');
        
        // get data provinsi
        $provinsi = kurl('get','getlist', 'PROPINSI', null, 'KriteriaFilter');

        if ($data['Status'] == "Success" && $provinsi['Status'] == "Success") {
            $kategori = $data['Data']['Items'];
            $provinsi = $provinsi['Data']['Items'];
        } 

        return view('content.pendaftaran_online', compact('kategori','provinsi'));
    }

    function jenis_penerbit(Request $request) {
        $value = '';
        if ($request->query('kategori')) {
            $value = $request->query('kategori');
        } 

        try {
            $filter = [["name"=>'KATEGORI_ID',"Value"=>$value,"SearchType"=>"Tepat"]];
            $data = kurl('get','getlist', 'PENERBIT_JENIS', $filter, 'KriteriaFilter');

            if ($data['Status'] == "Error") {
                return errorResponseWithContent(message: 'error', content : $data['Message']);
            } else {
                return successResponse(content : $data['Data']['Items']);
            }
        } catch (Exception $e) {
            return errorResponseWithContent(content : $e->getMessage());
        }
    }

    private function generateOTP($length = 6) {
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= mt_rand(0, 9);
        }

        session([
            'otp' => $otp,
            'otp_generated_at' => now(),
        ]);

        
        return $otp;
    }

    //check username
    function checking_data_existing(Request $request) {
        if ($request->isMethod('post')) {
            if ($request->input('username')) {
                $value = $request->input('username');
                $where = "WHERE USER_NAME = '$value'";
            } else if($request->input('admin_email')) {
                $value = $request->input('admin_email');
                $where = "WHERE ADMIN_EMAIL = '$value' AND ADMIN_EMAIL = '$value'";
            } else if($request->input('nama_penerbit')) {
                $value = $request->input('nama_penerbit');
                $input_params = strtoupper($value);
                $where = "WHERE UPPER(NAMA_PENERBIT) = '$input_params'";
            } else if($request->input('alternatif_email')) {
                $value = $request->input('alternatif_email');
                $where = "WHERE ALTERNATE_EMAIL = '$value' AND ALTERNATE_EMAIL = '$value'";
            } else {
                $value = '';
                $where = '';
            }
            $query = "SELECT 'USER_NAME','ADMIN_EMAIL', 'ALTERNATE_EMAIL' FROM ISBN_REGISTRASI_PENERBIT $where";
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            return json_encode($data['Data']['Items']);
        } else {
            return errorResponse();
        }
    }
    //data select2 wilayah 
    function get_wilayah(Request $request) {
        if ($request->isMethod('post')) {
            //validasi berdasarakan ...
            if ($request->input('kab_kot')) {
                $tbl = 'KABUPATEN';
                $col = 'propinsiid';
                $value = $request->input('kab_kot');
            }else if($request->input('kec')) {
                $tbl = 'KECAMATAN';
                $col = 'KABUPATENID';
                $value = $request->input('kec');
            } else if($request->input('kel')){
                $tbl = 'KELURAHAN';
                $col = 'KECAMATANID';
                $value = $request->input('kel');
            } else {
                $tbl = 'PROPINSI';
                $col = '';
                $value = '';
            }

            $filter = [["name"=>$col,"Value"=>$value,"SearchType"=>"Tepat"]];
            $data = kurl('get','getlist', $tbl, $filter, 'KriteriaFilter');

            return json_encode($data['Data']['Items']);
        } else {
            return errorResponse();
        }
    }

    //send file register
    function upload_file($file, $penerbit_id, $ip) {
        $gagal = [];
        //surat pernyataan
        if ($file['file_pernyataan']) {
            $filePath_one = public_path('img_tmp_upload/'.$file['file_pernyataan']);
            if (File::exists($filePath_one)) {
                $file_one = new UploadedFile(
                    $filePath_one,
                    $file['file_pernyataan'],
                    File::mimeType($filePath_one),
                    null,
                    true
                );
                $post_pernyataan = kurl_upload('post', 'uploadfilesuratpernyataan', $penerbit_id, $file_one, $ip);
                $res_pernyataan = $post_pernyataan;
                //res status
                $gagal['pernyataan'] = $res_pernyataan['Status'] == "Success" ? 0 : 1;
            }
        }
        //file akta notaris
        if ($file['file_akte']) {
            $filePath_two = public_path('img_tmp_upload/'.$file['file_akte']);
            if (File::exists($filePath_two)) {
                $file_one = new UploadedFile(
                    $filePath_two,
                    $file['file_akte'],
                    File::mimeType($filePath_two),
                    null,
                    true
                );
                $post_akte_notaris = kurl_upload('post', 'uploadfileaktenotaris', $penerbit_id, $file_one, $ip);
                $res_akte = $post_akte_notaris;
                //res status
                $gagal['akte']  = $res_akte['Status'] == "Success" ? 0 : 1;
            }
        }

        $mess = '';
        $sts = '';
        foreach ($gagal as $k => $v) {
            if ($v > 0) {
                $sts = 0;
                $mess = 'gagal upload '. $k;
                break; 
            } else {
                $sts = 1;
                $mess = 'sukses upload semua files';
            }
        }
        $data = [
            // 'status' => 0, // keperluan debug untuk file yang gagal upload
            'status' => $sts,
            'message' => $mess
        ];
        return $data;
    }

    //form data
    function submit_pendaftaran(Request $request) {
        if ($request->isMethod('post')) {
            //validate
            $messages = [];
            if ($request->input('kategori_penerbit') == 1) {
                $validator = Validator::make($request->all(), [
                    'file_surat_pernyataan' => 'required|max:5048'
                    // 'file_surat_pernyataan' => 'required|mimes:jpg,jpeg,pdf|max:5048'
                ]);
                if ($validator->fails()) {
                    $messages = array_merge($messages, $validator->errors()->all());
                }
            } else {
                $validator = Validator::make($request->all(), [
                    'file_akte_notaris' => 'required|max:5048',
                    // 'file_akte_notaris' => 'required|mimes:jpg,jpeg,pdf|max:5048'
                ]);
                if ($validator->fails()) {
                    $messages = array_merge($messages, $validator->errors()->all());
                }
            }

            $validator = Validator::make($request->all(), [
                'kategori_penerbit' => 'required',
                'jenis' => 'required',
                'alamat_penerbit' => 'required',
                'province_id' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                'village_id' => 'required',
                'admin_phone' => 'required',
                'website_url' => 'required',
                'user_name' => 'required|string|max:50',
                'admin_email' => 'required|string|email|max:50',
                'alternate_email' => 'required|string|email|max:50',
                'password' => 'required|string|min:8',
            ]);
            if ($validator->fails()) {
                $messages = array_merge($messages, $validator->errors()->all());
            }

            if (!empty($messages)) {
                $mesStr = '';
                foreach ($messages as $v) {
                    $mesStr .= '<span style="color:red">'. $v . '<span color="red"><br>';
                }
                $res_data = [
                    'status' => 'error',
                    'message' => $mesStr
                ];
                return $res_data;
            } else {
                $ip = $request->ip();
                $file = [
                    'file_pernyataan' => $request->input('file_surat_pernyataan') ?? null,
                    'file_akte' => $request->input('file_akte_notaris') ?? null
                ];
                $pass_untuk_send_email = $request->input('password');
                //generate OTP
                $otp = $this->generateOTP();

                //encript password
                $encryptedPassword = $this->rijndaelEncryptPassword($request->input('password2'));
                $md5Encrypt = $this->md5Hash($request->input('password'));

                $request->merge([
                    // 'password' => md5($request->input('password')),
                    'password' => $md5Encrypt,
                    'password2' => $encryptedPassword, //rijndael
                    'code_otp' => $otp, //rijndael
                    'kd_penerbit' => $request->input('user_name'),
                    'registrasi_valid' => 0,
                    'createdate' => date('Y-m-d H:i:s'),
                    'jenis_id' => $request->input('jenis'),
                    'kategori_id' => $request->input('kategori_penerbit'),
                    'createby' => 'pendaftaran_online',
                    'createterminal' => $request->ip(),
                ]);

                $dataset = $request->all();
                unset($dataset['acceptTerms']);

                $send_data = [];
                foreach ($dataset as $k => $v) {
                    $send_data[] = [
                        'name' => $k,
                        'Value' => $v,
                    ];
                };

                $params = [
                    'CreateBy' => 'pendaftaran_online',
                    'terminal' => $request->ip()
                ];

                $data = kurl('post','add', 'ISBN_REGISTRASI_PENERBIT', $send_data, 'ListAddItem', $params);

                if (!empty($data['Data'])) {
                    $id = $data['Data']['ID'];
                    $call_func = $this->upload_file($file, $id, $ip);
                    //jika upload doc gagal maka akan rollback (hapus data)
                    if ($call_func['status'] == 0 ) {
                        $hapus_data = $this->rollback_pendaftaran($id);
                        $sts_ket = 'error';
                        $ket = 'gagal upload file';
                        //masukkan kedalam log untuk kegunaan tracking data
                    } else {
                        $data_send_otp = [
                            'email_admin'       => $request->input('admin_email'),
                            'email_alternatif'  => $request->input('alternate_email'),
                            'password'          => $pass_untuk_send_email,
                            'username'    => $request->input('user_name'),
                            'kode_otp'    => $otp
                        ];
    
                        $res_otp = $this->send_email($data_send_otp);
                        if ($res_otp) {
                            //return json berhasil
                            $sts_ket = 'success';
                            $ket = 'berhasil pendaftaran silahkan check email anda untuk verifikasi';
                        } else {
                            $sts_ket = 'error';
                            $ket = 'Gagal mengirim email klik kirim ulang kode OTP';
                        }
                    }

                    $res_data = [
                        'status' => $sts_ket,
                        'message' => $ket
                    ];

                    // dd($res_data);

                    return $res_data;
                }

                $res_data = [
                    'status' => 'error',
                    'message' => 'Data gagal ter input'
                ];
                return $res_data;
            }
        }
    }

    function rollback_pendaftaran($penerbit_id) {
        $params = [
            'id' => $penerbit_id,
        ];
        $data = kurl('post','delete', 'ISBN_REGISTRASI_PENERBIT', '', '' , $params);
        return $data['Status'];
    }

    //send email verifikasi
    function send_email($res_data) {
        if (filter_var($res_data['email_admin'], FILTER_VALIDATE_EMAIL)) {
            $waktu = date('d F Y H:i');
            $username = $res_data['username'];
            $email = $res_data['email_admin'] ?? '';
            $otp = $res_data['kode_otp'];
            $password = $res_data['password'] ?? '';

            //templat email
            $query = "SELECT isi FROM ISBN_MAIL_TEMPLATE WHERE ID = '16'";
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            $html = "";
            if ($data['Data']['Items']) {
                $html .= $data['Data']['Items'][0]['ISI'];
            }
            //end template email

            //ambil email cc untuk pendaftara
            $filterCC = [["name"=>'NAME',"Value"=>"CCEmailPendaftaranPenerbit","SearchType"=>"Tepat"]];
            $get_data_cc_mail = kurl('get','getlist', 'SETTINGPARAMETERS', $filterCC, 'KriteriaFilter');
            $email_cc = "";
            if ($get_data_cc_mail['Status'] == "Success") {
                $email_cc = $get_data_cc_mail['Data']['Items'][0]['VALUE'];
            } 
            //end cc pendaftaran

            //replace karakter {}
            $htmlOutput = str_replace(
                ['{waktu}', '{username}', '{email}', '{otp}', '{password}'],  // placeholders
                [$waktu, $username, $email, $otp, $password],              // corresponding PHP values
                $html                                   // the original HTML template
            );

            Mail::to($res_data['email_admin'])->cc([$email_cc, $res_data['email_alternatif']])->send(new SendMail($htmlOutput));
            return 'success';
        }
    }

    function verifikasi_pendaftaran(Request $request) {
        if ($request->isMethod('post')) {
            $tbl = 'ISBN_REGISTRASI_PENERBIT';
            if ($request->input('tipe') == 'generate') { //resend otp
                $otp = $this->generateOTP();
                //set data OTP
                $data_send_otp = [
                    'email_admin' => $request->input('admin_email'),
                    'username'    => $request->input('username'),
                    'kode_otp'    => $otp
                ];

                $filter = [
                    ["name"=>"admin_email","Value"=>$request->input('admin_email'),"SearchType"=>"Tepat"],
                    ["name"=>"user_name","Value"=>$request->input('username'),"SearchType"=>"Tepat"]
                ];
                $get_data = kurl('get','getlist', $tbl, $filter, 'KriteriaFilter');

                //validasi response
                if (!empty($get_data['Data']['Items'])) {
                    $id = $get_data['Data']['Items'][0]['ID'];

                    $res_otp = $this->send_email($data_send_otp);
                    if ($res_otp) {
                        $update_data = $this->update_status_pendaftar($id, 'no_valid', $data_send_otp['kode_otp']); //update data
                        if ($update_data == 'Success') {
                            $status = 1; //success
                            $message = 'Kode OTP baru sudah dikirim, silahkan check email anda untuk verifikasi';
                        } else {
                            $status = 0; //success
                            $message = 'Gagal mengiri OTP baru';
                        }
                    } else {
                        $status = 0;
                        $message = 'Gagal mengirim email klik kirim ulang kode OTP';
                    }
                } else {
                    $status = 0;
                    $message = 'Data Pendaftar tidak ditemukan';
                }

                $res_data = [
                    'status' => $status,
                    'message' => $message
                ];
                return $res_data;

            } else if ($request->input('tipe') == 'submit') { //submit otp
                $filter = [
                    ["name"=>"admin_email","Value"=>$request->input('admin_email'),"SearchType"=>"Tepat"],
                    ["name"=>"user_name","Value"=>$request->input('username'),"SearchType"=>"Tepat"],
                    ["name"=>"CODE_OTP","Value"=>$request->input('kode_otp'),"SearchType"=>"Tepat"]
                ];

                $data = kurl('get','getlist', $tbl, $filter, 'KriteriaFilter');
                //validasi response
                if (empty($data['Data']['Items'])) {
                    $status = 0; //gagal
                    $message = 'Kode OTP tidak sesuai';
                } else {
                    $update_data = $this->update_status_pendaftar($data['Data']['Items'][0]['ID'], 'valid'); //update data
                    if ($update_data == 'Success') {
                        $status = 1; //success
                        $message = 'Sukses verifikasi pendaftaran';
                    } else {
                        $status = 1; //success
                        $message = 'Gagal verifikasi pendaftaran silahkan hubungi Admin';
                    }
                }
                //res data
                $res_data = [
                    'status' => $status,
                    'message' => $message
                ];
                return $res_data;

            } else { //index view
                $timeOtp = $this->timeOtp();
                $email = $request->input('admin_email');
                $username = $request->input('user_name');
                return view('content.verifikasi_pendaftaran', compact('email','username','timeOtp'));
            }
        }
        $username = '';
        $email = '';
        $timeOtp = $this->timeOtp();
        return view('content.verifikasi_pendaftaran', compact('timeOtp','username','email'));
    }

    function timeOtp() {
        try {
            $filter = [["name"=>'NAME',"Value"=>'LamaWaktuOTP',"SearchType"=>"Tepat"]];
            $data = kurl('get','getlist', 'SETTINGPARAMETERS', $filter, 'KriteriaFilter');

            if ($data['Status'] == "Success") {
                $time = $data['Data']['Items'][0]['VALUE'];
            } 
            return $time;
        } catch (Exception $e) {
            return 'error';
        }
    }

    function update_status_pendaftar($penerbit_id, $valid, $otp = "") {

        $send_data = [
            [
                'name' => 'CODE_OTP',
                'Value' => $otp,
                
            ]
        ];

        if ($valid == 'valid') {
            $send_data[] = 
                [
                    'name' => 'REGISTRASI_VALID',
                    'Value' => 1,
                ];
        }
        $params = [
            'id' => $penerbit_id,
            'UpdateBy' => 'pendaftaran_online',
            'terminal' => '127.0.0.1',
        ];

        $data = kurl('post','update', 'ISBN_REGISTRASI_PENERBIT', $send_data , 'ListUpdateItem', $params);
        return $data['Status'];
    }

    function rijndaelEncryptPassword($password)
    {
        // Key Size: Ensure the key is 32 bytes long for AES-256.
        // IV Size: Ensure the IV is 16 bytes long for AES-256-CBC

        $key = 'isbn_2021$'; 
        $cipher = 'aes-256-cbc';
        $iv = random_bytes(16);

        $encrypted = openssl_encrypt($password, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        // Combine IV and encrypted data for storage
        return base64_encode($iv . $encrypted);
    }

    function md5Hash($input) {
        // Compute the MD5 hash
        $hash = md5($input, true); // true to get raw binary format
        $hexHash = bin2hex($hash);
        return $hexHash;
    }


}
