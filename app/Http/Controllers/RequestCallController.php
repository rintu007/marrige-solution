<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\RequestCallBack;
use Illuminate\Support\Facades\Auth;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class RequestCallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function callback()
    {
        request()->session()->forget(['lsbm','lsbsm']);
        request()->session()->put(['lsbm'=>'adminMessage','lsbsm'=>'requestCallBack']);

        $data = RequestCallBack::orderBy('id','desc')->paginate(20);

        // dd($data);
        return view('admin.requestCallMessage.index', [
            'allMessage'=>$data]);
    }

    public function updateComplete(RequestCallBack $id)
    {        
        $id->completed = true;
        $id->save();       
        
        return redirect()->back();
    }

    public function calldelete(RequestCallBack $id,Request $request)
    {
        $id->delete();

        return back()->with('success', 'Callback request successfully deleted');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new RequestCallBack;
        $message->name = $request->name;
        $message->profilemadeby = $request->profilemadeby?: 'Self';
        $message->email = $request->email;
        $message->mobile = $request->mobile;
        $message->description = $request->desct;
        
        if($request->hasFile('file'))
        {
            
            $ffile = $request->file;
            // dd($ffile);
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewName = Str::random(8).time().'.'.$fimgExt; 
            
            Storage::disk('upload')
            ->put('cv/'.$fimageNewName, File::get($ffile));

            $image_url = 'storage/cv/'.$fimageNewName;

            $message->img_url = $image_url;
            $message->img_name =$fimageNewName;
        }

        if($request->hasFile('image_file'))
        {
            
            $ffile = $request->image_file;
            // dd($ffile);
            $fimgExt = strtolower($ffile->getClientOriginalExtension());               
            $fimageNewNames = Str::random(8).time().'.'.$fimgExt; 
            
            Storage::disk('upload')
            ->put('cv/'.$fimageNewNames, File::get($ffile));
            $image_url = 'storage/cv/'.$fimageNewNames;
            $message->pic_url = $image_url;

            $message->picture_name =$fimageNewNames;
        }

        $message->save();
        
        return redirect()->back()->with('success', 'Message send successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
