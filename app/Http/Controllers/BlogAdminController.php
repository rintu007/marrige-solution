<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Hash;
use Validator;
use Carbon\Carbon;
use App\Model\Page;
use App\Model\User;
use App\Model\Media;
use App\Model\Report;
use App\Model\AdSpace;
use App\Model\Division;
use App\Model\District;
use App\Model\UserRole;
use App\Model\UserPhoto;
use App\Model\UserAbout;
use App\Model\PostThana;
use App\Model\UserPicture;
use App\Model\UserComment;
use App\Model\UserPayment;
use App\Model\FrontSlider;
use App\Model\PostDivision;
use App\Model\PostDistrict;
use App\Model\PostCategory;
use App\Model\Blog as Post;
use App\Model\UserProposal;
use App\Model\UserEducation;
use App\Model\BlogParameter;
use Illuminate\Http\Request;
use App\Model\BlogTag as Tag;
use App\Model\SuccessProfile;
use App\Model\UserSettingItem;
use App\Model\UserContactInfo;
use App\Model\WebsiteParameter;
use App\Model\UserPersonalInfo;
use App\Model\UserSettingField;
use App\Model\Upazila as Thana;
use App\Model\UserInfoForOffice;
use App\Model\MembershipPackage;
use League\Flysystem\Filesystem;
use App\Model\UserPersonalActivity;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Model\BlogCategory as Category;
use Intervention\Image\ImageManagerStatic as Image;

class BlogAdminController extends Controller
{
    
    public function dashboard()
    {
        if(env('APP_ENV') != 'production')
        {
            //for online project
            // return back();
        }
    	$request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'dashboard','lsbsm'=>'dashboard']);
    	return view('blogAdmin.dashboard');
    }

    


