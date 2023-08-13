<template>
    <nav class="navbar navbar-light fixed-top bg-light shadow-sm">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Sistem Informasi Rumah Sakit</span>
            <div>
                <button @click="doLogout" class="btn btn-sm btn-danger">Logout</button>
            </div>
        </div>
    </nav>
    <div style="margin-top: 70px"></div>
</template>

<script>
export default {
    name: "Navbar",
    props: [],
    data(){
        return {
            token:''
        }
    },
    methods:{
        doLogout(){
            sessionStorage.removeItem('token')
            window.location.reload()
        }
    },

};
</script>
