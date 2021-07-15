<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activite_choisis_menage_sous_activite_model extends CI_Model {
    protected $table = 'activite_choisis_menage_sous_activite';

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


    public function get_all_by_menage($id_theme_formation_detail, $id_menage)
    {
        $sql = 
        "
            select 
                acmsa.id AS id,
                tfd.id AS id_theme_formation_detail,
                tfd.description AS description_theme_formation_detail,

                m.id AS id_menage
            FROM
                activite_choisis_menage_sous_activite AS acmsa,
                menage AS m,
                theme_formation_detail AS tfd,
                theme_formation AS tf
            WHERE
                acmsa.id_menage = m.id
                AND acmsa.id_theme_formation_detail = tfd.id
                AND tfd.id_theme_formation = tf.id
                AND tf.id = ".$id_theme_formation_detail."
                AND m.id = ".$id_menage."
                            
        ";


        return $this->db->query($sql)->result();
    }

 


 
}
?>