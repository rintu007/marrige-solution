@extends('bgbd.master')

@section('content')
  <!-- search banner start -->
  @include('bgbd.subpage.banner-sm')
  <!-- search banner end -->

  <section class=" pt-5 profile_section">
    <div class="container ">
      <!-- profile section start -->
      <div class="row pb-5 px-2 px-sm-0">

        <!-- profile menu section start -->
        <div class="col-sm-12 px-3 pl-sm-5 pb-5 pr-0">
          <div class="row ">
            <div class="col-12 col-sm-12 col-lg-4 py-5 py-sm-0  px-0 mx-0 display_profile">
              <div class="profile-picture">
                <img alt="{{$user->username}}"
                      class="img-fluid" src="{{ asset($user->latestCheckedPP()) }}" class="img-fluid  display_image" />
                

                <div class="display_overlay">
                  
                  <span>(BG{{ $user->username }})</span>
                </div>
              </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-8 px-2 px-sm-3">
              <table class="table table-responsible my_table">

                <tbody class="groom_table">
                  <tr class="table_align">
                    <td>
                      <span>Age & Gender: </span>
                      <span>{{ $user->age() }} years, {{ $user->gender }}</span>
                    </td>
                    <td>
                      <div class="activity">
                        Express Interest
                      </div>
                    </td>
                  </tr>
                  <tr class="table_align">
                    <td>
                      <span>Maritial Status: </span>
                      <span>{{ $user->marital_status }}</span>
                    </td>
                    <td><div class="activity">Contact Details</div></td>
                  </tr>
                  <tr class="table_align">
                    <td>
                      <span>Height: </span>
                      <span>{{ $user->height }}</span>
                    </td>
                    <td><div class="activity">Send a Messsages</div></td>
                  </tr>
                  <tr class="table_align">
                    <td>
                      <span>Education :  </span>
                      <span>
                        {{-- {!! isset($education[0]->education_level) ? educationLevel($education[0]->education_level) . " <small>(" . $education[0]->education_area . ")</small>":'N/A' !!} --}}
                        {{$user->education_level}}
                      </span>
                    </td>
                    <td><div class="activity">Add to Favourites</a></td>
                  </tr>
                  <tr class="table_align">
                    <td>
                      <span>Occupation : </span>
                      <span>
                        {{$user->profession}}
                      </span>
                    </td>
                    <td class="row_exception"><div class="activity">
                     
                     </td>
                  </tr>
                  <tr class="table_align">
                    <td>
                      <span>Home District : </span>
                      <span>
                        {{-- @php
                        if ($user->location_living_country > 0) {
                          if ($user->location_living_country == 1) {
                            $city = $user->location_living_city;

                            if ($user->location_upzila > 0) {
                              $city .= ', ' . \App\Common::upzila($user->location_upzila);

                            }
                            if ($user->location_district > 0) {
                              $city .= ', ' . \App\Common::district($user->location_district);
                            }
                            $city .= '.';
                          } else {
                            $city = $user->location_living_city . ', ' . \App\Common::country($user->location_living_country) . '.';
                          }

                        } else {
                          $city = '  N/A ';
                        }
                        @endphp --}}
                        
                        <span class="premium-member-only">Premium member only</span>
                      </span>
                    </td>
                    <td class="row_exception"><div class="activity">
                     {{-- Print this Profile      --}}
                  </a></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
          {{-- @if(($user->description)!='') --}}
            <div class="row pr-sm-3 pt-5">
              <div class="col-sm-12  groom_about_logedin pl-2  pl-sm-0	 ">
                <div class="about_groom_absolute">
                  <span class="table-header">About {{ ($user->gender == 'Male')?"Groom":"Bride" }}</span>
                </div>
              </div>
              <div class="col-sm-12 px-2 px-sm-0 groom_content">
                {{-- <p>{{ $user->description }}</p> --}}
              </div>
            </div>
          {{-- @endif --}}
          <!-- about groom end -->

          <!-- Basic Information start -->
          <div class="row pr-sm-3">
            <div class="col-sm-12  groom_about_logedin pl-2  pl-sm-0 ">
              <div class="about_groom_absolute">
                <span class="table-header">Basic Information</span>

              </div>

            </div>
            <div class="col-sm-12 px-2 px-sm-0 groom_content">
              <table class="table px-0 table-desktop">
                <tbody class="groom_table">
                  <tr>
                    <td width='25%'><b>Age</b></td>
                    <td width='25%'>{{ $user->age() }} years</td>
                    <td width='25%'><b>Blood Group</b></td>
                    <td width='25%'>{{ $user->personalInfo->blood_group }}</td>
                  </tr>
                  <tr>
                    <td width='25%'><b>Height</b></td>
                    <td width='25%'>{{ $user->personalInfo->height }}</td>
                    <td width='25%'><b>Skin Tone</b></td>
                    <td width='25%'>{{ $user->personalInfo->skin_tone }}</td>
                  </tr>
                  <tr>
                    {{-- <td width='25%'><b>Weight</b></td>
                    <td width='25%'>{{ ((int) $user->weight == $user->weight)?(int) $user->weight:$user->weight }} KG</td> --}}
                    <td width='25%'><b>Body Type</b></td>
                    <td width='25%'>{{ $user->personalInfo->body_build }}</td>
                  </tr>
                  <tr>
                    <td width='25%'><b>Maritial Status</b></td>
                    <td width='25%'>{{ $user->marital_status }}</td>
                    {{-- <td width='25%'><b>Personal Value</b></td>
                    <td width='25%'>{{ personalValue($user->personal_value) }}</td> --}}
                  </tr>
                  <tr>
                    <td><b>Children have</b></td>
                    <td>{{$user->personalInfo->do_u_have_children}}</td>
                  </tr>
                  <tr>
                    <td><b>Disability</b></td>
                    <td>{{$user->disability_status}}</td>
                  </tr>
                  <tr>
                    <td><b>Number of children</b></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><b>Disablity Details</b></td>
                    <td></td>
                  </tr>
                  {{-- @if($user->how_many_children) --}}
                    <tr>
                      <td><b>Children live with me:</b></td>
                      <td></td>
                    </tr>
                  {{-- @endif --}}
                </tbody>
              </table>
              <table class="table px-0 table-mobile">
                <tbody class="groom_table">
                  <tr>
                    <td width='45%'><b>Age</b></td>
                    <td width='50%'></td>
                  </tr>
                  <tr>
                    <td><b>Blood Group</b></td>
                    <td></td>
                    <tr>
                      <td><b>Height</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Skin Tone</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Weight</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Body Type</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Maritial Status</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Personal Value</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Children have</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Disability</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Number of children</b></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td><b>Disablity Details</b></td>
                      <td></td>
                    </tr>
                    @if($user->how_many_children)
                      <tr>
                        <td><b>Children live with me:</b></td>
                        <td></td>
                      </tr>
                    @endif
                </tbody>
              </table>
              </div>
            </div>
            <!-- Basic Information end -->
            <div class="row pr-sm-3">
              <div class="col-sm-12  groom_about_logedin pl-2  pl-sm-0 ">
                <div class="about_groom_absolute">
                  <span class="table-header">Education Background</span>

                </div>

              </div>
              <div class="col-sm-12 px-2 px-sm-0 groom_content">
                <table class="table px-0 table-desktop">
                  <tbody class="groom_table">
                    <tr>
                      <th>Educaiton Level</th>
                      <th>Educaiton Area</th>
                      <th>Degree</th>
                      <th>Institution</th>
                      {{-- <th>Status</th> --}}
                    </tr>
                      <tr>
                        <td>{{$user->personalInfo->educationLevel()}}</td>
                        <td>{{ $user->personalInfo->major_subject }}</td>
                        <td>{{ $user->personalInfo->major_subject }}</td>
                        <td><span class="badge badge-danger">Premium member only</span></td>
                        {{-- <td></td> --}}
                      </tr>
                  </tbody>
                </table>
                <table class="table px-0 table-mobile">
                  <tbody class="groom_table">
                    
                    
                      <tr>
                        <td>
                          <b>Education Level:</b>
                        </td>
                        <td>{{$user->personalInfo->educationLevel()}}</td>
                      </tr>
                      <tr>
                        <td>
                          <b>Educaiton Area:</b>
                        </td>
                        <td>
                          {{ $user->personalInfo->major_subject }}
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <b>Degree: </b>
                        </td>
                        <td>{{ $user->personalInfo->major_subject }}</td>
                      </tr>
                      <tr>
                        <td>
                          <b>Institution:</b>
                        </td>
                        <td><span class="badge badge-danger">Premium member only</span></td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Education end -->

            <!-- Religion and Others start -->
            <div class="row pr-sm-3">
              <div class="col-sm-12  groom_about_logedin pl-2  pl-sm-0 ">
                <div class="about_groom_absolute">
                  <span class="table-header">Religion and Others</span>

                </div>

              </div>
              <div class="col-sm-12 px-2 px-sm-0 groom_content">
                <table class="table px-0 table-desktop">

                  <tbody class="groom_table">
                    <tr>
                      <td width='25%'><b>Religion</b></td>
                      <td width='25%'>{{$user->religion}}</td>
                      <td width='25%'><b>Mother Tongue</b></td>
                      <td width='25%'>{{$user->personalInfo->mother_tongue}}</td>
                      <tr>
                        <td width='25%'><b>Sub caste</b></td>
                        <td width='25%'></td>
                        <td width='25%'><b>Smoke</b></td>
                        <td width='25%'>{{$user->personalInfo->smoke_status}}</td>
                      </tr>
                      <tr>
                        <td width='25%'><b>Diet</b></td>
                        <td width='25%'>{{$user->personalInfo->diat_status}}</td>
                        <td width='25%'><b>Sun Sign</b></td>
                        <td width='25%'>{{$user->personalInfo->zodiac_sign}}</td>
                      </tr>

                      <tr>
                        <td width='25%'><b>Drink</b></td>
                        <td width='25%'>{{$user->personalInfo->alcohol_status}}</td>
                        {{-- <td width='25%'><b>Hobby</b></td>
                        <td width='25%'></td> --}}
                      </tr>
                    </tbody>
                  </table>
                  <table class="table px-0 table-mobile">
                    <tbody class="groom_table">
                      <tr>
                        <td width='25%'><b>Religion</b></td>
                        <td width='25%'>{{$user->religion}}</td>
                      </tr>
                      <tr>
                        <td width='25%'><b>Mother Tongue</b></td>
                        <td width='25%'>{{$user->personalInfo->mother_tongue}}</td>
                        <tr>
                          <td width='25%'><b>Sub caste</b></td>
                          <td width='25%'></td>
                        </tr>
                        <tr>
                          <td width='25%'><b>Smoke</b></td>
                          <td width='25%'>{{$user->personalInfo->smoke_status}}</td>
                        </tr>
                        <tr>
                          <td width='25%'><b>Diet</b></td>
                          <td width='25%'>{{$user->personalInfo->diat_status}}</td>
                        </tr>
                        <tr>
                          <td width='25%'><b>Sun Sign</b></td>
                          <td width='25%'>{{$user->personalInfo->zodiac_sign}}</td>
                        </tr>

                        <tr>
                          <td width='25%'><b>Drink</b></td>
                          <td width='25%'>{{$user->personalInfo->alcohol_status}}</td>
                        </tr>
                        {{-- <tr>
                          <td width='25%'><b>Hobby</b></td>
                          <td width='25%'></td>
                        </tr> --}}
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- Religion and Others end -->

                <!-- Siblings start -->
                <div class="row pr-sm-3">
                  <div class="col-sm-12  groom_about_logedin pl-2  pl-sm-0 ">
                    <div class="about_groom_absolute">
                      <span class="table-header">Brother & Sister</span>

                    </div>

                  </div>
                  <div class="col-sm-12 px-2 px-sm-0 groom_content">
                    <table class="table px-0 table-desktop">
                      <tbody class="groom_table">
                        <tr>
                          <td width='25%'><b>Number of Brother</b></td>
                          <td width='25%'>{{$user->personalInfo->number_of_brother}}</td>
                          <td width='25%'><b>Number of Sister</b></td>
                          <td width='25%'>{{ $user->personalInfo->number_of_sister }}</td>
                        </tr>
                        <tr>
                          <td width='25%'><b>Of whom Married</b></td>
                          <td width='25%'>{{ $user->personalInfo->how_many_brother_married }}</td>

                          <td width='25%'><b>Of whom Married</b></td>
                          <td width='25%'>{{ $user->personalInfo->how_many_sister_married }}</td>
                        </tr>
                      </tbody>
                    </table>
                    <table class="table px-0 table-mobile">
                      <tbody class="groom_table">
                        <tr>
                          <td width='25%'><b>Number of Brother</b></td>
                          <td width='25%'>{{$user->personalInfo->number_of_brother}}</td>
                        </tr>
                        <tr>
                          <td width='25%'><b>Number of Sister</b></td>
                          <td width='25%'>{{ $user->personalInfo->number_of_sister }}</td>
                        </tr>
                        <tr>
                          <td width='25%'><b>Of whom Married</b></td>
                          <td width='25%'>{{ $user->personalInfo->how_many_brother_married }}</td>
                        </tr>
                        <tr>
                          <td width='25%'><b>Of whom Married</b></td>
                          <td width='25%'>{{ $user->personalInfo->how_many_sister_married }}</td>
                        </tr>
                        

                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- Siblings end -->

                

                {{-- @if ($user->preference_provided > 0) --}}
                  <!-- Partner preference start -->
                  <div class="row pr-sm-3">
                    <div class="col-sm-12  groom_about_logedin pl-2  pl-sm-0 ">
                      <div class="about_groom_absolute">
                        <span class="table-header">Partner preference</span>
                      </div>

                    </div>
                    <div class="col-sm-12 px-2 px-sm-0 groom_content">
                      <table class="table px-0 table-desktop">
                        <tbody class="groom_table">
                          <tr>
                            <td class="mytd" colspan="4"><b>Basic Information</b></td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Age</b></td>
                            <td width='25%'> {{ $user->searchTerm->min_age }} to {{ $user->searchTerm->max_age }} years</td>

                            <td width='25%'><b>Maritial Status</b></td>
                            <td width='25%'>{{ $user->searchTerm->marital_status }}</td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Height</b></td>
                            <td width='25%'>{{ $user->searchTerm->min_height }} to {{ $user->searchTerm->max_height }}</td>

                            <td width='25%'><b>Children Allow</b></td>
                            <td width='25%'></td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Religion</b></td>
                            <td width='25%'>{{ $user->searchTerm->religion }}</td>

                            <td width='25%'><b>Skin Tone</b></td>
                            <td width='25%'>{{ $user->searchTerm->skin_color }}</td>
                          </tr>

                          <tr>
                            <td class="mytd" colspan="4"><b class="color-red">Location Information</b></td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Current Living Country</b></td>
                            <td width='25%'>
                              {{ $user->searchTerm->countryOfOrigin() }}
                            </td>
                            <td width='25%'><b>Expected Home District</b></td>
                            <td colspan="3">
                              {{ $user->searchTerm->state_of_residence }}
                            </td>
                          </tr>
                          <tr>
                            <td class="mytd" colspan="4"><b class="color-red">Education &amp; Career</b></td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Education Level</b></td>
                            <td width='25%'>
                              {{ $user->searchTerm->education_level }}
                            </td>

                            <td width='25%'><b>Profession</b></td>
                            <td width='25%'>
                              {{ $user->searchTerm->my_profession }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <table class="table px-0 table-mobile">
                        <tbody class="groom_table">
                          <tr>
                            <td class="mytd" colspan="2"><b>Basic Information</b></td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Age</b></td>
                            <td width='25%'>{{ $user->searchTerm->min_age }} to {{ $user->searchTerm->max_age }} years</td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Maritial Status</b></td>
                            <td width='25%'>{{ $user->searchTerm->marital_status }}</td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Height</b></td>
                            <td width='25%'>{{ $user->searchTerm->min_height }} to {{ $user->searchTerm->max_height }}</td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Children Allow</b></td>
                            <td width='25%'>{{ ($user->preference_children_allow==1)?"Yes":"No" }}</td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Religion</b></td>
                            <td width='25%'>{{ $user->searchTerm->religion }}</td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Skin Tone</b></td>
                            <td width='25%'>{{ $user->searchTerm->skin_color }}</td>
                          </tr>
                          <tr>
                            <td width='25%'></td>
                            <td width='25%'></td>
                          </tr>
                          <tr>
                            <td class="mytd" colspan="4"><b class="color-red">Location Information</b></td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Current Living Country</b></td>
                            <td width='25%'>
                              {{ $user->searchTerm->countryOfOrigin() }}
                            </td>
                          </tr>
                          <tr>
                            <td><b>Expected Home District</b></td>
                            <td>
                              {{ $user->searchTerm->state_of_residence }}
                            </td>
                          </tr>
                          <tr>
                            <td class="mytd" colspan="2"><b class="color-red">Education &amp; Career</b></td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Education Level</b></td>
                            <td width='25%'>
                              {{ $user->searchTerm->education_level }}
                            </td>
                          </tr>
                          <tr>
                            <td width='25%'><b>Profession</b></td>
                            <td width='25%'>
                              {{ $user->searchTerm->my_profession }}
                            </td>
                          </tr>

                          <tr>
                            <tr>
                              <td class="mytd" colspan="2"><b>More about partner or partner family</b></td>
                            </tr>
                            <td colspan="2">
                              {{ strlen($user->preference_moreinfo) > 3?$user->preference_moreinfo:"Tell you later" }}
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- Partner preference end -->
                {{-- @endif --}}
            
          


              </div>
            </div>
          </div>
        </section>
        @include('bgbd.subpage.public-js')
      @endsection
