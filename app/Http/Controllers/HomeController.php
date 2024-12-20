<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index() {
        $query = "SELECT NOMOR_URUT, JUDUL, ISI
            FROM (
                SELECT NOMOR_URUT, JUDUL, ISI, ROWNUM AS RN
                FROM (
                    SELECT NOMOR_URUT, JUDUL, ISI
                    FROM ISBN_FAQ
                    WHERE IS_VISIBLE = '1'
                    ORDER BY NOMOR_URUT
                )
                WHERE ROWNUM <= 4
            )
        WHERE RN >= 1";

        // API call
        $data = kurl('get', 'getlistraw', null, $query, 'sql');
        
        $dataFaq = [];
        if ($data['Data']['Items']) {
            $dataFaq = $data['Data']['Items'];
        }

        return view('content.home', compact('dataFaq'));
    }

    //ambil data untuk popup modal home first load
    function flyer(Request $request)  {
        if ($request->isMethod('post')) {
            $filter = [["name"=>"VISIBLE","Value"=>"1","SearchType"=>"Tepat"]];
            $data = kurl('get','getlist', 'ISBN_MST_FLYER', $filter, 'KriteriaFilter');
            return json_encode($data['Data']['Items'][0]['DESCRIPTION']);
        } else {
            return errorResponse();
        }
    }

    function isbn_info() {
        $menu = [
            'Pengertian ISBN','Fungsi ISBN','Struktur ISBN','Terbitan yang dapat diberikam','Terbitan yang tidak dapat diberikan','Pencantuman ISBN','Anggota Baru','Anggota Lama'
        ];
        return view('content.isbn_info', compact('menu'));
    }

}


