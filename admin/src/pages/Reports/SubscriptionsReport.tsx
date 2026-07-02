import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import PlansBreakdown from "../../components/saas/PlansBreakdown";
import { getDashboardStats, getClients } from "../../services/api";
import type { DashboardStats, Client } from "../../types/saas";
import Badge from "../../components/ui/badge/Badge";

const EMPTY: DashboardStats = {
  total_clients: 0, active_subscriptions: 0, mrr: 0,
  mrr_last_month: 0, mrr_trend: 0, churn_rate: 0, invoice_recovery_rate: 0,
  expiring_soon: 0, revenue_this_month: 0, new_clients_this_month: 0,
  revenue_by_month: [], subscriptions_by_plan: [],
};

function statusColor(s?: string): "success"|"warning"|"error"|"info" {
  return s === "active" ? "success" : s === "grace" ? "warning" : s === "expired" ? "error" : "info";
}
function statusLabel(s?: string) {
  return s === "active" ? "Actif" : s === "grace" ? "Grâce" : s === "expired" ? "Expiré" : s === "suspended" ? "Suspendu" : "Aucun";
}

export default function SubscriptionsReport() {
  const [stats, setStats]     = useState<DashboardStats>(EMPTY);
  const [clients, setClients] = useState<Client[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    Promise.all([getDashboardStats(), getClients()])
      .then(([s, c]) => { setStats(s); setClients(c); })
      .finally(() => setLoading(false));
  }, []);

  if (loading) {
    return <div className="flex items-center justify-center h-64 text-gray-400">Chargement...</div>;
  }

  return (
    <>
      <PageMeta title="Rapport Abonnements — Bonresto SaaS" description="" />
      <div className="space-y-6">
        <div>
          <h2 className="text-xl font-semibold text-gray-800 text-white/90">Rapport des abonnements</h2>
          <p className="text-sm text-gray-500 mt-1">État des abonnements par client</p>
        </div>

        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03]">
            <p className="text-xs text-gray-500 mb-1">Abonnements actifs</p>
            <p className="text-2xl font-bold text-green-600">{stats.active_subscriptions}</p>
          </div>
          <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03]">
            <p className="text-xs text-gray-500 mb-1">Expirent dans 7 jours</p>
            <p className={`text-2xl font-bold ${stats.expiring_soon > 0 ? "text-yellow-600" : "text-gray-800 text-white/90"}`}>
              {stats.expiring_soon}
            </p>
          </div>
          <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03]">
            <p className="text-xs text-gray-500 mb-1">Taux d'activation</p>
            <p className="text-2xl font-bold text-brand-500">
              {stats.total_clients > 0 ? Math.round((stats.active_subscriptions / stats.total_clients) * 100) : 0}%
            </p>
          </div>
        </div>

        <div className="grid grid-cols-1 xl:grid-cols-2 gap-6">
          <PlansBreakdown stats={stats} />

          <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03]">
            <div className="px-6 pt-5 pb-3">
              <h3 className="text-base font-semibold text-gray-800 text-white/90">Statuts par client</h3>
            </div>
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead className="border-y border-gray-100 border-gray-800">
                  <tr>
                    {["Restaurant","Plan","Début","Fin","Statut"].map((h) => (
                      <th key={h} className="px-4 py-3 text-left text-xs font-medium text-gray-500 text-gray-400">{h}</th>
                    ))}
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-100 divide-gray-800">
                  {clients.map((c) => (
                    <tr key={c.client_id} className="hover:bg-gray-50 hover:bg-white/[0.02]">
                      <td className="px-4 py-3 font-medium text-gray-800 text-white/90">{c.business_name}</td>
                      <td className="px-4 py-3 text-gray-500 text-gray-400">{c.subscription?.plan_name ?? "—"}</td>
                      <td className="px-4 py-3 text-gray-500 text-gray-400">
                        {c.subscription?.start_date ? new Date(c.subscription.start_date).toLocaleDateString("fr-FR") : "—"}
                      </td>
                      <td className="px-4 py-3 text-gray-500 text-gray-400">
                        {c.subscription?.end_date ? new Date(c.subscription.end_date).toLocaleDateString("fr-FR") : "—"}
                      </td>
                      <td className="px-4 py-3">
                        <Badge size="sm" color={statusColor(c.subscription?.status)}>
                          {statusLabel(c.subscription?.status)}
                        </Badge>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </>
  );
}
