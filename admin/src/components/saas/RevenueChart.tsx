import Chart from "react-apexcharts";
import type { ApexOptions } from "apexcharts";
import type { DashboardStats } from "../../types/saas";

interface Props {
  stats: DashboardStats;
}

export default function RevenueChart({ stats }: Props) {
  const months = stats.revenue_by_month.map((r) => r.month);
  const revenues = stats.revenue_by_month.map((r) => r.revenue);

  const options: ApexOptions = {
    colors: ["#37a000"],
    chart: {
      fontFamily: "Outfit, sans-serif",
      type: "bar",
      height: 220,
      toolbar: { show: false },
      background: "transparent",
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "44%",
        borderRadius: 8,
        borderRadiusApplication: "end",
      },
    },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 0, colors: ["transparent"] },
    xaxis: {
      categories: months.length > 0 ? months : ["Jan","Fév","Mar","Avr","Mai","Jun","Jul","Aoû","Sep","Oct","Nov","Déc"],
      axisBorder: { show: false },
      axisTicks: { show: false },
    },
    legend: {
      show: false,
    },
    yaxis: {
      labels: {
        formatter: (val: number) => `${Math.round(val).toLocaleString("fr-FR")} F`,
      },
    },
    grid: {
      borderColor: "#e5e7eb",
      strokeDashArray: 4,
      yaxis: { lines: { show: true } },
    },
    fill: { opacity: 1 },
    tooltip: {
      x: { show: false },
      y: {
        formatter: (val: number) =>
          `${Math.round(val).toLocaleString("fr-FR")} XAF`,
      },
    },
  };

  const series = [{ name: "Revenus", data: revenues.length > 0 ? revenues : [] }];

  return (
    <div className="overflow-hidden rounded-[28px] border border-gray-200/80 bg-gradient-to-br from-white to-emerald-50/40 px-5 pt-5 shadow-[0_20px_60px_rgba(15,23,42,0.06)] border-gray-800 bg-gray-900/80 from-gray-900 to-gray-900 sm:px-6 sm:pt-6">
      <div className="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
          <p className="text-xs font-semibold uppercase tracking-[0.24em] text-[#37a000]">Performance</p>
          <h3 className="text-lg font-semibold text-gray-900 text-white/90">
            Revenus mensuels
          </h3>
        </div>
        <span className="inline-flex w-fit rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700 border-emerald-500/20 bg-emerald-500/10 text-emerald-400">
          12 derniers mois
        </span>
      </div>
      <div className="mt-4 max-w-full overflow-x-auto custom-scrollbar">
        <div className="-ml-5 min-w-[650px] pl-2 lg:min-w-full">
          <Chart options={options} series={series} type="bar" height={220} />
        </div>
      </div>
    </div>
  );
}
