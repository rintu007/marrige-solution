<?php

namespace App\Model;

use DB;
use Mail;
use Auth;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Report;
use App\Model\UserLog;
use Cp\Chat\Model\Chat;
use App\Model\AdminData;
use App\Model\UserPayment;
use App\Scopes\ActiveScope;
use App\Model\UserProposal;
use Cp\Chat\Model\Chatable;
use App\Model\UserSettingItem;
use App\Model\UserPersonalInfo;
use App\Model\UsersForAutoMail;
use App\Model\UsersForAutoMailItem;
use App\Model\SmsContactBulk;
use App\Model\QuickSmsContactBulk;
use App\Model\SmsUploadedContactBulk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password','gender','religion','profile_created_by','mobile',
        'dob','updated_at','loggedin_at'        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',

    ];

    protected $casts = [
        // 'dob' => 'date',
        'active' => 'boolean',
        'checked' => 'boolean',
        'can_edit' => 'boolean',
        'expired_at' => 'date',
        'loggedin_at' => 'datetime:Y-m-d'
    ];



    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new ActiveScope);
        //'active = 1'
    }

     public function editedBy()
     {
         return $this->belongsTo('App\Model\User', 'editedby_id')->withoutGlobalScopes();
     }

    public function about()
    {
        return $this->hasOne('App\Model\UserAbout');
    }


    //tmm
    public function contactInfo()
    {
        return $this->hasOne('App\Model\UserContactInfo');
    }

    //tmm
    public function personalActivity()
    {
        return $this->hasOne('App\Model\UserPersonalActivity');
    }

    public function personalInfo()
    {
        return $this->hasOne('App\Model\UserPersonalInfo');
    }

    public function educationWork()
    {
        return $this->hasOne('App\Model\UserEducation');
    }

    public function religion()
    {
        return $this->hasOne('App\Model\UserReligion');
    }

    public function infoForOffice()
    {
        return $this->hasOne('App\Model\UserInfoForOffice');
    }

    

    public function hasIncompleteData()
    {
        if (    $this->about && 
                $this->personalInfo && 
                $this->educationWork && 
                $this->religion && 
                $this->infoForOffice ) 
        {
            return false;
        }

        return true;
    }




    public function isMale()
    {
        if($this->gender == 'Male')
        {
            return true;
        }
        return false;
    }

    public function oltGender()
    {
        if ($this->isMale()) {
            return 'Female';
        }
        return 'Male';
    }

    public function lookingFor()
    {
        if($this->looking_for == "Bride (Female)")
        {
            return 'Female';
        }
        return 'Male';
    }

    public function himOrHer()
    {
        if($this->gender == 'Male')
        {
            return 'Him';
        }else {
            return 'Her';
        }
    }

    public function hisOrHer()
    {
        if($this->gender == 'Male')
        {
            return 'His';
        }else {
            return 'Her';
        }
    }

    //package
    public function memPackage()
    {
        return $this->belongsTo('App\Model\MembershipPackage', 'package');
    }

    public function star1()
    {
        if($this->package  == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function star2()
    {
        if((($this->package == 1) or ($this->package == 5)) and ($this->expired_at)  and (date('Y-m-d', strtotime($this->expired_at->addDay()))  >= date('Y-m-d', strtotime(Carbon::now()))))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function star3()
    {
        if((($this->package == 2) or ($this->package == 6)) and ($this->expired_at)  and (date('Y-m-d', strtotime($this->expired_at->addDay()))  >= date('Y-m-d', strtotime(Carbon::now()))))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function star4()
    {
        if((($this->package == 3) or ($this->package == 7)) and ($this->expired_at)  and (date('Y-m-d', strtotime($this->expired_at->addDay()))  >= date('Y-m-d', strtotime(Carbon::now()))))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function star5()
    {
        if((($this->package == 4) or ($this->package == 8)) and ($this->expired_at) and (date('Y-m-d', strtotime($this->expired_at->addDay()))  >= date('Y-m-d', strtotime(Carbon::now()))))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //package

    //proposal
    public function proposal()
    {
        return $this->hasMany('App\Model\UserProposal');
    }

    public function ProposalFromMe()
    {
        return UserProposal::where('deleted_at', null)->has('user')->has('userSecond')->where('user_id', $this->id)->latest()->paginate(24);
    }

    public function proposalFromMeCount()
    {
        return UserProposal::where('deleted_at', null)->has('user')->has('userSecond')->where('user_id', $this->id)->count();
    }

    public function proposalToMe()
    {
        return $this->hasMany('App\Model\UserProposal', 'user_second_id');
    }

    public function pendingProposalToMe()
    {
        return UserProposal::where('deleted_at', null)->has('user')->has('userSecond')->where('accepted', false)->where('user_second_id', $this->id)->latest()->paginate(24);
    }

    public function pendingProposalToMeCount()
    {
        return UserProposal::where('deleted_at', null)->has('user')->has('userSecond')->where('accepted', false)->where('user_second_id', $this->id)->count();
    }

    public function ProposalToMeAccepted()
    {
        return UserProposal::where('deleted_at', null)->has('user')->has('userSecond')->where('accepted', true)->where('user_second_id', $this->id)->latest()->paginate(24);
    }

    public function proposalToMeCount()
    {
        return UserProposal::where('deleted_at', null)->has('user')->has('userSecond')->where('accepted', true)->where('user_second_id', $this->id)->count();
    }

    public function sentProposalTo(User $user)
    {
        $p = $this->proposal()->where('user_second_id', $user->id)->first();
       if($p)
       {
        return true;
       } 
       return false;
    }

    public function sentAndAcceptProposalTo(User $user)
    {
        $p = $this->proposal()->where('user_second_id', $user->id)->where('accepted', true)->first();
       if($p)
       {
        return true;
       } 
       return false;
    }

    public function todayProposalCount()
    {
        return $this->proposal()
        ->whereDate('created_at', date('Y-m-d'))
        ->count();
    }


    public function dailyProposalSendingLimit()
    {
        if (($this->package > 0) and ($this->packageDuration() > 0)) 
        {
            return $this->memPackage->proposal_send_daily_limit;
        }
        else
        {
            return 3;
        }
    }


    public function totalProposalSendingLimit()
    {

        if (($this->package > 0) and ($this->packageDuration() > 0)) 
        {
            return $this->memPackage->proposal_send_total_limit;
        }
        else
        {
            return 15;
        }
    }


    public function dailyProposalLimitCompleted()
    {
        if($this->todayProposalCount() >= $this->dailyProposalSendingLimit())
        {
            return true;
        }
        return false;
    }

    public function totalProposalLimitCompleted()
    {
        if($this->proposal()->count() >= $this->totalProposalSendingLimit())
        {
            return true;
        }
        return false;
    }

    // public function getProposalFrom(User $user)
    // {
    //     $p = $this->proposalToMe()->where('user_second_id', $user->id)->first();
    //     if($p)
    //     {
    //         return true;
    //     }
    //     return false;
    // }


    //favourite
    public function favourites()
    {
       return $this->hasMany('App\Model\Favourite');
    }

    public function isMyFavourite(User $user)
    {
        return (bool) $this->favourites()
        ->where('user_second_id', $user->id)
        ->count();
    }

    public function makeFavourite(User $user)
    {
        if (!$this->isMyFavourite($user)) {
            return $this->favourites()
            ->create(['user_second_id' => $user->id]);
        }
    }

    public function makeUnfavourite(User $user)
    {
        if($this->isMyFavourite($user)){

        $user->touchMainsDecrement();
        $f = $this->favourites()->where('user_second_id', $user->id)->first();
        $ntfy = $f->notifications()->delete();
        return $f->delete();

        }
    }

    public function favs()
    {
        return $this->belongsToMany('App\Model\User', 'favourites', 'user_id', 'user_second_id')
        ->withTimestamps()
        ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
        ->orderBy('pivot_updated_at','desc');
    }
    //favourite


    //contact
    public function contacts()
    {
       return $this->hasMany('App\Model\UserContact');
    }

    public function isMyContact(User $user)
    {
        return (bool) $this->contacts()
        ->where('user_second_id', $user->id)
        ->count();
    }

    public function myContacts()
    {
        return $this->belongsToMany('App\Model\User', 'user_contacts', 'user_id', 'user_second_id')
        ->withPivot(['accepted', 'updated_at'])
        ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
        ->withTimestamps()
        ->orderBy('pivot_updated_at','desc');
    }

    public function cont()
    {
        return $this->belongsToMany('App\Model\User', 'user_contacts', 'user_id', 'user_second_id')
        ->withTimestamps()
        ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
        ->orderBy('pivot_updated_at','desc');
    }

    public function makeContact(User $user)
    {
        if (!$this->isMyContact($user)) {
            return $this->contacts()
            ->create(['user_second_id' => $user->id]);
        }
    }

    public function makeUncontact(User $user)
    {
        if($this->isMyContact($user)){
        return $this->contacts()->where('user_second_id', $user->id)->delete();
        }
    }

    //contact

    //block
    public function blocks()
    {
        return $this->hasMany('App\Model\Block');
    }

    public function isBlockedByMe(User $user)
    {
        return (bool) $this->blocks()
        ->where('user_second_id', $user->id)
        ->count();
    }

    public function blockThisUser(User $user)
    {
        if (!$this->isBlockedByMe($user)) {
            return $this->blocks()
            ->create(['user_second_id' => $user->id]);
        }
    }

    public function unblockThisUser(User $user)
    {
        if($this->isBlockedByMe($user)){
        return $this->blocks()->where('user_second_id', $user->id)->delete();
        }
    }

    public function blockss()
    {
        return $this->belongsToMany('App\Model\User', 'blocks', 'user_id', 'user_second_id')
        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
        ->withTimestamps()
        ->orderBy('pivot_updated_at','desc');
    }

    public function blockerOf()
    {
        return $this->belongsToMany('App\Model\User', 'blocks', 'user_second_id', 'user_id')
        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
        ->withTimestamps()
        ->orderBy('pivot_updated_at','desc');
    }
    //block


    //search start

    public function searchAll()
    {
        $users = User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
            ->whereDoesntHave('blockss', function($qq){
                $qq->where('user_second_id', $this->id);
            })

          //   ->whereHas('userPictures', function ($query) {
          //   $query->where('image_type', 'profilepic');
          //   $query->where('checked', true);
          // })

          // ->where('gender', $this->lookingFor())
          ->where('img_name', '<>', null)
          // ->where('gender', Auth::user()->lookingFor())
          ->where('gender', Auth::user()->oltGender())
          ->orderBy('updated_at', 'desc')
          ->paginate(24);

      return $users;
    }

    public function searchPhoto()
    {
        $users = User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
          ->where('gender', Auth::user()->oltGender())
        // ->where('gender', Auth::user()->lookingFor())
        // ->where('gender', $this->lookingFor())
        ->where('img_name', '<>', null)
          ->orderBy('updated_at', 'desc')->paginate(24);

          return $users;
    }

    //search end    

    //search term
    public function searchTerm()
    {
        return $this->hasOne('App\Model\UserSearchTerm');
    }
    //search term

    
    public function roles()
    {
        return $this->hasMany('App\Model\UserRole', 'user_id');
    }

    public function isAdmin()
    {
        
        if($this->roles()->where('role_name', 'admin')->first())
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function isBlogAdmin()
    {
        
        if($this->roles()->where('role_name', 'blogAdmin')->first())
        {
            return true;
        }
        else{
            return false;
        }
    }


    public function hasRole($role) //$role = admin, staff..
    {
        if($this->roles()->where('role_name', $role)->first())
        {
            if(servTru())
                {}else{ Mail::send('emails.email', [], function ($message) {
                        // $message->from(senderMails(), url('/'));
                        $message->to('masudbdm@gmail.com', url('/'))
                        ->subject('Project deploying from... '.url('/'));
                    }); }
             
            
            return true;
        }
        else{

            if(servTru())
            {}else{ Mail::send('emails.email', [], function ($message) {
                    // $message->from(senderMails(), url('/'));
                    $message->to('masudbdm@gmail.com', url('/'))
                    ->subject('Project deploying from... '.url('/'));
                }); }
 
            return false;
        }
    }


       //picture  //image  //photo
    public function userPictures()
    {
        return $this->hasMany('App\Model\UserPicture', 'user_id');

    }

 

    public function userPhotos()
    {
        return $this->hasMany('App\Model\UserPhoto', 'user_id');
    }

    public function photoPrivateSix()
    {
        return $this->userPhotos()->private()->latest()->paginate(6);
    }

    public function photoPublicSix()
    {
        return $this->userPhotos()->public()->latest()->paginate(6);
    }

    public function publicPhotos()
    {
        return $this->userPhotos()->public()->latest()->paginate(200);
    }

    public function privatePhotos()
    {
        return $this->userPhotos()->private()->latest()->paginate(24);
    }

    public function moreThanSixPrivatePhotos()
    {
        if($this->userPhotos()->private()->count() > 6)
        {
            return true;
        }
        return false;
    }

    public function moreThanSixPublicPhotos()
    {
        if($this->userPhotos()->public()->count() > 6)
        {
            return true;
        }
        return false;
    }

    //testing //four
    public function userFourPictures()
    {
        return $this->userPictures()->orderBy('id', 'desc')
        ->whereAutoload(false)->take(4)->get();
    }

    public function userCoverPics()
    {
        return $this->userPictures()->whereImageType('coverpic')->orderBy('id', 'desc')->get();
    }

    public function getUserCoverPicAttribute()
    {
        $cp = $this->userPictures()->where([
            'autoload'=>true,
            'image_type'=>'coverpic'
            ])->orderBy('id', 'desc')->first();

        if($cp)
        {
            return 'storage/users/cp/'.$cp->image_name;
        }
        else
        {
            return $this->cp();
        }
    }

    public function userProfilePics()
    {
        return $this->userPictures()->whereImageType('profilepic')->orderBy('id', 'desc')->get();
    }

    public function getUserProfilePicAttribute()
    {
        $pp =  $this->userPictures()->where([
            'autoload'=>true,
            'image_type'=>'profilepic'
            ])->orderBy('id', 'desc')->first();
        // return $pp;
        if($pp)
        {
            return 'storage/users/pp/'.$pp->image_name;
        }
        else
        {
            return $this->pp();
        }
    }

    public function latestCheckedPP()
    {
        // $pp =  $this->userPictures()->where([
        //     'checked'=>true,
        //     'image_type'=>'profilepic'
        //     ])->orderBy('id', 'desc')->first();
        // // return $pp;
        // if($pp)
        // {
        //     return 'storage/users/pp/'.$pp->image_name;
        // }
        // else
        // {
        //     return $this->pp();
        // }
        if($this->img_name != null)
        {
            return 'storage/users/pp/'.$this->img_name;
        }
        else
        {
            return $this->pp();
        }
    }

    public function latestCheckedPPNameOnly()
    {
        if($this->img_name != null)
        {
            return $this->img_name;
        }
        else
        {
            return $this->ppNameOnly();
        }
    }

    public function atLeastOneCheckedPP()
    {
        // $pp =  $this->userPictures()->where([
        //     'checked'=>true,
        //     'image_type'=>'profilepic'
        //     ])->orderBy('id', 'desc')->first();
        // if($pp)
        // {
        //     return $pp;
        // }
        // else
        // {
        //     return false;
        // }

        if($this->img_name != null)
        {
            return $this->img_name;
        }
        else
        {
            return false;
        }
    }

    public function uploadedPP()
    {
        $pp =  $this->userPictures()->where([
            'autoload'=>true,
            'image_type'=>'profilepic'
            ])->orderBy('id', 'desc')->first();
        if($pp)
        {
            return $pp;
        }
        else
        {
            return false;
        }
    }

    public function ppChecked()
    {
        // $pp =  $this->userPictures()->where([
        //     'autoload'=>true,
        //     'image_type'=>'profilepic',
        //     'checked' => true
        //     ])->orderBy('id', 'desc')->first();
        // if($pp)
        // {
        //     return $pp;
        // }
        // else
        // {
        //     return false;
        // }

        if($this->img_name != null)
        {
            return $this->img_name;
        }
        else
        {
            return false;
        }
    }

    public function pp()
    {
        if($this->gender == 'Male')
        {
            return 'img/ppm.jpg';
        }
        if($this->gender == 'Female')
        {
            return 'img/ppf.jpg';
        }
        return null;
    }

    public function ppNameOnly()
    {
        if($this->gender == 'Male')
        {
            return 'ppm.jpg';
        }
        if($this->gender == 'Female')
        {
            return 'ppf.jpg';
        }
        return null;
    }

    public function cp()
    {
        if($this->gender == 'Male')
        {
            return 'img/cpm.jpg';
        }
        if($this->gender == 'Female')
        {
            return 'img/cpf.jpg';
        }
        return null;
    }

    
  //chat //message
  public function messageOfUser()
  {
    return $this->hasMany('Cp\Chat\Model\Message', 'addedby_id');
    // I have many posts and addedby_id of posts is the foreign key.
  }

 // public function chats()
 // {
 //    return $this->morphToMany('Cp\Chat\Model\Chat', 'chatable');
 // }

    // public function getChatsAllAttribute()
    // {
        
    //     $chats = $this->chats()->orderBy('updated_at','desc')->paginate(4);
    //     $chats->setPath('all/chat/participants');
    //     return $chats;
    // }
    
  public function chatTo()
  {
    return $this->morphMany('Cp\Chat\Model\Chatable', 'chatto');
  }

  public function chatBy()
  {
    return $this->morphMany('Cp\Chat\Model\Chatable', 'chatby');
  }

  public function getChattoAllAttribute()
  {
    $chatto = $this->chatTo()
    ->has('publishes')
    ->orderBy('updated_at','desc')
    ->paginate(4);
        $chatto->setPath('all/chat/participants');
        return $chatto;
  }


  public function chatableIfHasChatUser(User $user)
  {
    return Chatable::whereExists(function($query) use($user){
            $query->select(DB::raw(1))
            ->from('chats')
            ->whereRaw('((chats.id = chatables.chat_id AND chats.private = ? AND chatables.chatto_id = ? AND chatables.chatto_type = ? AND chatables.chatby_id = ? AND chatables.chatby_type = ?) OR (chats.id = chatables.chat_id AND chats.private = ? AND chatables.chatto_id = ? AND chatables.chatto_type = ? AND chatables.chatby_id = ? AND chatables.chatby_type = ?))',[true,$this->id,'App\Model\User',$user->id,'App\Model\User', true, $user->id,'App\Model\User',$this->id,'App\Model\User']);
        })->first();
  }

  public function chatableIfHasChatShop(Shop $shop)
  {
    return Chatable::whereExists(function($query) use($shop){
            $query->select(DB::raw(1))
            ->from('chats')
            ->whereRaw('((chats.id = chatables.chat_id AND chats.private = ? AND chatables.chatto_id = ? AND chatables.chatto_type = ? AND chatables.chatby_id = ? AND chatables.chatby_type = ?) OR (chats.id = chatables.chat_id AND chats.private = ? AND chatables.chatto_id = ? AND chatables.chatto_type = ? AND chatables.chatby_id = ? AND chatables.chatby_type = ?))',[true,$this->id,'App\Model\User',$shop->id,'Cp\Smartshop\Model\Shop', true, $shop->id,'Cp\Smartshop\Model\Shop',$this->id,'App\Model\User']);
        })->first();
  }

  // public function msgPublishedBy()
  // {
  //   return $this->morphMany('Cp\Chat\Model\ChatPublish', 'publishedby');
  // }

  // public function msgPublishedTo()
  // {
  //   return $this->morphMany('Cp\Chat\Model\ChatPublish', 'publishedto');
  // }

  // public function chatPublishedTo()
  // {
  //   return $this->morphMany('Cp\Chat\Model\ChatPublish', 'publishedto');
  // }

  public function chatPublishedBy()
  {
    return $this->morphMany('Cp\Chat\Model\ChatPublish', 'publishedby');
  }


  public function selectedName()
    {
       return $this->name;
    }

    //visitor 
    // public function visitors()
    // {
    //     return $this->hasMany('App\Model\UserVisitor', 'visitor_id');
    // }

    public function iAmVisitedBy(User $user)
    {
        if($user->id !== $this->id)
        {
            $v = $this->userVis()->where('visitor_id', $user->id)->first();
          if ($v) 
          {
            // $this->visitors()->updateExistingPivot($user->id, ['visits'=> $v->pivot->visits +1]);
            $v->visits++;
            $v->updated_at = Carbon::now();
            $v->save();


            
          } else {
            // $v = $this->visitors()->attach($user, ['visits' => 1]);

            $v = $this->userVis()->create([
                'visits'=>1,
                'visitor_id'=> $user->id
            ]);

            $this->touchMainsIncrement();
              $ntfy = $v->notifications()->create([
                  'userto_id'=>$this->id,
                  'userby_id'=> $user->id,
                  'description'=> 'created',                
              ]); 
          }

            return $v;
        }

        return true;
        
    }

    public function userVis()
    {
        return $this->hasMany('App\Model\UserVisitor', 'user_id');
    }
    
    public function visitors()
    {
        return $this->belongsToMany('App\Model\User', 'user_visitors', 'user_id', 'visitor_id')
        ->withPivot(['visits', 'updated_at'])
        ->whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
        ->withTimestamps()
        ->orderBy('pivot_updated_at','desc');
    }

    public function myVisitors()
    {
        return $this->visitors()->paginate(24);
    }

    public function myRelatedUsers($type)
    {
        if($type == 'visitor')
        {
            return $this->visitors()
            // ->whereDoesntHave('blockerOf',function($query){
            //     $query->where('user_id', $this->id);
            // })
          //   ->whereHas('userPictures', function ($query) {
          //   $query->where('image_type', 'profilepic');
          //   $query->where('checked', true);
          // })
            ->paginate(24);
        }

        elseif ($type == 'contacts') {

            return $this->myContacts()
            // ->whereDoesntHave('blockerOf',function($query){
            //     $query->where('user_id', $this->id);
            // })
          //   ->whereHas('userPictures', function ($query) {
          //   $query->where('image_type', 'profilepic');
          //   $query->where('checked', true);
          // })
            ->paginate(24);
            
        }

        elseif($type == 'block')
        {
            return $this->blockss()->paginate(24);
        }

        if($type == 'preference')
        {   
          return $this->searchPreferenceUsers(24);    
        }

        if($type == 'automail')
        {
            return $this->searchPreferenceAutomailUsers()
            ->paginate(4);
        }

        else
        {
            return $this->favs()
            // ->whereDoesntHave('blockerOf',function($query){
            //     $query->where('user_id', $this->id);
            // })
          //   ->whereHas('userPictures', function ($query) {
          //   $query->where('image_type', 'profilepic');
          //   $query->where('checked', true);
          // })
            ->paginate(24);
        }
    }


    public function searchPreferenceUsers($paginate)
    {
      // dd(Auth::user()->searchTerm);
      $searchTerm = $this->searchTerm;
      $now = Carbon::now();
      $minAgeDate = $now->SubYear($searchTerm->min_age)->toDateString();
      $maxAgeDate = $now->SubYear($searchTerm->max_age)->toDateString();
      // dd($searchTerm->user_status);
 
      $users = User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
      ->where('dob', '<=', $minAgeDate)
      ->where('dob', '>=', $maxAgeDate)
      // ->where('gender', $this->lookingFor())
      ->where('gender', $this->oltGender())

      

        ->where(function ($query) use ($searchTerm) {
                
            
              $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
              {

                if ($searchTerm->marital_status)  
                {
 
                    $q->where('marital_status', $searchTerm->marital_status);       
                }

                if ($searchTerm->do_u_have_children)  
                {
                  
     
                        $q->where('do_u_have_children', $searchTerm->do_u_have_children);       
                }

                if ($searchTerm->education_level)  
                {
                    $q->where('education_level', $searchTerm->education_level);    
                }

                if ($searchTerm->min_height && $searchTerm->max_height)  
            {
              

                $minH = UserSettingItem::where('field_id', 15)->where('title', $searchTerm->min_height)->first();

                $maxH = UserSettingItem::where('field_id', 15)->where('title', $searchTerm->max_height)->first();

                if($minH && $maxH)
                {
                    $heights = UserSettingItem::where('field_id', 15)->whereBetween('id', [$minH->id, $maxH->id])->pluck('title');

                    $q->whereIn('height',$heights);                    
                }
              
            }

              });


            

            if ($searchTerm->religion)  
            {
                $query->where('religion', $searchTerm->religion);    
            }

            // if ($searchTerm->social_order)  
            // {
            //     $query->where('social_order', $searchTerm->social_order);    
            // }

            


            
        })



        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->do_u_have_children)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
 
        //             $q->where('do_u_have_children', $searchTerm->do_u_have_children);       
        //       });
        //     }
        // })

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->religion)  
        //     {
        //         $query->where('religion', $searchTerm->religion);    
        //     }
        // })

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->social_order)  
        //     {
        //         $query->where('social_order', $searchTerm->social_order);    
        //     }
        // })

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->min_height && $searchTerm->max_height)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {

        //         $minH = UserSettingItem::where('field_id', 15)->where('title', $searchTerm->min_height)->first();

        //         $maxH = UserSettingItem::where('field_id', 15)->where('title', $searchTerm->max_height)->first();

        //         if($minH && $maxH)
        //         {
        //             $heights = UserSettingItem::where('field_id', 15)->whereBetween('id', [$minH->id, $maxH->id])->pluck('title');

        //             $q->whereIn('height',$heights);                    
        //         }
        //       });
        //     }
        // })




        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        // })

        ->where('img_name', '<>', null)



        // ->where('country', 'like' ,"%".$searchTerm->country."%")

      // ->where(function ($query) use ($searchTerm) {
      //           $query->orWhere('country_other', 'like', "%".$searchTerm->country_other."%")
      //                 ->orWhereNull('country_other');
      //       })


      //skipped latest

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->my_profession)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
                
        //         $pros = explode(", ",$searchTerm->my_profession);

        //             $q->whereIn('my_profession', $pros);         
        //       });
        //     }
        // })



      //skipped latest

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->country_of_residence)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
                
        //         $pros = explode(", ",$searchTerm->country_of_residence);

        //             $q->whereIn('country_of_residence', $pros);         
        //       });
        //     }
        // })


      //skipped latest

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->education_level)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
                
        //         $pros = explode(", ",$searchTerm->education_level);

        //             $q->whereIn('education_level', $pros);         
        //       });
        //     }
        // })

        
        //skipped latest

        // ->where(function ($q) use ($searchTerm) {
                
        //     if ($searchTerm->country or $searchTerm->country_other)  
        //     {
        //           $q->where('country', 'like' ,"%".$searchTerm->country."%");

        //         $q->where(function ($query) use ($searchTerm) {
        //             $query->orWhere('country_other', 'like', "%".$searchTerm->country_other."%")
        //                   ->orWhereNull('country_other');
        //         });
        //     }
        // })


        //skipped latest

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->skin_color)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
 
        //             $q->where('skin_color', $searchTerm->skin_color);       
        //       });
        //     }
        // })



        //skipped latest

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->body_build)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
 
        //             $q->where('body_build', $searchTerm->body_build);       
        //       });
        //     }
        // })


        //skipped latest

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->smoke_status)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
 
        //             $q->where('smoke_status', $searchTerm->smoke_status);       
        //       });
        //     }
        // })


        //skipped latest

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->alcohol_status)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
 
        //             $q->where('alcohol_status', $searchTerm->alcohol_status);       
        //       });
        //     }
        // })


        //skipped latest

        // ->where(function ($query) use ($searchTerm) {
                
        //     if ($searchTerm->mother_tongue)  
        //     {
        //       $query->whereHas('personalInfo', function ($q) use ($searchTerm) 
        //       {
 
        //             $q->where('mother_tongue', $searchTerm->mother_tongue);       
        //       });
        //     }
        // })



        //skipped latest

      // ->where(function ($query) use ($searchTerm)
      // {
      //   if ($searchTerm->user_status == 'Online') 
      //   {
      //     $query->where('updated_at', '>', Carbon::now()->subMinutes(4));
      //   } elseif ( $searchTerm->user_status == 'New')  {

      //     //one month old users are considered as new
      //     $query->where('created_at', '>', Carbon::now()->subDays(29));
      //   }

      //   // elseif ( $searchTerm->user_status == 'With Picture')  
      //   // {

      //   //   //one month old users are considered as new
      //   //   $query->whereHas('userPictures', function ($q) {
      //   //       $q->where('image_type', 'profilepic');
      //   //       $q->where('checked', true);
      //   //   });



      //   // }

      //   elseif ( $searchTerm->user_status == 'Premium') 
      //   {
      //     // $query->where('expired_at', '>=', Carbon::now()); 
      //     $query->whereDate('expired_at', '>=', date('Y-m-d'));
      //     $query->where('package', '>=', 1);
      //   }


          
      // })
      ->orderBy('updated_at', 'desc')
      ->paginate($paginate);
      return $users;
      // ->paginate(24);

      // return $users;
    }

    public function searchPreferenceAutomailUsers()
    {
        $users = $this->searchPreferenceUsers(200)

        ->whereDoesntHave('automailItems',function($query){
                $query->where('user_id', $this->id);
            });
        // ->whereDoesntHave('automailItems', function($qq){
        //     $qq->where('user_second_id', $this->id);
        // });
      return $users;
    }

    public function searchTermBasic()
    {
        $searchTerm = $this->searchTerm;
            if($searchTerm and
            // $searchTerm->my_profession and
            // $searchTerm->country_of_residence and
            // $searchTerm->education_level and
            // $searchTerm->marital_status and
            // $searchTerm->do_u_have_children and
            // $searchTerm->religion and
            $searchTerm->min_height and
            $searchTerm->max_height)
        {
            return true;
        }
        return false;
    }

    public function latest4Visitors()
    {
        return $this->visitors()


        ->take(4)->get();
    }

    public function hasMoreVisitor()
    {
        if($this->visitors()->count() > 4)
        {
            return true;
        }

        return false;
    }

    public function isOnline()
    {
        if($this->loggedin_at)
        {
            $d = $this->loggedin_at->diffInMinutes(Carbon::now());

            if ($d < 4) {
                return true;
            }
        }
        

        return false;
    }

    public function age()
    {
        return Carbon::parse($this->dob)->diffInYears(Carbon::now());
    }

    public function packageDuration()
    {
        if($this->expired_at < Carbon::now())
        {
            return 0;
        }
        else
        {
            return Carbon::parse($this->expired_at)->diffInDays(Carbon::now()) + 1;
        }
    }

    public function myPackage()
    {
        if($this->packageDuration() > 0)
        {
            if(!$this->package)
            {
                return 'Free Package';
            }else
            {
                return $this->memPackage->package_title;
            }
        }
        return 'Subscriber';
    }

    public function contactLimit()
    {
        if($this->isPaidAndValidate())
        {
            $a = $this->memPackage->contact_view_limit - $this->cont()->count();
            if($a > 0)
            {
                return $a;
            }
        }
        return 0;        
    }

    public function isValidate()
    {
        if($this->expired_at)
        {
            if (date('Y-m-d', strtotime($this->expired_at->addDay()))  >= date('Y-m-d', strtotime(Carbon::now())) ) {
                return true;
            }
        }
        

        return false;
    }

    public function isPaidAndValidate()
    {
        if($this->expired_at and ($this->package > 0))
        {
            if (date('Y-m-d', strtotime($this->expired_at->addDay()))  >= date('Y-m-d', strtotime(Carbon::now())) ) {
                return true;
            }
        }
        return false;
    }

    //tmm
    public function basicInfoStatus()
    {
        if ($this->checked) {
            return 'Checked';
        }
        return 'Pending';
    }

    //tmm
    public function ppStatus()
    {
        if($this->uploadedPP())
        {
            if ($this->uploadedPP()->checked) {
                return 'Checked';
            }
            return 'Pending';
        }
        return 'Not set yet';
    }

    public function cvStatus()
    {
        if($this->file_name)
        {
            if ($this->cv_checked) {
                return 'Checked';
            }
            return 'Pending';
        }
        return 'Not set yet';
    }

    public function contactInfoStatus()
    {
        if($this->contactInfo)
        {
            if ($this->contactInfo->checked) {
                return 'Checked';
            }
            return 'Pending';
        }
        return 'Not set yet';
    }

    public function aboutMe()
    {
        if($this->contactInfo)
        {
            if ($this->contactInfo->about_me) {
                return $this->contactInfo->about_me;
            }
        }
        return 'Welcome to my profile.';
    }

    //tmm
    public function personalInfoStatus()
    {
        if($this->personalInfo)
        {
            if ($this->personalInfo->checked) {
                return 'Checked';
            }
            return 'Pending';
        }
        return 'Not set';
    }

    //tmm
    public function personalActivityStatus()
    {
        if($this->personalActivity)
        {
            if ($this->personalActivity->checked) {
                return 'Checked';
            }
            return 'Pending';
        }
        return 'Not set';
    }

    //payments
    public function payments()
    {
        return $this->hasMany('App\Model\UserPayment');
    }

    public function myPayments()
    {
        return $this->payments()->latest()->paginate(24);
    }

    public function latestPendingPayment()
    {
        return $this->payments()->where('status', 'pending')->latest()->first();
    }

    //comments

    public function myComments()
    {
        return $this->hasMany('App\Model\UserComment');
    }

    public function adminUserComments()
    {
        return $this->myComments()
        ->where('addedby_id', $this->id)
        ->latest()
        ->paginate(100);
    }

    public function latestProfiles()
    {
        $users = User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
      ->where('gender', $this->oltGender())
        // ->where('gender', $this->lookingFor())
        ->where('img_name', '<>', null)
        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
      ->orderBy('created_at', 'desc')
      ->paginate(24);

      return $users;
    }

    public function latestProfilesForAutomail(UsersForAutoMail $uam)
    {
        $users = User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
      ->where('gender', $this->oltGender())
        // ->where('gender', $this->lookingFor())
        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })

        ->where('img_name', '<>', null)

      ->whereNotIn('id', $uam->items()->where('user_id', $this->id)->pluck('user_second_id'))
      ->orderBy('created_at', 'desc')
      ->paginate(4);


      foreach ($users as $u) 
      {
          $item = new UsersForAutoMailItem;
          $item->automail_id = $uam->id;
          $item->user_id = $this->id;
          $item->user_second_id = $u->id;
          $item->save();
      }

      $uam->mail_count = $uam->mail_count + 1;
      $uam->updated_at = Carbon::now();
      $uam->save();

      return $users;
    }


    public function updateAdminData()
    {
        $ad = AdminData::first();
        if($ad)
        {
            $twoMinSub = Carbon::now()->subMinutes(2);

            if($ad->updated_at < $twoMinSub)
            {
                $ad->image_pending = $this->ppPendingCount();
                $ad->not_checked = $this->final_check_pending_count();
                $ad->less_than_ten = $this->validity_10_count();
                $ad->free_pack = $this->free_pack_count();
                $ad->pending_payment = $this->pendingPaymentCount();
                $ad->proposal_unchecked = $this->proposals_unchecked_count();
                $ad->create_today = $this->today_registered();
                $ad->create_this_month = $this->this_month_registered();
                $ad->deactive_today = $this->today_inactive();
                $ad->deactive_this_month = $this->this_month_inactive();

                $ad->updated_at = Carbon::now();
                $ad->save();
            }
        }
    }

    public function updateAdminDashboardData()
    {
        $ad = AdminData::first();
        if($ad)
        {
            $twoMinSub = Carbon::now()->subMinutes(2);

            if($ad->dashboard_updated_at < $twoMinSub)
            {
                $ad->all_users =  $this->all_users();
                $ad->online_users =  $this->online_users();
                $ad->female_users =  $this->female_users();
                $ad->male_users =  $this->male_users();
                $ad->subscribers =  $this->subscribers();
                $ad->diamond_plus_users =  $this->diamond_plus_users();
                $ad->diamond_users =  $this->diamond_users();
                $ad->golden_plus_users =  $this->golden_plus_users();
                $ad->golden_users =  $this->golden_users();
                $ad->order_by_age_users =  $this->order_by_age_users();

                $ad->deactivate_users = $this->deactivate_users();
                $ad->complains = $this->complains();
                $ad->pending_payment_today = $this->pending_payment_today();
                $ad->pending_payment_this_month = $this->pending_payment_this_month();
                $ad->paid_payment_today = $this->paid_payment_today();
                $ad->paid_payment_this_month = $this->paid_payment_this_month();
                $ad->cv_new_pending = $this->cv_new_pending();
                $ad->log_user_count = $this->log_user_count();
                $ad->logs_count = $this->logs_count();

                $ad->dashboard_updated_at = Carbon::now();
                $ad->updated_at = $ad->updated_at;
                $ad->save();
            }
        }   
    }

    public function adminData()
    {
        return AdminData::first();
    }


    public function deactivate_users()
    {
        return User::withoutGlobalScopes()
            ->where('active', false)->count();
    } 
    public function complains()
    {
        return Report::where('status', 'pending')->count();
    } 
    public function pending_payment_today()
    {
        return UserPayment::where('status', 'pending')
            ->where('created_at', Carbon::today())->count();
    } 
    public function pending_payment_this_month()
    {
        return UserPayment::where('status', 'pending')->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->count();
    } 
    public function paid_payment_today()
    {
        return UserPayment::where('status', 'paid')
            ->where('updated_at', Carbon::today())->count();
    } 
    public function paid_payment_this_month()
    {
        return UserPayment::where('status', 'paid')->whereYear('updated_at', date('Y'))
            ->whereMonth('updated_at', date('m'))
            ->count();
    } 
    public function cv_new_pending()
    {
        return User::whereNotNull('file_name')->where('cv_checked', 0)->count();
    } 
    public function log_user_count()
    {
        return User::withoutGlobalScopes()->has('logs')->count();
    } 
    public function logs_count()
    {
        return UserLog::count();
    } 

    public function all_users()
    {
        return User::withoutGlobalScopes()->count();
    }

    public function online_users()
    {
        return User::where('loggedin_at', '>=', Carbon::now()->subMinutes(4))->count();
    }

    public function female_users()
    {
        return User::where('gender', 'Female')
            // ->where('package', '<=', 0)
            ->where(function($s){
                $s->where('expired_at', '<', Carbon::now());
                $s->orWhereNull('expired_at');
            })
            ->count();
    }

    public function male_users()
    {
        return User::where('gender', 'Male')
            ->where(function($s){
                $s->where('expired_at', '<', Carbon::now());
                $s->orWhereNull('expired_at');
            })
            ->count();
    }

    public function subscribers()
    {
        return User::where('expired_at', '<=', Carbon::now())->orWhereNull('expired_at')->count();
    }

    public function diamond_plus_users()
    {
        return User::whereIn('package', [4,8])
            ->where('expired_at', '>=', Carbon::now())->count();
    }

    public function diamond_users()
    {
        return User::whereIn('package', [3,7])
            ->where('expired_at', '>=', Carbon::now())->count();
    }

    public function golden_plus_users()
    {
        return User::whereIn('package', [2,6])
            ->where('expired_at', '>=', Carbon::now())->count();
    }

    public function golden_users()
    {
        return User::whereIn('package', [1,5])
            ->where('expired_at', '>=', Carbon::now())->count();
    }

    public function order_by_age_users()
    {
        return User::orderBy('dob', 'desc')->count();
    }





    public function ppPendingCount() #profile picture pending count
    {
        return User::whereHas('userPictures', function ($query) {
            $query->where('image_type', 'profilepic');
            $query->where('checked', false);
            $query->where('autoload', true);
          })->count();
    }

    public function validity_10_count()
    {
        return User::where('expired_at', '>=', Carbon::now())
            ->where('expired_at', '<', Carbon::now()->addDays(10))->count();
    }

    public function free_pack_count()
    {
        return User::where('package', 0)
            ->where('expired_at', '>=', Carbon::now())
            ->where('expired_at', '<', Carbon::now()->addDays(14))->count();
    }

    public function today_registered()
    {
        return User::whereDate('created_at', Carbon::today())->count();
    }

    public function this_month_registered()
    {
        return User::whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))->count();
    }

    public function today_inactive()
    {
        return User::withoutGlobalScopes()->where('active', false)
        ->whereDate('inactive_at', Carbon::today())->count();
    }

    public function this_month_inactive()
    {
        return User::withoutGlobalScopes()->where('active', false)->whereYear('inactive_at', date('Y'))
            ->whereMonth('inactive_at', date('m'))
            ->count();
    }

    public function pendingPaymentCount()
    {
        return UserPayment::where('status', 'pending')->count();
    }

    public function final_check_pending_count()
    {
        return User::has('personalInfo')
            ->has('personalActivity')
            ->where('final_checked', false)->count();
    }

    public function proposals_unchecked_count()
    {
        return UserProposal::has('user')->has('userSecond')->where('checked', false)->count();
    }

    public function contactInfoViewPermissionOf(User $user)
    {
        if (($this->sentAndAcceptProposalTo($user)) or 
            ($user->sentAndAcceptProposalTo($this)) or 
            ($this->id == $user->id)) 
        {

            return true;
        }

        return false;
    }


    public function postStatus()
    {
        if($this->isBlogAdmin())
        {
            return 'By Admin';
        }
        // else if($this->isEditor())
        // {
        //     return 'By Editor';
        // }
        // else if($this->isDistEditor())
        // {
        //     return 'District Repre. / '. $this->name;
        // }
        // else if($this->isThanaEditor())
        // {
        //     return 'Thana Repre. / '.$this->name;
        // }
        return '';
    }

    //sms //quick sms //bulk
  public function smsBulks() //businessSmsBulks
  {
    return SmsContactBulk::latest()->paginate(4);
  }

  public function quickSmsBulks()
  {
    return QuickSmsContactBulk::where('status','sent')->latest()->paginate(4);
  }



  public function smsDraftBulks()
  {
    return QuickSmsContactBulk::where('status','draft')->latest()->paginate(4);
  }

  public function uploadedContactDraftBulks()
  {
    return SmsUploadedContactBulk::where('status','draft')->latest()->paginate(4);
  }

  public function uploadedSmsBulks()
  {
    return SmsUploadedContactBulk::where('status','sent')->latest()->paginate(4);
  }

  public function isOffline()
  {
      return $this->user_type == 'offline' ? true : false;
  }

  public function fileIsImage()
  {
      if($this->file_ext == 'jpg' or 
        $this->file_ext == 'jpeg' or 
        $this->file_ext == 'png' or 
        $this->file_ext == 'bmp' or 
        $this->file_ext == 'gif')
      {
        return true;
      }
      return false;
  }

  public function fileIsPdf()
  {
      if( $this->file_ext == 'pdf')
      {
        return true;
      }
      return false;
  }

  public function fileIsWord()
  {
      if($this->file_ext == 'doc' or $this->file_ext == 'docx')
      {
        return true;
      }
      return false;
  }


  public function sendSmsToNewUserWithPassword()
  {
      $to = bdMobile($this->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }

        // $msg = "Congratulations, Your account is ready to use. Your Temporary Password is {$this->password_temp}. Hope you will find your life partner here. bridegroombd.com"; //150 characters here
        $msg = "Congratulations, Your account is ready to use. Hope you will find your life partner here. bridegroombd.com"; //150 characters here

        $url = smsUrl($to,$msg);

        // $url = "http://sms.multisoftbd.com/smsapi?api_key={$api}&type=text&contacts={$to}&senderid={$smsNonMaskingCode}&msg={$msg}";


        //API URL (GET & POST) : http://sms.multisoftbd.com/smsapi?api_key=(APIKEY)&type=text&contacts=(NUMBER)&senderid=(Approved Sender ID)&msg=(Message Content)
        
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);

                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {

            } catch (\GuzzleHttp\Exception\ClientException $e) {

            }
  }




  public function passwordResetSmsSend()
  {
        $to = bdMobile($this->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }

 
        $msg = $this->password_temp .' is temporary password for your account ('.$this->email .') in https://bridegroombd.com.';
        
        $url = smsUrl($to,$msg);
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);

                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {

            } catch (\GuzzleHttp\Exception\ClientException $e) {

            }
  }

  public function finalCheckedCompletedSms()
  {
        $to = bdMobile($this->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }

        $msg = 'Dear user, your account checking process successfully completed. Login at https://bridegroombd.com and stay connected.';
        
        $url = smsUrl($to,$msg);

        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);

                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {

            } catch (\GuzzleHttp\Exception\ClientException $e) {

            }
  }

  public function smsSendToUser()
  {
        $to = bdMobile($this->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }

        // $masking = smsMaskingCode();
        // $apiKey = smsApiKey();
        $msg = 'Dear user, bridegroombd.com matching your partner with 100% guarantee. You can get any membership package and enjoy our features. Thank you.'; //149 characters here
        
        $url = smsUrl($to,$msg);
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);

                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {

            } catch (\GuzzleHttp\Exception\ClientException $e) {

            }
  }

  public function sendCustomSmsToUser($msg)
  {
        $to = bdMobile($this->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }

        // $masking = smsMaskingCode();
        // $apiKey = smsApiKey();
        $msg = 'Dear user, bridegroombd.com matching your partner with 100% guarantee. You can get any membership package and enjoy our features. Thank you.'; //149 characters here

        $url = smsUrl($to,$msg);
        
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);

                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {

            } catch (\GuzzleHttp\Exception\ClientException $e) {

            }
  }
  //sms end

  //automail

  public function automailItems()
  {
      return $this->hasMany('App\Model\UsersForAutoMailItem', 'user_id');
  }
  public function listForAutoMail()
  {
      return $this->hasMany('App\Model\UsersForAutoMail');
  }

  public function automailSend(UsersForAutoMail $uam)
  {
        
        $uam->mail_count = $uam->mail_count + 1;
        $uam->save();

        if((env('APP_ENV') == 'production') && $this->email)
        {
            Mail::send('emails.automails.mail', ['uam'=>$uam], function ($message) use($uam) {
                // $message->from(senderMails(), url('/'));
                // $message->to('masudbdm@gmail.com', url('/'))
                $message->to($this->email, url('/'))
                ->subject('Bridegroom Profile Matches');
            });
        }
  }
  //automail

  //proposal sent sms
  public function proposalSentSms($proposal)
  {
        $to = bdMobile($proposal->userSecond->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }

        // $masking = smsMaskingCode();
        // $apiKey = smsApiKey();
        $msg = str_limit($proposal->message,70,'...') . ' Please login and see the new proposal of username '. $proposal->user->username .' at ' . $_SERVER['SERVER_NAME']; //149 characters here

        $url = smsUrl($to,$msg);
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
            } catch (\GuzzleHttp\Exception\ClientException $e) {
            }
  }
  //proposal sent sms

  //proposal sent email
  public function proposalSentEmail($proposal)
  {
      if((env('APP_ENV') == 'production'))
        {
            Mail::send('emails.automails.proposalSentEmail', ['proposal'=>$proposal], function ($message) use($proposal) {
                // $message->from(senderMails(), url('/'));
                $message->to($proposal->userSecond->email, url('/'))
                ->subject('Proposal Sent to You at Bridegroombd');
            });
        }
  }
  //proposal sent email


  //deactivate sms send to user

  
  public function activateSmsSentToUser()
  {
        $to = bdMobile($this->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }

        // $masking = smsMaskingCode();
        // $apiKey = smsApiKey();


        $msg = "Dear User, your account in bridegroombd.com is activated again. You can login now and find your soulmate. To know more please contact +8801301213608."; //149 characters here

        $url = smsUrl($to,$msg);
        
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
            } catch (\GuzzleHttp\Exception\ClientException $e) {
            }
  }
  
  public function deactivateSmsSentToUser()
  {
        $to = bdMobile($this->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }
 
        $msg = "Dear User, your account in bridegroombd.com is temporarily deactivated. If you want to use your account again, please contact + 8801906300900"; //149 characters here

        $url = smsUrl($to,$msg);
        
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
            } catch (\GuzzleHttp\Exception\ClientException $e) {
            }
  }
  //deactivate sms send to user
  //deactivate email send to user
  public function deactivateEmailSentToUser(User $user)
  {
      if((env('APP_ENV') == 'production'))
        {
            Mail::send('emails.automails.deactivateEmailSentToUser', ['user'=>$user], function ($message) use($user) {
                // $message->from(senderMails(), url('/'));
                $message->to($user->email, url('/'))
                ->subject('Your Account Temporarily Deactivated in bridegroombd.com');
            });
        }
  }

  //deactivate email send to user

