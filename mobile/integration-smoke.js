const axios = require('axios');
const FormData = require('form-data');
const { API_BASE_URL } = require('./shared/config');

// Read credentials from env, with sensible defaults used for local testing.
const CREDENTIALS = {
  customer: {
    email: process.env.SMOKE_CUSTOMER_EMAIL || 'counter@example.com	',
    password: process.env.SMOKE_CUSTOMER_PASSWORD || '1234',
    token: process.env.SMOKE_CUSTOMER_TOKEN || 'smoke-customer-token-' + Date.now()
  }
};

const client = axios.create({
  baseURL: API_BASE_URL,
  timeout: 15000,
});

// Test Data Management & Reporting
let testDataToCleanup = {
  users: [],
  orders: [],
  carts: []
};

const testReport = {
  startTime: null,
  endTime: null,
  tests: [],
  summary: {
    total: 0,
    passed: 0,
    failed: 0,
    skipped: 0
  }
};

function recordTestResult(name, category, result, error = null) {
  testReport.tests.push({
    name,
    category,
    status: result ? 'passed' : 'failed',
    error: error ? error.message : null,
    timestamp: new Date().toISOString()
  });
  
  testReport.summary.total++;
  if (result) {
    testReport.summary.passed++;
  } else {
    testReport.summary.failed++;
    console.error(`❌ ${category} - ${name} failed:`, error ? error.message : 'Unknown error');
  }
}

function recordTestData(category, id) {
  if (Array.isArray(testDataToCleanup[category])) {
    testDataToCleanup[category].push(id);
  }
}

async function cleanupTestData() {
  console.log('\n=== Cleaning Up Test Data ===');
  
  // Note: We're logging cleanup attempts but not failing the test if cleanup fails
  for (const category of Object.keys(testDataToCleanup)) {
    const ids = testDataToCleanup[category];
    if (ids.length === 0) continue;
    
    console.log(`Cleaning up ${ids.length} ${category}...`);
    for (const id of ids) {
      try {
        const form = new FormData();
        form.append('id', id);
        await client.post(`/Appv1/delete_${category}`, form, { headers: form.getHeaders() });
      } catch (err) {
        console.warn(`Failed to cleanup ${category} ${id}:`, err.message);
      }
    }
  }
  
  // Reset cleanup tracking
  testDataToCleanup = {
    users: [],
    orders: [],
    carts: []
  };
}

// Validation Helpers
function assert(condition, message) {
  if (!condition) {
    console.error('ASSERTION FAILED:', message);
    throw new Error(message);
  }
}

function validateResponse(response, schema) {
  if (!response) {
    throw new Error('Response is null or undefined');
  }

  for (const [key, validator] of Object.entries(schema)) {
    const value = response[key];
    if (!validator(value)) {
      throw new Error(`Invalid ${key}: ${value}`);
    }
  }
}

const responseValidators = {
  user: (data) => {
    validateResponse(data, {
      id: (v) => typeof v === 'string' || typeof v === 'number',
      email: (v) => typeof v === 'string' && v.includes('@'),
      status: (v) => v === 'success' || v === 'failed'
    });
  },
  settings: (data) => {
    validateResponse(data, {
      currency: (v) => typeof v === 'string',
      servicecharge: (v) => typeof v === 'string' || typeof v === 'number',
      vat: (v) => typeof v === 'string' || typeof v === 'number'
    });
  },
  payment: (data) => {
    validateResponse(data, {
      id: (v) => typeof v === 'string' || typeof v === 'number',
      payment_method: (v) => typeof v === 'string'
    });
  },
  category: (data) => {
    validateResponse(data, {
      CategoryID: (v) => typeof v === 'string' || typeof v === 'number',
      Name: (v) => typeof v === 'string' && v.length > 0
    });
  },
  food: (data) => {
    validateResponse(data, {
      ProductsID: (v) => typeof v === 'string' || typeof v === 'number',
      ProductName: (v) => typeof v === 'string' && v.length > 0,
      price: (v) => typeof v === 'string' || typeof v === 'number'
    });
  },
  order: (data) => {
    validateResponse(data, {
      order_id: (v) => typeof v === 'string' || typeof v === 'number',
      status: (v) => typeof v === 'string'
    });
  }
};

