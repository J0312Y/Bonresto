import {
  Table,
  TableBody,
  TableCell,
  TableHeader,
  TableRow,
} from "../ui/table";
import Badge from "../ui/badge/Badge";
import type { RecentOrder } from "../../types/saas";

const fcfa = (n: number | string) => `${Math.round(Number(n)).toLocaleString("fr-FR")} FCFA`;

function paymentStatusBadge(status: string): { color: "success" | "warning" | "error" | "info"; label: string } {
  switch (status) {
    case "paid":     return { color: "success", label: "Payé" };
    case "pending":  return { color: "warning", label: "En attente" };
    case "failed":   return { color: "error",   label: "Échoué" };
    case "refunded": return { color: "info",     label: "Remboursé" };
    default:         return { color: "warning",  label: status };
  }
}

interface Props {
  orders: RecentOrder[];
}

export default function RecentOrdersAll({ orders }: Props) {
  return (
    <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
      <div className="flex items-center justify-between mb-4">
        <h3 className="text-lg font-semibold text-gray-800 dark:text-white/90">
          Paiements récents
        </h3>
        <span className="text-xs text-gray-400 dark:text-gray-500">
          Tous les clients
        </span>
      </div>

      <div className="max-w-full overflow-x-auto">
        <Table>
          <TableHeader className="border-gray-100 dark:border-gray-800 border-y">
            <TableRow>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                #
              </TableCell>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                Restaurant
              </TableCell>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                Plan
              </TableCell>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                Date
              </TableCell>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                Montant
              </TableCell>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">
                Statut
              </TableCell>
            </TableRow>
          </TableHeader>
          <TableBody className="divide-y divide-gray-100 dark:divide-gray-800">
            {orders.length === 0 ? (
              <TableRow>
                <TableCell className="py-8 text-center text-gray-400 text-sm">
                  Aucun paiement
                </TableCell>
              </TableRow>
            ) : (
              orders.map((p) => {
                const { color, label } = paymentStatusBadge(p.status);
                return (
                  <TableRow key={p.payment_id}>
                    <TableCell className="py-3 text-gray-500 text-theme-xs dark:text-gray-400">
                      #{p.payment_id}
                    </TableCell>
                    <TableCell className="py-3 text-sm font-medium text-gray-800 dark:text-white/90">
                      {p.business_name ?? "—"}
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-xs dark:text-gray-400">
                      {p.plan_name ?? "—"}
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-xs dark:text-gray-400">
                      {p.created_at ? p.created_at.slice(0, 10) : "—"}
                    </TableCell>
                    <TableCell className="py-3 font-medium text-gray-800 text-theme-sm dark:text-white/90">
                      {fcfa(p.amount)}
                    </TableCell>
                    <TableCell className="py-3">
                      <Badge size="sm" color={color}>{label}</Badge>
                    </TableCell>
                  </TableRow>
                );
              })
            )}
          </TableBody>
        </Table>
      </div>
    </div>
  );
}
