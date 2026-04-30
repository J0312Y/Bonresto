import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import { getPlans, createPlan, updatePlan, deletePlan } from "../../services/api";
import type { Plan } from "../../types/saas";

// ── Tous les modules Bonresto ──────────────────────────────────────────────────
const MODULE_GROUPS = [
  {
    group: "Core (toujours inclus)",
    always: true,
    modules: [
      { key: "ordermanage", label: "Gestion commandes & POS" },
      { key: "itemmanage",  label: "Articles & catégories" },
      { key: "dashboard",   label: "Tableau de bord restaurant" },
    ],
  },
  {
    group: "Restauration",
    always: false,
    modules: [
      { key: "reservation",    label: "Réservations de tables" },
      { key: "qrapp",          label: "Commande & paiement QR Code" },
      { key: "kitchen_screen", label: "Écran cuisine (KDS)" },
      { key: "counter",        label: "Tableau comptoir" },
    ],
  },
  {
    group: "Stock & Production",
    always: false,
    modules: [
      { key: "purchase",    label: "Achats & fournisseurs" },
      { key: "production",  label: "Unités de production & recettes" },
      { key: "wastemangment", label: "Gestion des déchets" },
      { key: "inventory",   label: "Inventaire avancé" },
    ],
  },
  {
    group: "Finance & Comptabilité",
    always: false,
    modules: [
      { key: "accounts",       label: "Comptabilité (grand livre, bilans)" },
      { key: "report",         label: "Rapports ventes & stocks" },
      { key: "cash_register",  label: "Gestion caisse" },
      { key: "online_payment", label: "Paiement en ligne" },
    ],
  },
  {
    group: "RH & Employés",
    always: false,
    modules: [
      { key: "hrm",       label: "Gestion RH & paie" },
      { key: "attendance", label: "Présence & congés" },
      { key: "payroll",   label: "Paie & salaires" },
    ],
  },
  {
    group: "Marketing & Clients",
    always: false,
    modules: [
      { key: "whatsapp",      label: "Notifications WhatsApp" },
      { key: "sms_notif",     label: "Notifications SMS" },
      { key: "loyalty",       label: "Programme fidélité" },
      { key: "coupon",        label: "Coupons & promotions" },
      { key: "rating",        label: "Avis & notations clients" },
    ],
  },
  {
    group: "Croissance (futurs modules)",
    always: false,
    modules: [
      { key: "multi_branch",  label: "Multi-établissements" },
      { key: "delivery",      label: "Gestion livraisons" },
      { key: "online_menu",   label: "Menu en ligne public" },
      { key: "api_access",    label: "Accès API externe" },
      { key: "white_label",   label: "Marque blanche" },
    ],
  },
];

const ALL_MODULES = MODULE_GROUPS.flatMap((g) => g.modules);
const ALWAYS_ON   = MODULE_GROUPS.filter((g) => g.always).flatMap((g) => g.modules.map((m) => m.key));

function emptyFeatures(): Record<string, boolean> {
  const f: Record<string, boolean> = {};
  ALL_MODULES.forEach((m) => { f[m.key] = ALWAYS_ON.includes(m.key); });
  return f;
}

const EMPTY_PLAN: Omit<Plan, "plan_id"> = {
  plan_name: "",
  price: 0,
  max_tables: 0,
  max_users: 0,
  billing_cycle: "monthly",
  features: emptyFeatures(),
};

function fcfa(n: number, cycle?: string) {
  if (n === 0) return "Gratuit";
  const suffix = cycle === "annual" ? "/an" : "/mois";
  return `${Math.round(n).toLocaleString("fr-FR")} FCFA${suffix}`;
}

