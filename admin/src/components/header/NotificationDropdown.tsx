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
        className="absolute -right-[240px] mt-[17px] flex h-[480px] w-[350px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark sm:w-[361px] lg:right-0"
      >
        {/* Header */}
        <div className="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 dark:border-gray-700">
          <h5 className="text-lg font-semibold text-gray-800 dark:text-gray-200">
            Notifications
            {unread === 0 && notifications.length > 0 && (
              <span className="ml-2 text-xs font-normal text-gray-400">
                ({notifications.length})
              </span>
            )}
          </h5>
          <button
            onClick={closeDropdown}
            className="text-gray-500 transition dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
          >
            <svg className="fill-current" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path fillRule="evenodd" clipRule="evenodd" d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z" fill="currentColor" />
            </svg>
          </button>
        </div>

        {/* List */}
        <ul className="flex flex-col flex-1 overflow-y-auto custom-scrollbar gap-0.5">
          {loading && (
            <li className="flex items-center justify-center py-12 text-gray-400 text-sm">
              Chargement…
            </li>
          )}

          {!loading && notifications.length === 0 && (
            <li className="flex flex-col items-center justify-center py-12 text-gray-400 text-sm gap-2">
              <i className="fa fa-bell-slash-o text-3xl" />
              Aucune notification récente
            </li>
          )}

          {!loading && notifications.map((n) => {
            const isRead = getReadIds().has(n.id);
            return (
            <li key={n.id}>
              <Link
                to={`/clients/${n.link.split("/").pop()}`}
                onClick={closeDropdown}
                className="flex gap-3 rounded-lg border-b border-gray-100 px-3 py-3 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-white/5 transition-colors"
              >
                {/* Logo or icon */}
                <NotifAvatar icon={n.icon} color={n.color} logoUrl={n.logo_url} />

                {/* Text */}
                <span className="flex flex-col min-w-0">
                  <span className="flex items-center gap-2 mb-0.5">
                    <span className="font-semibold text-sm text-gray-800 dark:text-white truncate">
                      {n.title}
                    </span>
                    {!isRead && (
                      <span
                        className={`shrink-0 inline-block h-2 w-2 rounded-full ${DOT_MAP[n.color] ?? "bg-gray-400"}`}
                      />
                    )}
                  </span>
                  <span className="text-xs text-gray-500 dark:text-gray-400 leading-snug line-clamp-2">
                    {n.message}
                  </span>
                  <span className="flex items-center gap-1.5 mt-1 text-[11px] text-gray-400 dark:text-gray-500">
                    <span className="capitalize">{TYPE_LABEL[n.type] ?? n.type}</span>
                    <span className="h-1 w-1 rounded-full bg-gray-300" />
                    <span>{timeAgo(n.time)}</span>
                  </span>
                </span>
              </Link>
            </li>
            );
          })}
        </ul>

        {/* Footer */}
        <Link
          to="/notifications"
          onClick={closeDropdown}
          className="block px-4 py-2 mt-3 text-sm font-medium text-center text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors"
        >
          Voir toutes les notifications
        </Link>
      </Dropdown>
    </div>
  );
}
