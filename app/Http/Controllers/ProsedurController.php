<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProsedurController extends Controller
{
    function index() {

        $filter = [
            ["name"=>"VISIBLE","Value"=>"1","SearchType"=>"Tepat"]
        ];
        $data = kurl('GET','getlist', 'ISBN_INFO_PROCEDURE', $filter, 'KriteriaFilter'); 
        $response = $data['Data']['Items'];

        if ($data['Data']['Items']) {
            $menu_header = [];
            $grouped_data = [];
            foreach ($response as $k => $v) {
                $get_arr = explode('.', $v['NOMOR']);
                if (empty($menu_header[$get_arr[0]])) {
                    $menu_header[$get_arr[0]] = $v['TITLE'];
                    //set header
                    $grouped_data[$get_arr[0]]['header'] = $v['TITLE'];
                }
                //set detail
                $grouped_data[$get_arr[0]]['items'][] = $v; 
            }
        }

        return view('content.prosedur', compact('grouped_data'));
    }
}
