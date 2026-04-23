import {
  Table,
  TableBody,
  TableCell,
  TableHeader,
  TableRow,
} from "../ui/table";
import Badge from "../ui/badge/Badge";
import type { RecentOrder } from "../../types/saas";

const fcfa = (n: number) => `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

function orderStatusBadge(status: number | string): { color: "success" | "warning" | "error" | "info"; label: string } {
  switch (Number(status)) {
    case 1:  return { color: "info",    label: "En cours" };
    case 2:  return { color: "warning", label: "En traitement" };
    case 3:  return { color: "info",    label: "Prêt" };
    case 4:  return { color: "success", label: "Servie" };
    case 5:  return { color: "error",   label: "Annulée" };
    default: return { color: "warning", label: "En attente" };
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
          Commandes récentes
        </h3>
        <span className="text-xs text-gray-400 dark:text-gray-500">
          Tous les restaurants
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
                Client
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
                  Aucune commande
                </TableCell>
              </TableRow>
            ) : (
              orders.map((order) => {
                const { color, label } = orderStatusBadge(order.order_status);
                return (
                  <TableRow key={order.order_id}>
                    <TableCell className="py-3 text-gray-500 text-theme-xs dark:text-gray-400">
                      #{order.order_id}
                    </TableCell>
                    <TableCell className="py-3 text-sm font-medium text-gray-800 dark:text-white/90">
                      {order.business_name ?? "—"}
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-xs dark:text-gray-400">
                      {order.customer_name ?? "Client"}
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-xs dark:text-gray-400">
                      {order.order_date}
                      {order.order_time ? ` ${order.order_time.slice(0, 5)}` : ""}
                    </TableCell>
                    <TableCell className="py-3 font-medium text-gray-800 text-theme-sm dark:text-white/90">
                      {fcfa(order.totalamount)}
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
