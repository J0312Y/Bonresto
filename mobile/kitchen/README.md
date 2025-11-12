Kitchen App (Expo + TypeScript)

Quick start

1. Install dependencies

   npm install

2. Start Expo

   npm run start

3. Run on a device or simulator using the Expo dev tools.

Notes
- Update `src/api/client.ts` baseURL to point to your local server (e.g., http://10.0.2.2/bonresto/ or http://localhost/bonresto/ depending on your emulator).
- This scaffold provides Login and Orders screens wired to `V3/sign_in` and `V3/orderlist` routes; you'll need to adapt IPs and endpoints to match your environment.
- The Login screen now requests push notification permissions and registers the device token with your server (`Api/save_fcm_token`).
- Make sure to run `npm install` in `mobile/kitchen` to install `expo-notifications` and `@react-native-async-storage/async-storage` before running the app.
