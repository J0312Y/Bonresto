import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import {
  Table, TableBody, TableCell, TableHeader, TableRow,
} from "../../components/ui/table";
import { getActivity, exportActivity } from "../../services/api";
import type { ActivityLog } from "../../types/saas";

const ACTION_LABELS: Record<string, string> = {
  tenant_created:       "Nouveau client",
  subscription_updated: "Abonnement mis à jour",
  tenant_suspended:     "Client suspendu",
  license_generated:    "Clé générée",
  license_activated:    "Licence activée",
  payment_recorded:     "Paiement enregistré",
  reminder_sent:        "Rappel envoyé",
  auto_suspended:       "Suspension auto",
  event:                "Événement",
};

const ACTION_COLORS: Record<string, string> = {
  tenant_created:       "bg-blue-100 text-blue-700 bg-blue-900/30 text-blue-400",
  subscription_updated: "bg-purple-100 text-purple-700 bg-purple-900/30 text-purple-400",
  tenant_suspended:     "bg-red-100 text-red-700 bg-red-900/30 text-red-400",
  auto_suspended:       "bg-red-100 text-red-700 bg-red-900/30 text-red-400",
  license_generated:    "bg-yellow-100 text-yellow-700 bg-yellow-900/30 text-yellow-400",
  license_activated:    "bg-green-100 text-green-700 bg-green-900/30 text-green-400",
  payment_recorded:     "bg-emerald-100 text-emerald-700 bg-emerald-900/30 text-emerald-400",
  reminder_sent:        "bg-orange-100 text-orange-700 bg-orange-900/30 text-orange-400",
};

function ActionBadge({ action }: { action: string }) {
  const label = ACTION_LABELS[action] ?? action;
  const cls = ACTION_COLORS[action] ?? "bg-gray-100 text-gray-600 bg-gray-800 text-gray-400";
  return (
    <span className={`inline-block rounded-full px-2.5 py-0.5 text-xs font-medium ${cls}`}>
      {label}
    </span>
  );
}

const PAGE_SIZE = 15;

function Pagination({ page, total, pageSize, onChange }: { page: number; total: number; pageSize: number; onChange: (p: number) => void }) {
  const pages = Math.ceil(total / pageSize);
  if (pages <= 1) return null;
  return (
    <div className="flex items-center justify-between px-6 py-3 border-t border-gray-100 border-gray-800">
      <span className="text-xs text-gray-400">{total} entrée{total !== 1 ? "s" : ""}</span>
      <div className="flex gap-1">
        <button disabled={page === 1} onClick={() => onChange(page - 1)}
          className="px-3 py-1 text-xs rounded border border-gray-200 border-gray-700 disabled:opacity-40 hover:bg-gray-50 hover:bg-white/5">‹</button>
        {Array.from({ length: pages }, (_, i) => i + 1).map((p) => (
          <button key={p} onClick={() => onChange(p)}
            className={`px-3 py-1 text-xs rounded border ${p === page ? "bg-[#37a000] text-white border-[#37a000]" : "border-gray-200 border-gray-700 hover:bg-gray-50 hover:bg-white/5"}`}>
            {p}
          </button>
        ))}
        <button disabled={page === pages} onClick={() => onChange(page + 1)}
          className="px-3 py-1 text-xs rounded border border-gray-200 border-gray-700 disabled:opacity-40 hover:bg-gray-50 hover:bg-white/5">›</button>
      </div>
    </div>
  );
}

