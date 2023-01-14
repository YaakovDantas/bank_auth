import axios from "axios";
import dotenv from "dotenv";

dotenv.config();

const http = axios.create({
  baseURL: process.env.VUE_APP_API_SERVER,
});

http.interceptors.request.use(
  (config) => {
    config.headers["Authorization"] = `Bearer ${localStorage.getItem(
      "user_token"
    )}`;
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

export default http;
