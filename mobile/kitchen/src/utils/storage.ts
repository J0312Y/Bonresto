// Lightweight storage shim that uses AsyncStorage when available.
let AsyncStorage: any = null;
try {
  // runtime import; during static analysis this may not exist
  // but at runtime in the Expo app it will
  // eslint-disable-next-line global-require
  AsyncStorage = require('@react-native-async-storage/async-storage').default;
} catch (e) {
  AsyncStorage = null;
}

export const save = async (key: string, value: string) => {
  if (!AsyncStorage) return;
  try {
    await AsyncStorage.setItem(key, value);
  } catch (e) {
    // ignore for scaffold
  }
};

export const load = async (key: string) => {
  if (!AsyncStorage) return null;
  try {
    return await AsyncStorage.getItem(key);
  } catch (e) {
    return null;
  }
};
