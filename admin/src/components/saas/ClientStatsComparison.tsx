import Chart from "react-apexcharts";
import type { ApexOptions } from "apexcharts";
import { useState } from "react";
import type { ClientStats } from "../../types/saas";

type Metric = "total_revenue" | "payment_count";

const METRICS: { key: Metric; label: string }[] = [
  { key: "total_revenue",  label: "Revenus (FCFA)" },
  { key: "payment_count",  label: "Paiements" },
];

interface Props {
  clients: ClientStats[];
}

export default function ClientStatsComparison({ clients }: Props) {
  const [metric, setMetric] = useState<Metric>("total_revenue");

  const sorted = [...clients].sort((a, b) => b[metric] - a[metric]);
  const categories = sorted.map((c) => c.business_name);
  const values = sorted.map((c) => Math.round(c[metric]));

  const options: ApexOptions = {
    chart: {
      type: "bar",
      fontFamily: "Outfit, sans-serif",
      toolbar: { show: false },
    },
    colors: ["#465fff"],
    plotOptions: {
      bar: {
        horizontal: true,
        borderRadius: 4,
        borderRadiusApplication: "end",
        barHeight: "55%",
      },
    },
    dataLabels: { enabled: false },
    xaxis: {
      categories,
      labels: {
        formatter: (val: string) =>
          metric === "total_revenue"
            ? `${Number(val).toLocaleString("fr-FR")} F`
            : val,
        style: { colors: "#9ca3af", fontSize: "11px" },
      },
      axisBorder: { show: false },
      axisTicks: { show: false },
    },
    yaxis: {
      labels: {
        style: { colors: "#6b7280", fontSize: "12px" },
        maxWidth: 120,
      },
    },
    grid: {
      xaxis: { lines: { show: true } },
      yaxis: { lines: { show: false } },
      borderColor: "#f3f4f6",
      strokeDashArray: 4,
    },
    tooltip: {
      y: {
        formatter: (val: number) =>
          metric === "total_revenue"
            ? `${val.toLocaleString("fr-FR")} FCFA`
            : String(val),
      },
    },
  };

  return (
    <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6 sm:pt-6">
      <div className="flex flex-wrap items-center justify-between gap-3 mb-4">
        <div>
          <h3 className="text-lg font-semibold text-gray-800 dark:text-white/90">
            Comparaison des restaurants
          </h3>
          <p className="text-sm text-gray-500 dark:text-gray-400">
            Classement par indicateur
          </p>
        </div>
        <div className="flex gap-2">
          {METRICS.map((m) => (
            <button
              key={m.key}
              onClick={() => setMetric(m.key)}
              className={`px-3 py-1.5 text-xs font-medium rounded-lg transition-colors ${
                metric === m.key
                  ? "bg-brand-500 text-white"
                  : "bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700"
              }`}
            >
              {m.label}
            </button>
          ))}
        </div>
      </div>

      {clients.length === 0 ? (
        <div className="flex items-center justify-center h-40 text-sm text-gray-400">
          Aucune donnée
        </div>
      ) : (
        <div className="max-w-full overflow-x-auto pb-4">
          <Chart
            options={options}
            series={[{ name: METRICS.find((m) => m.key === metric)?.label ?? "", data: values }]}
            type="bar"
            height={Math.max(180, sorted.length * 52)}
          />
        </div>
      )}
    </div>
  );
}
