import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import ClientRevenueChart from "../../components/saas/ClientRevenueChart";
import { getClientsRevenue, getClientsStats } from "../../services/api";
import type { ClientRevenueMonth, ClientStats } from "../../types/saas";

const fcfa = (n: number) => `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

export default function RevenueReport() {
  const [revenue, setRevenue] = useState<ClientRevenueMonth[]>([]);
  const [clients, setClients] = useState<ClientStats[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    Promise.all([getClientsRevenue(), getClientsStats()])
      .then(([r, c]) => { setRevenue(r); setClients(c); })
      .finally(() => setLoading(false));
  }, []);

  const totalRevenue  = clients.reduce((s, c) => s + c.total_revenue, 0);
  const totalPayments = clients.reduce((s, c) => s + c.payment_count, 0);

  if (loading) {
    return <div className="flex items-center justify-center h-64 text-gray-400">Chargement...</div>;
  }

  return (
    <>
      <PageMeta title="Rapport Revenus — Bonresto SaaS" description="" />
      <div className="space-y-6">
        <div>
          <h2 className="text-xl font-semibold text-gray-800 text-white/90">Rapport des revenus</h2>
          <p className="text-sm text-gray-500 mt-1">Revenus cumulés de tous les restaurants</p>
        </div>

        {/* Summary cards */}
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03]">
            <p className="text-xs text-gray-500 mb-1">Revenu total</p>
            <p className="text-2xl font-bold text-gray-800 text-white/90">{fcfa(totalRevenue)}</p>
          </div>
          <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03]">
            <p className="text-xs text-gray-500 mb-1">Paiements totaux</p>
            <p className="text-2xl font-bold text-gray-800 text-white/90">{totalPayments.toLocaleString("fr-FR")}</p>
          </div>
          <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03]">
            <p className="text-xs text-gray-500 mb-1">Revenu moyen / client</p>
            <p className="text-2xl font-bold text-gray-800 text-white/90">
              {fcfa(clients.length > 0 ? totalRevenue / clients.length : 0)}
            </p>
          </div>
        </div>

        <ClientRevenueChart data={revenue} />

        {/* Per-client table */}
        <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03]">
          <div className="px-6 pt-5 pb-3">
            <h3 className="text-base font-semibold text-gray-800 text-white/90">Détail par restaurant</h3>
          </div>
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead className="border-y border-gray-100 border-gray-800">
                <tr>
                  {["Restaurant","Plan","Statut","Paiements","Revenu total","Expiration"].map((h) => (
                    <th key={h} className="px-6 py-3 text-left text-xs font-medium text-gray-500 text-gray-400">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100 divide-gray-800">
                {clients.sort((a,b) => b.total_revenue - a.total_revenue).map((c) => (
                  <tr key={c.tenant_id} className="hover:bg-gray-50 hover:bg-white/[0.02]">
                    <td className="px-6 py-3 font-medium text-gray-800 text-white/90">{c.business_name}</td>
                    <td className="px-6 py-3 text-gray-600 text-gray-300">{c.plan_name}</td>
                    <td className="px-6 py-3 text-gray-600 text-gray-300 capitalize">{c.subscription_status}</td>
                    <td className="px-6 py-3 text-gray-600 text-gray-300">{c.payment_count.toLocaleString("fr-FR")}</td>
                    <td className="px-6 py-3 text-gray-600 text-gray-300">{fcfa(c.total_revenue)}</td>
                    <td className="px-6 py-3 text-gray-600 text-gray-300">
                      {c.end_date ? new Date(c.end_date).toLocaleDateString("fr-FR") : "—"}
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </>
  );
}
