<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tableau_de_bord_model extends CI_Model
{
    protected $table = 'tableau_de_bord';

    public function add($tdb)  {
        $this->db->set($this->_set($tdb))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $tdb)  {
        $this->db->set($this->_set($tdb))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($tdb) {
        return array(
            'type_tdb'          =>  $tdb['type_tdb'],
            'ile_id'            =>  $tdb['ile_id'],
            'vague'             =>  $tdb['vague'],
            'indicateur'        =>  $tdb['indicateur'],
            'objectif_nombre'   =>  $tdb['objectif_nombre'],
            'objectif_village'  =>  $tdb['objectif_village'],                       
            'rang'              =>  $tdb['rang'],                       
            'visible'           =>  $tdb['visible'],                       
        );
    }
    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('rang')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return array();
        }                 
    }
    public function findByTypeTDB($type_tdb) {
		$requete="select tb.*,i.Ile as ile,indic.description as indicateur"
				." from tableau_de_bord as tb"
				." left join see_ile as i on i.id=tb.ile_id"
				." left join indicateur_tdb as indic on indic.id=tb.indicateur_id"
				." where tb.type_tdb='".$type_tdb
				."' order by tb.rang";
		$result = $this->db->query($requete)->result();
        if($result) {
            return $result;
        }else{
            return array();
        }                 
    }
    public function findById($id)   {
        $result =  $this->db->select('*')
                        ->from($this->table)
						->where('id', (int) $id)
                        ->order_by('rang')
                        ->get()
                        ->result();
        if($result)  {
            return $result;
        }else{
            return array();
        }   
    }
}
