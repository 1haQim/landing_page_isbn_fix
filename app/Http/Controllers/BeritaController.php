<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class BeritaController extends Controller
{
    function index() {
        $filter = [
            ["name"=>"IS_VISIBLE","Value"=>"1","SearchType"=>"Tepat"]
        ];

        //get restAPI
        $data = kurl('get','getlist', 'ISBN_MST_BERITA', $filter, 'KriteriaFilter');
        $responseData = $data['Data'];

        return $responseData;
    }
}
