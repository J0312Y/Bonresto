const fetch = require('node-fetch');

async function test() {
  try {
    const base = 'http://localhost/bonresto/index.php'; // adjust to your dev URL

    // example sign_in
    const form = new URLSearchParams();
    form.append('email', 'joeldytsina94@gmail.com');
    form.append('password', 'password');
    form.append('token', 'sample-token');

    const sign = await fetch(base + '/V3/sign_in', { method: 'POST', body: form });
    const signJson = await sign.json();
    console.log('sign_in ->', signJson);

    if (signJson.status === 'success') {
      const user = signJson.data;
      const orderForm = new URLSearchParams();
      orderForm.append('id', user.id);
      orderForm.append('kitchenid', (user.kitchenid || '').replace(/'/g, '').split(',')[0] || '');

      const orders = await fetch(base + '/V3/orderlist', { method: 'POST', body: orderForm });
      console.log('orderlist ->', await orders.json());
    }
  } catch (err) {
    console.error(err);
  }
}

test();
