# Todo List

- [x] Create project scaffold
  - Create Expo TypeScript project structure under `mobile/customer` with App.tsx, screens, contexts, services, types, and tsconfig.json.
- [x] Fix package.json
  - Validate and correct `mobile/customer/package.json` JSON so npm can install dependencies.
- [x] Install dependencies
  - Run `npm install` in `mobile/customer` and resolve permission or dependency issues (chown ~/.npm if needed).
- [x] Verify app runs
  - Start Expo (`npx expo start`) and ensure Metro loads; fix any runtime/type errors.
- [x] Wire login->main flow
  - Ensure `AuthContext` stores token and App redirects after login; add simple guard in App.tsx.
- [x] Integration smoke tests
  - Create a small node script to call login and categorylist endpoints to verify API payloads and token usage.
- [x] Wire logged-in user into API calls
  - Expose `user` from `AuthContext` and make `getCategories`/`getFoodList` use the authenticated user's id instead of hard-coded '1'.
- [x] Review mobile directory (customer/kitchen/waiter)
  - Perform a code review across the three mobile apps and report findings, risks and recommended fixes.
- [x] Centralize API_BASE_URL
  - Create `mobile/shared/config.js` and update customer, waiter, and test scripts to use it.
- [x] Log API base at runtime
  - Print resolved API_BASE_URL at app startup (customer App.tsx) to help debug which backend is used.
- [x] Add mobile README
  - Create `mobile/README.md` describing API_BASE_URL usage, Expo extra config, and test commands.
- [x] Log API base in waiter/kitchen apps
  - Add runtime logs in waiter and kitchen entry points to show resolved API_BASE_URL.

All tasks completed as of November 7, 2025.

## Completion Summary

1. Project Structure
   - ✅ Customer app scaffold complete with TypeScript
   - ✅ Dependencies installed and working
   - ✅ App running successfully

2. Authentication & API Integration
   - ✅ Login flow implemented
   - ✅ Auth context working
   - ✅ User ID integrated in API calls

3. Integration Testing
   - ✅ Smoke tests implemented
   - ✅ Auth endpoint testing
   - ✅ Category/food list validation
   - ✅ Test reporting and cleanup

4. Configuration & Documentation
   - ✅ API_BASE_URL centralized
   - ✅ Runtime logging added
   - ✅ Documentation complete
   - ✅ All apps updated with shared config