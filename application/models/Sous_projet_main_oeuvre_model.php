<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sous_projet_main_oeuvre_model extends CI_Model
{
    protected $table = 'sous_projet_main_oeuvre';


    public function add($sous_projet_main_oeuvre)
    {
        $this->db->set($this->_set($sous_projet_main_oeuvre))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $sous_projet_main_oeuvre)
    {
        $this->db->set($this->_set($sous_projet_main_oeuvre))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($sous_projet_main_oeuvre)
    {
        return array(
            'activite'    =>      $sous_projet_main_oeuvre['activite'],
            'main_oeuvre' =>      $sous_projet_main_oeuvre['main_oeuvre'],
            'post_travail'    =>      $sous_projet_main_oeuvre['post_travail'],
            'remuneration_jour' =>      $sous_projet_main_oeuvre['remuneration_jour'],
            'nbr_jour' =>      $sous_projet_main_oeuvre['nbr_jour'],
            'remuneration_total' =>      $sous_projet_main_oeuvre['remuneration_total'],
            'id_sous_projet' =>      $sous_projet_main_oeuvre['id_sous_projet']                      
        );
    }

    public function add_down($sous_projet_main_oeuvre, $id)  {
        $this->db->set($this->_set_down($sous_projet_main_oeuvre, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($sous_projet_main_oeuvre, $id)
    {
        return array(
            'id' => $id,
            'activite'    =>      $sous_projet_main_oeuvre['activite'],
            'main_oeuvre' =>      $sous_projet_main_oeuvre['main_oeuvre'],
            'post_travail'    =>      $sous_projet_main_oeuvre['post_travail'],
            'remuneration_jour' =>      $sous_projet_main_oeuvre['remuneration_jour'],
            'nbr_jour' =>      $sous_projet_main_oeuvre['nbr_jour'],
            'remuneration_total' =>      $sous_projet_main_oeuvre['remuneration_total'],
            'id_sous_projet' =>      $sous_projet_main_oeuvre['id_sous_projet'] 
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
                        ->order_by('activite')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getsous_projet_main_oeuvrebysousprojet($id_sous_projet)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_sous_projet',$id_sous_projet)
                        ->order_by('activite')
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
