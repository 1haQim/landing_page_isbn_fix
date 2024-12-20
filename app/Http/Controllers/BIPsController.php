<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BIPsController extends Controller
{
    public function index(Request $request)
    {
        return view('content.home_bip');
    }

    function serverside_bip(Request $request) {
        // Get the pagination parameters from DataTables
        $page = $request->input('page'); // Current page number
        $pageSize = $request->input('pageSize'); // Number of records per page
        $search = $request->input('search.value'); // Search filter

        $filter = null;
        if (!empty($search)) {
            $filter = [
                ["name"=>"DESKRIPSI","Value"=>$search,"SearchType"=>"SalahSatuIsi"]
            ];
            $page = 1;
        }
        //get pagination restAPI
        $params = [
            'PageNumber' => $page,
            'MaxItemPerPage' => $pageSize
        ];

        //get restAPI
        $data = kurl('get','getlist', 'ISBN_MST_BIP_DOWN', $filter, 'KriteriaFilter', $params);
        $responseData = $data['Data'];

        //Olah data
        $data = $responseData['Items']; // Data for the current page
        $totalRecords = $responseData['TotalData']; // Total records before pagination
        $totalFiltered = $responseData['TotalData']; // Total records after filtering

        // Return data in DataTables format
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }
}
