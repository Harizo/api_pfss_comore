<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tableau_impacts_model extends CI_Model
{
    protected $table = 'tableau_impacts';


    public function add($tableau_impacts)
    {
        $this->db->set($this->_set($tableau_impacts))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $tableau_impacts)
    {
        $this->db->set($this->_set($tableau_impacts))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($tableau_impacts)
    {
        return array(
            'sources_sousprojets' => $tableau_impacts['sources_sousprojets'],
            'localisation' => $tableau_impacts['localisation'],
            'nature_recepteur' => $tableau_impacts['nature_recepteur'],
            'composante_recepteur' => $tableau_impacts['composante_recepteur'],
            'impacts' => $tableau_impacts['impacts'],
            'nature_impact' => $tableau_impacts['nature_impact'],
            'degre_impact' => $tableau_impacts['degre_impact'],
            'effet_impact' => $tableau_impacts['effet_impact'],
            'id_etude_env' =>      $tableau_impacts['id_etude_env']                      
        );
    }

    public function add_down($tableau_impacts, $id)  {
        $this->db->set($this->_set_down($tableau_impacts, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($tableau_impacts, $id)
    {
        return array(
            'sources_sousprojets' => $tableau_impacts['sources_sousprojets'],
            'localisation' => $tableau_impacts['localisation'],
            'nature_recepteur' => $tableau_impacts['nature_recepteur'],
            'composante_recepteur' => $tableau_impacts['composante_recepteur'],
            'impacts' => $tableau_impacts['impacts'],
            'nature_impact' => $tableau_impacts['nature_impact'],
            'degre_impact' => $tableau_impacts['degre_impact'],
            'effet_impact' => $tableau_impacts['effet_impact'],
            'id_etude_env' =>      $tableau_impacts['id_etude_env']  
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
                        ->order_by('id_etude_env')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    

    public function gettableau_impactsbyetude($id_etude_env)
    {
        $result =  $this->db->select("*")
                        ->from($this->table)
                        ->where('id_etude_env',$id_etude_env)
                        ->order_by('id_etude_env')
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
