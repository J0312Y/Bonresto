import { createContext, useContext, useState, useEffect } from 'react';
import { signIn } from '../services/api';
import AsyncStorage from '@react-native-async-storage/async-storage';

interface AuthContextType {
  isAuthenticated: boolean;
  token: string | null;
  user?: any | null;
  isLoading?: boolean;
  login: (email: string, password: string) => Promise<void>;
  logout: () => Promise<void>;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [token, setToken] = useState<string | null>(null);
  const [user, setUser] = useState<any | null>(null);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const bootstrap = async () => {
      try {
        const t = await AsyncStorage.getItem('token');
        if (t) {
          setToken(t);
          setIsAuthenticated(true);
        }
        const u = await AsyncStorage.getItem('user');
        if (u) {
          try {
            setUser(JSON.parse(u));
          } catch (e) {
            console.warn('Invalid user in storage', e);
          }
        }
      } catch (err) {
        console.warn('Failed to read token from storage', err);
      } finally {
        setIsLoading(false);
      }
    };
    bootstrap();
  }, []);

  const login = async (email: string, password: string) => {
    try {
  // Call backend sign_in
  const result = await signIn(email, password, '');

      if (result && result.status === 'success') {
        // result.data contains user object
        const user = result.data;
        const tokenToStore = String(user.id || user.user_id || user.customer_id || '');
        // Persist token and user
        await AsyncStorage.setItem('token', tokenToStore);
        await AsyncStorage.setItem('user', JSON.stringify(user));
        setToken(tokenToStore);
        setUser(user);
        setIsAuthenticated(true);
      } else {
        const msg = result?.message || 'Login failed';
        throw new Error(msg);
      }
    } catch (error) {
      console.error('Login failed:', error);
      throw error;
    }
  };

  const logout = async () => {
    try {
      await AsyncStorage.removeItem('token');
      await AsyncStorage.removeItem('user');
      setToken(null);
      setUser(null);
      setIsAuthenticated(false);
    } catch (error) {
      console.error('Logout failed:', error);
    }
  };

  return (
    <AuthContext.Provider value={{ isAuthenticated, token, user, isLoading, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within AuthProvider');
  }
  return context;
}