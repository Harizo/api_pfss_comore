<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requete_import_model extends CI_Model {
    protected $table = 'contrat_consultant_ong';

    public function Execution_requete($requete) {
		// expression (chaine de caracteres)requete libre de mise a jour : update table set x=a,y=b,z=c where d=1 and e=? etc
 		$query= $this->db->query($requete);		
			return "OK";
   }
    public function Requete_insertion($requete) {
		// requete insertion suivant le syntaxe insert into table (x,y,z) values ((x1,y1,z1),(x2,y2,z2),(x3,y3,z3),...)
 		$query= $this->db->query($requete);		
			return $this->db->insert_id();
   }
    public function Requete_datefin_date_paiement($requete) {
		// requete vérification date de paiementde l'activite ACT : tester si date paiement > date du jour (illogique) ET 
		// si date paiement < date fin fiche de présence à importer aussi (illogique) => impérativement entre les 2
 		$query= $this->db->query($requete);		
			return $this->db->insert_id();
   }
}
?>