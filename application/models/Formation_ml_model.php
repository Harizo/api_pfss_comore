<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Formation_ml_model extends CI_Model {
    protected $table = 'formation_ml';

    public function add($formation_ml)  {
        $this->db->set($this->_set($formation_ml))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $formation_ml)  {
        $this->db->set($this->_set($formation_ml))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($formation_ml) 
    {
        return array
        (
            'numero'           => $formation_ml['numero'],
            'id_commune'      => $formation_ml['id_commune'],
            'id_contrat_consultant_ong'  => $formation_ml['id_contrat_consultant_ong'],
            'description'     => $formation_ml['description'],
            'lieu'            => $formation_ml['lieu'],
            'date_debut'      => $formation_ml['date_debut'],
            'date_fin'        => $formation_ml['date_fin']
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
    
    
    public function getformation_mlBysousprojetcommune($id_sous_projet,$id_commune)  {
        $result =  $this->db->select('formation_ml.*')
                        ->from($this->table)
                        ->join("contrat_consultant_ong","contrat_consultant_ong.id=formation_ml.id_contrat_consultant_ong")
                        ->where("id_sous_projet", $id_sous_projet)
                        ->where("id_commune",$id_commune) 
                        ->order_by('contrat_consultant_ong.id', 'asc')
                        ->order_by('numero', 'asc')
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