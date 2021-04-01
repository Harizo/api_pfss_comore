<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_ugp_agex_pv_remise_model extends CI_Model {
    protected $table = 'pv_remise_agex';

    public function add($contrat_ugp_agex_pv_remise)  {
        $this->db->set($this->_set($contrat_ugp_agex_pv_remise))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $contrat_ugp_agex_pv_remise)  {
        $this->db->set($this->_set($contrat_ugp_agex_pv_remise))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_ugp_agex_pv_remise) 
    {
        return array
        (
            'id_contrat_ugp_agex' => $contrat_ugp_agex_pv_remise['id_contrat_ugp_agex'],
            'nom_representant_cps'       => $contrat_ugp_agex_pv_remise['nom_representant_cps'],
            'date_remise'     => $contrat_ugp_agex_pv_remise['date_remise']
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
    public function findByContrat_ugp_agex($id_contrat_ugp_agex)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_ugp_agex", $id_contrat_ugp_agex)
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