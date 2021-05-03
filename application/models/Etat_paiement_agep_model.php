<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Etat_paiement_agep_model extends CI_Model {
    protected $table = 'etat_paiement_agep';

    public function add($etat_paiement_agep)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($etat_paiement_agep))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $etat_paiement_agep)   {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($etat_paiement_agep))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($etat_paiement_agep)  {
		// Affectation des valeurs
        return array(  
            'numero_ordre_paiement' => $etat_paiement_agep['numero_ordre_paiement'],
            'activite_concerne'     => $etat_paiement_agep['activite_concerne'],
            'id_contrat_agep'       => $etat_paiement_agep['id_contrat_agep'],
            'id_menage'             => $etat_paiement_agep['id_menage'],
            'tranche'               => $etat_paiement_agep['tranche'],
            'pourcentage'           => $etat_paiement_agep['pourcentage'],
            //'montant_total_prevu'   => $etat_paiement_agep['montant_total_prevu'],
            'montant_percu'         => $etat_paiement_agep['montant_percu'],
            'date_paiement'         => $etat_paiement_agep['date_paiement'],
            'moyen_transfert'       => $etat_paiement_agep['moyen_transfert'],
            'situation_paiement'    => $etat_paiement_agep['situation_paiement'],
            'id_ile' => $etat_paiement_agep['id_ile'],
            'id_region' => $etat_paiement_agep['id_region'],
            'id_commune' => $etat_paiement_agep['id_commune'],
            'id_village' => $etat_paiement_agep['id_village'],
            'id_communaute' => $etat_paiement_agep['id_communaute']
        );
    }
    public function delete($id)  {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll()  {
		// Selection de tous les enregitrements
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
    public function getetatBycontrat($id_contrat_agep) 
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_contrat_agep',$id_contrat_agep)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
   
   
    public function findById($id)  {
		// Selection par id
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    
}
?>