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
    colors: ["#465fff"],
    chart: {
      fontFamily: "Outfit, sans-serif",
      type: "bar",
      height: 180,
      toolbar: { show: false },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "39%",
        borderRadius: 5,
        borderRadiusApplication: "end",
      },
    },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 4, colors: ["transparent"] },
    xaxis: {
      categories: months.length > 0 ? months : ["Jan","Fév","Mar","Avr","Mai","Jun","Jul","Aoû","Sep","Oct","Nov","Déc"],
      axisBorder: { show: false },
      axisTicks: { show: false },
    },
    legend: {
      show: true,
      position: "top",
      horizontalAlign: "left",
      fontFamily: "Outfit",
    },
    yaxis: {
      labels: {
        formatter: (val: number) => `€${val.toLocaleString("fr-FR")}`,
      },
    },
    grid: { yaxis: { lines: { show: true } } },
    fill: { opacity: 1 },
    tooltip: {
      x: { show: false },
      y: {
        formatter: (val: number) =>
          new Intl.NumberFormat("fr-FR", { style: "currency", currency: "EUR" }).format(val),
      },
    },
  };

  const series = [{ name: "Revenus", data: revenues.length > 0 ? revenues : [] }];

  return (
    <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
      <div className="flex items-center justify-between">
        <h3 className="text-lg font-semibold text-gray-800 dark:text-white/90">
          Revenus mensuels
        </h3>
        <span className="text-sm text-gray-400 dark:text-gray-500">
          12 derniers mois
        </span>
      </div>
      <div className="max-w-full overflow-x-auto custom-scrollbar">
        <div className="-ml-5 min-w-[650px] xl:min-w-full pl-2">
          <Chart options={options} series={series} type="bar" height={180} />
        </div>
      </div>
    </div>
  );
}
