@if((Auth::user()->contactInfoViewPermissionOf($user) and Auth::user()->isPaidAndValidate()) or (Auth::user()->isMyContact($user) and Auth::user()->isPaidAndValidate()) or (Auth::user()->isAdmin()) or (Auth::id() == $user->id))
<div class="w3-border-top w3-border-light-gray">
	<h3 class="mt-0">Contact Information</h3>
	<div style="min-height: 200px;">


	@if($user->id == Auth::id())
	<small class="help-block"> Users related with proposal (Accepted) can see your contact Information</small> <br>
	@endif

		
<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Email
</div>
  <div class="w3-rest text-left">
    : 
    {{ $user->email }}
  </div>
</div>

<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Mobile
</div>
  <div class="w3-rest text-left">
    : 
    {{ $user->mobile }}
  </div>
</div>

		@if($user->contactInfo)


<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Alternative Email
</div>
  <div class="w3-rest text-left">
  	: 
  	{{ $user->contactInfo->alternative_email }}
  </div>
</div>

<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Alternative Mobile
</div>
  <div class="w3-rest text-left">
  	: 
  	{{ $user->contactInfo->alternative_mobile }}
  </div>
</div>

<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Name of Contact Person
</div>
  <div class="w3-rest text-left">
  	: 
  	{{ $user->contactInfo->name_of_contact_person }}
  </div>
</div>

<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Relation with Contact Person
</div>
  <div class="w3-rest text-left">
  	: 
  	{{ $user->contactInfo->relation_with_contact_person }}
  </div>
</div>

<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Present Address
</div>
  <div class="w3-rest text-left">
  	: 
  	{{ $user->contactInfo->present_address }}
  </div>
</div>

<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Permanent Address
</div>
  <div class="w3-rest text-left">
  	: 
  	{{ $user->contactInfo->permanent_address }}
  </div>
</div>

<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  Family Background
</div>
  <div class="w3-rest text-left">
  	: 
  	{{ $user->contactInfo->about_family }}
  </div>
</div>

@if(Auth::user()->isAdmin())
<div class="w3-row">
  <div class="text-left w3-text-gray w3-small w3-col width-140">
  NID/Smart Card/Passport Number
</div>
  <div class="w3-rest text-left">
    : 
    {{ $user->contactInfo->nid }}
    <span class="help-block"> (You have seen this because you are admin.)</span>
  </div>
</div>
@endif


		@endif



	</div>
</div>
@endif