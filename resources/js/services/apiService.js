import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost:8000/api', // Ganti dengan URL base API Anda
    headers: {
        'Content-Type': 'application/json',
        'Authorization': sessionStorage.getItem('token'),
    }
});


export {apiClient}
