import { Link } from "react-router";
import {
  Table,
  TableBody,
  TableCell,
  TableHeader,
  TableRow,
} from "../ui/table";
import Badge from "../ui/badge/Badge";
import type { Client } from "../../types/saas";

interface Props {
  clients: Client[];
}

function statusColor(
  status?: string
): "success" | "warning" | "error" | "info" {
  switch (status) {
    case "active":
      return "success";
    case "grace":
      return "warning";
    case "expired":
      return "error";
    default:
      return "info";
  }
}

function statusLabel(status?: string): string {
  switch (status) {
    case "active":
      return "Actif";
    case "grace":
      return "Grâce";
    case "expired":
      return "Expiré";
    case "suspended":
      return "Suspendu";
    default:
      return "Aucun";
  }
}

export default function RecentClients({ clients }: Props) {
  return (
    <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 border-gray-800 bg-white/[0.03] sm:px-6">
      <div className="flex items-center justify-between mb-4">
        <h3 className="text-lg font-semibold text-gray-800 text-white/90">
          Clients récents
        </h3>
        <Link
          to="/clients"
          className="text-sm text-brand-500 hover:text-brand-600 text-brand-400"
        >
          Voir tout →
        </Link>
      </div>
      <div className="max-w-full overflow-x-auto">
        <Table>
          <TableHeader className="border-gray-100 border-gray-800 border-y">
            <TableRow>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">
                Restaurant
              </TableCell>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">
                Plan
              </TableCell>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">
                Expire le
              </TableCell>
              <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs text-gray-400">
                Statut
              </TableCell>
            </TableRow>
          </TableHeader>
          <TableBody className="divide-y divide-gray-100 divide-gray-800">
            {clients.slice(0, 6).map((client) => (
              <TableRow key={client.client_id}>
                <TableCell className="py-3">
                  <div>
                    <p className="font-medium text-gray-800 text-theme-sm text-white/90">
                      {client.business_name}
                    </p>
                    <span className="text-gray-500 text-theme-xs text-gray-400">
                      {client.email}
                    </span>
                  </div>
                </TableCell>
                <TableCell className="py-3 text-gray-500 text-theme-sm text-gray-400">
                  {client.subscription?.plan_name ?? "—"}
                </TableCell>
                <TableCell className="py-3 text-gray-500 text-theme-sm text-gray-400">
                  {client.subscription
                    ? new Date(client.subscription.end_date).toLocaleDateString("fr-FR")
                    : "—"}
                </TableCell>
                <TableCell className="py-3">
                  <Badge
                    size="sm"
                    color={statusColor(client.subscription?.status)}
                  >
                    {statusLabel(client.subscription?.status)}
                  </Badge>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </div>
    </div>
  );
}
