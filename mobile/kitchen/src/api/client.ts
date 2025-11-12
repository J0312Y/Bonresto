import axios from 'axios';

const API_BASE = "http://localhost/bonresto/"; // <-- update to your dev server URL (use LAN IP for device)

const client = axios.create({
  baseURL: API_BASE,
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json'
  }
});

export default client;

export async function saveFcmToken(token: string) {
  try {
    // server expects JSON body { fcm_token: "..." }
    const resp = await client.post('/index.php/Api/save_fcm_token', { fcm_token: token });
    return resp.data;
  } catch (err) {
    // swallow error for scaffold; caller may log
    return null;
  }
}
