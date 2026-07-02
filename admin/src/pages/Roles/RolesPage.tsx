import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import { getRoles, createRole, updateRole, deleteRole } from "../../services/api";
import type { SaasRole } from "../../types/saas";
import { useAuth } from "../../context/AuthContext";

// ── All permission keys grouped by section ─────────────────────────────────────
const PERM_GROUPS = [
  {
    group: "Tableau de bord",
    perms: [{ key: "dashboard.view", label: "Voir le tableau de bord" }],
  },
  {
    group: "Clients",
    perms: [
      { key: "clients.view",    label: "Voir les clients" },
      { key: "clients.create",  label: "Créer un client" },
      { key: "clients.edit",    label: "Modifier un client" },
      { key: "clients.suspend", label: "Suspendre / réactiver" },
      { key: "clients.delete",  label: "Supprimer un client" },
    ],
  },
  {
    group: "Plans",
    perms: [
      { key: "plans.view",   label: "Voir les plans" },
      { key: "plans.create", label: "Créer un plan" },
      { key: "plans.edit",   label: "Modifier un plan" },
      { key: "plans.delete", label: "Supprimer un plan" },
    ],
  },
  {
    group: "Licences",
    perms: [
      { key: "licenses.view",     label: "Voir les licences" },
      { key: "licenses.generate", label: "Générer une licence" },
      { key: "licenses.revoke",   label: "Révoquer une licence" },
    ],
  },
  {
    group: "Paiements",
    perms: [
      { key: "payments.view",   label: "Voir les paiements" },
      { key: "payments.record", label: "Enregistrer un paiement" },
    ],
  },
  {
    group: "Factures",
    perms: [
      { key: "invoices.view",    label: "Voir les factures" },
      { key: "invoices.create",  label: "Créer une facture" },
      { key: "invoices.confirm", label: "Confirmer le paiement" },
      { key: "invoices.send",    label: "Envoyer par email" },
      { key: "invoices.cancel",  label: "Annuler une facture" },
      { key: "invoices.pdf",     label: "Télécharger PDF" },
    ],
  },
  {
    group: "Activité & Rapports",
    perms: [
      { key: "activity.view", label: "Journal d'activité" },
      { key: "reports.view",  label: "Rapports" },
      { key: "notifications.view", label: "Notifications" },
    ],
  },
  {
    group: "Mises à jour",
    perms: [
      { key: "updates.view",    label: "Voir les mises à jour" },
      { key: "updates.create",  label: "Créer une mise à jour" },
      { key: "updates.publish", label: "Publier / archiver" },
    ],
  },
  {
    group: "Paramètres",
    perms: [
      { key: "settings.view", label: "Voir les paramètres" },
      { key: "settings.edit", label: "Modifier les paramètres" },
    ],
  },
  {
    group: "Équipe & Rôles",
    perms: [
      { key: "team.view",    label: "Voir l'équipe" },
      { key: "team.manage",  label: "Gérer l'équipe" },
      { key: "roles.view",   label: "Voir les rôles" },
      { key: "roles.manage", label: "Gérer les rôles" },
    ],
  },
];

const COLOR_OPTIONS = [
  { value: "bg-blue-100 text-blue-700 bg-blue-900/30 text-blue-300",       label: "Bleu" },
  { value: "bg-purple-100 text-purple-700 bg-purple-900/30 text-purple-300", label: "Violet" },
  { value: "bg-green-100 text-green-700 bg-green-900/30 text-green-300",   label: "Vert" },
  { value: "bg-orange-100 text-orange-700 bg-orange-900/30 text-orange-300", label: "Orange" },
  { value: "bg-red-100 text-red-700 bg-red-900/30 text-red-300",           label: "Rouge" },
  { value: "bg-teal-100 text-teal-700 bg-teal-900/30 text-teal-300",       label: "Teal" },
  { value: "bg-yellow-100 text-yellow-700 bg-yellow-900/30 text-yellow-300", label: "Jaune" },
  { value: "bg-pink-100 text-pink-700 bg-pink-900/30 text-pink-300",       label: "Rose" },
  { value: "bg-gray-100 text-gray-600 bg-gray-700 text-gray-300",          label: "Gris" },
];

