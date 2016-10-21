<div id="reset-password-block" class="col-lg-12 block">
    <h1>Reset Password</h1>
    <br>

    <form role="form" method="POST" action="{{ url('/reset-password') }}">
        <fieldset>
            {!! csrf_field() !!}

            @if(isset($token))
                <input type="hidden" name="token" value="{{ $token }}">
            @endif

            @if (count($errors) > 0 && Request::is('reset-password/*'))
                <div class="alert alert-danger alert-dismissible errors" role="alert">
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
                <label class="control-label" for="email">Email</label>

                <input class="form-control" type="email" id="email" name="email" value="{{ $email or old('email') }}">
            </div>

            <div class="form-group">
                <label class="control-label" for="password">Password</label>

                <input class="form-control" type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <label class="control-label" for="password_confirmation">Confirm Password</label>

                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation">
            </div>

            <div class="form-group">
                <button class="btn btn-primary pull-right" type="submit">
                    <i class="fa fa-btn fa-refresh"></i> Reset Password
                </button>
            </div>
        </fieldset>
    </form>
</div>