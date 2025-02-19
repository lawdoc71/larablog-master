<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use App\Models\ParentCategory;

class Categories extends Component
{
    use WithPagination;

    public $isUpdateParentCategoryMode = false;
    public $pcategory_id, $pcategory_name;

    public $isUpdateCategoryMode = false;
    public $category_id, $parent = 0, $category_name;

    // number of XX per page, set below!!!
    public $pcategoriesPerPage = 5;
    public $categoriesPerPage = 5;

    protected $listeners = [
        'updateParentCategoryOrdering',
        'updateCategoryOrdering',
        'deleteParentCategoryAction',
        'deleteCategoryAction'
    ];

    public function addParentCategory(){
        $this->pcategory_id = null;
        $this->pcategory_name = null;
        $this->isUpdateParentCategoryMode = false;
        $this->showParentCategoryModalForm();
    }

    public function createParentCategory(){
        $this->validate([
            'pcategory_name'=>'required|unique:parent_categories,name'
        ],[
            'pcategory_name.required'=>'Parent category field is required.',
            'pcategory_name.unique'=>'Parent category name is already exists.'
        ]);

        /** Store new parent category */
        $pcategory = new ParentCategory();
        $pcategory->name = $this->pcategory_name;
        $saved = $pcategory->save();

        if( $saved ){
            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'New parent category has been created successfully.']);
        }else{
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function editParentCategory($id){

        $pcategory = ParentCategory::findOrFail($id);

        $this->pcategory_id = $pcategory->id;
        $this->pcategory_name = $pcategory->name;
        $this->isUpdateParentCategoryMode = true;

        $this->showParentCategoryModalForm();

    }

    public function updateParentCategory(){

        $pcategory = ParentCategory::findOrFail($this->pcategory_id);

        // validate
        $this->validate([
            'pcategory_name'=>'required|unique:parent_categories,name,'.$pcategory->id
        ],[
            'pcategory_name.required'=>'Parent category field is required.',
            'pcategory_name.unique'=>'Parent category name is taken.'
        ]);

        /** Update parent category */
        $pcategory->name = $this->pcategory_name;
        $pcategory->slug = null;

        // save
        $updated = $pcategory->save();

        if( $updated ){
            // success
            $this->hideParentCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'Parent category successfully updated.']);

        } else {
            // fail
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);

        }
    }

    public function updateParentCategoryOrdering($positions){
        // dd($positions);
        foreach($positions as $position){
            $index = $position[0];
            $new_position = $position[1];
            ParentCategory::where('id',$index)->update([
                'ordering'=>$new_position
            ]);
            $this->dispatch('showToastr',['type'=>'success','message'=>'Parent categories ordering have been updated successfully.']);
        }
    }

    public function updateCategoryOrdering($positions){
        foreach($positions as $position){
            $index = $position[0];
            $new_position = $position[1];
            Category::where('id',$index)->update([
                'ordering'=>$new_position
            ]);
            $this->dispatch('showToastr',['type'=>'success','message'=>'Categories ordering have been updated successfully.']);
        }
    }

    public function deleteCategory($id){

        $this->dispatch('deleteCategory',['id'=>$id]);

    }

    public function deleteParentCategory($id){
        $this->dispatch('deleteParentCategory',['id'=>$id]);
    }

    public function deleteParentCategoryAction($id){
        $pcategory = ParentCategory::findOrFail($id);

        //Check if this parent category as children
        if( $pcategory->children->count() > 0 ){
            foreach( $pcategory->children as $category ){
                //Release a category
                Category::where('id',$category->id)->update(['parent'=>0]);
            }
        }

        //Delete parent category
        $delete = $pcategory->delete();

        if( $delete ){
            $this->dispatch('showToastr',['type'=>'success','message'=>'Parent category has been deleted successfully.']);
        }else{
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function addCategory(){
        // dd('Show add category modal form....');
        $this->category_id = null;
        $this->parent = 0;
        $this->category_name = null;
        $this->isUpdateCategoryMode = false;
        $this->showCategoryModalForm();
    }

    public function createCategory(){
        $this->validate([
            'category_name'=>'required|unique:categories,name'
        ],[
            'category_name.required'=>'Category field is required',
            'category_name.unique'=>'Category name is already exists.'
        ]);

        /** Store new category */
        $category = new Category();
        $category->parent = $this->parent;
        $category->name = $this->category_name;
        $saved = $category->save();

        if( $saved ){
            $this->hideCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'New category has been created successfully.']);
        }else{
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function editCategory($id){
        $category = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->parent = $category->parent;
        $this->category_name = $category->name;
        $this->isUpdateCategoryMode = true;
        $this->showCategoryModalForm();
    }

    public function updateCategory(){
        $category = Category::findOrFail($this->category_id);
        $this->validate([
            'category_name'=>'required|unique:categories,name,'.$category->id
        ],[
            'category_name.required'=>'Category name field is required.',
            'category_name.unique'=>'Category name is already exists.'
        ]);

        /** Update category */
        $category->name = $this->category_name;
        $category->parent = $this->parent;
        $category->slug = null;
        $updated = $category->save();

        if( $updated ){
            $this->hideCategoryModalForm();
            $this->dispatch('showToastr',['type'=>'success','message'=>'Category has been updated successfully.']);
        }else{
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function deleteCategoryAction($id){

        $category = Category::findOrFail($id);

        //Check if this category has related post(s)
        if( $category->posts->count() > 0 ){

            $count = $category->posts->count();
            $this->dispatch('showToastr',['type'=>'error','message'=>'This category has ('.$count.') related post(s). And so, it cannot be deleted.']);

        } else {

            //Delete category
            $delete = $category->delete();

            if( $delete ){

                $this->dispatch('showToastr',['type'=>'success','message'=>'Category successfully deleted.']);

            } else {

                $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);

            }


        }


    }

    public function showParentCategoryModalForm(){
        $this->resetErrorBag();
        $this->dispatch('showParentCategoryModalForm');
    }

    public function hideParentCategoryModalForm(){
        $this->dispatch('hideParentCategoryModalForm');
        $this->isUpdateParentCategoryMode = false;
        $this->pcategory_id = $this->pcategory_name = null;
    }

    public function showCategoryModalForm(){
       $this->resetErrorBag();
       $this->dispatch('showCategoryModalForm');
    }

    public function hideCategoryModalForm(){
        $this->dispatch('hideCategoryModalForm');
        $this->isUpdateCategoryMode = false;
        $this->category_id = $this->category_name = null;
        $this->parent = 0;
    }

    public function render(){
        return view('livewire.admin.categories',[
            'pcategories'=>ParentCategory::orderBy('ordering','asc')->paginate($this->pcategoriesPerPage,['*'],'pcat_page'),
            'categories'=>Category::orderBy('ordering','asc')->paginate($this->categoriesPerPage,['*'],'cat_page')
        ]);
    }
}
