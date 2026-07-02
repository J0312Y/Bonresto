import { useEffect, useState } from "react";
import { Link } from "react-router";
import PageMeta from "../../components/common/PageMeta";
import Badge from "../../components/ui/badge/Badge";
import { getInvoices, cancelInvoice, sendInvoice, getPlans, getClients, downloadInvoicePdf, exportInvoices } from "../../services/api";
import type { Invoice, Plan, Client } from "../../types/saas";
import { CreateInvoiceModal } from "./CreateInvoiceModal";
import { ConfirmPaymentModal } from "./ConfirmPaymentModal";

const fmt = (n: number | string) => `${Math.round(Number(n)).toLocaleString("fr-FR")} FCFA`;

const PAGE_SIZE = 10;

function Pagination({ page, total, pageSize, onChange }: { page: number; total: number; pageSize: number; onChange: (p: number) => void }) {
  const pages = Math.ceil(total / pageSize);
  if (pages <= 1) return null;
  return (
    <div className="flex items-center justify-between px-5 py-3 border-t border-gray-100 border-gray-800">
      <span className="text-xs text-gray-400">{total} résultat{total !== 1 ? "s" : ""}</span>
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

function statusColor(s: string): "success" | "warning" | "error" | "info" {
  if (s === "paid")      return "success";
  if (s === "sent")      return "info";
  if (s === "cancelled") return "error";
  return "warning"; // draft
}

function statusLabel(s: string) {
  if (s === "paid")      return "Payée";
  if (s === "sent")      return "Envoyée";
  if (s === "cancelled") return "Annulée";
  return "Brouillon";
}

const METHOD_LABEL: Record<string, string> = {
  mtn:       "MTN MoMo",
  airtel:    "Airtel Money",
  virement:  "Virement",
  especes:   "Espèces",
  autre:     "Autre",
};

export default function InvoiceList() {
  const [invoices, setInvoices] = useState<Invoice[]>([]);
  const [plans, setPlans]       = useState<Plan[]>([]);
  const [clients, setClients]   = useState<Client[]>([]);
  const [loading, setLoading]   = useState(true);
  const [filter, setFilter]     = useState("all");
  const [search, setSearch]     = useState("");
  const [page, setPage]         = useState(1);
  const [showCreate, setShowCreate]   = useState(false);
  const [confirmInv, setConfirmInv]   = useState<Invoice | null>(null);
  const [msg, setMsg]                 = useState<string | null>(null);
  const [pdfLoading, setPdfLoading]   = useState<number | null>(null);
  const [sendLoading, setSendLoading] = useState<number | null>(null);

  useEffect(() => {
    Promise.all([getInvoices(), getPlans(), getClients()])
      .then(([inv, pl, cl]) => { setInvoices(inv); setPlans(pl); setClients(cl); })
      .finally(() => setLoading(false));
  }, []);

  const filtered = invoices.filter((i) => {
    const matchFilter = filter === "all" || i.status === filter;
    const q = search.toLowerCase();
    const matchSearch = !q ||
      (i.business_name ?? "").toLowerCase().includes(q) ||
      (i.invoice_number ?? "").toLowerCase().includes(q) ||
      (i.plan_name ?? "").toLowerCase().includes(q);
    return matchFilter && matchSearch;
  });

  const paginated = filtered.slice((page - 1) * PAGE_SIZE, page * PAGE_SIZE);

  async function handleCancel(inv: Invoice) {
    if (!confirm(`Annuler la facture ${inv.invoice_number} ?`)) return;
    await cancelInvoice(inv.invoice_id);
    setInvoices((prev) => prev.map((i) => i.invoice_id === inv.invoice_id ? { ...i, status: "cancelled" } : i));
  }

  async function handleConfirmed(updated: Invoice) {
    setInvoices((prev) => prev.map((i) => i.invoice_id === updated.invoice_id ? updated : i));
    setConfirmInv(null);
    setMsg(`Paiement confirmé — ${updated.invoice_number}`);
    setTimeout(() => setMsg(null), 4000);
  }

  async function handleSend(inv: Invoice) {
    setSendLoading(inv.invoice_id);
    try {
      const updated = await sendInvoice(inv.invoice_id);
      setInvoices((prev) => prev.map((i) => i.invoice_id === inv.invoice_id ? updated : i));
      setMsg(`Facture ${inv.invoice_number} envoyée à ${inv.client_email}.`);
      setTimeout(() => setMsg(null), 5000);
    } catch (e: unknown) {
      const msg = e instanceof Error ? e.message : "Erreur lors de l'envoi.";
      setMsg(msg);
      setTimeout(() => setMsg(null), 5000);
    } finally {
      setSendLoading(null);
    }
  }

  async function handleDownloadPdf(inv: Invoice) {
    setPdfLoading(inv.invoice_id);
    try {
      await downloadInvoicePdf(inv.invoice_id, inv.invoice_number);
    } catch {
      setMsg("Erreur lors du téléchargement PDF.");
      setTimeout(() => setMsg(null), 4000);
    } finally {
      setPdfLoading(null);
    }
  }

  function handleCreated(inv: Invoice) {
    setInvoices((prev) => [inv, ...prev]);
    setShowCreate(false);
    setMsg(`Facture ${inv.invoice_number} créée.`);
    setTimeout(() => setMsg(null), 4000);
  }

  return (
    <>
      <PageMeta title="Factures — Bonresto SaaS" description="" />

      <div className="mb-6 flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 text-white/90">Factures</h2>
          <p className="text-sm text-gray-500">{invoices.length} facture{invoices.length !== 1 ? "s" : ""}</p>
        </div>
        <div className="flex items-center gap-2">
          <button
            onClick={() => exportInvoices().catch(() => {})}
            className="inline-flex items-center gap-2 rounded-lg border border-gray-300 border-gray-600 px-3 py-2 text-sm font-medium text-gray-600 text-gray-300 hover:bg-gray-50 hover:bg-white/5"
          >
            ↓ CSV
          </button>
          <button
            onClick={() => setShowCreate(true)}
            className="inline-flex items-center gap-2 rounded-lg bg-[#37a000] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#2d8600]"
          >
            + Nouvelle facture
          </button>
        </div>
      </div>

      {msg && (
        <div className="mb-4 rounded-xl bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
          {msg}
        </div>
      )}

      {/* Search */}
      <div className="mb-3">
        <input
          type="text"
          placeholder="Rechercher par client, numéro, plan…"
          value={search}
          onChange={(e) => { setSearch(e.target.value); setPage(1); }}
          className="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#37a000] border-gray-700 bg-gray-800 text-white"
        />
      </div>

      {/* Filter bar */}
      <div className="mb-4 flex gap-2 flex-wrap">
        {[
          { key: "all",       label: "Toutes" },
          { key: "draft",     label: "Brouillon" },
          { key: "sent",      label: "Envoyées" },
          { key: "paid",      label: "Payées" },
          { key: "cancelled", label: "Annulées" },
        ].map(({ key, label }) => (
          <button
            key={key}
            onClick={() => { setFilter(key); setPage(1); }}
            className={`px-3 py-1.5 rounded-full text-xs font-semibold border transition-colors ${
              filter === key
                ? "bg-[#37a000] text-white border-[#37a000]"
                : "bg-white text-gray-600 border-gray-300 hover:bg-gray-50 bg-gray-800 text-gray-300 border-gray-600"
            }`}
          >
            {label}
          </button>
        ))}
      </div>

      <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03]">
        {loading ? (
          <div className="p-8 text-center text-gray-400">Chargement...</div>
        ) : filtered.length === 0 ? (
          <div className="p-10 text-center text-gray-400">
            <p className="text-3xl mb-2">🧾</p>
            Aucune facture.
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full text-sm">
              <thead>
                <tr className="border-b border-gray-100 border-gray-800 text-left">
                  {["Numéro", "Client", "Plan", "Montant", "Période", "Statut", "Méthode", "Actions"].map((h) => (
                    <th key={h} className="px-5 py-3 text-xs font-medium text-gray-500 text-gray-400">{h}</th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-gray-100 divide-gray-800">
                {paginated.map((inv) => (
                  <tr key={inv.invoice_id} className="hover:bg-gray-50 hover:bg-white/5">
                    <td className="px-5 py-3 font-mono text-xs text-gray-600 text-gray-400 whitespace-nowrap">
                      {inv.invoice_number}
                    </td>
                    <td className="px-5 py-3">
                      <Link to={`/clients/${inv.tenant_id}`} className="font-medium text-gray-800 text-white hover:text-[#37a000] hover:text-[#37a000]">
                        {inv.business_name}
                      </Link>
                      <p className="text-xs text-gray-400">{inv.client_email}</p>
                    </td>
                    <td className="px-5 py-3 text-gray-500">{inv.plan_name ?? "—"}</td>
                    <td className="px-5 py-3 font-semibold text-gray-800 text-white whitespace-nowrap">
                      {fmt(inv.amount)}
                    </td>
                    <td className="px-5 py-3 text-gray-500 whitespace-nowrap text-xs">
                      {inv.period_start && inv.period_end
                        ? `${new Date(inv.period_start).toLocaleDateString("fr-FR")} → ${new Date(inv.period_end).toLocaleDateString("fr-FR")}`
                        : "—"}
                    </td>
                    <td className="px-5 py-3">
                      <Badge size="sm" color={statusColor(inv.status)}>
                        {statusLabel(inv.status)}
                      </Badge>
                    </td>
                    <td className="px-5 py-3 text-gray-500 text-xs">
                      {inv.payment_method ? METHOD_LABEL[inv.payment_method] ?? inv.payment_method : "—"}
                    </td>
                    <td className="px-5 py-3">
                      <div className="flex items-center gap-2 whitespace-nowrap">
                        {(inv.status === "draft" || inv.status === "sent") && (
                          <button
                            onClick={() => handleSend(inv)}
                            disabled={sendLoading === inv.invoice_id}
                            className="text-xs font-medium text-orange-500 hover:underline disabled:opacity-40"
                            title={`Envoyer à ${inv.client_email}`}
                          >
                            {sendLoading === inv.invoice_id ? "…" : inv.status === "sent" ? "Renvoyer" : "Envoyer"}
                          </button>
                        )}
                        {inv.status !== "paid" && inv.status !== "cancelled" && (
                          <button
                            onClick={() => setConfirmInv(inv)}
                            className="text-xs font-medium text-[#37a000] hover:underline"
                          >
                            Confirmer
                          </button>
                        )}
                        <button
                          onClick={() => handleDownloadPdf(inv)}
                          disabled={pdfLoading === inv.invoice_id}
                          className="text-xs text-blue-500 hover:underline disabled:opacity-40"
                          title="Télécharger PDF"
                        >
                          {pdfLoading === inv.invoice_id ? "…" : "PDF"}
                        </button>
                        {inv.status !== "paid" && inv.status !== "cancelled" && (
                          <button
                            onClick={() => handleCancel(inv)}
                            className="text-xs text-red-400 hover:underline"
                          >
                            Annuler
                          </button>
                        )}
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
            <Pagination page={page} total={filtered.length} pageSize={PAGE_SIZE} onChange={setPage} />
          </div>
        )}
      </div>

      {showCreate && (
        <CreateInvoiceModal
          clients={clients}
          plans={plans}
          onCreated={handleCreated}
          onClose={() => setShowCreate(false)}
        />
      )}

      {confirmInv && (
        <ConfirmPaymentModal
          invoice={confirmInv}
          onConfirmed={handleConfirmed}
          onClose={() => setConfirmInv(null)}
        />
      )}
    </>
  );
}
