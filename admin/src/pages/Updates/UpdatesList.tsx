import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import { getUpdates, getPlans, getClients, createUpdate, publishUpdate, archiveUpdate } from "../../services/api";
import type { SaasUpdate, Plan, Client } from "../../types/saas";
import Badge from "../../components/ui/badge/Badge";

// All modules matching PlanList
const ALL_MODULES = [
  { key: "ordermanage",    label: "Gestion commandes & POS" },
  { key: "itemmanage",     label: "Articles & catégories" },
  { key: "dashboard",      label: "Tableau de bord restaurant" },
  { key: "reservation",    label: "Réservations de tables" },
  { key: "qrapp",          label: "Commande & paiement QR Code" },
  { key: "kitchen_screen", label: "Écran cuisine (KDS)" },
  { key: "counter",        label: "Tableau comptoir" },
  { key: "purchase",       label: "Achats & fournisseurs" },
  { key: "production",     label: "Unités de production & recettes" },
  { key: "wastemangment",  label: "Gestion des déchets" },
  { key: "inventory",      label: "Inventaire avancé" },
  { key: "accounts",       label: "Comptabilité" },
  { key: "report",         label: "Rapports ventes & stocks" },
  { key: "cash_register",  label: "Gestion caisse" },
  { key: "online_payment", label: "Paiement en ligne" },
  { key: "hrm",            label: "Gestion RH & paie" },
  { key: "attendance",     label: "Présence & congés" },
  { key: "payroll",        label: "Paie & salaires" },
  { key: "whatsapp",       label: "Notifications WhatsApp" },
  { key: "sms_notif",      label: "Notifications SMS" },
  { key: "loyalty",        label: "Programme fidélité" },
  { key: "coupon",         label: "Coupons & promotions" },
  { key: "rating",         label: "Avis & notations" },
  { key: "multi_branch",   label: "Multi-établissements" },
  { key: "delivery",       label: "Gestion livraisons" },
  { key: "online_menu",    label: "Menu en ligne public" },
  { key: "api_access",     label: "Accès API externe" },
  { key: "white_label",    label: "Marque blanche" },
  { key: "core",           label: "Core system (application)" },
];

type FormState = {
  title: string;
  version: string;
  module: string;
  type: "config" | "code";
  target_type: "all" | "plan" | "tenant";
  target_id: string;
  changelog: string;
  config_json: string;
  files: { path: string; content_b64: string; filename: string }[];
};

const EMPTY_FORM: FormState = {
  title: "", version: "", module: "core", type: "config",
  target_type: "all", target_id: "", changelog: "",
  config_json: "{}", files: [],
};

function statusBadge(s: string): "success" | "warning" | "info" | "error" {
  return s === "published" ? "success" : s === "draft" ? "warning" : "error";
}

function typeBadge(t: string) {
  return t === "code"
    ? <span className="px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400">Code PHP</span>
    : <span className="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400">Config</span>;
}

