import { useEffect, useState } from "react";
import { Link } from "react-router";
import PageMeta from "../../components/common/PageMeta";
import Badge from "../../components/ui/badge/Badge";
import { ClientAvatar } from "../../components/ui/ClientAvatar";
import {
  Table,
  TableBody,
  TableCell,
  TableHeader,
  TableRow,
} from "../../components/ui/table";
import { getClients, generateLicense, suspendClient, exportClients } from "../../services/api";
import type { Client } from "../../types/saas";

function statusColor(s?: string): "success" | "warning" | "error" | "info" {
  if (s === "active") return "success";
  if (s === "grace") return "warning";
  if (s === "expired") return "error";
  return "info";
}
function statusLabel(s?: string) {
  if (s === "active") return "Actif";
  if (s === "grace") return "Période de grâce";
  if (s === "expired") return "Expiré";
  if (s === "suspended") return "Suspendu";
  return "Aucun abonnement";
}

const PAGE_SIZE = 10;

function Pagination({ page, total, pageSize, onChange }: { page: number; total: number; pageSize: number; onChange: (p: number) => void }) {
  const pages = Math.ceil(total / pageSize);
  if (pages <= 1) return null;
  return (
    <div className="flex items-center justify-between px-5 py-3 border-t border-gray-100 dark:border-gray-800">
      <span className="text-xs text-gray-400">{total} résultat{total !== 1 ? "s" : ""}</span>
      <div className="flex gap-1">
        <button disabled={page === 1} onClick={() => onChange(page - 1)}
          className="px-3 py-1 text-xs rounded border border-gray-200 dark:border-gray-700 disabled:opacity-40 hover:bg-gray-50 dark:hover:bg-white/5">
          ‹
        </button>
        {Array.from({ length: pages }, (_, i) => i + 1).map((p) => (
          <button key={p} onClick={() => onChange(p)}
            className={`px-3 py-1 text-xs rounded border ${p === page ? "bg-[#37a000] text-white border-[#37a000]" : "border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-white/5"}`}>
            {p}
          </button>
        ))}
        <button disabled={page === pages} onClick={() => onChange(page + 1)}
          className="px-3 py-1 text-xs rounded border border-gray-200 dark:border-gray-700 disabled:opacity-40 hover:bg-gray-50 dark:hover:bg-white/5">
          ›
        </button>
      </div>
    </div>
  );
}

