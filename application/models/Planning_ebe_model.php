<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planning_ebe_model extends CI_Model {
    protected $table = 'planning_ebe';

    public function add($planning_ebe)  {
        $this->db->set($this->_set($planning_ebe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $planning_ebe)  {
        $this->db->set($this->_set($planning_ebe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($planning_ebe) 
    {
        return array
        (
            'id_theme_sensibilisation'     => $planning_ebe['id_theme_sensibilisation'],
            'id_groupe_ml_pl'   => $planning_ebe['id_groupe_ml_pl'],
            'numero'=> $planning_ebe['numero'],
            'date_ebe'      => $planning_ebe['date_ebe'],
            'duree'       => $planning_ebe['duree'],
            'lieu'     => $planning_ebe['lieu'],
            'id_village'     => $planning_ebe['id_village']
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
    
    
    public function getplanning_ebeByvillage($id_village)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_village", $id_village)
                        ->order_by('numero', 'asc')
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