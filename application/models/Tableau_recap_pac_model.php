<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tableau_recap_pac_model extends CI_Model
{
    protected $table = 'tableau_recap_pac';


    public function add($tableau_recap_pac)
    {
        $this->db->set($this->_set($tableau_recap_pac))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $tableau_recap_pac)
    {
        $this->db->set($this->_set($tableau_recap_pac))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($tableau_recap_pac)
    {
        return array(            
            'besoin'       => $tableau_recap_pac['besoin'],
            'cout'  => $tableau_recap_pac['cout'],
            'duree'  => $tableau_recap_pac['duree'],      
            'id_pac'    => $tableau_recap_pac['id_pac']
        );
    }

    public function add_down($tableau_recap_pac, $id)  {
        $this->db->set($this->_set_down($tableau_recap_pac, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($tableau_recap_pac, $id)
    {
        return array(
            'besoin'       => $tableau_recap_pac['besoin'],
            'cout'  => $tableau_recap_pac['cout'],
            'duree'  => $tableau_recap_pac['duree'],      
            'id_pac'    => $tableau_recap_pac['id_pac']
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
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    } 
    public function gettableau_recap_pacbypac($id_pac)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_pac',$id_pac)
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
