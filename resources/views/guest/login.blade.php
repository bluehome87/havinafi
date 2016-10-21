<div id="login-block" class="col-lg-12 block">
    <h1>Login</h1>
    <br>

    <form role="form" method="POST" action="{{ url('/login') }}">
        <fieldset>
            {!! csrf_field() !!}

            @if (count($errors) > 0 && Request::is('login'))
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
                <label class="control-label" for="email">Email</label>

                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="control-label" for="password">Password</label>

                <input class="form-control" type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <div class="form-group">
                <button class="btn btn-primary pull-right" type="submit">Login</button>
            </div>

            <div class="form-group">
                <a class="btn btn-link pull-left" onclick="showForgotPasswordBlock()">Forgot Your Password?</a>
            </div>
        </fieldset>
    </form>
</div>