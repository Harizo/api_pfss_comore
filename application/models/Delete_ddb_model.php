<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Delete_ddb_model extends CI_Model {
    

    public function delete($table) {
        $resp = $this->db->empty_table($table); 
        if($resp)  
        {
            return true;
        }
        else
        {
            return null;
        }  
    }

    public function add($data, $table)  {
        $this->db->set($this->_set($data, $table))
                            ->insert($table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

     public function _set($colonne, $table) {

		switch ($nom_table) {
			case "plan_action_reinstallation":
				return array(
					'id' => $colonne['id'],
					'intitule' => $colonne['intitule'],
					'description' => $colonne['description'],
					'id_commune' => $colonne['id_commune'],
				);
				break;
			case "activite_par":
				return array(
					'id' => $colonne['id'],
					'id_par' => $colonne['id_par'],
					'description' => $colonne['description'],
				);
				break;
        }
    }
}
?>