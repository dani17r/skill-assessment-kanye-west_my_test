import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export const api = axios.create({
  baseURL: window.location.origin + '/api',
});