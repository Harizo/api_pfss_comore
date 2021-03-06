<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agence_p_model extends CI_Model {
    protected $table = 'see_agent';

    public function add($agence_p)  {
        $this->db->set($this->_set($agence_p))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function add_down($agence_p, $id)  {
        $this->db->set($this->_set_down($agence_p, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $agence_p)  {
        $this->db->set($this->_set($agence_p))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($agence_p) {
        return array(
            'identifiant' => $agence_p['identifiant'],
            'raison_social' => $agence_p['raison_social'],
            'nom_contact' => $agence_p['nom_contact'],
            'titre_contact' => $agence_p['titre_contact'],
            'numero_phone_contact' => $agence_p['numero_phone_contact'],
            'adresse' => $agence_p['adresse']
        );
    }

    public function _set_down($agence_p, $id) {
        return array(
            'id' => $id,
            'identifiant' => $agence_p['identifiant'],
            'raison_social' => $agence_p['raison_social'],
            'nom_contact' => $agence_p['nom_contact'],
            'titre_contact' => $agence_p['titre_contact'],
            'numero_phone_contact' => $agence_p['numero_phone_contact'],
            'adresse' => $agence_p['adresse']
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
                        ->order_by('id')
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