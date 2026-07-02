import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import Badge from "../../components/ui/badge/Badge";
import {
  Table, TableBody, TableCell, TableHeader, TableRow,
} from "../../components/ui/table";
import { getLicenses, revokeLicense } from "../../services/api";
import type { LicenseKey } from "../../types/saas";

function fmt(d: string | null | undefined) {
  return d ? new Date(d).toLocaleDateString("fr-FR") : "—";
}

function fcfa(n: number | string | null | undefined) {
  if (!n) return "—";
  return `${Math.round(Number(n)).toLocaleString("fr-FR")} FCFA`;
}

function subBadge(sub: LicenseKey) {
  if (sub.status === "revoked") return null;
  switch (sub.sub_status) {
    case "active":    return <Badge size="sm" color="success">Abonné</Badge>;
    case "grace":     return <Badge size="sm" color="warning">Grâce</Badge>;
    case "expired":   return <Badge size="sm" color="error">Expiré</Badge>;
    case "suspended": return <Badge size="sm" color="error">Suspendu</Badge>;
    default:          return <Badge size="sm" color="info">Aucun abonnement</Badge>;
  }
}

function keyBadge(lic: LicenseKey) {
  if (lic.status === "revoked") return <Badge size="sm" color="error">Révoquée</Badge>;
  if (Number(lic.is_activated)) return <Badge size="sm" color="success">Activée</Badge>;
  return <Badge size="sm" color="info">En attente</Badge>;
}

type FilterTab = "all" | "active" | "revoked" | "expired";

