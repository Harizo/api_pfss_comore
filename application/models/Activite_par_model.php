<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activite_par_model extends CI_Model
{
    protected $table = 'activite_par';

	// Ajout d'un enregistrement
    public function add($plan_action) {
        $this->db->set($this->_set($plan_action))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function add_down($plan_action, $id)  {
        $this->db->set($this->_set_down($plan_action, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
	// Mise à jour d'un enregistrement
    public function update($id, $plan_action)  {
        $this->db->set($this->_set($plan_action))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
	// Affectation colonne de la table
    public function _set($plan_action)  {
        return array(
            'id_par'         => $plan_action['id_par'],
            'description'  => $plan_action['description'],
        );
    }
    public function _set_down($plan_action, $id) {
        return array(
            'id' => $id,
            'id_par' => $plan_action['id_par'],
            'description' => $plan_action['description'],
        );
    }
	// Suppression d'un enregistrement
    public function delete($id)  {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
	// Récupération de tous les enregistrements de la table
    public function findAll()  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('code')
                        ->get()
                        ->result();
        if($result)  {
            return $result;
        }else{
            return null;
        }                 
    }
	// Récupération par id (clé primaire)
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
	// Récupération par id (clé primaire) : réponse : tableau
    public function findByIdArray($id)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
    public function findByIdpar($id_par)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_par", $id_par)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
}
?>