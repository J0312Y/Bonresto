import { useState } from "react";
import { confirmPayment } from "../../services/api";
import type { Invoice } from "../../types/saas";

const METHODS = [
  { value: "mtn",      label: "MTN MoMo",     icon: "📱" },
  { value: "airtel",   label: "Airtel Money",  icon: "📲" },
  { value: "virement", label: "Virement bancaire", icon: "🏦" },
  { value: "especes",  label: "Espèces",       icon: "💵" },
  { value: "autre",    label: "Autre",         icon: "💳" },
];

const fmt = (n: number) => `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

interface Props {
  invoice: Invoice;
  onConfirmed: (updated: Invoice) => void;
  onClose: () => void;
}

export function ConfirmPaymentModal({ invoice, onConfirmed, onClose }: Props) {
  const [method, setMethod] = useState("mtn");
  const [saving, setSaving] = useState(false);
  const [err, setErr]       = useState<string | null>(null);

  async function submit() {
    setSaving(true);
    setErr(null);
    try {
      const updated = await confirmPayment(invoice.invoice_id, method);
      onConfirmed(updated);
    } catch (ex: unknown) {
      setErr(ex instanceof Error ? ex.message : "Erreur.");
    } finally {
      setSaving(false);
    }
  }

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
      <div className="w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-xl">

        {/* Header */}
        <div className="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 px-6 py-4">
          <h3 className="text-lg font-bold text-gray-800 dark:text-white">Confirmer le paiement</h3>
          <button onClick={onClose} className="text-gray-400 hover:text-gray-600 text-xl font-bold">×</button>
        </div>

        <div className="px-6 py-5 space-y-5">
          {/* Invoice recap */}
          <div className="rounded-xl bg-gray-50 dark:bg-gray-800 px-4 py-3 space-y-1.5 text-sm">
            <div className="flex justify-between">
              <span className="text-gray-500">Facture</span>
              <span className="font-mono font-semibold text-gray-800 dark:text-white">{invoice.invoice_number}</span>
            </div>
            <div className="flex justify-between">
              <span className="text-gray-500">Client</span>
              <span className="font-medium text-gray-700 dark:text-gray-200">{invoice.business_name}</span>
            </div>
            <div className="flex justify-between">
              <span className="text-gray-500">Montant</span>
              <span className="font-bold text-[#37a000] text-base">{fmt(invoice.amount)}</span>
            </div>
            {invoice.plan_name && (
              <div className="flex justify-between">
                <span className="text-gray-500">Plan</span>
                <span className="text-gray-700 dark:text-gray-300">{invoice.plan_name}</span>
              </div>
            )}
          </div>

          {/* Payment method */}
          <div>
            <p className="text-xs font-medium text-gray-500 mb-3">Méthode de paiement reçue</p>
            <div className="grid grid-cols-2 gap-2 sm:grid-cols-3">
              {METHODS.map((m) => (
                <button
                  key={m.value}
                  type="button"
                  onClick={() => setMethod(m.value)}
                  className={`flex flex-col items-center gap-1.5 rounded-xl border-2 px-3 py-3 text-sm font-medium transition-colors ${
                    method === m.value
                      ? "border-[#37a000] bg-green-50 text-[#37a000] dark:bg-green-900/20"
                      : "border-gray-200 text-gray-600 hover:border-gray-300 dark:border-gray-700 dark:text-gray-400"
                  }`}
                >
                  <span className="text-xl">{m.icon}</span>
                  <span className="text-xs text-center leading-tight">{m.label}</span>
                </button>
              ))}
            </div>
          </div>

          {err && <div className="rounded-lg bg-red-50 px-4 py-2.5 text-sm text-red-600">{err}</div>}

          <div className="flex gap-3">
            <button
              onClick={submit}
              disabled={saving}
              className="flex-1 rounded-lg bg-[#37a000] py-2.5 text-sm font-semibold text-white hover:bg-[#2d8600] disabled:opacity-60"
            >
              {saving ? "Confirmation..." : "✓ Confirmer le paiement"}
            </button>
            <button onClick={onClose}
              className="rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300">
              Annuler
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