export default function LicenseList() {
  const [licenses, setLicenses] = useState<LicenseKey[]>([]);
  const [loading, setLoading]   = useState(true);
  const [copied, setCopied]     = useState<number | null>(null);
  const [filter, setFilter]     = useState<FilterTab>("all");

  useEffect(() => {
    getLicenses()
      .then(setLicenses)
      .catch(() => {})
      .finally(() => setLoading(false));
  }, []);

  async function handleRevoke(keyId: number) {
    if (!confirm("Révoquer cette clé ? Le client ne pourra plus l'utiliser.")) return;
    try {
      await revokeLicense(keyId);
      setLicenses((prev) =>
        prev.map((k) =>
          k.key_id === keyId
            ? { ...k, status: "revoked" as const, revoked_at: new Date().toISOString() }
            : k
        )
      );
    } catch {
      alert("Erreur lors de la révocation.");
    }
  }

  function copyKey(key: string, id: number) {
    navigator.clipboard.writeText(key);
    setCopied(id);
    setTimeout(() => setCopied(null), 2000);
  }

  const counts = {
    all:     licenses.length,
    active:  licenses.filter((k) => k.status === "active" && k.sub_status !== "expired" && k.sub_status !== "suspended").length,
    expired: licenses.filter((k) => k.status === "active" && (k.sub_status === "expired" || k.sub_status === "suspended")).length,
    revoked: licenses.filter((k) => k.status === "revoked").length,
  };

  const shown = filter === "all"     ? licenses
    : filter === "revoked"           ? licenses.filter((k) => k.status === "revoked")
    : filter === "expired"           ? licenses.filter((k) => k.status === "active" && (k.sub_status === "expired" || k.sub_status === "suspended"))
    : /* active */                     licenses.filter((k) => k.status === "active" && k.sub_status !== "expired" && k.sub_status !== "suspended");

  const tabs: { key: FilterTab; label: string }[] = [
    { key: "all",     label: `Toutes (${counts.all})` },
    { key: "active",  label: `Actives (${counts.active})` },
    { key: "expired", label: `Expirées (${counts.expired})` },
    { key: "revoked", label: `Révoquées (${counts.revoked})` },
  ];

  return (
    <>
      <PageMeta title="Licences — Bonresto SaaS" description="Clés d'activation" />

      <div className="mb-4 flex items-end justify-between flex-wrap gap-3">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 text-white/90">Clés de licence</h2>
          <p className="text-sm text-gray-500 text-gray-400 mt-1">
            {counts.all} clé{counts.all !== 1 ? "s" : ""} au total
            {" · "}
            <span className="text-green-600 font-medium">{counts.active} active{counts.active !== 1 ? "s" : ""}</span>
            {" · "}
            <span className="text-yellow-600 font-medium">{counts.expired} expirée{counts.expired !== 1 ? "s" : ""}</span>
            {" · "}
            <span className="text-red-500 font-medium">{counts.revoked} révoquée{counts.revoked !== 1 ? "s" : ""}</span>
          </p>
        </div>

        <div className="flex gap-2 flex-wrap">
          {tabs.map((t) => (
            <button
              key={t.key}
              onClick={() => setFilter(t.key)}
              className={`px-3 py-1.5 rounded-full text-xs font-semibold border transition-colors ${
                filter === t.key
                  ? "bg-[#37a000] text-white border-[#37a000]"
                  : "bg-white text-gray-600 border-gray-300 hover:bg-gray-50 bg-gray-800 text-gray-300 border-gray-600"
              }`}
            >
              {t.label}
            </button>
          ))}
        </div>
      </div>

      <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03]">
        {loading ? (
          <div className="p-8 text-center text-gray-400">Chargement...</div>
        ) : (
          <div className="overflow-x-auto">
            <Table>
              <TableHeader className="border-gray-100 border-gray-800 border-y">
                <TableRow>
                  <TableCell isHeader className="py-3 px-6 font-medium text-gray-500 text-theme-xs text-gray-400">Client</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Clé</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Clé statut</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Abonnement</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Plan · Coût</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Expire le</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Activée le</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Révoquée le</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Serveur</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">Action</TableCell>
                </TableRow>
              </TableHeader>
              <TableBody className="divide-y divide-gray-100 divide-gray-800">
                {shown.map((lic) => {
                  const isRevoked  = lic.status === "revoked";
                  const isExpired  = !isRevoked && (lic.sub_status === "expired" || lic.sub_status === "suspended");
                  return (
                    <TableRow key={lic.key_id} className={isRevoked || isExpired ? "opacity-60" : ""}>
                      <TableCell className="py-3 px-6">
                        <p className="font-medium text-gray-800 text-theme-sm text-white/90">
                          {lic.business_name ?? `Tenant #${lic.tenant_id}`}
                        </p>
                        <span className="text-xs text-gray-400">{lic.email}</span>
                      </TableCell>

                      <TableCell className="py-3">
                        <div className="flex items-center gap-2">
                          <code className={`rounded px-2 py-1 text-xs font-mono tracking-wider ${
                            isRevoked
                              ? "bg-red-50 text-red-400 bg-red-900/20 line-through"
                              : "bg-gray-100 text-gray-700 bg-gray-800 text-gray-300"
                          }`}>
                            {lic.client_key}
                          </code>
                          {!isRevoked && (
                            <button onClick={() => copyKey(lic.client_key, lic.key_id)} className="text-xs text-brand-500 hover:underline">
                              {copied === lic.key_id ? "✓" : "Copier"}
                            </button>
                          )}
                        </div>
                      </TableCell>

                      <TableCell className="py-3">{keyBadge(lic)}</TableCell>

                      <TableCell className="py-3">{subBadge(lic)}</TableCell>

                      <TableCell className="py-3">
                        {lic.plan_name ? (
                          <div>
                            <span className="text-sm font-medium text-gray-700 text-gray-300">{lic.plan_name}</span>
                            <br />
                            <span className="text-xs text-gray-400">
                              {fcfa(lic.price)}{lic.billing_cycle === "monthly" ? "/mois" : "/an"}
                            </span>
                          </div>
                        ) : "—"}
                      </TableCell>

                      <TableCell className="py-3 text-gray-500 text-theme-sm text-gray-400">
                        {fmt(lic.sub_end_date)}
                      </TableCell>

                      <TableCell className="py-3 text-gray-500 text-theme-sm text-gray-400">
                        {fmt(lic.activated_at)}
                      </TableCell>

                      <TableCell className="py-3 text-gray-500 text-theme-sm text-gray-400">
                        {fmt(lic.revoked_at)}
                      </TableCell>

                      <TableCell className="py-3 text-gray-500 text-theme-sm text-gray-400">
                        {lic.server_url && !isRevoked ? (
                          <a href={lic.server_url} target="_blank" rel="noopener noreferrer"
                             className="text-xs text-brand-500 hover:underline truncate max-w-[140px] block">
                            {lic.server_url}
                          </a>
                        ) : "—"}
                      </TableCell>

                      <TableCell className="py-3">
                        {isRevoked ? (
                          <span className="text-xs text-gray-400 italic">Révoquée</span>
                        ) : (
                          <button onClick={() => handleRevoke(lic.key_id)} className="text-xs text-red-500 hover:underline">
                            Révoquer
                          </button>
                        )}
                      </TableCell>
                    </TableRow>
                  );
                })}
                {shown.length === 0 && (
                  <TableRow>
                    <TableCell className="py-8 text-center text-gray-400">Aucune clé.</TableCell>
                  </TableRow>
                )}
              </TableBody>
            </Table>
          </div>
        )}
      </div>
    </>
  );
}
