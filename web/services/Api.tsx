import axios, { AxiosError } from 'axios';

const Api = axios.create({
	baseURL: 'http://localhost:8000/api'
});

const isApiException = (e: any) : e is AxiosError => e.isAxiosError === true;

export { isApiException };
export default Api;