async function generateTestEmail() {
  return `test-${Date.now()}@example.com`;
}

async function doRegister(email, password, fullname) {
  const form = new FormData();
  form.append('customer_name', fullname);
  form.append('email', email);
  form.append('password', password);
  form.append('token', 'test-token-' + Date.now());
  
  try {
    const res = await client.post('/Appv1/sign_up', form, { headers: form.getHeaders() });
    console.log(`[register] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[register] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function doLogin(role) {
  const creds = CREDENTIALS[role];
  const form = new FormData();
  form.append('email', creds.email);
  form.append('password', creds.password);
  form.append('token', creds.token);

  const headers = form.getHeaders();
  try {
    const res = await client.post('/V3/sign_in', form, { headers });
    console.log(`[${role}] sign_in -> status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error(`[${role}] sign_in ERROR:`, err.response ? err.response.data : err.message);
    return null;
  }
}

async function getCategories(userId) {
  const form = new FormData();
  form.append('id', userId || '1');
  form.append('Name', '');
  try {
    const res = await client.post('/Appv1/categorylist', form, { headers: form.getHeaders() });
    console.log(`[categories] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[categories] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getFoodList(userId, categoryId) {
  const form = new FormData();
  form.append('id', userId || '1');
  form.append('CategoryID', categoryId || '1');
  form.append('page', '1');
  form.append('limit', '10');
  try {
    const res = await client.post('/Appv1/foodlist', form, { headers: form.getHeaders() });
    console.log(`[foodlist] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[foodlist] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getAllFoodList(userId) {
  const form = new FormData();
  form.append('id', userId || '1');
  form.append('Name', '');
  try {
    const res = await client.post('/Appv1/allfoodlist', form, { headers: form.getHeaders() });
    console.log(`[allfoodlist] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[allfoodlist] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function searchFoodByCategory(userId, categoryId, searchTerm) {
  const form = new FormData();
  form.append('id', userId || '2');
  form.append('CategoryID', categoryId || '5');
  form.append('foodname', searchTerm || 'pizza');
  try {
    const res = await client.post('/Appv1/foodsearchbycategory', form, { headers: form.getHeaders() });
    console.log(`[foodsearch] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[foodsearch] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getTableList() {
  const form = new FormData();
  try {
    const res = await client.post('/Appv1/tablelist', form, { headers: form.getHeaders() });
    console.log(`[tablelist] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[tablelist] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getWaiterList() {
  const form = new FormData();
  try {
    const res = await client.post('/Appv1/waiterwithshift', form, { headers: form.getHeaders() });
    console.log(`[waiterlist] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[waiterlist] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getCustomerList() {
  const form = new FormData();
  try {
    const res = await client.post('/Appv1/customerlist', form, { headers: form.getHeaders() });
    console.log(`[customerlist] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[customerlist] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

// Table Reservation Functions
async function checkTableAvailability(tableId) {
  const form = new FormData();
  form.append('tableid', tableId);
  try {
    const res = await client.post('/Appv1/checktable', form, { headers: form.getHeaders() });
    console.log(`[checkTable] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[checkTable] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getCustomerTypes() {
  const form = new FormData();
  try {
    const res = await client.post('/Appv1/customertype', form, { headers: form.getHeaders() });
    console.log(`[customerTypes] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[customerTypes] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

// Payment & Settings Functions
async function getRestaurantSettings() {
  const form = new FormData();
  try {
    const res = await client.post('/Appv1/settings', form, { headers: form.getHeaders() });
    console.log(`[settings] status=${res.data.status}`);
    return res.data;
  } catch (err) {
    console.error('[settings] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getPaymentMethods() {
  const form = new FormData();
  try {
    const res = await client.post('/Appv1/paymentmethods', form, { headers: form.getHeaders() });
    console.log(`[paymentMethods] status=${res.data.status}`);
    return res.data;
  } catch (err) {
    console.error('[paymentMethods] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function updateUserProfile(userId, updates) {
  const form = new FormData();
  form.append('id', userId);
  Object.entries(updates).forEach(([key, value]) => {
    form.append(key, value);
  });
  try {
    const res = await client.post('/Appv1/updateprofile', form, { headers: form.getHeaders() });
    console.log(`[updateProfile] status=${res.data.status}`);
    return res.data;
  } catch (err) {
    console.error('[updateProfile] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getThirdPartySettings() {
  const form = new FormData();
  try {
    const res = await client.post('/Appv1/thirdparty', form, { headers: form.getHeaders() });
    console.log(`[thirdParty] status=${res.data.status}`);
    return res.data;
  } catch (err) {
    console.error('[thirdParty] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

// Order Management Functions
async function addToCart(userId, foodId, variantId = '', addons = []) {
  const form = new FormData();
  form.append('id', userId);
  form.append('foodid', foodId);
  form.append('varientid', variantId);
  form.append('addons', JSON.stringify(addons));
  try {
    const res = await client.post('/Appv1/foodcart', form, { headers: form.getHeaders() });
    console.log(`[addToCart] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[addToCart] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getKitchenOrderList() {
  const form = new FormData();
  try {
    const res = await client.get('/V3/kitchenlist', { headers: form.getHeaders() });
    console.log(`[kitchenOrderList] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[kitchenOrderList] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getAllOrders() {
  const form = new FormData();
  try {
    const res = await client.get('/V3/orderlist', { headers: form.getHeaders() });
    console.log(`[orderList] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[orderList] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function markOrderReady(orderId) {
  const form = new FormData();
  form.append('orderid', orderId);
  try {
    const res = await client.post('/V3/markasready', form, { headers: form.getHeaders() });
    console.log(`[markOrderReady] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[markOrderReady] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function getOnlineOrders() {
  const form = new FormData();
  try {
    const res = await client.get('/V3/allonlineorder', { headers: form.getHeaders() });
    console.log(`[onlineOrders] status=${res.data.status} message=${res.data.message}`);
    return res.data;
  } catch (err) {
    console.error('[onlineOrders] ERROR:', err.response ? err.response.data : err.message);
    return null;
  }
}

async function run() {
  let hasErrors = false;
  testReport.startTime = new Date().toISOString();
  
  try {
    console.log('Integration smoke test starting against', API_BASE_URL);

    // Test user registration and auth
    console.log('\n=== Testing User Registration & Auth ===');
    try {
      const testEmail = await generateTestEmail();
      const registrationResult = await doRegister(
        testEmail,
        'Test123!@#',
        'Test Customer'
      );
      
      assert(registrationResult, 'Registration should return a response');
      if (registrationResult.status === 'success') {
        recordTestData('users', registrationResult.data.id);
        recordTestResult('User Registration', 'auth', true);
        
        const testLogin = await doLogin({
          email: testEmail,
          password: 'Test123!@#',
          token: 'test-token-' + Date.now()
        });
        
        assert(testLogin && testLogin.status === 'success', 'Should be able to login with new account');
        responseValidators.user(testLogin.data);
        recordTestResult('New User Login', 'auth', true);
      }
    } catch (error) {
      recordTestResult('User Registration Flow', 'auth', false, error);
      hasErrors = true;
    }

    // Test existing account auth
    try {
      console.log('\n=== Testing Existing User Auth ===');
      const customer = await doLogin('customer');
      assert(customer, 'Customer login should return a response');
      recordTestResult('Customer Login', 'auth', true);

      const waiter = await doLogin('waiter');
      assert(waiter, 'Waiter login should return a response');
      recordTestResult('Waiter Login', 'auth', true);

      const kitchen = await doLogin('kitchen');
      assert(kitchen, 'Kitchen login should return a response');
      recordTestResult('Kitchen Login', 'auth', true);
    } catch (error) {
      recordTestResult('Existing User Auth', 'auth', false, error);
      hasErrors = true;
    }

    // Test menu and categories
    try {
      console.log('\n=== Testing Menu System ===');
      const cats = await getCategories('1');
      assert(cats && cats.data, 'Should get category list');
      recordTestResult('Category List', 'menu', true);

      if (cats.data && cats.data.length > 0) {
        const catId = cats.data[0].CategoryID;
        const foods = await getFoodList('1', catId);
        assert(foods && foods.data, 'Should get food list');
        recordTestResult('Food List', 'menu', true);

        const searchResult = await searchFoodByCategory('1', catId, 'chicken');
        assert(searchResult, 'Should get search results');
        recordTestResult('Food Search', 'menu', true);
      }
    } catch (error) {
      recordTestResult('Menu System', 'menu', false, error);
      hasErrors = true;
    }

    // Test table system
    try {
      console.log('\n=== Testing Table System ===');
      const tables = await getTableList();
      assert(tables && tables.data, 'Should get table list');
      recordTestResult('Table List', 'tables', true);

      if (tables.data && tables.data.length > 0) {
        const firstTable = tables.data[0];
        const tableCheck = await checkTableAvailability(firstTable.tableid || firstTable.id);
        assert(tableCheck, 'Should check table availability');
        recordTestResult('Table Availability', 'tables', true);
      }

      const customerTypes = await getCustomerTypes();
      assert(customerTypes, 'Should get customer types');
      recordTestResult('Customer Types', 'tables', true);
    } catch (error) {
      recordTestResult('Table System', 'tables', false, error);
      hasErrors = true;
    }

    // Test kitchen order system
    try {
      console.log('\n=== Testing Kitchen System ===');
      const kitchenOrders = await getKitchenOrderList();
      assert(kitchenOrders, 'Should get kitchen orders');
      recordTestResult('Kitchen Orders', 'kitchen', true);

      const allOrders = await getAllOrders();
      assert(allOrders, 'Should get all orders');
      recordTestResult('All Orders', 'kitchen', true);

      const onlineOrders = await getOnlineOrders();
      assert(onlineOrders, 'Should get online orders');
      recordTestResult('Online Orders', 'kitchen', true);
    } catch (error) {
      recordTestResult('Kitchen System', 'kitchen', false, error);
      hasErrors = true;
    }

    // Test settings and configuration
    try {
      console.log('\n=== Testing Settings & Configuration ===');
      const settings = await getRestaurantSettings();
      assert(settings, 'Should get restaurant settings');
      responseValidators.settings(settings.data);
      recordTestResult('Restaurant Settings', 'settings', true);

      const paymentMethods = await getPaymentMethods();
      assert(paymentMethods, 'Should get payment methods');
      if (paymentMethods.data && Array.isArray(paymentMethods.data)) {
        paymentMethods.data.forEach(pm => responseValidators.payment(pm));
      }
      recordTestResult('Payment Methods', 'settings', true);

      const thirdParty = await getThirdPartySettings();
      assert(thirdParty, 'Should get third party settings');
      recordTestResult('Third Party Settings', 'settings', true);
    } catch (error) {
      recordTestResult('Settings System', 'settings', false, error);
      hasErrors = true;
    }

    // Test profile management
    if (customer && customer.data && customer.data.id) {
      try {
        console.log('\n=== Testing Profile Management ===');
        const profileUpdate = await updateUserProfile(customer.data.id, {
          customer_name: 'Updated Test User',
          phone: '1234567890'
        });
        assert(profileUpdate, 'Should update user profile');
        recordTestResult('Profile Update', 'profile', true);
      } catch (error) {
        recordTestResult('Profile Management', 'profile', false, error);
        hasErrors = true;
      }
    }

  // Customer flow
  console.log('\n=== Testing Customer Flow ===');
  const customer = await doLogin('customer');
  const customerId = customer && customer.status === 'success' && customer.data ? (customer.data.id || customer.data.user_id || customer.data.customer_id) : null;
  if (customerId) {
    // Food browsing flow
    const cats = await getCategories(String(customerId));
    const catId = (cats && cats.data && cats.data[0] && cats.data[0].CategoryID) ? String(cats.data[0].CategoryID) : '1';
    await getFoodList(String(customerId), catId);
    await getAllFoodList(String(customerId));
    await searchFoodByCategory(String(customerId), catId, 'chicken');
    
    // Table availability
    await getTableList();
  }

  // Waiter flow
  console.log('\n=== Testing Waiter Flow ===');
  const waiter = await doLogin('waiter');
  if (waiter && waiter.status === 'success') {
    await getTableList();
    await getCustomerList();
    await getWaiterList();
  }

  // Kitchen flow
  console.log('\n=== Testing Kitchen Flow ===');
  const kitchen = await doLogin('kitchen');
  if (kitchen && kitchen.status === 'success') {
    // Test kitchen order management
    const orderList = await getKitchenOrderList();
    const allOrders = await getAllOrders();
    
    // If there are any orders, test marking as ready
    if (allOrders && allOrders.data && allOrders.data.length > 0) {
      const firstOrder = allOrders.data[0];
      await markOrderReady(firstOrder.order_id || firstOrder.id);
    }
    
    // Test online order monitoring
    await getOnlineOrders();
  }

  // Test table management
  console.log('\n=== Testing Table Management ===');
  const tables = await getTableList();
  if (tables && tables.data && tables.data.length > 0) {
    const firstTable = tables.data[0];
    await checkTableAvailability(firstTable.tableid || firstTable.id);
  }
  // Get customer types for table assignment
  await getCustomerTypes();
  
  // Test customer ordering (if we have valid customer session)
  if (customerId && cats && cats.data && cats.data[0]) {
    const firstCategory = cats.data[0];
    const foods = await getFoodList(String(customerId), firstCategory.CategoryID);
    
    if (foods && foods.data && foods.data.length > 0) {
      const firstFood = foods.data[0];
      // Attempt to add first food item to cart
      await addToCart(
        String(customerId),
        firstFood.ProductsID || firstFood.id,
        firstFood.variantid // Optional variant ID if exists
      );
    }
  }

  } catch (error) {
    console.error('Test failed:', error.message);
    hasErrors = true;
  } finally {
    testReport.endTime = new Date().toISOString();
    
    // Always attempt to cleanup test data
    try {
      await cleanupTestData();
    } catch (cleanupError) {
      console.error('Cleanup failed:', cleanupError.message);
    }
    
    // Generate and save test report
    const reportPath = './test-report.json';
    try {
      const fs = require('fs');
      fs.writeFileSync(reportPath, JSON.stringify(testReport, null, 2));
      console.log(`\nTest report saved to ${reportPath}`);
    } catch (reportError) {
      console.error('Failed to save test report:', reportError.message);
    }
    
    // Print test summary
    console.log('\n=== Integration Test Summary ===');
    console.log(`Total Tests: ${testReport.summary.total}`);
    console.log(`✅ Passed: ${testReport.summary.passed}`);
    console.log(`❌ Failed: ${testReport.summary.failed}`);
    console.log(`⏭️  Skipped: ${testReport.summary.skipped}`);
    console.log('Status:', hasErrors ? 'FAILED' : 'PASSED');
    console.log(`Duration: ${(new Date(testReport.endTime) - new Date(testReport.startTime))}ms`);
    console.log('\nIntegration smoke test finished.');
    
    // Exit with appropriate code
    process.exit(hasErrors ? 1 : 0);
  }
}

// Run the tests
run().catch((e) => {
  console.error('Unexpected error:', e);
  process.exit(2);
});
