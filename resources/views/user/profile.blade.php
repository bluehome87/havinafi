<div id="profile-block" class="col-lg-12 block">
    <h1>My Profile</h1>
    <br>

    <form role="form" method="POST" action="{{ url('/profile') }}">
        <fieldset>
            {!! csrf_field() !!}

            @if (count($errors) > 0 && Request::is('profile'))
                <div class="alert alert-danger errors" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span>Errors:</span>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="name">Name</span>
                    <input type="text" class="form-control" name="name" value="{{old('name', Auth::user()->name)}}" aria-describedby="name">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="company_name">Company name</span>
                    <input type="text" class="form-control" name="company_name" value="{{old('company_name', Auth::user()->company_name)}}" aria-describedby="company_name">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="address">Address</span>
                    <input type="text" class="form-control" name="address" value="{{old('address', Auth::user()->address)}}" aria-describedby="address">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="phone">Phone</span>
                    <input type="text" class="form-control" name="phone" value="{{old('phone', Auth::user()->phone)}}" aria-describedby="phone">
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="description">Description</span>
                    <textarea class="form-control" rows="3" id="description" name="description" aria-describedby="description">{{old('description', Auth::user()->description)}}</textarea>
                </div>
            </div>

            <div class="input-group pull-left" id="profile-is-professional" data-toggle="buttons">
                <label class="btn @if(old('is_professional', Auth::user()->is_professional)) btn-success active @else btn-default @endif">
                    <input type="checkbox" name="is_professional" id="is_professional" autocomplete="off" @if(old('is_professional', Auth::user()->is_professional)) checked @endif>Professional (transport company)?
                </label>
            </div>

            <button class="btn btn-primary pull-right" type="submit">Save</button>
        </fieldset>
    </form>
</div>