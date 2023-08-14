<template>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4" style="width: 400px; margin-top: -20vh;">
            <div class="card-body" >
                <h1 class="card-title font-monospace text-center mb-5">Login</h1>
                <form @submit.prevent="login">
                    <div class="mb-3">
                        <label for="name" class="form-label">Email:</label>
                        <input type="text" id="name" class="form-control" v-model="email" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" class="form-control" v-model="password" autocomplete="true" />
                    </div>
                    <button type="submit" class="btn btn-primary" :disabled="isFormEmpty">Login</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    computed: {
        isFormEmpty() {
            return (
                this.email === '' ||
                this.password === ''
            );
        }
    },
    methods: {
        login() {
            const queryParams = new URLSearchParams({
                email: this.email,
                password: this.password,
            });
            axios
                .post("http://localhost:8000/api/login", queryParams.toString())
                .then((response) => {
                    sessionStorage.setItem("token", response.data.data.token);
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error.response.data.message);
                });
        },
    },
};
</script>
