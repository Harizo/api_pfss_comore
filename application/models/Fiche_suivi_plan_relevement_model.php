<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_suivi_plan_relevement_model extends CI_Model {
    protected $table = 'fiche_suivi_plan_relevement';

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
            'id_village'                            => $fiche_pres['id_village'],
            'id_menage'                             => $fiche_pres['id_menage'],                      
            'id_agex'                               => $fiche_pres['id_agex']
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

    /*public function findAllby_id_village($id_village)  {
        
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_village", $id_village)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }*/


    public function findAllby_id_village($id_village)  {
        
        $sql = 
        "
            select
                fpri.id AS id,
                
                
                
                si.id AS id_ile,
                si.Ile,
                
                sr.id AS id_region,
                sr.Region,
                
                sc.id AS id_commune,
                sc.Commune,
                
                sv.id AS id_village,
                sv.Village ,
                
                z.libelle AS zip,
                sv.vague AS vague,
                
                m.id AS id_menage,
                m.identifiant_menage,
                m.nomchefmenage AS nom_chef_menage,
                m.agechefdemenage,
                m.nombre_enfant_moins_quinze_ans,
                m.NomTravailleur,
                m.NomTravailleurSuppliant,
                
                sa.id as id_agex,
                sa.Nom AS nom_agex
                
            FROM
                fiche_suivi_plan_relevement AS fpri,
                menage AS m,
                see_agex AS sa,
                see_village AS sv,
                see_commune AS sc,
                see_region AS sr,
                see_ile AS si,
                zip AS z
            WHERE 
                fpri.id_village = sv.id
                AND fpri.id_menage = m.id
                AND fpri.id_agex = sa.id
                AND sc.id = sv.commune_id
                AND sr.id = sc.region_id
                AND si.id = sr.ile_id
                AND sv.id_zip = z.id
                and sv.id = ".$id_village."
        ";
        return $this->db->query($sql)->result();               
    }



    public function findById($id)  {
		$sql = 
        "
            select
                fpri.id AS id,
                
                
                
                si.id AS id_ile,
                si.Ile,
                
                sr.id AS id_region,
                sr.Region,
                
                sc.id AS id_commune,
                sc.Commune,
                
                sv.id AS id_village,
                sv.Village ,
                
                z.libelle AS zip,
                sv.vague AS vague,
                
                m.id AS id_menage,
                m.identifiant_menage,
                m.nomchefmenage AS nom_chef_menage,
                m.agechefdemenage,
                m.nombre_enfant_moins_quinze_ans,
                m.NomTravailleur,
                m.NomTravailleurSuppliant,
                
                sa.id as id_agex,
                sa.Nom AS nom_agex
                
            FROM
                fiche_suivi_plan_relevement AS fpri,
                menage AS m,
                see_agex AS sa,
                see_village AS sv,
                see_commune AS sc,
                see_region AS sr,
                see_ile AS si,
                zip AS z
            WHERE 
                fpri.id_village = sv.id
                AND fpri.id_menage = m.id
                AND fpri.id_agex = sa.id
                AND sc.id = sv.commune_id
                AND sr.id = sc.region_id
                AND si.id = sr.ile_id
                AND sv.id_zip = z.id
                and fpri.id = ".$id."
        ";
        return $this->db->query($sql)->result();
    }
 
}
?>