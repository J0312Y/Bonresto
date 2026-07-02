import { useCallback, useEffect, useRef, useState } from "react";
import { Link, useLocation, useNavigate } from "react-router";
import {
  GridIcon,
  UserCircleIcon,
  ChevronDownIcon,
  HorizontaLDots,
  GroupIcon,
  DollarLineIcon,
  BoxCubeIcon,
  PlugInIcon,
  ListIcon,
  PageIcon,
  BoltIcon,
  AlertIcon,
} from "../icons";
import { useSidebar } from "../context/SidebarContext";
import { useAuth } from "../context/AuthContext";

type NavItem = {
  name: string;
  icon: React.ReactNode;
  path?: string;
  subItems?: { name: string; path: string }[];
};

const navItems: NavItem[] = [
  { icon: <GridIcon />,      name: "Tableau de bord", path: "/" },
  {
    icon: <GroupIcon />,
    name: "Clients",
    subItems: [
      { name: "Tous les clients", path: "/clients" },
      { name: "Nouveau client",   path: "/clients/new" },
    ],
  },
  { icon: <BoxCubeIcon />,   name: "Plans",      path: "/plans" },
  { icon: <PlugInIcon />,    name: "Licences",   path: "/licenses" },
  { icon: <DollarLineIcon />,name: "Paiements",  path: "/payments" },
  { icon: <PageIcon />,      name: "Factures",   path: "/invoices" },
  { icon: <ListIcon />,      name: "Activité",      path: "/activity" },
  { icon: <AlertIcon />,    name: "Notifications", path: "/notifications" },
  { icon: <BoltIcon />,     name: "Mises à jour",  path: "/updates" },
  { icon: <GroupIcon />,    name: "Équipe",         path: "/team" },
  { icon: <ListIcon />,     name: "Rôles",           path: "/roles" },
];

const othersItems: NavItem[] = [
  {
    icon: <PageIcon />,
    name: "Rapports",
    subItems: [
      { name: "Revenus",       path: "/reports/revenue" },
      { name: "Abonnements",   path: "/reports/subscriptions" },
      { name: "Clients",       path: "/reports/clients" },
    ],
  },
  { icon: <PlugInIcon />,     name: "Paramètres",  path: "/settings" },
  { icon: <UserCircleIcon />, name: "Mon profil",  path: "/profile" },
];

