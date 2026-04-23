import { GroupIcon, BoxIconLine, DollarLineIcon, TableIcon } from "../../icons";
import type { ClientStats } from "../../types/saas";

const fcfa = (n: number) => `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

interface Props {
  clients: ClientStats[];
}

export default function ClientDemographics({ clients }: Props) {
  if (clients.length === 0) {
    return (
      <div className="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6 flex items-center justify-center h-full">
        <p className="text-sm text-gray-400">Aucune donnée</p>
      </div>
    );
  }

  return (
    <div className="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
      <h3 className="text-lg font-semibold text-gray-800 dark:text-white/90 mb-1">
        Démographie clients
      </h3>
      <p className="text-sm text-gray-500 dark:text-gray-400 mb-5">
        Statistiques par restaurant
      </p>

      <div className="space-y-5">
        {clients.map((c) => (
          <div
            key={c.tenant_id}
            className="rounded-xl border border-gray-100 dark:border-gray-800 p-4"
          >
            <p className="font-semibold text-gray-800 dark:text-white/90 text-sm mb-3 truncate">
              {c.business_name}
            </p>
            <div className="grid grid-cols-2 gap-3">
              <div className="flex items-center gap-2">
                <span className="flex items-center justify-center w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-500/10">
                  <GroupIcon className="text-blue-500 size-4" />
                </span>
                <div>
                  <p className="text-xs text-gray-400">Clients</p>
                  <p className="text-sm font-semibold text-gray-800 dark:text-white/90">{c.total_customers}</p>
                </div>
              </div>
              <div className="flex items-center gap-2">
                <span className="flex items-center justify-center w-7 h-7 rounded-lg bg-purple-50 dark:bg-purple-500/10">
                  <BoxIconLine className="text-purple-500 size-4" />
                </span>
                <div>
                  <p className="text-xs text-gray-400">Commandes</p>
                  <p className="text-sm font-semibold text-gray-800 dark:text-white/90">{c.total_orders}</p>
                </div>
              </div>
              <div className="flex items-center gap-2">
                <span className="flex items-center justify-center w-7 h-7 rounded-lg bg-green-50 dark:bg-green-500/10">
                  <DollarLineIcon className="text-green-500 size-4" />
                </span>
                <div>
                  <p className="text-xs text-gray-400">Panier moyen</p>
                  <p className="text-sm font-semibold text-gray-800 dark:text-white/90">{fcfa(c.avg_order)}</p>
                </div>
              </div>
              <div className="flex items-center gap-2">
                <span className="flex items-center justify-center w-7 h-7 rounded-lg bg-orange-50 dark:bg-orange-500/10">
                  <TableIcon className="text-orange-500 size-4" />
                </span>
                <div>
                  <p className="text-xs text-gray-400">Tables</p>
                  <p className="text-sm font-semibold text-gray-800 dark:text-white/90">{c.total_tables}</p>
                </div>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}
