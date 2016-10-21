<div id="register-block" class="col-lg-12 block">
    <h1>Register</h1>
    <br>

    <form role="form" method="POST" action="{{ url('/register') }}">
        <fieldset>
            {!! csrf_field() !!}

            @if (count($errors) > 0 && Request::is('register'))
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
                <label class="control-label" for="name">Name</label>

                <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label class="control-label" for="email">Email</label>

                <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="control-label" for="password">Password</label>

                <input class="form-control" type="password" id="password" name="password">
            </div>

            <div class="form-group">
                <button class="btn btn-primary pull-right" type="submit">Register</button>
            </div>
        </fieldset>
    </form>
</div>