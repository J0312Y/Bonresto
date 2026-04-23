import {
  createContext,
  useContext,
  useState,
  useEffect,
  type ReactNode,
} from "react";
import { login as apiLogin } from "../services/api";

interface Admin {
  name: string;
  email: string;
  role?: string;
}

interface AuthContextType {
  admin: Admin | null;
  isLoading: boolean;
  login: (email: string, password: string) => Promise<void>;
  logout: () => void;
  isAuthenticated: boolean;
  updateAdmin: (patch: Partial<Admin>) => void;
}

const AuthContext = createContext<AuthContextType | null>(null);

export function AuthProvider({ children }: { children: ReactNode }) {
  const [admin, setAdmin] = useState<Admin | null>(null);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem("saas_token");
    const stored = localStorage.getItem("saas_admin");
    if (token && stored) {
      try {
        const parsed = JSON.parse(stored);
        setAdmin(parsed);
        // If role is missing (old session), fetch it fresh from /auth/me
        if (!parsed.role) {
          fetch(
            (import.meta.env.VITE_API_URL || "http://localhost/bonresto/index.php/saas") + "/auth/me",
            { headers: { Authorization: `Bearer ${token}` } }
          )
            .then((r) => r.ok ? r.json() : null)
            .then((data) => {
              if (data?.admin) {
                const refreshed = { ...parsed, ...data.admin };
                localStorage.setItem("saas_admin", JSON.stringify(refreshed));
                setAdmin(refreshed);
              }
            })
            .catch(() => {});
        }
      } catch {
        localStorage.removeItem("saas_admin");
      }
    }
    setIsLoading(false);
  }, []);

  async function login(email: string, password: string) {
    const res = await apiLogin(email, password);
    localStorage.setItem("saas_token", res.token);
    localStorage.setItem("saas_admin", JSON.stringify(res.admin));
    setAdmin(res.admin);
  }

  function logout() {
    localStorage.removeItem("saas_token");
    localStorage.removeItem("saas_admin");
    setAdmin(null);
  }

  function updateAdmin(patch: Partial<Admin>) {
    setAdmin((prev) => {
      if (!prev) return prev;
      const updated = { ...prev, ...patch };
      localStorage.setItem("saas_admin", JSON.stringify(updated));
      return updated;
    });
  }

  return (
    <AuthContext.Provider
      value={{ admin, isLoading, login, logout, isAuthenticated: !!admin, updateAdmin }}
    >
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const ctx = useContext(AuthContext);
  if (!ctx) throw new Error("useAuth must be used inside AuthProvider");
  return ctx;
}
