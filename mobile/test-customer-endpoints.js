const axios = require('axios');
const FormData = require('form-data');

const { API_BASE_URL } = require('./shared/config');
let authToken = null;
let customerId = null;

const client = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'multipart/form-data',
    'Accept': 'application/json'
  }
});

// Test credentials
const TEST_CREDENTIALS = {
  customer: {
    email: 'counter@example.com',
    password: '1234',
    token: 'test-fcm-token-' + Date.now()
  }
};

async function makeAuthRequest(endpoint, data) {
  const form = new FormData();
  Object.entries(data).forEach(([key, value]) => {
    form.append(key, value);
  });
  
  try {
    const response = await client.post(endpoint, form);
    return response;
  } catch (err) {
    console.error(`Error calling ${endpoint}:`, err.response?.data || err.message);
    throw err;
  }
}

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

async function runCustomerTests() {
  console.log('Starting Customer API endpoint tests...\n');

  // 1. First authenticate
  console.log('Testing authentication...');
  const authData = {
    customer_email: TEST_CREDENTIALS.customer.email,
    password: TEST_CREDENTIALS.customer.password,
    token: TEST_CREDENTIALS.customer.token
  };
  
  try {
    const authResponse = await makeAuthRequest('/Android/sign_in', authData);
    console.log('Auth Response:', JSON.stringify(authResponse.data, null, 2));
    
    if (authResponse.data && authResponse.data.customer_token) {
      authToken = authResponse.data.customer_token;
      customerId = authResponse.data.customer_id;
      console.log('Authentication successful');
    } else {
      console.error('No token received in auth response');
    }
  } catch (error) {
    console.error('Authentication failed:', error.message);
    return;
  }

  // 2. Test Category List
  await testEndpoint('Get Category List', async () => {
    const form = new FormData();
    if (authToken) form.append('token', authToken);
    return client.post('/Api_v2/categorylist', form);
  });

  // 3. Test Food List
  await testEndpoint('Get Food List', async () => {
    const form = new FormData();
    form.append('id', customerId);
    form.append('CategoryID', '1'); // Category ID from previous response
    form.append('page', '1');
    form.append('limit', '10');
    if (authToken) form.append('token', authToken);
    return client.post('/Api_v2/foodlist', form);
  });

  // 4. Test Food Details
  await testEndpoint('Get Food Details', async () => {
    const form = new FormData();
    form.append('id', customerId);
    form.append('ProductsID', '1'); // Product ID from previous response
    if (authToken) form.append('token', authToken);
    return client.post('/Api_v2/fooddetails', form);
  });

  // 5. Test Add to Cart
  await testEndpoint('Add to Cart', async () => {
    const form = new FormData();
    form.append('id', customerId);
    form.append('ProductsID', '1');   // Product ID from previous response
    form.append('variantid', '1');    // Variant ID if applicable
    form.append('quantity', '1');
    form.append('size', '');         // Size if applicable
    if (authToken) form.append('token', authToken);
    return client.post('/Api_v2/addtocart', form);
  });

  // 6. Test Cart List
  await testEndpoint('Get Cart List', async () => {
    const form = new FormData();
    form.append('id', customerId);
    if (authToken) form.append('token', authToken);
    return client.post('/Api_v2/cartdata', form);
  });

  // 7. Test Place Order
  await testEndpoint('Place Order', async () => {
    const form = new FormData();
    form.append('id', customerId);
    form.append('grandtotal', '100');
    form.append('payment_method', '1');
    form.append('table_no', '1');
    form.append('customer_note', 'Test order');
    form.append('customerpaid', '100');
    form.append('customer_type', '1');
    if (authToken) form.append('token', authToken);
    return client.post('/Api_v2/placeorder', form);
  });

  // 8. Test Order History
  await testEndpoint('Get Order History', async () => {
    const form = new FormData();
    form.append('id', customerId);
    form.append('limit', '10');
    form.append('page', '1');
    if (authToken) form.append('token', authToken);
    return client.post('/Api_v2/orderlist', form);
  });

  // 9. Test Order Details
  await testEndpoint('Get Order Details', async () => {
    const form = new FormData();
    form.append('id', customerId);
    form.append('order_id', '1'); // Order ID from previous response
    if (authToken) form.append('token', authToken);
    return client.post('/Api_v2/orderdetails', form);
  });
}

// Install dependencies and run tests
console.log('Installing dependencies...');
require('child_process').execSync('npm install axios form-data', { stdio: 'inherit' });

console.log('\nRunning customer app tests...');
runCustomerTests().catch(console.error);