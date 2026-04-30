import type {
  ActivityLog,
  Client,
  ClientRevenueMonth,
  ClientStats,
  DashboardStats,
  Invoice,
  LicenseKey,
  LiveStats,
  Payment,
  Plan,
  RecentOrder,
  SaasNotification,
  SaasUpdate,
} from "../types/saas";

const BASE_URL =
  import.meta.env.VITE_API_URL || "https://bonresto.lamuka-tech.com/index.php/saas";

// ── Auth token ────────────────────────────────────────────────────────────────

function getToken(): string | null {
  return localStorage.getItem("saas_token");
}

async function request<T>(
  path: string,
  options: RequestInit = {}
): Promise<T> {
  const token = getToken();
  const res = await fetch(`${BASE_URL}${path}`, {
    ...options,
    headers: {
      "Content-Type": "application/json",
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
      ...(options.headers || {}),
    },
  });

  if (res.status === 401) {
    localStorage.removeItem("saas_token");
    localStorage.removeItem("saas_admin");
    window.location.href = import.meta.env.BASE_URL + "signin";
  }

  const data = await res.json();
  if (!res.ok) throw new Error(data.error || "Request failed");
  return data as T;
}

// ── Auth ──────────────────────────────────────────────────────────────────────

export async function login(
  email: string,
  password: string
): Promise<{ token: string; admin: { name: string; email: string } }> {
  return request("/auth/login", {
    method: "POST",
    body: JSON.stringify({ email, password }),
  });
}

// ── Dashboard ─────────────────────────────────────────────────────────────────

export async function getDashboardStats(): Promise<DashboardStats> {
  return request("/dashboard/stats");
}

// ── Clients ───────────────────────────────────────────────────────────────────

export async function getClients(): Promise<Client[]> {
  return request("/clients");
}

export async function getClient(id: number): Promise<Client> {
  return request(`/clients/${id}`);
}

export async function createClient(
  data: Omit<Client, "client_id" | "created_at">
): Promise<Client> {
  return request("/clients", { method: "POST", body: JSON.stringify(data) });
}

export async function updateClient(
  id: number,
  data: Partial<Client>
): Promise<Client> {
  return request(`/clients/${id}`, { method: "PUT", body: JSON.stringify(data) });
}

export async function updateClientSubscription(
  clientId: number,
  planId: number,
  endDate: string
): Promise<void> {
  return request(`/clients/${clientId}/subscription`, {
    method: "PUT",
    body: JSON.stringify({ plan_id: planId, end_date: endDate }),
  });
}

export async function suspendClient(clientId: number): Promise<void> {
  return request(`/clients/${clientId}/suspend`, { method: "POST" });
}

export async function uploadClientLogo(
  clientId: number,
  file: File
): Promise<{ logo_url: string }> {
  const token = localStorage.getItem("saas_token");
  const form = new FormData();
  form.append("logo", file);
  const res = await fetch(
    `${(import.meta.env.VITE_API_URL || "https://bonresto.lamuka-tech.com/index.php/saas")}/clients/${clientId}/logo`,
    {
      method: "POST",
      headers: token ? { Authorization: `Bearer ${token}` } : {},
      body: form,
    }
  );
  const text = await res.text();
  let data: Record<string, unknown>;
  try { data = JSON.parse(text); } catch { throw new Error("Réponse invalide du serveur: " + text.slice(0, 200)); }
  if (!res.ok) throw new Error((data.error as string) || "Upload échoué");
  return data as { logo_url: string };
}

export async function deleteClientLogo(clientId: number): Promise<void> {
  return request(`/clients/${clientId}/logo`, { method: "DELETE" });
}

// ── Plans ─────────────────────────────────────────────────────────────────────

export async function getPlans(): Promise<Plan[]> {
  return request("/plans");
}

export async function createPlan(
  data: Omit<Plan, "plan_id">
): Promise<Plan> {
  return request("/plans", { method: "POST", body: JSON.stringify(data) });
}

export async function updatePlan(
  id: number,
  data: Partial<Plan>
): Promise<Plan> {
  return request(`/plans/${id}`, {
    method: "PUT",
    body: JSON.stringify(data),
  });
}

