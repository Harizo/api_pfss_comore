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
            'Code' => $agence_p['Code'],
            'Nom' => $agence_p['Nom'],
            'Contact' => $agence_p['Contact'],
            'Representant' => $agence_p['Representant'],
            'Telephone' => $agence_p['Telephone'],
            'programme_id' => $agence_p['programme_id'],
            'ile_id' => $agence_p['ile_id']
        );
    }

    public function _set_down($agence_p, $id) {
        return array(
            'id' => $id,
            'Code' => $agence_p['Code'],
            'Nom' => $agence_p['Nom'],
            'Contact' => $agence_p['Contact'],
            'Representant' => $agence_p['Representant'],
            'Telephone' => $agence_p['Telephone'],
            'programme_id' => $agence_p['programme_id'],
            'ile_id' => $agence_p['ile_id']
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
                        ->order_by('Nom')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
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