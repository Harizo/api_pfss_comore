<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lienparental_model extends CI_Model
{
    protected $table = 'liendeparente';

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
            'description'  => $plan_action['description'],
            'a_ete_modifie'  => $plan_action['a_ete_modifie'],
            'supprime'  => $plan_action['supprime'],
            'userid'  => $plan_action['userid'],
            'datemodification'  => $plan_action['datemodification'],
        );
    }
    public function _set_down($plan_action, $id) {
        return array(
            'id' => $id,
            'description' => $plan_action['description'],
            'a_ete_modifie' => $plan_action['a_ete_modifie'],
            'supprime' => $plan_action['supprime'],
            'datemodification' => $plan_action['datemodification'],
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
                        ->order_by('description')
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
}
?>