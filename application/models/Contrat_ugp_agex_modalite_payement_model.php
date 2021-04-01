<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_ugp_agex_modalite_payement_model extends CI_Model {
    protected $table = 'contrat_ugp_agex_modalite_payement';

    public function add($contrat_ugp_agex_modalite_payement)  {
        $this->db->set($this->_set($contrat_ugp_agex_modalite_payement))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $contrat_ugp_agex_modalite_payement)  {
        $this->db->set($this->_set($contrat_ugp_agex_modalite_payement))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_ugp_agex_modalite_payement) 
    {
        return array
        (
            'numero_tranche' => $contrat_ugp_agex_modalite_payement['numero_tranche'],
            'id_contrat_ugp_agex' => $contrat_ugp_agex_modalite_payement['id_contrat_ugp_agex'],
            'poucentage'       => $contrat_ugp_agex_modalite_payement['poucentage'],
            'montant'     => $contrat_ugp_agex_modalite_payement['montant']
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
                        ->order_by('numero_tranche', 'asc')
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