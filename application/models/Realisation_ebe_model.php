<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Realisation_ebe_model extends CI_Model {
    protected $table = 'realisation_ebe';

    public function add($realisation_ebe)  {
        $this->db->set($this->_set($realisation_ebe))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $realisation_ebe)  {
        $this->db->set($this->_set($realisation_ebe))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($realisation_ebe) 
    {
        return array
        (
            'numero'       => $realisation_ebe['numero'],
            'id_groupe_ml_pl'     => $realisation_ebe['id_groupe_ml_pl'],
            'id_contrat_consultant_ong'  => $realisation_ebe['id_contrat_consultant_ong'],
            'materiel'     => $realisation_ebe['materiel'],
            'lieu'         => $realisation_ebe['lieu'],
            'date_regroupement'=> $realisation_ebe['date_regroupement'],
            'but_regroupement' => $realisation_ebe['but_regroupement']
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
    
    
    public function getrealisation_ebeBysousprojetml_pl($id_sous_projet,$id_groupe_ml_pl)  {
        $result =  $this->db->select('realisation_ebe.*')
                        ->from($this->table)
                        ->join("contrat_consultant_ong","contrat_consultant_ong.id=realisation_ebe.id_contrat_consultant_ong")
                        ->where("id_sous_projet", $id_sous_projet)
                        ->where("id_groupe_ml_pl",$id_groupe_ml_pl) 
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