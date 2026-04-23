export default function UserAddressCard() {
  return (
    <div className="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
      <h4 className="mb-6 text-lg font-semibold text-gray-800 dark:text-white/90">
        Plateforme
      </h4>
      <div className="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7">
        <div>
          <p className="mb-1 text-xs text-gray-500 dark:text-gray-400">Nom</p>
          <p className="text-sm font-medium text-gray-800 dark:text-white/90">Bonresto SaaS</p>
        </div>
        <div>
          <p className="mb-1 text-xs text-gray-500 dark:text-gray-400">Version</p>
          <p className="text-sm font-medium text-gray-800 dark:text-white/90">1.0.0</p>
        </div>
        <div>
          <p className="mb-1 text-xs text-gray-500 dark:text-gray-400">API</p>
          <p className="text-sm font-medium text-gray-800 dark:text-white/90">
            {import.meta.env.VITE_API_URL || "http://localhost/bonresto/index.php/saas"}
          </p>
        </div>
      </div>
    </div>
  );
}
