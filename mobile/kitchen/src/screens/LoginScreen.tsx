import React, { useState, useEffect } from 'react';
import { View, Text, TextInput, Button, StyleSheet, Alert, Platform } from 'react-native';
import client, { saveFcmToken } from '../api/client';
import * as Device from 'expo-device';
import * as Notifications from 'expo-notifications';
import { save } from '../utils/storage';

export default function LoginScreen({ navigation }: any) {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const onLogin = async () => {
    try {
      // token is push token; load from storage
      const pushToken = (await loadPushToken()) || 'device-push-token-sample';

      const form = new FormData();
      form.append('email', email);
      form.append('password', password);
      form.append('token', pushToken);

      const resp = await client.post('/index.php/V3/sign_in', form, {
        headers: { 'Content-Type': 'multipart/form-data' }
      });

      if (resp.data && resp.data.status === 'success') {
        const user = resp.data.data;
        navigation.replace('Orders', { user });
      } else {
        Alert.alert('Login failed', resp.data?.message || 'Unknown error');
      }
    } catch (err: any) {
      Alert.alert('Network error', err.message);
    }
  };

  // Push token registration
  const registerForPushNotificationsAsync = async () => {
    let token;
    if (Device.isDevice) {
      const { status: existingStatus } = await Notifications.getPermissionsAsync();
      let finalStatus = existingStatus;
      if (existingStatus !== 'granted') {
        const { status } = await Notifications.requestPermissionsAsync();
        finalStatus = status;
      }
      if (finalStatus !== 'granted') {
        Alert.alert('Failed to get push token for push notification!');
        return null;
      }
      token = (await Notifications.getExpoPushTokenAsync()).data;
      await save('pushToken', token);
      // forward token to server
      saveFcmToken(token);
    } else {
      Alert.alert('Must use physical device for Push Notifications');
    }

    if (Platform.OS === 'android') {
      Notifications.setNotificationChannelAsync('default', {
        name: 'default',
        importance: Notifications.AndroidImportance.MAX,
        vibrationPattern: [0, 250, 250, 250],
        lightColor: '#FF231F7C',
      });
    }
    return token;
  };

  const loadPushToken = async () => {
    try {
      const t = await import('../utils/storage').then(m => m.load('pushToken'));
      return t;
    } catch (e) {
      return null;
    }
  };

  useEffect(() => {
    registerForPushNotificationsAsync();
  }, []);

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Kitchen Login</Text>
      <TextInput style={styles.input} placeholder="Email" value={email} onChangeText={setEmail} autoCapitalize="none" />
      <TextInput style={styles.input} placeholder="Password" value={password} onChangeText={setPassword} secureTextEntry />
      <Button title="Sign in" onPress={onLogin} />
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, justifyContent: 'center', padding: 16 },
  title: { fontSize: 20, marginBottom: 12, textAlign: 'center' },
  input: { borderWidth: 1, borderColor: '#ccc', padding: 8, marginBottom: 12, borderRadius: 4 }
});
