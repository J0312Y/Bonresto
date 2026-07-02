import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import { getTeam, createTeamMember, updateTeamMember, deleteTeamMember, getRoles } from "../../services/api";
import type { AdminAccount, SaasRole } from "../../types/saas";
import { useAuth } from "../../context/AuthContext";

const EMPTY_FORM = { name: "", email: "", password: "", role: "admin" };

export default function TeamPage() {
  const { admin: me } = useAuth();
  const isSuperAdmin  = (me as (typeof me & { role?: string }))?.role === "super_admin";

  const [members, setMembers]   = useState<AdminAccount[]>([]);
  const [roles, setRoles]       = useState<SaasRole[]>([]);
  const [loading, setLoading]   = useState(true);
  const [showForm, setShowForm] = useState(false);
  const [editing, setEditing]   = useState<AdminAccount | null>(null);
  const [form, setForm]         = useState(EMPTY_FORM);
  const [saving, setSaving]     = useState(false);
  const [msg, setMsg]           = useState<{ text: string; ok: boolean } | null>(null);

  useEffect(() => {
    Promise.all([getTeam(), getRoles()])
      .then(([members, roles]) => { setMembers(members); setRoles(roles); })
      .finally(() => setLoading(false));
  }, []);

  function roleLabel(name: string) {
    return roles.find((r) => r.name === name)?.label ?? name;
  }
  function roleColor(name: string) {
    return roles.find((r) => r.name === name)?.color ?? "bg-gray-100 text-gray-600";
  }

  function flash(text: string, ok = true) {
    setMsg({ text, ok });
    setTimeout(() => setMsg(null), 5000);
  }

  function openCreate() {
    setEditing(null);
    setForm(EMPTY_FORM);
    setShowForm(true);
  }

  function openEdit(m: AdminAccount) {
    setEditing(m);
    setForm({ name: m.name, email: m.email, password: "", role: m.role });
    setShowForm(true);
  }

  async function handleSave(e: React.FormEvent) {
    e.preventDefault();
    setSaving(true);
    try {
      if (editing) {
        const updated = await updateTeamMember(editing.admin_id, form);
        setMembers((prev) => prev.map((m) => m.admin_id === editing.admin_id ? updated as AdminAccount : m));
        flash(`Compte de ${updated.name} mis à jour.`);
      } else {
        const created = await createTeamMember(form as { name: string; email: string; password: string; role: string });
        setMembers((prev) => [created as AdminAccount, ...prev]);
        flash(`Compte de ${created.name} créé.`);
      }
      setShowForm(false);
    } catch (err: unknown) {
      flash(err instanceof Error ? err.message : "Erreur.", false);
    } finally {
      setSaving(false);
    }
  }

  async function handleDelete(m: AdminAccount) {
    if (!confirm(`Supprimer le compte de ${m.name} ?`)) return;
    try {
      await deleteTeamMember(m.admin_id);
      setMembers((prev) => prev.filter((x) => x.admin_id !== m.admin_id));
      flash(`Compte de ${m.name} supprimé.`);
    } catch (err: unknown) {
      flash(err instanceof Error ? err.message : "Erreur.", false);
    }
  }

  async function handleToggle(m: AdminAccount) {
    try {
      const updated = await updateTeamMember(m.admin_id, { is_active: m.is_active ? 0 : 1 });
      setMembers((prev) => prev.map((x) => x.admin_id === m.admin_id ? updated as AdminAccount : x));
      flash(`Compte ${updated.is_active ? "activé" : "désactivé"}.`);
    } catch (err: unknown) {
      flash(err instanceof Error ? err.message : "Erreur.", false);
    }
  }

  const initials = (name: string) => name.split(" ").map((w) => w[0]).join("").toUpperCase().slice(0, 2);
  const avatarBg = ["bg-blue-500","bg-purple-500","bg-green-600","bg-orange-500","bg-pink-500","bg-teal-500"];
  const colorFor = (id: number) => avatarBg[id % avatarBg.length];

  return (
    <>
      <PageMeta title="Équipe — Bonresto SaaS" description="" />

      <div className="mb-6 flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 text-white/90">Équipe</h2>
          <p className="text-sm text-gray-500">{members.length} compte{members.length !== 1 ? "s" : ""}</p>
        </div>
        {isSuperAdmin && (
          <button
            onClick={openCreate}
            className="inline-flex items-center gap-2 rounded-lg bg-[#37a000] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#2d8600]"
          >
            + Nouveau collaborateur
          </button>
        )}
      </div>

      {msg && (
        <div className={`mb-4 rounded-xl px-4 py-3 text-sm border ${msg.ok ? "bg-green-50 border-green-200 text-green-700" : "bg-red-50 border-red-200 text-red-700"}`}>
          {msg.text}
        </div>
      )}

      {!isSuperAdmin && (
        <div className="mb-4 rounded-xl bg-blue-50 border border-blue-200 px-4 py-3 text-sm text-blue-700 bg-blue-900/20 border-blue-800 text-blue-300">
          Seul le super administrateur peut gérer les comptes collaborateurs.
        </div>
      )}

      <div className="rounded-2xl border border-gray-200 bg-white border-gray-800 bg-white/[0.03] overflow-hidden">
        {loading ? (
          <div className="p-8 text-center text-gray-400">Chargement...</div>
        ) : (
          <table className="w-full text-sm">
            <thead>
              <tr className="border-b border-gray-100 border-gray-800 text-left">
                {["Collaborateur", "Rôle", "Statut", "Créé le", "Actions"].map((h) => (
                  <th key={h} className="px-5 py-3 text-xs font-medium text-gray-500 text-gray-400">{h}</th>
                ))}
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100 divide-gray-800">
              {members.map((m) => (
                <tr key={m.admin_id} className="hover:bg-gray-50 hover:bg-white/5">
                  <td className="px-5 py-3">
                    <div className="flex items-center gap-3">
                      <div className={`flex items-center justify-center w-8 h-8 rounded-full text-white text-xs font-bold flex-shrink-0 ${colorFor(m.admin_id)}`}>
                        {initials(m.name)}
                      </div>
                      <div>
                        <p className="font-medium text-gray-800 text-white">{m.name}</p>
                        <p className="text-xs text-gray-400">{m.email}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-5 py-3">
                    <span className={`px-2 py-0.5 rounded-full text-xs font-semibold ${roleColor(m.role)}`}>
                      {roleLabel(m.role)}
                    </span>
                  </td>
                  <td className="px-5 py-3">
                    <span className={`px-2 py-0.5 rounded-full text-xs font-medium ${m.is_active ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-500"}`}>
                      {m.is_active ? "Actif" : "Inactif"}
                    </span>
                  </td>
                  <td className="px-5 py-3 text-gray-400 text-xs">
                    {new Date(m.created_at).toLocaleDateString("fr-FR")}
                  </td>
                  <td className="px-5 py-3">
                    {isSuperAdmin && (
                      <div className="flex items-center gap-3">
                        <button onClick={() => openEdit(m)} className="text-xs text-blue-500 hover:underline">Modifier</button>
                        <button onClick={() => handleToggle(m)} className={`text-xs hover:underline ${m.is_active ? "text-orange-400" : "text-green-500"}`}>
                          {m.is_active ? "Désactiver" : "Activer"}
                        </button>
                        {m.role !== "super_admin" && (
                          <button onClick={() => handleDelete(m)} className="text-xs text-red-400 hover:underline">Supprimer</button>
                        )}
                      </div>
                    )}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        )}
      </div>

      {/* Modal */}
      {showForm && (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
          <div className="w-full max-w-md rounded-2xl bg-white bg-gray-900 shadow-xl">
            <div className="flex items-center justify-between px-6 py-4 border-b border-gray-100 border-gray-800">
              <h3 className="font-semibold text-gray-800 text-white">
                {editing ? "Modifier le collaborateur" : "Nouveau collaborateur"}
              </h3>
              <button onClick={() => setShowForm(false)} className="text-gray-400 hover:text-gray-600 text-xl leading-none">×</button>
            </div>
            <form onSubmit={handleSave} className="p-6 space-y-4">
              <div>
                <label className="block text-xs font-medium text-gray-500 mb-1.5">Nom complet</label>
                <input required type="text" value={form.name} onChange={(e) => setForm((p) => ({ ...p, name: e.target.value }))}
                  className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40" />
              </div>
              <div>
                <label className="block text-xs font-medium text-gray-500 mb-1.5">Email</label>
                <input required type="email" value={form.email} onChange={(e) => setForm((p) => ({ ...p, email: e.target.value }))}
                  className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40" />
              </div>
              <div>
                <label className="block text-xs font-medium text-gray-500 mb-1.5">
                  {editing ? "Nouveau mot de passe (laisser vide pour ne pas changer)" : "Mot de passe"}
                </label>
                <input type="password" value={form.password} required={!editing} minLength={editing ? 0 : 8}
                  onChange={(e) => setForm((p) => ({ ...p, password: e.target.value }))}
                  className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40" />
              </div>
              <div>
                <label className="block text-xs font-medium text-gray-500 mb-1.5">Rôle</label>
                <select value={form.role} onChange={(e) => setForm((p) => ({ ...p, role: e.target.value }))}
                  className="w-full rounded-lg border border-gray-300 border-gray-600 bg-white bg-gray-800 px-3 py-2 text-sm text-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-[#37a000]/40">
                  {roles.map((r) => (
                    <option key={r.name} value={r.name}>{r.label}</option>
                  ))}
                </select>
              </div>

              <div className="pt-2 flex gap-3 justify-end">
                <button type="button" onClick={() => setShowForm(false)}
                  className="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                  Annuler
                </button>
                <button type="submit" disabled={saving}
                  className="rounded-lg bg-[#37a000] px-5 py-2 text-sm font-semibold text-white hover:bg-[#2d8600] disabled:opacity-60">
                  {saving ? "Enregistrement..." : editing ? "Mettre à jour" : "Créer le compte"}
                </button>
              </div>
            </form>
          </div>
        </div>
      )}
    </>
  );
}
