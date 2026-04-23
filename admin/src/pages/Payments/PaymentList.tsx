import { useEffect, useState } from "react";
import PageMeta from "../../components/common/PageMeta";
import Badge from "../../components/ui/badge/Badge";
import {
  Table, TableBody, TableCell, TableHeader, TableRow,
} from "../../components/ui/table";
import { getPayments } from "../../services/api";
import type { Payment } from "../../types/saas";

function statusColor(s: string): "success" | "warning" | "error" | "info" {
  if (s === "paid") return "success";
  if (s === "pending") return "warning";
  if (s === "failed") return "error";
  return "info";
}

function statusLabel(s: string) {
  if (s === "paid") return "Payé";
  if (s === "pending") return "En attente";
  if (s === "failed") return "Échoué";
  if (s === "refunded") return "Remboursé";
  return s;
}

export default function PaymentList() {
  const [payments, setPayments] = useState<Payment[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    getPayments()
      .then(setPayments)
      .catch(() => {})
      .finally(() => setLoading(false));
  }, []);

  const total = payments
    .filter((p) => p.status === "paid")
    .reduce((sum, p) => sum + p.amount, 0);

  const fmt = (n: number) =>
    `${Math.round(n).toLocaleString("fr-FR")} FCFA`;

  return (
    <>
      <PageMeta title="Paiements — Bonresto SaaS" description="Historique des paiements" />

      <div className="mb-6 flex items-center justify-between">
        <div>
          <h2 className="text-2xl font-bold text-gray-800 dark:text-white/90">Paiements</h2>
          <p className="text-sm text-gray-500 dark:text-gray-400">
            {payments.length} transaction{payments.length !== 1 ? "s" : ""}
            {" · "}
            Total encaissé : <strong className="text-gray-700 dark:text-gray-200">{fmt(total)}</strong>
          </p>
        </div>
      </div>

      <div className="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        {loading ? (
          <div className="p-8 text-center text-gray-400">Chargement...</div>
        ) : (
          <div className="overflow-x-auto">
            <Table>
              <TableHeader className="border-gray-100 dark:border-gray-800 border-y">
                <TableRow>
                  <TableCell isHeader className="py-3 px-6 font-medium text-gray-500 text-theme-xs dark:text-gray-400">#</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Client</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Plan</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Montant</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Date</TableCell>
                  <TableCell isHeader className="py-3 font-medium text-gray-500 text-theme-xs dark:text-gray-400">Statut</TableCell>
                </TableRow>
              </TableHeader>
              <TableBody className="divide-y divide-gray-100 dark:divide-gray-800">
                {payments.map((p) => (
                  <TableRow key={p.payment_id}>
                    <TableCell className="py-3 px-6 text-gray-400 text-theme-xs">
                      #{p.payment_id}
                    </TableCell>
                    <TableCell className="py-3">
                      <p className="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                        {p.client_name}
                      </p>
                      <span className="text-xs text-gray-400">{p.client_email}</span>
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                      {p.plan_name}
                    </TableCell>
                    <TableCell className="py-3 font-semibold text-gray-800 dark:text-white/90">
                      {fmt(p.amount)}
                    </TableCell>
                    <TableCell className="py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                      {new Date(p.created_at).toLocaleDateString("fr-FR")}
                    </TableCell>
                    <TableCell className="py-3">
                      <Badge size="sm" color={statusColor(p.status)}>
                        {statusLabel(p.status)}
                      </Badge>
                    </TableCell>
                  </TableRow>
                ))}
                {payments.length === 0 && (
                  <TableRow>
                    <TableCell className="py-8 text-center text-gray-400">
                      Aucun paiement enregistré.
                    </TableCell>
                  </TableRow>
                )}
              </TableBody>
            </Table>
          </div>
        )}
      </div>
    </>
  );
}
