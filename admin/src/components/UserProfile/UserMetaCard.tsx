import { useAuth } from "../../context/AuthContext";

export default function UserMetaCard() {
  const { admin } = useAuth();

  const initials = admin?.name
    ? admin.name.split(" ").map((w) => w[0]).join("").toUpperCase().slice(0, 2)
    : "AD";

  return (
    <div className="p-5 border border-gray-200 rounded-2xl border-gray-800 lg:p-6">
      <div className="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
        <div className="flex flex-col items-center w-full gap-6 xl:flex-row">
          {/* Avatar avec initiales */}
          <div className="flex items-center justify-center w-20 h-20 rounded-full bg-brand-500 text-white text-2xl font-bold border border-gray-200 border-gray-800">
            {initials}
          </div>

          <div>
            <h4 className="mb-1 text-lg font-semibold text-center text-gray-800 text-white/90 xl:text-left">
              {admin?.name ?? "Administrateur"}
            </h4>
            <p className="text-sm text-gray-500 text-gray-400 text-center xl:text-left">
              {admin?.email ?? ""}
            </p>
            <span className="inline-block mt-1 px-2.5 py-0.5 text-xs font-medium bg-brand-50 text-brand-600 rounded-full bg-brand-500/10 text-brand-400">
              Super Admin
            </span>
          </div>
        </div>
      </div>
    </div>
  );
}