//posts
    public function postAddNew(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'posts','lsbsm'=>'postAddNew']);

        $post = Post::where('publish_status', 'temp')->first();
        $cats = Category::all();
        $divs = Division::all();
        $mediaAll = Media::latest()->paginate(200);
        if(!$post)
        {
            $post = new Post;
            $post->addedby_id = Auth::id();
            $post->save();
        }
        return view('blogAdmin.posts.postAddNew',[
            'post'=>$post,
            'cats'=>$cats,
            'divs'=>$divs,
            'mediaAll'=>$mediaAll
        ]);
    }

    public function postsAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'posts','lsbsm'=>'postsAll']);
        $posts = Post::where('publish_status','<>','temp')->orderby('id','desc')->paginate(20);
        return view('blogAdmin.posts.postsAll',['posts'=>$posts]);
    }

    public function postAddNewPost(Request $request){
        
        // dd($request->all());
        $validation = Validator::make($request->all(),
        [ 
          // "title" => "title"
          // "description" => "required"
          // "publish" => "on"
            'excerpt' => 'max:254|required',
            'feature_image' => 'image|dimensions:min_with=300,min_height=200,ratio=3/2'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        if($request->tags)
        {
            foreach($request->tags as $tag)
            {
                $t = Tag::where('title',$tag)->first();
                if(!$t)
                {
                   $t = new Tag;
                   $t->title = $tag;
                   // $t->addedby_id = Auth::id();
                   $t->save(); 
                }                
            }
        }

        $post = Post::where('publish_status', 'temp')->first();
        if(!$post){
            $post = new Post;
            $post->addedby_id = Auth::id();
            $post->save();
        }

        $post->title = $request->title ?: null;
        $post->description = $request->description ?: null;
        $post->excerpt = $request->excerpt ?: null;
        $post->publish_status = $request->publish ? 'published' : 'draft';
        $post->front_slider = $request->front_slider ? true : false;

        $post->meta_title = $request->meta_title ?: null;

        $post->meta_keywords = $request->meta_keywords ?: null;

        $post->meta_description = $request->meta_description ?: null;

        $post->headline = $request->headline ? true : false;
        // $post->highlight = $request->highlight ? true : false;
        $post->addedby_id = Auth::id();

        if($request->tags)
        {
            $post->tags = implode(', ',$request->tags);
        }else
        {
            $post->tags = null;
        }


        if($request->hasFile('feature_image'))
        {

            $ffile = $request->feature_image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $originalName = $ffile->getClientOriginalName();

            Storage::disk('upload')->put('media/image/'.$fimageNewName, File::get($ffile));

                if($post->feature_img_name)
                {

                    Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
                }

            $post->feature_img_name = $fimageNewName;
            $post->feature_img_original_name = $originalName;
            $post->feature_img_ext = $fimgExt;
        }

        $post->save();


        $post->blogCategories()->detach();
        if($request->categories)
        {
            foreach($request->categories as $cat)
            {
                $c = PostCategory::where('category_id',$cat)->where('post_id',$post->id)->first();
                if(!$c)
                {
                   $c = new PostCategory;
                   $c->category_id = $cat;
                   $c->post_id = $post->id;
                   $c->addedby_id = Auth::id();
                   $c->save(); 
                }                
            }
        }

        $post->divisions()->detach();
        if($request->division)
        {
            $division = Division::where('id',$request->division)->first();
            if($division)
            {
                $c = PostDivision::where('division_id',$division->id)->where('post_id',$post->id)->first();
                if(!$c)
                {
                   $c = new PostDivision;
                   $c->division_id = $division->id;
                   $c->post_id = $post->id;
                   $c->addedby_id = Auth::id();
                   $c->save();                   
                }

                $post->districts()->detach();
                if($request->district)
                {
                    $district = District::where('name',$request->district)
                    ->where('division_id', $division->id)->first();
                    if($district)
                    {
                        $c = PostDistrict::where('district_id',$district->id)->where('post_id',$post->id)->first();
                        if(!$c)
                        {
                           $c = new PostDistrict;
                           $c->district_id = $district->id;
                           $c->post_id = $post->id;
                           $c->addedby_id = Auth::id();
                           $c->save(); 
                        }

                        $post->thanas()->detach();
                        if($request->thana)
                        {
                            $thana = Thana::where('name',$request->thana)
                            ->where('division_id', $division->id)
                            ->where('district_id', $district->id)
                            ->first();
                            if($thana)
                            {
                                $c = PostThana::where('thana_id',$thana->id)->where('post_id',$post->id)->first();
                                if(!$c)
                                {
                                   $c = new PostThana;
                                   $c->thana_id = $thana->id;
                                   $c->post_id = $post->id;
                                   $c->addedby_id = Auth::id();
                                   $c->save(); 
                                }  
                            }                 
                        }
                    }                 
                }
            }                            
        }   

        Cache::flush();

        return redirect()->route('admin.postEdit',$post)->with('success', 'New post successfully created.');
    }

    public function postEdit(Post $post, Request $request){

        $cats = Category::all();
        $oldTags = $post->tags ? explode(", ",$post->tags) : null;
        $divs = Division::all();
        $dist = $post->districts()->first();
        $thana = $post->thanas()->first();
        $mediaAll = Media::latest()->paginate(200);
        return view('blogAdmin.posts.postEdit',[
            'post'=>$post,
            'cats'=>$cats,
            'oldTags'=>$oldTags,
            'divs'=>$divs,
            'mediaAll'=>$mediaAll,
            'dist'=>$dist,
            'thana'=>$thana
        ]);
    }

    public function postUpdate(Post $post, Request $request){


        $validation = Validator::make($request->all(),
        [ 
          // "title" => "title"
          // "description" => "required"
          // "publish" => "on"
            'excerpt' => 'max:254|required',
            'feature_image' => 'image|dimensions:min_with=300,min_height=200,ratio=3/2'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        if($request->tags)
        {
            foreach($request->tags as $tag)
            {
                $t = Tag::where('title',$tag)->first();
                if(!$t)
                {
                   $t = new Tag;
                   $t->title = $tag;
                   // $t->addedby_id = Auth::id();
                   $t->save(); 
                }                
            }
        }

        $post->title = $request->title ?: null;
        $post->description = $request->description ?: null;
        $post->excerpt = $request->excerpt ?: null;
        $post->publish_status = $request->publish ? 'published' : 'draft';
        $post->front_slider = $request->front_slider ? true : false;
        $post->headline = $request->headline ? true : false;
        // $post->highlight = $request->highlight ? true : false;

        $post->meta_title = $request->meta_title ?: null;

        $post->meta_keywords = $request->meta_keywords ?: null;

        $post->meta_description = $request->meta_description ?: null;
        
        $post->editedby_id = Auth::id();

        if($request->tags)
        {
            $post->tags = implode(', ',$request->tags);
        }else
        {
            $post->tags = null;
        }

        if($request->hasFile('feature_image'))
        {

            $ffile = $request->feature_image;
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = str_random(8).time().'.'.$fimgExt;
            $originalName = $ffile->getClientOriginalName();

            Storage::disk('upload')->put('media/image/'.$fimageNewName, File::get($ffile));

                if($post->feature_img_name)
                {

                    Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
                }

            $post->feature_img_name = $fimageNewName;
            $post->feature_img_original_name = $originalName;
            $post->feature_img_ext = $fimgExt;
        }

        $post->save();

        $post->blogCategories()->detach();
        if($request->categories)
        {
            foreach($request->categories as $cat)
            {
                $c = PostCategory::where('category_id',$cat)->where('post_id',$post->id)->first();
                if(!$c)
                {
                   $c = new PostCategory;
                   $c->category_id = $cat;
                   $c->post_id = $post->id;
                   $c->addedby_id = Auth::id();
                   $c->save(); 
                }                
            }
        }

        $post->divisions()->detach();
        if($request->division)
        {
            $division = Division::where('id',$request->division)->first();
            if($division)
            {
                $c = PostDivision::where('division_id',$division->id)->where('post_id',$post->id)->first();
                if(!$c)
                {
                   $c = new PostDivision;
                   $c->division_id = $division->id;
                   $c->post_id = $post->id;
                   $c->addedby_id = Auth::id();
                   $c->save();                   
                }

                $post->districts()->detach();
                if($request->district)
                {
                    $district = District::where('name',$request->district)
                    ->where('division_id', $division->id)->first();
                    if($district)
                    {
                        $c = PostDistrict::where('district_id',$district->id)->where('post_id',$post->id)->first();
                        if(!$c)
                        {
                           $c = new PostDistrict;
                           $c->district_id = $district->id;
                           $c->post_id = $post->id;
                           $c->addedby_id = Auth::id();
                           $c->save(); 
                        }

                        $post->thanas()->detach();
                        if($request->thana)
                        {
                            $thana = Thana::where('name',$request->thana)
                            ->where('division_id', $division->id)
                            ->where('district_id', $district->id)
                            ->first();
                            if($thana)
                            {
                                $c = PostThana::where('thana_id',$thana->id)->where('post_id',$post->id)->first();
                                if(!$c)
                                {
                                   $c = new PostThana;
                                   $c->thana_id = $thana->id;
                                   $c->post_id = $post->id;
                                   $c->addedby_id = Auth::id();
                                   $c->save(); 
                                }  
                            }                 
                        }
                    }                 
                }
            }                            
        } 

        Cache::flush();

        return redirect()->route('admin.postEdit',$post)->with('success', 'Post successfully updated.');
    }

    public function featureImageDelete(Request $request, Post $post){
        
        // dd($request->all());
        if($post->feature_img_name)
        {
            Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
            $post->feature_img_name = null;
            $post->save();
        }

        Cache::flush();

        return back();
    }

    public function postDelete(Post $post, Request $request){

        if($post->feature_img_name)
        {
            Storage::disk('upload')->delete('media/image/'.$post->feature_img_name);
            $post->feature_img_name = null;
            $post->save();
        }

        $post->divisions()->detach();
        $post->blogCategories()->detach();
        $post->delete();

        Cache::flush();

        return back()->with('success', 'Post successfully deleted.');
    }

    //posts


    //category
    public function categoryAddNew(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'categories','lsbsm'=>'categoryAddNew']);
        return view('blogAdmin.categories.categoryAddNew');
    }

    public function categoriesAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'categories','lsbsm'=>'categoriesAll']);

        $cats = Category::all();
        return view('blogAdmin.categories.categoriesAll',['cats'=>$cats]);
    }

    public function categoryAddNewPost(Request $request){

        $validation = Validator::make($request->all(),
        [
          'category'=> 'required|min:2|max:100|unique:blog_categories,title'
        ]);
        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $cat = new Category;
        $cat->title = $request->category;
        // $cat->addedby_id = $request->user()->id;
        $cat->save();

        Cache::flush();

        return back()->with('success', 'New Category Successfully Created.');
    }

    public function categoryEdit(Category $cat, Request $request)
    {
        if($request->ajax())
        {
            return Response()->json(View('blogAdmin.categories.ajax.catTbodyEdit',[
                'cat' => $cat,
            ])->render());
        }
    }

    public function categoryUpdate(Category $cat, Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
            'name'=> 'required|min:2|max:100|unique:blog_categories,title',
        ]);
        if($validation->fails())
        {
            return Response()->json(View('blogAdmin.categories.ajax.catTable',[
                'cat' => $cat,
            ])->render());
        }

        $name = $request->name;
        $cat_old_name = $cat->title;
        $cat->title = $name ?: $cat_old_name;
        // $cat->editedby_id = Auth::id();
        $cat->save();

        Cache::flush();

        if($request->ajax())
        {
            return Response()->json(View('blogAdmin.categories.ajax.catTable',[
                'cat' => $cat,
            ])->render());
        }

        

        return back();
    }

    public function categoryDelete(Category $cat, Request $request)
    {
        $cat->posts()->detach();
        $cat->delete();

        Cache::flush();

        if($request->ajax())
        {
            return Response()->json(['success'=>true]);
        }

        

        return back();
    }

