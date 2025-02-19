<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function addPage(Request $request){

        $data = [
            'pageTitle'=>'Add new page',
        ];

        return view('back.pages.add_page',$data);
    }

    public function createPage(Request $request){

        //Validate The Form
        $request->validate([
            'title'=>'required|unique:pages,title',
            'content'=>'required',
        ]);

        $page = new Page();
        $page->title = $request->title;
        $page->content = $request->content;
        $page->show_on_header = $request->show_on_header ? $request->show_on_header : false;
        $page->show_on_footer = $request->show_on_footer ? $request->show_on_footer : false;
        $saved = $page->save();

        if( $saved ){
            return response()->json(['status'=>1,'message'=>'New page has been successfully created.']);
        }else{
            return response()->json(['status'=>0,'message'=>'Something went wrong.']);
        }

    }

    public function allPages(Request $request){

        $data = [
          'pageTitle'=>'Pages'
        ];

        return view('back.pages.pages', $data);

      } //End Method

      public function editPage(Request $request, $id = null){

        $page = Page::findOrFail($id);
        $data = [
            'pageTitle'=>'Edit',
            'page'=>$page,
            // 'categories_html'=>$categories_html
        ];

        return view('back.pages.edit_page',$data);

      }

      public function updatePage(Request $request){
        
        $page = Page::findOrFail($request->page_id);

        //Validate The Form
        $request->validate([
            'title'=>'required|unique:pages,title,'.$page->id,
            'content'=>'required',
        ]);


        $page->title = $request->title;
        $page->slug = null;
        $page->content = $request->content;
        $page->show_on_header = $request->show_on_header ? $request->show_on_header : false;
        $page->show_on_footer = $request->show_on_footer ? $request->show_on_footer : false;
        $saved = $page->save();

        if( $saved ){
            return response()->json(['status'=>1,'message'=>'Page has been successfully updated.']);
        }else{
            return response()->json(['status'=>0,'message'=>'Something went wrong.']);
        }

      }
}
