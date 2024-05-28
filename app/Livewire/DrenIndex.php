<?php

namespace App\Livewire;

use App\Models\dren;
use App\Models\ecole;
use App\Models\eleve;
use App\Models\fiche;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;



class Drenindex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $code_dren, $nom_dren;
    public $search;
    public $icon;
    public $drenId;
    public $ide;
    public $creer;
    public $edit;
    public $drenInfos;
    public $nombre_eleves;
    public $nombre_fiches;
    public $nombre_ecoles;
    public $yearSelect="";
    public $niveau6eme;
    public $niveau2nde;
    public $pourcentage_garcon;
    public $pourcentage_fille;
    public $nombre_filles;
    public $nombre_garcons;
    public $nombre_seconde;
    public $nombre_sixeme;
    public $pourcentage_seconde;
    public $pourcentage_sixeme;
    public $nom_ecoles;
    public $dren;
    
    public function selectAnnee(){
        $this->yearSelect=$this->yearSelect;
        $this->drenInfo();
    }
    
    private function resetInput(){
        $this->code_dren=$this->nom_dren='';
    }
    public function create(){
        $this->creer = true;
        $this->edit = false;
        $this->resetInput();
    }
    public function close(){
        $this->edit=false;
        $this->creer=false;
        $this->resetInput();        
    }
    protected $queryString = [
        'search'=> ['except'=>''],
        'orderField'=> ['except'=>'title'],
        'oderDirection'=> ['except'=>'ASC']
         ];
    public function research(){
        $this->search = $this->search; 
    }

    public string $orderField= 'code_dren';
    public string $orderDirection = 'ASC';


    //FONCTION DE FILTRRE
    public function setOrderField(string $nom){
        if($nom === $this->orderField){
            $this->orderDirection = $this->orderDirection ==='ASC' ? 'DESC': 'ASC';
            $this->icon ='check';
        }else{
            $this->orderField = $nom;
            $this->reset('orderDirection');
            
        }
       
    }

    public function storeDren(){

        $validate = $this->validate([
            'code_dren'=>'required|min:1|',
            'nom_dren'=>'required|min:3', 
        ]);

        if(!Dren::where('code_dren', $this->code_dren)->exists() || !Dren::where('nom_dren', $this->nom_dren)->exists()){
           
            Dren::create($validate);
            session()->flash("success", "Enregistrement effectué avec succès");
            $this->resetInput();
            $this->dispatch('create')->to(FicheTable::class);
            
        }else
        {
            session()->flash('error', 'le code DREN ou le nom DREN existe déjà');
        }

    }
    public function updateDren(){
        try{
          $validate = $this->validate([
            'code_dren'=>'required|min:1|',
            'nom_dren'=>'required|min:3', 
        ]);
        $drenInfo = dren::find($this->ide);
        if($drenInfo->update($validate)){
            session()->flash("success", "Mise à jour effectué avec succès");
            $this->dispatch('update')->to(FicheTable::class);
            
        }else{
            session()->flash("error", "Erreur de mise à jour");
        }  
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                // Gestion de l'erreur de contrainte d'unicité
                session()->flash('error', 'Ce code est déjà attribué une Dren.');
                return redirect()->back()->withInput();
            } else {
                // Autre erreur de base de données
                session()->flash('error', 'Une erreur est survenue lors de la mise à jour.');
                return redirect()->back()->withInput();
            }
        }
        
    }

    public function update($id){
        $this->ide = $id;
        $this->creer = false;
        $this->edit = true;
        $drenEdit = dren::where("id", $id)->get();
        $this->nom_dren= $drenEdit[0]->nom_dren;
        $this->code_dren= $drenEdit[0]->code_dren;
    }
    public function selectDate(){
        $this->dispatch('mise_a_jour');  
    }
    public function drenInfo(){
        $dren= Dren::with('dren_ecole')->with('dren_fiche')->where('id',$this->drenId);
        $this->dren=$dren->get()[0]->code_dren;
        $this->drenInfos=$dren->get();
        $drenId=$this->drenId;
        $nombreEleves = eleve::whereHas('eleve_fiche', function($query) use ($drenId) { // recupere le nombre d'eleves dans la dren 
            $query->where('dren_id', $drenId);
        })->where('annee',"LIKE", "%".$this->yearSelect."%");

        
        $nombre_ecoles = $dren->first()->dren_ecole;
        $nombre_fiches = fiche::whereHas('fiche_dren', function($query) use ($drenId){
            $query->where('dren_id', $drenId);
        })->where('annee',"LIKE", "%".$this->yearSelect."%");
        
        $this->nombre_ecoles= $nombre_ecoles->count();
        $this->nombre_fiches= $nombre_fiches->count();
        $this->nombre_eleves= $nombreEleves->count();
        $nombre_seconde=(clone $nombreEleves)->where('classe','2nde')->count(); 
        $nombre_sixeme=(clone $nombreEleves)->where('classe','6eme')->count();
        $this->nombre_seconde=$nombre_seconde;
        $this->nombre_sixeme=$nombre_sixeme;
        
        $this->nombre_garcons=$nombre_garcons= (clone $nombreEleves)->where('genre','M')->count();// il faut cloner le query bulder de $nombreEleves pour ne pas se retrouver a faire 2 where('genre','M')et where('genre','F') pour le nombre de fille
        $this->nombre_filles=$nombre_filles= (clone $nombreEleves)->where('genre','F')->count();
        $this->niveau6eme = $nombre_sixeme;
        $this->niveau2nde = $nombre_seconde;
                
        if($this->nombre_eleves>0){
        $pourcentage_garcon=round(($nombre_garcons*100)/$this->nombre_eleves, 2);
        $pourcentage_fille=round(($nombre_filles*100)/$this->nombre_eleves, 2); 
        $pourcentage_seconde=round(($nombre_seconde*100)/$this->nombre_eleves, 2);
        $pourcentage_sixeme=round(($nombre_sixeme*100)/$this->nombre_eleves, 2);   
        }else{
            $pourcentage_garcon=0;
            $pourcentage_fille=0;
            $pourcentage_seconde=0;
            $pourcentage_sixeme=0;
        }
        
        $this->pourcentage_garcon=$pourcentage_garcon;
        $this->pourcentage_fille=$pourcentage_fille;
        $this->pourcentage_seconde=$pourcentage_seconde;
        $this->pourcentage_sixeme=$pourcentage_sixeme;

        
    }

    public function show(){

    }

    public function render()
    { 
        $mots=explode(' ', $this->search);
        $nom_ecoles= ecole::withCount([
            'ecole_eleve_A as filles_count' => function ($query) {
                $query->where('genre', 'F');
            },
            'ecole_eleve_A as garcons_count' => function ($query) {
                $query->where('genre', 'M');
            }
        ])->where('CODE_DREN',$this->dren)
        ->where(function($query) use ($mots) {
            foreach ($mots as $mot) {
                $query->where('NOMCOMPLs', 'like', '%' . $mot . '%');
            }
        })
        ->paginate(10);
        return view('livewire.dren-index', [
            'listes_ecoles' => $nom_ecoles   
        ]);
    }
}
