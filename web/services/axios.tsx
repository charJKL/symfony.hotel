import axios, {AxiosInstance} from 'axios';

const instance = axios.create({
	baseURL: 'http://localhost:8000/api'
});

export default instance;
export type {AxiosInstance};