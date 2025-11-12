const axios = require('axios');
const { API_BASE_URL } = require('../../shared/config');
const BASE = process.env.API_BASE_URL || API_BASE_URL;

async function smokeLogin() {
  try {
    const params = new URLSearchParams();
    params.append('email', process.argv[2] || 'admin@example.com');
    params.append('password', process.argv[3] || '12345');
    params.append('token', 'smoke-test-token');

    const res = await axios.post(`${BASE}/V3/sign_in`, params.toString(), {
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    });
    console.log('Status:', res.data.status, 'Message:', res.data.message);
    console.log('Data:', JSON.stringify(res.data.data, null, 2));
  } catch (err) {
    console.error('Error:', err.response ? err.response.data : err.message);
  }
}

smokeLogin();
