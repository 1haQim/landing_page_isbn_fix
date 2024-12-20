<?php

use Illuminate\Support\Facades\Http;

/*
params kurl
$method = post/get
$action = add, getlist, update, delete
$table = table yang akan dieksekusi
$data = data filter atau data update atau data add yang berupa array
$kategori = dari backend ada ListAddItem, ListUpdateItem
$params = untuk penambahan params pada saat req api (pagination dll)
*/

function kurl($method, $action, $table, $data, $kategori, $params = null) { 

    $body = $action == 'getlistraw' ? $data : json_encode($data);
    $form_data = [
        'token' => 'WWQG9BP0JBCL3QSAW9K75G',
        'op' => $action,
        'table' => $table,
        $kategori => $body
    ];

    //page
    if (!empty($params)) {
        $form_data = array_merge($form_data, $params);
    }

    $response = Http::asForm()->$method('http://demo321.online/ISBN_API/Restful.aspx', $form_data);

    if ($response->successful()) {
        $data = $response->json();
        return $data;

    } else {
        // Handle the error
        $status = $response->status();
        $error = $response->body();
        return $status;
    }
}

function kurl_upload($method, $action, $penerbit_id, $file, $ip_user) {
    $response = Http::asMultipart()->$method('http://demo321.online/ISBN_API/Restful.aspx', [
        [
            'name'     => 'token',
            'contents' => 'WWQG9BP0JBCL3QSAW9K75G',
        ],
        [
            'name'     => 'op',
            'contents' => $action,
        ],
        [
            'name'     => 'isbn_registrasi_penerbit_id',
            'contents' => $penerbit_id,
        ],
        [
            'name'     => 'actionby',
            'contents' => $penerbit_id,
        ],
        [
            'name'     => 'terminal',
            'contents' => $ip_user,
        ],
        [
            'name'     => 'file',
            'contents' => fopen($file->getRealPath(), 'r'),
            'filename' => $file->getClientOriginalName(),
        ],
    ]);

    if ($response->successful()) {
        $data = $response->json();
        return $data;

    } else {
        // Handle the error
        $status = $response->status();
        $error = $response->body();
        return $status;
    }
}