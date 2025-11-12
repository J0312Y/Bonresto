// Centralized API base URL for mobile apps and test scripts.
// Resolution order:
// 1. Expo Constants manifest.extra.API_BASE_URL (when running inside Expo)
// 2. process.env.API_BASE_URL (when running node scripts or Metro with env)
// 3. fallback default (localhost)
let API_BASE_URL = process.env.API_BASE_URL || 'http://localhost/Bonresto/index.php';

try {
  // When running inside Expo, prefer the value from Constants.manifest.extra
  const Constants = require('expo-constants');
  // Newer SDKs expose extras under expoConfig.extra
  const extras = (Constants && (Constants.manifest && Constants.manifest.extra)) || (Constants && Constants.expoConfig && Constants.expoConfig.extra);
  if (extras && extras.API_BASE_URL) {
    API_BASE_URL = extras.API_BASE_URL;
  }
} catch (e) {
  // Not running inside Expo or expo-constants not available — ignore
}

module.exports = {
  API_BASE_URL,
};
