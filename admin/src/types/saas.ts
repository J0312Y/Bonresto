export interface Client {
  client_id: number;
  business_name: string;
  email: string;
  phone: string;
  country: string;
  city?: string;
  address?: string;
  website?: string;
  notes?: string;
  created_at: string;
  logo_url?: string | null;
  is_active?: boolean;
  subscription?: Subscription;
}

export interface Subscription {
  sub_id: number;
  client_id: number;
  plan_id: number;
  plan_name: string;
  status: "active" | "grace" | "expired" | "suspended";
  start_date: string;
  end_date: string;
  grace_end_date: string;
}

export interface Plan {
  plan_id: number;
  plan_name: string;
  features: Record<string, boolean>;
  max_tables: number;
  max_users: number;
  price: number;
  billing_cycle: "monthly" | "annual";
}

export interface AdminAccount {
  admin_id: number;
  name: string;
  email: string;
  role: string;
  is_active: number;
  created_at: string;
}

export interface SaasRole {
  role_id: number;
  name: string;
  label: string;
  color: string;
  permissions: string[];
  is_system: number;
  created_at: string;
}

export interface LicenseKey {
  key_id: number;
  tenant_id: number;
  client_key: string;
  is_activated: boolean | string;
  status: "active" | "revoked";
  activated_at: string | null;
  revoked_at: string | null;
  server_url: string | null;
  created_at: string;
  // joined
  business_name?: string;
  email?: string;
  sub_status?: "active" | "grace" | "expired" | "suspended" | null;
  sub_end_date?: string | null;
  plan_name?: string | null;
  price?: number | string | null;
  billing_cycle?: "monthly" | "annual" | null;
}

export interface Payment {
  payment_id: number;
  client_id: number;
  amount: number;
  currency: string;
  plan_id: number;
  plan_name: string;
  status: "pending" | "paid" | "failed" | "refunded";
  created_at: string;
  client_name: string;
  client_email: string;
}

export interface ActivityLog {
  log_id: number;
  tenant_id: number;
  action: string;
  description: string;
  meta: Record<string, unknown> | null;
  created_at: string;
  business_name?: string;
}

export interface LiveStats {
  orders_today: number;
  revenue_today: number;
  customers_total: number;
  tables_total: number;
}

export interface SaasUpdate {
  update_id: number;
  title: string;
  version: string;
  module: string;
  type: "config" | "code";
  target_type: "all" | "plan" | "tenant";
  target_id: number | null;
  target_name?: string;
  target_plan?: string;
  changelog: string;
  payload: unknown;
  status: "draft" | "published" | "archived";
  created_at: string;
  published_at: string | null;
  delivery?: { pending: number; applied: number; failed: number };
}

export interface RecentOrder {
  order_id: number;
  tenant_id: number;
  order_date: string;
  order_time: string;
  totalamount: number;
  order_status: number | string;
  business_name: string;
  customer_name: string | null;
}

export interface ClientStats {
  tenant_id: number;
  business_name: string;
  total_orders: number;
  total_revenue: number;
  total_customers: number;
  total_tables: number;
  avg_order: number;
}

export interface ClientRevenueMonth {
  tenant_id: number;
  business_name: string;
  month: string;
  month_key: string;
  revenue: number;
  orders_count: number;
}

export interface Invoice {
  invoice_id: number;
  invoice_number: string;
  tenant_id: number;
  plan_id: number | null;
  amount: number;
  currency: string;
  period_start: string | null;
  period_end: string | null;
  status: "draft" | "sent" | "paid" | "cancelled";
  payment_method: "mtn" | "airtel" | "virement" | "especes" | "autre" | null;
  notes: string | null;
  paid_at: string | null;
  created_at: string;
  // joined
  business_name?: string;
  client_email?: string;
  plan_name?: string;
}

export interface SaasNotification {
  id: string;
  type: string;
  icon: string;
  color: "success" | "info" | "warning" | "error" | "brand";
  title: string;
  message: string;
  link: string;
  time: string;
  logo_url?: string | null;
  read: boolean;
}

export interface DashboardStats {
  total_clients: number;
  active_subscriptions: number;
  mrr: number;
  mrr_last_month: number;
  mrr_trend: number;
  churn_rate: number;
  invoice_recovery_rate: number;
  expiring_soon: number;
  revenue_this_month: number;
  new_clients_this_month: number;
  revenue_by_month: { month: string; revenue: number }[];
  subscriptions_by_plan: { plan: string; count: number }[];
}
