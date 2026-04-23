import { useAuth } from "../../context/AuthContext";

export default function UserInfoCard() {
  const { admin } = useAuth();

  const nameParts = (admin?.name ?? "Super Admin").split(" ");
  const firstName = nameParts[0] ?? "";
  const lastName = nameParts.slice(1).join(" ") || "Admin";

  return (
    <div className="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
      <h4 className="mb-6 text-lg font-semibold text-gray-800 dark:text-white/90">
        Informations personnelles
      </h4>

      <div className="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7">
        <div>
          <p className="mb-1 text-xs text-gray-500 dark:text-gray-400">Prénom</p>
          <p className="text-sm font-medium text-gray-800 dark:text-white/90">{firstName}</p>
        </div>
        <div>
          <p className="mb-1 text-xs text-gray-500 dark:text-gray-400">Nom</p>
          <p className="text-sm font-medium text-gray-800 dark:text-white/90">{lastName}</p>
        </div>
        <div>
          <p className="mb-1 text-xs text-gray-500 dark:text-gray-400">Email</p>
          <p className="text-sm font-medium text-gray-800 dark:text-white/90">{admin?.email ?? "—"}</p>
        </div>
        <div>
          <p className="mb-1 text-xs text-gray-500 dark:text-gray-400">Rôle</p>
          <p className="text-sm font-medium text-gray-800 dark:text-white/90">Super Admin</p>
        </div>
      </div>
    </div>
  );
}
