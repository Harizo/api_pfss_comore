<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formation_tech_base_menage_fiche_presence_model extends CI_Model {
    protected $table = 'formation_tech_base_menage_fiche_presence';

    public function add($data)  {
        $this->db->set($this->_set($data))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $data)  {
        $this->db->set($this->_set($data))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($data) 
    {
        return array
        (
            'id_ftbm'                   => $data['id_ftbm'],
            'nom_prenom'                => $data['nom_prenom'],
            'adresse'                   => $data['adresse']
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
    
 
    public function findBy_id_ftbm($id_ftbm)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_ftbm", $id_ftbm)
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