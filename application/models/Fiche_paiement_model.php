<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_paiement_model extends CI_Model {
    protected $table = 'see_fichepaiement';

    public function add($fiche_pres)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($fiche_pres))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $fiche_pres)   {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($fiche_pres))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($fiche_pres)  {
		// Affectation des valeurs
        return array(
            'activite_id'        => $fiche_pres['activite_id'],
            'village_id'  => $fiche_pres['village_id'],                      
            'id_annee'  => $fiche_pres['id_annee'],                      
            'microprojet_id'  => $fiche_pres['microprojet_id'],                      
            'etape_id'      => $fiche_pres['etape_id'],                      
            'agep_id' => $fiche_pres['agep_id'],                      
            'fichepresence_id' => $fiche_pres['fichepresence_id'],                      
            'inapte' => $fiche_pres['inapte'],                      
            'datepaiement' => $fiche_pres['datepaiement'],                      
            'nombrejourdetravail' => $fiche_pres['nombrejourdetravail'],                      
            'montanttotalapayer' => $fiche_pres['montanttotalapayer'],                      
            'montanttotalpaye' => $fiche_pres['montanttotalpaye'],                      
            'montantapayertravailleur' => $fiche_pres['montantapayertravailleur'],                      
            'montantpayetravailleur' => $fiche_pres['montantpayetravailleur'],                      
            'montantapayersuppliant' => $fiche_pres['montantapayersuppliant'],                      
            'montantpayesuppliant' => $fiche_pres['montantpayesuppliant'],                      
            'indemnite' => $fiche_pres['indemnite'],                      
            'observation' => $fiche_pres['observation'],                      
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
    public function findById($id)  {
		// Selection par id
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findByVillageAndEtapeAndMicroprojet($village_id,$requeteplus,$microprojet_id)  {
		 $requete="SELECT see_fichepaiement.*,i.id as ile_id,i.ile,r.id as region_id,r.region,c.id as commune_id,c.commune,v.id as village_id,v.village,"
				."ph.phase as tranche"
				."  from see_fichepaiement"
				." left join see_village as v on v.id=see_fichepaiement.village_id"
				." left join see_commune as c on c.id=v.commune_id"
				." left join see_region as r on r.id=c.region_id"
				." left join see_ile as i on i.id=r.ile_id"
				." left join see_phaseexecution as ph on ph.id=see_fichepaiement.etape_id"
				." where microprojet_id=".$microprojet_id.$requeteplus;
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
 
}
?>