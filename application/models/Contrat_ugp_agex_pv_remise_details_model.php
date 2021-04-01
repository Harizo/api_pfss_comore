<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_ugp_agex_pv_remise_details_model extends CI_Model {
    protected $table = 'pv_remise_details_agex';

    public function add($contrat_ugp_agex_pv_remise_details)  {
        $this->db->set($this->_set($contrat_ugp_agex_pv_remise_details))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $contrat_ugp_agex_pv_remise_details)  {
        $this->db->set($this->_set($contrat_ugp_agex_pv_remise_details))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_ugp_agex_pv_remise_details) 
    {
        return array
        (
            'id_pv_remise_agex' => $contrat_ugp_agex_pv_remise_details['id_pv_remise_agex'],
            'intitule'       => $contrat_ugp_agex_pv_remise_details['intitule'],
            'nombre'     => $contrat_ugp_agex_pv_remise_details['nombre'],
            'observation'     => $contrat_ugp_agex_pv_remise_details['observation']
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
    public function findByPvremise($id_pv_remise_agex)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_pv_remise_agex", $id_pv_remise_agex)
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