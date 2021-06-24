<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formation_ml_repartition_model extends CI_Model {
    protected $table = 'formation_ml_repartition';

    public function add($formation_ml_repartition)  {
        $this->db->set($this->_set($formation_ml_repartition))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $formation_ml_repartition)  {
        $this->db->set($this->_set($formation_ml_repartition))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($formation_ml_repartition) 
    {
        return array
        (
            'num_groupe'     => $formation_ml_repartition['num_groupe'],
            'date_formation'            => $formation_ml_repartition['date_formation'],
            'nbr_ml'     => $formation_ml_repartition['nbr_ml'],
            'lieu_formation'      => $formation_ml_repartition['lieu_formation'],
            'responsable'      => $formation_ml_repartition['responsable'],
            'id_formation_ml'      => $formation_ml_repartition['id_formation_ml']
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
    
    
    public function getformation_ml_repartitionByformation($id_formation_ml)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_formation_ml", $id_formation_ml)
                        ->order_by('num_groupe', 'asc')
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