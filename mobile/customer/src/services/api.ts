import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

import { API_BASE_URL } from '../shared/config';

const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Accept': 'application/json'
  }
});

// Attach token from AsyncStorage to every request (if available)
api.interceptors.request.use(
  async (config) => {
    try {
      const token = await AsyncStorage.getItem('token');
      if (token) {
        if (!config.headers) config.headers = {} as any;
        // Attach as Bearer token for compatibility
        config.headers['Authorization'] = `Bearer ${token}`;
        // Also attach X-User-Id header since this backend commonly uses POST 'id' field
        // but some integrations expect the numeric user id in a header. Our stored token
        // is the numeric user id (see AuthContext), so include it for endpoints that
        // might read it from headers.
        config.headers['X-User-Id'] = token;
      }
    } catch (e) {
      console.warn('Failed to attach token to request', e);
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export async function signIn(email: string, password: string, deviceToken = '') {
  const form = new FormData();
  form.append('email', email);
  form.append('password', password);
  form.append('token', deviceToken);

  const resp = await api.post('/V3/sign_in', form);
  return resp.data;
}

export default api;

export async function getCategories(customerId: string = '1', name: string = '') {
  const form = new FormData();
  form.append('id', customerId);
  form.append('Name', name);
  const resp = await api.post('/Appv1/categorylist', form);
  return resp.data;
}

export async function getFoodList(customerId: string = '1', categoryId: string = '1', page = 1, limit = 50) {
  const form = new FormData();
  form.append('id', customerId);
  form.append('CategoryID', categoryId);
  form.append('page', String(page));
  form.append('limit', String(limit));
  const resp = await api.post('/Appv1/foodlist', form);
  return resp.data;
}
