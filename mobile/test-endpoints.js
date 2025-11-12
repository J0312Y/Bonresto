const axios = require('axios');
const FormData = require('form-data');

const { API_BASE_URL } = require('./shared/config');

// Helper function to get active users (admin only)
async function getActiveUsers() {
  try {
    // Login as admin first
    const adminForm = new FormData();
    adminForm.append('email', 'admin@example.com');
    adminForm.append('password', '12345');
    adminForm.append('token', 'admin-token');

    const loginResp = await axios.post(API_BASE_URL + '/V3/sign_in', adminForm, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });

    console.log('Admin login response:', loginResp.data);

    // Now get user list
    const usersResp = await axios.get(API_BASE_URL + '/V3/user_list');
    console.log('Users list:', usersResp.data);
    
    return usersResp.data;
  } catch (err) {
    console.error('Failed to get users:', err.response?.data || err.message);
    return null;
  }
}

const client = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'multipart/form-data'
  }
});

// Test credentials - replace with valid test credentials
const TEST_CREDENTIALS = {
  admin: {
    email: 'waiter@example.com',
    password: '1234',
    token: 'admin-token-' + Date.now()
  },
  kitchen: {
    email: 'waiter@example.com',
    password: '1234',
    token: 'test-kitchen-token-' + Date.now()
  },
  waiter: {
    email: 'waiter@example.com',
    password: '1234',
    token: 'test-waiter-token-' + Date.now()
  }
};

async function testEndpoint(name, fn) {
  try {
    console.log(`\nTesting ${name}...`);
    const result = await fn();
    console.log('Success:', JSON.stringify(result.data, null, 2));
    return result.data;
  } catch (err) {
    console.error('Error:', err.response?.data || err.message);
    return null;
  }
}

async function runTests() {
  console.log('Starting API endpoint tests...\n');
  
  // First test admin login
  const adminLogin = await testEndpoint('Admin Login', async () => {
    const form = new FormData();
    form.append('email', TEST_CREDENTIALS.admin.email);
    form.append('password', TEST_CREDENTIALS.admin.password);
    form.append('token', TEST_CREDENTIALS.admin.token);
    return client.post('/V3/sign_in', form);
  });

  // 1. Test Kitchen Login
  const kitchenLogin = await testEndpoint('Kitchen Login', async () => {
    const form = new FormData();
    form.append('email', TEST_CREDENTIALS.kitchen.email);
    form.append('password', TEST_CREDENTIALS.kitchen.password);
    form.append('token', TEST_CREDENTIALS.kitchen.token);
    return client.post('/V3/sign_in', form);
  });

  if (!kitchenLogin?.data?.id) {
    console.error('Kitchen login failed, skipping related tests');
    return;
  }

  const kitchenId = kitchenLogin.data.kitchenid?.replace(/'/g, '').split(',')[0];

  // 2. Test Kitchen Order List
  await testEndpoint('Kitchen Order List', async () => {
    const form = new FormData();
    form.append('id', kitchenLogin.data.id);
    form.append('kitchenid', kitchenId);
    return client.post('/V3/orderlist', form);
  });

  // 3. Test Food Ready Status Update
  await testEndpoint('Food Ready Status Update', async () => {
    const form = new FormData();
    form.append('Orderid', '1'); // Replace with valid order ID
    form.append('ProductsID', '1'); // Replace with valid product ID
    form.append('variantid', '1'); // Replace with valid variant ID
    form.append('isready', '1');
    form.append('kitchenid', kitchenId);
    return client.post('/V3/foodisready', form);
  });

  // 4. Test FCM Token Save
  await testEndpoint('Save FCM Token', async () => {
    const form = new FormData();
    form.append('userid', kitchenLogin.data.id);
    form.append('token', 'test-fcm-token-' + Date.now());
    return client.post('/Api/save_fcm_token', form);
  });

  // 5. Test Waiter Login
  const waiterLogin = await testEndpoint('Waiter Login', async () => {
    const form = new FormData();
    form.append('email', TEST_CREDENTIALS.waiter.email);
    form.append('password', TEST_CREDENTIALS.waiter.password);
    form.append('token', TEST_CREDENTIALS.waiter.token);
    return client.post('/V3/sign_in', form);
  });

  if (!waiterLogin?.data?.id) {
    console.error('Waiter login failed, skipping related tests');
    return;
  }

  // 6. Test Waiter Order List
  await testEndpoint('Waiter Order List', async () => {
    const form = new FormData();
    form.append('waiterid', waiterLogin.data.id);
    return client.post('/V3/waiter_orderlist', form);
  });

  // 7. Test Order Status Update
  await testEndpoint('Update Order Status', async () => {
    const form = new FormData();
    form.append('orderid', '1'); // Replace with valid order ID
    form.append('status', 'processing');
    form.append('waiterid', waiterLogin.data.id);
    return client.post('/V3/update_order_status', form);
  });

  // 8. Test Table List
  await testEndpoint('Get Tables', async () => {
    return client.get('/V3/table_list');
  });
}

// Install dependencies and run tests
console.log('Installing dependencies...');
require('child_process').execSync('npm install axios form-data', { stdio: 'inherit' });

console.log('\nRunning tests...');
runTests().catch(console.error);