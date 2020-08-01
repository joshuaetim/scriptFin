@extends('layouts.frontend')

@section('content')
    <div class="container__login">
    <div class="logo__login-box">
      <img src="{{url('img/logo.png')}}" alt="Paynaira" class="logo__login" />
    </div>
    <div class="login__content">
      <form action="{{ route('password.email') }}" class="form__login" method="post">
        @csrf
        <div class="form__group">
          <h2 class="form__title">Sign in to your account</h2>
        </div>
        <div class="form__group">
          <p class="form__text">
            Enter the email address associated with your account, and we'll
            send you a link to reset your password.
          </p>
        </div>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <h2 style="padding:10px; margin-bottom:5px; background-color: #ffccff;">{{$error}}</h2>
            @endforeach
        @endif
        <div class="form__group">
          <input
            type="email"
            placeholder="Email Address"
            class="form__input"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
          />
          <label for="email" class="form__label">Email Address *</label>
          <button class="btn__submit" style="margin-top: 0.9rem;">
            Continue
          </button>

          <p class="btn__text">
            Remember your password
            <a href="{{url('/login')}}" class="form__link"
              ><strong>Login Here</strong></a
            >
          </p>
        </div>
      </form>
    </div>

    <div class="form__group .u-margin-top-small">
      <p class="btn__text">
        Don't have an account ?
        <a href="{{url('register')}}" class="form__link"
          ><strong>SignUp Here</strong></a
        >
      </p>
    </div>
  </div>
@endsection
