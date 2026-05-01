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
    <ul className="flex flex-col gap-1">
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
                className={`w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                  ${isOpen
                    ? "bg-[#33383e] text-white"
                    : "text-[#a6a6a6] hover:bg-[#33383e] hover:text-white"}
                  ${!show ? "lg:justify-center" : "justify-start"}`}
              >
                <span className="size-5 flex-shrink-0">{nav.icon}</span>
                {show && <span className="flex-1 text-left">{nav.name}</span>}
                {show && (
                  <ChevronDownIcon
                    className={`w-4 h-4 transition-transform duration-200 ${isOpen ? "rotate-180 text-[#37a000]" : ""}`}
                  />
                )}
              </button>
            ) : (
              nav.path && (
                <Link
                  to={nav.path}
                  className={`flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                    ${active
                      ? "bg-[#33383e] text-white border-l-4 border-[#37a000]"
                      : "text-[#a6a6a6] hover:bg-[#33383e] hover:text-white border-l-4 border-transparent"}
                    ${!show ? "lg:justify-center" : ""}`}
                >
                  <span className={`size-5 flex-shrink-0 ${active ? "text-[#37a000]" : ""}`}>
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
                <ul className="mt-1 ml-8 space-y-1 border-l border-[#33383e] pl-3">
                  {nav.subItems.map((sub) => (
                    <li key={sub.name}>
                      <Link
                        to={sub.path}
                        className={`block rounded-lg px-3 py-2 text-sm transition-colors
                          ${isActive(sub.path)
                            ? "text-[#37a000] font-semibold"
                            : "text-[#a6a6a6] hover:text-white"}`}
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
      style={{ backgroundColor: "#2c3136", borderRight: "1px solid #33383e" }}
      onMouseEnter={() => !isExpanded && setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      {/* Logo */}
      <div className={`py-4 flex items-center ${!show ? "lg:justify-center" : "justify-start px-1"}`}>
        <Link to="/" className="flex items-center gap-2">
          <img
            src="/images/logo/bonresto-logo.png"
            alt="Bonresto"
            className={show ? "h-10 w-10 object-contain" : "h-9 w-9 object-contain"}
          />
          {show && (
            <span className="text-base font-bold text-white tracking-wide">
              Bonresto <span className="text-[#37a000]">SaaS</span>
            </span>
          )}
        </Link>
      </div>

      {/* Nav */}
      <div className="flex flex-col flex-1 overflow-y-auto no-scrollbar">
        <nav className="mb-6 space-y-6">
          <div>
            {show && (
              <p className="mb-2 px-3 text-[10px] font-semibold uppercase tracking-widest text-[#5c6370]">
                Menu
              </p>
            )}
            {!show && (
              <div className="flex justify-center mb-2">
                <HorizontaLDots className="size-5 text-[#5c6370]" />
              </div>
            )}
            {renderMenuItems(navItems, "main")}
          </div>

          <div>
            {show && (
              <p className="mb-2 px-3 text-[10px] font-semibold uppercase tracking-widest text-[#5c6370]">
                Autres
              </p>
            )}
            {!show && (
              <div className="flex justify-center mb-2">
                <HorizontaLDots className="size-5 text-[#5c6370]" />
              </div>
            )}
            {renderMenuItems(othersItems, "others")}
          </div>
        </nav>
      </div>

      {/* Bottom admin info */}
      {show && admin && (
        <div className="pb-5 pt-4 border-t border-[#33383e]">
          <div className="flex items-center gap-3 px-1">
            <div className="flex items-center justify-center w-8 h-8 rounded-full bg-[#37a000] text-white text-xs font-bold flex-shrink-0">
              {admin.name?.split(" ").map((w) => w[0]).join("").toUpperCase().slice(0, 2) ?? "AD"}
            </div>
            <div className="flex-1 min-w-0">
              <p className="text-sm font-medium text-white truncate">{admin.name}</p>
              <p className="text-xs text-[#a6a6a6] truncate">{admin.email}</p>
            </div>
          </div>
          <button
            onClick={handleLogout}
            className="mt-3 w-full text-left px-1 text-xs text-[#a6a6a6] hover:text-red-400 transition-colors"
          >
            → Se déconnecter
          </button>
        </div>
      )}
    </aside>
  );
};

export default AppSidebar;