const EMPTY_FORM = {
  name: "",
  label: "",
  color: COLOR_OPTIONS[0].value,
  permissions: [] as string[],
};

export default function RolesPage() {
  const { admin: me } = useAuth();
  const isSuperAdmin = (me as (typeof me & { role?: string }))?.role === "super_admin";

  const [roles, setRoles]     = useState<SaasRole[]>([]);
  const [loading, setLoading] = useState(true);
  const [showForm, setShowForm] = useState(false);
  const [editing, setEditing] = useState<SaasRole | null>(null);
  const [form, setForm]       = useState(EMPTY_FORM);
  const [saving, setSaving]   = useState(false);
  const [msg, setMsg]         = useState<{ text: string; ok: boolean } | null>(null);

  useEffect(() => {
    getRoles().then(setRoles).finally(() => setLoading(false));
  }, []);

  function flash(text: string, ok = true) {
    setMsg({ text, ok });
    setTimeout(() => setMsg(null), 5000);
  }

  function openCreate() {
    setEditing(null);
    setForm(EMPTY_FORM);
    setShowForm(true);
  }

  function openEdit(r: SaasRole) {
    setEditing(r);
    setForm({ name: r.name, label: r.label, color: r.color, permissions: [...r.permissions] });
    setShowForm(true);
  }

  function togglePerm(key: string, checked: boolean) {
    setForm((f) => ({
      ...f,
      permissions: checked
        ? [...f.permissions, key]
        : f.permissions.filter((p) => p !== key),
    }));
  }

  function toggleGroup(keys: string[], checked: boolean) {
    setForm((f) => {
      const next = new Set(f.permissions);
      keys.forEach((k) => (checked ? next.add(k) : next.delete(k)));
      return { ...f, permissions: Array.from(next) };
    });
  }

  async function handleSave(e: React.FormEvent) {
    e.preventDefault();
    setSaving(true);
    try {
      if (editing) {
        const updated = await updateRole(editing.role_id, {
          label: form.label,
          color: form.color,
          permissions: form.permissions,
        });
        setRoles((prev) => prev.map((r) => r.role_id === editing.role_id ? updated : r));
        flash(`Rôle "${updated.label}" mis à jour.`);
      } else {
        const created = await createRole(form);
        setRoles((prev) => [...prev, created]);
        flash(`Rôle "${created.label}" créé.`);
      }
      setShowForm(false);
    } catch (err: unknown) {
      flash(err instanceof Error ? err.message : "Erreur.", false);
    } finally {
      setSaving(false);
    }
  }

  async function handleDelete(r: SaasRole) {
    if (!confirm(`Supprimer le rôle "${r.label}" ? Les collaborateurs avec ce rôle seront rétrogradés en Lecteur.`)) return;
    try {
      await deleteRole(r.role_id);
      setRoles((prev) => prev.filter((x) => x.role_id !== r.role_id));
      flash(`Rôle "${r.label}" supprimé.`);
    } catch (err: unknown) {
      flash(err instanceof Error ? err.message : "Erreur.", false);
    }
  }

  const permCount = (r: SaasRole) =>
    r.permissions.includes("*") ? "Tout" : `${r.permissions.length} permissions`;

  return (
    <>
      <PageMeta title="Rôles — Bonresto SaaS" description="" />

      <div className="mb-6 flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 text-white/90">Rôles & Permissions</h2>
          <p className="text-sm text-gray-500">{roles.length} rôle{roles.length !== 1 ? "s" : ""}</p>
        </div>
        {isSuperAdmin && (
          <button
            onClick={openCreate}
            className="inline-flex items-center gap-2 rounded-lg bg-[#37a000] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#2d8600]"
          >
            + Nouveau rôle
          </button>
        )}
      </div>

      {msg && (
        <div className={`mb-4 rounded-xl px-4 py-3 text-sm border ${msg.ok ? "bg-green-50 border-green-200 text-green-700" : "bg-red-50 border-red-200 text-red-700"}`}>
          {msg.text}
        </div>
      )}

      {loading ? (
        <div className="p-8 text-center text-gray-400">Chargement...</div>
      ) : (
        <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
          {roles.map((r) => (
            <div key={r.role_id} className="rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03] p-5 flex flex-col gap-3">
              <div className="flex items-start justify-between">
                <div>
                  <span className={`px-2.5 py-1 rounded-full text-xs font-semibold ${r.color}`}>
                    {r.label}
                  </span>
                  <p className="mt-1.5 text-xs text-gray-400 font-mono">{r.name}</p>
                </div>
                {r.is_system ? (
                  <span className="text-[10px] font-medium text-gray-400 bg-gray-100 bg-gray-800 px-2 py-0.5 rounded-full">Système</span>
                ) : isSuperAdmin && (
                  <div className="flex gap-2">
                    <button onClick={() => openEdit(r)} className="text-xs text-blue-500 hover:underline">Modifier</button>
                    <button onClick={() => handleDelete(r)} className="text-xs text-red-400 hover:underline">Supprimer</button>
                  </div>
                )}
              </div>

              <div className="text-xs text-gray-500 font-medium">
                {r.permissions.includes("*") ? (
                  <span className="text-[#37a000]">Toutes les permissions (accès complet)</span>
                ) : (
                  <span>{permCount(r)}</span>
                )}
              </div>

              {!r.permissions.includes("*") && r.permissions.length > 0 && (
                <div className="flex flex-wrap gap-1">
                  {r.permissions.slice(0, 8).map((p) => (
                    <span key={p} className="px-1.5 py-0.5 rounded text-[10px] bg-gray-100 text-gray-600 bg-gray-800 text-gray-400 font-mono">
                      {p}
                    </span>
                  ))}
                  {r.permissions.length > 8 && (
                    <span className="px-1.5 py-0.5 rounded text-[10px] bg-gray-100 text-gray-500 bg-gray-800">
                      +{r.permissions.length - 8}
                    </span>
                  )}
                </div>
              )}

              {isSuperAdmin && r.is_system && (
                <button
                  onClick={() => openEdit(r)}
                  className="mt-auto text-xs text-gray-400 hover:text-blue-500 text-left hover:underline"
                >
                  Modifier le libellé / couleur →
                </button>
              )}
            </div>
          ))}
        </div>
      )}

      {/* ── Modal ─────────────────────────────────────────────────────────── */}
      {showForm && (
        <div className="fixed inset-0 z-50 flex items-start justify-center bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
          <div className="w-full max-w-2xl rounded-2xl bg-white bg-gray-900 shadow-xl my-8">
            <div className="flex items-center justify-between px-6 py-4 border-b border-gray-100 border-gray-800">
              <h3 className="font-semibold text-gray-800 text-white">
                {editing ? `Modifier "${editing.label}"` : "Nouveau rôle"}
              </h3>
              <button onClick={() => setShowForm(false)} className="text-gray-400 hover:text-gray-600 text-xl leading-none">×</button>
            </div>

            <form onSubmit={handleSave} className="p-6 space-y-5">
              {/* Base info */}
              <div className="grid grid-cols-1 gap-4 sm:grid-cols-3">
                {!editing && (
                  <div>
                    <label className="block text-xs font-medium text-gray-500 mb-1.5">
                      Nom interne (slug)
                    </label>
                    <input
                      required
                      type="text"
                      value={form.name}
                      onChange={(e) => setForm((f) => ({ ...f, name: e.target.value.toLowerCase().replace(/[^a-z0-9_]/g, "") }))}
                      placeholder="ex: billing"
                      className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40 font-mono"
                    />
                    <p className="mt-1 text-[10px] text-gray-400">Minuscules, chiffres et _ uniquement</p>
                  </div>
                )}
                <div className={editing ? "sm:col-span-2" : ""}>
                  <label className="block text-xs font-medium text-gray-500 mb-1.5">Libellé affiché</label>
                  <input
                    required
                    type="text"
                    value={form.label}
                    onChange={(e) => setForm((f) => ({ ...f, label: e.target.value }))}
                    placeholder="ex: Facturation"
                    className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
                  />
                </div>
                <div>
                  <label className="block text-xs font-medium text-gray-500 mb-1.5">Couleur du badge</label>
                  <select
                    value={form.color}
                    onChange={(e) => setForm((f) => ({ ...f, color: e.target.value }))}
                    className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40"
                  >
                    {COLOR_OPTIONS.map((c) => (
                      <option key={c.value} value={c.value}>{c.label}</option>
                    ))}
                  </select>
                  <div className="mt-1.5">
                    <span className={`px-2.5 py-0.5 rounded-full text-xs font-semibold ${form.color}`}>
                      {form.label || "Aperçu"}
                    </span>
                  </div>
                </div>
              </div>

              {/* Permissions — hidden for system roles */}
              {(!editing || !editing.is_system) && (
                <div>
                  <p className="text-sm font-semibold text-gray-700 text-gray-300 mb-3">
                    Permissions
                    <span className="ml-2 text-xs font-normal text-gray-400">
                      ({form.permissions.length} sélectionnée{form.permissions.length !== 1 ? "s" : ""})
                    </span>
                  </p>
                  <div className="space-y-4 max-h-96 overflow-y-auto pr-1">
                    {PERM_GROUPS.map((g) => {
                      const keys = g.perms.map((p) => p.key);
                      const allChecked = keys.every((k) => form.permissions.includes(k));
                      return (
                        <div key={g.group} className="rounded-xl border border-gray-100 border-gray-800 p-3">
                          <div className="flex items-center justify-between mb-2">
                            <p className="text-xs font-semibold uppercase tracking-wide text-gray-500">{g.group}</p>
                            <button
                              type="button"
                              onClick={() => toggleGroup(keys, !allChecked)}
                              className="text-xs text-[#37a000] hover:underline"
                            >
                              {allChecked ? "Tout décocher" : "Tout cocher"}
                            </button>
                          </div>
                          <div className="grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                            {g.perms.map((p) => {
                              const checked = form.permissions.includes(p.key);
                              return (
                                <label
                                  key={p.key}
                                  className={`flex items-center gap-2 rounded-lg px-3 py-1.5 cursor-pointer transition-colors ${
                                    checked ? "bg-green-50 bg-green-900/20" : "hover:bg-gray-50 hover:bg-white/[0.02]"
                                  }`}
                                >
                                  <input
                                    type="checkbox"
                                    checked={checked}
                                    onChange={(e) => togglePerm(p.key, e.target.checked)}
                                    className="accent-[#37a000] w-4 h-4 flex-shrink-0"
                                  />
                                  <div>
                                    <span className={`text-sm ${checked ? "text-gray-800 text-white/90 font-medium" : "text-gray-500 text-gray-400"}`}>
                                      {p.label}
                                    </span>
                                    <span className="ml-1.5 text-[10px] text-gray-400 font-mono">{p.key}</span>
                                  </div>
                                </label>
                              );
                            })}
                          </div>
                        </div>
                      );
                    })}
                  </div>
                </div>
              )}

              {editing?.is_system && (
                <div className="rounded-xl bg-blue-50 bg-blue-900/20 border border-blue-200 border-blue-800 px-4 py-3 text-sm text-blue-700 text-blue-300">
                  Les permissions des rôles système ne peuvent pas être modifiées. Seuls le libellé et la couleur sont éditables.
                </div>
              )}

              <div className="pt-2 flex gap-3 justify-end border-t border-gray-100 border-gray-800">
                <button
                  type="button"
                  onClick={() => setShowForm(false)}
                  className="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50"
                >
                  Annuler
                </button>
                <button
                  type="submit"
                  disabled={saving}
                  className="rounded-lg bg-[#37a000] px-5 py-2 text-sm font-semibold text-white hover:bg-[#2d8600] disabled:opacity-60"
                >
                  {saving ? "Enregistrement..." : editing ? "Mettre à jour" : "Créer le rôle"}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </>
  );
}