export default function PlanList() {
  const [plans, setPlans]       = useState<Plan[]>([]);
  const [loading, setLoading]   = useState(true);
  const [showForm, setShowForm] = useState(false);
  const [editPlan, setEditPlan] = useState<Plan | null>(null);
  const [form, setForm]         = useState<Omit<Plan, "plan_id">>(EMPTY_PLAN);
  const [saving, setSaving]     = useState(false);

  useEffect(() => {
    getPlans()
      .then((data) =>
        // Normalize: features may come as [] (PHP empty array) — always ensure object
        setPlans(data.map((p) => ({
          ...p,
          features: (Array.isArray(p.features) || !p.features)
            ? emptyFeatures()
            : p.features,
        })))
      )
      .finally(() => setLoading(false));
  }, []);

  function openCreate() {
    setEditPlan(null);
    setForm(EMPTY_PLAN);
    setShowForm(true);
  }

  function openEdit(plan: Plan) {
    setEditPlan(plan);
    // Merge existing features with full module list
    const merged = emptyFeatures();
    Object.entries(plan.features ?? {}).forEach(([k, v]) => { merged[k] = !!v; });
    setForm({ plan_name: plan.plan_name, price: plan.price, max_tables: plan.max_tables, max_users: plan.max_users, billing_cycle: plan.billing_cycle ?? "monthly", features: merged });
    setShowForm(true);
  }

  function toggleFeature(key: string, checked: boolean) {
    if (ALWAYS_ON.includes(key)) return; // core modules can't be toggled
    setForm((f) => ({ ...f, features: { ...f.features, [key]: checked } }));
  }

  function selectGroup(groupModules: { key: string }[], checked: boolean) {
    setForm((f) => {
      const updated = { ...f.features };
      groupModules.forEach(({ key }) => { if (!ALWAYS_ON.includes(key)) updated[key] = checked; });
      return { ...f, features: updated };
    });
  }

  function normalizePlan(p: Plan): Plan {
    return {
      ...p,
      features: (Array.isArray(p.features) || !p.features) ? emptyFeatures() : p.features,
    };
  }

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setSaving(true);
    try {
      if (editPlan) {
        const updated = await updatePlan(editPlan.plan_id, form);
        setPlans((p) => p.map((pl) =>
          pl.plan_id === editPlan.plan_id ? normalizePlan(updated) : pl
        ));
      } else {
        const created = await createPlan(form);
        setPlans((p) => [...p, normalizePlan(created)]);
      }
      setShowForm(false);
      setEditPlan(null);
      setForm(EMPTY_PLAN);
    } catch {
      alert("Erreur lors de l'enregistrement.");
    } finally {
      setSaving(false);
    }
  }

  async function handleDelete(id: number) {
    if (!confirm("Supprimer ce plan ?")) return;
    try {
      await deletePlan(id);
      setPlans((p) => p.filter((pl) => pl.plan_id !== id));
    } catch {
      alert("Impossible de supprimer ce plan.");
    }
  }

  return (
    <>
      <PageMeta title="Plans — Bonresto SaaS" description="Gestion des plans d'abonnement" />

      <div className="mb-6 flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 dark:text-white/90">Plans d'abonnement</h2>
          <p className="text-sm text-gray-500">{plans.length} plan{plans.length !== 1 ? "s" : ""} configuré{plans.length !== 1 ? "s" : ""}</p>
        </div>
        <button onClick={openCreate} className="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600">
          + Nouveau plan
        </button>
      </div>

      {/* ── Form ────────────────────────────────────────────────── */}
      {showForm && (
        <form onSubmit={handleSubmit} className="mb-8 rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
          <div className="flex items-center justify-between mb-5">
            <h3 className="text-lg font-semibold text-gray-800 dark:text-white/90">
              {editPlan ? `Modifier "${editPlan.plan_name}"` : "Nouveau plan"}
            </h3>
            <button type="button" onClick={() => setShowForm(false)} className="text-xs text-gray-400 hover:text-gray-600">✕ Annuler</button>
          </div>

          {/* Basic info */}
          <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5 mb-6">
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Nom du plan</label>
              <input
                required value={form.plan_name}
                onChange={(e) => setForm((f) => ({ ...f, plan_name: e.target.value }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
                placeholder="Basic, Pro, Enterprise..."
              />
            </div>
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Cycle de facturation</label>
              <select
                value={form.billing_cycle}
                onChange={(e) => setForm((f) => ({ ...f, billing_cycle: e.target.value as "monthly" | "annual" }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
              >
                <option value="monthly">Mensuel</option>
                <option value="annual">Annuel</option>
              </select>
            </div>
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                Prix (FCFA / {form.billing_cycle === "annual" ? "an" : "mois"})
              </label>
              <input
                required type="number" min="0" value={form.price}
                onChange={(e) => setForm((f) => ({ ...f, price: +e.target.value }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
                placeholder="0"
              />
            </div>
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Max tables (0 = illimité)</label>
              <input
                type="number" min="0" value={form.max_tables}
                onChange={(e) => setForm((f) => ({ ...f, max_tables: +e.target.value }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
              />
            </div>
            <div>
              <label className="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Max utilisateurs (0 = illimité)</label>
              <input
                type="number" min="0" value={form.max_users}
                onChange={(e) => setForm((f) => ({ ...f, max_users: +e.target.value }))}
                className="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-500"
              />
            </div>
          </div>

          {/* Module selector */}
          <div>
            <p className="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Modules inclus</p>
            <div className="space-y-5">
              {MODULE_GROUPS.map((group) => {
                const nonCore = group.modules.filter((m) => !ALWAYS_ON.includes(m.key));
                const allChecked = nonCore.every((m) => !!form.features[m.key]);
                return (
                  <div key={group.group} className="rounded-xl border border-gray-100 dark:border-gray-800 p-4">
                    <div className="flex items-center justify-between mb-3">
                      <p className="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        {group.group}
                      </p>
                      {!group.always && nonCore.length > 0 && (
                        <button
                          type="button"
                          onClick={() => selectGroup(nonCore, !allChecked)}
                          className="text-xs text-brand-500 hover:underline"
                        >
                          {allChecked ? "Tout décocher" : "Tout cocher"}
                        </button>
                      )}
                      {group.always && (
                        <span className="text-xs text-green-600 font-medium">Toujours inclus</span>
                      )}
                    </div>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                      {group.modules.map((mod) => {
                        const isAlways = ALWAYS_ON.includes(mod.key);
                        const checked  = isAlways || !!form.features[mod.key];
                        return (
                          <label
                            key={mod.key}
                            className={`flex items-center gap-2 rounded-lg px-3 py-2 cursor-pointer transition-colors ${
                              checked
                                ? "bg-brand-50 dark:bg-brand-500/10"
                                : "hover:bg-gray-50 dark:hover:bg-white/[0.02]"
                            } ${isAlways ? "opacity-70 cursor-default" : ""}`}
                          >
                            <input
                              type="checkbox"
                              checked={checked}
                              disabled={isAlways}
                              onChange={(e) => toggleFeature(mod.key, e.target.checked)}
                              className="accent-brand-500 w-4 h-4 flex-shrink-0"
                            />
                            <span className={`text-sm ${checked ? "text-gray-800 dark:text-white/90 font-medium" : "text-gray-500 dark:text-gray-400"}`}>
                              {mod.label}
                            </span>
                          </label>
                        );
                      })}
                    </div>
                  </div>
                );
              })}
            </div>
          </div>

          <div className="mt-6 flex gap-3">
            <button
              type="submit" disabled={saving}
              className="rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white hover:bg-brand-600 disabled:opacity-60"
            >
              {saving ? "Enregistrement..." : editPlan ? "Mettre à jour" : "Créer le plan"}
            </button>
            <button type="button" onClick={() => setShowForm(false)} className="rounded-lg border border-gray-300 px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400">
              Annuler
            </button>
          </div>
        </form>
      )}

      {/* ── Plan cards ──────────────────────────────────────────── */}
      {loading ? (
        <div className="text-center text-gray-400 py-8">Chargement...</div>
      ) : (
        <div className="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">
          {plans.map((plan) => {
            const activeModules = ALL_MODULES.filter((m) => ALWAYS_ON.includes(m.key) || !!plan.features[m.key]);
            return (
              <div key={plan.plan_id} className="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] flex flex-col">
                <div className="flex items-start justify-between mb-2">
                  <div>
                    <h3 className="text-lg font-bold text-gray-800 dark:text-white/90">{plan.plan_name}</h3>
                    <p className="text-xl font-bold text-brand-500 mt-1">{fcfa(plan.price, plan.billing_cycle)}</p>
                  </div>
                  <div className="flex gap-2">
                    <button onClick={() => openEdit(plan)} className="text-xs text-brand-500 hover:underline">Modifier</button>
                    <button onClick={() => handleDelete(plan.plan_id)} className="text-xs text-red-400 hover:text-red-600">Supprimer</button>
                  </div>
                </div>

                <p className="text-xs text-gray-400 mb-4">
                  {plan.max_tables === 0 ? "Tables illimitées" : `${plan.max_tables} tables`}
                  {" · "}
                  {plan.max_users === 0 ? "Utilisateurs illimités" : `${plan.max_users} users`}
                  {" · "}
                  <strong className="text-brand-500">{activeModules.length}</strong> modules
                  {" · "}
                  <span className={`inline-block px-1.5 py-0.5 rounded text-[10px] font-semibold ${plan.billing_cycle === "annual" ? "bg-purple-100 text-purple-700" : "bg-blue-100 text-blue-700"}`}>
                    {plan.billing_cycle === "annual" ? "Annuel" : "Mensuel"}
                  </span>
                </p>

                <div className="flex-1">
                  {MODULE_GROUPS.map((group) => {
                    const enabled = group.modules.filter((m) => ALWAYS_ON.includes(m.key) || !!plan.features[m.key]);
                    if (enabled.length === 0) return null;
                    return (
                      <div key={group.group} className="mb-3">
                        <p className="text-[10px] uppercase font-semibold text-gray-400 mb-1">{group.group}</p>
                        <div className="flex flex-wrap gap-1">
                          {enabled.map((m) => (
                            <span key={m.key} className="inline-block px-2 py-0.5 rounded-full text-xs bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400">
                              {m.label}
                            </span>
                          ))}
                        </div>
                      </div>
                    );
                  })}
                </div>
              </div>
            );
          })}
        </div>
      )}
    </>
  );
}
