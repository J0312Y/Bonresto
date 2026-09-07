<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {


	public function checkUser($data = array())
	{
		// Audit F-11 : l'empreinte n'est plus comparee dans le SQL. On charge
		// la ligne par l'adresse, on verifie en PHP — Saas_password accepte
		// l'ancien MD5 comme le bcrypt — et on remet l'empreinte a niveau au
		// premier succes. Personne n'a de mot de passe a changer.
		$this->load->library('Saas_password');

		$compte = $this->db->select('id, password')
			->from('user')
			->where('email', $data['email'])
			->get()->row();

		$valide = $compte && Saas_password::verifier($data['password'], $compte->password);

		if ($valide && Saas_password::a_rehacher($compte->password)) {
			$this->db->where('id', $compte->id)
				->update('user', ['password' => Saas_password::hacher($data['password'])]);
		}

		return $this->db->select("
				user.id,
				CONCAT_WS(' ', user.firstname, user.lastname) AS fullname,
				user.email,
				user.image,
				user.last_login,
				user.last_logout,
				user.ip_address,
				user.counter,
				user.status,
				user.is_admin,
				IF (user.is_admin=3, 'Super Admin', IF(user.is_admin=1, 'Admin', 'User')) as user_level
			")
			->from('user')
			// Echec d'authentification : on filtre sur un id impossible pour
			// renvoyer un jeu vide, et conserver la forme de retour attendue
			// par le controleur (num_rows() puis row()).
			->where('user.id', $valide ? (int) $compte->id : 0)
			->get();
	}


	public function userPermission1($id = null)
	{
		
		$acc_tbl = $this->db->select('*')->from('sec_user_access_tbl')->where('fk_user_id',$id)->get()->result();

		if($acc_tbl!=NULL){

			$role_id = [];
			foreach ($acc_tbl as $key => $value) {
				$role_id[] = $value->fk_role_id;
			}

		return	$result = $this->db->select("
			module.directory, 
			module_permission.fk_module_id, 
			IF(SUM(module_permission.create)>=1,1,0) AS 'create', 
			IF(SUM(module_permission.read)>=1,1,0) AS 'read', 
			IF(SUM(module_permission.update)>=1,1,0) AS 'update', 
			IF(SUM(module_permission.delete)>=1,1,0) AS 'delete'
			")
			->from('module_permission')
			->join('module', 'module.id = module_permission.fk_module_id', 'full')
			->where_in('module_permission.fk_role_id', $role_id)
			->where('module.status', 1)
			->group_by('module_permission.fk_module_id')
			->group_start()
				->where('create', 1)
				->or_where('read', 1)
				->or_where('update', 1)
				->or_where('delete', 1)
			->group_end()
			->get()
			->result();
		} else {
			return 0;
		}
	}
	

public function userPermission2($id = null)
	{
		
		$acc_tbl = $this->db->select('*')->from('sec_user_access_tbl')->where('fk_user_id',$id)->get()->result();

		if($acc_tbl!=NULL){

			$role_id = [];
			foreach ($acc_tbl as $key => $value) {
				$role_id[] = $value->fk_role_id;
			}

		return	$result = $this->db->select("
				sec_role_permission.role_id, 
				sec_role_permission.menu_id, 
				IF(SUM(sec_role_permission.can_create)>=1,1,0) AS 'create', 
				IF(SUM(sec_role_permission.can_access)>=1,1,0) AS 'read', 
				IF(SUM(sec_role_permission.can_edit)>=1,1,0) AS 'update', 
				IF(SUM(sec_role_permission.can_delete)>=1,1,0) AS 'delete',
				sec_menu_item.menu_title,
				sec_menu_item.page_url,
				sec_menu_item.module
				")
				->from('sec_role_permission')
				->join('sec_menu_item', 'sec_menu_item.menu_id = sec_role_permission.menu_id', 'full')
				->where_in('sec_role_permission.role_id', $role_id)
				->group_by('sec_role_permission.menu_id')
				->group_start()
					->where('can_create', 1)
					->or_where('can_access', 1)
					->or_where('can_edit', 1)
					->or_where('can_delete', 1)
				->group_end()
				->get()
				->result();
			} else {
				return 0;
		}
	}




	public function userPermission($id = null)
	{
		return $this->db->select("
			module.directory, 
			module_permission.fk_module_id, 
			module_permission.create, 
			module_permission.read, 
			module_permission.update, 
			module_permission.delete
			")
			->from('module_permission')
			->join('module', 'module.id = module_permission.fk_module_id', 'full')
			->where('module_permission.fk_user_id', $id)
			->where('module.status', 1)
			->group_start()
				->where('create', 1)
				->or_where('read', 1)
				->or_where('update', 1)
				->or_where('delete', 1)
			->group_end()
			->get()
			->result();
	}





	public function last_login($id = null)
	{
		return $this->db->set('last_login', date('Y-m-d H:i:s'))
			->set('ip_address', $this->input->ip_address())
			->where('id',$this->session->userdata('id'))
			->update('user');
	}

	public function last_logout($id = null)
	{
		return $this->db->set('last_logout', date('Y-m-d H:i:s'))
			->where('id', $this->session->userdata('id'))
			->update('user');
	}


}
 
