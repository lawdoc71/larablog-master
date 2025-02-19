<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Page;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Pages extends Component
{
    use WithPagination;

    public $perPage = 4;

    protected $listeners = [
        'updatePagesOrdering',
        'deletePageAction'
    ];

   public function updatePagesOrdering($positions){
    foreach($positions as $position){
        $index = $position[0];
        $newPosition = $position[1];
        Page::where("id",$index)->update([
            "ordering"=>$newPosition
        ]);
        $this->dispatch('initializeSwitchery');
        $this->dispatch("showToastr",["type"=>"success","message"=>"Pages ordering have been updated successfully."]);
    }
   }
   public function deletePageAction($id){
    $page = Page::findOrFail($id);

    $delete = $page->delete();

    if( $delete ){
        $this->dispatch('showToastr',['type'=>'success','message'=>'Page has been deleted successfully.']);
    }else{
        $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong while deleting page info.']);
    }
   }

   public function updateVisibility($location, $id){
    $page = Page::findOrFail($id);
    $column = $location == 'header' ? 'show_on_header' : 'show_on_footer';

    $page->$column = !$page->$column;
    $update = $page->save();

    if( $update ){
        $this->dispatch('showToastr',['type'=>'success','message'=>'Page visibility has been successfully updated.']);
    }else{
        $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
    }

    // $currentStatus = $movie->visibility;
    // $new_value = $currentStatus == 1 ? 0 : 1;
    // $movie->visibility = $new_value;
    // $movie->save();

    // $mode  = $new_value == 1 ? 'Public' : 'Private';
    // $mtype = $new_value == 1 ? 'success' : 'warning';
    // $msg   = $movie->title.' set in <b>'.$mode.'</b> mode';

    // $this->dispatch('showAlert',[
    //     'type'=>$mtype,
    //     'message'=>$msg
    // ]);

    // $db = !$fs; // invers


}

    public function render()
    {
        return view('livewire.admin.pages',[
            'pages'=>Page::orderBy('ordering','asc')->paginate($this->perPage)
        ]);
    }
}
