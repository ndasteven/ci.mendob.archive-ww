<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Elèves') }}
        </h2>
    </x-slot>
    <style>

.btn-spacing {
    margin-right: 10px; /* Ajoutez la marge à droite pour espacer les boutons */
    background-color: #fff;
    border-radius: 10px;

}
.checkinfo{
    background-color: #39b315;color:#fff;
    margin-top: 10px;
}
table{
    font-size: 13px;
}
.form-control{
    height:33px;
}

    </style>
    <div class="container" >
        <div class="row d-flex justify-content-end mt-4">
            <button class="btn btn-sm col-md-2 col-4 addStudent" data-bs-toggle="modal" data-bs-target="#modalStudent" wire:click='create()' style="display:none"></button>
        </div>
        <!--liste des élèves -->
        <div class="row">
                      
            <div class="container">
               
                <div class="row">
                    <div style="position: absolute">
                    @if (!empty($shareAnnee) || !empty($shareNiveau))
                     @if (!empty($shareNiveau))
                         <small> <span style="color: blue">Filter par niveau</span>: 
                             <select wire:change="changeSelect" wire:model="shareNiveau" class="border-0" style="background-color:#f3f4f6; color:red; font-weight:bold" name="" id="">
                                <option selected value="">{{ $shareNiveau }}</option>
                                @if ($shareNiveau=="6eme")
                                 <option value="2nde">2nde</option>
                                 <option value="">full</option>
                                 @else                                  
                                 <option value="6eme">6eme</option>
                                 <option value="">full</option>  
                                @endif 
                             </select>
                         </small>
                     @endif 
                     @if (!empty($shareAnnee))
                     <small> <span style="color: blue">Filter par année</span>: 
                        <select wire:change="changeSelect" wire:model="shareAnnee" class="border-0" style="background-color:#f3f4f6; color:red; font-weight:bold" name="" id="">
                           <option selected value="">{{ $shareAnnee }}</option>
                           <option value="2019">2019</option>
                           <option value="2020">2020</option>
                           <option value="2021">2021</option>
                           <option value="2022">2022</option>
                           <option value="">fulll</option>
                        </select>
                    </small>
                     @endif 
                    @endif
                    {{-- bouton radio pour afficher eleve avec fiche ou sans fiche --}}
                      <div class="form-check form-switch">
                        <input class="form-check-input" wire:click='methodechecked' wire:model="checkedFiche" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                        <label class="form-check-label" for="flexSwitchCheckDefault"><small style="margin-bottom: px">avec décision</small></label>
                      </div>
                    {{--fin bouton radio pour afficher eleve avec fiche ou sans fiche --}}
                      <div class="col-1" style="position: absolute;top:18%; left:-4px">
                        <span class="col-1" wire:loading style="margin: 0;">
                          <div class="spinner-border" role="status" style="width: 15px; height: 15px; color:#ee8712">
                          </div>
                        </span>  
                      </div>
                    </div>
                    <div class="col-md-12 col-12 mt-5">
                        <livewire:student-table :shareAnnee="$shareAnnee" :shareNiveau="$shareNiveau" :checkedFiche="$checkedFiche" /><button class="studentclick" wire:model='ide'   data-bs-toggle="modal" data-bs-target="#modalStudentInfos" wire:click="studentInfo()"   style="display:none" ></button>
                                                <button class="multipleCheck" wire:model='idsSelects' wire:click="getIdArray" data-bs-toggle="modal" data-bs-target="#multipleEdit"></button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--fin liste des élèves -->
        <!-- modal formulaire inscription-->
        @include('livewire.modal_form_students')
        <!--fin modal -->
        <!-- modal info student-->
        @include('livewire.modalStudentInfos')
        <!--fin modal -->
        <!-- modal editMultiple-->
        @include('livewire.multipleIdEdit_form')
        <!--fin modal -->

    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
           @this.on('edit', (data) => {
            @this.ide = data.rowId //ce id ce trouve dans le bouton sectionner dans le controlleur de mon powergrid "studentTable"
            
            $('.studentclick').click()
           });

          @this.on('editting',(data)=>{
            @this.idsSelects = data[0].myId; // on fait passer les id selectionner de la propriete $this->showCheckBox()->checkedValues() de la table powergrid studenTable dans le controlleur livewire StudentIndex.php
            $('.multipleCheck').click()
          })

          @this.on('addStudent', function(){
            $('.addStudent').click()
            
          })    
       
           
      
        });


     
    </script>
</div>

<script>

</script>
