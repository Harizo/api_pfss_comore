<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Etat_paiement_depense_model extends CI_Model {
    protected $table = 'etat_paiement_depense';

    public function add($etat_paiement_depense)  {
        $this->db->set($this->_set($etat_paiement_depense))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $etat_paiement_depense)  {
        $this->db->set($this->_set($etat_paiement_depense))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($etat_paiement_depense) 
    {
        return array
        (
            'id_contrat_ugp_agex' => $etat_paiement_depense['id_contrat_ugp_agex'],
            'date_debut'       => $etat_paiement_depense['date_debut'],
            'date_fin'       => $etat_paiement_depense['date_fin'],
            'designation'     => $etat_paiement_depense['designation'],
            'montant_recu'     => $etat_paiement_depense['montant_recu'],
            'montant_depense'     => $etat_paiement_depense['montant_depense'],
            'reliquat'     => $etat_paiement_depense['reliquat']
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