//category


    //media
    public function mediaAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'media','lsbsm'=>'mediaAll']);
        $mediaAll = Media::latest()->paginate(50);
        return view('blogAdmin.media.mediaAll',['mediaAll'=>$mediaAll]);
    }

    public function mediaUploadPost(Request $request)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(),
        [ 
            'files.*' => 'image'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        if($request->hasFile('files'))
            {
                foreach($request->file('files') as $file)
                {
                    $originalName = $file->getClientOriginalName();
                    $ext = $file->getClientOriginalExtension();
                    $mime = $file->getClientMimeType();
                    $size =$file->getSize();
                    $fileNewName = str_random(4).date('ymds').'.'.$ext;
                    // $fileNewName = str_random(6).time().'.'.$ext;
                    // $fileNewName = Auth::id().'_'.date('ymdhis').'_'.rand(11,99).'.'.$ext;
                    list($width,$height) = getimagesize($file);                    

                    Storage::disk('upload')
                    ->put('media/image/'.$fileNewName, File::get($file));

                    $file_new_url = 'storage/media/image/'.$fileNewName;

                    $media = new Media;                    
                    $media->file_name = $fileNewName;
                    $media->file_original_name = $originalName;
                    $media->file_mime = $mime;
                    $media->file_ext = $ext;
                    $media->file_size = $size;
                    
                    $media->width = $width;
                    $media->height = $height;
                    $media->file_url = $file_new_url;
                    $media->addedby_id = Auth::id();
                    if($mime == 'image/gif' or $mime == 'image/png' or $mime == 'image/jpeg' or $mime == 'image/bmp')
                    {
                        $media->file_type = 'image';
                    }
                    //image/gif, image/png, image/jpeg, image/bmp, image/webp

                    $media->save();

                }
            }
        

        return back();
    }

    public function mediaDelete(Media $media,Request $request)
    {
        if($media->file_type == 'image')
        {
            Storage::disk('upload')->delete('media/image/'.$media->file_name);
            $media->delete();
        }

        return back()->with('info','Media successfully deleted.');
        
    }
