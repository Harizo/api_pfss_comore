<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Livrable_ong_encadrement_model extends CI_Model {
    protected $table = 'livrable_ong_encadrement';

    public function add($livrable_ong_encadrement)  {
        $this->db->set($this->_set($livrable_ong_encadrement))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $livrable_ong_encadrement)  {
        $this->db->set($this->_set($livrable_ong_encadrement))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($livrable_ong_encadrement) 
    {
        return array
        (
            'id_contrat_agex'     => $livrable_ong_encadrement['id_contrat_agex'],
            'id_agex'   => $livrable_ong_encadrement['id_agex'],
            'mission'=> $livrable_ong_encadrement['mission'],
            'date_edition'      => $livrable_ong_encadrement['date_edition'],
            'outil_travail'       => $livrable_ong_encadrement['outil_travail'],
            'methodologie'     => $livrable_ong_encadrement['methodologie'],
            'planning'     => $livrable_ong_encadrement['planning'],
            'id_commune'     => $livrable_ong_encadrement['id_commune']
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
    public function findAll() {
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
    public function findById($id) {		
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
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
    
    
    public function getlivrable_ong_encadrementBycommune($id_commune)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_commune", $id_commune)
                        //->order_by('numero', 'asc')
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