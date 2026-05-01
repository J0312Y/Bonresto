import { useEffect, useRef, useState } from "react";
import { useNavigate, useParams } from "react-router";
import PageMeta from "../../components/common/PageMeta";
import Badge from "../../components/ui/badge/Badge";
import { ClientAvatar } from "../../components/ui/ClientAvatar";
import {
  Table, TableBody, TableCell, TableHeader, TableRow,
} from "../../components/ui/table";
import {
  getClient,
  getTenantActivity,
  suspendClient,
  updateClient,
  updateClientSubscription,
  getPlans,
  uploadClientLogo,
  deleteClientLogo,
  getInvoices,
  reactivateClient,
} from "../../services/api";
import type { ActivityLog, Client, Invoice, Plan } from "../../types/saas";
import { CreateInvoiceModal } from "../Invoices/CreateInvoiceModal";
import { ConfirmPaymentModal } from "../Invoices/ConfirmPaymentModal";

const fmt = (n: number) => `${Math.round(n).toLocaleString("fr-FR")} FCFA`;
const STATUS_LABEL: Record<string, string> = { draft:"Brouillon", sent:"Envoyée", paid:"Payée", cancelled:"Annulée" };
const STATUS_COLOR: Record<string, string> = { paid:"text-green-600", cancelled:"text-red-400", sent:"text-blue-500", draft:"text-gray-400" };

function subStatusColor(s: string): "success" | "warning" | "error" | "info" {
  if (s === "active") return "success";
  if (s === "grace") return "warning";
  if (s === "expired" || s === "suspended") return "error";
  return "info";
}

function subStatusLabel(s: string) {
  if (s === "active") return "Actif";
  if (s === "grace") return "Grâce";
  if (s === "expired") return "Expiré";
  if (s === "suspended") return "Suspendu";
  return s;
}

