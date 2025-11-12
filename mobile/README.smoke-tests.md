# Integration Smoke Tests

This directory contains integration smoke tests for verifying the core functionality of the Bonresto mobile applications.

## Running Tests

```bash
# Run with default test credentials
node integration-smoke.js

# Run with custom credentials
SMOKE_CUSTOMER_EMAIL=customer@example.com \
SMOKE_CUSTOMER_PASSWORD=password123 \
SMOKE_WAITER_EMAIL=waiter@example.com \
SMOKE_WAITER_PASSWORD=password123 \
SMOKE_KITCHEN_EMAIL=kitchen@example.com \
SMOKE_KITCHEN_PASSWORD=password123 \
node integration-smoke.js
```

## Test Coverage

The smoke tests verify the following functionality:

1. Authentication
   - User registration
   - Customer login
   - Waiter login
   - Kitchen login

2. Menu System
   - Category listing
   - Food listing
   - Food search
   - Full menu retrieval

3. Table Management
   - Table listing
   - Table availability checking
   - Customer type management

4. Kitchen System
   - Order listing
   - Order status updates
   - Online order monitoring

5. Settings & Configuration
   - Restaurant settings validation
   - Payment methods verification
   - Third-party integrations check
   - Service charge and VAT validation

6. Profile Management
   - User profile updates
   - Profile data validation

7. Data Cleanup
   - Automatic test data removal
   - Clean slate for next run

## Test Report

After each run, a `test-report.json` file is generated with detailed test results including:
- Test counts (total/passed/failed/skipped)
- Individual test results with timestamps
- Error messages for failed tests
- Test duration

## Exit Codes

- 0: All tests passed
- 1: One or more tests failed
- 2: Unexpected error occurred

## Environment Variables

| Variable | Description | Default |
|----------|-------------|---------|
| SMOKE_CUSTOMER_EMAIL | Test customer email | customer@example.com |
| SMOKE_CUSTOMER_PASSWORD | Test customer password | 123456 |
| SMOKE_WAITER_EMAIL | Test waiter email | manik@gmail.com |
| SMOKE_WAITER_PASSWORD | Test waiter password | 123456 |
| SMOKE_KITCHEN_EMAIL | Test kitchen email | hmisahaq@gmail.com |
| SMOKE_KITCHEN_PASSWORD | Test kitchen password | 123456 |

## Adding New Tests

To add new tests:

1. Add endpoint function in appropriate section
2. Add validation schema if needed
3. Add test case in run() function
4. Update README coverage section