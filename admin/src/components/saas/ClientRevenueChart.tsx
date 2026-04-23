import Chart from "react-apexcharts";
import type { ApexOptions } from "apexcharts";
import type { ClientRevenueMonth } from "../../types/saas";

interface Props {
  data: ClientRevenueMonth[];
}

const COLORS = ["#465fff", "#a855f7", "#f97316", "#22c55e", "#ec4899", "#06b6d4"];

export default function ClientRevenueChart({ data }: Props) {
  // Build months axis (unique, ordered)
  const monthKeys = [...new Set(data.map((d) => d.month_key))].sort();
  const monthLabels = monthKeys.map((k) => {
    const [y, m] = k.split("-");
    return new Date(Number(y), Number(m) - 1).toLocaleDateString("fr-FR", { month: "short", year: "2-digit" });
  });

  // Build series per tenant
  const tenantMap = new Map<string, { name: string; revenues: Record<string, number> }>();
  for (const row of data) {
    if (!tenantMap.has(String(row.tenant_id))) {
      tenantMap.set(String(row.tenant_id), { name: row.business_name, revenues: {} });
    }
    tenantMap.get(String(row.tenant_id))!.revenues[row.month_key] = Number(row.revenue);
  }

  const series = Array.from(tenantMap.values()).map(({ name, revenues }) => ({
    name,
    data: monthKeys.map((mk) => Math.round(revenues[mk] ?? 0)),
  }));

  const options: ApexOptions = {
    chart: {
      type: "bar",
      fontFamily: "Outfit, sans-serif",
      toolbar: { show: false },
      stacked: false,
    },
    colors: COLORS,
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: series.length > 2 ? "70%" : "50%",
        borderRadius: 4,
        borderRadiusApplication: "end",
      },
    },
    dataLabels: { enabled: false },
    stroke: { show: true, width: 2, colors: ["transparent"] },
    xaxis: {
      categories: monthLabels,
      axisBorder: { show: false },
      axisTicks: { show: false },
      labels: { style: { colors: "#9ca3af", fontSize: "12px" } },
    },
    yaxis: {
      labels: {
        formatter: (val: number) => `${val.toLocaleString("fr-FR")} F`,
        style: { colors: "#9ca3af", fontSize: "11px" },
      },
    },
    legend: {
      show: true,
      position: "top",
      horizontalAlign: "left",
      fontFamily: "Outfit",
      fontSize: "13px",
    },
    grid: {
      yaxis: { lines: { show: true } },
      borderColor: "#f3f4f6",
      strokeDashArray: 4,
    },
    fill: { opacity: 1 },
    tooltip: {
      y: {
        formatter: (val: number) => `${val.toLocaleString("fr-FR")} FCFA`,
      },
    },
  };

  return (
    <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
      <div className="flex items-center justify-between mb-2">
        <h3 className="text-lg font-semibold text-gray-800 dark:text-white/90">
          Revenus mensuels par restaurant
        </h3>
        <span className="text-sm text-gray-400 dark:text-gray-500">6 mois</span>
      </div>

      {series.length === 0 ? (
        <div className="flex items-center justify-center h-40 text-sm text-gray-400">
          Aucune donnée de commandes
        </div>
      ) : (
        <div className="max-w-full overflow-x-auto custom-scrollbar">
          <div className="-ml-5 min-w-[650px] xl:min-w-full pl-2">
            <Chart options={options} series={series} type="bar" height={220} />
          </div>
        </div>
      )}
    </div>
  );
}
