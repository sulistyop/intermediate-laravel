<template>
    <div class="container">
        <div v-if="token">
            <Navbar/>
            <div class="text-left mb-5">
                <h4>Laporan Kunjungan Rawat Jalan Per Wilayah</h4>
            </div>
            <div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="bi bi-search p-1"></i> Pencarian
                </button>
                <button type="button" class="btn btn-sm btn-secondary mx-2" @click="getOrReloadData">
                    <i class="bi bi-bootstrap-reboot p-1"></i> Reload
                </button>
                <!-- Modal -->
                <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Filter Pencarian</h5>
                                <button type="button" class="btn-close" id="close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Type</label>
                                        <select class="form-select form-select-sm" id="type" v-model="selectedOption">
                                            <option value="daily">Harian</option>
                                            <option value="monthly">Bulan</option>
                                            <option value="yearly">Tahun</option>
                                        </select>
                                    </div>
                                    <label class="form-label">Filter Tanggal</label>
                                    <div v-if="selectedOption === 'daily'">
                                        <div class="input-group mb-3">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="date" class="form-control form-control-sm" id="tanggal_awal" v-model="tanggal_awal">
                                                </div>
                                                <div class="col">
                                                    <input type="date" class="form-control form-control-sm" id="tanggal_akhir" v-model="tanggal_akhir">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="selectedOption === 'monthly'">
                                        <div class="input-group mb-3">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="month" class="form-control form-control-sm" id="tanggal_awal" v-model="tanggal_awal">
                                                </div>
                                                <div class="col">
                                                    <input type="month" class="form-control form-control-sm" id="tanggal_akhir" v-model="tanggal_akhir">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="selectedOption === 'yearly'">
                                        <div class="input-group mb-3">
                                            <div class="row">
                                                <div class="col">
                                                    <input
                                                        type="number"
                                                        class="form-control form-control-sm"
                                                        id="tanggal_akhir"
                                                        min="1900"
                                                        max="2100"
                                                        v-model="tanggal_awal"
                                                    >
                                                </div>
                                                <div class="col">
                                                    <input
                                                        type="number"
                                                        class="form-control form-control-sm"
                                                        id="tanggal_akhir"
                                                        min="1900"
                                                        max="2100"
                                                        v-model="tanggal_akhir"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select class="form-select form-select-sm" id="kategori" v-model="category" >
                                            <option value="kelurahan">Kelurahan</option>
                                            <option value="kecamatan">Kecamatan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kabupaten" class="form-label">Kabupaten</label>
                                        <select
                                            class="form-select form-select-sm form-select-sm"
                                            id="kabupaten" v-model="kabupaten"
                                        >
                                            <option :value="option.nama" v-for="option in dataKabupaten" :key="option.id">
                                                {{ option.nama }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Keluar</button>
                                    <button type="button" class="btn btn-sm btn-primary" @click="searchFilter">Cari</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- List Kunjungan -->
            <div class="text-center d-none p-3" id="keterangan">
                <h5 class="fw-bold">Laporan Kunjungan Rawat Jalan per Kelurahan se Kabupaten {{kabupaten}} </h5>
                <div v-if="tanggal_akhir && tanggal_awal">
                    <h5 class="fw-lighter">{{ convertDate(tanggal_awal) }} s.d {{ convertDate(tanggal_akhir) }}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 p-2">
                    <TableSummary :visits="visits"/>
                </div>
                <div class="col-md-6 p-2"
                     v-for="(visit, kelurahan) in visits.list_kunjungan"
                     :key="kelurahan"
                >
                    <TableKunjungan :visit="visit" :kelurahan="kelurahan" />
                </div>
            </div>
        </div>
        <div class="h-100 d-flex align-items-center justify-content-center" v-else>
            <LoginComponent />
        </div>
    </div>

</template>

<script>
import axios from "axios";
import TableKunjungan from "../components/TableKunjungan.vue";
import Navbar from "./NavbarComponent.vue";
import TableSummary from "./TableSummary.vue";
import moment from 'moment';
import LoginComponent from "../components/LoginComponent.vue";

export default {
    name: "LaporanComponent",
    components: {
        Navbar,
        TableKunjungan,
        TableSummary,
        LoginComponent
    },
    data() {
        return {
            visits: [],
            filter: "",
            tanggal_awal: new Date().getFullYear(),
            tanggal_akhir: new Date().getFullYear(),
            category: "",
            type: "",
            kabupaten: "",
            token: null,
            dataKabupaten:null,
            selectedOption: 'daily',
        };
    },
    methods: {

        setProduct(data) {
            this.visits = data.data;
        },
        convertDate(date){
            if(this.selectedOption == 'yearly'){
                return date;
            }else if(this.selectedOption == 'monthly'){
                return moment(date).format('D MMM');
            }else{
                return moment(date).format('D MMM Y');

            }

        },
        searchFilter() {
            axios
                .get(
                    "http://localhost:8000/api/pendaftaran/get?" +
                    "tanggal_awal=" + this.tanggal_awal +
                    "&tanggal_akhir=" + this.tanggal_akhir +
                    "&kabupaten=" + this.kabupaten +
                    "&kategori=" + this.selectedOption
                )
                .then((response) => this.setProduct(response.data))
                .then(() => {
                    document.getElementById('close').click()
                    var element = document.getElementById("keterangan");
                    element.classList.remove("d-none");
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getOrReloadData(){
            axios.get("http://localhost:8000/api/pendaftaran/get")
                .then(
                    (response) => {
                        this.setProduct(response.data)
                    }
                ).catch(function (error) {
                    console.log(error);
                });

            if(this.token){
                document.getElementById("keterangan").classList.add("d-none");
            }
        },
        setToken(token) {
            this.token = token;
        },
        getListKabupaten(){
            axios
                .get("http://localhost:8000/api/kabupaten")
                .then((response) => this.dataKabupaten = response.data.data)

                .catch(function (error) {
                    console.log(error);
                });
        }

    },
    mounted() {
        const token = sessionStorage.getItem('token')
        if(token){
            this.getListKabupaten()
            this.getOrReloadData()
            this.setToken(token)
        }
    },
};
</script>


