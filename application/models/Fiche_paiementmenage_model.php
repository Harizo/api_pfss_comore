<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_paiementmenage_model extends CI_Model {
    protected $table = 'see_fichepaiementmenage';

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
            'fiche_paiement_id'        => $fiche_pres['fiche_paiement_id'],
            'menage_id'  => $fiche_pres['menage_id'],                      
            'village_id'  => $fiche_pres['village_id'],                      
            'fiche_presence_id'        => $fiche_pres['fiche_presence_id'],
            'microprojet_id'        => $fiche_pres['microprojet_id'],
            'travailleurpresent'      => $fiche_pres['travailleurpresent'],                      
            'suppliantpresent' => $fiche_pres['suppliantpresent'],                      
            'montanttotalapayer' => $fiche_pres['montanttotalapayer'],                      
            'montanttotalpaye' => $fiche_pres['montanttotalpaye'],                      
            'montantapayertravailleur' => $fiche_pres['montantapayertravailleur'],                      
            'montantpayetravailleur' => $fiche_pres['montantpayetravailleur'],                      
            'montantapayersuppliant' => $fiche_pres['montantapayersuppliant'],                      
            'montantpayesuppliant' => $fiche_pres['montantpayesuppliant'],                      
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
    public function findByFiche_paiement_id($fiche_paiement_id)  {
		// Selection de tous les enregitrements
		 $requete="SELECT fp.id,i.id as ile_id,i.ile,r.id as region_id,r.region,c.id as commune_id,c.commune,"
				."fp.village_id as village_id,v.village,"
				."fp.activite_id,act.detail as activite,fpp.agex_id,ag.identifiant_agex,"
				."v.zone_id,z.libelle as zone,ifnull(date_format(fpp.datedu,'%Y-%m-%d'),'') as datedu,ifnull(date_format(fpp.datefin,'%Y-%m-%d'),'') as datefin,fp.nombrejourdetravail,"
				."fpp.fichepaiement_id,ifnull(date_format(fp.datepaiement,'%Y-%m-%d'),'') as datepaiement,"
				."fp.microprojet_id,mic.description as microprojet,mic.code as code_sous_projet,"
				."fp.etape_id,ph.phase,fp.id_annee as id_annee,a.annee,agp.identifiant as code_agep,agp.raison_social as nom_agep,"
				."fp.montanttotalapayer,fp.montanttotalpaye,fp.montantapayertravailleur,fp.montantpayetravailleur,"
				."fp.montantapayersuppliant,fp.montantpayesuppliant"
				." from see_fichepaiement as fp"
				." left outer join see_fichepresence as fpp on fpp.id=fp.fichepresence_id"
				." left outer join see_village as v on v.id=fp.village_id"
				." left outer join see_commune as c on c.id=v.commune_id"
				." left outer join see_region as r on r.id=c.region_id"
				." left outer join see_ile as i on i.id=r.ile_id"
				." left outer join see_activite as act on act.id=fp.activite_id"
				." left outer join see_agex as ag on ag.id=fpp.agex_id"
				." left outer join see_agent as agp on agp.id=fp.agep_id"
				." left outer join zip as z on z.id=v.zone_id"
				." left outer join sous_projet as mic on mic.id=fp.microprojet_id"
				." left outer join see_phaseexecution as ph on ph.id=fp.etape_id"
				." left outer join see_annee as a on a.id=fp.id_annee"	
				." where fp.id=".$fiche_paiement_id
				." order by i.ile,r.region,c.commune,z.libelle,v.village,act.detail,ph.phase,fp.datepaiement";	
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{ 
            return null;
        }                  
    }
    public function findDetailByFiche_paiement_id($fiche_paiement_id,$id_sous_projet)  {
		// Selection de tous les enregitrements
		 $requete="SELECT fp.id,i.id as ile_id,i.ile,r.id as region_id,r.region,c.id as commune_id,c.commune,"
				."fp.village_id as village_id,v.village,"
				."fp.activite_id,act.detail as activite,fpp.agex_id,ag.identifiant_agex,"
				."v.zone_id,z.libelle as zone,ifnull(date_format(fpp.datedu,'%Y-%m-%d'),'') as datedu,ifnull(date_format(fpp.datefin,'%Y-%m-%d'),'') as datefin,fp.nombrejourdetravail,"
				."fpp.fichepaiement_id,ifnull(date_format(fp.datepaiement,'%Y-%m-%d'),'') as datepaiement,"
				."fp.microprojet_id,mic.description as microprojet,mic.code as code_sous_projet,"
				."fp.etape_id,ph.phase,fp.id_annee as id_annee,a.annee,agp.identifiant as code_agep,agp.raison_social as nom_agep,"
				."fp.montanttotalapayer as totalmontanttotalapayer ,fp.montanttotalpaye as totalmontanttotalpaye,"
				."fp.montantapayertravailleur as totalmontantapayertravailleur,fp.montantpayetravailleur as totalmontantpayetravailleur,"
				."fp.montantapayersuppliant as totalmontantapayersuppliant,fp.montantpayesuppliant as totalmontantpayesuppliant,"
				."fpm.montanttotalapayer ,fpm.montanttotalpaye,fpm.montantapayertravailleur,fpm.montantpayetravailleur,"
				."fpm.montantapayersuppliant,fpm.montantpayesuppliant"
				." from see_fichepaiementmenage as fpm"
				." left outer join see_fichepaiement as fp on fp.id=fpm.fiche_paiement_id"
				." left outer join see_fichepresence as fpp on fpp.id=fp.fichepresence_id"
				." left outer join see_village as v on v.id=fp.village_id"
				." left outer join see_commune as c on c.id=v.commune_id"
				." left outer join see_region as r on r.id=c.region_id"
				." left outer join see_ile as i on i.id=r.ile_id"
				." left outer join see_activite as act on act.id=fp.activite_id"
				." left outer join see_agex as ag on ag.id=fpp.agex_id"
				." left outer join see_agent as agp on agp.id=fp.agep_id"
				." left outer join zip as z on z.id=v.zone_id"
				." left outer join sous_projet as mic on mic.id=fp.microprojet_id"
				." left outer join see_phaseexecution as ph on ph.id=fp.etape_id"
				." left outer join see_annee as a on a.id=fp.id_annee"	
				." where fp.id=".$fiche_paiement_id
				." order by i.ile,r.region,c.commune,z.libelle,v.village,act.detail,ph.phase,fp.datepaiement";	
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