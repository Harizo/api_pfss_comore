<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_consultant_ong_model extends CI_Model {
    protected $table = 'contrat_consultant_ong';

    public function add($contrat)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($contrat))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $contrat)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($contrat))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat) {
		// Affectation des valeurs
        return array(
            'id_consultant' =>  $contrat['id_consultant'],
            'id_sous_projet' =>  $contrat['id_sous_projet'],
            'reference'  =>  $contrat['reference'],                       
            'date_contrat'    =>  $contrat['date_contrat'],                       
            'objet'    =>  $contrat['objet'],                       
         );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1) {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
 		$requete="select ct.id,ct.id_consultant,ct.id_sous_projet, ct.reference,sp.description as sous_projet,ct.date_contrat,ct.objet,"
		."co.raison_social as consultant"
		." from contrat_consultant_ong as ct"
		." left outer join sous_projet as sp on sp.id=ct.id_sous_projet"
		." left outer join consultant_ong as co on co.id=ct.id_consultant"
		." order by ct.id";
		$query= $this->db->query($requete);		
		if($query->result()) {
			return $query->result();
        }else{
            return null;
        }  
   }
   public function getcontratbysousprojet($id_sous_projet) {
        $requete="
        select contrat.id as id,
                contrat.id_consultant as id_consultant_ong,
                contrat.id_sous_projet as id_sous_projet,
                contrat.reference as reference,
                sp.description as description_sp,
                contrat.date_contrat as date_contrat,
                contrat.objet as objet,
                consultant.nom_consultant as nom_consultant
        from contrat_consultant_ong as contrat
            left outer join sous_projet as sp on sp.id=contrat.id_sous_projet
            left outer join consultant_ong as consultant on consultant.id=contrat.id_consultant
            where sp.id='".$id_sous_projet."'
        order by contrat.id";
       $query= $this->db->query($requete);		
       if($query->result()) {
           return $query->result();
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
   public function findByIdAfaa($id_contrat) {
        $requete="
        select contrat.id as id,
                contrat.id_consultant as id_consultant_ong,
                contrat.id_sous_projet as id_sous_projet,
                contrat.reference as reference,
                sp.description as description_sp,
                contrat.date_contrat as date_contrat,
                contrat.objet as objet,
                consultant.nom_consultant as nom_consultant
        from contrat_consultant_ong as contrat
            left outer join sous_projet as sp on sp.id=contrat.id_sous_projet
            left outer join consultant_ong as consultant on consultant.id=contrat.id_consultant
            where contrat.id='".$id_contrat."'
        order by contrat.id";
        return $this->db->query($requete)->result(); 
  }
    public function findByIdwithcle($id) {
		// Selection par id
        $this->db->select('contrat_consultant_ong.id as id,
                            contrat_consultant_ong.id_consultant as id_consultant_ong,
                            contrat_consultant_ong.id_sous_projet as id_sous_projet,
                            contrat_consultant_ong.reference as reference,
                            sous_projet.description as description_sp,
                            contrat_consultant_ong.date_contrat as date_contrat,
                            contrat_consultant_ong.objet as objet,
                            consultant_ong.nom_consultant as nom_consultant')
                    //->from('contrat_consultant_ong')
                    ->join("sous_projet", "sous_projet.id=contrat_consultant_ong.id_sous_projet")
                    ->join("consultant_ong", "consultant_ong.id=contrat_consultant_ong.id_consultant")
                    ->where("contrat_consultant_ong.id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }
}
?>