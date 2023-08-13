<template>
    <div class="card m-1">
        <div class="pt-2 px-2 bg-success-subtle">
            <h5 class="success text-capitalize fs-6 fw-bold"> <i class="bi bi-pin-map"></i> {{ kelurahan }}</h5>
        </div>
        <div class="m-1">
            <table class="table table-responsive table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Kelurahan</th>
                    <th class="text-center">Poli</th>
                    <th class="text-center">IGD</th>
                    <th class="text-center">KB</th>
                    <th class="text-end">Total</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(data,kelurahan,index ) in visit.kelurahan">
                    <td class="text-center">{{index + 1}}</td>
                    <td>{{kelurahan}}</td>
                    <td class="text-center">{{data.jumlah_poliklinik}}</td>
                    <td class="text-center">{{data.jumlah_igd}}</td>
                    <td class="text-center">{{data.jumlah_kamar_bersalin}}</td>
                    <td class="text-end fw-bold">{{data.total_pengunjung_kelurahan}}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" align="right">Total</td>
                    <td class="text-center fw-bold">{{visit.total_poliklinik}}</td>
                    <td class="text-center fw-bold">{{visit.total_igd}}</td>
                    <td class="text-center fw-bold">{{visit.total_kamar_bersalin}}</td>
                    <td class="text-end fw-bold">{{visit.total_pengunjung_kecamatan}}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
import Masonry from "masonry-layout";
export default
{
    name: "TableKunjungan",
    props: ["visit","kelurahan"],
};
</script>

