<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;


class PencarianController extends Controller
{
    function index(Request $request) {

        //$kotaPopuler = $this->kota_penerbit_terbanyak();
        //$penerbitPopuler = $this->penerbit_terbanyak();

        //if($request->isMethod('post')){

            $keyword = $request->input('keyword');
            $filter_by = $request->input('filter_by'); // Filter berdasarkan pilihan user
            $jenis_media = $request->input('jenis_media') ? $request->input('jenis_media') : 'all';
            return view('content.pencarian2',compact('keyword', 'filter_by', 'jenis_media'));
        //}

        //return view('content.pencarian',compact('kotaPopuler','penerbitPopuler'));
    }

    //serverside
    function search(Request $request) {
        
       // $start = $request->input('page', 0); 
        //$length = $request->input('pageSize', 10); 
        
        // Calculate starting and ending row for Oracle's ROW_NUMBER
        //$startRow = ($start * $length) + 1; 
        //$endRow = $startRow + $length - 1; 
        
        $start  = $request->input('start');
        $length = $request->input('length');
        //$order  = $whereLike[$request->input('order.0.column')];
        //$dir    = $request->input('order.0.dir');
        //$search = $request->input('search.value');
        //$id = session('penerbit')['ID'];
        $end = $start + $length;

        $keyword = $request->input('search');
        $filter_by = $request->input('filter_by'); // Search filter
        $jenis_media = $request->input('jenis_media'); // Search filter

        $where = '';
        if ($filter_by == 'all' && $keyword != "") {
            $keyword = strtoupper($keyword); //upper
            $where .= "where upper(pi.isbn_no) like '%".$keyword."%' or upper(pt.title) like '%".$keyword."%' or upper(pt.kepeng) like '%".$keyword."%' or upper(p.name) like '%".$keyword."%'";
        } else if($filter_by && $keyword != "") {
            $keyword = strtoupper($keyword); //upper
            if($filter_by == 'PI.ISBN_NO'){
                $keyword = str_replace ('-', '', $keyword);
            }
            $where .= "where upper($filter_by) like '%".$keyword."%'"; //filterby ambil dari params filter dihome
        } else {
            $where = '';
        }

        //filter dari halaman pencarian 
        $by_penerbit = strtoupper($request->input('by_penerbit'));
        $by_kota = strtoupper($request->input('by_kota'));

        //validasi 
        $operator = $where != "" ? "and " : "where ";
        if ($by_penerbit && $by_kota) {
            $where .= " $operator upper(p.name) ='$by_penerbit' and upper(pt.tempat_terbit) = '$by_kota'";
        } else if ($by_penerbit){
            $where .= " $operator upper(p.name) ='$by_penerbit'";
        } else if ($by_kota){
            $where .= " $operator upper(pt.tempat_terbit) = '$by_kota'";
        } else {
            // $where; //hanya mengambil filter
        }

        //filter jenis
        if ($jenis_media != 'all' && $jenis_media != "") {
            $operator = $where != "" ? "AND " : "WHERE ";
            $where = $where. " $operator pt.jenis_media ='$jenis_media'";
        } else {
            $where;
        }
        
        //query
        $query = "SELECT outer.* FROM (SELECT inner.*, rownum rn FROM (
                SELECT 
                    (prefix_element || '-' || publisher_element || '-' || item_element || '-' || check_digit) AS isbn_no,
                    -- PI.ISBN_NO,
                    pt.title,
                    pt.kepeng,
                    pt.tempat_terbit,
                    pt.jml_jilid,
                    pt.tahun_terbit,
                    pt.seri,
                    pt.id,
                    -- pt.link_buku,
                    pi.link_buku,
                    pt.is_kdt_valid,
                    pt.jenis_media,
                    p.name as nama_penerbit,
                    p.id as penerbit_id
                FROM penerbit_isbn pi
                JOIN penerbit_terbitan pt ON pi.penerbit_terbitan_id = pt.id
                JOIN penerbit p ON pi.penerbit_id = p.id
                $where
            ) inner
            WHERE rownum <= $end ) outer where rn >$start ";
        \Log::info($query);
        //fetch api
        $data = kurl('get','getlistraw', null, $query, 'sql');
        $responseData = $data['Data'];

        // Fetch all data for total count
        $totalQuery = "SELECT count(pi.id) as total from penerbit_isbn pi
            join penerbit_terbitan pt on pi.penerbit_terbitan_id = pt.id
            join penerbit p on pi.penerbit_id = p.id ";

        $totalData = kurl('get', 'getlistraw', null, $totalQuery, 'sql');
        $totalFiltered = kurl('get', 'getlistraw', null, $totalQuery . $where, 'sql');

        $totalRecords = $totalData['Data']['Items'][0]['TOTAL'];
        $totalFilteredRecords = $totalFiltered['Data']['Items'][0]['TOTAL'];

        //Olah data
        $data = $responseData['Items']; // Data for the current page
        // $totalRecords = count($responseData['Items']); // Total records before pagination
        // $totalFiltered = count($responseData['Items']); // Total records after filtering

        // Return data in DataTables format
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFilteredRecords,
            'data' => $data
        ]);
    }

    function penerbit_terbanyak(Request $request) {
        $keyword = $request->input('search');
        $filter_by = $request->input('filter_by'); // Search filter
        $jenis_media = $request->input('jenis_media'); // Search filter

        $where = '';
        if ($filter_by == 'all' && $keyword != "") {
            $keyword = strtoupper($keyword); //upper
            $where .= "where upper(pi.isbn_no) like '%".$keyword."%' or upper(pt.title) like '%".$keyword."%' or upper(pt.kepeng) like '%".$keyword."%' or upper(p.name) like '%".$keyword."%'";
        } else if($filter_by && $keyword != "") {
            $keyword = strtoupper($keyword); //upper
            if($filter_by == 'PI.ISBN_NO'){
                $keyword = str_replace ('-', '', $keyword);
            }
            $where .= "where upper($filter_by) like '%".$keyword."%'"; //filterby ambil dari params filter dihome
        } else {
            $where = '';
        }

        //filter dari halaman pencarian 
        $by_penerbit = strtoupper($request->input('by_penerbit'));
        $by_kota = strtoupper($request->input('by_kota'));

        //validasi 
        $operator = $where != "" ? "and " : "where ";
        if ($by_penerbit && $by_kota) {
            $where .= " $operator upper(p.name) ='$by_penerbit' and upper(pt.tempat_terbit) = '$by_kota'";
        } else if ($by_penerbit){
            $where .= " $operator upper(p.name) ='$by_penerbit'";
        } else if ($by_kota){
            $where .= " $operator upper(pt.tempat_terbit) = '$by_kota'";
        } else {
            // $where; //hanya mengambil filter
        }

        //filter jenis
        if ($jenis_media != 'all' && $jenis_media != "") {
            $operator = $where != "" ? "AND " : "WHERE ";
            $where = $where. " $operator pt.jenis_media ='$jenis_media'";
        } else {
            $where;
        }
        
        $query = "SELECT 
                NAMA_PENERBIT, 
                jumlah
            FROM (
                SELECT 
                    P.NAME AS NAMA_PENERBIT,
                    COUNT(*) AS jumlah
                FROM 
                    penerbit_terbitan PT
                JOIN PENERBIT P ON PT.PENERBIT_ID = P.ID 
                $where  
                    AND PT.PENERBIT_ID IS NOT NULL 
                GROUP BY 
                    P.NAME -- Use P.NAME in the GROUP BY instead of PENERBIT_ID
                ORDER BY 
                    jumlah DESC
            ) 
            WHERE ROWNUM <= 5";
        
        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');
            if ($data['Status'] == "Error") {
                return [];
            } else {
                //response
                return $data['Data']['Items'];
            }
        } catch (Exception $e) {
            return [];
        }
    }

    function kota_penerbit_terbanyak(Request $request) {
        $keyword = $request->input('search');
        $filter_by = $request->input('filter_by'); // Search filter
        $jenis_media = $request->input('jenis_media'); // Search filter

        $where = '';
        if ($filter_by == 'all' && $keyword != "") {
            $keyword = strtoupper($keyword); //upper
            $where .= "where upper(pi.isbn_no) like '%".$keyword."%' or upper(pt.title) like '%".$keyword."%' or upper(pt.kepeng) like '%".$keyword."%' or upper(p.name) like '%".$keyword."%'";
        } else if($filter_by && $keyword != "") {
            $keyword = strtoupper($keyword); //upper
            if($filter_by == 'PI.ISBN_NO'){
                $keyword = str_replace ('-', '', $keyword);
            }
            $where .= "where upper($filter_by) like '%".$keyword."%'"; //filterby ambil dari params filter dihome
        } else {
            $where = '';
        }

        //filter dari halaman pencarian 
        $by_penerbit = strtoupper($request->input('by_penerbit'));
        $by_kota = strtoupper($request->input('by_kota'));

        //validasi 
        $operator = $where != "" ? "and " : "where ";
        if ($by_penerbit && $by_kota) {
            $where .= " $operator upper(p.name) ='$by_penerbit' and upper(pt.tempat_terbit) = '$by_kota'";
        } else if ($by_penerbit){
            $where .= " $operator upper(p.name) ='$by_penerbit'";
        } else if ($by_kota){
            $where .= " $operator upper(pt.tempat_terbit) = '$by_kota'";
        } else {
            // $where; //hanya mengambil filter
        }

        //filter jenis
        if ($jenis_media != 'all' && $jenis_media != "") {
            $operator = $where != "" ? "AND " : "WHERE ";
            $where = $where. " $operator pt.jenis_media ='$jenis_media'";
        } else {
            $where;
        }
        $query = "SELECT * FROM (
                SELECT * FROM (        
                    SELECT
                        PT.TEMPAT_TERBIT as CITY, 
                        COUNT(1) AS JUMLAH
                    FROM PENERBIT_ISBN PI
                    INNER JOIN PENERBIT_TERBITAN PT ON PI.PENERBIT_TERBITAN_ID = PT.ID
                    $where AND PT.TEMPAT_TERBIT IS NOT NULL
                    GROUP BY PT.TEMPAT_TERBIT
                    ) a
                    ORDER BY JUMLAH DESC
                    ) b
                    WHERE ROWNUM <= 5";

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            if ($data['Status'] == "Error") {
                return [];
            } else {
                //response
                return $data['Data']['Items'];
            }
        } catch (Exception $e) {
            return [];
        }
    }

    function dataKdt() {
        $query = "SELECT 
                NAMA_PENERBIT, 
                jumlah
            FROM (
                SELECT 
                    P.NAME AS NAMA_PENERBIT,
                    COUNT(*) AS jumlah
                FROM 
                    penerbit_terbitan PT
                JOIN PENERBIT P ON PT.PENERBIT_ID = P.ID 
                WHERE 
                    PT.PENERBIT_ID IS NOT NULL
                GROUP BY 
                    P.NAME -- Use P.NAME in the GROUP BY instead of PENERBIT_ID
                ORDER BY 
                    jumlah DESC
            ) 
            WHERE ROWNUM <= 5";

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');
            if ($data['Status'] == "Error") {
                return [];
            } else {
                //response
                return $data['Data']['Items'];
            }
        } catch (Exception $e) {
            return [];
        }
    }



}
