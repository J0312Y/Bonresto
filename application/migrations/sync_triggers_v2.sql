-- ============================================================
-- SYNC TRIGGERS V2 — Serveur LOCAL uniquement
-- Couvre tous les modules : HR, comptabilité, production,
-- achats, réservations, permissions, config, etc.
-- ============================================================

SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';
DELIMITER //

-- ─── COMPTABILITÉ ────────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_acc_account_name_ins //
CREATE TRIGGER trg_acc_account_name_ins AFTER INSERT ON acc_account_name FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('acc_account_name',NEW.account_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_acc_account_name_upd //
CREATE TRIGGER trg_acc_account_name_upd AFTER UPDATE ON acc_account_name FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('acc_account_name',NEW.account_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_acc_account_name_del //
CREATE TRIGGER trg_acc_account_name_del AFTER DELETE ON acc_account_name FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('acc_account_name',OLD.account_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_acn_account_transaction_ins //
CREATE TRIGGER trg_acn_account_transaction_ins AFTER INSERT ON acn_account_transaction FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('acn_account_transaction',NEW.account_tran_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_acn_account_transaction_upd //
CREATE TRIGGER trg_acn_account_transaction_upd AFTER UPDATE ON acn_account_transaction FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('acn_account_transaction',NEW.account_tran_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_acn_account_transaction_del //
CREATE TRIGGER trg_acn_account_transaction_del AFTER DELETE ON acn_account_transaction FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('acn_account_transaction',OLD.account_tran_id,'delete','pending',NOW()); END//

-- ─── RH / PAIE ───────────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_department_ins //
CREATE TRIGGER trg_department_ins AFTER INSERT ON department FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('department',NEW.dept_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_department_upd //
CREATE TRIGGER trg_department_upd AFTER UPDATE ON department FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('department',NEW.dept_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_department_del //
CREATE TRIGGER trg_department_del AFTER DELETE ON department FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('department',OLD.dept_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_position_ins //
CREATE TRIGGER trg_position_ins AFTER INSERT ON position FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('position',NEW.pos_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_position_upd //
CREATE TRIGGER trg_position_upd AFTER UPDATE ON position FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('position',NEW.pos_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_position_del //
CREATE TRIGGER trg_position_del AFTER DELETE ON position FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('position',OLD.pos_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_gender_ins //
CREATE TRIGGER trg_gender_ins AFTER INSERT ON gender FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('gender',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_gender_upd //
CREATE TRIGGER trg_gender_upd AFTER UPDATE ON gender FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('gender',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_gender_del //
CREATE TRIGGER trg_gender_del AFTER DELETE ON gender FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('gender',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_marital_info_ins //
CREATE TRIGGER trg_marital_info_ins AFTER INSERT ON marital_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('marital_info',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_marital_info_upd //
CREATE TRIGGER trg_marital_info_upd AFTER UPDATE ON marital_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('marital_info',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_marital_info_del //
CREATE TRIGGER trg_marital_info_del AFTER DELETE ON marital_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('marital_info',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_duty_type_ins //
CREATE TRIGGER trg_duty_type_ins AFTER INSERT ON duty_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('duty_type',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_duty_type_upd //
CREATE TRIGGER trg_duty_type_upd AFTER UPDATE ON duty_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('duty_type',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_duty_type_del //
CREATE TRIGGER trg_duty_type_del AFTER DELETE ON duty_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('duty_type',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_shift_management_ins //
CREATE TRIGGER trg_shift_management_ins AFTER INSERT ON shift_management FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shift_management',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_shift_management_upd //
CREATE TRIGGER trg_shift_management_upd AFTER UPDATE ON shift_management FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shift_management',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_shift_management_del //
CREATE TRIGGER trg_shift_management_del AFTER DELETE ON shift_management FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shift_management',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_shift_assign_ins //
CREATE TRIGGER trg_shift_assign_ins AFTER INSERT ON shift_assign FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shift_assign',NEW.assignid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_shift_assign_upd //
CREATE TRIGGER trg_shift_assign_upd AFTER UPDATE ON shift_assign FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shift_assign',NEW.assignid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_shift_assign_del //
CREATE TRIGGER trg_shift_assign_del AFTER DELETE ON shift_assign FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('shift_assign',OLD.assignid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_emp_attendance_ins //
CREATE TRIGGER trg_emp_attendance_ins AFTER INSERT ON emp_attendance FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('emp_attendance',NEW.att_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_emp_attendance_upd //
CREATE TRIGGER trg_emp_attendance_upd AFTER UPDATE ON emp_attendance FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('emp_attendance',NEW.att_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_emp_attendance_del //
CREATE TRIGGER trg_emp_attendance_del AFTER DELETE ON emp_attendance FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('emp_attendance',OLD.att_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_employee_history_ins //
CREATE TRIGGER trg_employee_history_ins AFTER INSERT ON employee_history FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_history',NEW.emp_his_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_history_upd //
CREATE TRIGGER trg_employee_history_upd AFTER UPDATE ON employee_history FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_history',NEW.emp_his_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_history_del //
CREATE TRIGGER trg_employee_history_del AFTER DELETE ON employee_history FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_history',OLD.emp_his_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_employee_benifit_ins //
CREATE TRIGGER trg_employee_benifit_ins AFTER INSERT ON employee_benifit FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_benifit',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_benifit_upd //
CREATE TRIGGER trg_employee_benifit_upd AFTER UPDATE ON employee_benifit FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_benifit',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_benifit_del //
CREATE TRIGGER trg_employee_benifit_del AFTER DELETE ON employee_benifit FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_benifit',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_employee_performance_ins //
CREATE TRIGGER trg_employee_performance_ins AFTER INSERT ON employee_performance FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_performance',NEW.emp_per_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_performance_upd //
CREATE TRIGGER trg_employee_performance_upd AFTER UPDATE ON employee_performance FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_performance',NEW.emp_per_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_performance_del //
CREATE TRIGGER trg_employee_performance_del AFTER DELETE ON employee_performance FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_performance',OLD.emp_per_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_employee_salary_setup_ins //
CREATE TRIGGER trg_employee_salary_setup_ins AFTER INSERT ON employee_salary_setup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_salary_setup',NEW.e_s_s_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_salary_setup_upd //
CREATE TRIGGER trg_employee_salary_setup_upd AFTER UPDATE ON employee_salary_setup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_salary_setup',NEW.e_s_s_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_salary_setup_del //
CREATE TRIGGER trg_employee_salary_setup_del AFTER DELETE ON employee_salary_setup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_salary_setup',OLD.e_s_s_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_employee_salary_payment_ins //
CREATE TRIGGER trg_employee_salary_payment_ins AFTER INSERT ON employee_salary_payment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_salary_payment',NEW.emp_sal_pay_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_salary_payment_upd //
CREATE TRIGGER trg_employee_salary_payment_upd AFTER UPDATE ON employee_salary_payment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_salary_payment',NEW.emp_sal_pay_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_employee_salary_payment_del //
CREATE TRIGGER trg_employee_salary_payment_del AFTER DELETE ON employee_salary_payment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('employee_salary_payment',OLD.emp_sal_pay_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_salary_type_ins //
CREATE TRIGGER trg_salary_type_ins AFTER INSERT ON salary_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_type',NEW.salary_type_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_salary_type_upd //
CREATE TRIGGER trg_salary_type_upd AFTER UPDATE ON salary_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_type',NEW.salary_type_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_salary_type_del //
CREATE TRIGGER trg_salary_type_del AFTER DELETE ON salary_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_type',OLD.salary_type_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_salary_setup_header_ins //
CREATE TRIGGER trg_salary_setup_header_ins AFTER INSERT ON salary_setup_header FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_setup_header',NEW.s_s_h_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_salary_setup_header_upd //
CREATE TRIGGER trg_salary_setup_header_upd AFTER UPDATE ON salary_setup_header FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_setup_header',NEW.s_s_h_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_salary_setup_header_del //
CREATE TRIGGER trg_salary_setup_header_del AFTER DELETE ON salary_setup_header FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_setup_header',OLD.s_s_h_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_salary_sheet_generate_ins //
CREATE TRIGGER trg_salary_sheet_generate_ins AFTER INSERT ON salary_sheet_generate FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_sheet_generate',NEW.ssg_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_salary_sheet_generate_upd //
CREATE TRIGGER trg_salary_sheet_generate_upd AFTER UPDATE ON salary_sheet_generate FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_sheet_generate',NEW.ssg_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_salary_sheet_generate_del //
CREATE TRIGGER trg_salary_sheet_generate_del AFTER DELETE ON salary_sheet_generate FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('salary_sheet_generate',OLD.ssg_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_pay_frequency_ins //
CREATE TRIGGER trg_pay_frequency_ins AFTER INSERT ON pay_frequency FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('pay_frequency',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_pay_frequency_upd //
CREATE TRIGGER trg_pay_frequency_upd AFTER UPDATE ON pay_frequency FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('pay_frequency',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_pay_frequency_del //
CREATE TRIGGER trg_pay_frequency_del AFTER DELETE ON pay_frequency FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('pay_frequency',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_payroll_tax_setup_ins //
CREATE TRIGGER trg_payroll_tax_setup_ins AFTER INSERT ON payroll_tax_setup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_tax_setup',NEW.tax_setup_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payroll_tax_setup_upd //
CREATE TRIGGER trg_payroll_tax_setup_upd AFTER UPDATE ON payroll_tax_setup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_tax_setup',NEW.tax_setup_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payroll_tax_setup_del //
CREATE TRIGGER trg_payroll_tax_setup_del AFTER DELETE ON payroll_tax_setup FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_tax_setup',OLD.tax_setup_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_payroll_holiday_ins //
CREATE TRIGGER trg_payroll_holiday_ins AFTER INSERT ON payroll_holiday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_holiday',NEW.payrl_holi_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payroll_holiday_upd //
CREATE TRIGGER trg_payroll_holiday_upd AFTER UPDATE ON payroll_holiday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_holiday',NEW.payrl_holi_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payroll_holiday_del //
CREATE TRIGGER trg_payroll_holiday_del AFTER DELETE ON payroll_holiday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_holiday',OLD.payrl_holi_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_payroll_commission_setting_ins //
CREATE TRIGGER trg_payroll_commission_setting_ins AFTER INSERT ON payroll_commission_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_commission_setting',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payroll_commission_setting_upd //
CREATE TRIGGER trg_payroll_commission_setting_upd AFTER UPDATE ON payroll_commission_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_commission_setting',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payroll_commission_setting_del //
CREATE TRIGGER trg_payroll_commission_setting_del AFTER DELETE ON payroll_commission_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payroll_commission_setting',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_weekly_holiday_ins //
CREATE TRIGGER trg_weekly_holiday_ins AFTER INSERT ON weekly_holiday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('weekly_holiday',NEW.wk_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_weekly_holiday_upd //
CREATE TRIGGER trg_weekly_holiday_upd AFTER UPDATE ON weekly_holiday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('weekly_holiday',NEW.wk_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_weekly_holiday_del //
CREATE TRIGGER trg_weekly_holiday_del AFTER DELETE ON weekly_holiday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('weekly_holiday',OLD.wk_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_leave_type_ins //
CREATE TRIGGER trg_leave_type_ins AFTER INSERT ON leave_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('leave_type',NEW.leave_type_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_leave_type_upd //
CREATE TRIGGER trg_leave_type_upd AFTER UPDATE ON leave_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('leave_type',NEW.leave_type_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_leave_type_del //
CREATE TRIGGER trg_leave_type_del AFTER DELETE ON leave_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('leave_type',OLD.leave_type_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_leave_apply_ins //
CREATE TRIGGER trg_leave_apply_ins AFTER INSERT ON leave_apply FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('leave_apply',NEW.leave_appl_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_leave_apply_upd //
CREATE TRIGGER trg_leave_apply_upd AFTER UPDATE ON leave_apply FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('leave_apply',NEW.leave_appl_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_leave_apply_del //
CREATE TRIGGER trg_leave_apply_del AFTER DELETE ON leave_apply FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('leave_apply',OLD.leave_appl_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_award_ins //
CREATE TRIGGER trg_award_ins AFTER INSERT ON award FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('award',NEW.award_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_award_upd //
CREATE TRIGGER trg_award_upd AFTER UPDATE ON award FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('award',NEW.award_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_award_del //
CREATE TRIGGER trg_award_del AFTER DELETE ON award FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('award',OLD.award_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_grand_loan_ins //
CREATE TRIGGER trg_grand_loan_ins AFTER INSERT ON grand_loan FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('grand_loan',NEW.loan_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_grand_loan_upd //
CREATE TRIGGER trg_grand_loan_upd AFTER UPDATE ON grand_loan FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('grand_loan',NEW.loan_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_grand_loan_del //
CREATE TRIGGER trg_grand_loan_del AFTER DELETE ON grand_loan FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('grand_loan',OLD.loan_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_loan_installment_ins //
CREATE TRIGGER trg_loan_installment_ins AFTER INSERT ON loan_installment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('loan_installment',NEW.loan_inst_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_loan_installment_upd //
CREATE TRIGGER trg_loan_installment_upd AFTER UPDATE ON loan_installment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('loan_installment',NEW.loan_inst_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_loan_installment_del //
CREATE TRIGGER trg_loan_installment_del AFTER DELETE ON loan_installment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('loan_installment',OLD.loan_inst_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_rate_type_ins //
CREATE TRIGGER trg_rate_type_ins AFTER INSERT ON rate_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('rate_type',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_rate_type_upd //
CREATE TRIGGER trg_rate_type_upd AFTER UPDATE ON rate_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('rate_type',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_rate_type_del //
CREATE TRIGGER trg_rate_type_del AFTER DELETE ON rate_type FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('rate_type',OLD.id,'delete','pending',NOW()); END//

-- ─── RECRUTEMENT ─────────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_candidate_basic_info_ins //
CREATE TRIGGER trg_candidate_basic_info_ins AFTER INSERT ON candidate_basic_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_basic_info',NEW.can_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_basic_info_upd //
CREATE TRIGGER trg_candidate_basic_info_upd AFTER UPDATE ON candidate_basic_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_basic_info',NEW.can_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_basic_info_del //
CREATE TRIGGER trg_candidate_basic_info_del AFTER DELETE ON candidate_basic_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_basic_info',OLD.can_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_candidate_education_info_ins //
CREATE TRIGGER trg_candidate_education_info_ins AFTER INSERT ON candidate_education_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_education_info',NEW.can_edu_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_education_info_upd //
CREATE TRIGGER trg_candidate_education_info_upd AFTER UPDATE ON candidate_education_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_education_info',NEW.can_edu_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_education_info_del //
CREATE TRIGGER trg_candidate_education_info_del AFTER DELETE ON candidate_education_info FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_education_info',OLD.can_edu_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_candidate_interview_ins //
CREATE TRIGGER trg_candidate_interview_ins AFTER INSERT ON candidate_interview FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_interview',NEW.can_int_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_interview_upd //
CREATE TRIGGER trg_candidate_interview_upd AFTER UPDATE ON candidate_interview FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_interview',NEW.can_int_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_interview_del //
CREATE TRIGGER trg_candidate_interview_del AFTER DELETE ON candidate_interview FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_interview',OLD.can_int_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_candidate_selection_ins //
CREATE TRIGGER trg_candidate_selection_ins AFTER INSERT ON candidate_selection FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_selection',NEW.can_sel_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_selection_upd //
CREATE TRIGGER trg_candidate_selection_upd AFTER UPDATE ON candidate_selection FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_selection',NEW.can_sel_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_selection_del //
CREATE TRIGGER trg_candidate_selection_del AFTER DELETE ON candidate_selection FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_selection',OLD.can_sel_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_candidate_shortlist_ins //
CREATE TRIGGER trg_candidate_shortlist_ins AFTER INSERT ON candidate_shortlist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_shortlist',NEW.can_short_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_shortlist_upd //
CREATE TRIGGER trg_candidate_shortlist_upd AFTER UPDATE ON candidate_shortlist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_shortlist',NEW.can_short_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_shortlist_del //
CREATE TRIGGER trg_candidate_shortlist_del AFTER DELETE ON candidate_shortlist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_shortlist',OLD.can_short_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_candidate_workexperience_ins //
CREATE TRIGGER trg_candidate_workexperience_ins AFTER INSERT ON candidate_workexperience FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_workexperience',NEW.can_workexp_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_workexperience_upd //
CREATE TRIGGER trg_candidate_workexperience_upd AFTER UPDATE ON candidate_workexperience FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_workexperience',NEW.can_workexp_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_candidate_workexperience_del //
CREATE TRIGGER trg_candidate_workexperience_del AFTER DELETE ON candidate_workexperience FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('candidate_workexperience',OLD.can_workexp_id,'delete','pending',NOW()); END//

-- ─── PERMISSIONS / UTILISATEURS ──────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_user_ins //
CREATE TRIGGER trg_user_ins AFTER INSERT ON user FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('user',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_user_upd //
CREATE TRIGGER trg_user_upd AFTER UPDATE ON user FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('user',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_user_del //
CREATE TRIGGER trg_user_del AFTER DELETE ON user FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('user',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_sec_role_tbl_ins //
CREATE TRIGGER trg_sec_role_tbl_ins AFTER INSERT ON sec_role_tbl FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_role_tbl',NEW.role_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sec_role_tbl_upd //
CREATE TRIGGER trg_sec_role_tbl_upd AFTER UPDATE ON sec_role_tbl FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_role_tbl',NEW.role_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sec_role_tbl_del //
CREATE TRIGGER trg_sec_role_tbl_del AFTER DELETE ON sec_role_tbl FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_role_tbl',OLD.role_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_sec_role_permission_ins //
CREATE TRIGGER trg_sec_role_permission_ins AFTER INSERT ON sec_role_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_role_permission',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sec_role_permission_upd //
CREATE TRIGGER trg_sec_role_permission_upd AFTER UPDATE ON sec_role_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_role_permission',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sec_role_permission_del //
CREATE TRIGGER trg_sec_role_permission_del AFTER DELETE ON sec_role_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_role_permission',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_sec_user_access_tbl_ins //
CREATE TRIGGER trg_sec_user_access_tbl_ins AFTER INSERT ON sec_user_access_tbl FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_user_access_tbl',NEW.role_acc_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sec_user_access_tbl_upd //
CREATE TRIGGER trg_sec_user_access_tbl_upd AFTER UPDATE ON sec_user_access_tbl FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_user_access_tbl',NEW.role_acc_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sec_user_access_tbl_del //
CREATE TRIGGER trg_sec_user_access_tbl_del AFTER DELETE ON sec_user_access_tbl FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_user_access_tbl',OLD.role_acc_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_sec_menu_item_ins //
CREATE TRIGGER trg_sec_menu_item_ins AFTER INSERT ON sec_menu_item FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_menu_item',NEW.menu_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sec_menu_item_upd //
CREATE TRIGGER trg_sec_menu_item_upd AFTER UPDATE ON sec_menu_item FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_menu_item',NEW.menu_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sec_menu_item_del //
CREATE TRIGGER trg_sec_menu_item_del AFTER DELETE ON sec_menu_item FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sec_menu_item',OLD.menu_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_role_permission_ins //
CREATE TRIGGER trg_role_permission_ins AFTER INSERT ON role_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('role_permission',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_role_permission_upd //
CREATE TRIGGER trg_role_permission_upd AFTER UPDATE ON role_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('role_permission',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_role_permission_del //
CREATE TRIGGER trg_role_permission_del AFTER DELETE ON role_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('role_permission',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_module_ins //
CREATE TRIGGER trg_module_ins AFTER INSERT ON module FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('module',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_module_upd //
CREATE TRIGGER trg_module_upd AFTER UPDATE ON module FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('module',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_module_del //
CREATE TRIGGER trg_module_del AFTER DELETE ON module FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('module',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_module_permission_ins //
CREATE TRIGGER trg_module_permission_ins AFTER INSERT ON module_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('module_permission',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_module_permission_upd //
CREATE TRIGGER trg_module_permission_upd AFTER UPDATE ON module_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('module_permission',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_module_permission_del //
CREATE TRIGGER trg_module_permission_del AFTER DELETE ON module_permission FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('module_permission',OLD.id,'delete','pending',NOW()); END//

-- ─── FINANCE / ACHATS ────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_expense_ins //
CREATE TRIGGER trg_expense_ins AFTER INSERT ON expense FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('expense',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_expense_upd //
CREATE TRIGGER trg_expense_upd AFTER UPDATE ON expense FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('expense',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_expense_del //
CREATE TRIGGER trg_expense_del AFTER DELETE ON expense FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('expense',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_expense_item_ins //
CREATE TRIGGER trg_expense_item_ins AFTER INSERT ON expense_item FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('expense_item',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_expense_item_upd //
CREATE TRIGGER trg_expense_item_upd AFTER UPDATE ON expense_item FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('expense_item',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_expense_item_del //
CREATE TRIGGER trg_expense_item_del AFTER DELETE ON expense_item FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('expense_item',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_supplier_ins //
CREATE TRIGGER trg_supplier_ins AFTER INSERT ON supplier FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('supplier',NEW.supid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_supplier_upd //
CREATE TRIGGER trg_supplier_upd AFTER UPDATE ON supplier FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('supplier',NEW.supid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_supplier_del //
CREATE TRIGGER trg_supplier_del AFTER DELETE ON supplier FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('supplier',OLD.supid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_supplier_ledger_ins //
CREATE TRIGGER trg_supplier_ledger_ins AFTER INSERT ON supplier_ledger FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('supplier_ledger',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_supplier_ledger_upd //
CREATE TRIGGER trg_supplier_ledger_upd AFTER UPDATE ON supplier_ledger FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('supplier_ledger',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_supplier_ledger_del //
CREATE TRIGGER trg_supplier_ledger_del AFTER DELETE ON supplier_ledger FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('supplier_ledger',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_purchaseitem_ins //
CREATE TRIGGER trg_purchaseitem_ins AFTER INSERT ON purchaseitem FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchaseitem',NEW.purID,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_purchaseitem_upd //
CREATE TRIGGER trg_purchaseitem_upd AFTER UPDATE ON purchaseitem FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchaseitem',NEW.purID,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_purchaseitem_del //
CREATE TRIGGER trg_purchaseitem_del AFTER DELETE ON purchaseitem FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchaseitem',OLD.purID,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_purchase_details_ins //
CREATE TRIGGER trg_purchase_details_ins AFTER INSERT ON purchase_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchase_details',NEW.detailsid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_purchase_details_upd //
CREATE TRIGGER trg_purchase_details_upd AFTER UPDATE ON purchase_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchase_details',NEW.detailsid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_purchase_details_del //
CREATE TRIGGER trg_purchase_details_del AFTER DELETE ON purchase_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchase_details',OLD.detailsid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_purchase_return_ins //
CREATE TRIGGER trg_purchase_return_ins AFTER INSERT ON purchase_return FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchase_return',NEW.preturn_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_purchase_return_upd //
CREATE TRIGGER trg_purchase_return_upd AFTER UPDATE ON purchase_return FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchase_return',NEW.preturn_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_purchase_return_del //
CREATE TRIGGER trg_purchase_return_del AFTER DELETE ON purchase_return FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('purchase_return',OLD.preturn_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_multipay_bill_ins //
CREATE TRIGGER trg_multipay_bill_ins AFTER INSERT ON multipay_bill FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('multipay_bill',NEW.multipay_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_multipay_bill_upd //
CREATE TRIGGER trg_multipay_bill_upd AFTER UPDATE ON multipay_bill FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('multipay_bill',NEW.multipay_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_multipay_bill_del //
CREATE TRIGGER trg_multipay_bill_del AFTER DELETE ON multipay_bill FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('multipay_bill',OLD.multipay_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_bill_card_payment_ins //
CREATE TRIGGER trg_bill_card_payment_ins AFTER INSERT ON bill_card_payment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('bill_card_payment',NEW.row_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_bill_card_payment_upd //
CREATE TRIGGER trg_bill_card_payment_upd AFTER UPDATE ON bill_card_payment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('bill_card_payment',NEW.row_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_bill_card_payment_del //
CREATE TRIGGER trg_bill_card_payment_del AFTER DELETE ON bill_card_payment FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('bill_card_payment',OLD.row_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_payment_transactions_ins //
CREATE TRIGGER trg_payment_transactions_ins AFTER INSERT ON payment_transactions FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payment_transactions',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payment_transactions_upd //
CREATE TRIGGER trg_payment_transactions_upd AFTER UPDATE ON payment_transactions FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payment_transactions',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_payment_transactions_del //
CREATE TRIGGER trg_payment_transactions_del AFTER DELETE ON payment_transactions FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('payment_transactions',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_sub_order_ins //
CREATE TRIGGER trg_sub_order_ins AFTER INSERT ON sub_order FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sub_order',NEW.sub_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sub_order_upd //
CREATE TRIGGER trg_sub_order_upd AFTER UPDATE ON sub_order FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sub_order',NEW.sub_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sub_order_del //
CREATE TRIGGER trg_sub_order_del AFTER DELETE ON sub_order FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sub_order',OLD.sub_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_bank_ins //
CREATE TRIGGER trg_tbl_bank_ins AFTER INSERT ON tbl_bank FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_bank',NEW.bankid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_bank_upd //
CREATE TRIGGER trg_tbl_bank_upd AFTER UPDATE ON tbl_bank FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_bank',NEW.bankid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_bank_del //
CREATE TRIGGER trg_tbl_bank_del AFTER DELETE ON tbl_bank FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_bank',OLD.bankid,'delete','pending',NOW()); END//

-- ─── PRODUCTION / INVENTAIRE ─────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_ingredients_ins //
CREATE TRIGGER trg_ingredients_ins AFTER INSERT ON ingredients FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('ingredients',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_ingredients_upd //
CREATE TRIGGER trg_ingredients_upd AFTER UPDATE ON ingredients FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('ingredients',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_ingredients_del //
CREATE TRIGGER trg_ingredients_del AFTER DELETE ON ingredients FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('ingredients',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_production_ins //
CREATE TRIGGER trg_production_ins AFTER INSERT ON production FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('production',NEW.productionid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_production_upd //
CREATE TRIGGER trg_production_upd AFTER UPDATE ON production FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('production',NEW.productionid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_production_del //
CREATE TRIGGER trg_production_del AFTER DELETE ON production FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('production',OLD.productionid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_production_details_ins //
CREATE TRIGGER trg_production_details_ins AFTER INSERT ON production_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('production_details',NEW.pro_detailsid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_production_details_upd //
CREATE TRIGGER trg_production_details_upd AFTER UPDATE ON production_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('production_details',NEW.pro_detailsid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_production_details_del //
CREATE TRIGGER trg_production_details_del AFTER DELETE ON production_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('production_details',OLD.pro_detailsid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_waste_tracking_ins //
CREATE TRIGGER trg_waste_tracking_ins AFTER INSERT ON waste_tracking FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('waste_tracking',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_waste_tracking_upd //
CREATE TRIGGER trg_waste_tracking_upd AFTER UPDATE ON waste_tracking FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('waste_tracking',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_waste_tracking_del //
CREATE TRIGGER trg_waste_tracking_del AFTER DELETE ON waste_tracking FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('waste_tracking',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_ingradient_food_waste_ins //
CREATE TRIGGER trg_ingradient_food_waste_ins AFTER INSERT ON ingradient_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('ingradient_food_waste',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_ingradient_food_waste_upd //
CREATE TRIGGER trg_ingradient_food_waste_upd AFTER UPDATE ON ingradient_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('ingradient_food_waste',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_ingradient_food_waste_del //
CREATE TRIGGER trg_ingradient_food_waste_del AFTER DELETE ON ingradient_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('ingradient_food_waste',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_items_food_waste_ins //
CREATE TRIGGER trg_items_food_waste_ins AFTER INSERT ON items_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('items_food_waste',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_items_food_waste_upd //
CREATE TRIGGER trg_items_food_waste_upd AFTER UPDATE ON items_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('items_food_waste',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_items_food_waste_del //
CREATE TRIGGER trg_items_food_waste_del AFTER DELETE ON items_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('items_food_waste',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_packaging_food_waste_ins //
CREATE TRIGGER trg_packaging_food_waste_ins AFTER INSERT ON packaging_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('packaging_food_waste',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_packaging_food_waste_upd //
CREATE TRIGGER trg_packaging_food_waste_upd AFTER UPDATE ON packaging_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('packaging_food_waste',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_packaging_food_waste_del //
CREATE TRIGGER trg_packaging_food_waste_del AFTER DELETE ON packaging_food_waste FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('packaging_food_waste',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_unit_of_measurement_ins //
CREATE TRIGGER trg_unit_of_measurement_ins AFTER INSERT ON unit_of_measurement FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('unit_of_measurement',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_unit_of_measurement_upd //
CREATE TRIGGER trg_unit_of_measurement_upd AFTER UPDATE ON unit_of_measurement FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('unit_of_measurement',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_unit_of_measurement_del //
CREATE TRIGGER trg_unit_of_measurement_del AFTER DELETE ON unit_of_measurement FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('unit_of_measurement',OLD.id,'delete','pending',NOW()); END//

-- ─── RÉSERVATIONS ────────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_tblreservation_ins //
CREATE TRIGGER trg_tblreservation_ins AFTER INSERT ON tblreservation FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tblreservation',NEW.reserveid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tblreservation_upd //
CREATE TRIGGER trg_tblreservation_upd AFTER UPDATE ON tblreservation FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tblreservation',NEW.reserveid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tblreservation_del //
CREATE TRIGGER trg_tblreservation_del AFTER DELETE ON tblreservation FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tblreservation',OLD.reserveid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_reservationofday_ins //
CREATE TRIGGER trg_reservationofday_ins AFTER INSERT ON reservationofday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('reservationofday',NEW.offdayid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_reservationofday_upd //
CREATE TRIGGER trg_reservationofday_upd AFTER UPDATE ON reservationofday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('reservationofday',NEW.offdayid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_reservationofday_del //
CREATE TRIGGER trg_reservationofday_del AFTER DELETE ON reservationofday FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('reservationofday',OLD.offdayid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tblserver_ins //
CREATE TRIGGER trg_tblserver_ins AFTER INSERT ON tblserver FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tblserver',NEW.serverid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tblserver_upd //
CREATE TRIGGER trg_tblserver_upd AFTER UPDATE ON tblserver FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tblserver',NEW.serverid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tblserver_del //
CREATE TRIGGER trg_tblserver_del AFTER DELETE ON tblserver FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tblserver',OLD.serverid,'delete','pending',NOW()); END//

-- ─── COMMANDES / CUISINE / POS ───────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_qr_orders_ins //
CREATE TRIGGER trg_qr_orders_ins AFTER INSERT ON qr_orders FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_orders',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_qr_orders_upd //
CREATE TRIGGER trg_qr_orders_upd AFTER UPDATE ON qr_orders FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_orders',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_qr_orders_del //
CREATE TRIGGER trg_qr_orders_del AFTER DELETE ON qr_orders FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_orders',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_qr_payments_ins //
CREATE TRIGGER trg_qr_payments_ins AFTER INSERT ON qr_payments FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_payments',NEW.payment_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_qr_payments_upd //
CREATE TRIGGER trg_qr_payments_upd AFTER UPDATE ON qr_payments FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_payments',NEW.payment_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_qr_payments_del //
CREATE TRIGGER trg_qr_payments_del AFTER DELETE ON qr_payments FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('qr_payments',OLD.payment_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_table_details_ins //
CREATE TRIGGER trg_table_details_ins AFTER INSERT ON table_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('table_details',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_table_details_upd //
CREATE TRIGGER trg_table_details_upd AFTER UPDATE ON table_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('table_details',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_table_details_del //
CREATE TRIGGER trg_table_details_del AFTER DELETE ON table_details FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('table_details',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_table_setting_ins //
CREATE TRIGGER trg_table_setting_ins AFTER INSERT ON table_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('table_setting',NEW.settingid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_table_setting_upd //
CREATE TRIGGER trg_table_setting_upd AFTER UPDATE ON table_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('table_setting',NEW.settingid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_table_setting_del //
CREATE TRIGGER trg_table_setting_del AFTER DELETE ON table_setting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('table_setting',OLD.settingid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_assign_kitchen_ins //
CREATE TRIGGER trg_tbl_assign_kitchen_ins AFTER INSERT ON tbl_assign_kitchen FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_assign_kitchen',NEW.assignid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_assign_kitchen_upd //
CREATE TRIGGER trg_tbl_assign_kitchen_upd AFTER UPDATE ON tbl_assign_kitchen FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_assign_kitchen',NEW.assignid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_assign_kitchen_del //
CREATE TRIGGER trg_tbl_assign_kitchen_del AFTER DELETE ON tbl_assign_kitchen FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_assign_kitchen',OLD.assignid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_cancelitem_ins //
CREATE TRIGGER trg_tbl_cancelitem_ins AFTER INSERT ON tbl_cancelitem FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cancelitem',NEW.cancelid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_cancelitem_upd //
CREATE TRIGGER trg_tbl_cancelitem_upd AFTER UPDATE ON tbl_cancelitem FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cancelitem',NEW.cancelid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_cancelitem_del //
CREATE TRIGGER trg_tbl_cancelitem_del AFTER DELETE ON tbl_cancelitem FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cancelitem',OLD.cancelid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_card_terminal_ins //
CREATE TRIGGER trg_tbl_card_terminal_ins AFTER INSERT ON tbl_card_terminal FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_card_terminal',NEW.card_terminalid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_card_terminal_upd //
CREATE TRIGGER trg_tbl_card_terminal_upd AFTER UPDATE ON tbl_card_terminal FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_card_terminal',NEW.card_terminalid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_card_terminal_del //
CREATE TRIGGER trg_tbl_card_terminal_del AFTER DELETE ON tbl_card_terminal FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_card_terminal',OLD.card_terminalid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_cashcounter_ins //
CREATE TRIGGER trg_tbl_cashcounter_ins AFTER INSERT ON tbl_cashcounter FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cashcounter',NEW.ccid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_cashcounter_upd //
CREATE TRIGGER trg_tbl_cashcounter_upd AFTER UPDATE ON tbl_cashcounter FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cashcounter',NEW.ccid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_cashcounter_del //
CREATE TRIGGER trg_tbl_cashcounter_del AFTER DELETE ON tbl_cashcounter FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cashcounter',OLD.ccid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_cashregister_ins //
CREATE TRIGGER trg_tbl_cashregister_ins AFTER INSERT ON tbl_cashregister FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cashregister',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_cashregister_upd //
CREATE TRIGGER trg_tbl_cashregister_upd AFTER UPDATE ON tbl_cashregister FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cashregister',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_cashregister_del //
CREATE TRIGGER trg_tbl_cashregister_del AFTER DELETE ON tbl_cashregister FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_cashregister',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_itemaccepted_ins //
CREATE TRIGGER trg_tbl_itemaccepted_ins AFTER INSERT ON tbl_itemaccepted FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_itemaccepted',NEW.acid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_itemaccepted_upd //
CREATE TRIGGER trg_tbl_itemaccepted_upd AFTER UPDATE ON tbl_itemaccepted FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_itemaccepted',NEW.acid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_itemaccepted_del //
CREATE TRIGGER trg_tbl_itemaccepted_del AFTER DELETE ON tbl_itemaccepted FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_itemaccepted',OLD.acid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_kitchen_order_ins //
CREATE TRIGGER trg_tbl_kitchen_order_ins AFTER INSERT ON tbl_kitchen_order FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_kitchen_order',NEW.ktid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_kitchen_order_upd //
CREATE TRIGGER trg_tbl_kitchen_order_upd AFTER UPDATE ON tbl_kitchen_order FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_kitchen_order',NEW.ktid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_kitchen_order_del //
CREATE TRIGGER trg_tbl_kitchen_order_del AFTER DELETE ON tbl_kitchen_order FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_kitchen_order',OLD.ktid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_openclose_ins //
CREATE TRIGGER trg_tbl_openclose_ins AFTER INSERT ON tbl_openclose FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_openclose',NEW.stid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_openclose_upd //
CREATE TRIGGER trg_tbl_openclose_upd AFTER UPDATE ON tbl_openclose FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_openclose',NEW.stid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_openclose_del //
CREATE TRIGGER trg_tbl_openclose_del AFTER DELETE ON tbl_openclose FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_openclose',OLD.stid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_orderprepare_ins //
CREATE TRIGGER trg_tbl_orderprepare_ins AFTER INSERT ON tbl_orderprepare FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_orderprepare',NEW.opid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_orderprepare_upd //
CREATE TRIGGER trg_tbl_orderprepare_upd AFTER UPDATE ON tbl_orderprepare FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_orderprepare',NEW.opid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_orderprepare_del //
CREATE TRIGGER trg_tbl_orderprepare_del AFTER DELETE ON tbl_orderprepare FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_orderprepare',OLD.opid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_posetting_ins //
CREATE TRIGGER trg_tbl_posetting_ins AFTER INSERT ON tbl_posetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_posetting',NEW.possettingid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_posetting_upd //
CREATE TRIGGER trg_tbl_posetting_upd AFTER UPDATE ON tbl_posetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_posetting',NEW.possettingid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_posetting_del //
CREATE TRIGGER trg_tbl_posetting_del AFTER DELETE ON tbl_posetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_posetting',OLD.possettingid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_quickordersetting_ins //
CREATE TRIGGER trg_tbl_quickordersetting_ins AFTER INSERT ON tbl_quickordersetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_quickordersetting',NEW.quickordid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_quickordersetting_upd //
CREATE TRIGGER trg_tbl_quickordersetting_upd AFTER UPDATE ON tbl_quickordersetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_quickordersetting',NEW.quickordid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_quickordersetting_del //
CREATE TRIGGER trg_tbl_quickordersetting_del AFTER DELETE ON tbl_quickordersetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_quickordersetting',OLD.quickordid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_rating_ins //
CREATE TRIGGER trg_tbl_rating_ins AFTER INSERT ON tbl_rating FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_rating',NEW.ratingid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_rating_upd //
CREATE TRIGGER trg_tbl_rating_upd AFTER UPDATE ON tbl_rating FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_rating',NEW.ratingid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_rating_del //
CREATE TRIGGER trg_tbl_rating_del AFTER DELETE ON tbl_rating FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_rating',OLD.ratingid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_room_ins //
CREATE TRIGGER trg_tbl_room_ins AFTER INSERT ON tbl_room FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_room',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_room_upd //
CREATE TRIGGER trg_tbl_room_upd AFTER UPDATE ON tbl_room FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_room',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_room_del //
CREATE TRIGGER trg_tbl_room_del AFTER DELETE ON tbl_room FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_room',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_updateitems_ins //
CREATE TRIGGER trg_tbl_updateitems_ins AFTER INSERT ON tbl_updateitems FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_updateitems',NEW.updateid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_updateitems_upd //
CREATE TRIGGER trg_tbl_updateitems_upd AFTER UPDATE ON tbl_updateitems FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_updateitems',NEW.updateid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_updateitems_del //
CREATE TRIGGER trg_tbl_updateitems_del AFTER DELETE ON tbl_updateitems FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_updateitems',OLD.updateid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_usedcoupon_ins //
CREATE TRIGGER trg_usedcoupon_ins AFTER INSERT ON usedcoupon FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('usedcoupon',NEW.cusedid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_usedcoupon_upd //
CREATE TRIGGER trg_usedcoupon_upd AFTER UPDATE ON usedcoupon FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('usedcoupon',NEW.cusedid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_usedcoupon_del //
CREATE TRIGGER trg_usedcoupon_del AFTER DELETE ON usedcoupon FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('usedcoupon',OLD.cusedid,'delete','pending',NOW()); END//

-- ─── CONFIG DIVERS ───────────────────────────────────────────────────────────

DROP TRIGGER IF EXISTS trg_email_config_ins //
CREATE TRIGGER trg_email_config_ins AFTER INSERT ON email_config FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('email_config',NEW.email_config_id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_email_config_upd //
CREATE TRIGGER trg_email_config_upd AFTER UPDATE ON email_config FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('email_config',NEW.email_config_id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_email_config_del //
CREATE TRIGGER trg_email_config_del AFTER DELETE ON email_config FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('email_config',OLD.email_config_id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_sms_template_ins //
CREATE TRIGGER trg_sms_template_ins AFTER INSERT ON sms_template FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sms_template',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sms_template_upd //
CREATE TRIGGER trg_sms_template_upd AFTER UPDATE ON sms_template FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sms_template',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_sms_template_del //
CREATE TRIGGER trg_sms_template_del AFTER DELETE ON sms_template FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('sms_template',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_facebook_settings_ins //
CREATE TRIGGER trg_facebook_settings_ins AFTER INSERT ON facebook_settings FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('facebook_settings',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_facebook_settings_upd //
CREATE TRIGGER trg_facebook_settings_upd AFTER UPDATE ON facebook_settings FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('facebook_settings',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_facebook_settings_del //
CREATE TRIGGER trg_facebook_settings_del AFTER DELETE ON facebook_settings FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('facebook_settings',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_customerpoint_ins //
CREATE TRIGGER trg_tbl_customerpoint_ins AFTER INSERT ON tbl_customerpoint FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_customerpoint',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_customerpoint_upd //
CREATE TRIGGER trg_tbl_customerpoint_upd AFTER UPDATE ON tbl_customerpoint FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_customerpoint',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_customerpoint_del //
CREATE TRIGGER trg_tbl_customerpoint_del AFTER DELETE ON tbl_customerpoint FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_customerpoint',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_customer_membership_map_ins //
CREATE TRIGGER trg_customer_membership_map_ins AFTER INSERT ON customer_membership_map FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_membership_map',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_customer_membership_map_upd //
CREATE TRIGGER trg_customer_membership_map_upd AFTER UPDATE ON customer_membership_map FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_membership_map',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_customer_membership_map_del //
CREATE TRIGGER trg_customer_membership_map_del AFTER DELETE ON customer_membership_map FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('customer_membership_map',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_subscribe_emaillist_ins //
CREATE TRIGGER trg_subscribe_emaillist_ins AFTER INSERT ON subscribe_emaillist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('subscribe_emaillist',NEW.emailid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_subscribe_emaillist_upd //
CREATE TRIGGER trg_subscribe_emaillist_upd AFTER UPDATE ON subscribe_emaillist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('subscribe_emaillist',NEW.emailid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_subscribe_emaillist_del //
CREATE TRIGGER trg_subscribe_emaillist_del AFTER DELETE ON subscribe_emaillist FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('subscribe_emaillist',OLD.emailid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_seoption_ins //
CREATE TRIGGER trg_tbl_seoption_ins AFTER INSERT ON tbl_seoption FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_seoption',NEW.id,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_seoption_upd //
CREATE TRIGGER trg_tbl_seoption_upd AFTER UPDATE ON tbl_seoption FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_seoption',NEW.id,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_seoption_del //
CREATE TRIGGER trg_tbl_seoption_del AFTER DELETE ON tbl_seoption FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_seoption',OLD.id,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_soundsetting_ins //
CREATE TRIGGER trg_tbl_soundsetting_ins AFTER INSERT ON tbl_soundsetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_soundsetting',NEW.soundid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_soundsetting_upd //
CREATE TRIGGER trg_tbl_soundsetting_upd AFTER UPDATE ON tbl_soundsetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_soundsetting',NEW.soundid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_soundsetting_del //
CREATE TRIGGER trg_tbl_soundsetting_del AFTER DELETE ON tbl_soundsetting FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_soundsetting',OLD.soundid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_generatedreport_ins //
CREATE TRIGGER trg_tbl_generatedreport_ins AFTER INSERT ON tbl_generatedreport FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_generatedreport',NEW.generateid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_generatedreport_upd //
CREATE TRIGGER trg_tbl_generatedreport_upd AFTER UPDATE ON tbl_generatedreport FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_generatedreport',NEW.generateid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_generatedreport_del //
CREATE TRIGGER trg_tbl_generatedreport_del AFTER DELETE ON tbl_generatedreport FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_generatedreport',OLD.generateid,'delete','pending',NOW()); END//

DROP TRIGGER IF EXISTS trg_tbl_module_purchasekey_ins //
CREATE TRIGGER trg_tbl_module_purchasekey_ins AFTER INSERT ON tbl_module_purchasekey FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_module_purchasekey',NEW.mpid,'insert','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_module_purchasekey_upd //
CREATE TRIGGER trg_tbl_module_purchasekey_upd AFTER UPDATE ON tbl_module_purchasekey FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_module_purchasekey',NEW.mpid,'update','pending',NOW()); END//
DROP TRIGGER IF EXISTS trg_tbl_module_purchasekey_del //
CREATE TRIGGER trg_tbl_module_purchasekey_del AFTER DELETE ON tbl_module_purchasekey FOR EACH ROW
BEGIN INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) VALUES('tbl_module_purchasekey',OLD.mpid,'delete','pending',NOW()); END//

DELIMITER ;

-- ─── BACKFILL INITIAL ────────────────────────────────────────────────────────

INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'acc_account_name',account_id,'insert','pending',NOW() FROM acc_account_name;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'acn_account_transaction',account_tran_id,'insert','pending',NOW() FROM acn_account_transaction;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'department',dept_id,'insert','pending',NOW() FROM department;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'position',pos_id,'insert','pending',NOW() FROM position;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'gender',id,'insert','pending',NOW() FROM gender;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'marital_info',id,'insert','pending',NOW() FROM marital_info;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'duty_type',id,'insert','pending',NOW() FROM duty_type;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'shift_management',id,'insert','pending',NOW() FROM shift_management;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'shift_assign',assignid,'insert','pending',NOW() FROM shift_assign;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'emp_attendance',att_id,'insert','pending',NOW() FROM emp_attendance;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'employee_history',emp_his_id,'insert','pending',NOW() FROM employee_history;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'employee_benifit',id,'insert','pending',NOW() FROM employee_benifit;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'employee_performance',emp_per_id,'insert','pending',NOW() FROM employee_performance;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'employee_salary_setup',e_s_s_id,'insert','pending',NOW() FROM employee_salary_setup;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'employee_salary_payment',emp_sal_pay_id,'insert','pending',NOW() FROM employee_salary_payment;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'salary_type',salary_type_id,'insert','pending',NOW() FROM salary_type;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'salary_setup_header',s_s_h_id,'insert','pending',NOW() FROM salary_setup_header;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'salary_sheet_generate',ssg_id,'insert','pending',NOW() FROM salary_sheet_generate;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'pay_frequency',id,'insert','pending',NOW() FROM pay_frequency;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'payroll_tax_setup',tax_setup_id,'insert','pending',NOW() FROM payroll_tax_setup;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'payroll_holiday',payrl_holi_id,'insert','pending',NOW() FROM payroll_holiday;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'payroll_commission_setting',id,'insert','pending',NOW() FROM payroll_commission_setting;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'weekly_holiday',wk_id,'insert','pending',NOW() FROM weekly_holiday;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'leave_type',leave_type_id,'insert','pending',NOW() FROM leave_type;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'leave_apply',leave_appl_id,'insert','pending',NOW() FROM leave_apply;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'award',award_id,'insert','pending',NOW() FROM award;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'grand_loan',loan_id,'insert','pending',NOW() FROM grand_loan;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'loan_installment',loan_inst_id,'insert','pending',NOW() FROM loan_installment;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'rate_type',id,'insert','pending',NOW() FROM rate_type;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'candidate_basic_info',can_id,'insert','pending',NOW() FROM candidate_basic_info;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'candidate_education_info',can_edu_id,'insert','pending',NOW() FROM candidate_education_info;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'candidate_interview',can_int_id,'insert','pending',NOW() FROM candidate_interview;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'candidate_selection',can_sel_id,'insert','pending',NOW() FROM candidate_selection;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'candidate_shortlist',can_short_id,'insert','pending',NOW() FROM candidate_shortlist;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'candidate_workexperience',can_workexp_id,'insert','pending',NOW() FROM candidate_workexperience;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'user',id,'insert','pending',NOW() FROM user;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'sec_role_tbl',role_id,'insert','pending',NOW() FROM sec_role_tbl;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'sec_role_permission',id,'insert','pending',NOW() FROM sec_role_permission;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'sec_user_access_tbl',role_acc_id,'insert','pending',NOW() FROM sec_user_access_tbl;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'sec_menu_item',menu_id,'insert','pending',NOW() FROM sec_menu_item;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'role_permission',id,'insert','pending',NOW() FROM role_permission;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'module',id,'insert','pending',NOW() FROM module;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'module_permission',id,'insert','pending',NOW() FROM module_permission;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'expense',id,'insert','pending',NOW() FROM expense;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'expense_item',id,'insert','pending',NOW() FROM expense_item;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'supplier',supid,'insert','pending',NOW() FROM supplier;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'supplier_ledger',id,'insert','pending',NOW() FROM supplier_ledger;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'purchaseitem',purID,'insert','pending',NOW() FROM purchaseitem;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'purchase_details',detailsid,'insert','pending',NOW() FROM purchase_details;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'purchase_return',preturn_id,'insert','pending',NOW() FROM purchase_return;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'multipay_bill',multipay_id,'insert','pending',NOW() FROM multipay_bill;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'bill_card_payment',row_id,'insert','pending',NOW() FROM bill_card_payment;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'payment_transactions',id,'insert','pending',NOW() FROM payment_transactions;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'sub_order',sub_id,'insert','pending',NOW() FROM sub_order;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_bank',bankid,'insert','pending',NOW() FROM tbl_bank;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'ingredients',id,'insert','pending',NOW() FROM ingredients;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'production',productionid,'insert','pending',NOW() FROM production;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'production_details',pro_detailsid,'insert','pending',NOW() FROM production_details;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'waste_tracking',id,'insert','pending',NOW() FROM waste_tracking;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'ingradient_food_waste',id,'insert','pending',NOW() FROM ingradient_food_waste;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'items_food_waste',id,'insert','pending',NOW() FROM items_food_waste;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'packaging_food_waste',id,'insert','pending',NOW() FROM packaging_food_waste;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'unit_of_measurement',id,'insert','pending',NOW() FROM unit_of_measurement;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tblreservation',reserveid,'insert','pending',NOW() FROM tblreservation;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'reservationofday',offdayid,'insert','pending',NOW() FROM reservationofday;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tblserver',serverid,'insert','pending',NOW() FROM tblserver;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'qr_orders',id,'insert','pending',NOW() FROM qr_orders;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'qr_payments',payment_id,'insert','pending',NOW() FROM qr_payments;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'table_details',id,'insert','pending',NOW() FROM table_details;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'table_setting',settingid,'insert','pending',NOW() FROM table_setting;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_assign_kitchen',assignid,'insert','pending',NOW() FROM tbl_assign_kitchen;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_cancelitem',cancelid,'insert','pending',NOW() FROM tbl_cancelitem;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_card_terminal',card_terminalid,'insert','pending',NOW() FROM tbl_card_terminal;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_cashcounter',ccid,'insert','pending',NOW() FROM tbl_cashcounter;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_cashregister',id,'insert','pending',NOW() FROM tbl_cashregister;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_itemaccepted',acid,'insert','pending',NOW() FROM tbl_itemaccepted;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_kitchen_order',ktid,'insert','pending',NOW() FROM tbl_kitchen_order;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_openclose',stid,'insert','pending',NOW() FROM tbl_openclose;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_orderprepare',opid,'insert','pending',NOW() FROM tbl_orderprepare;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_posetting',possettingid,'insert','pending',NOW() FROM tbl_posetting;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_quickordersetting',quickordid,'insert','pending',NOW() FROM tbl_quickordersetting;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_rating',ratingid,'insert','pending',NOW() FROM tbl_rating;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_room',id,'insert','pending',NOW() FROM tbl_room;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_updateitems',updateid,'insert','pending',NOW() FROM tbl_updateitems;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'usedcoupon',cusedid,'insert','pending',NOW() FROM usedcoupon;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'email_config',email_config_id,'insert','pending',NOW() FROM email_config;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'sms_template',id,'insert','pending',NOW() FROM sms_template;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'facebook_settings',id,'insert','pending',NOW() FROM facebook_settings;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_customerpoint',id,'insert','pending',NOW() FROM tbl_customerpoint;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'customer_membership_map',id,'insert','pending',NOW() FROM customer_membership_map;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'subscribe_emaillist',emailid,'insert','pending',NOW() FROM subscribe_emaillist;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_seoption',id,'insert','pending',NOW() FROM tbl_seoption;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_soundsetting',soundid,'insert','pending',NOW() FROM tbl_soundsetting;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_generatedreport',generateid,'insert','pending',NOW() FROM tbl_generatedreport;
INSERT INTO sync_queue(entity_type,entity_id,operation,status,created_at) SELECT 'tbl_module_purchasekey',mpid,'insert','pending',NOW() FROM tbl_module_purchasekey;

SELECT CONCAT('Backfill v2 terminé — ', COUNT(*), ' entrées en queue') AS result FROM sync_queue WHERE status = 'pending';
