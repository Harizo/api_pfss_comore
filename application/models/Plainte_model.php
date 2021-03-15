<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plainte_model extends CI_Model {
    protected $table = 'see_plainte';

    public function add($plainte)  {
        $this->db->set($this->_set($plainte))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function add_down($plainte, $id)  {
        $this->db->set($this->_set_down($plainte, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $plainte)  {
        $this->db->set($this->_set($plainte))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($plainte) {
        return array(
            'menage_id'                 => $plainte['menage_id'],
            'activite_id'               => $plainte['activite_id'],
            'cellulederecours_id'       => $plainte['cellulederecours_id'],
            'typeplainte_id'            => $plainte['typeplainte_id'],
            'solution_id'               => $plainte['solution_id'],
            'village_id'                => $plainte['village_id'],
            'programme_id'              => $plainte['programme_id'],
            'Objet'                     => $plainte['Objet'],
            'datedepot'                 => $plainte['datedepot'],
            'reference'                 => $plainte['reference'],
            'nomplaignant'              => $plainte['nomplaignant'],
            'adresseplaignant'          => $plainte['adresseplaignant'],
            'responsableenregistrement' => $plainte['responsableenregistrement'],
            'mesureprise'               => $plainte['mesureprise'],
            'dateresolution'            => $plainte['dateresolution'],
            'statut'                    => $plainte['statut'],
            'a_ete_modifie'             => $plainte['a_ete_modifie'],
            'supprime'                  => $plainte['supprime'],
            'userid'                    => $plainte['userid'],
            'datemodification'          => $plainte['datemodification'],
        );
    }

    public function _set_down($plainte, $id) {
        return array(
            'id'                        => $id,
            'menage_id'                 => $plainte['menage_id'],
            'activite_id'               => $plainte['activite_id'],
            'cellulederecours_id'       => $plainte['cellulederecours_id'],
            'typeplainte_id'            => $plainte['typeplainte_id'],
            'solution_id'               => $plainte['solution_id'],
            'village_id'                => $plainte['village_id'],
            'programme_id'              => $plainte['programme_id'],
            'Objet'                     => $plainte['Objet'],
            'datedepot'                 => $plainte['Objet'],
            'reference'                 => $plainte['reference'],
            'nomplaignant'              => $plainte['nomplaignant'],
            'adresseplaignant'          => $plainte['adresseplaignant'],
            'responsableenregistrement' => $plainte['responsableenregistrement'],
            'mesureprise'               => $plainte['mesureprise'],
            'dateresolution'            => $plainte['dateresolution'],
            'statut'                    => $plainte['statut'],
            'a_ete_modifie'             => $plainte['a_ete_modifie'],
            'supprime'                  => $plainte['supprime'],
            'userid'                    => $plainte['userid'],
            'datemodification'          => $plainte['datemodification'],
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
                        ->order_by('datedepot')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findById($id) {
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
    public function findByVillage($village_id) {
		$requete = "select v.Village as village,cp.Code as code,tp.TypePlainte as type_plainte,rp.libelle as resultat_plainte,"
					."p.id,p.village_id,p.cellulederecours_id,p.typeplainte_id,p.solution_id,p.Objet,p.datedepot,p.reference,"
					."p.nomplaignant,p.adresseplaignant,p.dateresolution"
					." from see_plainte as p"
					." left outer join see_village as v on v.id=p.village_id"
					." left outer join see_celluleprotectionsociale as cp on cp.id=p.cellulederecours_id"
					." left outer join see_typeplainte as tp on tp.id=p.typeplainte_id"
					." left outer join resultat_plainte as rp on tp.id=p.solution_id"
					." where p.village_id=".$village_id;
		$query = $this->db->query($requete);
        return $query->result();                 
    }
}
?>