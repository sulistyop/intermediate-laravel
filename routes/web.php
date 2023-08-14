<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/api-docs',function (){
    $endpoints = [
        [
            'name' => 'Login',
            'url' => 'http://localhost:8000/api/login',
            'method' => 'POST'
        ],
        [
            'name' => 'Register',
            'url' => 'http://localhost:8000/api/register',
            'method' => 'POST'
        ],
        [
            'name' => 'List Kabupaten',
            'url' => 'http://localhost:8000/api/kabupaten',
            'method' => 'GET',
            'desc' => '
                <table class="table table-bordered">
                    <tr>
                        <th>Key</th>
                        <th>Desc</th>
                    </tr>
                    <tr>
                        <td>tipe</td>
                        <td>
                         Query berdasarkan tipe (Harian, tahunan, Bulanan)

                        </td>
                    </tr>
                    <tr>
                        <td>tanggal_awal - tanggal_akhir</td>
                        <td>query date range, bisa digunakan utk harian, bulanan, tahunan</td>
                    </tr>
                    <tr>
                        <td>kabupaten</td>
                        <td>Query berdasarkan nama kabupaten</td>
                    </tr>


                </table>
               Catatan :
               <ul>
                    <li> Untuk Jika tipe yang dipilih adalah harian, maka input tanggal nya dengan format<strong> 2022-01-01</strong></li>
                    <li> Untuk Jika tipe yang dipilih adalah bulanan, maka input tanggal nya dengan format<strong> 2022-01 </strong></li>
                    <li> Untuk Jika tipe yang dipilih adalah harian, maka input tanggal nya dengan format<strong> 2022</strong></li>
                    <li> semuanya berlaku untuk <mark>tanggal_awal</mark> dan <mark>tanggal_akhir</mark></li>
                </ul>
                '
        ],
        [
            'name' => 'List Kunjungan - Presentase - dan Sub Kunjungan ',
            'url' => 'http://localhost:8000/api/kabupaten',
            'method' => 'GET'

        ],

    ];

    return view('api-docs',[
        'endpoints'=> $endpoints
    ]);
});
