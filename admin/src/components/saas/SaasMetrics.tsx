import {
  GroupIcon,
  CheckCircleIcon,
  DollarLineIcon,
  ShootingStarIcon,
  AlertIcon,
  PieChartIcon,
  ArrowUpIcon,
  ArrowDownIcon,
} from "../../icons";
import type { DashboardStats } from "../../types/saas";

const fcfa = (n: number) =>
  `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

interface CardProps {
  label: string;
  value: string | number;
  sub?: string;
  trend?: { label: string; up: boolean };
  icon: React.ReactNode;
  iconBg: string;
}

function MetricCard({ label, value, sub, trend, icon, iconBg }: CardProps) {
  return (
    <div className="rounded-2xl border border-gray-200 bg-white p-5 border-gray-800 bg-white/[0.03] md:p-6">
      <div className={`flex items-center justify-center w-12 h-12 rounded-xl ${iconBg}`}>
        {icon}
      </div>
      <div className="flex items-end justify-between mt-5">
        <div>
          <span className="text-sm text-gray-500 text-gray-400">{label}</span>
          <h4 className="mt-2 font-bold text-gray-800 text-title-sm text-white/90">
            {value}
          </h4>
          {sub && (
            <span className="text-xs text-gray-400 text-gray-500">{sub}</span>
          )}
        </div>
        {trend && (
          <span
            className={`inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium ${
              trend.up
                ? "bg-success-50 text-success-600 bg-success-500/15 text-success-400"
                : "bg-error-50 text-error-600 bg-error-500/15 text-error-400"
            }`}
          >
            {trend.up ? (
              <ArrowUpIcon className="w-3 h-3" />
            ) : (
              <ArrowDownIcon className="w-3 h-3" />
            )}
            {trend.label}
          </span>
        )}
      </div>
    </div>
  );
}

export default function SaasMetrics({ stats }: { stats: DashboardStats }) {
  const activationRate =
    stats.total_clients > 0
      ? Math.round((stats.active_subscriptions / stats.total_clients) * 100)
      : 0;

  return (
    <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3 md:gap-6">
      <MetricCard
        label="Total clients"
        value={stats.total_clients}
        sub={`+${stats.new_clients_this_month} ce mois`}
        trend={
          stats.new_clients_this_month > 0
            ? { label: `${stats.new_clients_this_month} nouveaux`, up: true }
            : undefined
        }
        icon={<GroupIcon className="text-blue-600 size-6 text-blue-400" />}
        iconBg="bg-blue-50 bg-blue-500/10"
      />
      <MetricCard
        label="Abonnements actifs"
        value={stats.active_subscriptions}
        sub={`sur ${stats.total_clients} clients`}
        icon={<CheckCircleIcon className="text-green-600 size-6 text-green-400" />}
        iconBg="bg-green-50 bg-green-500/10"
      />
      <MetricCard
        label="Revenus du mois"
        value={fcfa(stats.revenue_this_month)}
        trend={{ label: "ce mois", up: true }}
        icon={<DollarLineIcon className="text-purple-600 size-6 text-purple-400" />}
        iconBg="bg-purple-50 bg-purple-500/10"
      />
      <MetricCard
        label="MRR"
        value={fcfa(stats.mrr)}
        sub="Revenus mensuels récurrents"
        trend={
          stats.mrr_trend !== undefined
            ? { label: `${stats.mrr_trend > 0 ? "+" : ""}${stats.mrr_trend}% vs mois dernier`, up: stats.mrr_trend >= 0 }
            : undefined
        }
        icon={<ShootingStarIcon className="text-orange-500 size-6 text-orange-400" />}
        iconBg="bg-orange-50 bg-orange-500/10"
      />
      <MetricCard
        label="Expirent bientôt"
        value={stats.expiring_soon}
        sub="dans les 7 prochains jours"
        trend={
          stats.expiring_soon > 0
            ? { label: "attention", up: false }
            : undefined
        }
        icon={<AlertIcon className="text-yellow-600 size-6 text-yellow-400" />}
        iconBg="bg-yellow-50 bg-yellow-500/10"
      />
      <MetricCard
        label="Taux d'activation"
        value={`${activationRate}%`}
        sub="clients avec abonnement actif"
        icon={<PieChartIcon className="text-pink-600 size-6 text-pink-400" />}
        iconBg="bg-pink-50 bg-pink-500/10"
      />
      <MetricCard
        label="Taux de churn"
        value={`${stats.churn_rate ?? 0}%`}
        sub="résiliations sur 30 jours"
        trend={
          (stats.churn_rate ?? 0) > 5
            ? { label: "élevé", up: false }
            : { label: "faible", up: true }
        }
        icon={<ArrowDownIcon className="text-red-500 size-6 text-red-400" />}
        iconBg="bg-red-50 bg-red-500/10"
      />
      <MetricCard
        label="Recouvrement factures"
        value={`${stats.invoice_recovery_rate ?? 0}%`}
        sub="factures payées / émises"
        trend={
          (stats.invoice_recovery_rate ?? 0) >= 80
            ? { label: "bon", up: true }
            : { label: "à améliorer", up: false }
        }
        icon={<CheckCircleIcon className="text-teal-500 size-6 text-teal-400" />}
        iconBg="bg-teal-50 bg-teal-500/10"
      />
    </div>
  );
}
