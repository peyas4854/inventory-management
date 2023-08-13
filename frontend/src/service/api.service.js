import axios from 'axios';
import JwtService from "@/service/jwt.service";

const ApiService = {
    init() {
        console.log('sd',process.env);
        axios.defaults.baseURL = process.env.VUE_APP_API_URL + "/api/";
        axios.defaults.headers.common["Authorization"] = `Bearer ${JwtService.getToken()}`;
    },

    get(resource, params) {
        return axios.get(`${resource}`, params);
    },

    post(resource, params) {
        return axios.post(`${resource}`, params);
    },

    update(resource, params) {
        return axios.put(`${resource}`, params);
    },

    delete(resource, params) {
        return axios.delete(resource);
    },
};

export default ApiService;
