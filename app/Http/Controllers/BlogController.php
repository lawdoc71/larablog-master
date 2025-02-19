<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Helpers\CMail;
use App\Models\Category;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class BlogController extends Controller
{
    public function index(Request $request){
        $title = isset(settings()->site_title) ? settings()->site_title : '';
        $description = isset(settings()->site_meta_description) ? settings()->site_meta_description : '';
        $imgURL = isset(settings()->site_logo) ? asset('/images/site/'.settings()->site_logo) : '';
        $keywords = isset(settings()->site_meta_keywords) ? settings()->site_meta_keywords : '';
        $currentUrl = url()->current();

        /** Meta SEO */
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);
        SEOMeta::setKeywords($keywords);

        /** Open Graph */
        SEOTools::opengraph()->setUrl($currentUrl);
        SEOTools::opengraph()->addImage($imgURL);
        SEOTools::opengraph()->addProperty('type','articles');

        /** Twitter */
        SEOTools::twitter()->addImage($imgURL);
        SEOTools::twitter()->setUrl($currentUrl);
        SEOTools::twitter()->setSite('@larablog');


        $data = [
            'pageTitle'=>$title
        ];

        return view('front.pages.index',$data);

    } // End Method

    public function categoryPosts(Request $request, $slug = null){

        //Find Category by slug
        $category = Category::where('slug',$slug)->firstOrFail();

        //Retrieve posts related to this category and paginate
        $posts = Post::where('category',$category->id)
                     ->where('visibility',1)
                     ->paginate(8);

        $title = 'Posts in Category: '.$category->name;
        $description = 'Browse the latest posts in the '.$category->name.' category. Stay updated with articles, insights, and tutorials.';

        /** Set SEO Meta Tags */
        SEOTools::setTitle($title,false);
        SEOTools::setDescription($description);
        SEOTools::opengraph()->setUrl(url()->current());

        $data = [

            'pageTitle'=>$category->name,
            'posts'=>$posts

        ];

        return view('front.pages.category_posts', $data);

    } // End Method

    public function authorPosts(Request $request, $username = null){

        //Find the author based on the username
        $author = User::where('username',$username)->firstOrFail();

        //Retrieve posts related to this author and paginate
        $posts = Post::where('author_id',$author->id)
                     ->where('visibility',1)
                     ->orderBy('created_at','asc')
                     ->paginate(8);
        $title = $author->name.' | Blog Posts';
        $description = 'Explore latest posts by .'.$author->name.'';

        /** Set SEO Meta Tags */
        SEOTools::setTitle($title,false);
        SEOTools::setDescription($description);
        SEOTools::setCanonical(route('author_posts',['username'=>$author->username]));
        SEOTools::opengraph()->setUrl(route('author_posts',['username'=>$author->username]));
        SEOTools::opengraph()->addProperty('type','profile');
        SEOTools::opengraph()->setProfile([
            'first_name'=>$author->name,
            'username'=>$author->username
        ]);

        $data = [

            'pageTitle'=>$author->name,
            'author'=>$author,
            'posts'=>$posts

        ];

        return view('front.pages.author_posts', $data);

    } // End Method

    public function tagPosts(Request $request, $tag = null){
        //Query posts that have the selected tag
        $posts = Post::where('tags','LIKE',"%{$tag}%")->where('visibility',1)->paginate(8);

        /** For Meta Tags */
        $title = "Posts tagged with {$tag}";
        $description = "Explore posts tagged with {$tag} at our blog.";

        /** Set SEO Meta Tags */
        SEOTools::setTitle($title,false);
        SEOTools::setDescription($description);
        SEOTools::setCanonical(url()->current());

        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::opengraph()->addProperty('type','articles');

        $data = [
            'pageTitle'=>$title,
            'tag'=>$tag,
            'posts'=>$posts
        ];
        return view('front.pages.tag_posts',$data);
    } // End Method

    public function searchPosts(Request $request){

        //Get search query from the input
        $query = $request->input('q');

        //If query is not empty, process the search
        if( $query ){
            $keywords = explode(' ', $query);
            $postsQuery = Post::query();

            foreach( $keywords as $keyword ){
                $postsQuery->orWhere('title','LIKE','%'.$keyword.'%')
                           ->orWhere('tags','LIKE','%'.$keyword.'%');
            }
            $posts = $postsQuery->where('visibility',1)
                                ->orderBy('created_at','desc')
                                ->paginate(10);

            /** For Meta Tags */
            $title = "Search results for {$query}";
            $description = "Browse search results for {$query} on our blog.";

        }else{
            $posts = collect();

            /** For Meta Tags */
            $title = 'Search';
            $description = 'Search for blog posts on our website.';
        }

        SEOTools::setTitle($title,false);
        SEOTools::setDescription($description);

        $data = [
            'pageTitle'=>$title,
            'query'=>$query,
            'posts'=>$posts
        ];
        return view('front.pages.search_posts',$data);
    } // End Method

    public function readPost(Request $request, $slug = null){

        // Fetch single post by slug
        $post = Post::where('slug',$slug)->firstOrFail();

        // Get related posts
        $relatedPosts = Post::where('category',$post->category)
                            ->where('id','!=',$post->id)
                            ->where('visibility',1)
                            ->take(3)
                            ->get();

        // Get the next post
        $nextPost = Post::where('id','>',$post->id)
                        ->where('visibility',1)
                        ->orderBy('id','asc')
                        ->first();

        // Get the previous post
        $prevPost = Post::where('id','<',$post->id)
                        ->where('visibility',1)
                        ->orderBy('id','desc')
                        ->first();

        // Set SEO Meta Tags
        $title = $post->title;
        $description = ($post->meta_description != '') ? $post->meta_description : words($post->content,35);

        SEOTools::setTitle($title,false);
        SEOTools::setDescription($description);
        SEOTools::opengraph()->setUrl(route('read_post',['slug'=>$post->slug]));
        SEOTools::opengraph()->addProperty('type','article');
        SEOTools::opengraph()->addImage(asset('images/posts/'.$post->featured_image));
        SEOTools::twitter()->setImage(asset('images/posts/'.$post->featured_image));

        $data = [

            'pageTitle'=>$title,
            'post'=>$post,
            'relatedPosts'=>$relatedPosts,
            'nextPost'=>$nextPost,
            'prevPost'=>$prevPost

        ];

        return view('front.pages.single_post',$data);

    } // End Method

    public function contactPage(Request $request){

        $title = 'Contact Us';
        $description = 'Contact with any and all questions you may have.';
        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);

        return view('front.pages.contact');

    } // End Method

    public function sendEmail(Request $request){

       //Validate the form
       $request->validate([
          'name'=>'required',
          'email'=>'required|email',
          'subject'=>'required',
          'message'=>'required'
       ]);

       $siteInfo = settings();

       $data = [
         'name'=>$request->name,
         'email'=>$request->email,
         'message'=>$request->message,
       ];

       $mail_body = view('email-templates.contact-message-template',$data);

       $mail_config = [
          'from_name'=>$request->name,
          'replyToAddress'=>$request->email,
          'replyToName'=>$request->name,
          'recipient_address'=>$siteInfo->site_email,
          'recipient_name'=>$siteInfo->site_title,
          'subject'=>$request->subject,
          'body'=>$mail_body
       ];

       if( CMail::send($mail_config, true) ){

            return redirect()->back()->with('success','Email Sent Successfully!.');

       } else {

            return redirect()->back()->withInput()->with('fail','Something went wrong. Try again later.');

       }
    } // End Method

    public function showPage(Request $request, $slug){

        $page = Page::where('slug',$slug)->firstOrFail();

        $title = 'Info | '.$page->title;
        $description = '';

        SEOTools::setTitle($title, false);
        SEOTools::setDescription($description);

        $data = [

            'pageTitle'=>$title,
            'page'=>$page,
            
        ];

        return view('front.pages.single_page',$data);

    }
}
