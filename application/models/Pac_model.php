<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pac_model extends CI_Model
{
    protected $table = 'pac';


    public function add($pac)
    {
        $this->db->set($this->_set($pac))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $pac)
    {
        $this->db->set($this->_set($pac))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($pac)
    {
        return array(            
            'milieu_physique'       => $pac['milieu_physique'],
            'condition_climatique'  => $pac['condition_climatique'],
            'diffi_socio_eco'  => $pac['diffi_socio_eco'],      
            'infra_pub_soc'    => $pac['infra_pub_soc'],      
            'analyse_pro'  => $pac['analyse_pro'],
            'identi_prio_arse' => $pac['identi_prio_arse'],
            'marche_loc_reg_arse'  => $pac['marche_loc_reg_arse'],
            'description_activite' => $pac['description_activite'],      
            'estimation_besoin'    => $pac['estimation_besoin'],      
            'etude_eco'  => $pac['etude_eco'],
            'structure_appui' => $pac['structure_appui'],
            'impact_env'      => $pac['impact_env'],
            'impact_sociau'  => $pac['impact_sociau'],      
            'id_ile'    => $pac['id_ile'],      
            'id_region'  => $pac['id_region'],
            'id_commune' => $pac['id_commune'],
            'id_zip'     => $pac['id_zip']
        );
    }

    public function add_down($pac, $id)  {
        $this->db->set($this->_set_down($pac, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($pac, $id)
    {
        return array(
            'milieu_physique'       => $pac['milieu_physique'],
            'condition_climatique'  => $pac['condition_climatique'],
            'diffi_socio_eco'  => $pac['diffi_socio_eco'],      
            'infra_pub_soc'    => $pac['infra_pub_soc'],      
            'analyse_pro'  => $pac['analyse_pro'],
            'identi_prio_arse' => $pac['identi_prio_arse'],
            'marche_loc_reg_arse'  => $pac['marche_loc_reg_arse'],
            'description_activite' => $pac['description_activite'],      
            'estimation_besoin'    => $pac['estimation_besoin'],      
            'etude_eco'  => $pac['etude_eco'],
            'structure_appui' => $pac['structure_appui'],
            'impact_env'      => $pac['impact_env'],
            'impact_sociau'  => $pac['impact_sociau'],      
            'id_ile'    => $pac['id_ile'],      
            'id_region'  => $pac['id_region'],
            'id_commune' => $pac['id_commune'],
            'id_zip'     => $pac['id_zip']
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
