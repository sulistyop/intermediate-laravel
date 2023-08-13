<template>
    <div>
        <h1>Login</h1>
        <form @submit.prevent="login">
            <label for="name">Email:</label>
            <input type="text" id="name" v-model="email" />

            <label for="password">Password:</label>
            <input type="password" id="password" v-model="password"  autocomplete="true"/>

            <button type="submit">Login</button>
        </form>
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
    methods: {

         login() {
                const queryParams = new URLSearchParams({
                    email: this.email,
                    password: this.password,
                });
                axios
                    .post('http://localhost:8000/api/login', queryParams.toString())
                    .then((response) => {
                        sessionStorage.setItem('token',response.data.data.token)
                        window.location.reload();
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
        },
    },
};
</script>
