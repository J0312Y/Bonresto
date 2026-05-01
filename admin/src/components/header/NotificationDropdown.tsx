import { useEffect, useState } from "react";
import { Link } from "react-router";
import { getNotifications } from "../../services/api";
import type { SaasNotification } from "../../types/saas";
import { Dropdown } from "../ui/dropdown/Dropdown";

// ── Helpers ───────────────────────────────────────────────────────────────────

function timeAgo(dateStr: string): string {
  const diff = Math.floor((Date.now() - new Date(dateStr).getTime()) / 1000);
  if (diff < 60) return "à l'instant";
  if (diff < 3600) return `il y a ${Math.floor(diff / 60)} min`;
  if (diff < 86400) return `il y a ${Math.floor(diff / 3600)} h`;
  return `il y a ${Math.floor(diff / 86400)} j`;
}

const COLOR_MAP: Record<string, string> = {
  success: "bg-green-100 text-green-700",
  info:    "bg-blue-100 text-blue-700",
  warning: "bg-yellow-100 text-yellow-800",
  error:   "bg-red-100 text-red-700",
  brand:   "bg-purple-100 text-purple-700",
};

const DOT_MAP: Record<string, string> = {
  success: "bg-green-500",
  info:    "bg-blue-500",
  warning: "bg-yellow-500",
  error:   "bg-red-500",
  brand:   "bg-purple-500",
};

const TYPE_LABEL: Record<string, string> = {
  license_activated:    "Licence",
  tenant_created:       "Nouveau client",
  subscription_updated: "Abonnement",
  tenant_suspended:     "Suspension",
  subscription_expiring:"Expiration",
  subscription_expired: "Expiré",
  update_failed:        "Mise à jour",
};

// Icon or logo component
function NotifAvatar({ icon, color, logoUrl }: { icon: string; color: string; logoUrl?: string | null }) {
  if (logoUrl) {
    return (
      <img
        src={logoUrl}
        alt=""
        className="h-10 w-10 shrink-0 rounded-full object-cover border border-gray-200 dark:border-gray-700"
        onError={(e) => { (e.currentTarget as HTMLImageElement).style.display = "none"; }}
      />
    );
  }
  const cls = COLOR_MAP[color] ?? "bg-gray-100 text-gray-600";
  return (
    <span
      className={`flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm ${cls}`}
    >
      <i className={`fa fa-${icon}`} />
    </span>
  );
}

// ── Component ─────────────────────────────────────────────────────────────────

const POLL_INTERVAL = 60_000; // 1 minute
const LS_KEY = "saas_read_notif_ids";

function getReadIds(): Set<string> {
  try {
    const stored = localStorage.getItem(LS_KEY);
    return stored ? new Set(JSON.parse(stored)) : new Set();
  } catch {
    return new Set();
  }
}

function saveReadIds(ids: Set<string>) {
  // Keep only the last 200 IDs to avoid localStorage bloat
  const arr = Array.from(ids).slice(-200);
  localStorage.setItem(LS_KEY, JSON.stringify(arr));
}

