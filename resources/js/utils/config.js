import axios from "axios";

const URL = "http://localhost";
const PORT = "8000";
const PREFIX = "api";

// const BASE_URL = `${URL}:${PORT}/${PREFIX}`;
const BASE_URL = '/api';

export const getToken = () => {
    const token = localStorage.getItem('token');
    if (token == null) {
        return false;
    }
    return token;
}

export default axios.create({
    baseURL: BASE_URL,
    headers: {
        'Authorization': 'Bearer ' + getToken(),
        //"Content-type": "application/x-www-form-urlencoded",
        'Accept': 'application/json'
    }
});

export const headers = () => {
    const token = localStorage.getItem('token');
    if (token == '' || token == null) {
        return false;
    }
    return {
        'Authorization': 'Bearer ' + token,
        'Content-Type': 'application/x-www-form-urlencoded',
        'Accept': 'application/json'
    };
}

//console.log(headers());

export const authLogin = async (data) => {
    return await axios.post(BASE_URL + '/login', { ...data
        })
        .then(response => {
            return response;
        }).catch(error => {
            console.log(`error :`, error);
        });
}


export const fetchData = async (url, data) => {
    return await axios.post(BASE_URL + url, { ...data
        }, {
            headers
        })
        .then(response => {
            return response.data;
        }).catch(error => {
            console.log(`error :`, error);
        });
}

export const fetchAll = (url, data) => {   
    return axios.get(BASE_URL + url, {
            headers : headers
        })
        .then(response => {
            return response.data;
        }).catch(error => {
            console.log(`error :`, error);
        });
}


export const fetchPost = (url, data) => {
    return axios.post(BASE_URL + url, JSON.stringify(data), {
            headers
        })
        .then(response => {
            return response.data;
        }).catch(error => {
            console.log(`error :`, error);
        });
}
