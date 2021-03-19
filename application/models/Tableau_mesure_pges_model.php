<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tableau_mesure_pges_model extends CI_Model
{
    protected $table = 'tableau_mesure_pges';


    public function add($tableau_mesure_pges)
    {
        $this->db->set($this->_set($tableau_mesure_pges))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $tableau_mesure_pges)
    {
        $this->db->set($this->_set($tableau_mesure_pges))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($tableau_mesure_pges)
    {
        return array(
            'activites_sousprojets' => $tableau_mesure_pges['activites_sousprojets'],
            'mesure' => $tableau_mesure_pges['mesure'],
            'responsables' => $tableau_mesure_pges['responsables'],
            'estimation_cout' => $tableau_mesure_pges['estimation_cout'],
            'impacts' => $tableau_mesure_pges['impacts'],
            'timing' => $tableau_mesure_pges['timing'],
            'id_etude_env' =>      $tableau_mesure_pges['id_etude_env']                      
        );
    }

    public function add_down($tableau_mesure_pges, $id)  {
        $this->db->set($this->_set_down($tableau_mesure_pges, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($tableau_mesure_pges, $id)
    {
        return array(
            'activites_sousprojets' => $tableau_mesure_pges['activites_sousprojets'],
            'mesure' => $tableau_mesure_pges['mesure'],
            'responsables' => $tableau_mesure_pges['responsables'],
            'estimation_cout' => $tableau_mesure_pges['estimation_cout'],
            'impacts' => $tableau_mesure_pges['impacts'],
            'timing' => $tableau_mesure_pges['timing'],
            'id_etude_env' =>      $tableau_mesure_pges['id_etude_env']  
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
    

    public function gettableau_mesure_pgesbyetude($id_etude_env)
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
