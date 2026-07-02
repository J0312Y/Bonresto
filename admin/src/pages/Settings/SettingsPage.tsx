import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import { getSettings, saveSettings, testSmtp, runCron } from "../../services/api";

type Settings = Record<string, string>;

const SMTP_PROTOCOLS = ["smtp", "sendmail", "mail"];
const SMTP_CRYPTOS   = ["tls", "ssl", ""];

export default function SettingsPage() {
  const [settings, setSettings]   = useState<Settings>({});
  const [loading, setLoading]     = useState(true);
  const [saving, setSaving]       = useState(false);
  const [testing, setTesting]     = useState(false);
  const [msg, setMsg]             = useState<{ text: string; ok: boolean } | null>(null);
  const [showPass, setShowPass]   = useState(false);
  const [cronRunning, setCronRunning] = useState(false);
  const [cronResult, setCronResult]   = useState<string | null>(null);

  useEffect(() => {
    getSettings()
      .then(setSettings)
      .finally(() => setLoading(false));
  }, []);

  function set(key: string, value: string) {
    setSettings((prev) => ({ ...prev, [key]: value }));
  }

  function flash(text: string, ok = true) {
    setMsg({ text, ok });
    setTimeout(() => setMsg(null), 5000);
  }

  async function handleSave(e: React.FormEvent) {
    e.preventDefault();
    setSaving(true);
    try {
      await saveSettings(settings);
      flash("Paramètres enregistrés avec succès.");
    } catch (err: unknown) {
      flash(err instanceof Error ? err.message : "Erreur lors de la sauvegarde.", false);
    } finally {
      setSaving(false);
    }
  }

  async function handleTest() {
    setTesting(true);
    try {
      const res = await testSmtp();
      flash(`Email de test envoyé à ${res.sent_to} — SMTP opérationnel !`);
    } catch (err: unknown) {
      flash(err instanceof Error ? err.message : "Échec du test SMTP.", false);
    } finally {
      setTesting(false);
    }
  }

  if (loading) {
    return <div className="p-8 text-gray-400">Chargement...</div>;
  }

  return (
    <>
      <PageMeta title="Paramètres — Bonresto SaaS" description="" />

      <div className="mb-6">
        <h2 className="text-2xl font-bold text-gray-800 text-white/90">Paramètres</h2>
        <p className="text-sm text-gray-500">Configuration SMTP et informations de la société</p>
      </div>

      {msg && (
        <div className={`mb-5 rounded-xl px-4 py-3 text-sm border ${
          msg.ok
            ? "bg-green-50 border-green-200 text-green-700"
            : "bg-red-50 border-red-200 text-red-700"
        }`}>
          {msg.text}
        </div>
      )}

      <form onSubmit={handleSave} className="space-y-6">

        {/* ── SMTP ── */}
        <div className="rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03] overflow-hidden">
          <div className="flex items-center justify-between px-6 py-4 border-b border-gray-100 border-gray-800">
            <div>
              <h3 className="font-semibold text-gray-800 text-white">Configuration SMTP</h3>
              <p className="text-xs text-gray-400 mt-0.5">Utilisé pour envoyer les factures, confirmations et rappels</p>
            </div>
            <button
              type="button"
              onClick={handleTest}
              disabled={testing}
              className="inline-flex items-center gap-2 rounded-lg border border-gray-300 border-gray-600 px-3 py-1.5 text-xs font-medium text-gray-600 text-gray-300 hover:bg-gray-50 hover:bg-white/5 disabled:opacity-40 transition-colors"
            >
              {testing ? "Envoi..." : "Tester le SMTP"}
            </button>
          </div>

          <div className="p-6 grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Protocole</label>
              <select
                value={settings.smtp_protocol ?? "smtp"}
                onChange={(e) => set("smtp_protocol", e.target.value)}
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              >
                {SMTP_PROTOCOLS.map((p) => <option key={p} value={p}>{p || "—"}</option>)}
              </select>
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Chiffrement</label>
              <select
                value={settings.smtp_crypto ?? "tls"}
                onChange={(e) => set("smtp_crypto", e.target.value)}
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              >
                {SMTP_CRYPTOS.map((c) => <option key={c} value={c}>{c || "Aucun"}</option>)}
              </select>
            </div>

            <div className="sm:col-span-2">
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Serveur SMTP (host)</label>
              <input
                type="text"
                value={settings.smtp_host ?? ""}
                onChange={(e) => set("smtp_host", e.target.value)}
                placeholder="smtp.gmail.com"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Port</label>
              <input
                type="number"
                value={settings.smtp_port ?? "587"}
                onChange={(e) => set("smtp_port", e.target.value)}
                placeholder="587"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
              <p className="mt-1 text-[11px] text-gray-400">587 (TLS) · 465 (SSL) · 25 (sans chiffrement)</p>
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Email expéditeur</label>
              <input
                type="email"
                value={settings.from_email ?? ""}
                onChange={(e) => set("from_email", e.target.value)}
                placeholder="noreply@bonresto.com"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Nom expéditeur</label>
              <input
                type="text"
                value={settings.from_name ?? ""}
                onChange={(e) => set("from_name", e.target.value)}
                placeholder="Bonresto SaaS"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Nom d'utilisateur SMTP</label>
              <input
                type="text"
                value={settings.smtp_user ?? ""}
                onChange={(e) => set("smtp_user", e.target.value)}
                placeholder="votre@email.com"
                autoComplete="username"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Mot de passe SMTP</label>
              <div className="relative">
                <input
                  type={showPass ? "text" : "password"}
                  value={settings.smtp_pass ?? ""}
                  onChange={(e) => set("smtp_pass", e.target.value)}
                  placeholder="Laisser vide pour ne pas modifier"
                  autoComplete="new-password"
                  className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 pr-20 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
                />
                <button
                  type="button"
                  onClick={() => setShowPass((v) => !v)}
                  className="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 hover:text-gray-600"
                >
                  {showPass ? "Masquer" : "Afficher"}
                </button>
              </div>
              <p className="mt-1 text-[11px] text-gray-400">Pour Gmail : utilisez un mot de passe d'application (pas votre mot de passe principal)</p>
            </div>

          </div>
        </div>

        {/* ── Société ── */}
        <div className="rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03] overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-100 border-gray-800">
            <h3 className="font-semibold text-gray-800 text-white">Informations société</h3>
            <p className="text-xs text-gray-400 mt-0.5">Apparaissent dans le pied de page des emails et sur les factures PDF</p>
          </div>

          <div className="p-6 grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Nom de la société</label>
              <input
                type="text"
                value={settings.company_name ?? ""}
                onChange={(e) => set("company_name", e.target.value)}
                placeholder="Bonresto"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Email de contact</label>
              <input
                type="email"
                value={settings.company_email ?? ""}
                onChange={(e) => set("company_email", e.target.value)}
                placeholder="contact@bonresto.com"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Téléphone</label>
              <input
                type="text"
                value={settings.company_phone ?? ""}
                onChange={(e) => set("company_phone", e.target.value)}
                placeholder="+225 00 00 00 00"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Site web</label>
              <input
                type="url"
                value={settings.company_website ?? ""}
                onChange={(e) => set("company_website", e.target.value)}
                placeholder="https://bonresto.com"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div className="sm:col-span-2">
              <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Adresse</label>
              <input
                type="text"
                value={settings.company_address ?? ""}
                onChange={(e) => set("company_address", e.target.value)}
                placeholder="Abidjan, Côte d'Ivoire"
                className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

          </div>
        </div>

        {/* ── Cron ── */}
        <div className="rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03] overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-100 border-gray-800">
            <h3 className="font-semibold text-gray-800 text-white">Tâches automatiques (Cron)</h3>
            <p className="text-xs text-gray-400 mt-0.5">Rappels d'expiration J-7 et J-1 · Suspension automatique des abonnements expirés</p>
          </div>
          <div className="p-6 space-y-5">

            {/* Schedule picker */}
            <div className="flex items-end gap-4 flex-wrap">
              <div>
                <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Heure d'exécution</label>
                <select
                  value={settings.cron_hour ?? "8"}
                  onChange={(e) => set("cron_hour", e.target.value)}
                  className="rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
                >
                  {Array.from({ length: 24 }, (_, i) => (
                    <option key={i} value={String(i)}>{String(i).padStart(2, "0")}h00</option>
                  ))}
                </select>
              </div>
              <div>
                <label className="block text-xs font-medium text-gray-500 text-gray-400 mb-1.5">Minutes</label>
                <select
                  value={settings.cron_minute ?? "0"}
                  onChange={(e) => set("cron_minute", e.target.value)}
                  className="rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
                >
                  {["0","15","30","45"].map((m) => (
                    <option key={m} value={m}>:{m.padStart(2,"0")}</option>
                  ))}
                </select>
              </div>
              <p className="text-xs text-gray-400 pb-2">
                Exécution quotidienne à{" "}
                <strong className="text-gray-600 text-gray-300">
                  {String(settings.cron_hour ?? 8).padStart(2,"0")}h{String(settings.cron_minute ?? 0).padStart(2,"0")}
                </strong>
              </p>
            </div>

            {/* cPanel command */}
            <div className="rounded-xl bg-gray-50 bg-white/5 border border-gray-200 border-gray-700 p-4">
              <p className="text-xs font-medium text-gray-500 text-gray-400 mb-2">Commande à configurer dans cPanel → Cron Jobs :</p>
              <code className="block text-xs font-mono text-gray-700 text-gray-300 break-all select-all bg-white bg-gray-900 rounded p-2 border border-gray-200 border-gray-700">
                {`${settings.cron_minute ?? 0} ${settings.cron_hour ?? 8} * * * curl -s "${window.location.origin}/bonresto/index.php/saas/cron/run?key=${settings.saas_cron_key ?? "bonresto-cron-secret-2026"}"`}
              </code>
            </div>

            {cronResult && (
              <div className={`rounded-xl px-4 py-3 text-sm font-mono whitespace-pre-wrap border ${cronResult.startsWith("❌") ? "bg-red-50 border-red-200 text-red-700" : "bg-green-50 border-green-200 text-green-700"}`}>
                {cronResult}
              </div>
            )}

            <button
              type="button"
              onClick={async () => {
                setCronRunning(true);
                setCronResult(null);
                try {
                  const res = await runCron(settings.saas_cron_key ?? "bonresto-cron-secret-2026");
                  const r7  = res.reminders_7d as Record<string, number>;
                  const r1  = res.reminders_1d as Record<string, number>;
                  const sus = res.auto_suspend as Record<string, number>;
                  setCronResult(
                    `✅ Cron exécuté le ${res.ran_at}\n` +
                    `• Rappels J-7 : ${r7.sent} envoyés, ${r7.failed} échecs\n` +
                    `• Rappels J-1 : ${r1.sent} envoyés, ${r1.failed} échecs\n` +
                    `• Auto-suspendus : ${sus.suspended}`
                  );
                } catch (e: unknown) {
                  setCronResult("❌ " + (e instanceof Error ? e.message : "Erreur cron."));
                } finally {
                  setCronRunning(false);
                }
              }}
              disabled={cronRunning}
              className="inline-flex items-center gap-2 rounded-lg bg-[#2c3136] text-white px-4 py-2 text-sm font-medium hover:bg-[#33383e] disabled:opacity-40 transition-colors"
            >
              {cronRunning ? "⏳ Exécution..." : "▶ Lancer maintenant"}
            </button>
          </div>
        </div>

        {/* Save button */}
        <div className="flex justify-end pb-6">
          <button
            type="submit"
            disabled={saving}
            className="inline-flex items-center gap-2 rounded-xl bg-[#37a000] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#2d8600] disabled:opacity-60 transition-colors"
          >
            {saving ? "Enregistrement..." : "Enregistrer les paramètres"}
          </button>
        </div>

      </form>
    </>
  );
}
