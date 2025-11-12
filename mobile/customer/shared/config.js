
// mobile/customer/shared/config.ts
const axios = require('axios');
const { API_BASE_URL } = require('../../shared/config');
const BASE = process.env.API_BASE_URL || API_BASE_URL;
if (Constants.manifest && Constants.manifest.extra && Constants.manifest.extra.API_BASE_URL) {
  API_BASE_URL = Constants.manifest.extra.API_BASE_URL;
}

module.exports = {
  API_BASE_URL,
};



