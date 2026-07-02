import { useState } from "react";
import { createInvoice } from "../../services/api";
import type { Client, Invoice, Plan } from "../../types/saas";

interface Props {
  clients: Client[];
  plans: Plan[];
  tenantId?: number; // pre-fill when opened from client detail
  onCreated: (inv: Invoice) => void;
  onClose: () => void;
}

export function CreateInvoiceModal({ clients, plans, tenantId, onCreated, onClose }: Props) {
  const [form, setForm] = useState({
    tenant_id:    tenantId ?? 0,
    plan_id:      0,
    amount:       "",
    period_start: "",
    period_end:   "",
    notes:        "",
  });
  const [saving, setSaving] = useState(false);
  const [err, setErr]       = useState<string | null>(null);

  function handle(e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) {
    setForm((f) => ({ ...f, [e.target.name]: e.target.value }));
  }

  // Auto-fill amount when plan is selected
  function handlePlanChange(e: React.ChangeEvent<HTMLSelectElement>) {
    const planId = Number(e.target.value);
    const plan   = plans.find((p) => p.plan_id === planId);
    setForm((f) => ({ ...f, plan_id: planId, amount: plan ? String(plan.price) : f.amount }));
  }

  async function submit(e: React.FormEvent) {
    e.preventDefault();
    if (!form.tenant_id || !form.amount) { setErr("Client et montant requis."); return; }
    setSaving(true);
    setErr(null);
    try {
      const inv = await createInvoice({
        tenant_id:    Number(form.tenant_id),
        plan_id:      form.plan_id || null,
        amount:       Number(form.amount),
        period_start: form.period_start || undefined,
        period_end:   form.period_end   || undefined,
        notes:        form.notes        || undefined,
      });
      onCreated(inv);
    } catch (ex: unknown) {
      setErr(ex instanceof Error ? ex.message : "Erreur.");
    } finally {
      setSaving(false);
    }
  }

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
      <div className="w-full max-w-lg rounded-2xl bg-white bg-gray-900 shadow-xl">
        {/* Header */}
        <div className="flex items-center justify-between border-b border-gray-100 border-gray-800 px-6 py-4">
          <h3 className="text-lg font-bold text-gray-800 text-white">Nouvelle facture</h3>
          <button onClick={onClose} className="text-gray-400 hover:text-gray-600 text-xl font-bold">×</button>
        </div>

        <form onSubmit={submit} className="px-6 py-5 space-y-4">
          {err && <div className="rounded-lg bg-red-50 px-4 py-2.5 text-sm text-red-600">{err}</div>}

          {/* Client */}
          {!tenantId && (
            <div>
              <label className="block text-xs font-medium text-gray-500 mb-1">Client *</label>
              <select
                name="tenant_id"
                value={form.tenant_id}
                onChange={handle}
                required
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm border-gray-700 bg-gray-800 text-white"
              >
                <option value={0}>-- Choisir un client --</option>
                {clients.map((c) => (
                  <option key={c.client_id} value={c.client_id}>{c.business_name}</option>
                ))}
              </select>
            </div>
          )}

          {/* Plan */}
          <div>
            <label className="block text-xs font-medium text-gray-500 mb-1">Plan (optionnel)</label>
            <select
              name="plan_id"
              value={form.plan_id}
              onChange={handlePlanChange}
              className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm border-gray-700 bg-gray-800 text-white"
            >
              <option value={0}>-- Sans plan spécifique --</option>
              {plans.map((p) => (
                <option key={p.plan_id} value={p.plan_id}>{p.plan_name} — {Math.round(p.price).toLocaleString("fr-FR")} FCFA</option>
              ))}
            </select>
          </div>

          {/* Amount */}
          <div>
            <label className="block text-xs font-medium text-gray-500 mb-1">Montant (FCFA) *</label>
            <input
              type="number"
              name="amount"
              value={form.amount}
              onChange={handle}
              required
              min={0}
              placeholder="50000"
              className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm border-gray-700 bg-gray-800 text-white"
            />
          </div>

          {/* Period */}
          <div className="grid grid-cols-2 gap-3">
            <div>
              <label className="block text-xs font-medium text-gray-500 mb-1">Début de période</label>
              <input type="date" name="period_start" value={form.period_start} onChange={handle}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm border-gray-700 bg-gray-800 text-white" />
            </div>
            <div>
              <label className="block text-xs font-medium text-gray-500 mb-1">Fin de période</label>
              <input type="date" name="period_end" value={form.period_end} onChange={handle}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm border-gray-700 bg-gray-800 text-white" />
            </div>
          </div>

          {/* Notes */}
          <div>
            <label className="block text-xs font-medium text-gray-500 mb-1">Notes</label>
            <textarea
              name="notes"
              value={form.notes}
              onChange={handle}
              rows={2}
              placeholder="Renouvellement abonnement mensuel..."
              className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm resize-none border-gray-700 bg-gray-800 text-white"
            />
          </div>

          <div className="flex gap-3 pt-1">
            <button
              type="submit"
              disabled={saving}
              className="flex-1 rounded-lg bg-[#37a000] py-2.5 text-sm font-medium text-white hover:bg-[#2d8600] disabled:opacity-60"
            >
              {saving ? "Création..." : "Créer la facture"}
            </button>
            <button type="button" onClick={onClose}
              className="rounded-lg border border-gray-300 px-5 py-2.5 text-sm text-gray-600 hover:bg-gray-50 border-gray-700 text-gray-300">
              Annuler
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
