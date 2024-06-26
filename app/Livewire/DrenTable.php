<?php

namespace App\Livewire;

use App\Models\dren;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class drenTable extends PowerGridComponent
{
    use WithExport;
    public int $perPage = 5;
    public array $perPageValues = [1, 5, 10, 20, 50];
    #[\Livewire\Attributes\On('update')] //lors d'une mise a jour il ecoute le dispatch update qui lui a ete transferer par le comtrolleur drenindex.php et met a jout datatable powergrid
    #[\Livewire\Attributes\On('create')] //lors d'une mise a jour il ecoute le dispatch create qui lui a ete transferer par le comtrolleur drenindex.php et met a jout datatable powergrid
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            /*Exportable::make('export')
                ->striped(),
             ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),*/
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return dren::query()->orderBy('nom_dren', 'asc');
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('nom_dren')
            ->addColumn('code_dren')
            

           /** Example of custom column using a closure **/
            ->addColumn('nom_dren_lower', fn (dren $model) => strtolower(e($model->nom_dren)));

           //->addColumn('created_at', fn (dren $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            //Column::make('Id', 'id'),
            Column::make('Nom dren', 'nom_dren')
                ->sortable()
                ->searchable(),

            Column::make('Code dren', 'code_dren')
                ->sortable()
                ->searchable(),
           
               
            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    /*
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }
    */
    //permet de afficher le voir boutton voir+ dans le drentable
    public function actions(\App\Models\dren $row): array
    {
        return [
            Button::add('edit')
                ->slot('voir +')
                ->id()
                ->class('btn btn-sm  checkinfo')
                ->dispatch('edit', ['rowId' => $row->id]),
        ];
    }

    

    

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
    public function header(): array
    
    {
    if (Auth::check() && Auth::user()->role === 'superAdmin' || Auth::user()->role === 'admin'){
    return [
        Button::add()
        ->slot('Ajouter une Dren')
        ->id()
        ->class('btn btn-sm  checkinfo')
        ->dispatch('addDren',[])
    ];    
    }else{
        return[];
    }
}
}
