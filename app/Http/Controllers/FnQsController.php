<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FnQsController extends Controller
{
    function index() {
        return view('content.fnq');
    }

    function getData(Request $request) {
        $search = $request->query('keyword'); // Search filter
        $where = "";
        if ($search) {
            $search = strtoupper($search); //upper
            $where = "AND UPPER(JUDUL) LIKE '%$search%' OR UPPER(ISI) LIKE '%$search%'";
        }

        $query = "SELECT NOMOR_URUT, JUDUL, ISI 
            FROM ISBN_FAQ 
            WHERE IS_VISIBLE = '1' 
            $where
            ORDER BY NOMOR_URUT";

        try {
            // API call
            $data = kurl('get', 'getlistraw', null, $query, 'sql');

            if ($data['Status'] == "Error") {
                return response()->json(['faq' => '']);
            } else {
                $cardHtml = '';
                if ($data['Data']['Items']) {
                    foreach ($data['Data']['Items'] as $k => $v) {
                        $cardHtml .= '
                            <div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5 mt-5">
                                <div class="d-flex" >
                                    <span class="badge bg-design rounded-pill mt-4"">'.$v['NOMOR_URUT'].'</span>
    
                                    <div class="custom-block-topics-listing-info d-flex">
                                        <div >
                                            <div>
                                                <h5 class="mb-2">'.$v['JUDUL'].'</h5>
                                                <p class="mb-0">'.html_entity_decode($v['ISI']).'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                } else {
                    $cardHtml .= '<div class="custom-block custom-block-topics-listing bg-white shadow-lg mb-5 mt-5">
                                <div class="d-flex" >
                                    <div class="custom-block-topics-listing-info d-flex">
                                        <div >
                                            <div>
                                                <h5 class="mb-2"></h5>
                                                <p class="mb-0">Data pencarian tidak ditemukan</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }
                return response()->json(['faq' => $cardHtml]);
            }
        } catch (Exception $e) {
            return response()->json(['faq' => '']);
        }
    }
}
