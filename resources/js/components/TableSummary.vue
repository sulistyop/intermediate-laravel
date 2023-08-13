<template>
    <div class="card m-1">
        <div class="pt-2 px-2 bg-warning">
            <h5 class="success text-capitalize fs-6 fw-bold"> <i class="bi bi-file-bar-graph-fill"></i> Summary </h5>
        </div>
        <div class="m-2">
            <div class="row">
                <div class="col-sm-6">
                    <table class="table table-striped table-responsive table-bordered">
                        <thead>
                        <tr>
                            <th>Area</th>
                            <th class="text-end">Presentase</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(value,kecamatan ,key) in visits.presentase"
                            :key="key"
                        >
                            <td>{{kecamatan}}</td>
                            <td class="text-end">{{value}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="table table-striped table-responsive table-bordered">
                        <thead>
                        <tr>
                            <th>Sub</th>
                            <th class="text-end">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="(value,jenis ,key) in visits.total_sub_kunjungan"
                            :key="key"
                        >
                            <td>{{jenis}}</td>
                            <td class="text-end fw-bold">{{value}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Masonry from "masonry-layout";
export default
{
    name: "TableKunjungan",
    props: ["visits"],
};
</script>

