import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import ClientStatsComparison from "../../components/saas/ClientStatsComparison";
import ClientDemographics from "../../components/saas/ClientDemographics";
import { getClientsStats } from "../../services/api";
import type { ClientStats } from "../../types/saas";

export default function ClientsReport() {
  const [clients, setClients] = useState<ClientStats[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    getClientsStats()
      .then(setClients)
      .finally(() => setLoading(false));
  }, []);

  if (loading) {
    return <div className="flex items-center justify-center h-64 text-gray-400">Chargement...</div>;
  }

  return (
    <>
      <PageMeta title="Rapport Clients — Bonresto SaaS" description="" />
      <div className="space-y-6">
        <div>
          <h2 className="text-xl font-semibold text-gray-800 dark:text-white/90">Rapport des clients</h2>
          <p className="text-sm text-gray-500 mt-1">Abonnements et paiements par restaurant</p>
        </div>

        <div className="grid grid-cols-12 gap-6">
          <div className="col-span-12 xl:col-span-5">
            <ClientDemographics clients={clients} />
          </div>
          <div className="col-span-12 xl:col-span-7">
            <ClientStatsComparison clients={clients} />
          </div>
        </div>
      </div>
    </>
  );
}
