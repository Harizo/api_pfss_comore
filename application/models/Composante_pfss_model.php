<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class composante_pfss_model extends CI_Model {
    protected $table = 'composante_pfss';

   /* public function getAll(controller) {                               
            $this->db->set($this)

        } */

    public function add($composante)  {
        $this->db->set($this->_set($composante))

                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function add_down($composante, $id)  {
        $this->db->set($this->_set_down($composante, $id))
                            ->insert($this->table);

        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id(); 
        }else{
            return null;
        }                    
    }
    public function update($id, $composante)  {
        $this->db->set($this->_set($composante))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($composante) { 
        return array(           
            'code' => $composante['code'],
            'libelle' => $composante['libelle'],
            'montant_prevu' => $composante['montant_prevu']
        );
    }

    public function _set_down($composante, $id) {
        return array(
            'id' => $id,
            'code' => $composante['code'],
            'libelle' => $composante['libelle'],
            'montant_prevu' => $composante['montant_prevu'] 
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
                        ->order_by('code')
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