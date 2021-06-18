<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fiche_supervision_direction_regional_personne_organisation_ong_model extends CI_Model {
    protected $table = 'fiche_supervision_direction_regional_personne_organisation_ong';

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
            'id_fsdr'                            => $data['id_fsdr'],
            'planning'                           => $data['planning'],
            'date_debut_previsionnele'           => $data['date_debut_previsionnele'],
            'date_fin_previsionnele'             => $data['date_fin_previsionnele']
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