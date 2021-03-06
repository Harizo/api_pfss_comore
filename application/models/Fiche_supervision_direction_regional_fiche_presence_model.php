<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_direction_regional_fiche_presence_model extends CI_Model {
    protected $table = 'fiche_supervision_direction_regional_fiche_presence';

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
            'id_fsdr'                   => $data['id_fsdr'],
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
    
 
    public function findBy_id_fsdr($id_fsdr)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_fsdr", $id_fsdr)
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