<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_suivi_prelevement_payement_model extends CI_Model {
    protected $table = 'fiche_suivi_prelevement_payement';

    public function add($fiche_suivi_prelevement_payement)  {
        $this->db->set($this->_set($fiche_suivi_prelevement_payement))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $fiche_suivi_prelevement_payement)  {
        $this->db->set($this->_set($fiche_suivi_prelevement_payement))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_suivi_prelevement_payement) 
    {
        return array
        (
            

            'id_fspr'             => $fiche_suivi_prelevement_payement['id_fspr'],
            'numero_tranche'      => $fiche_suivi_prelevement_payement['numero_tranche'],
            'etat_paiement'       => $fiche_suivi_prelevement_payement['etat_paiement'],
            'date_paiement'         => $fiche_suivi_prelevement_payement['date_paiement']
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
    
 
    public function findBy_id_fspr($id_fspr)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_fspr", $id_fspr)
                      
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