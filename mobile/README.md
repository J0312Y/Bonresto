Mobile workspace README

This folder contains three lightweight mobile apps used to interact with the CodeIgniter backend:

- mobile/customer — Expo + TypeScript customer app (development skeleton)
- mobile/kitchen — Kitchen app (React Native)
- mobile/waiter  — Waiter app (React Native)

Centralized configuration

A single, centralized API base URL is available at `mobile/shared/config.js`.
The resolution order is:
1. Expo Constants: `expo.manifest.extra.API_BASE_URL` (when running inside Expo)
2. Environment variable: `API_BASE_URL` (when running node scripts or Metro with env)
3. Fallback default: `http://127.0.0.1/bonresto/index.php`

Setting the API URL for device testing

If you want to test on a physical device, point the API to your machine's LAN IP (replace `192.168.0.42` below):

1) Using `app.json` for the Expo app (mobile/customer):

```json
{
  "expo": {
    "name": "customer",
    "slug": "customer",
    "sdkVersion": "49.0.0",
    "extra": {
      "API_BASE_URL": "http://192.168.0.42/bonresto/index.php"
    }
  }
}
```

2) Or set the environment variable when running node scripts or Metro:

```bash
# zsh example
export API_BASE_URL='http://192.168.0.42/bonresto/index.php'
# Run smoke test
node mobile/customer/test/smoke-login.js
# Or start Expo
cd mobile/customer
npx expo start
```

Notes about Expo Constants

- `mobile/shared/config.js` will read `expo-constants` (manifest.extra) when available. That means the URL you put into `app.json` or `app.config.js` will be picked up automatically when the app runs under Expo.
- If you change `app.json`, restart Metro and clear cache: `npx expo start -c`.

Developer tips

- The test scripts in `mobile/` (e.g., `test-endpoints.js`, `test-customer-endpoints.js`, `mobile/customer/test/smoke-login.js`) now import `mobile/shared/config.js`. You can override the URL with `API_BASE_URL` env var as shown above.
- The customer app prints the resolved API base URL at startup (check Metro or device logs) so you can confirm which backend it's using.

Next recommended steps

- Keep the backend reachable from devices by using your machine IP and ensuring firewall/hosts allow access.
- Consider adding per-environment app configs or using `.env` + build-time injection for production/staging separation.
- If you want, I can add an automated script to validate endpoint responses with environment-aware configuration.

If you want any of those next steps implemented, tell me which one and I'll add it.
