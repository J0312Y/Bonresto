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
    colors: ["#37a000"],
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
          background: "#e5e7eb",
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
    fill: { type: "solid", colors: ["#37a000"] },
    stroke: { lineCap: "round" },
    labels: ["Activation"],
  };

  return (
    <div className="overflow-hidden rounded-[28px] border border-gray-200/80 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.06)] border-gray-800 bg-gray-900/80">
      <div className="rounded-[28px] bg-gradient-to-br from-white to-emerald-50/60 px-5 pb-10 pt-5 from-gray-900 to-gray-900 sm:px-6 sm:pt-6">
        <div className="flex items-start justify-between gap-3">
          <div>
            <p className="text-xs font-semibold uppercase tracking-[0.24em] text-[#37a000]">Système de santé</p>
            <h3 className="mt-1 text-lg font-semibold text-gray-900 text-white/90">
              Taux d'activation
            </h3>
            <p className="mt-1 text-sm text-gray-500 text-gray-400">
              Clients avec un abonnement actif
            </p>
          </div>
          <span className="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 border-emerald-500/20 bg-emerald-500/10 text-emerald-400">
            {stats.active_subscriptions} actifs
          </span>
        </div>

        <div className="relative mt-4">
          <div className="max-h-[330px]">
            <Chart options={options} series={[rate]} type="radialBar" height={330} />
          </div>
        </div>

        <p className="mx-auto mt-2 w-full max-w-[380px] text-center text-sm text-gray-500 sm:text-base">
          {stats.new_clients_this_month > 0
            ? `+${stats.new_clients_this_month} nouveau${stats.new_clients_this_month > 1 ? "x" : ""} client${stats.new_clients_this_month > 1 ? "s" : ""} ce mois. Continuez sur cette lancée !`
            : "Suivez vos abonnements et relancez les clients inactifs."}
        </p>
      </div>

      <div className="flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5">
        <div>
          <p className="mb-1 text-center text-gray-500 text-theme-xs text-gray-400 sm:text-sm">
            MRR
          </p>
          <p className="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 text-white/90 sm:text-lg">
            {fmt(stats.mrr)}
          </p>
        </div>

        <div className="w-px bg-gray-200 h-7 bg-gray-800" />

        <div>
          <p className="mb-1 text-center text-gray-500 text-theme-xs text-gray-400 sm:text-sm">
            Ce mois
          </p>
          <p className="flex items-center justify-center gap-1 text-base font-semibold text-gray-800 text-white/90 sm:text-lg">
            {fmt(stats.revenue_this_month)}
          </p>
        </div>

        <div className="w-px bg-gray-200 h-7 bg-gray-800" />

        <div>
          <p className="mb-1 text-center text-gray-500 text-theme-xs text-gray-400 sm:text-sm">
            Expirent
          </p>
          <p className={`flex items-center justify-center gap-1 text-base font-semibold sm:text-lg ${stats.expiring_soon > 0 ? "text-warning-600 text-warning-400" : "text-gray-800 text-white/90"}`}>
            {stats.expiring_soon}
          </p>
        </div>
      </div>
    </div>
  );
}
