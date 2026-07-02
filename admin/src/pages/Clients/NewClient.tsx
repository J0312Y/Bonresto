import { useRef, useState } from "react";
import { useNavigate } from "react-router";
import PageMeta from "../../components/common/PageMeta";
import { ClientAvatar } from "../../components/ui/ClientAvatar";
import { createClient, uploadClientLogo } from "../../services/api";

const FIELDS = [
  { label: "Nom du restaurant *", name: "business_name", type: "text",  placeholder: "Le Petit Bistro", required: true },
  { label: "Email *",             name: "email",         type: "email", placeholder: "contact@restaurant.com", required: true },
  { label: "Téléphone",           name: "phone",         type: "text",  placeholder: "+225 07 00 00 00", required: false },
  { label: "Pays",                name: "country",       type: "text",  placeholder: "Côte d'Ivoire", required: false },
  { label: "Ville",               name: "city",          type: "text",  placeholder: "Abidjan", required: false },
  { label: "Adresse",             name: "address",       type: "text",  placeholder: "Rue des Jardins, Plateau", required: false },
  { label: "Site web",            name: "website",       type: "url",   placeholder: "https://restaurant.com", required: false },
];

export default function NewClient() {
  const navigate  = useNavigate();
  const fileRef   = useRef<HTMLInputElement>(null);

  const [form, setForm] = useState({
    business_name: "", email: "", phone: "",
    country: "", city: "", address: "", website: "", notes: "",
  });
  const [logoFile, setLogoFile]     = useState<File | null>(null);
  const [logoPreview, setLogoPreview] = useState<string | null>(null);
  const [error, setSaving_err]      = useState<string | null>(null);
  const [saving, setSaving]         = useState(false);

  function handle(e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) {
    setForm((f) => ({ ...f, [e.target.name]: e.target.value }));
  }

  function handleLogoSelect(e: React.ChangeEvent<HTMLInputElement>) {
    const file = e.target.files?.[0];
    if (!file) return;
    setLogoFile(file);
    setLogoPreview(URL.createObjectURL(file));
  }

  function removeLogo() {
    setLogoFile(null);
    setLogoPreview(null);
    if (fileRef.current) fileRef.current.value = "";
  }

  async function submit(e: React.FormEvent) {
    e.preventDefault();
    setSaving(true);
    setSaving_err(null);
    try {
      const client = await createClient(form);
      if (logoFile) {
        await uploadClientLogo(client.client_id, logoFile).catch(() => {});
      }
      navigate(`/clients/${client.client_id}`);
    } catch (err: unknown) {
      setSaving_err(err instanceof Error ? err.message : "Erreur lors de la création.");
    } finally {
      setSaving(false);
    }
  }

  return (
    <>
      <PageMeta title="Nouveau client — Bonresto SaaS" description="" />

      <div className="max-w-2xl">
        <div className="mb-6">
          <h2 className="text-2xl font-bold text-gray-800 text-white/90">Nouveau client</h2>
          <p className="text-sm text-gray-500 text-gray-400">Créer un compte restaurant dans le SaaS.</p>
        </div>

        {error && (
          <div className="mb-4 rounded-xl bg-red-50 border border-red-200 p-4 text-sm text-red-700 bg-red-500/10 text-red-400">
            {error}
          </div>
        )}

        <form onSubmit={submit} className="space-y-6">

          {/* ── Logo ── */}
          <div className="rounded-2xl border border-gray-200 bg-white p-6 border-gray-800 bg-white/[0.03]">
            <h3 className="mb-4 text-sm font-semibold text-gray-700 text-gray-200">Logo du restaurant</h3>
            <div className="flex items-center gap-5">
              <div className="relative group cursor-pointer" onClick={() => fileRef.current?.click()}>
                <ClientAvatar
                  name={form.business_name || "?"}
                  logoUrl={logoPreview}
                  size={72}
                />
                <div className="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                  <span className="text-white text-xl">+</span>
                </div>
              </div>
              <div className="flex flex-col gap-2">
                <button
                  type="button"
                  onClick={() => fileRef.current?.click()}
                  className="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 border-gray-700 text-gray-300 hover:bg-gray-800"
                >
                  Choisir un logo
                </button>
                {logoFile && (
                  <button type="button" onClick={removeLogo} className="text-xs text-red-400 hover:underline text-left">
                    Supprimer
                  </button>
                )}
                <p className="text-xs text-gray-400">PNG, JPG, WebP — max 2 Mo</p>
              </div>
              <input ref={fileRef} type="file" accept="image/*" className="hidden" onChange={handleLogoSelect} />
            </div>
          </div>

          {/* ── Infos principales ── */}
          <div className="rounded-2xl border border-gray-200 bg-white p-6 border-gray-800 bg-white/[0.03]">
            <h3 className="mb-4 text-sm font-semibold text-gray-700 text-gray-200">Informations du restaurant</h3>
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
              {FIELDS.map((field) => (
                <div key={field.name} className={field.name === "business_name" || field.name === "address" ? "sm:col-span-2" : ""}>
                  <label className="block text-sm font-medium text-gray-700 text-gray-300 mb-1.5">
                    {field.label}
                  </label>
                  <input
                    type={field.type}
                    name={field.name}
                    value={form[field.name as keyof typeof form]}
                    onChange={handle}
                    placeholder={field.placeholder}
                    required={field.required}
                    className="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500 border-gray-700 bg-gray-800 text-white"
                  />
                </div>
              ))}
            </div>
          </div>

          {/* ── Notes ── */}
          <div className="rounded-2xl border border-gray-200 bg-white p-6 border-gray-800 bg-white/[0.03]">
            <h3 className="mb-4 text-sm font-semibold text-gray-700 text-gray-200">Notes internes</h3>
            <textarea
              name="notes"
              value={form.notes}
              onChange={handle}
              rows={3}
              placeholder="Informations complémentaires, contexte commercial..."
              className="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-brand-500 border-gray-700 bg-gray-800 text-white resize-none"
            />
          </div>

          {/* ── Actions ── */}
          <div className="flex gap-3">
            <button
              type="submit"
              disabled={saving}
              className="rounded-lg bg-brand-500 px-6 py-2.5 text-sm font-medium text-white hover:bg-brand-600 disabled:opacity-60"
            >
              {saving ? "Enregistrement..." : "Créer le client"}
            </button>
            <button
              type="button"
              onClick={() => navigate("/clients")}
              className="rounded-lg border border-gray-300 px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 border-gray-700 text-gray-300"
            >
              Annuler
            </button>
          </div>
        </form>
      </div>
    </>
  );
}