export default function NotificationDropdown() {
  const [isOpen, setIsOpen]               = useState(false);
  const [notifications, setNotifications] = useState<SaasNotification[]>([]);
  const [unread, setUnread]               = useState(0);
  const [loading, setLoading]             = useState(true);

  async function fetchNotifs() {
    try {
      const data = await getNotifications();
      const readIds = getReadIds();
      setNotifications(data);
      const newCount = data.filter((n) => !readIds.has(n.id)).length;
      setUnread(newCount);
    } catch {
      // silently ignore network errors in header
    } finally {
      setLoading(false);
    }
  }

  useEffect(() => {
    fetchNotifs();
    const timer = setInterval(fetchNotifs, POLL_INTERVAL);
    return () => clearInterval(timer);
  }, []);

  function handleOpen() {
    setIsOpen((o) => !o);
    if (!isOpen) {
      // Mark all current notifications as read in localStorage
      const readIds = getReadIds();
      notifications.forEach((n) => readIds.add(n.id));
      saveReadIds(readIds);
      setUnread(0);
    }
  }

  function closeDropdown() {
    setIsOpen(false);
  }

  return (
    <div className="relative">
      {/* Bell button */}
      <button
        className="relative flex items-center justify-center text-gray-500 transition-colors bg-white border border-gray-200 rounded-full dropdown-toggle hover:text-gray-700 h-11 w-11 hover:bg-gray-100 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-white"
        onClick={handleOpen}
        aria-label="Notifications"
      >
        {/* Orange pulsing dot for new notifications */}
        <span
          className={`absolute right-0 top-0.5 z-10 h-2 w-2 rounded-full bg-orange-400 ${
            unread > 0 ? "flex" : "hidden"
          }`}
        >
          <span className="absolute inline-flex w-full h-full bg-orange-400 rounded-full opacity-75 animate-ping" />
        </span>
        <svg
          className="fill-current"
          width="20"
          height="20"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fillRule="evenodd"
            clipRule="evenodd"
            d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z"
            fill="currentColor"
          />
        </svg>
      </button>

      <Dropdown
        isOpen={isOpen}
        onClose={closeDropdown}
        className="absolute -right-[240px] mt-2 flex w-[360px] flex-col rounded-2xl border border-gray-200 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-900 overflow-hidden sm:w-[370px] lg:right-0"
      >
        {/* Header */}
        <div className="flex items-center justify-between px-4 py-3.5 border-b border-gray-100 dark:border-gray-800">
          <div className="flex items-center gap-2">
            <h5 className="text-base font-semibold text-gray-800 dark:text-white">
              Notifications
            </h5>
            {unread > 0 && (
              <span className="inline-flex items-center justify-center h-5 min-w-5 px-1.5 rounded-full bg-orange-500 text-white text-[10px] font-bold">
                {unread}
              </span>
            )}
            {unread === 0 && notifications.length > 0 && (
              <span className="text-xs text-gray-400">({notifications.length})</span>
            )}
          </div>
          <button
            onClick={closeDropdown}
            className="flex items-center justify-center h-7 w-7 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300 transition-colors"
          >
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
              <path d="M1 1l12 12M13 1L1 13" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round"/>
            </svg>
          </button>
        </div>

        {/* List */}
        <ul className="flex flex-col flex-1 overflow-y-auto custom-scrollbar max-h-[400px]">
          {loading && (
            <li className="flex flex-col items-center justify-center py-14 gap-2">
              <div className="h-5 w-5 rounded-full border-2 border-brand-500 border-t-transparent animate-spin" />
              <span className="text-sm text-gray-400">Chargement…</span>
            </li>
          )}

          {!loading && notifications.length === 0 && (
            <li className="flex flex-col items-center justify-center py-14 text-gray-400 text-sm gap-3">
              <span className="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-2xl">
                🔔
              </span>
              <span>Aucune notification récente</span>
            </li>
          )}

          {!loading && notifications.map((n) => {
            const isRead = getReadIds().has(n.id);
            return (
              <li key={n.id}>
                <Link
                  to={`/clients/${n.link.split("/").pop()}`}
                  onClick={closeDropdown}
                  className={`flex gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors border-b border-gray-50 dark:border-gray-800/60 ${!isRead ? "bg-brand-50/40 dark:bg-brand-500/5" : ""}`}
                >
                  <NotifAvatar icon={n.icon} color={n.color} logoUrl={n.logo_url} />

                  <span className="flex flex-col min-w-0 flex-1">
                    <span className="flex items-center justify-between gap-2 mb-0.5">
                      <span className="font-semibold text-sm text-gray-800 dark:text-white truncate">
                        {n.title}
                      </span>
                      {!isRead && (
                        <span className={`shrink-0 h-2 w-2 rounded-full ${DOT_MAP[n.color] ?? "bg-brand-500"}`} />
                      )}
                    </span>
                    <span className="text-xs text-gray-500 dark:text-gray-400 leading-snug line-clamp-2">
                      {n.message}
                    </span>
                    <span className="flex items-center gap-1.5 mt-1.5">
                      <span className={`text-[10px] font-medium px-1.5 py-0.5 rounded-full ${COLOR_MAP[n.color] ?? "bg-gray-100 text-gray-500"}`}>
                        {TYPE_LABEL[n.type] ?? n.type}
                      </span>
                      <span className="text-[10px] text-gray-400">{timeAgo(n.time)}</span>
                    </span>
                  </span>
                </Link>
              </li>
            );
          })}
        </ul>

        {/* Footer */}
        <div className="px-3 py-2.5 border-t border-gray-100 dark:border-gray-800">
          <Link
            to="/notifications"
            onClick={closeDropdown}
            className="flex items-center justify-center gap-2 w-full rounded-xl py-2 text-sm font-medium text-brand-600 hover:bg-brand-50 dark:text-brand-400 dark:hover:bg-brand-500/10 transition-colors"
          >
            Voir toutes les notifications
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
              <path d="M1 7h12M8 2l5 5-5 5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
            </svg>
          </Link>
        </div>
      </Dropdown>
    </div>
  );
}
