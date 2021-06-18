<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activite_choisis_menage_model extends CI_Model {
    protected $table = 'activite_choisis_menage';

    public function add($data)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($data))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $data)   {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($data))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($data)  {
		// Affectation des valeurs
        return array(
            'id_theme_formation_detail'             => $data['id_theme_formation_detail'],
            'id_menage'                             => $data['id_menage']
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


    public function get_all_by_theme_formation_detail($id_theme_formation_detail, $id_village)
    {
        $sql = 
        "
            select 
                acm.id AS id,

                m.identifiant_menage AS identifiant_menage,
                m.nomchefmenage AS nomchefmenage,
                m.id AS id_menage,

                grp.nom_prenom_ml_pl AS groupe,

                tfd.id as id_theme_formation_detail,
                tfd.description as description_theme_formation_detail
            FROM
                activite_choisis_menage AS acm,
                menage AS m,
                menage_beneficiaire AS mb,
                groupe_ml_pl AS grp,
                theme_formation_detail AS tfd
            WHERE 
                acm.id_menage = m.id
                AND tfd.id = acm.id_theme_formation_detail
                and m.id = mb.id_menage
                AND m.id = grp.id_menage
                and acm.id_theme_formation_detail = ".$id_theme_formation_detail."
                and m.village_id = ".$id_village."
    
                            
        ";


        return $this->db->query($sql)->result();
    }

    public function get_all_by_theme_formation($id_theme_formation, $id_village)
    {
        $sql = 
        "
            select 
                acm.id AS id,

                m.identifiant_menage AS identifiant_menage,
                m.nomchefmenage AS nomchefmenage,
                m.id AS id_menage,

                grp.nom_prenom_ml_pl AS groupe,

                tfd.id as id_theme_formation_detail,
                tfd.description as description_theme_formation_detail
            FROM
                activite_choisis_menage AS acm,
                menage AS m,
                menage_beneficiaire AS mb,
                groupe_ml_pl AS grp,
                theme_formation_detail AS tfd,
                theme_formation AS tf
            WHERE 
                acm.id_menage = m.id
                AND tfd.id = acm.id_theme_formation_detail
                and m.id = mb.id_menage
                AND m.id = grp.id_menage
                AND tf.id = tfd.id_theme_formation
                and tf.id = ".$id_theme_formation."
                and m.village_id = ".$id_village."
    
                            
        ";


        return $this->db->query($sql)->result();
    }

    public function get_nbr_menage($id_theme_formation, $id_village)
    {
        $sql = 
        "
            select 
                COUNT(distinct(m.id)) AS nbr_menage
            FROM
                activite_choisis_menage AS acm,
                menage AS m,
                menage_beneficiaire AS mb,
                groupe_ml_pl AS grp,
                theme_formation_detail AS tfd,
                theme_formation AS tf
            WHERE 
                acm.id_menage = m.id
                AND tfd.id = acm.id_theme_formation_detail
                and m.id = mb.id_menage
                AND m.id = grp.id_menage
                AND tf.id = tfd.id_theme_formation
                and tf.id = ".$id_theme_formation."
                and m.village_id = ".$id_village."
    
                            
        ";


        return $this->db->query($sql)->result();
    }
 
}
?>