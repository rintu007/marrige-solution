<form method="post" action="{{ route('login') }}">
    {{csrf_field()}}
    <div class="row">
        <div class="col-md-6 ml-auto mr-auto">

 
 



            <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                <label for="exampleInput1" class="bmd-label-floating">Enter Your Email *</label>
                <input type="email" value="{{old('email') }}" class="form-control" id="email" name="email">
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @else
                <span class="bmd-help">Email is required</span>
                @endif
            </div>

 


            <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }}">
                <label for="exampleInput1" class="bmd-label-floating">Password *</label>
                <input type="password" value="{{old('password')}}" class="form-control" id="password" name="password">
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @else
                <span class="bmd-help">Password is required</span>
                @endif
            </div>

            
                 


            

            <br>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                    {{ __('Remember Me') }}
                </label>
            </div>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                </div>
            </div>
            





  
<br>



            <div class="">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            
        </div>
    </div>
</form>