<div  class="modal fade" id="modalDrenInfos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
  <style>
    .pie-chart {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: conic-gradient(
            rgb(238, 70, 98) 0% var(--percentage-female),
            rgb(11, 165, 216) var(--percentage-female) 100%
        );
        position: relative;
        margin: 20px auto;
    }
    .label {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        font-size: 1.2em;
        color: #fff;
    }
</style>
  <div class="modal-dialog modal-fullscreen">
        <div class="modal-content" style="background-color: #f4f7f7">
          <div class="modal-header shadow-2xl" style="background-color: #fff">
            <h1 class="modal-title titre fs-5" id="exampleModalLabel">INFORMATIONS SUR LA DREN</h1>
            <button  class="btn-close" wire:click='' data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          @if ($drenInfos)
          @foreach ($drenInfos as $drenInfo)
           <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <div class="card shadow-xl">
                  <div class="card-body" style="background-color: rgb(204, 109, 21)">
                      <div class="row">
                          <div class="col-md-4 mx-auto">
                              <h1 style="text-align:center; font-weight:bold; font-size:22px; color:#fff"> DREN </h1>
                              <img src="asset/img/logoDOB.jpeg" alt="" width="100%" height="auto" />
                              <br>
                          </div>
                          <table class="table table-striped">
                            <tr>
                                <td style="text-align: left"><span style="color: black; font-weight:bold">Nom de la dren </span>: </td>
                                <td style=""><span style="color: ; font-weight:bold"> {{ $drenInfo->nom_dren }} </span></td>
                            </tr>
                            <tr>
                              <td style="text-align: left"><span style="color: black; font-weight:bold">Code de la dren </span>: </td>
                              <td style=""><span style="color: ; font-weight:bold"> {{ $drenInfo->code_dren }} </span></td>
                            </tr>
                            @if (Auth::check() && Auth::user()->role === 'superAdmin' || Auth::user()->role === 'admin')
                                        <tr>
                                            <td style="text-align: left"><span style="color: black; font-weight:bold">Modifier la dren</span>: </td>
                                            <td style="">
                                                <span style="color: ; font-weight:bold">
                                                 <button class="btn btn-warning btn-sm test_click" data-bs-toggle="modal" data-bs-target="#exampleModal" wire:click="update({{$drenInfo->id}})">Modifier la DREN</button>
                                                </span></td>
                                        </tr>
                            @endif
                          </table>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="card shadow-xl border-0">
                  <div class="card-body">
                      <div class="row" style="margin-bottom: 20px">
                        <div class="d-flex justify-content-end">
                          <div class="col-2" style="position: relative">
                           <select style="background-color: #f8930f; color:#fff" wire:model='yearSelect' wire:change="selectAnnee" class="form-select form-select-sm  col-1" aria-label="Small select example">
                              <option selected value="">Tous les années</option>
                              <option value="2019">2019</option>
                              <option value="2020">2020</option>
                              <option value="2021">2021</option>
                              <option value="2022">2022</option>
                              <option value="2023">2023</option>
                              <option value="2024">2024</option>
                              <option value="2025">2025</option> 
                          </select>
                          <div class="col-1" style="position: absolute;top:18%; right:5px">
                            <span class="col-1" wire:loading style="margin: 0;">
                              <div class="spinner-border" role="status" style="width: 15px; height: 15px; color:#fff">
                              </div>
                            </span>  
                          </div> 
                          </div>
                          
                        </div>                          
                      </div>
                    <div class="row">
                     <div class="col">
                      <div class="card shadow-xl" style="background: linear-gradient(135deg, rgba(231, 224, 224, 0.8), rgba(253, 252, 250, 0.5)); border: none; color: white;">
                        <div class="card-body" style="color:black; text-align:center">
                          <div>NOMBRE ECOLES</div>
                          <div>
                            <h3 style="font-weight: bold">{{ $nombre_ecoles }}</h3>
                          </div>
                        </div>
                      </div>
                     </div>

                     <div class="col">
                      <div class="card shadow-xl" style="background: linear-gradient(135deg, rgba(231, 224, 224, 0.8), rgba(253, 252, 250, 0.5)); border: none; color: white;">
                        <div class="card-body" style="color:black; text-align:center">
                          <div>NOMBRE FICHES</div>
                          <div>
                            <h3 style="font-weight: bold">{{ $nombre_fiches }}</h3>
                          </div>
                        </div>
                      </div>
                     </div>

                     <div class="col">
                      <div class="card shadow-xl" style="background: linear-gradient(135deg, rgba(231, 224, 224, 0.8), rgba(253, 252, 250, 0.5)); border: none; color: white;">
                        <div class="card-body" style="color:black; text-align:center">
                          <div>NOMBRE ELEVES</div>
                          <div>
                            <h3 style="font-weight: bold">{{ $nombre_eleves }}</h3>
                          </div>
                        </div>
                      </div>
                     </div>
                    </div>
                    <div class="row d-flex justify-content-between">
                      <div class="pie-chart col-3" style="--percentage-female: {{ $pourcentage_fille }}%;">
                        <div class="label">{{ $pourcentage_fille }}%<br>Filles <br> {{ $nombre_filles }} </div>
                      </div>
                      <div class="pie-chart col-3" style="--percentage-female: {{ $pourcentage_garcon }}%;">
                        <div class="label">{{ $pourcentage_garcon }}%<br>Garçons <br> {{ $nombre_garcons }}</div>
                      </div>
                    </div>

                    <div class="row" style="text-align: center">
                      <h3 style='font-size:17px'>Nombre d'élèves par niveau</h3>
                      <div class="row">
                       <div class="col" >seconde</div>
                        <div class="col-8 mt-1" >
                          <div class="progress " role="progressbar" aria-label="Success example" aria-valuenow="{{ $pourcentage_seconde }}" aria-valuemin="0" aria-valuemax="100">
                           <div class="progress-bar bg-success" style="width: {{ $pourcentage_seconde }}%">{{ $pourcentage_seconde }}%</div>
                          </div>
                        </div> 
                        <div class="col">{{ $nombre_seconde }}</div>  
                      </div>

                      <div class="row mt-2 d-flex justify-content-between">
                        <div class="col" >sixeme</div>
                         <div class="col-8 mt-1" >
                           <div class="progress " role="progressbar" aria-label="Success example" aria-valuenow="{{ $pourcentage_sixeme }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-danger" style="width: {{ $pourcentage_sixeme }}%">{{ $pourcentage_sixeme }}%</div>
                           </div>
                         </div> 
                         <div class="col">{{ $nombre_sixeme }}</div>  
                       </div>
                     
                    </div>

                    <div class="row mt-4">
                      <div class="col-12 mx-auto">
                        <div class="card shadow-lg border-0 overflow-x-scroll">
                          <div class="card-body">
                            <table class="table">
                              <div class="row">
                                <div class="col-5 overflow-x-scroll">{{ $listes_ecoles->links()}}</div>
                                <div class="col-7" style="position: relative">
                                  <input wire:model="search" wire:keydown.debounce.900ms="research" class="form-control form-control-sm" type="text" placeholder="Recherche ecole" aria-label=".form-control-sm example">
                                  <span class="col-1" wire:loading style="margin: 0; position: absolute; right:2px; top:10%" >
                                    <div class="spinner-border" role="status" style="width: 15px; height: 15px; color:#eb250b">
                                    </div>
                                  </span>
                                </div>
                              </div>
                              <thead>
                                <tr>
                                  
                                  <th scope="col">Nom établissements</th>
                                  <th scope="col"><i class="bi bi-person-standing" style="color: rgb(11, 165, 216)"></i>Nombre Garçons</th>
                                  <th scope="col"><i class="bi bi-person-standing-dress" style="color: rgb(238, 70, 98)"></i>Nombre Filles</th>
                                  <th scope="col"><i class="bi bi-people-fill" style="color: rgb(209, 10, 43)"></i>Totals</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if (count($listes_ecoles)>0)
                                  @foreach ($listes_ecoles as $item)
                                  <tr>
                                    <td>{{ $item->NOMCOMPLs }}</td>
                                    <td>{{ $item->garcons_count }}</td>
                                    <td>{{ $item->filles_count }}</td>
                                    <td>{{ count($item->ecole_eleve_A) }}</td>
                                  </tr> 
                                  @endforeach  
                                @endif 
                              </tbody>
                          
                            </table>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           </div>
           @endforeach
           @endif
        </div>
    </div>
    @include('livewire.loading')
</div>

@include('livewire.modal_form_drens')