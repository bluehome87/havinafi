<div id="forgot-password-block" class="col-lg-12 block">
    <h1>Forgot Password</h1>
    <br>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            <span>Reset password link was sent to your email.</span>
        </div>
    @else
        <form role="form" method="POST" action="{{ url('/forgot-password') }}">
            <fieldset>
                {!! csrf_field() !!}

                @if (count($errors) > 0 && Request::is('forgot-password'))
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

                    <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <button class="btn btn-primary pull-right" type="submit">
                        <i class="fa fa-btn fa-envelope"></i> Send Password Reset Link
                    </button>
                </div>
            </fieldset>
        </form>
    @endif
</div>