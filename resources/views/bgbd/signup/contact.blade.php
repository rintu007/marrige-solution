@extends('hasan.master')

@section('content')
  @include('hasan.subpage.banner-sm')
  <div class="container" style="margin-top: 30px;">
    <br />
    <div class="row">
      <div class="col-sm-12 padding-0 margin-0">
        <div class="progress">
          <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="{{ $completed }}"
          aria-valuemin="0" aria-valuemax="100" style="width:{{ $completed }}%">
          {{ $completed }}% completed
        </div>
      </div>
    </div>
  </div>
  <br />

  <div class="row">
    <div class="col-sm-12 m-b-100">
      @isset($allowGoback)
        <a href="{{ $allowGoback }}" class="signupbutton padding-0-30 margin-bottom-15 btn btn-info pull-left">
          <span class="fa fa-caret-left"></span> Back
        </a>
      @endisset

      @isset($allowSkip)
        <a href="{{ $allowSkip }}" class="signupbutton padding-0-30 margin-bottom-15 btn btn-danger pull-right">
          Skip <span class="fa fa-caret-right"></span>
        </a>
      @endisset

      <h2 class="center-block m-t-0">
        @isset($title)
          {{ $title }}
        @else
          Title of the form
        @endisset
      </h2>
      <hr>

      <form method="POST" action=" {{ route('signup.contactStore') }}"  role="form" >
        @csrf
        <div class="form-group row">
          <div class="col-sm-6">
            <label for="fullname" class=" col-form-label">Name of the Contact Person
            </label>
            <div class="">
              <input required='required' value="{{ old('fullname') }}" id="fullname" name="fullname"
              placeholder="Name" class="uk-input" type="text">

              @if ($errors->has('fullname'))
                <span class="text-danger" role="alert">
                  <strong>{{ $errors->first('fullname') }}</strong>
                </span>
              @endif
              <span class="text-danger" role="alert">
                <strong id="err_fullname"></strong>
              </span>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="relation" class="col-form-label">Relativeship
            </label>
            <div class="uk-form-controls religion_caste_lg uk-form-custom uk-form-controls-lg" uk-form-custom="target: > * > span:first-child">
              <select required='required' name="relation" id="relation" class="uk-input">
                <option value="">Select ...</option>
                @foreach (relation() as $key => $value)
                  <option {{ old('relation') == $key ? 'selected' : '' }} value="{{ $key }}">{{
                    $value }}</option>
                  @endforeach
                </select>
                <button class="uk-button birth_day_btn uk-button-default px-0 mx-0 " type="button" tabindex="-1">
                  <span>
                    Relativeship
                  </span>
                  <span class="uk-icon" uk-icon="icon: chevron-down"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="chevron-down"><polyline fill="none" stroke="#000" stroke-width="1.03" points="16 7 10 13 4 7"></polyline></svg></span>
                </button>

                @if ($errors->has('relation'))
                  <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('relation') }}</strong>
                  </span>
                @endif
                <span class="text-danger" role="alert">
                  <strong id="err_relation"></strong>
                </span>
              </div>
            </div>

          </div>

          <div class="form-group row">

            <div class="col-sm-6">
              <label for="mobile" class=" col-form-label">Mobile No.
              </label>
              <div class="">
                <input required='required' value="{{ old('mobile') }}" id="mobile" name="mobile"
                placeholder="Mobile" class="uk-input" type="text">
                @if ($errors->has('mobile'))
                  <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('mobile') }}</strong>
                  </span>
                @endif
                <span class="text-danger" role="alert">
                  <strong id="err_mobile"></strong>
                </span>
              </div>
            </div>

            <div class="col-sm-6">
              <label for="email" class=" col-form-label">Alternative Email
              </label>
              <div class="">
                <input value="{{ old('email') }}" id="email" name="email" placeholder="First Name"
                class="uk-input" type="email">
                @if ($errors->has('email'))
                  <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
                <span class="text-danger" role="alert">
                  <strong id="err_email"></strong>
                </span>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="timeform" class="col-form-label col-xs-12">&nbsp;&nbsp;&nbsp;&nbsp;Convinient time to call
            </label>
            <label for="timeform" class="col-form-label col-xs-2 h4">&nbsp;&nbsp;From ... </label>
            <div class="col-xs-4">
              <select required='required' name="timeform" id="timeform" class="uk-input">
                <option value="">From ...</option>
                @for ($i = 1; $i < 13; $i++)
                  <option {{ old('timeform') == $i.' AM'? 'selected' : '' }} value="{{ $i.' AM' }}">{{ $i.' AM' }}</option>
                @endfor
                @for ($i = 1; $i < 13; $i++)
                  <option {{ old('timeform') == $i.' PM'? 'selected' : '' }} value="{{ $i.' PM' }}">{{ $i.' PM' }}</option>
                @endfor
              </select>
              @if ($errors->has('timeform'))
                <span class="text-danger" role="alert">
                  <strong>{{ $errors->first('timeform') }}</strong>
                </span>
              @endif
              <span class="text-danger" role="alert">
                <strong id="err_timeform"></strong>
              </span>
            </div>
            <label for="timeto" class="col-form-label col-xs-2 h4"> &nbsp;&nbsp;To ...</label>
            <div class="col-xs-4">
              <select required='required' name="timeto" id="timeto" class="uk-input">
                <option value="">To ...</option>
                @for ($i = 1; $i < 13; $i++)
                  <option {{ old('timeto') == $i.' AM'? 'selected' : '' }} value="{{ $i.' AM' }}">{{ $i.' AM' }}</option>
                @endfor
                @for ($i = 1; $i < 13; $i++)
                  <option {{ old('timeto') == $i.' PM'? 'selected' : '' }} value="{{ $i.' PM' }}">{{ $i.' PM' }}</option>
                @endfor
              </select>
              @if ($errors->has('timeto'))
                <span class="text-danger" role="alert">
                  <strong>{{ $errors->first('timeto') }}</strong>
                </span>
              @endif
              <span class="text-danger" role="alert">
                <strong id="err_timeto"></strong>
              </span>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-6">
              <label for="presentaddress" class=" col-form-label">Present Address
              </label>
              <div class="">
                <textarea class="uk-input" name="presentaddress" id="" cols="30" rows="5">{{ old('presentaddress') }}</textarea>
                @if ($errors->has('presentaddress'))
                  <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('presentaddress') }}</strong>
                  </span>
                @endif
                <span class="text-danger" role="alert">
                  <strong id="err_presentaddress"></strong>
                </span>
              </div>
            </div>
            <div class="col-sm-6">
              <label for="permanentaddress" class=" col-form-label">Permanent Address
              </label>
              <div class="">
                <textarea class="uk-input" name="permanentaddress" id="" cols="30" rows="5">{{ old('permanentaddress') }}</textarea>
                @if ($errors->has('permanentaddress'))
                  <span class="text-danger" role="alert">
                    <strong>{{ $errors->first('permanentaddress') }}</strong>
                  </span>
                @endif
                <span class="text-danger" role="alert">
                  <strong id="err_permanentaddress"></strong>
                </span>
              </div>
            </div>
          </div>




          <div class="form-group row">
            <div class="col-sm-3">
              <button type="submit" id="submit" class="uk-button uk-button-block create_acc">Save and
                Continue</button>
              </div>

            </div>


          </form>

        </div>

      </div>
    </div>

  @endsection


  @section("footerscript")
    <script>
    $(document).ready(function () {
      $("body").on("click", "#submit", function () {
        var err = 0;
        $(
          "#err_fullname, #err_relation , #err_mobile , #err_email  , #err_timeform ,#err_timeto ,#err_presentaddress ,#err_permanentaddress " ).text("");

          var fullname = $("input[name='fullname']").val();
          var relation = $("select[name='relation']").val();
          var mobile = $("input[name='mobile']").val();
          var email = $("input[name='email']").val();
          var timeform = $("select[name='timeform']").val();
          var timeto = $("select[name='timeto']").val();
          var presentaddress = $("textarea[name='presentaddress']").val();//
          var permanentaddress = $("textarea[name='permanentaddress']").val();


          if (fullname == "") {
            $("#err_fullname").text("Name of the Contact Person Required");
            err++;
          }
          if (relation == "") {
            $("#err_relation").text("Relativeship Required");
            err++;
          }

          if (mobile == "") {
            $("#err_mobile").text("Mobile No Required");
            err++;
          }
          /*
          else if (fname.match(/[$,-,'',#,@,&,!_,%]/)) {
          $("#err_fname").text("Please don't use this $,-,'',#,@,&,!_,%");
          err++;
        }*/


        if (timeform == "") {
          $('#err_timeform').text("Convinient time to call  Required");
          err++;
        }
        if (timeto == "") {
          $("#err_timeto").text("Convinient time to call To Required");
          err++;
        }
        if (presentaddress == "") {
          $("#err_presentaddress").text("Present Address Required");
          err++;
        }
        if (permanentaddress == "") {
          $("#err_permanentaddress").text("Permanent Address is Required");
          err++;
        }

        if (err > 0) {
          return false;
        }
        return true;
      });
    });

    </script>
  @endsection
