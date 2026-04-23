import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router";

const BASE = import.meta.env.BASE_URL; // set by Vite's `base` config
import { AuthProvider, useAuth } from "./context/AuthContext";
import AppLayout from "./layout/AppLayout";
import { ScrollToTop } from "./components/common/ScrollToTop";

// Auth pages
import SignIn from "./pages/AuthPages/SignIn";

// SaaS pages
import Home from "./pages/Dashboard/Home";
import ClientList from "./pages/Clients/ClientList";
import NewClient from "./pages/Clients/NewClient";
import ClientDetail from "./pages/Clients/ClientDetail";
import PlanList from "./pages/Plans/PlanList";
import LicenseList from "./pages/Licenses/LicenseList";
import PaymentList from "./pages/Payments/PaymentList";
import ActivityList from "./pages/Activity/ActivityList";
import UpdatesList from "./pages/Updates/UpdatesList";
import RevenueReport from "./pages/Reports/RevenueReport";
import SubscriptionsReport from "./pages/Reports/SubscriptionsReport";
import ClientsReport from "./pages/Reports/ClientsReport";
import NotificationsPage from "./pages/Notifications/NotificationsPage";
import InvoiceList from "./pages/Invoices/InvoiceList";
import SettingsPage from "./pages/Settings/SettingsPage";
import TeamPage from "./pages/Team/TeamPage";
import RolesPage from "./pages/Roles/RolesPage";

// Other
import NotFound from "./pages/OtherPage/NotFound";
import UserProfiles from "./pages/UserProfiles";

// Protected route wrapper
function Protected({ children }: { children: React.ReactNode }) {
  const { isAuthenticated, isLoading } = useAuth();
  if (isLoading) {
    return (
      <div className="flex items-center justify-center min-h-screen text-gray-400">
        Chargement...
      </div>
    );
  }
  return isAuthenticated ? <>{children}</> : <Navigate to="/signin" replace />;
}

function AppRoutes() {
  return (
    <Router basename={BASE}>
      <ScrollToTop />
      <Routes>
        {/* Protected dashboard routes */}
        <Route
          element={
            <Protected>
              <AppLayout />
            </Protected>
          }
        >
          <Route index path="/" element={<Home />} />
          <Route path="/clients" element={<ClientList />} />
          <Route path="/clients/new" element={<NewClient />} />
          <Route path="/clients/:id" element={<ClientDetail />} />
          <Route path="/plans" element={<PlanList />} />
          <Route path="/licenses" element={<LicenseList />} />
          <Route path="/payments" element={<PaymentList />} />
          <Route path="/activity" element={<ActivityList />} />
          <Route path="/updates" element={<UpdatesList />} />
          <Route path="/reports/revenue"       element={<RevenueReport />} />
          <Route path="/reports/subscriptions" element={<SubscriptionsReport />} />
          <Route path="/reports/clients"       element={<ClientsReport />} />
          <Route path="/notifications"         element={<NotificationsPage />} />
          <Route path="/invoices"             element={<InvoiceList />} />
          <Route path="/settings" element={<SettingsPage />} />
          <Route path="/team" element={<TeamPage />} />
          <Route path="/roles" element={<RolesPage />} />
          <Route path="/profile" element={<UserProfiles />} />
        </Route>

        {/* Public auth routes */}
        <Route path="/signin" element={<SignIn />} />

        {/* 404 */}
        <Route path="*" element={<NotFound />} />
      </Routes>
    </Router>
  );
}

export default function App() {
  return (
    <AuthProvider>
      <AppRoutes />
    </AuthProvider>
  );
}