//media

    //blog parameter start

    public function blogParameter()
    {
        $request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'dashboard','lsbsm'=>'blogParameter']);

        $post = BlogParameter::firstOrCreate([]);
        $colors = [
 
            'blue',
            'light-blue',
            'brown',
            'cyan',
            'blue-grey',
            'green',
            'light-green',
            'indigo',
            'lime',
            'orange',
            'deep-orange',
            'pink',
            'purple',
            'deep-purple',
            'red',
            'teal',
            'yellow',
            'white',
            'black',
            'grey',
            'light-grey',
            'dark-grey',
        ];

        return view('blogAdmin.blogParameter',['post'=>$post, 'colors'=> $colors]);
    }

    public function blogParameterUpdate()
    {
        $request = request();
        $post = BlogParameter::firstOrCreate([]);

        $post->title = $request->title;
        $post->short_title = $request->short_title;
        $post->h1 = $request->h1;
        // $post->google_analytics_code = $request->google_analytics_code;
        // $post->meta_author = $request->meta_author;
        // $post->meta_keyword = $request->meta_keyword;
        // $post->meta_description = $request->meta_description;
        $post->footer_address = $request->footer_address;
        $post->footer_copyright = $request->footer_copyright;
        // $post->fb_url = $request->fb_url;
        $post->google_map_code = $request->google_map_code;
        $post->addthis_url = $request->addthis_url;
        $post->main_color = $request->main_color ?: 'default';
        $post->sub_color = $request->sub_color ?: 'default';
        $post->header_bg_color = $request->header_bg_color ?: 'default';
        $post->header_text_color = $request->header_text_color ?: 'default';
        $post->footer_bg_color = $request->footer_bg_color ?: 'default';
        $post->footer_text_color = $request->footer_text_color ?: 'default';

        if($request->favicon)
        {
            $file = $request->favicon;
            Storage::disk('upload')->delete('favicon/'.$post->favicon);

            $originalName = $file->getClientOriginalName();
            Storage::disk('upload')->put('favicon/'.$originalName, File::get($file));
            $post->favicon = $originalName;
        }

        if($request->logo)
        {
            $file = $request->logo;
            // Storage::disk('upload')->delete('logo/'.$post->logo);

            $originalName = $file->getClientOriginalName();
            $newName = rand(1000,9999) . $originalName;
            Storage::disk('upload')->put('logo/'.$newName, File::get($file));
            $post->logo = $newName;
        }

        // if($request->android_apk)
        // {
        //     $apk = $request->android_apk;
        //     Storage::disk('upload')->delete('apk/'.$post->android_apk);

        //     $on = $apk->getClientOriginalName();
        //     Storage::disk('upload')->put('apk/'.$on, File::get($apk));
        //     $post->android_apk = $on;
        // }

        $post->save();

        Cache::flush();

        return back()->with('success', 'Blog Parameter Successfully Updated.');
    }

    //blog parameter end


    //ad space
    public function newAd()
    {
        $request = request();
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'ad','lsbsm'=>'newAd']);
        $mediaAll = Media::latest()->paginate(200);
        return view('blogAdmin.ad.newAd',['mediaAll'=>$mediaAll]);
    }

    public function newAdPost(Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $ad = new AdSpace;
        $ad->title = $request->title;
        $ad->description = $request->description;
        $ad->addedby_id = Auth::id();
        $ad->save();

        Cache::flush();

        return back()->with('success','Ad Space successfully created.');

    }

    public function allAds(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'ad','lsbsm'=>'allAds']);
        $ads = AdSpace::latest()->paginate(50);
        $mediaAll = Media::latest()->paginate(200);
        return view('blogAdmin.ad.allAds',['ads'=>$ads,'mediaAll'=>$mediaAll]);
    }

    public function editAd(AdSpace $ad)
    {
        $mediaAll = Media::latest()->paginate(200);
        return view('blogAdmin.ad.editAd',['mediaAll'=>$mediaAll,'ad'=>$ad]);
    }

    public function updateAd(AdSpace $ad, Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $ad->title = $request->title;
        $ad->description = $request->description;
        $ad->editedby_id = Auth::id();
        $ad->save();

        Cache::flush();

        return back()->with('success','Ad Space successfully updated.');
    }
    //ad space