export default function ClientDetail() {
  const { id } = useParams<{ id: string }>();
  const clientId = Number(id);
  const navigate = useNavigate();

  const [client, setClient] = useState<Client | null>(null);
  const [activity, setActivity] = useState<ActivityLog[]>([]);
  const [plans, setPlans] = useState<Plan[]>([]);
  const [loading, setLoading] = useState(true);
  const [invoices, setInvoices]     = useState<Invoice[]>([]);
  const [showCreateInv, setShowCreateInv] = useState(false);
  const [confirmInv, setConfirmInv]       = useState<Invoice | null>(null);
  const [saving, setSaving]         = useState(false);
  const [saveMsg, setSaveMsg]       = useState<string | null>(null);
  const [logoUploading, setLogoUploading] = useState(false);
  const fileRef = useRef<HTMLInputElement>(null);

  // Info edit form
  const [infoForm, setInfoForm]     = useState<Partial<Client>>({});
  const [infoSaving, setInfoSaving] = useState(false);
  const [infoMsg, setInfoMsg]       = useState<string | null>(null);

  // Subscription form state
  const [planId, setPlanId] = useState(0);
  const [endDate, setEndDate] = useState("");

  useEffect(() => {
    // Load client first — if it fails, show "introuvable"
    getClient(clientId)
      .then((c) => {
        setClient(c);
        setInfoForm({
          business_name: c.business_name,
          email: c.email,
          phone: c.phone,
          country: c.country,
          city: c.city ?? "",
          address: c.address ?? "",
          website: c.website ?? "",
          notes: c.notes ?? "",
        });
        setPlanId(c.subscription?.plan_id ?? 0);
        setEndDate(c.subscription?.end_date ?? "");

        // Load secondary data independently — failures don't affect client display
        getTenantActivity(clientId).then(setActivity).catch(() => {});
        getPlans().then(setPlans).catch(() => {});
        getInvoices(clientId).then(setInvoices).catch(() => {});
      })
      .catch(() => {})
      .finally(() => setLoading(false));
  }, [clientId]);

  async function handleUpdateSub() {
    if (!planId || !endDate) return;
    setSaving(true);
    setSaveMsg(null);
    try {
      await updateClientSubscription(clientId, planId, endDate);
      const updated = await getClient(clientId);
      setClient(updated);
      setSaveMsg("Plan mis à jour. Les nouvelles fonctionnalités seront actives chez le client dans moins de 5 minutes.");
    } catch {
      setSaveMsg("Erreur lors de la mise à jour.");
    } finally {
      setSaving(false);
    }
  }

  async function handleInfoSave() {
    setInfoSaving(true);
    setInfoMsg(null);
    try {
      const updated = await updateClient(clientId, infoForm);
      setClient(updated);
      setInfoForm({
        business_name: updated.business_name,
        email:   updated.email,
        phone:   updated.phone,
        country: updated.country,
        city:    updated.city    ?? "",
        address: updated.address ?? "",
        website: updated.website ?? "",
        notes:   updated.notes   ?? "",
      });
      setInfoMsg("Informations mises à jour.");
    } catch (err: unknown) {
      setInfoMsg(err instanceof Error ? err.message : "Erreur lors de la sauvegarde.");
    } finally {
      setInfoSaving(false);
    }
  }

  async function handleLogoUpload(e: React.ChangeEvent<HTMLInputElement>) {
    const file = e.target.files?.[0];
    if (!file || !client) return;
    setLogoUploading(true);
    try {
      const res = await uploadClientLogo(clientId, file);
      setClient((prev) => prev ? { ...prev, logo_url: res.logo_url } : prev);
    } catch (err: unknown) {
      alert("Erreur upload: " + (err instanceof Error ? err.message : String(err)));
    } finally {
      setLogoUploading(false);
      if (fileRef.current) fileRef.current.value = "";
    }
  }

  async function handleLogoDelete() {
    if (!window.confirm("Supprimer le logo de ce client ?")) return;
    await deleteClientLogo(clientId);
    setClient((prev) => prev ? { ...prev, logo_url: null } : prev);
  }

  async function handleSuspend() {
    if (!window.confirm("Suspendre ce client ?")) return;
    await suspendClient(clientId);
    navigate("/clients");
  }

  async function handleReactivate() {
    if (!window.confirm("Réactiver l'accès de ce client ?")) return;
    try {
      const updated = await reactivateClient(clientId);
      setClient(updated);
      setSaveMsg("Client réactivé avec succès.");
      setTimeout(() => setSaveMsg(null), 4000);
    } catch (err: unknown) {
      setSaveMsg(err instanceof Error ? err.message : "Erreur lors de la réactivation.");
    }
  }

  if (loading) {
    return <div className="p-8 text-center text-gray-400">Chargement...</div>;
  }

  if (!client) {
    return <div className="p-8 text-center text-red-400">Client introuvable.</div>;
  }

  const sub = client.subscription;
  const live = (client as unknown as { live_stats?: Record<string, number> }).live_stats;

  return (
    <>
      <PageMeta
        title={`${client.business_name} — Bonresto SaaS`}
        description="Détail client"
      />

      {/* Header */}
      <div className="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div className="flex items-center gap-4">
          {/* Logo / Avatar with upload */}
          <div className="relative group">
            <ClientAvatar
              name={client.business_name}
              logoUrl={client.logo_url}
              size={64}
            />
            {/* Overlay on hover */}
            <div
              className="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
              onClick={() => fileRef.current?.click()}
              title="Changer le logo"
            >
              {logoUploading
                ? <span className="text-white text-xs">…</span>
                : <span className="text-white text-lg">✎</span>
              }
            </div>
            <input
              ref={fileRef}
              type="file"
              accept="image/png,image/jpeg,image/gif,image/webp"
              className="hidden"
              onChange={handleLogoUpload}
            />
          </div>

          <div>
            <button
              onClick={() => navigate("/clients")}
              className="mb-0.5 text-sm text-brand-500 hover:underline"
            >
              ← Retour aux clients
            </button>
            <h2 className="text-2xl font-bold text-gray-800 dark:text-white/90">
              {client.business_name}
            </h2>
            <p className="text-sm text-gray-500 dark:text-gray-400">
              {client.email} · {client.country}
            </p>
            {client.logo_url && (
              <button
                onClick={handleLogoDelete}
                className="mt-0.5 text-xs text-red-400 hover:underline"
              >
                Supprimer le logo
              </button>
            )}
          </div>
        </div>

        <div className="flex gap-2">
          {sub && (
            <Badge size="sm" color={subStatusColor(sub.status)}>
              {subStatusLabel(sub.status)}
            </Badge>
          )}
          {client.is_active ? (
            <button
              onClick={handleSuspend}
              className="rounded-xl border border-red-300 px-3 py-1.5 text-sm text-red-600 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/20"
            >
              Suspendre
            </button>
          ) : (
            <button
              onClick={handleReactivate}
              className="rounded-xl border border-green-300 px-3 py-1.5 text-sm text-green-700 hover:bg-green-50 dark:border-green-700 dark:text-green-400 dark:hover:bg-green-900/20"
            >
              Réactiver
            </button>
          )}
        </div>
      </div>

      <div className="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {/* Live Stats (subscription-based) */}
        {live && (
          <div className="lg:col-span-3 grid grid-cols-2 gap-4 sm:grid-cols-4">
            {[
              { label: "Plan actif",        value: live.plan_name ?? "—" },
              { label: "Statut abonnement", value: live.subscription_status ?? "—" },
              { label: "Jours restants",    value: live.days_remaining ?? 0 },
              {
                label: "Total encaissé",
                value: `${Math.round(live.total_paid ?? 0).toLocaleString("fr-FR")} FCFA`,
              },
            ].map((stat) => (
              <div
                key={stat.label}
                className="rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03]"
              >
                <p className="text-xs text-gray-500 dark:text-gray-400">{stat.label}</p>
                <p className="mt-1 text-2xl font-bold text-gray-800 dark:text-white/90">
                  {stat.value}
                </p>
              </div>
            ))}
          </div>
        )}

        {/* ── Info panel ── */}
        <div className="lg:col-span-3 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div className="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-5 py-4">
            <h3 className="font-semibold text-gray-700 dark:text-gray-200">Informations du restaurant</h3>
            <div className="flex items-center gap-3">
              {infoMsg && (
                <span className={`text-xs px-3 py-1 rounded-full ${
                  infoMsg.startsWith("Erreur")
                    ? "bg-red-50 text-red-600"
                    : "bg-green-50 text-green-700"
                }`}>
                  {infoMsg}
                </span>
              )}
              <button
                onClick={handleInfoSave}
                disabled={infoSaving}
                className="rounded-lg bg-[#37a000] px-4 py-1.5 text-sm font-medium text-white hover:bg-[#2d8600] disabled:opacity-60"
              >
                {infoSaving ? "Enregistrement…" : "Sauvegarder"}
              </button>
            </div>
          </div>

          <div className="px-5 py-4">
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
              {[
                { label: "Nom du restaurant *", key: "business_name", type: "text" },
                { label: "Email *",             key: "email",         type: "email" },
                { label: "Téléphone",           key: "phone",         type: "text" },
                { label: "Pays",                key: "country",       type: "text" },
                { label: "Ville",               key: "city",          type: "text" },
                { label: "Adresse",             key: "address",       type: "text" },
                { label: "Site web",            key: "website",       type: "url"  },
              ].map(({ label, key, type }) => (
                <div key={key} className={key === "business_name" || key === "address" ? "sm:col-span-2" : ""}>
                  <label className="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{label}</label>
                  <input
                    type={type}
                    value={(infoForm[key as keyof typeof infoForm] as string) ?? ""}
                    onChange={(e) => setInfoForm((f) => ({ ...f, [key]: e.target.value }))}
                    className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#37a000] dark:border-gray-700 dark:bg-white/5 dark:text-gray-300"
                  />
                </div>
              ))}
              <div className="sm:col-span-2">
                <label className="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Notes internes</label>
                <textarea
                  value={(infoForm.notes as string) ?? ""}
                  onChange={(e) => setInfoForm((f) => ({ ...f, notes: e.target.value }))}
                  rows={3}
                  className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#37a000] dark:border-gray-700 dark:bg-white/5 dark:text-gray-300 resize-none"
                />
              </div>
            </div>
          </div>
        </div>

        {/* Subscription panel */}
        <div className="lg:col-span-1 rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
          <h3 className="mb-4 font-semibold text-gray-700 dark:text-gray-200">Abonnement</h3>

          {sub ? (
            <dl className="mb-4 space-y-2 text-sm">
              <div className="flex justify-between">
                <dt className="text-gray-500">Plan</dt>
                <dd className="font-medium text-gray-800 dark:text-white/80">{sub.plan_name}</dd>
              </div>
              <div className="flex justify-between">
                <dt className="text-gray-500">Début</dt>
                <dd className="text-gray-700 dark:text-gray-300">
                  {new Date(sub.start_date).toLocaleDateString("fr-FR")}
                </dd>
              </div>
              <div className="flex justify-between">
                <dt className="text-gray-500">Fin</dt>
                <dd className="text-gray-700 dark:text-gray-300">
                  {new Date(sub.end_date).toLocaleDateString("fr-FR")}
                </dd>
              </div>
              <div className="flex justify-between">
                <dt className="text-gray-500">Grâce jusqu'au</dt>
                <dd className="text-gray-700 dark:text-gray-300">
                  {new Date(sub.grace_end_date).toLocaleDateString("fr-FR")}
                </dd>
              </div>
            </dl>
          ) : (
            <p className="mb-4 text-sm text-gray-400">Aucun abonnement actif.</p>
          )}

          <div className="space-y-3">
            <div>
              <label className="mb-1 block text-xs font-medium text-gray-500">Plan</label>
              <select
                value={planId}
                onChange={(e) => setPlanId(Number(e.target.value))}
                className="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 dark:border-gray-700 dark:bg-white/5 dark:text-gray-300"
              >
                <option value={0}>-- Choisir --</option>
                {plans.map((p) => (
                  <option key={p.plan_id} value={p.plan_id}>
                    {p.plan_name}
                  </option>
                ))}
              </select>
            </div>
            <div>
              <label className="mb-1 block text-xs font-medium text-gray-500">
                Date d'expiration
              </label>
              <input
                type="date"
                value={endDate}
                onChange={(e) => setEndDate(e.target.value)}
                className="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700 dark:border-gray-700 dark:bg-white/5 dark:text-gray-300"
              />
            </div>
            <button
              onClick={handleUpdateSub}
              disabled={saving || !planId || !endDate}
              className="w-full rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 disabled:opacity-50"
            >
              {saving ? "Enregistrement…" : "Appliquer le plan"}
            </button>

            {saveMsg && (
              <p className={`mt-2 text-xs rounded-lg px-3 py-2 ${
                saveMsg.startsWith("Erreur")
                  ? "bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400"
                  : "bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400"
              }`}>
                {saveMsg}
              </p>
            )}
          </div>
        </div>

        {/* Activity log */}
        <div className="lg:col-span-2 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div className="border-b border-gray-100 px-5 py-4 dark:border-gray-800">
            <h3 className="font-semibold text-gray-700 dark:text-gray-200">
              Activité récente
            </h3>
          </div>
          <div className="overflow-x-auto">
            <Table>
              <TableHeader className="border-b border-gray-100 dark:border-gray-800">
                <TableRow>
                  <TableCell isHeader className="py-3 px-5 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Date
                  </TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Action
                  </TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                    Détails
                  </TableCell>
                </TableRow>
              </TableHeader>
              <TableBody className="divide-y divide-gray-100 dark:divide-gray-800">
                {activity.map((log) => (
                  <TableRow key={log.log_id}>
                    <TableCell className="py-3 px-5 text-xs text-gray-400 whitespace-nowrap">
                      {new Date(log.created_at).toLocaleString("fr-FR", {
                        day: "2-digit",
                        month: "2-digit",
                        hour: "2-digit",
                        minute: "2-digit",
                      })}
                    </TableCell>
                    <TableCell className="py-3 text-sm font-medium text-gray-700 dark:text-gray-200">
                      {log.action}
                    </TableCell>
                    <TableCell className="py-3 text-sm text-gray-500 dark:text-gray-400">
                      {log.description}
                    </TableCell>
                  </TableRow>
                ))}
                {activity.length === 0 && (
                  <TableRow>
                    <TableCell className="py-6 text-center text-gray-400">
                      Aucune activité.
                    </TableCell>
                  </TableRow>
                )}
              </TableBody>
            </Table>
          </div>
        </div>

        {/* ── Factures ── */}
        <div className="lg:col-span-3 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div className="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-5 py-4">
            <h3 className="font-semibold text-gray-700 dark:text-gray-200">
              Factures
              {invoices.length > 0 && (
                <span className="ml-2 text-xs font-normal text-gray-400">({invoices.length})</span>
              )}
            </h3>
            <button
              onClick={() => setShowCreateInv(true)}
              className="rounded-lg bg-[#37a000] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#2d8600]"
            >
              + Nouvelle facture
            </button>
          </div>

          {invoices.length === 0 ? (
            <div className="py-10 text-center text-gray-400 text-sm">Aucune facture pour ce client.</div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full text-sm">
                <thead>
                  <tr className="border-b border-gray-100 dark:border-gray-800 text-left">
                    {["Numéro", "Montant", "Période", "Statut", "Méthode", ""].map((h) => (
                      <th key={h} className="px-5 py-3 text-xs font-medium text-gray-500">{h}</th>
                    ))}
                  </tr>
                </thead>
                <tbody className="divide-y divide-gray-100 dark:divide-gray-800">
                  {invoices.map((inv) => (
                    <tr key={inv.invoice_id} className="hover:bg-gray-50 dark:hover:bg-white/5">
                      <td className="px-5 py-3 font-mono text-xs text-gray-500">{inv.invoice_number}</td>
                      <td className="px-5 py-3 font-semibold text-gray-800 dark:text-white">{fmt(inv.amount)}</td>
                      <td className="px-5 py-3 text-xs text-gray-400">
                        {inv.period_start && inv.period_end
                          ? `${new Date(inv.period_start).toLocaleDateString("fr-FR")} → ${new Date(inv.period_end).toLocaleDateString("fr-FR")}`
                          : "—"}
                      </td>
                      <td className="px-5 py-3">
                        <span className={`text-xs font-semibold ${STATUS_COLOR[inv.status] ?? "text-gray-400"}`}>
                          {STATUS_LABEL[inv.status] ?? inv.status}
                        </span>
                      </td>
                      <td className="px-5 py-3 text-xs text-gray-400">
                        {inv.payment_method ? inv.payment_method.toUpperCase() : "—"}
                      </td>
                      <td className="px-5 py-3">
                        {inv.status !== "paid" && inv.status !== "cancelled" && (
                          <button
                            onClick={() => setConfirmInv(inv)}
                            className="text-xs font-medium text-[#37a000] hover:underline"
                          >
                            Confirmer
                          </button>
                        )}
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>

      </div>

      {showCreateInv && client && (
        <CreateInvoiceModal
          clients={[client]}
          plans={plans}
          tenantId={client.client_id}
          onCreated={(inv) => { setInvoices((p) => [inv, ...p]); setShowCreateInv(false); }}
          onClose={() => setShowCreateInv(false)}
        />
      )}

      {confirmInv && (
        <ConfirmPaymentModal
          invoice={confirmInv}
          onConfirmed={(updated) => {
            setInvoices((p) => p.map((i) => i.invoice_id === updated.invoice_id ? updated : i));
            setConfirmInv(null);
          }}
          onClose={() => setConfirmInv(null)}
        />
      )}
    </>
  );
}
