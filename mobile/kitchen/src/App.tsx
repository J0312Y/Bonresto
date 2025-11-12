import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
// Log resolved API base URL at startup to help debugging which backend the app will call
const { API_BASE_URL } = require('../../shared/config');
console.log('Resolved API_BASE_URL for kitchen app:', API_BASE_URL);
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import LoginScreen from './screens/LoginScreen';
import OrdersScreen from './screens/OrdersScreen';

const Stack = createNativeStackNavigator();

export default function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Login">
        <Stack.Screen name="Login" component={LoginScreen} />
        <Stack.Screen name="Orders" component={OrdersScreen} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}