//division //district //thana
    public function divisionAddNew(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'divisions','lsbsm'=>'divisionAddNew']);
        return view('blogAdmin.divisions.divisionAddNew');
    }

    public function divisionsAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'divisions','lsbsm'=>'divisionsAll']);

        $divs = Division::all();
        return view('blogAdmin.divisions.divisionsAll',['divs'=>$divs]);
    }

    public function divisionAddNewPost(Request $request){

        $validation = Validator::make($request->all(),
        [
          'division'=> 'required|min:2|max:100|unique:divisions,name'
        ]);
        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $div = new Division;
        $div->name = $request->division;
        $div->addedby_id = $request->user()->id;
        $div->save();

        Cache::flush();


        return back()->with('success', 'New division Successfully Created.');
    }

    public function divisionEdit(Division $div, Request $request)
    {
        if($request->ajax())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.divTbodyEdit',[
                'div' => $div,
            ])->render());
        }
    }

    public function divisionUpdate(Division $div, Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
            'name'=> 'required|min:2|max:100|unique:divisions,name',
        ]);
        if($validation->fails())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.divTable',[
                'div' => $div,
            ])->render());
        }

        $name = $request->name;
        $div_old_name = $div->name;
        $div->name = $name ?: $div_old_name;
        $div->editedby_id = Auth::id();
        $div->save();

        Cache::flush();

        if($request->ajax())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.divTable',[
                'div' => $div,
            ])->render());
        }

        

        return back();
    }

    public function divisionDelete(Division $div, Request $request)
    {
        $div->posts()->detach();
        $div->districts()->delete();
        $div->thanas()->delete();
        $div->delete();

        Cache::flush();

        if($request->ajax())
        {
            return Response()->json(['success'=>true]);
        }

        

        return back();
    }

    public function districtsAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'divisions','lsbsm'=>'districtsAll']);

        $divs = Division::all();
        return view('blogAdmin.divisions.districtsAll',['divs'=>$divs]);
    }

    public function districtAddNewPost(Request $request){

        $validation = Validator::make($request->all(),
        [
          'division'=> 'required|exists:divisions,name',
          'district'=> 'required|min:2|max:100|unique:districts,name'
        ]);
        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $div = Division::where('name', $request->division)->first();

        $dis = new District;
        $dis->name = $request->district;
        $dis->division_id = $div->id;
        $dis->addedby_id = $request->user()->id;
        $dis->save();

        Cache::flush();

        return back()
        ->withInput()
        ->with('success', 'New District Successfully Created.');
    }

    public function districtDelete(District $district, Request $request)
    {
        // $district->posts()->detach();
        $district->thanas()->delete();
        $district->delete();

        Cache::flush();

        if($request->ajax())
        {
            return Response()->json(['success'=>true]);
        }
        return back();
    }

    public function districtEdit(District $district, Request $request)
    {
        if($request->ajax())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.districtTbodyEdit',[
                'district' => $district,
            ])->render());
        }
    }

    public function districtUpdate(District $district, Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
            'name'=> 'required|min:2|max:100|unique:districts,name',
        ]);
        if($validation->fails())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.districtTBody',[
                'district' => $district,
            ])->render());
        }

        $name = $request->name;
        $district_old_name = $district->name;
        $district->name = $name ?: $district_old_name;
        $district->editedby_id = Auth::id();
        $district->save();

        Cache::flush();

        if($request->ajax())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.districtTBody',[
                'district' => $district,
            ])->render());
        }
        return back();
    }

    public function thanaAll(Request $request)
    {
        $request->session()->forget(['lsbm','lsbsm']);
        $request->session()->put(['lsbm'=>'divisions','lsbsm'=>'thanaAll']);

        $districts = District::all();
        return view('blogAdmin.divisions.thanaAll',['districts'=>$districts]);
    }

    public function thanaAddNewPost(Request $request){

        // dd($request->all());
        $validation = Validator::make($request->all(),
        [
          'district'=> 'required|exists:districts,name',
          'thana'=> 'required|min:2|max:100'
        ]);
        if($validation->fails())
        {
            return back()
            ->withErrors($validation)
            ->withInput()
            ->with('error', 'Something Went Wrong!');
        }

        $district = District::where('name', $request->district)->first();

        $dis = new Thana;
        $dis->name = $request->thana;
        $dis->district_id = $district->id;
        $dis->division_id = $district->division->id;
        $dis->addedby_id = $request->user()->id;
        $dis->save();

        Cache::flush();

        return back()
        ->withInput()
        ->with('success', 'New Thana (উপজেলা) Successfully Created.');
    }

    public function thanaDelete(Thana $thana, Request $request)
    {
        // $thana->posts()->detach();
        $thana->delete();

        Cache::flush();

        if($request->ajax())
        {
            return Response()->json(['success'=>true]);
        }
        return back();
    }

    public function thanaEdit(Thana $thana, Request $request)
    {
        if($request->ajax())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.thanaTbodyEdit',[
                'thana' => $thana,
            ])->render());
        }
    }

    public function thanaUpdate(Thana $thana, Request $request)
    {
        $validation = Validator::make($request->all(),
        [ 
            'name'=> 'required|min:2|max:100',
        ]);
        if($validation->fails())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.thanaTBody',[
                'thana' => $thana,
            ])->render());
        }

        $name = $request->name;
        $thana_old_name = $thana->name;
        $thana->name = $name ?: $thana_old_name;
        $thana->editedby_id = Auth::id();
        $thana->save();

        Cache::flush();

        if($request->ajax())
        {
            return Response()->json(View('blogAdmin.divisions.ajax.thanaTBody',[
                'thana' => $thana,
            ])->render());
        }
        return back();
    }

//division //district //thana
}
