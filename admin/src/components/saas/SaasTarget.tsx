import Chart from "react-apexcharts";
import type { ApexOptions } from "apexcharts";
import type { DashboardStats } from "../../types/saas";

interface Props {
  stats: DashboardStats;
}

export default function SaasTarget({ stats }: Props) {
  const rate =
    stats.total_clients > 0
      ? Math.round((stats.active_subscriptions / stats.total_clients) * 100)
      : 0;

  const fmt = (n: number) => `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

  const options: ApexOptions = {
    colors: ["#465FFF"],
    chart: {
      fontFamily: "Outfit, sans-serif",
      type: "radialBar",
      height: 330,
      sparkline: { enabled: true },
    },
    plotOptions: {
      radialBar: {
        startAngle: -85,
        endAngle: 85,
        hollow: { size: "80%" },
        track: {
          background: "#E4E7EC",
          strokeWidth: "100%",
          margin: 5,
        },
        dataLabels: {
          name: { show: false },
          value: {
            fontSize: "36px",
            fontWeight: "600",
            offsetY: -40,
            color: "#1D2939",
            formatter: (val: number) => val + "%",
          },
        },
      },
    },
    fill: { type: "solid", colors: ["#465FFF"] },
    stroke: { lineCap: "round" },
    labels: ["Activation"],
  };

  return (
    <div className="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-white/[0.03]">
      <div className="px-5 pt-5 bg-white shadow-default rounded-2xl pb-11 dark:bg-gray-900 sm:px-6 sm:pt-6">
        <div className="flex justify-between">
          <div>
            <h3 className="text-lg font-semibold text-gray-800 dark:text-white/90">
              Taux d'activation
            </h3>
            <p className="mt-1 text-gray-500 text-theme-sm dark:text-gray-400">
              Clients avec un abonnement actif
            </p>
          </div>
        </div>

        <div className="relative">
          <div className="max-h-[330px]">
            <Chart options={options} series={[rate]} type="radialBar" height={330} />
          </div>
          <span className="absolute left-1/2 top-full -translate-x-1/2 -translate-y-[95%] rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-600 dark:bg-success-500/15 dark:text-success-500">
            {stats.active_subscriptions} actifs
          </span>
        </div>

        <p className="mx-auto mt-10 w-full max-w-[380px] text-center text-sm text-gray-500 sm:text-base">
          {stats.new_clients_this_month > 0
            ? `+${stats.new_clients_this_month} nouveau${stats.new_clients_this_month > 1 ? "x" : ""} client${stats.new_clients_this_month > 1 ? "s" : ""} ce mois. Continuez sur cette lancée !`
            : "Suivez vos abonnements et relancez les clients inactifs."}
        </p>
      </div>

      <div className="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
        <div>
          <p className="mb-1 text-center text-gray-500 text-theme-xs dark:text-gray-400 sm:text-sm">
            MRR
          </p>
          <p className="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
            {fmt(stats.mrr)}
          </p>
        </div>

        <div className="w-px bg-gray-200 h-7 dark:bg-gray-800" />

        <div>
          <p className="mb-1 text-center text-gray-500 text-theme-xs dark:text-gray-400 sm:text-sm">
            Ce mois
          </p>
          <p className="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 dark:text-white/90 sm:text-lg">
            {fmt(stats.revenue_this_month)}
          </p>
        </div>

        <div className="w-px bg-gray-200 h-7 dark:bg-gray-800" />

        <div>
          <p className="mb-1 text-center text-gray-500 text-theme-xs dark:text-gray-400 sm:text-sm">
            Expirent
          </p>
          <p className={`flex items-center justify-center gap-1 text-base font-semibold sm:text-lg ${stats.expiring_soon > 0 ? "text-warning-600 dark:text-warning-400" : "text-gray-800 dark:text-white/90"}`}>
            {stats.expiring_soon}
          </p>
        </div>
      </div>
    </div>
  );
}
