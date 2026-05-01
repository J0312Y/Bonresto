import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import RecentOrdersAll from "../../components/saas/RecentOrdersAll";
import PlansBreakdown from "../../components/saas/PlansBreakdown";
import RecentClients from "../../components/saas/RecentClients";
import RevenueChart from "../../components/saas/RevenueChart";
import SaasTarget from "../../components/saas/SaasTarget";
import ClientDemographics from "../../components/saas/ClientDemographics";
import {
  getDashboardStats,
  getRecentOrders,
  getClientsStats,
  getClients,
} from "../../services/api";
import type {
  DashboardStats,
  RecentOrder,
  ClientStats,
  Client,
} from "../../types/saas";
import {
  GroupIcon,
  CheckCircleIcon,
  DollarLineIcon,
  ShootingStarIcon,
  AlertIcon,
  PieChartIcon,
  ArrowUpIcon,
  ArrowDownIcon,
} from "../../icons";

// ── Helpers ────────────────────────────────────────────────────────────────────

const fcfa = (n: number) => `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

const EMPTY_STATS: DashboardStats = {
  total_clients: 0,
  active_subscriptions: 0,
  mrr: 0,
  mrr_last_month: 0,
  mrr_trend: 0,
  churn_rate: 0,
  invoice_recovery_rate: 0,
  expiring_soon: 0,
  revenue_this_month: 0,
  new_clients_this_month: 0,
  revenue_by_month: [],
  subscriptions_by_plan: [],
};

// ── Small KPI Card ─────────────────────────────────────────────────────────────

interface KpiProps {
  label: string;
  value: string | number;
  sub?: string;
  badge?: { text: string; up: boolean };
  icon: React.ReactNode;
  iconBg: string;
}

function KpiCard({ label, value, sub, badge, icon, iconBg }: KpiProps) {
  return (
    <div className="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
      <div className="flex items-start justify-between">
        <div className={`flex items-center justify-center w-11 h-11 rounded-xl ${iconBg}`}>
          {icon}
        </div>
        {badge && (
          <span className={`inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium ${
            badge.up
              ? "bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-400"
              : "bg-red-50 text-red-600 dark:bg-red-500/15 dark:text-red-400"
          }`}>
            {badge.up ? <ArrowUpIcon className="w-3 h-3" /> : <ArrowDownIcon className="w-3 h-3" />}
            {badge.text}
          </span>
        )}
      </div>
      <div className="mt-4">
        <p className="text-sm text-gray-500 dark:text-gray-400">{label}</p>
        <h4 className="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90 truncate">{value}</h4>
        {sub && <p className="mt-0.5 text-xs text-gray-400 dark:text-gray-500">{sub}</p>}
      </div>
    </div>
  );
}

// ── Page ───────────────────────────────────────────────────────────────────────

export default function Home() {
  const [stats, setStats]                   = useState<DashboardStats>(EMPTY_STATS);
  const [orders, setOrders]                 = useState<RecentOrder[]>([]);
  const [clientStats, setClientStats]       = useState<ClientStats[]>([]);
  const [recentClients, setRecentClients]   = useState<Client[]>([]);
  const [loading, setLoading]               = useState(true);
  const [error, setError]                   = useState<string | null>(null);

  useEffect(() => {
    Promise.all([
      getDashboardStats(),
      getRecentOrders(),
      getClientsStats(),
      getClients(),
    ])
      .then(([s, o, cs, cl]) => {
        setStats(s);
        setOrders(o);
        setClientStats(cs);
        setRecentClients(cl);
        setError(null);
      })
      .catch((e) => setError(e?.message ?? "Erreur API"))
      .finally(() => setLoading(false));
  }, []);

  const today = new Date().toLocaleDateString("fr-FR", {
    weekday: "long",
    day: "numeric",
    month: "long",
    year: "numeric",
  });

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64 text-gray-400 text-sm">
        Chargement du tableau de bord...
      </div>
    );
  }

  return (
    <>
      <PageMeta title="Tableau de bord — Bonresto SaaS" description="" />

      {/* ── Page header ─────────────────────────────────────────── */}
      <div className="mb-6 flex items-center justify-between">
        <div>
          <h1 className="text-2xl font-bold text-gray-800 dark:text-white/90">Tableau de bord</h1>
          <p className="text-sm text-gray-400 mt-0.5 capitalize">{today}</p>
        </div>
      </div>

      {error && (
        <div className="mb-6 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700 dark:bg-red-500/10 dark:border-red-500/20 dark:text-red-400">
          <strong>Erreur API :</strong> {error}
        </div>
      )}

      <div className="space-y-6">

        {/* ── Section 1 : KPI principaux (4 cards) ────────────────── */}
        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
          <KpiCard
            label="Total clients"
            value={stats.total_clients}
            sub={`+${stats.new_clients_this_month} ce mois`}
            badge={stats.new_clients_this_month > 0
              ? { text: `${stats.new_clients_this_month} nouveaux`, up: true }
              : undefined}
            icon={<GroupIcon className="text-blue-600 size-5 dark:text-blue-400" />}
            iconBg="bg-blue-50 dark:bg-blue-500/10"
          />
          <KpiCard
            label="Abonnements actifs"
            value={stats.active_subscriptions}
            sub={`sur ${stats.total_clients} clients`}
            icon={<CheckCircleIcon className="text-[#37a000] size-5 dark:text-green-400" />}
            iconBg="bg-green-50 dark:bg-green-500/10"
          />
          <KpiCard
            label="MRR"
            value={fcfa(stats.mrr)}
            sub="Revenus récurrents mensuels"
            badge={stats.mrr_trend !== undefined
              ? { text: `${stats.mrr_trend > 0 ? "+" : ""}${stats.mrr_trend}% vs mois dernier`, up: stats.mrr_trend >= 0 }
              : undefined}
            icon={<ShootingStarIcon className="text-orange-500 size-5 dark:text-orange-400" />}
            iconBg="bg-orange-50 dark:bg-orange-500/10"
          />
          <KpiCard
            label="Revenus du mois"
            value={fcfa(stats.revenue_this_month)}
            sub="encaissés ce mois-ci"
            icon={<DollarLineIcon className="text-purple-600 size-5 dark:text-purple-400" />}
            iconBg="bg-purple-50 dark:bg-purple-500/10"
          />
        </div>

        {/* ── Section 2 : Revenus 12 mois (full width) ────────────── */}
        <RevenueChart stats={stats} />

        {/* ── Section 3 : Taux d'activation ───────────────────────── */}
        <SaasTarget stats={stats} />

        {/* ── Section 4 : KPI secondaires ─────────────────────────── */}
        <div>
          <p className="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-3 px-0.5">
            Performance & Santé
          </p>
          <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <KpiCard
              label="Expirent bientôt"
              value={stats.expiring_soon}
              sub="dans les 7 prochains jours"
              badge={stats.expiring_soon > 0 ? { text: "attention", up: false } : undefined}
              icon={<AlertIcon className="text-amber-500 size-5 dark:text-amber-400" />}
              iconBg="bg-amber-50 dark:bg-amber-500/10"
            />
            <KpiCard
              label="Taux d'activation"
              value={`${stats.total_clients > 0
                ? Math.round((stats.active_subscriptions / stats.total_clients) * 100)
                : 0}%`}
              sub="clients avec abonnement actif"
              icon={<PieChartIcon className="text-pink-600 size-5 dark:text-pink-400" />}
              iconBg="bg-pink-50 dark:bg-pink-500/10"
            />
            <KpiCard
              label="Taux de churn"
              value={`${stats.churn_rate ?? 0}%`}
              sub="résiliations sur 30 jours"
              badge={{ text: (stats.churn_rate ?? 0) > 5 ? "élevé" : "faible", up: (stats.churn_rate ?? 0) <= 5 }}
              icon={<ArrowDownIcon className="text-red-500 size-5 dark:text-red-400" />}
              iconBg="bg-red-50 dark:bg-red-500/10"
            />
            <KpiCard
              label="Recouvrement factures"
              value={`${stats.invoice_recovery_rate ?? 0}%`}
              sub="factures payées / émises"
              badge={{ text: (stats.invoice_recovery_rate ?? 0) >= 80 ? "bon" : "à améliorer", up: (stats.invoice_recovery_rate ?? 0) >= 80 }}
              icon={<CheckCircleIcon className="text-teal-500 size-5 dark:text-teal-400" />}
              iconBg="bg-teal-50 dark:bg-teal-500/10"
            />
          </div>
        </div>

        {/* ── Section 5 : Répartition plans + Démographie clients ─── */}
        <div className="grid grid-cols-1 gap-4 lg:grid-cols-3">
          <div className="lg:col-span-1">
            <PlansBreakdown stats={stats} />
          </div>
          <div className="lg:col-span-2">
            <ClientDemographics clients={clientStats} />
          </div>
        </div>

        {/* ── Section 6 : Clients récents ──────────────────────────── */}
        <RecentClients clients={recentClients} />

        {/* ── Section 7 : Toutes les commandes récentes ────────────── */}
        <RecentOrdersAll orders={orders} />

      </div>
    </>
  );
}
