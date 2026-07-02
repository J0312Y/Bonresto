import { useEffect, useState } from "react";
import { Link } from "react-router";
import { getNotifications } from "../../services/api";
import type { SaasNotification } from "../../types/saas";

const LS_KEY = "saas_read_notif_ids";
function getReadIds(): Set<string> {
  try {
    const stored = localStorage.getItem(LS_KEY);
    return stored ? new Set(JSON.parse(stored)) : new Set();
  } catch { return new Set(); }
}
function saveReadIds(ids: Set<string>) {
  localStorage.setItem(LS_KEY, JSON.stringify(Array.from(ids).slice(-200)));
}

// ── Helpers ───────────────────────────────────────────────────────────────────

function timeAgo(dateStr: string): string {
  const diff = Math.floor((Date.now() - new Date(dateStr).getTime()) / 1000);
  if (diff < 60) return "à l'instant";
  if (diff < 3600) return `il y a ${Math.floor(diff / 60)} min`;
  if (diff < 86400) return `il y a ${Math.floor(diff / 3600)} h`;
  return `il y a ${Math.floor(diff / 86400)} j`;
}

function formatDate(dateStr: string): string {
  return new Date(dateStr).toLocaleDateString("fr-FR", {
    day: "2-digit",
    month: "long",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
}

const COLOR_BG: Record<string, string> = {
  success: "bg-green-100 text-green-700",
  info:    "bg-blue-100 text-blue-700",
  warning: "bg-yellow-100 text-yellow-800",
  error:   "bg-red-100 text-red-700",
  brand:   "bg-purple-100 text-purple-700",
};

const COLOR_BORDER: Record<string, string> = {
  success: "border-l-green-500",
  info:    "border-l-blue-500",
  warning: "border-l-yellow-500",
  error:   "border-l-red-500",
  brand:   "border-l-purple-500",
};

const TYPE_LABEL: Record<string, string> = {
  license_activated:    "Licence activée",
  tenant_created:       "Nouveau client",
  subscription_updated: "Abonnement modifié",
  tenant_suspended:     "Client suspendu",
  subscription_expiring:"Expiration proche",
  subscription_expired: "Abonnement expiré",
  update_failed:        "Mise à jour échouée",
};

const PAGE_SIZE = 10;

// ── Component ─────────────────────────────────────────────────────────────────

export default function NotificationsPage() {
  const [all, setAll]           = useState<SaasNotification[]>([]);
  const [readIds, setReadIds]   = useState<Set<string>>(getReadIds);
  const [visible, setVisible]   = useState(PAGE_SIZE);
  const [loading, setLoading]   = useState(true);
  const [filter, setFilter]     = useState<string>("all");

  useEffect(() => {
    getNotifications().then((data) => {
      setAll(data);
      // Mark all as read on page open
      const ids = getReadIds();
      data.forEach((n) => ids.add(n.id));
      saveReadIds(ids);
      setReadIds(new Set(ids));
    }).finally(() => setLoading(false));
  }, []);

  // Unique types for filter bar
  const types = ["all", ...Array.from(new Set(all.map((n) => n.type)))];

  const filtered = filter === "all" ? all : all.filter((n) => n.type === filter);
  const shown    = filtered.slice(0, visible);

  function loadMore() {
    setVisible((v) => v + PAGE_SIZE);
  }

  // Extract client id from link "/clients/42" → 42
  function clientId(link: string): string {
    return link.split("/").pop() ?? "";
  }

  return (
    <div className="p-6 max-w-3xl mx-auto">
      {/* ── Page header ── */}
      <div className="flex items-center justify-between mb-6">
        <div>
          <h1 className="text-2xl font-bold text-gray-800 text-white">
            Notifications
          </h1>
          <p className="text-sm text-gray-500 mt-1">
            {all.length} notification{all.length !== 1 ? "s" : ""} récente{all.length !== 1 ? "s" : ""}
          </p>
        </div>
        <button
          onClick={() => { setLoading(true); getNotifications().then(setAll).finally(() => setLoading(false)); }}
          className="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 bg-gray-800 border-gray-700 text-gray-300 hover:bg-gray-700"
        >
          <i className="fa fa-refresh" />
          Actualiser
        </button>
      </div>

      {/* ── Filter bar ── */}
      <div className="flex flex-wrap gap-2 mb-6">
        {types.map((t) => (
          <button
            key={t}
            onClick={() => { setFilter(t); setVisible(PAGE_SIZE); }}
            className={`px-3 py-1.5 rounded-full text-xs font-semibold border transition-colors ${
              filter === t
                ? "bg-[#37a000] text-white border-[#37a000]"
                : "bg-white text-gray-600 border-gray-300 hover:bg-gray-50 bg-gray-800 text-gray-300 border-gray-600"
            }`}
          >
            {t === "all" ? "Toutes" : (TYPE_LABEL[t] ?? t)}
          </button>
        ))}
      </div>

      {/* ── List ── */}
      {loading && (
        <div className="flex justify-center py-20 text-gray-400">
          <i className="fa fa-spinner fa-spin fa-2x" />
        </div>
      )}

      {!loading && filtered.length === 0 && (
        <div className="flex flex-col items-center py-20 text-gray-400 gap-3">
          <i className="fa fa-bell-slash-o fa-3x" />
          <span className="text-sm">Aucune notification pour ce filtre</span>
        </div>
      )}

      {!loading && shown.length > 0 && (
        <div className="flex flex-col gap-3">
          {shown.map((n) => {
            const isRead = readIds.has(n.id);
            return (
            <div
              key={n.id}
              className={`bg-white bg-gray-800 rounded-xl border border-gray-100 border-gray-700 border-l-4 ${isRead ? "border-l-gray-200 border-l-gray-600" : (COLOR_BORDER[n.color] ?? "border-l-gray-300")} shadow-sm overflow-hidden`}
            >
              <div className="flex items-start gap-4 p-4">
                {/* Logo or icon */}
                {n.logo_url ? (
                  <img
                    src={n.logo_url}
                    alt=""
                    className="h-10 w-10 shrink-0 rounded-full object-cover border border-gray-200 border-gray-700"
                    onError={(e) => { (e.currentTarget as HTMLImageElement).style.display = "none"; }}
                  />
                ) : (
                  <span
                    className={`flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm ${isRead ? "bg-gray-100 text-gray-400" : (COLOR_BG[n.color] ?? "bg-gray-100 text-gray-600")}`}
                  >
                    <i className={`fa fa-${n.icon}`} />
                  </span>
                )}

                {/* Content */}
                <div className="flex-1 min-w-0">
                  <div className="flex items-start justify-between gap-2 flex-wrap">
                    <div>
                      <span className="font-semibold text-sm text-gray-800 text-white">
                        {n.title}
                      </span>
                      <span className="ml-2 text-[11px] font-medium text-gray-400 uppercase tracking-wide">
                        {TYPE_LABEL[n.type] ?? n.type}
                      </span>
                    </div>
                    <span className="text-xs text-gray-400 whitespace-nowrap" title={formatDate(n.time)}>
                      {timeAgo(n.time)}
                    </span>
                  </div>
                  <p className="text-sm text-gray-500 text-gray-400 mt-1 leading-snug">
                    {n.message}
                  </p>
                  <div className="mt-2 text-xs text-gray-400 text-gray-500">
                    {formatDate(n.time)}
                  </div>
                </div>
              </div>

              {/* Footer link */}
              <div className="border-t border-gray-100 border-gray-700 px-4 py-2 bg-gray-50 bg-gray-900/30">
                <Link
                  to={`/clients/${clientId(n.link)}`}
                  className="inline-flex items-center gap-1.5 text-xs font-semibold text-[#37a000] hover:underline"
                >
                  Voir le profil client
                  <i className="fa fa-arrow-right" />
                </Link>
              </div>
            </div>
            );
          })}
        </div>
      )}

      {/* ── Load more ── */}
      {!loading && visible < filtered.length && (
        <div className="flex justify-center mt-6">
          <button
            onClick={loadMore}
            className="px-6 py-2.5 text-sm font-semibold text-white bg-[#37a000] rounded-lg hover:bg-[#2d8600] transition-colors"
          >
            Voir plus ({filtered.length - visible} restantes)
          </button>
        </div>
      )}
    </div>
  );
}
