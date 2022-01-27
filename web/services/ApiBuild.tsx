import axios, {AxiosInstance} from 'axios';

const instance = axios.create({
	baseURL: 'http://api:80/api'
});

export default instance;
export type {AxiosInstance};