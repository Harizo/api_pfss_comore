<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formation_tech_base_menage_model extends CI_Model {
    protected $table = 'formation_tech_base_menage';

    public function add($formation_tech_base_menage)  {
        $this->db->set($this->_set($formation_tech_base_menage))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $formation_tech_base_menage)  {
        $this->db->set($this->_set($formation_tech_base_menage))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($formation_tech_base_menage) 
    {
        return array
        (
            'id_theme_formation_detail'             => $formation_tech_base_menage['id_theme_formation_detail'],
            'id_village'                            => $formation_tech_base_menage['id_village'],
            'date'                                  => $formation_tech_base_menage['date'],
            'contenu'                               => $formation_tech_base_menage['contenu'],
            'objectifs'                             => $formation_tech_base_menage['objectifs'],
            'methodologies'                         => $formation_tech_base_menage['methodologies'],
            'materiel'                              => $formation_tech_base_menage['materiel'],
            'duree'                                 => $formation_tech_base_menage['duree']
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
    public function findBy_theme_and_village($id_village ,$id_theme_formation) 
    {
        $sql = 
        "
            select
                ftbm.id AS id,
	
                tf.id AS id_theme_formation,
                tf.description AS description_theme_formation,
                
                ftbm.id_theme_formation_detail AS id_theme_formation_detail,
                tfd.description AS description_theme_formation_detail,

                ftbm.id_village,
                sv.Village ,
                
                sc.id AS id_commune,
                sc.Commune,
                
                sr.id AS id_region,
                sr.Region,
                
                si.id AS id_ile,
                si.Ile,
                
                
                
                ftbm.date,
                ftbm.contenu,
                ftbm.objectifs,
                ftbm.methodologies,
                ftbm.materiel,
                ftbm.duree
            FROM
                formation_tech_base_menage AS ftbm,
                see_village AS sv,
                see_commune AS sc,
                see_region AS sr,
                see_ile AS si,
                theme_formation AS tf,
                theme_formation_detail AS tfd
            WHERE 
                ftbm.id_theme_formation_detail = tfd.id
                AND ftbm.id_village = sv.id
                AND sv.commune_id = sc.id
                AND sc.region_id = sr.id
                AND sr.ile_id = si.id 
                AND tfd.id_theme_formation = tf.id
                AND sv.id = ".$id_village."
                AND tf.id = ".$id_theme_formation."
        ";
        $res = $this->db->query($sql)->result();     
        if ($res) 
            return $res ;      
        else 
            return array();
        
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
    public function findByIdArray($id)  {
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

    public function get_mdp_en_retard()
    {


        $now_date = date("Y-m-d") ;

       // $array = array('date_prevu_fin_contrat >=' => $now_date, 'date_prevu_fin_contrat <=' => $now_date);

        $sql = 
        "
            select niv1.numero_contrat,
                niv1.date_prevu_fin_contrat 
            from
            (
            select 
                            
                cua.numero_contrat,
                cua.date_prevu_fin_contrat
            FROM 
                formation_tech_base_menage as cua
            WHERE 
                cua.date_prevu_fin_contrat < NOW()
                and cua.status_contrat = 'En cours'
                and (
                            select 
                                count(id) 
                            from 
                                formation_tech_base_menage_avenant  
                            where 
                                id_formation_tech_base_menage = cua.id 
                                and not type = 'Financier' 
                        ) = 0 
                        
            UNION

            select 
                    
                cua.numero_contrat,
                cuav.date_prevu_fin_contrat
            FROM 
                formation_tech_base_menage as cua,
                 formation_tech_base_menage_avenant AS cuav
            WHERE
                cua.id = cuav.id_formation_tech_base_menage
                AND cuav.date_prevu_fin_contrat < NOW()
                AND cuav.date_prevu_fin_contrat = (select MAX(date_prevu_fin_contrat) FROM formation_tech_base_menage_avenant WHERE id_formation_tech_base_menage = cua.id)
                and cuav.status_contrat = 'En cours'
                AND not cuav.`type` = 'Financier'
                
            ) AS niv1

                
        ";
        return $this->db->query($sql)->result(); 
    }
    
    public function findById_sous_projet($id_sous_projet)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_sous_projet", $id_sous_projet)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function findByIdobjet($id) {		
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
    
    public function findById_agex($id) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_agex", $id)
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