<?php

namespace App\Services\Impl;

use App\Models\Kabupaten;
use App\Services\VisitService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class VisitServiceImpl implements VisitService
{
    public function getData($request): array
    {
        $tipe = $request->input('tipe') ?? [];
        $tanggal_awal = $request->input('tanggal_awal') ?? [];
        $tanggal_akhir = $request->input('tanggal_akhir') ?? [];
        $kabupaten = $request->input('kabupaten') ?? [];

        $query = DB::table('dc_pendaftaran as pendaftaran')
            ->join('dc_pasien as pasien', 'pendaftaran.id_pasien', '=', 'pasien.id')
            ->join('dc_kelurahan as kelurahan', 'pasien.id_kelurahan', '=', 'kelurahan.id')
            ->join('dc_kecamatan as kecamatan', 'kelurahan.id_kecamatan', '=', 'kecamatan.id')
            ->join('dc_kabupaten as kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id')
            ->join('dc_provinsi as provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id')
            ->select(
                'kelurahan.nama AS nama_kelurahan',
                'kecamatan.nama AS nama_kecamatan',
                DB::raw('SUM(CASE WHEN jenis = "Poliklinik" THEN 1 ELSE 0 END) as jumlah_poliklinik'),
                DB::raw('SUM(CASE WHEN jenis = "IGD" THEN 1 ELSE 0 END) as jumlah_igd'),
                DB::raw('SUM(CASE WHEN jenis_igd = "Kamar Bersalin" THEN 1 ELSE 0 END) as jumlah_kamar_bersalin')
            );
        //Query Filter

        if(!empty($kabupaten)){
            $query->where('kabupaten.nama', $kabupaten);
        }

        if(!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            if($tipe == 'daily'){
                $query->whereBetween('pendaftaran.waktu_daftar', [$tanggal_awal, $tanggal_akhir]);
            }elseif($tipe == 'yearly'){
                $query->whereBetween('pendaftaran.waktu_daftar', [
                    $tanggal_awal.'-01-01',
                    $tanggal_akhir.'-12-31'
                ]);
            }else{//monthly
                $query->whereBetween('pendaftaran.waktu_daftar', [
                    $tanggal_awal.'-01',
                    $tanggal_akhir.'-01',
                ]);
            }
        }

        $results = $query->orderBy('kecamatan.nama','ASC')->groupBy(
            'kecamatan.id', 'kelurahan.id',
            'kecamatan.nama','kelurahan.nama',
            'pendaftaran.id','pendaftaran.jenis','pendaftaran.jenis_igd',
            'pendaftaran.no_register','pendaftaran.waktu_daftar'
        )->get();

        return $this->grupingData($results);
    }

    /*
     *  eksekusi grouping data by kecamatan dan kelurahan
     *   - kecamatan
     *   --/ kelurahan
     */
    private function grupingData(object $results)
    {
        $hasilGroupData = [];
        $totalPengunjung = [
            'poliklinik' => [],
            'igd' => [],
            'kamar_bersalin' => [],
        ];
        foreach ($results as $result) {
            $nama_kelurahan = $result->nama_kelurahan;
            $nama_kecamatan = $result->nama_kecamatan;

            if (!isset($hasilGroupData[$nama_kecamatan])) {
                $hasilGroupData[$nama_kecamatan] = [
                    'total_pengunjung_kecamatan' => 0,
                    'total_poliklinik' => 0,
                    'total_igd' => 0,
                    'total_kamar_bersalin' => 0,
                    'kelurahan' => []
                ];
            }
            if (!isset($hasilGroupData[$nama_kecamatan]['kelurahan'][$nama_kelurahan])) {
                $hasilGroupData[$nama_kecamatan]['kelurahan'][$nama_kelurahan] = [
                    'total_pengunjung_kelurahan' => 0,
                    'jumlah_poliklinik' => 0,
                    'jumlah_igd' => 0,
                    'jumlah_kamar_bersalin' => 0
                ];
            }

            $total_pengunjung_kelurahan = $result->jumlah_poliklinik + $result->jumlah_igd + $result->jumlah_kamar_bersalin;

            //menghitung total dari semua data kelurahan per kecamatan
            $hasilGroupData[$nama_kecamatan]['total_pengunjung_kecamatan'] += $total_pengunjung_kelurahan;
            $hasilGroupData[$nama_kecamatan]['total_poliklinik'] += $result->jumlah_poliklinik;
            $hasilGroupData[$nama_kecamatan]['total_igd'] += $result->jumlah_igd;
            $hasilGroupData[$nama_kecamatan]['total_kamar_bersalin'] += $result->jumlah_kamar_bersalin;

            //menghitung total dari semua data kunjungan per kelurahan
            $hasilGroupData[$nama_kecamatan]['kelurahan'][$nama_kelurahan]['total_pengunjung_kelurahan'] += $total_pengunjung_kelurahan;
            $hasilGroupData[$nama_kecamatan]['kelurahan'][$nama_kelurahan]['jumlah_poliklinik'] += $result->jumlah_poliklinik;
            $hasilGroupData[$nama_kecamatan]['kelurahan'][$nama_kelurahan]['jumlah_igd'] += $result->jumlah_igd;
            $hasilGroupData[$nama_kecamatan]['kelurahan'][$nama_kelurahan]['jumlah_kamar_bersalin'] += $result->jumlah_kamar_bersalin;

            // Menghitung total kunjungan untuk tiap kecamatan berdasarkan jenis
            $totalPengunjung['total'][$nama_kecamatan] = ($totalPengunjung['poliklinik'][$nama_kecamatan] ?? 0) + $total_pengunjung_kelurahan;
            $totalPengunjung['poliklinik'][$nama_kecamatan] = ($totalPengunjung['poliklinik'][$nama_kecamatan] ?? 0) + $result->jumlah_poliklinik;
            $totalPengunjung['igd'][$nama_kecamatan] = ($totalPengunjung['igd'][$nama_kecamatan] ?? 0) + $result->jumlah_igd;
            $totalPengunjung['kamar_bersalin'][$nama_kecamatan] = ($totalPengunjung['kamar_bersalin'][$nama_kecamatan] ?? 0) + $result->jumlah_kamar_bersalin;
        }

        //total kunjungan dari setiap jenis layanan
        $totalPoliklinik = array_sum($totalPengunjung['poliklinik']);
        $totalIgd = array_sum($totalPengunjung['igd']);
        $totalKamarBersalin = array_sum($totalPengunjung['kamar_bersalin']);
        $totalPengunjungSeluruhKecamatan = $totalPoliklinik + $totalIgd + $totalKamarBersalin;

        $percentageByKecamatan = $this->getPrecentage($hasilGroupData, $totalPengunjungSeluruhKecamatan);


        return [
            'list_kunjungan' => $hasilGroupData,
            'presentase' => $percentageByKecamatan,
            'total_sub_kunjungan' => [
                'Poliklinik' => $totalPoliklinik,
                'IGD' => $totalIgd,
                'Kamar Bersalin' => $totalKamarBersalin,
                'Total' =>$totalPengunjungSeluruhKecamatan
            ]
        ];
    }

    // Menghitung persentase untuk tiap kecamatan
    private function getPrecentage($hasilGroupData, $totalPengunjungSeluruhKecamatan)
    {
        $array = [];
        foreach ($hasilGroupData as $kecamatan => $data) {
            $data['persentase_pengunjung_kecamatan'] = ($totalPengunjungSeluruhKecamatan > 0) ? ($data['total_pengunjung_kecamatan'] / $totalPengunjungSeluruhKecamatan) * 100 : 0;
            $array[$kecamatan] = number_format($data['persentase_pengunjung_kecamatan'], 2, '.', ',').' %';
        }
        return $array;
    }

    public function getKabupaten($request): array
    {
        return Kabupaten::all()->toArray();
    }
}
