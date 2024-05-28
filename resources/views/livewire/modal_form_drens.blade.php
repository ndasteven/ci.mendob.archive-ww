<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self> 
  <style>
    .closeformUpdatedren {
      display: none;
    }
  </style>
    <div class="modal-dialog modal-fullscreen">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Enregistrer une DREN</h1>
          <button @if($creer) style="display: none" @endif @if($edit) style="display: block" wire:click="close"  @endif  class="closeformUpdatedren  btn-close"  data-bs-dismiss="modal" aria-label="Close"></button> 
          <button @if($creer) style="display: block" @endif @if($edit) style="display: none" wire:click="close"  @endif  class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>   
        </div>
        <div class="modal-body">
          <style>
            .disabled{
              opacity: 0.8;
            }
          </style>
          <!--Formulaire d'enregistrement-->
          <div class="col-md-10 mx-auto col-12">
            <!--Message alert-->
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-warning">
                    {{ session('error') }}
                </div>
            @endif
            <!--Message alert-->
            <form @if($creer)wire:submit.prevent='storeDren()' @endif @if($edit)wire:submit.prevent='updateDren()' @endif >
                <div class="row">
                <div class="col">
                    <label for="validationServer01" class="form-label">CODE DREN</label>
                    <input  class="form-control @error('code_dren') is-invalid @enderror " id="validationServer01" value="" wire:model='code_dren'  >
                    <div class="invalid-feedback">
                      Entrer un code DREN valide
                    </div>
                </div>
                <div class="col">
                    <label for="validationServer01" class="form-label">NOM DREN</label>
                    <input class="form-control @error('nom_dren') is-invalid @enderror " id="validationServer01" value="" wire:model='nom_dren'  >
                    <div class="invalid-feedback">
                      Entrer un nom de DREN valide
                    </div>
                </div>
                
            </div>           
            
            <div class="row mt-3">
              <button class="btn btn-success col-12" wire:loading.attr="disabled">
                @if($creer) Ajouter une DREN @endif @if($edit) Modifier la DREN @endif .
                <span class="" wire:loading style="margin: 0;">
                  <div class="spinner-border" role="status" style="width: 15px; height: 15px">
                  </div>
                </span>
             </button> 
            </div>
            </form>
          </div>
          
          <!--fin Formulaire d'enregistrement-->
        </div>
        <div class="modal-footer">
         
        </div>
      </div>
    </div>
  </div>
@script
<script>
  document.addEventListener('livewire:initialized', () => {
  $('.closeformUpdatedren').on('click', function(e){
      $('#exampleModal').modal('hide')  
      $('#modalDrenInfos').modal('show') 
    })
  })
</script>
@endscript