export async function deletePlan(id: number): Promise<void> {
  return request(`/plans/${id}`, { method: "DELETE" });
}

// ── Licenses ──────────────────────────────────────────────────────────────────

export async function getLicenses(): Promise<LicenseKey[]> {
  return request("/licenses");
}

export async function generateLicense(clientId: number): Promise<LicenseKey> {
  return request("/licenses/generate", {
    method: "POST",
    body: JSON.stringify({ client_id: clientId }),
  });
}

export async function revokeLicense(keyId: number): Promise<void> {
  return request(`/licenses/${keyId}/revoke`, { method: "POST" });
}

// ── Payments ──────────────────────────────────────────────────────────────────

export async function getPayments(): Promise<Payment[]> {
  return request("/payments");
}

export async function recordPayment(data: {
  tenant_id: number;
  plan_id?: number;
  amount: number;
  currency?: string;
  status?: string;
  reference?: string;
}): Promise<{ payment_id: number }> {
  return request("/payments", { method: "POST", body: JSON.stringify(data) });
}

// ── Dashboard extended ────────────────────────────────────────────────────────

export async function getRecentOrders(): Promise<RecentOrder[]> {
  return request("/dashboard/recent-orders");
}

export async function getClientsStats(): Promise<ClientStats[]> {
  return request("/dashboard/clients-stats");
}

export async function getClientsRevenue(): Promise<ClientRevenueMonth[]> {
  return request("/dashboard/clients-revenue");
}

// ── Updates ───────────────────────────────────────────────────────────────────

export async function getUpdates(): Promise<SaasUpdate[]> {
  return request("/updates");
}

export async function createUpdate(data: Partial<SaasUpdate>): Promise<SaasUpdate> {
  return request("/updates", { method: "POST", body: JSON.stringify(data) });
}

export async function publishUpdate(id: number): Promise<void> {
  return request(`/updates/${id}/publish`, { method: "POST" });
}

export async function archiveUpdate(id: number): Promise<void> {
  return request(`/updates/${id}/archive`, { method: "POST" });
}

// ── Invoices ──────────────────────────────────────────────────────────────────

export async function getInvoices(tenantId?: number): Promise<Invoice[]> {
  const qs = tenantId ? `?tenant_id=${tenantId}` : "";
  return request(`/invoices${qs}`);
}

export async function createInvoice(data: {
  tenant_id: number;
  plan_id?: number | null;
  amount: number;
  currency?: string;
  period_start?: string;
  period_end?: string;
  notes?: string;
}): Promise<Invoice> {
  return request("/invoices", { method: "POST", body: JSON.stringify(data) });
}

export async function confirmPayment(
  invoiceId: number,
  paymentMethod: string
): Promise<Invoice> {
  return request(`/invoices/${invoiceId}/confirm`, {
    method: "POST",
    body: JSON.stringify({ payment_method: paymentMethod }),
  });
}

export async function sendInvoice(invoiceId: number): Promise<Invoice> {
  return request(`/invoices/${invoiceId}/send`, { method: "POST" });
}

export async function cancelInvoice(invoiceId: number): Promise<void> {
  return request(`/invoices/${invoiceId}/cancel`, { method: "POST" });
}

export async function downloadInvoicePdf(invoiceId: number, invoiceNumber: string): Promise<void> {
  const token = getToken();
  const res = await fetch(`${BASE_URL}/invoices/${invoiceId}/pdf`, {
    headers: token ? { Authorization: `Bearer ${token}` } : {},
  });
  if (!res.ok) throw new Error("Impossible de télécharger le PDF.");
  const blob = await res.blob();
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = `Facture-${invoiceNumber}.pdf`;
  a.click();
  URL.revokeObjectURL(url);
}

// ── Team ─────────────────────────────────────────────────────────────────────

import type { AdminAccount, SaasRole } from "../types/saas";

// ── Roles ─────────────────────────────────────────────────────────────────────