export default function ClientList() {
  const [clients, setClients] = useState<Client[]>([]);
  const [search, setSearch] = useState("");
  const [filter, setFilter] = useState<string>("all");
  const [page, setPage] = useState(1);
  const [loading, setLoading] = useState(true);
  const [actionMsg, setActionMsg] = useState<string | null>(null);

  useEffect(() => {
    getClients()
      .then(setClients)
      .catch(() => {})
      .finally(() => setLoading(false));
  }, []);

  const filtered = clients.filter((c) => {
    const matchSearch =
      c.business_name.toLowerCase().includes(search.toLowerCase()) ||
      c.email.toLowerCase().includes(search.toLowerCase());
    const matchFilter =
      filter === "all" || c.subscription?.status === filter;
    return matchSearch && matchFilter;
  });

  const paginated = filtered.slice((page - 1) * PAGE_SIZE, page * PAGE_SIZE);

  async function handleGenerate(clientId: number) {
    try {
      const key = await generateLicense(clientId);
      setActionMsg(`Clé générée : ${key.client_key}`);
    } catch {
      setActionMsg("Erreur lors de la génération de la clé.");
    }
  }

  async function handleSuspend(clientId: number) {
    if (!confirm("Suspendre cet abonnement ?")) return;
    try {
      await suspendClient(clientId);
      setClients((prev) =>
        prev.map((c) =>
          c.client_id === clientId && c.subscription
            ? { ...c, subscription: { ...c.subscription, status: "suspended" } }
            : c
        )
      );
    } catch {
      setActionMsg("Erreur lors de la suspension.");
    }
  }

  return (
    <>
      <PageMeta title="Clients — Bonresto SaaS" description="Gestion des clients" />

      <div className="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 dark:text-white/90">Clients</h2>
          <p className="text-sm text-gray-500 dark:text-gray-400">
            {clients.length} restaurant{clients.length !== 1 ? "s" : ""} enregistré{clients.length !== 1 ? "s" : ""}
          </p>
        </div>
        <div className="flex items-center gap-2">
          <button
            onClick={() => exportClients().catch(() => {})}
            className="inline-flex items-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5"
          >
            ↓ CSV
          </button>
          <Link
            to="/clients/new"
            className="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
          >
            + Nouveau client
          </Link>
        </div>
      </div>

      {actionMsg && (
        <div className="mb-4 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-200 p-4 text-sm text-blue-800 dark:text-blue-300">
          {actionMsg}
          <button onClick={() => setActionMsg(null)} className="ml-3 text-blue-500 underline">×</button>
        </div>
      )}

      {/* Filters */}
      <div className="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center">
        <input
          type="text"
          placeholder="Rechercher un client..."
          value={search}
          onChange={(e) => { setSearch(e.target.value); setPage(1); }}
          className="saas-select"
        />
        <select
          value={filter}
          onChange={(e) => { setFilter(e.target.value); setPage(1); }}
          className="saas-select"
        >
          <option value="all">Tous les statuts</option>
          <option value="active">Actif</option>
          <option value="grace">Période de grâce</option>
          <option value="expired">Expiré</option>
          <option value="suspended">Suspendu</option>
        </select>
      </div>

      <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        {loading ? (
          <div className="p-8 text-center text-gray-400">Chargement...</div>
        ) : (
          <div className="overflow-x-auto">
            <Table>
              <TableHeader className="border-gray-100 dark:border-gray-800 border-y">
                <TableRow>
                  <TableCell isHeader className="py-3 px-6 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Restaurant</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Contact</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Plan</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Expire le</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Statut</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Actions</TableCell>
                </TableRow>
              </TableHeader>
              <TableBody className="divide-y divide-gray-100 dark:divide-gray-800">
                {paginated.map((client) => (
                  <TableRow key={client.client_id}>
                    <TableCell className="py-3 px-6">
                      <div className="flex items-center gap-3">
                        <ClientAvatar
                          name={client.business_name}
                          logoUrl={client.logo_url}
                          size={36}
                        />
                        <div>
                          <p className="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                            {client.business_name}
                          </p>
                          <span className="text-gray-400 text-theme-xs">{client.country}</span>
                        </div>
                      </div>
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                      <div>
                        <p>{client.email}</p>
                        <p className="text-xs text-gray-400">{client.phone}</p>
                      </div>
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                      {client.subscription?.plan_name ?? <span className="text-gray-300">—</span>}
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                      {client.subscription
                        ? new Date(client.subscription.end_date).toLocaleDateString("fr-FR")
                        : "—"}
                    </TableCell>
                    <TableCell className="py-3">
                      <Badge size="sm" color={statusColor(client.subscription?.status)}>
                        {statusLabel(client.subscription?.status)}
                      </Badge>
                    </TableCell>
                    <TableCell className="py-3">
                      <div className="flex items-center gap-2">
                        <Link
                          to={`/clients/${client.client_id}`}
                          className="text-xs text-brand-500 hover:underline"
                        >
                          Détails
                        </Link>
                        <button
                          onClick={() => handleGenerate(client.client_id)}
                          className="text-xs text-green-600 hover:underline"
                        >
                          Clé
                        </button>
                        {client.subscription?.status === "active" && (
                          <button
                            onClick={() => handleSuspend(client.client_id)}
                            className="text-xs text-red-500 hover:underline"
                          >
                            Suspendre
                          </button>
                        )}
                      </div>
                    </TableCell>
                  </TableRow>
                ))}
                {paginated.length === 0 && (
                  <TableRow>
                    <TableCell className="py-8 text-center text-gray-400 col-span-6">
                      Aucun client trouvé.
                    </TableCell>
                  </TableRow>
                )}
              </TableBody>
            </Table>
            <Pagination page={page} total={filtered.length} pageSize={PAGE_SIZE} onChange={setPage} />
          </div>
        )}
      </div>
    </>
  );
}
