<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_depenses_model extends CI_Model
{
    protected $table = 'sous_projet_depenses';


    public function add($sous_projet_depenses)
    {
        $this->db->set($this->_set($sous_projet_depenses))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $sous_projet_depenses)
    {
        $this->db->set($this->_set($sous_projet_depenses))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($sous_projet_depenses)
    {
        return array(
            'designation' => $sous_projet_depenses['designation'],
            'montant' => $sous_projet_depenses['montant'],
            'pourcentage' => $sous_projet_depenses['pourcentage'],
            'id_sous_projet' =>      $sous_projet_depenses['id_sous_projet']                      
        );
    }

    public function add_down($sous_projet_depenses, $id)  {
        $this->db->set($this->_set_down($sous_projet_depenses, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($sous_projet_depenses, $id)
    {
        return array(
            'id' => $id,
            'designation' => $sous_projet_depenses['designation'],
            'montant' => $sous_projet_depenses['montant'],
            'pourcentage' => $sous_projet_depenses['pourcentage'],
            'id_sous_projet' =>      $sous_projet_depenses['id_sous_projet'] 
        );
    }

    public function delete($id)
    {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }


    public function findAll()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('designation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getsous_projet_depensesbysousprojet($id_sous_projet)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_sous_projet',$id_sous_projet)
                        ->order_by('designation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }

}
