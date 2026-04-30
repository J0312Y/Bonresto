import { useState } from "react";
import { useAuth } from "../context/AuthContext";
import PageMeta from "../components/common/PageMeta";
import { changePassword, updateProfile } from "../services/api";

export default function UserProfiles() {
  const { admin, updateAdmin } = useAuth();

  // ── Nom ───────────────────────────────────────────────────────────────────────
  const [nameForm, setNameForm]   = useState({ name: admin?.name ?? "" });
  const [nameSaving, setNameSaving] = useState(false);
  const [nameMsg, setNameMsg]     = useState<{ text: string; ok: boolean } | null>(null);

  async function handleNameSubmit(e: React.FormEvent) {
    e.preventDefault();
    if (!nameForm.name.trim()) return;
    setNameSaving(true);
    setNameMsg(null);
    try {
      const res = await updateProfile({ name: nameForm.name.trim() });
      updateAdmin({ name: res.name });
      setNameMsg({ text: "Nom mis à jour avec succès.", ok: true });
    } catch (err: unknown) {
      setNameMsg({ text: err instanceof Error ? err.message : "Erreur.", ok: false });
    } finally {
      setNameSaving(false);
    }
  }

  // ── Mot de passe ──────────────────────────────────────────────────────────────
  const [form, setForm] = useState({
    current_password:  "",
    new_password:      "",
    confirm_password:  "",
  });
  const [saving, setSaving]   = useState(false);
  const [msg, setMsg]         = useState<{ text: string; ok: boolean } | null>(null);
  const [showPwd, setShowPwd] = useState(false);

  function set(k: keyof typeof form, v: string) {
    setForm((p) => ({ ...p, [k]: v }));
  }

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setSaving(true);
    setMsg(null);
    try {
      await changePassword(form);
      setMsg({ text: "Mot de passe modifié avec succès.", ok: true });
      setForm({ current_password: "", new_password: "", confirm_password: "" });
    } catch (err: unknown) {
      setMsg({ text: err instanceof Error ? err.message : "Erreur.", ok: false });
    } finally {
      setSaving(false);
    }
  }

  const initials = admin?.name?.split(" ").map((w) => w[0]).join("").toUpperCase().slice(0, 2) ?? "AD";

  return (
    <>
      <PageMeta title="Mon profil — Bonresto SaaS" description="" />

      <div className="max-w-2xl mx-auto space-y-6">

        {/* Identity card */}
        <div className="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-6 flex items-center gap-5">
          <div className="flex items-center justify-center w-16 h-16 rounded-full bg-[#37a000] text-white text-2xl font-bold flex-shrink-0">
            {initials}
          </div>
          <div>
            <p className="text-lg font-bold text-gray-800 dark:text-white">{admin?.name}</p>
            <p className="text-sm text-gray-500">{admin?.email}</p>
            <span className="mt-1 inline-block text-xs font-medium text-[#37a000] bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded-full">
              Administrateur SaaS
            </span>
          </div>
        </div>

        {/* Name edit */}
        <div className="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 className="font-semibold text-gray-800 dark:text-white">Modifier le nom</h3>
            <p className="text-xs text-gray-400 mt-0.5">Nom affiché dans la barre latérale et le profil</p>
          </div>
          <form onSubmit={handleNameSubmit} className="p-6 space-y-4">
            {nameMsg && (
              <div className={`rounded-xl px-4 py-3 text-sm border ${
                nameMsg.ok
                  ? "bg-green-50 border-green-200 text-green-700"
                  : "bg-red-50 border-red-200 text-red-700"
              }`}>
                {nameMsg.text}
              </div>
            )}
            <div>
              <label className="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">Nom complet</label>
              <input
                type="text"
                required
                value={nameForm.name}
                onChange={(e) => setNameForm({ name: e.target.value })}
                className="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
                placeholder="Votre nom complet"
              />
            </div>
            <div className="flex justify-end pt-1">
              <button
                type="submit"
                disabled={nameSaving}
                className="rounded-xl bg-[#37a000] px-5 py-2 text-sm font-semibold text-white hover:bg-[#2d8600] disabled:opacity-60 transition-colors"
              >
                {nameSaving ? "Enregistrement..." : "Enregistrer le nom"}
              </button>
            </div>
          </form>
        </div>

        {/* Password change */}
        <div className="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <h3 className="font-semibold text-gray-800 dark:text-white">Changer le mot de passe</h3>
            <p className="text-xs text-gray-400 mt-0.5">Minimum 8 caractères</p>
          </div>

          <form onSubmit={handleSubmit} className="p-6 space-y-4">
            {msg && (
              <div className={`rounded-xl px-4 py-3 text-sm border ${
                msg.ok
                  ? "bg-green-50 border-green-200 text-green-700"
                  : "bg-red-50 border-red-200 text-red-700"
              }`}>
                {msg.text}
              </div>
            )}

            <div>
              <label className="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">
                Mot de passe actuel
              </label>
              <input
                type={showPwd ? "text" : "password"}
                value={form.current_password}
                onChange={(e) => set("current_password", e.target.value)}
                required
                autoComplete="current-password"
                className="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">
                Nouveau mot de passe
              </label>
              <input
                type={showPwd ? "text" : "password"}
                value={form.new_password}
                onChange={(e) => set("new_password", e.target.value)}
                required
                minLength={8}
                autoComplete="new-password"
                className="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div>
              <label className="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">
                Confirmer le nouveau mot de passe
              </label>
              <input
                type={showPwd ? "text" : "password"}
                value={form.confirm_password}
                onChange={(e) => set("confirm_password", e.target.value)}
                required
                autoComplete="new-password"
                className="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
              />
            </div>

            <div className="flex items-center justify-between pt-2">
              <label className="flex items-center gap-2 text-xs text-gray-500 cursor-pointer select-none">
                <input
                  type="checkbox"
                  checked={showPwd}
                  onChange={(e) => setShowPwd(e.target.checked)}
                  className="accent-[#37a000]"
                />
                Afficher les mots de passe
              </label>
              <button
                type="submit"
                disabled={saving}
                className="rounded-xl bg-[#37a000] px-5 py-2 text-sm font-semibold text-white hover:bg-[#2d8600] disabled:opacity-60 transition-colors"
              >
                {saving ? "Enregistrement..." : "Modifier le mot de passe"}
              </button>
            </div>
          </form>
        </div>

      </div>
    </>
  );
}
