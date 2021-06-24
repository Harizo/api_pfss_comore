<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_direction_regional_model extends CI_Model {
    protected $table = 'fiche_supervision_direction_regional';

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
            'id_village'                      => $fiche_pres['id_village'],
            'date'                            => $fiche_pres['date'],                   
            'id_agex'                         => $fiche_pres['id_agex'],                         
            'nom_direction_regional'          => $fiche_pres['nom_direction_regional']
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
                
                fpri.date,
                fpri.nom_direction_regional AS nom_direction_regional,
                
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
                
   
                
                sa.id as id_agex,
                sa.Nom AS nom_agex
                
            FROM
                fiche_supervision_direction_regional AS fpri,
            
                see_agex AS sa,
                see_village AS sv,
                see_commune AS sc,
                see_region AS sr,
                see_ile AS si,
                zip AS z
            WHERE 
                fpri.id_village = sv.id
            
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