export async function getRoles(): Promise<SaasRole[]> {
  return request("/roles");
}
export async function createRole(data: { name: string; label: string; color: string; permissions: string[] }): Promise<SaasRole> {
  return request("/roles", { method: "POST", body: JSON.stringify(data) });
}
export async function updateRole(id: number, data: { label: string; color: string; permissions: string[] }): Promise<SaasRole> {
  return request(`/roles/${id}`, { method: "PUT", body: JSON.stringify(data) });
}
export async function deleteRole(id: number): Promise<void> {
  return request(`/roles/${id}`, { method: "DELETE" });
}

export async function getTeam(): Promise<AdminAccount[]> {
  return request("/team");
}
export async function createTeamMember(data: {
  name: string; email: string; password: string; role: string;
}): Promise<AdminAccount> {
  return request("/team", { method: "POST", body: JSON.stringify(data) });
}
export async function updateTeamMember(id: number, data: Partial<AdminAccount & { password?: string }>): Promise<AdminAccount> {
  return request(`/team/${id}`, { method: "PUT", body: JSON.stringify(data) });
}
export async function deleteTeamMember(id: number): Promise<void> {
  return request(`/team/${id}`, { method: "DELETE" });
}

// ── Reactivate client ─────────────────────────────────────────────────────────

export async function reactivateClient(id: number): Promise<Client> {
  return request(`/clients/${id}/reactivate`, { method: "POST" });
}

// ── CSV exports ───────────────────────────────────────────────────────────────

async function downloadCsv(path: string, filename: string): Promise<void> {
  const token = getToken();
  const res = await fetch(`${BASE_URL}${path}`, {
    headers: token ? { Authorization: `Bearer ${token}` } : {},
  });
  if (!res.ok) throw new Error("Erreur lors de l'export.");
  const blob = await res.blob();
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = filename;
  a.click();
  URL.revokeObjectURL(url);
}

export const exportClients  = () => downloadCsv("/clients/export",  `clients-${new Date().toISOString().slice(0,10)}.csv`);
export const exportInvoices = () => downloadCsv("/invoices/export", `factures-${new Date().toISOString().slice(0,10)}.csv`);
export const exportActivity = () => downloadCsv("/activity/export", `activite-${new Date().toISOString().slice(0,10)}.csv`);

// ── Change password ───────────────────────────────────────────────────────────

export async function changePassword(data: {
  current_password: string;
  new_password: string;
  confirm_password: string;
}): Promise<{ success: boolean }> {
  return request("/auth/change-password", { method: "POST", body: JSON.stringify(data) });
}

export async function updateProfile(data: { name: string }): Promise<{ success: boolean; name: string }> {
  return request("/auth/profile", { method: "PUT", body: JSON.stringify(data) });
}

// ── Run cron manually ─────────────────────────────────────────────────────────

export async function runCron(key: string): Promise<Record<string, unknown>> {
  const token = getToken();
  const res = await fetch(`${BASE_URL}/cron/run?key=${encodeURIComponent(key)}`, {
    headers: token ? { Authorization: `Bearer ${token}` } : {},
  });
  const data = await res.json();
  if (!res.ok) throw new Error(data.error || "Erreur cron.");
  return data;
}

// ── Settings ──────────────────────────────────────────────────────────────────

export async function getSettings(): Promise<Record<string, string>> {
  return request("/settings");
}

export async function saveSettings(data: Record<string, string>): Promise<{ success: boolean }> {
  return request("/settings", { method: "POST", body: JSON.stringify(data) });
}

export async function testSmtp(): Promise<{ success: boolean; sent_to: string }> {
  return request("/settings/test-smtp", { method: "POST" });
}

// ── Notifications ─────────────────────────────────────────────────────────────

export async function getNotifications(): Promise<SaasNotification[]> {
  return request("/notifications");
}

// ── Activity ──────────────────────────────────────────────────────────────────

export async function getActivity(): Promise<ActivityLog[]> {
  return request("/activity");
}

export async function getTenantActivity(tenantId: number): Promise<ActivityLog[]> {
  return request(`/activity/tenant/${tenantId}`);
}

export async function getClientLiveStats(clientId: number): Promise<LiveStats> {
  return request(`/clients/${clientId}/live`);
}