const AppSidebar: React.FC = () => {
  const { isExpanded, isMobileOpen, isHovered, setIsHovered } = useSidebar();
  const { admin, logout } = useAuth();
  const location = useLocation();
  const navigate = useNavigate();

  const [openSubmenu, setOpenSubmenu] = useState<{
    type: "main" | "others";
    index: number;
  } | null>(null);
  const [subMenuHeight, setSubMenuHeight] = useState<Record<string, number>>({});
  const subMenuRefs = useRef<Record<string, HTMLDivElement | null>>({});

  const isActive = useCallback(
    (path: string) => location.pathname === path,
    [location.pathname]
  );

  useEffect(() => {
    let matched = false;
    (["main", "others"] as const).forEach((menuType) => {
      const items = menuType === "main" ? navItems : othersItems;
      items.forEach((nav, index) => {
        nav.subItems?.forEach((sub) => {
          if (isActive(sub.path)) {
            setOpenSubmenu({ type: menuType, index });
            matched = true;
          }
        });
      });
    });
    if (!matched) setOpenSubmenu(null);
  }, [location, isActive]);

  useEffect(() => {
    if (openSubmenu !== null) {
      const key = `${openSubmenu.type}-${openSubmenu.index}`;
      if (subMenuRefs.current[key]) {
        setSubMenuHeight((prev) => ({
          ...prev,
          [key]: subMenuRefs.current[key]?.scrollHeight ?? 0,
        }));
      }
    }
  }, [openSubmenu]);

  function handleLogout() {
    logout();
    navigate("/signin");
  }

  const show = isExpanded || isHovered || isMobileOpen;

  /* ── Bonresto colours ────────────────────────────────────── */
  // sidebar bg    : #2c3136
  // row hover/open: #33383e
  // accent green  : #37a000
  // text default  : #a6a6a6  active: #fff

  const renderMenuItems = (items: NavItem[], menuType: "main" | "others") => (
    <ul className="flex flex-col gap-1.5">
      {items.map((nav, index) => {
        const isOpen = openSubmenu?.type === menuType && openSubmenu?.index === index;
        const active = nav.path ? isActive(nav.path) : false;

        return (
          <li key={nav.name}>
            {nav.subItems ? (
              <button
                onClick={() =>
                  setOpenSubmenu((prev) =>
                    prev?.type === menuType && prev?.index === index
                      ? null
                      : { type: menuType, index }
                  )
                }
                className={`group flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                  ${isOpen
                    ? "bg-white/10 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.08)]"
                    : "text-[#c8ceda] hover:bg-white/8 hover:text-white"}
                  ${!show ? "justify-center px-2.5" : "justify-start"}`}
              >
                <span className={`flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-white/10 transition-all ${isOpen ? "bg-[#37a000]/20 text-[#37a000]" : "bg-white/6 text-[#aeb5c3] group-hover:bg-white/10 group-hover:text-white"}`}>
                  {nav.icon}
                </span>
                {show && <span className="flex-1 text-left">{nav.name}</span>}
                {show && (
                  <ChevronDownIcon
                    className={`h-4 w-4 transition-transform duration-200 ${isOpen ? "rotate-180 text-[#37a000]" : "text-[#8a92a3]"}`}
                  />
                )}
              </button>
            ) : (
              nav.path && (
                <Link
                  to={nav.path}
                  className={`group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200
                    ${active
                      ? "bg-gradient-to-r from-[#37a000]/20 to-[#37a000]/10 text-white shadow-[inset_0_1px_0_rgba(255,255,255,0.08)]"
                      : "text-[#c8ceda] hover:bg-white/8 hover:text-white"}
                    ${!show ? "justify-center px-2.5" : ""}`}
                >
                  <span className={`flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-white/10 transition-all ${active ? "bg-[#37a000]/20 text-[#37a000]" : "bg-white/6 text-[#aeb5c3] group-hover:bg-white/10 group-hover:text-white"}`}>
                    {nav.icon}
                  </span>
                  {show && <span>{nav.name}</span>}
                </Link>
              )
            )}

            {nav.subItems && show && (
              <div
                ref={(el) => { subMenuRefs.current[`${menuType}-${index}`] = el; }}
                className="overflow-hidden transition-all duration-300"
                style={{
                  height: isOpen ? `${subMenuHeight[`${menuType}-${index}`] ?? 0}px` : "0px",
                }}
              >
                <ul className="mt-1 ml-3 space-y-1 rounded-xl border border-white/8 bg-black/10 p-2">
                  {nav.subItems.map((sub) => (
                    <li key={sub.name}>
                      <Link
                        to={sub.path}
                        className={`block rounded-lg px-3 py-2 text-sm transition-all
                          ${isActive(sub.path)
                            ? "bg-[#37a000]/15 text-[#7ce45b] font-semibold"
                            : "text-[#9aa4b2] hover:bg-white/8 hover:text-white"}`}
                      >
                        {sub.name}
                      </Link>
                    </li>
                  ))}
                </ul>
              </div>
            )}
          </li>
        );
      })}
    </ul>
  );

  return (
    <aside
      className={`fixed mt-16 flex flex-col lg:mt-0 top-0 px-3 left-0 h-screen transition-all duration-300 ease-in-out z-50
        ${isExpanded || isMobileOpen ? "w-[270px]" : isHovered ? "w-[270px]" : "w-[78px]"}
        ${isMobileOpen ? "translate-x-0" : "-translate-x-full"}
        lg:translate-x-0`}
      style={{ background: "linear-gradient(180deg, #252a30 0%, #1f2328 100%)", borderRight: "1px solid rgba(255,255,255,0.08)" }}
      onMouseEnter={() => !isExpanded && setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      <div className={`py-4 ${!show ? "lg:justify-center" : "px-1"}`}>
        <Link
          to="/"
          className={`flex items-center ${show ? "gap-3 rounded-2xl border border-white/10 bg-white/5 p-3 shadow-[0_8px_30px_rgba(0,0,0,0.2)]" : "justify-center rounded-2xl border border-white/10 bg-white/5 p-2.5"}`}
        >
          <div className="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-[#37a000] to-[#2d8700] shadow-lg shadow-[#37a000]/20">
            <img
              src="/images/logo/bonresto-logo.png"
              alt="Bonresto"
              className={show ? "h-8 w-8 object-contain" : "h-7 w-7 object-contain"}
            />
          </div>
          {show && (
            <div className="min-w-0">
              <p className="text-sm font-semibold text-white">
                Bonresto <span className="text-[#37a000]">SaaS</span>
              </p>
              <p className="text-[11px] uppercase tracking-[0.28em] text-[#8a92a3]">
                Administration
              </p>
            </div>
          )}
        </Link>
      </div>

      <div className="flex flex-col flex-1 overflow-y-auto no-scrollbar">
        <nav className="mb-6 space-y-5">
          <div>
            {show && (
              <div className="mb-2 flex items-center justify-between px-3">
                <p className="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#5c6370]">
                  Menu
                </p>
                <span className="rounded-full bg-[#37a000]/15 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-[0.2em] text-[#7ce45b]">
                  Live
                </span>
              </div>
            )}
            {!show && (
              <div className="mb-2 flex justify-center">
                <HorizontaLDots className="size-5 text-[#5c6370]" />
              </div>
            )}
            {renderMenuItems(navItems, "main")}
          </div>

          <div>
            {show && (
              <p className="mb-2 px-3 text-[10px] font-semibold uppercase tracking-[0.3em] text-[#5c6370]">
                Autres
              </p>
            )}
            {!show && (
              <div className="mb-2 flex justify-center">
                <HorizontaLDots className="size-5 text-[#5c6370]" />
              </div>
            )}
            {renderMenuItems(othersItems, "others")}
          </div>
        </nav>
      </div>

      {show && admin && (
        <div className="pb-4 pt-3">
          <div className="rounded-2xl border border-white/10 bg-white/5 p-3 shadow-[0_12px_32px_rgba(0,0,0,0.2)]">
            <div className="flex items-center gap-3">
              <div className="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-[#37a000] to-[#2d8700] text-sm font-bold text-white">
                {admin.name?.split(" ").map((w) => w[0]).join("").toUpperCase().slice(0, 2) ?? "AD"}
              </div>
              <div className="min-w-0 flex-1">
                <p className="truncate text-sm font-semibold text-white">{admin.name}</p>
                <p className="truncate text-xs text-[#a6a6a6]">{admin.email}</p>
              </div>
            </div>
            <button
              onClick={handleLogout}
              className="mt-3 flex w-full items-center gap-2 rounded-lg border border-red-400/20 bg-red-400/10 px-2.5 py-2 text-left text-xs font-medium text-red-300 transition-colors hover:bg-red-400/20"
            >
              <span>↩</span>
              <span>Se déconnecter</span>
            </button>
          </div>
        </div>
      )}
    </aside>
  );
};

export default AppSidebar;