export default function UpdatesList() {
  const [updates, setUpdates] = useState<SaasUpdate[]>([]);
  const [plans, setPlans]     = useState<Plan[]>([]);
  const [clients, setClients] = useState<Client[]>([]);
  const [loading, setLoading] = useState(true);
  const [showForm, setShowForm] = useState(false);
  const [form, setForm]       = useState<FormState>(EMPTY_FORM);
  const [saving, setSaving]   = useState(false);
  const [error, setError]     = useState<string | null>(null);

  useEffect(() => {
    Promise.all([getUpdates(), getPlans(), getClients()])
      .then(([u, p, c]) => { setUpdates(u); setPlans(p); setClients(c); })
      .finally(() => setLoading(false));
  }, []);

  // ── File upload (code update) ─────────────────────────────────────────────
  function handleFileUpload(e: React.ChangeEvent<HTMLInputElement>) {
    const files = Array.from(e.target.files ?? []);
    files.forEach((file) => {
      const reader = new FileReader();
      reader.onload = (ev) => {
        const b64 = (ev.target?.result as string).split(",")[1];
        setForm((f) => ({
          ...f,
          files: [
            ...f.files.filter((x) => x.filename !== file.name),
            { path: "", content_b64: b64, filename: file.name },
          ],
        }));
      };
      reader.readAsDataURL(file);
    });
    e.target.value = "";
  }

  function updateFilePath(filename: string, path: string) {
    setForm((f) => ({
      ...f,
      files: f.files.map((x) => x.filename === filename ? { ...x, path } : x),
    }));
  }

  function removeFile(filename: string) {
    setForm((f) => ({ ...f, files: f.files.filter((x) => x.filename !== filename) }));
  }

  // ── Submit ────────────────────────────────────────────────────────────────
  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setError(null);

    // Validate payload
    let payload: unknown;
    if (form.type === "config") {
      try { payload = JSON.parse(form.config_json); }
      catch { setError("Le JSON de configuration est invalide."); return; }
    } else {
      if (form.files.some((f) => !f.path.trim())) {
        setError("Chaque fichier doit avoir un chemin de déploiement (ex: application/modules/hrm/controllers/Hrm.php).");
        return;
      }
      payload = form.files.map((f) => ({ path: f.path.trim(), content_b64: f.content_b64 }));
    }

    setSaving(true);
    try {
      const created = await createUpdate({
        title:       form.title,
        version:     form.version,
        module:      form.module,
        type:        form.type,
        target_type: form.target_type,
        target_id:   form.target_id ? Number(form.target_id) : null,
        changelog:   form.changelog,
        payload,
      } as Partial<SaasUpdate>);
      setUpdates((u) => [{ ...created, delivery: { pending: 0, applied: 0, failed: 0 } }, ...u]);
      setShowForm(false);
      setForm(EMPTY_FORM);
    } catch (err: unknown) {
      setError(err instanceof Error ? err.message : "Erreur lors de la création.");
    } finally {
      setSaving(false);
    }
  }

  async function handlePublish(id: number) {
    try {
      await publishUpdate(id);
      setUpdates((u) => u.map((x) =>
        x.update_id === id ? { ...x, status: "published", published_at: new Date().toISOString() } : x
      ));
    } catch { alert("Impossible de publier cette mise à jour."); }
  }

  async function handleArchive(id: number) {
    if (!confirm("Archiver cette mise à jour ?")) return;
    try {
      await archiveUpdate(id);
      setUpdates((u) => u.map((x) => x.update_id === id ? { ...x, status: "archived" } : x));
    } catch { alert("Impossible d'archiver."); }
  }

  return (
    <>
      <PageMeta title="Mises à jour — Bonresto SaaS" description="" />

      <div className="mb-6 flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 dark:text-white/90">Mises à jour</h2>
          <p className="text-sm text-gray-500">Déployez des configs ou du code PHP sur vos clients</p>
        </div>
        <button
          onClick={() => { setShowForm(!showForm); setError(null); }}
          className="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
        >
          {showForm ? "Annuler" : "+ Nouvelle mise à jour"}
        </button>
      </div>

      {/* ── Create Form ─────────────────────────────────────────────────────── */}
      {showForm && (
        <form onSubmit={handleSubmit} className="mb-8 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] space-y-5">
          <h3 className="text-lg font-semibold text-gray-800 dark:text-white/90">Nouvelle mise à jour</h3>

          {error && (
            <div className="rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700 dark:bg-red-500/10 dark:text-red-400">
              {error}
            </div>
          )}

          {/* Row 1: title + version */}
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div className="lg:col-span-2">
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Titre</label>
              <input required value={form.title} onChange={(e) => setForm((f) => ({ ...f, title: e.target.value }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
                placeholder="Fix bug POS, Nouveau module HRM v2..." />
            </div>
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Version</label>
              <input required value={form.version} onChange={(e) => setForm((f) => ({ ...f, version: e.target.value }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
                placeholder="1.0.0" />
            </div>
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Type</label>
              <select value={form.type} onChange={(e) => setForm((f) => ({ ...f, type: e.target.value as "config" | "code" }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="config">Config (JSON)</option>
                <option value="code">Code PHP</option>
              </select>
            </div>
          </div>

          {/* Row 2: module + target */}
          <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Module concerné</label>
              <select value={form.module} onChange={(e) => setForm((f) => ({ ...f, module: e.target.value }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                {ALL_MODULES.map((m) => <option key={m.key} value={m.key}>{m.label}</option>)}
              </select>
            </div>
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Cible</label>
              <select value={form.target_type} onChange={(e) => setForm((f) => ({ ...f, target_type: e.target.value as "all"|"plan"|"tenant", target_id: "" }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option value="all">Tous les clients</option>
                <option value="plan">Un plan spécifique</option>
                <option value="tenant">Un client spécifique</option>
              </select>
            </div>
            {form.target_type === "plan" && (
              <div>
                <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Plan</label>
                <select required value={form.target_id} onChange={(e) => setForm((f) => ({ ...f, target_id: e.target.value }))}
                  className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                  <option value="">-- Choisir --</option>
                  {plans.map((p) => <option key={p.plan_id} value={p.plan_id}>{p.plan_name}</option>)}
                </select>
              </div>
            )}
            {form.target_type === "tenant" && (
              <div>
                <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Client</label>
                <select required value={form.target_id} onChange={(e) => setForm((f) => ({ ...f, target_id: e.target.value }))}
                  className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                  <option value="">-- Choisir --</option>
                  {clients.map((c) => <option key={c.client_id} value={c.client_id}>{c.business_name}</option>)}
                </select>
              </div>
            )}
          </div>

          {/* Changelog */}
          <div>
            <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Changelog / Notes</label>
            <textarea rows={3} value={form.changelog} onChange={(e) => setForm((f) => ({ ...f, changelog: e.target.value }))}
              className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
              placeholder="Décrivez les changements apportés par cette mise à jour..." />
          </div>

          {/* Config payload */}
          {form.type === "config" && (
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                Payload JSON (configuration à appliquer)
              </label>
              <textarea rows={6} value={form.config_json}
                onChange={(e) => setForm((f) => ({ ...f, config_json: e.target.value }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
                placeholder={'{\n  "setting_key": "new_value",\n  "max_tables": 50\n}'} />
              <p className="mt-1 text-xs text-gray-400">Ce JSON sera mergé dans <code>application/config/saas_config.php</code> sur l'installation cliente.</p>
            </div>
          )}

          {/* Code files */}
          {form.type === "code" && (
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">
                Fichiers PHP à déployer
              </label>
              <div className="mb-3">
                <label className="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-dashed border-brand-400 text-sm text-brand-500 cursor-pointer hover:bg-brand-50 dark:hover:bg-brand-500/10">
                  <span>+ Ajouter des fichiers</span>
                  <input type="file" multiple accept=".php,.js,.css,.json" className="hidden" onChange={handleFileUpload} />
                </label>
              </div>
              {form.files.length === 0 && (
                <p className="text-sm text-gray-400 italic">Aucun fichier sélectionné.</p>
              )}
              <div className="space-y-3">
                {form.files.map((f) => (
                  <div key={f.filename} className="rounded-lg border border-gray-200 dark:border-gray-700 p-3">
                    <div className="flex items-center justify-between mb-2">
                      <span className="text-sm font-medium text-gray-700 dark:text-gray-300">{f.filename}</span>
                      <button type="button" onClick={() => removeFile(f.filename)} className="text-xs text-red-400 hover:text-red-600">✕ Retirer</button>
                    </div>
                    <div>
                      <label className="block text-xs text-gray-500 mb-1">Chemin de déploiement (relatif à la racine Bonresto)</label>
                      <input
                        required
                        value={f.path}
                        onChange={(e) => updateFilePath(f.filename, e.target.value)}
                        className="w-full rounded border border-gray-300 px-3 py-1.5 text-xs font-mono dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-1 focus:ring-brand-500"
                        placeholder="application/modules/hrm/controllers/Employees.php"
                      />
                    </div>
                  </div>
                ))}
              </div>
              <p className="mt-2 text-xs text-gray-400">
                Chemins autorisés : <code>application/modules/</code>, <code>application/libraries/</code>, <code>application/config/</code>, <code>assets/</code>
              </p>
            </div>
          )}

          <div className="flex gap-3 pt-2">
            <button type="submit" disabled={saving}
              className="rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white hover:bg-brand-600 disabled:opacity-60">
              {saving ? "Création..." : "Créer (brouillon)"}
            </button>
            <button type="button" onClick={() => { setShowForm(false); setError(null); }}
              className="rounded-lg border border-gray-300 px-6 py-2.5 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
              Annuler
            </button>
          </div>
        </form>
      )}

      {/* ── Updates list ────────────────────────────────────────────────────── */}
      {loading ? (
        <div className="text-center text-gray-400 py-8">Chargement...</div>
      ) : updates.length === 0 ? (
        <div className="text-center text-gray-400 py-16">Aucune mise à jour créée.</div>
      ) : (
        <div className="space-y-4">
          {updates.map((u) => (
            <div key={u.update_id}
              className={`rounded-2xl border bg-white dark:bg-white/[0.03] p-5 ${u.status === "archived" ? "opacity-60 border-gray-100 dark:border-gray-800/50" : "border-gray-200 dark:border-gray-800"}`}>
              <div className="flex flex-wrap items-start justify-between gap-3">
                <div className="flex-1 min-w-0">
                  <div className="flex items-center gap-2 flex-wrap mb-1">
                    <h3 className="font-semibold text-gray-800 dark:text-white/90">{u.title}</h3>
                    <span className="text-xs text-gray-400">v{u.version}</span>
                    {typeBadge(u.type)}
                    <Badge size="sm" color={statusBadge(u.status)}>
                      {u.status === "draft" ? "Brouillon" : u.status === "published" ? "Publié" : "Archivé"}
                    </Badge>
                  </div>
                  <p className="text-xs text-gray-500 dark:text-gray-400">
                    Module : <strong>{u.module}</strong>
                    {" · "}
                    Cible : {u.target_type === "all" ? "Tous les clients" : u.target_type === "plan" ? `Plan : ${u.target_plan ?? u.target_id}` : `Client : ${u.target_name ?? u.target_id}`}
                    {u.published_at && ` · Publié le ${new Date(u.published_at).toLocaleDateString("fr-FR")}`}
                  </p>
                  {u.changelog && (
                    <p className="mt-2 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{u.changelog}</p>
                  )}
                </div>

                {/* Actions */}
                <div className="flex items-center gap-2 flex-shrink-0">
                  {u.status === "draft" && (
                    <button onClick={() => handlePublish(u.update_id)}
                      className="rounded-lg bg-brand-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-brand-600">
                      ▶ Publier
                    </button>
                  )}
                  {u.status === "published" && (
                    <button onClick={() => handleArchive(u.update_id)}
                      className="rounded-lg border border-gray-300 px-3 py-1.5 text-xs text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
                      Archiver
                    </button>
                  )}
                </div>
              </div>

              {/* Delivery stats */}
              {u.status === "published" && u.delivery && (
                <div className="mt-3 flex items-center gap-4 pt-3 border-t border-gray-100 dark:border-gray-800">
                  <span className="text-xs text-gray-400">Livraison :</span>
                  <span className="flex items-center gap-1 text-xs font-medium text-yellow-600">
                    <span className="w-2 h-2 rounded-full bg-yellow-400 inline-block" />
                    {u.delivery.pending} en attente
                  </span>
                  <span className="flex items-center gap-1 text-xs font-medium text-green-600">
                    <span className="w-2 h-2 rounded-full bg-green-400 inline-block" />
                    {u.delivery.applied} appliqué{u.delivery.applied > 1 ? "s" : ""}
                  </span>
                  {u.delivery.failed > 0 && (
                    <span className="flex items-center gap-1 text-xs font-medium text-red-600">
                      <span className="w-2 h-2 rounded-full bg-red-400 inline-block" />
                      {u.delivery.failed} échoué{u.delivery.failed > 1 ? "s" : ""}
                    </span>
                  )}
                </div>
              )}
            </div>
          ))}
        </div>
      )}
    </>
  );
}
