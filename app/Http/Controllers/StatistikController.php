<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatistikController extends Controller
{
    function index() {



        return view('content.statistik');
    }

    function dataMapsMaping() {
        $provinceMap = [
            11 => 'id-ac', // Aceh
            12 => 'id-su', // Sumatera Utara
            13 => 'id-sb', // Sumatera Barat
            14 => 'id-ri', // Riau
            15 => 'id-ja', // Jambi
            16 => 'id-sl', // Sumatera Selatan
            17 => 'id-be', // Bengkulu
            18 => 'id-1024', // Lampung
            19 => 'id-bb', // Kepulauan Bangka Belitung
            21 => 'id-kr', // Kepulauan Riau
            31 => 'id-jk', // DKI Jakarta
            32 => 'id-jr', // Jawa Barat
            33 => 'id-jt', // Jawa Tengah
            34 => 'id-yo', // Daerah Istimewa Yogyakarta
            35 => 'id-ji', // Jawa Timur
            36 => 'id-bt', // Banten
            51 => 'id-ba', // Bali
            52 => 'id-nb', // Nusa Tenggara Barat
            53 => 'id-nt', // Nusa Tenggara Timur
            61 => 'id-kb', // Kalimantan Barat
            62 => 'id-kt', // Kalimantan Tengah
            63 => 'id-ks', // Kalimantan Selatan
            64 => 'id-ki', // Kalimantan Timur
            65 => 'id-kp', // Kalimantan Utara
            71 => 'id-sw', // Sulawesi Utara
            72 => 'id-st', // Sulawesi Tengah
            73 => 'id-se', // Sulawesi Selatan
            74 => 'id-sg', // Sulawesi Tenggara
            75 => 'id-go', // Gorontalo
            76 => 'id-sr', // Sulawesi Barat
            81 => 'id-ma', // Maluku
            82 => 'id-la', // Maluku Utara
            91 => 'id-pa', // Papua
            92 => 'id-ib', // Papua Barat
            93 => 'id-ps', // Papua Selatan
            94 => 'id-pt', // Papua Tengah
            95 => 'id-pp', // Papua Pegunungan
            96 => 'id-pbd', // Papua Barat Daya
        ];

        return $provinceMap;
    }

    function peta_provinsi(Request $request) {
        $tahun = date("Y");
        if ($request->query('year')) {
            $tahun = $request->query('year');
        }
        $query = "SELECT 
                PROPINSI.ID,
                PROPINSI.NAMAPROPINSI,
                COUNT(PROPINSI.ID) AS Jumlah
            FROM 
                PENERBIT_ISBN
            INNER JOIN 
                PENERBIT ON PENERBIT_ISBN.PENERBIT_ID = PENERBIT.ID
            INNER JOIN 
                PROPINSI ON PENERBIT.PROVINCE_ID = PROPINSI.ID
            GROUP BY 
                PROPINSI.ID, PROPINSI.NAMAPROPINSI
                ORDER BY Jumlah DESC";

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            $provinceMap = $this->dataMapsMaping();

            // dd($data['Data']['Items']);

            //generate to data grafik
            // $mappedIsbnData = [];
            // foreach ($data['Data']['Items'] as $row) {
            //     $hcKey = isset($provinceMap[$row['ID']]) ? $provinceMap[$row['ID']] : null;
            //     if ($hcKey) {
            //         $mappedIsbnData[] = [
            //             'hc-key' => $hcKey,
            //             'value' => (int) $row['JUMLAH'],
            //         ];
            //     }
            // }

            $mappedIsbnData = [];

            // Create an associative array from $data['Data']['Items'] for easier lookup
            $itemData = [];
            foreach ($data['Data']['Items'] as $row) {
                $itemData[$row['ID']] = (int) $row['JUMLAH'];
            }

            // Loop through all provinces in the provinceMap
            foreach ($provinceMap as $provinceId => $hcKey) {
                // Check if the province exists in the data, if not, set value to 0
                $mappedIsbnData[] = [
                    'hc-key' => $hcKey,
                    'value' => isset($itemData[$provinceId]) ? $itemData[$provinceId] : 0,
                ];
            }


            //response
            return successResponse(content : json_encode($mappedIsbnData));
        } catch (Exception $e) {
            return errorResponseWithContent(content : $e->getMessage());
        }
    }

    function jenis_cetak_isbn(Request $request) {
        $tahun = date("Y");
        if ($request->query('year')) {
            $tahun = $request->query('year');
        }
        $query = "SELECT * FROM (
            SELECT (CASE WHEN JENIS_MEDIA = '1' THEN 'Buku' WHEN JENIS_MEDIA = '2' THEN 'Pdf' WHEN JENIS_MEDIA = '3' THEN 'Epub' WHEN JENIS_MEDIA = '4' THEN 'Audio Book' WHEN JENIS_MEDIA = '5' THEN 'Audio Visual' ELSE '-' END) as JenisMedia, COUNT(*) as Jumlah
            FROM PENERBIT_TERBITAN
            WHERE 1=1
            AND TO_CHAR(PENERBIT_TERBITAN.CREATEDATE,'YYYY') = '$tahun'
            GROUP BY JENIS_MEDIA
            ORDER BY Jumlah DESC) a
            WHERE ROWNUM <= 10";

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');
            //generate to data grafik
            $arr_color = [
                "#cc0000","#ff3300","#ff6600","#ff9933","#ffcc00","#a2c2e4","#cda4d6","#8bb4d9", 
            ];
            $data_chart = [];
            foreach ($data['Data']['Items'] as $k => $v) {
                $color = $arr_color[$k];
                $data_chart[] = [
                    'values' => [(int) $v['JUMLAH']],
                    'background-color' => $color,
                    'text' => $v['JENISMEDIA'].'<br>Total : '. $v['JUMLAH'] ,
                ];
            }
            //response
            return successResponse(content : $data_chart);
        } catch (Exception $e) {
            return errorResponseWithContent(content : $e->getMessage());
        }
    }

    //isbn berdasarkan ss kckr (sudah menyerahkan / belum serah simpan)
    function berdasarkan_kckr(Request $request) {
        $tahun = date("Y");
        if ($request->query('year')) {
            $tahun = $request->query('year');
        }
        $query = "SELECT
            ( CASE WHEN RECEIVED_DATE_KCKR IS NOT NULL THEN 'Sudah Menyerahkan KCKR' ELSE 'Belum Menyerahkan KCKR' END ) AS StatusKCKR,
                COUNT( * ) AS Jumlah 
            FROM
                PENERBIT_ISBN 
            WHERE
                1 = 1 
                AND TO_CHAR( PENERBIT_ISBN.CREATEDATE, 'YYYY' ) = '$tahun' 
            GROUP BY
                ( CASE WHEN RECEIVED_DATE_KCKR IS NOT NULL THEN 'Sudah Menyerahkan KCKR' ELSE 'Belum Menyerahkan KCKR' END )";

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            if ($data['Status'] == "Error") {
                return errorResponseWithContent(message: 'error', content : $data['Message']);
            } else {
                //generate to data grafik
                $arr_color = [
                    "#cc0000","#ff6600",
                ];
                $data_chart = [];
                foreach ($data['Data']['Items'] as $k => $v) {
                    $color = $arr_color[$k];
                    $data_chart[] = [
                        'values' => [(int) $v['JUMLAH']],
                        'background-color' => $color,
                        'text' => $v['STATUSKCKR'].'<br>Total : '. $v['JUMLAH'] ,
                    ];
                }
                //response
                return successResponse(content : $data_chart);
            }
        } catch (Exception $e) {
            return errorResponseWithContent(content : $e->getMessage());
        }
    }

    function kota_terbitan_terbanyak(Request $request) {
        $tahun = date("Y");
        if ($request->query('year')) {
            $tahun = $request->query('year');
        }
        $query = "SELECT 
            tempat_terbit, 
            jumlah
        FROM (
            SELECT 
                penerbit_terbitan.tempat_terbit, 
                COUNT(*) AS jumlah 
            FROM 
                penerbit_terbitan 
            WHERE 
                penerbit_terbitan.tempat_terbit IS NOT NULL AND
				penerbit_terbitan.TAHUN_TERBIT = '$tahun'
            GROUP BY 
                penerbit_terbitan.tempat_terbit 
            ORDER BY 
                jumlah DESC
        )
        WHERE ROWNUM <= 10";
        //get api dan olah data

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            if ($data['Status'] == "Error") {
                return errorResponseWithContent(message: 'error - kota terbitan', content : $data['Message']);
            } else {
                 // API call
                $data = kurl('get', 'getlistraw', null, $query, 'sql');
                //generate to data grafik
                $arr_color = [
                    "#cc0000","#ff3300","#ff6600","#ff9933","#ffcc00","#a2c2e4","#e49382","#8dcf8d","#cda4d6","#8bb4d9", 
                ];
                $data_chart = [];
                foreach ($data['Data']['Items'] as $k => $v) {
                    $color = $arr_color[$k];
                    $data_chart[] = [
                        'values' => [(int) $v['JUMLAH']],
                        'background-color' => $color,
                        'text' => $v['TEMPAT_TERBIT'].'<br>Total : '. $v['JUMLAH'] ,
                    ];
                }
                //response
                return successResponse(content : $data_chart);


            }
        } catch (Exception $e) {
            return errorResponseWithContent(content : $e->getMessage());
        }
    }

    function kota_penerbit_terbanyak(Request $request) {
        $tahun = date("Y");
        if ($request->query('year')) {
            $tahun = $request->query('year');
        }
        $query = "SELECT 
            city, 
            jumlah
        FROM (
            SELECT 
                penerbit.city, 
                COUNT(*) AS jumlah 
            FROM 
                penerbit 
            WHERE 
                penerbit.city IS NOT NULL AND
                EXTRACT(YEAR FROM CREATEDATE) = '$tahun'
            GROUP BY 
                penerbit.city 
            ORDER BY 
                jumlah DESC
        )
        WHERE ROWNUM <= 10";

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            if ($data['Status'] == "Error") {
                return errorResponseWithContent(message: 'error - fetch kota penerbit', content : $data['Message']);
            } else {
                //generate to data grafik
                $arr_color = [
                    "#cc0000","#ff3300","#ff6600","#ff9933","#ffcc00","#a2c2e4","#e49382","#8dcf8d","#cda4d6","#8bb4d9",
                ];
                $data_chart = [];
                foreach ($data['Data']['Items'] as $k => $v) {
                    $color = $arr_color[$k];
                    $data_chart[] = [
                        'values' => [(int) $v['JUMLAH']],
                        'background-color' => $color,
                        'text' => $v['CITY'].'<br>Total : '. $v['JUMLAH'] ,
                    ];
                }
                //response
                return successResponse(content : $data_chart);
            }
        } catch (Exception $e) {
            return errorResponseWithContent(content : $e->getMessage());
        }
    }

    function isbn_periode(Request $request) {
        $periode = "'YYYY'";
        $where = ''; 
        $order1 = "ORDER BY TO_NUMBER(periode) DESC";
        $order2 = "ORDER BY TO_NUMBER(periode) ASC"; 

        //jika memilih periode bulan
        if ($request->query('periode') == 'bulan') {
            $periode = "'YYYY-MM'";
            $where = " WHERE to_char(penerbit_isbn.createdate,'YYYY') = '".$request->query('tahun')."'";
            $order1 = " ORDER BY periode";
            $order2 = " ORDER BY periode ASC";
        } 

        $query = "SELECT * 
        FROM (
            SELECT 
                TO_CHAR(penerbit_isbn.createdate, $periode) AS periode, 
                COUNT(DISTINCT penerbit_terbitan_id) AS jumlah_judul, 
                COUNT(1) AS jumlah_isbn 
            FROM 
                penerbit_isbn 
            $where
            GROUP BY 
                TO_CHAR(penerbit_isbn.createdate, $periode)
            $order1
        )
        WHERE ROWNUM <= 6
        $order2";

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            // dd($data);

            if ($data['Status'] == "Error") {
                return errorResponseWithContent(message: 'error - get data periode', content : $data['Message']);
            } else {
                $dataChart = [];
                foreach ($data['Data']['Items'] as $k => $v) {
                    $dataChart['label'][] = $v['PERIODE'];
                    $dataChart['judul'][] = $v['JUMLAH_JUDUL'];
                    $dataChart['isbn'][] = $v['JUMLAH_ISBN'];
                }

                return successResponse(content : $dataChart);
            }
        } catch (Exception $e) {
            return errorResponseWithContent(content : $e->getMessage());
        }
    }

    function isbn_wilayah(Request $request) {
        $where = " WHERE penerbit.province_id = ".$request->query('id');
        //jika memilih wilayah kota
        if ($request->query('wilayah') == 'kota') {
            $where = " WHERE penerbit.city_id = ".$request->query('id');
        } 

        $query = "SELECT COUNT(1) AS jumlah
            FROM penerbit_isbn
            INNER JOIN penerbit ON penerbit_isbn.penerbit_id = penerbit.id
            $where
            AND TO_CHAR(penerbit_isbn.createdate, 'YYYY') = '".$request->query('tahun')."'";
        
        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            if ($data['Status'] == "Error") {
                return errorResponseWithContent(message: 'error - get data periode', content : $data['Message']);
            } else {
                return successResponse(content : $data['Data']['Items']);
            }
        } catch (Exception $e) {
            return errorResponseWithContent(content : $e->getMessage());
        }
    }

}
