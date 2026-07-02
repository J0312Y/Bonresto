import Chart from "react-apexcharts";
import type { ApexOptions } from "apexcharts";
import type { DashboardStats } from "../../types/saas";

interface Props {
  stats: DashboardStats;
}

const PLAN_COLORS: Record<string, string> = {
  Basic: "#60a5fa",
  Pro: "#a78bfa",
  Enterprise: "#fb923c",
};

export default function PlansBreakdown({ stats }: Props) {
  const plans = stats.subscriptions_by_plan;
  const labels = plans.map((p) => p.plan);
  const series = plans.map((p) => p.count);
  const colors = labels.map((l) => PLAN_COLORS[l] ?? "#465fff");

  const options: ApexOptions = {
    chart: {
      type: "donut",
      fontFamily: "Outfit, sans-serif",
      toolbar: { show: false },
    },
    colors,
    labels,
    legend: {
      show: true,
      position: "bottom",
      fontFamily: "Outfit, sans-serif",
      fontSize: "13px",
    },
    dataLabels: {
      enabled: true,
      formatter: (val: number) => `${Math.round(val)}%`,
    },
    plotOptions: {
      pie: {
        donut: {
          size: "65%",
          labels: {
            show: true,
            total: {
              show: true,
              label: "Total",
              fontSize: "14px",
              color: "#6b7280",
              formatter: () => `${series.reduce((a, b) => a + b, 0)}`,
            },
          },
        },
      },
    },
    tooltip: {
      y: { formatter: (val: number) => `${val} client${val > 1 ? "s" : ""}` },
    },
  };

  if (plans.length === 0) {
    return (
      <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03] md:p-6 h-full flex flex-col">
        <h3 className="text-lg font-semibold text-gray-800 text-white/90 mb-4">
          Répartition des plans
        </h3>
        <div className="flex-1 flex items-center justify-center text-gray-400 text-sm">
          Aucun abonnement actif
        </div>
      </div>
    );
  }

  return (
    <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03] md:p-6">
      <h3 className="text-lg font-semibold text-gray-800 text-white/90 mb-2">
        Répartition des plans
      </h3>
      <p className="text-sm text-gray-500 text-gray-400 mb-4">
        Abonnements actifs par offre
      </p>
      <Chart options={options} series={series} type="donut" height={280} />
    </div>
  );
}
