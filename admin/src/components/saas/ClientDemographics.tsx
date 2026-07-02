import { DollarLineIcon, CheckCircleIcon } from "../../icons";
import Badge from "../ui/badge/Badge";
import type { ClientStats } from "../../types/saas";

const fcfa = (n: number) => `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

function subColor(s: string): "success" | "warning" | "error" | "info" {
  if (s === "active")   return "success";
  if (s === "grace")    return "warning";
  if (s === "expired" || s === "suspended") return "error";
  return "info";
}

function subLabel(s: string) {
  if (s === "active")    return "Actif";
  if (s === "grace")     return "Grâce";
  if (s === "expired")   return "Expiré";
  if (s === "suspended") return "Suspendu";
  return "—";
}

interface Props {
  clients: ClientStats[];
}

export default function ClientDemographics({ clients }: Props) {
  if (clients.length === 0) {
    return (
      <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03] md:p-6 flex items-center justify-center h-full">
        <p className="text-sm text-gray-400">Aucune donnée</p>
      </div>
    );
  }

  return (
    <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03] md:p-6">
      <h3 className="text-lg font-semibold text-gray-800 text-white/90 mb-1">
        Aperçu des abonnements
      </h3>
      <p className="text-sm text-gray-500 text-gray-400 mb-5">
        Statut par restaurant
      </p>

      <div className="space-y-5">
        {clients.map((c) => (
          <div
            key={c.tenant_id}
            className="rounded-xl border border-gray-100 border-gray-800 p-4"
          >
            <div className="flex items-center justify-between mb-3">
              <p className="font-semibold text-gray-800 text-white/90 text-sm truncate">
                {c.business_name}
              </p>
              <Badge size="sm" color={subColor(c.subscription_status)}>
                {subLabel(c.subscription_status)}
              </Badge>
            </div>
            <div className="grid grid-cols-2 gap-3">
              <div className="flex items-center gap-2">
                <span className="flex items-center justify-center w-7 h-7 rounded-lg bg-blue-50 bg-blue-500/10">
                  <CheckCircleIcon className="text-blue-500 size-4" />
                </span>
                <div>
                  <p className="text-xs text-gray-400">Plan</p>
                  <p className="text-sm font-semibold text-gray-800 text-white/90">{c.plan_name}</p>
                </div>
              </div>
              <div className="flex items-center gap-2">
                <span className="flex items-center justify-center w-7 h-7 rounded-lg bg-green-50 bg-green-500/10">
                  <DollarLineIcon className="text-green-500 size-4" />
                </span>
                <div>
                  <p className="text-xs text-gray-400">Total payé</p>
                  <p className="text-sm font-semibold text-gray-800 text-white/90">{fcfa(c.total_revenue)}</p>
                </div>
              </div>
            </div>
            {c.end_date && (
              <p className="mt-2 text-xs text-gray-400">
                Expire le {new Date(c.end_date).toLocaleDateString("fr-FR")}
              </p>
            )}
          </div>
        ))}
      </div>
    </div>
  );
}
