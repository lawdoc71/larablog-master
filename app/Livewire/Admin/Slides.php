<?php

namespace App\Livewire\Admin;

use App\Models\Slide;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class Slides extends Component
{
    use WithFileUploads;

    public $isUpdateSlideMode = false;
    public $slide_id, $slide_heading, $slide_link, $slide_image, $slide_status = true;
    public $selected_slide_image = null;

    protected $listeners = [

        'updateSlidesOrdering',
        'deleteSlideAction'

    ];

    public function updatedSlideImage(){

        if( $this->slide_image ){
            $this->selected_slide_image = $this->slide_image->temporaryUrl();
        }
    }

    public function addSlide(){
        // dd('Open Add Slide Form Modal');
        $this->slide_id = null;
        $this->slide_heading = null;
        $this->slide_link = null;
        $this->slide_image = null;
        $this->slide_status = true;
        $this->isUpdateSlideMode = false;
        $this->selected_slide_image = null;
        $this->showSlideModalForm();
    }

    public function showSlideModalForm(){

        $this->resetErrorBag();
        $this->dispatch('showSlideModalForm');

    }

    public function hideSlideModalForm(){

        $this->dispatch('hideSlideModalForm');
        $this->isUpdateSlideMode = false;
        $this->slide_id = $this->slide_heading = $this->slide_link = $this->slide_image = null;
        $this->slide_status = true;

    }

    public function createSlide(){

        //Validate the form
        $this->validate([
            'slide_heading'=>'required',
            'slide_link'=>'nullable|url',
            'slide_image'=>'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        // dd('Create a slide now!');
        $path = "slides/";
        $file = $this->slide_image;
        $filename = 'SLD_'.date('YmdHis',time()).'.'.$file->getClientOriginalExtension();

        // Upload Slide Image
        $upload = $file->storeAs($path, $filename, 'slides_uploads');

        if( !$upload ){

            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong while uploading slide image.']);

        } else {
            /** Store new slide */
            $slide = new Slide();
            $slide->image = $filename;
            $slide->heading = $this->slide_heading;
            $slide->link = $this->slide_link;
            $slide->status = $this->slide_status == true ? 1 : 0;
            $saved = $slide->save();

            if( $saved ){
                $this->hideSlideModalForm();
                $this->dispatch('showToastr',['type'=>'success','message'=>'New Slide successfully added to database.']);
            }else{
                $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong while saving slide details.']);
            }
        }
    }

    // edit - when pencil icon clicked on dashboard table
    public function editSlide($id){

        $slide = Slide::findOrFail($id);

        $this->slide_id = $slide->id;
        $this->slide_heading = $slide->heading;
        $this->slide_link = $slide->link;
        $this->slide_status = $slide->status == 1 ? true : false;
        $this->slide_image = null;
        $this->selected_slide_image = '/images/slides/'.$slide->image;
        $this->isUpdateSlideMode = true;

        $this->showSlideModalForm();
    }

    public function updateSlide(){

        $slide = Slide::findOrFail($this->slide_id);

        // Validate the form
        $this->validate([

            'slide_heading'=>'required',
            'slide_link'=>'nullable|url',
            'slide_image'=>'nullable|mimes:png,jpg,jpeg|max:2048'

        ]);

        $slide_image_name = $slide->image;

        //If Form has Image File
        if( $this->slide_image ){

            $path = 'slides/';
            $file = $this->slide_image;
            $filename = 'SLD_'.date('YmdHis',time()).'.'.$file->getClientOriginalExtension();

            //Upload new Slide image
            $upload = $file->storeAs($path, $filename, 'slides_uploads');

            if( !$upload ){

                $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong while uploading slide image.']);

            } else {

                //Delete Old Slide Image
                $slide_path = 'images/'.$path;

                $old_slide_image = $slide->image;

                if( $old_slide_image != '' && File::exists(public_path($slide_path.$old_slide_image)) ){
                    File::delete(public_path($slide_path.$old_slide_image));
                }

                $slide_image_name = $filename;
            }
        }

        //UPDATE SLIDE INFO
        $slide->image = $slide_image_name;
        $slide->heading = $this->slide_heading;
        $slide->link = $this->slide_link;
        $slide->status = $this->slide_status == true ? 1 : 0;
        $saved = $slide->save();

        if( $saved ){

            $this->hideSlideModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'Slide successfully updated.']);

        } else {

            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong while updating slide info.']);

        }
    }

    public function updateSlidesOrdering($positions){
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            Slide::where("id",$index)->update([
                "ordering"=>$newPosition
            ]);
            $this->dispatch("showToastr",["type"=>"success","message"=>"Slides ordering successfully updated."]);
        }
    }

    public function deleteSlideAction($id){
        $slide = Slide::findOrFail($id);
        $path = "slides/";
        $slide_path = "images/".$path;
        $slide_image = $slide->image;

        if( $slide_image != '' && File::exists(public_path($slide_path.$slide_image)) ){
            File::delete(public_path($slide_path.$slide_image));
        }

        $delete = $slide->delete();

        if( $delete ){
            $this->dispatch('showToastr',['type'=>'success','message'=>'Slide successfully deleted.']);
        }else{
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong while deleting slide info.']);
        }
    }

    public function render(){
        return view('livewire.admin.slides',[

            'slides'=>Slide::orderBy('ordering','asc')->get()

        ]);
    }
}
