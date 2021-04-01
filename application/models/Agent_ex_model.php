<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agent_ex_model extends CI_Model {
    protected $table = 'see_agex';

    public function add($agent_ex)  {
        $this->db->set($this->_set($agent_ex))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function add_down($agent_ex, $id)  {
        $this->db->set($this->_set_down($agent_ex, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $agent_ex)  {
        $this->db->set($this->_set($agent_ex))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($agent_ex) {
        return array(
            'identifiant_agex' => $agent_ex['identifiant_agex'],
            'Nom' => $agent_ex['Nom'],
            'intervenant_agex' => $agent_ex['intervenant_agex'],
            'nom_contact_agex' => $agent_ex['nom_contact_agex'],
            'titre_contact' => $agent_ex['titre_contact'],
            'numero_phone_contact' => $agent_ex['numero_phone_contact'],
            'adresse_agex' => $agent_ex['adresse_agex']
        );
    }

    public function _set_down($agent_ex, $id) {
        return array(
            'id' => $id,
            'identifiant_agex' => $agent_ex['identifiant_agex'],
            'Nom' => $agent_ex['Nom'],
            'intervenant_agex' => $agent_ex['intervenant_agex'],
            'nom_contact_agex' => $agent_ex['nom_contact_agex'],
            'titre_contact' => $agent_ex['titre_contact'],
            'numero_phone_contact' => $agent_ex['numero_phone_contact'],
            'adresse_agex' => $agent_ex['adresse_agex']
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('identifiant_agex')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
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
            return null;
        }                 
    }
}
?>