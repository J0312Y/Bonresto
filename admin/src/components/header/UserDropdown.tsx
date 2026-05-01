import { useState } from "react";
import { useNavigate, Link } from "react-router";
import { Dropdown } from "../ui/dropdown/Dropdown";
import { useAuth } from "../../context/AuthContext";

export default function UserDropdown() {
  const [isOpen, setIsOpen] = useState(false);
  const { admin, logout } = useAuth();
  const navigate = useNavigate();

  function handleLogout() {
    logout();
    navigate("/signin");
  }

  const initials = admin?.name
    ? admin.name.split(" ").map((w) => w[0]).join("").toUpperCase().slice(0, 2)
    : "AD";

  const roleLabel: Record<string, { label: string; color: string }> = {
    super_admin: { label: "Super Admin", color: "bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300" },
    admin:       { label: "Admin",       color: "bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300" },
    viewer:      { label: "Lecteur",     color: "bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300" },
  };
  const role = roleLabel[admin?.role ?? ""] ?? { label: admin?.role ?? "Admin", color: "bg-gray-100 text-gray-600" };

  return (
    <div className="relative">
      <button
        onClick={() => setIsOpen(!isOpen)}
        className="flex items-center gap-2.5 rounded-xl px-2 py-1.5 transition-colors hover:bg-gray-100 dark:hover:bg-white/5"
      >
        <span className="flex items-center justify-center h-9 w-9 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 text-white font-bold text-sm shadow-sm">
          {initials}
        </span>
        <span className="hidden sm:flex flex-col items-start">
          <span className="text-sm font-semibold text-gray-800 dark:text-white leading-tight">
            {admin?.name ?? "Admin"}
          </span>
          <span className={`text-[10px] font-medium px-1.5 py-0.5 rounded-full mt-0.5 ${role.color}`}>
            {role.label}
          </span>
        </span>
        <svg
          className={`text-gray-400 transition-transform duration-200 ${isOpen ? "rotate-180" : ""}`}
          width="16" height="16" viewBox="0 0 16 16" fill="none"
        >
          <path d="M4 6l4 4 4-4" stroke="currentColor" strokeWidth="1.5"
            strokeLinecap="round" strokeLinejoin="round" />
        </svg>
      </button>

      <Dropdown
        isOpen={isOpen}
        onClose={() => setIsOpen(false)}
        className="absolute right-0 mt-2 w-[270px] rounded-2xl border border-gray-200 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-900 overflow-hidden"
      >
        {/* User info header */}
        <div className="bg-gradient-to-br from-brand-500 to-brand-700 px-4 py-4">
          <div className="flex items-center gap-3">
            <span className="flex items-center justify-center h-12 w-12 rounded-full bg-white/20 text-white font-bold text-base backdrop-blur-sm">
              {initials}
            </span>
            <div className="min-w-0">
              <p className="font-semibold text-white truncate">
                {admin?.name ?? "Administrateur"}
              </p>
              <p className="text-xs text-white/70 truncate mt-0.5">
                {admin?.email ?? ""}
              </p>
              <span className="inline-block mt-1.5 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-white/20 text-white">
                {role.label}
              </span>
            </div>
          </div>
        </div>

        {/* Menu items */}
        <div className="p-2">
          <Link
            to="/settings"
            onClick={() => setIsOpen(false)}
            className="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/5 transition-colors group"
          >
            <span className="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-500 group-hover:bg-brand-50 group-hover:text-brand-600 dark:bg-gray-800 dark:text-gray-400 transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" strokeWidth="1.5"/>
                <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" stroke="currentColor" strokeWidth="1.5"/>
              </svg>
            </span>
            Paramètres
          </Link>

          <div className="my-1.5 h-px bg-gray-100 dark:bg-gray-800" />

          <button
            onClick={handleLogout}
            className="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-500/10 transition-colors group"
          >
            <span className="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50 text-red-500 group-hover:bg-red-100 dark:bg-red-500/10 transition-colors">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
              </svg>
            </span>
            Se déconnecter
          </button>
        </div>
      </Dropdown>
    </div>
  );
}