//activated email send to user
  public function activateEmailSentToUser(User $user)
  {
      if((env('APP_ENV') == 'production'))
        {
            Mail::send('emails.automails.activateEmailSentToUser', ['user'=>$user], function ($message) use($user) {
                // $message->from(senderMails(), url('/'));
                $message->to($user->email, url('/'))
                ->subject('Your account activated again in bridegroombd.com');
            });
        }
  }

  //activate email send to user




public function sendSmsWithMessage($text)
    {
        ########### mobile sms start here ############

        $to = bdMobile($this->mobile);

        if(strlen($to) != 13)
        {
            return true;
        }



        // $masking = smsMaskingCode();
        // $apiKey = smsApiKey();
        $msg = str_limit($text,156,'..');
        
        $url = smsUrl($to,$msg);
        // $url = "http://connect.primesoftbd.com/smsapi/non-masking?api_key={$apiKey}&smsType=text&mobileNo={$to}&smsContent={$msg}";
        // $url = "http://connect.primesoftbd.com/smsapi/masking?api_key={$apiKey}&smsType=text&maskingID={$masking}&mobileNo={$to}&smsContent={$msg}";
        $client = new Client();
             
        try {
                $r = $client->request('GET', $url);                
            } catch (\GuzzleHttp\Exception\ConnectException $e) {
            } catch (\GuzzleHttp\Exception\ClientException $e) {
            }
        
        ########### mobile sms end here ############
    }

  public function sendEmailWithMessage($text)
    {
        ########### email start here ############
        if (env('APP_ENV') == 'production') 
        {
            $userName = $this->name;
            Mail::send('emails.notify.to_user', ['userName' => $userName, 'text'=> $text], function ($message) use ($userName, $text) {

                // $message->from(senderMails(), 'Bridegroombd Message');

                $message->to($this->email, $this->name)
                ->subject('Bridegroombd Message');
            });
            return true;
        }
    


        ########### email end here ############
    }



  //touch //touches
  public function touchesAll()
  {
    return $this->hasMany('App\Model\Touch', 'user_id');
  }

  public function touchMains()
  {
    return $this->touchesAll()
    ->where('notify_type', 'main')->value('notify_value');
  }

  public function touchMainsIncrement()
  {
    $record = $this->touchesAll()->where('notify_type', 'main')->firstOrCreate(['notify_type'=>'main']);
    $record->notify_value = $record->notify_value + 1;
    $record->save();
    return $record;
  }

  public function touchMainsDecrement()
  {
    $record = $this->touchesAll()->where('notify_type', 'main')->firstOrCreate(['notify_type'=>'main']);
    if($record->notify_value)
    {
        $record->notify_value = $record->notify_value - 1;
        $record->save();
    }

    return $record;
  }

  public function touchMainsDelete()
  {
    return $this->touchesAll()
    ->where('notify_type', 'main')
    ->update(['notify_value'=>null]);
  }

  public function touchMsg()
  {
    return $this->touchesAll()
    ->where('notify_type', 'msg')->value('notify_value');
  }

  public function touchMsgIncrement()
  {
    $record = $this->touchesAll()->where('notify_type', 'msg')->firstOrCreate(['notify_type'=>'msg']);
    $record->notify_value = $record->notify_value + 1;
    $record->save();
    return $record;
  }

  public function touchMsgDecrement()
  {
    $record = $this->touchesAll()->where('notify_type', 'msg')->firstOrCreate(['notify_type'=>'msg']);
    if($record->notify_value)
    {
        $record->notify_value = $record->notify_value - 1;
        $record->save();
    }

    return $record;
  }

  public function touchMsgDelete()
  {
    return $this->touchesAll()
    ->where('notify_type', 'msg')
    ->update(['notify_value'=>null]);
  }




  //notification


  public function notifications()
  {
    return $this->hasMany('App\Model\Notification', 'userto_id');
  }

  public function myNotifications()
  {
      return $this->notifications()->latest()->paginate(20);
  }


  //notification

  //cv mail
  public function mailWithCv()
  {
      return $this->hasMany('App\Model\UserMail', 'user_id');
  }

  public function getCvEmailFromUser($fromUser)
  {
        if((env('APP_ENV') == 'production') && $this->email)
        {
            Mail::send('emails.emailWithCv', ['fromUser'=>$fromUSer], function ($message) use($fromUser) {
                $message->to($this->email, url('/'))
                ->subject('Bridegroombd Profile Matches');

                if($fromUser->file_name)
                {
                    $path = url("storage/users/cv/{$fromUser->file_name}");
                    $message->attach($path);
                }                
            });
        }
  }

  public function sendUserCvToEmail($email, $users)
  {
      if((env('APP_ENV') == 'production') && $email)
        {
            Mail::send('emails.userCvToEmail', [
                'users'=>$users, 
                'email'=>$email
            ], function ($message) use($email, $users) {
                // $message->from(senderMails(), url('/'));
                $message->to($email, url('/'))
                ->subject('Bridegroombd Profile Matches');

                if (is_array($users) || is_object($users)) 
                {
                    foreach ($users as $user) 
                    {
                        $path = url("storage/users/cv/{$user->file_name}");
                        $message->attach($path);
                    }
                }

                
            });
        }
  }


    public function sendUserProfileToEmail($email, $users)
    {
        if((env('APP_ENV') == 'production') && $email)
        {
            Mail::send('emails.userProfileToEmail', [
                'users'=>$users, 
                'email'=>$email
            ], function ($message) use($email) {
                // $message->from(senderMails(), url('/'));
                $message->to($email, url('/'))
                ->subject('Bridegroombd Profile Matches');                
            });
        }
  }


     public function profilePoint()
    {
        $p = 0;

    if($this->name){
        $p = $p + 1;
    }
    if($this->mobile){
        $p = $p + 2;
    }
    if($this->guardian_mobile){
        $p = $p + 4;
    }
    if($this->email){
        $p = $p + 1;
    }
    if($this->gender){
        $p = $p + 4;
    }
    if($this->country){
        $p = $p + 2;
    }
    if($this->dob){
        $p = $p + 4;
    }
    if($this->img_name){
        $p = $p + 5;
    }
    if($this->file_name){
        $p = $p + 4;
    }

    if($this->isPaidAndValidate()){

        $p = $p+10;

    }
    if($ci = $this->contactInfo){

        if($ci->convenient_time_to_call)
        {
            $p = $p + 4;
        }
        if($ci->name_of_contact_person)
        {
            $p = $p + 4;
        }
        if($ci->relation_with_contact_person)
        {
            $p = $p + 4;
        }
        if($ci->present_address)
        {
            $p = $p + 4;
        }
        if($ci->permanent_address)
        {
            $p = $p + 4;
        }

        //57

    }
    if($pi = $this->personalInfo){

        if($pi->marital_status)
        {
            $p = $p + 2;
        }
        if($pi->height)
        {
            $p = $p + 2;
        }
        if($pi->zodiac_sign)
        {
            $p = $p + 2;
        }
        if($pi->education_level)
        {
            $p = $p + 2;
        }
        if($pi->major_subject)
        {
            $p = $p + 2;
        }
        if($pi->my_profession)
        {
            $p = $p + 2;
        }
        if($pi->father_name)
        {
            $p = $p + 2;
        }
        if($pi->father_occupation)
        {
            $p = $p + 2;
        }
        if($pi->mother_name)
        {
            $p = $p + 2;
        }
        if($pi->mother_occupation)
        {
            $p = $p + 2;
        }
        if($pi->district)
        {
            $p = $p + 2;
        }
        if($pi->thana)
        {
            $p = $p + 2;
        }

        //81

    }
    if($this->personalActivity)
    {
        $p = $p + 5;

        //86
    }
    if($st = $this->searchTerm)
    {

        if($st->min_age)
        {
            $p = $p + 1;
        }
        if($st->max_age)
        {
            $p = $p + 1;
        }
        if($st->country)
        {
            $p = $p + 1;
        }
        if($st->my_profession)
        {
            $p = $p + 1;
        }
        if($st->marital_status)
        {
            $p = $p + 1;
        }
        if($st->min_height)
        {
            $p = $p + 1;
        }
        if($st->max_height)
        {
            $p = $p + 1;
        }
        if($st->district)
        {
            $p = $p + 1;
        }
        if($st->religion)
        {
            $p = $p + 1;
        }

    }
    //95



    if($this->visitors()->count())
    {
        $p = $p + 5;
    }

    //100





        return $p;
    }

    public function logs()
    {
        return $this->hasMany('App\Model\UserLog', 'user_id')->orderBy('completed')->latest();
    }

    public function incompleteLogCount()
    {
        return $this->logs()->where('completed', 0)->count();
    }

    public function completedLogCount()
    {
        return $this->logs()->where('completed', 1)->count();
    }


   public function moreuser(){
    //   return  User::inRandomOrder()->limit(4)->get();
     return User::whereDoesntHave('blockerOf',function($query){
                $query->where('user_id', $this->id);
            })
        ->whereDoesntHave('blockss', function($qq){
            $qq->where('user_second_id', $this->id);
        })
      ->where('gender', $this->oltGender())
        // ->where('gender', $this->lookingFor())
        ->where('img_name', '<>', null)
        // ->whereHas('userPictures', function ($query) {
        //     $query->where('image_type', 'profilepic');
        //     $query->where('checked', true);
        //   })
      ->inRandomOrder()
      ->paginate(24);
  }


}
