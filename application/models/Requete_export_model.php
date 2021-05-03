<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requete_export_model extends CI_Model
{
    protected $table = 'region';

 
    public function Fiche_etat_de_presence($id_sous_projet,$village_id)
    {
		$requete="select m.inapte,m.NumeroEnregistrement,m.NumeroEnregistrement as menage,m.nomchefmenage,mp.id,mp.id_menage,mp.id_sous_projet,"
				."m.NomTravailleur as nomTravailleur,m.SexeTravailleur,m.NomTravailleurSuppliant as nomTravailleurSuppliant,"
				."m.SexeTravailleurSuppliant,m.milieu,"
				."m.identifiant_menage,m.datedenaissancetravailleur,m.numerocintravailleur,m.numerocarteelectoraletravailleur,"
				."m.datedenaissancesuppliant,m.numerocinsuppliant,m.numerocarteelectoralesuppliant,m.Addresse,m.SexeChefMenage"
				." from menage_beneficiaire as mp"
				." left outer join menage as m on m.id=mp.id_menage"
				." left outer join see_village as v on v.id=m.village_id"
                ." where mp.id_sous_projet=".$id_sous_projet
				." and v.id=".$village_id." and m.statut='BENEFICIAIRE'";	
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    public function Etat_recepteur($id_sous_projet,$village_id)
    {
		$requete="select m.inapte,m.NumeroEnregistrement,m.NumeroEnregistrement as menage,m.nomchefmenage,mp.id,mp.id_menage,mp.id_sous_projet,"
				."m.NomTravailleur as NomTravailleur,m.SexeTravailleur,m.NomTravailleurSuppliant as NomTravailleurSuppliant,"
				."m.SexeTravailleurSuppliant,m.milieu,"
				."m.identifiant_menage,DATE_FORMAT(m.datedenaissancetravailleur,'%d/%m/%Y') as datedenaissancetravailleur,m.numerocintravailleur,m.numerocarteelectoraletravailleur,"
				."DATE_FORMAT(m.datedenaissancesuppliant,'%d/%m/%Y') as datedenaissancesuppliant,m.numerocinsuppliant,m.numerocarteelectoralesuppliant,m.Addresse,m.SexeChefMenage,"
				."m.agetravailleur,m.agesuppliant,m.NumeroCIN,m.NumeroCarteElectorale"
				." from menage_beneficiaire as mp" 
				." left outer join menage as m on m.id=mp.id_menage"
				." left outer join see_village as v on v.id=m.village_id"
                ." where mp.id_sous_projet=".$id_sous_projet
				." and v.id=".$village_id." and m.statut='BENEFICIAIRE'";	
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    public function Fiche_etat_de_paiement($village_id)
    {
		$requete="select fp.id,fp.annee as id_annee,a.annee,fp.microprojet_id,sp.description as sous_projet,"
				." fp.etape_id,et.Phase as etape,fp.agex_id,ag.Nom as agex,fp.fichepaiement_id,fp.inapte,fp.datedu,"
				." fp.datefin,fp.observation,fp.nombrejourdetravail,fp.village_id,v.Village as village,"
				."z.code as code_zip,z.libelle as zip,if(fp.inapte=1,'(Inapte)','') as etat"
				." from see_fichepresence as fp"
				." left join see_annee as a on a.id=fp.annee"
				." left join sous_projet as sp on sp.id=fp.microprojet_id"
				." left join see_phaseexecution as et on et.id=fp.etape_id"
				." left join see_agex as ag on ag.id=fp.agex_id"
				." left join see_village as v on v.id=fp.village_id"
				." left join zip as z on z.id=v.zone_id"
				." where fp.microprojet_id >'' and fp.fichepaiement_id is null "
				." and fp.village_id=".$village_id
				." order by fp.id,fp.datedu,fp.inapte";
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
    public function Detail_fiche_etat_de_paiement($id_fichepresence)
    {
		$requete="select fpm.fiche_presence_id,fpm.menage_id,fpm.village_id,fpm.travailleurpresent,fpm.suppliantpresent,"
				." m.NumeroEnregistrement,m.nomchefmenage,m.NomTravailleur as nomtravailleur,m.NomTravailleurSuppliant as nomtravailleursuppliant,"
				."m.sexeChefMenage,m.sexeTravailleur,m.sexeTravailleurSuppliant,fp.inapte,fp.nombrejourdetravail"
				." from see_fichepresencemenage as fpm"
				."  left join see_fichepresence as fp on fp.id=fpm.fiche_presence_id"
				."  left join menage as m on m.id=fpm.menage_id"
				."   where fpm.fiche_presence_id=".$id_fichepresence;
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
    }
	public function Liste_etat_presence($village_id,$requetefiltre) {
		$requete="SELECT fp.id,i.id as ile_id,i.ile,r.id as region_id,r.region,c.id as commune_id,c.commune,"
				."fp.village_id as village_id,v.village,"
				."fp.activite_id,act.detail as activite,fp.agex_id,ag.identifiant_agex,"
				."v.zone_id,z.zone,ifnull(date_format(fp.datedu,'%Y-%m-%d'),'') as datedu,ifnull(date_format(fp.datefin,'%Y-%m-%d'),'') as datefin,fp.nombrejourdetravail,"
				."fp.fichepaiement_id,ifnull(date_format(fpaie.datepaiement,'%Y-%m-%d'),'') as datepaiement,"
				."fp.microprojet_id,mic.description as microprojet,mic.code as code_sous_projet,"
				."fp.etape_id,ph.phase,fp.annee as annee_id,a.annee"
				." from see_fichepresence as fp"
				." left outer join see_village as v on v.id=fp.village_id"
				." left outer join see_commune as c on c.id=v.commune_id"
				." left outer join see_region as r on r.id=c.region_id"
				." left outer join see_ile as i on i.id=r.ile_id"
				." left outer join see_activite as act on act.id=fp.activite_id"
				." left outer join see_agex as ag on ag.id=fp.agex_id"
				." left outer join see_zone as z on z.id=v.zone_id"
				." left outer join see_fichepaiement as fpaie on fpaie.id=fp.fichepaiement_id"
				." left outer join sous_projet as mic on mic.id=fp.microprojet_id"
				." left outer join see_phaseexecution as ph on ph.id=fp.etape_id"
				." left outer join see_annee as a on a.id=fp.annee"	
				." where fp.village_id=".$village_id.$requetefiltre
				." order by i.ile,r.region,c.commune,z.zone,v.village,act.detail,ph.phase,fp.datedu";	
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
		
	}
	public function Liste_etat_paiement($village_id,$requetefiltre) {
		$requete="SELECT fp.id,i.id as ile_id,i.ile,r.id as region_id,r.region,c.id as commune_id,c.commune,"
				."fp.village_id as village_id,v.village,"
				."fp.activite_id,act.detail as activite,fpp.agex_id,ag.identifiant_agex,"
				."v.zone_id,z.zone,ifnull(date_format(fpp.datedu,'%Y-%m-%d'),'') as datedu,ifnull(date_format(fpp.datefin,'%Y-%m-%d'),'') as datefin,fp.nombrejourdetravail,"
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
				." left outer join see_zone as z on z.id=v.zone_id"
				." left outer join sous_projet as mic on mic.id=fp.microprojet_id"
				." left outer join see_phaseexecution as ph on ph.id=fp.etape_id"
				." left outer join see_annee as a on a.id=fp.id_annee"	
				." where fp.village_id=".$village_id.$requetefiltre
				." order by i.ile,r.region,c.commune,z.zone,v.village,act.detail,ph.phase,fp.datepaiement";	
				$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
		
	}
	public function Nombre_travailleur_par_sexe($id_sous_projet,$village_id) {
		$requete="select m.village_id,mb.id_sous_projet,"
				." (select ifnull(count(m1.id),0) from menage_beneficiaire as m1 where m1.id_sous_projet=mb.id_sous_projet group by m1.id_sous_projet, mb.id_sous_projet) as nombre_menage_beneficiaire,"
				." (select ifnull(count(m1.SexeChefMenage),0) from menage as m1 where m1.SexeChefMenage='H' group by m1.village_id,m.village_id,mb.id_sous_projet) as nombre_chefmenage_homme ,"
				." (select ifnull(count(m1.SexeChefMenage),0) from menage as m1 where m1.SexeChefMenage='F'  group by m1.village_id,m.village_id,mb.id_sous_projet) as nombre_chefmenage_femme ,"
				." (select ifnull(count(m1.SexeTravailleur),0) from menage as m1 where m1.SexeTravailleur='H'  group by m1.village_id,m.village_id,mb.id_sous_projet) as nombre_travailleur_homme,"
				." (select ifnull(count(m1.SexeTravailleur),0)  from menage as m1 where m1.SexeTravailleur='F' group by m1.village_id,m.village_id,mb.id_sous_projet) as nombre_travailleur_femme,"
				." (select ifnull(count(m1.SexeTravailleurSuppliant),0) from menage as m1 where m1.SexeTravailleurSuppliant='H' group by m1.village_id,m.village_id,mb.id_sous_projet) as nombre_suppleant_homme,"
				." (select ifnull(count(m1.SexeTravailleurSuppliant),0) from menage as m1 where m1.SexeTravailleurSuppliant='F' group by m1.village_id,m.village_id,mb.id_sous_projet) as nombre_suppleant_femme"
				." from menage as m"
				." left join menage_beneficiaire as mb on mb.id_menage=m.id"
				." where mb.id_sous_projet=".$id_sous_projet." and m.village_id=".$village_id
				." group by m.village_id,mb.id_sous_projet";
		$result = $this->db->query($requete)->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                  
		
	}
    public function findById($id)  {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    public function findByIdArray($id)  {
        $result =  $this->db->select('*')
                        ->from($
                            $this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
}
