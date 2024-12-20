<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PelacakanController extends Controller
{
    function index() {
        return view('content.pelacakan');
    }

    function serverside_pelacakan(Request $request) {
        if ($request->isMethod('post')) {

            $resi = $request->input('resi');

            $query = "";
            if ($resi) {
                //QUERY LAMA SEBELUM REVISI
                // $query = "SELECT
                //     PT.NORESI,
                //     PT.TITLE,
                //     PT.KEPENG,
                //     PT.TEMPAT_TERBIT,
                //     PT.TAHUN_TERBIT,
                //     PT.MOHON_DATE,
                //     PT.STATUS,
                //     P.NAME AS NAMA_PENERBIT,
                //     PT.JILID_VOLUME
                // FROM
                //     PENERBIT_TERBITAN PT
                //     JOIN PENERBIT P ON PT.PENERBIT_ID = P.ID 
                // WHERE
                //     PT.NORESI = '".$resi."'";

                // QUERY BARU
                $query = "SELECT 
                    R.NORESI,
                    R.STATUS,
                    R.MOHON_DATE,
                    R.JML_JILID_REQ AS JILID_VOLUME,
                    PT.TITLE,
                    PT.KEPENG,
                    PT.TEMPAT_TERBIT,
                    PT.TAHUN_TERBIT,
                    P.NAME AS NAMA_PENERBIT
                FROM ISBN_RESI R
                JOIN PENERBIT_TERBITAN PT ON R.PENERBIT_TERBITAN_ID = PT.ID
                JOIN PENERBIT P ON R.PENERBIT_ID = P.ID
                WHERE R.NORESI = '".$resi."'";
            }

            //fetch api
            $data = kurl('get','getlistraw', null, $query, 'sql');
            $responseData = $data['Data'];

            return $responseData;
        }
    }
}
