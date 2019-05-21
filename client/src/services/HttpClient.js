const axios = require('axios');
const API_ENDPOINT = 'http://127.0.0.1/api';

export class HttpClient {
    static async get(path, params) {
        return axios.get(API_ENDPOINT + path, {params}).then(response => response.data);
    }

    static async post(path, data) {
        return axios.post(API_ENDPOINT + path, data).then(response => response.data);
    }

    static async delete(path, params) {
        return axios.delete(API_ENDPOINT + path, {params}).then(response => response.data);
    }
}