import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

// 10.0.2.2 is for Android Emulator to access host localhost
// For iOS use http://localhost:8000
// For physical device use your machine's IP address e.g., http://192.168.1.X:8000
export const API_URL = 'http://10.0.2.2:8000/api/mobile/v1';

const client = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

client.interceptors.request.use(
  async (config) => {
    const token = await AsyncStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

client.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (error.response?.status === 401) {
      // Token expired or invalid
      await AsyncStorage.removeItem('auth_token');
      // You might want to trigger a navigation to login here via a global event or context
    }
    return Promise.reject(error);
  }
);

export default client;