export default function ActivityList() {
  const [logs, setLogs]       = useState<ActivityLog[]>([]);
  const [loading, setLoading] = useState(true);
  const [search, setSearch]   = useState("");
  const [action, setAction]   = useState("all");
  const [page, setPage]       = useState(1);

  useEffect(() => {
    getActivity()
      .then(setLogs)
      .catch(() => {})
      .finally(() => setLoading(false));
  }, []);

  // Unique action types from loaded data
  const actionTypes = ["all", ...Array.from(new Set(logs.map((l) => l.action)))];

  const filtered = logs.filter((l) => {
    const matchAction = action === "all" || l.action === action;
    const q = search.toLowerCase();
    const matchSearch = !q ||
      (l.business_name ?? "").toLowerCase().includes(q) ||
      l.description.toLowerCase().includes(q);
    return matchAction && matchSearch;
  });

  const paginated = filtered.slice((page - 1) * PAGE_SIZE, page * PAGE_SIZE);

  function handleSearchChange(v: string) { setSearch(v); setPage(1); }
  function handleActionChange(v: string) { setAction(v); setPage(1); }

  return (
    <>
      <PageMeta title="Activité — Bonresto SaaS" description="Journal d'activité global" />

      <div className="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 text-white/90">Journal d'activité</h2>
          <p className="text-sm text-gray-500 text-gray-400">
            {filtered.length} entrée{filtered.length !== 1 ? "s" : ""}
            {filtered.length !== logs.length && ` sur ${logs.length}`}
          </p>
        </div>
        <button
          onClick={() => exportActivity().catch(() => {})}
          className="inline-flex items-center gap-2 rounded-lg border border-gray-300 border-gray-600 px-3 py-2 text-sm font-medium text-gray-600 text-gray-300 hover:bg-gray-50 hover:bg-white/5"
        >
          ↓ CSV
        </button>
      </div>

      {/* Filters */}
      <div className="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center">
        <input
          type="text"
          placeholder="Rechercher par client ou description…"
          value={search}
          onChange={(e) => handleSearchChange(e.target.value)}
          className="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#37a000] border-gray-700 bg-gray-800 text-white"
        />
        <select
          value={action}
          onChange={(e) => handleActionChange(e.target.value)}
          className="saas-select"
        >
          {actionTypes.map((a) => (
            <option key={a} value={a}>
              {a === "all" ? "Toutes les actions" : (ACTION_LABELS[a] ?? a)}
            </option>
          ))}
        </select>
      </div>

      <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03]">
        {loading ? (
          <div className="p-8 text-center text-gray-400">Chargement...</div>
        ) : (
          <>
            <div className="overflow-x-auto">
              <Table>
                <TableHeader className="border-y border-gray-100 border-gray-800">
                  <TableRow>
                    <TableCell isHeader className="py-3 px-6 font-medium text-gray-500 text-theme-xs text-gray-400">Date</TableCell>
                    <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Client</TableCell>
                    <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Action</TableCell>
                    <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Détails</TableCell>
                  </TableRow>
                </TableHeader>
                <TableBody className="divide-y divide-gray-100 divide-gray-800">
                  {paginated.map((log) => (
                    <TableRow key={log.log_id} className="hover:bg-gray-50 hover:bg-white/[0.02]">
                      <TableCell className="py-3 px-6 text-xs text-gray-400 whitespace-nowrap">
                        {new Date(log.created_at).toLocaleString("fr-FR", {
                          day: "2-digit", month: "2-digit", year: "numeric",
                          hour: "2-digit", minute: "2-digit",
                        })}
                      </TableCell>
                      <TableCell className="py-3">
                        <span className="text-sm font-medium text-gray-700 text-gray-200">
                          {log.business_name ?? `Tenant #${log.tenant_id}`}
                        </span>
                      </TableCell>
                      <TableCell className="py-3">
                        <ActionBadge action={log.action} />
                      </TableCell>
                      <TableCell className="py-3 text-sm text-gray-500 text-gray-400">
                        {log.description}
                        {log.meta && Object.keys(log.meta).length > 0 && (
                          <details className="mt-1">
                            <summary className="cursor-pointer text-xs text-gray-400 hover:text-gray-600">Métadonnées</summary>
                            <pre className="mt-1 rounded bg-gray-50 p-2 text-xs text-gray-600 bg-gray-900 text-gray-400 overflow-auto max-w-xs">
                              {JSON.stringify(log.meta, null, 2)}
                            </pre>
                          </details>
                        )}
                      </TableCell>
                    </TableRow>
                  ))}
                  {paginated.length === 0 && (
                    <TableRow>
                      <TableCell className="py-8 text-center text-gray-400">Aucune activité trouvée.</TableCell>
                    </TableRow>
                  )}
                </TableBody>
              </Table>
            </div>
            <Pagination page={page} total={filtered.length} pageSize={PAGE_SIZE} onChange={setPage} />
          </>
        )}
      </div>
    </>
  );
}
