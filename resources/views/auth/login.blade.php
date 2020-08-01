@extends('layouts.frontend')
  @section('content')
  <div class="container__login">
    <div class="logo__login-box">
      <br><br>
      {{-- <img src="{{ url('img/logo.png') }}" alt="Paynaira" class="logo__login" /> --}}
      <h2 class="form__title">{{config('app.name')}}</h2>
    </div>
    <div class="login__content">
      <form method="POST" action="{{ route('login') }}@isset($url)/{{ $url }} @endisset" class="form__login">
        @csrf
        <div class="form__group">
          <h2 class="form__title">Sign in to your @isset($url)
            {{ ucwords($url) }}
        @endisset account</h2>
        </div>
        @if (session('status'))
          <h2 style="padding:10px; margin-bottom:5px; background-color: #ffccff;">{{session('status')}}</h2>
        @endif
        <div class="form__group">
          <input
            type="email"
            placeholder="Email Address"
            name="email"
            class="form__input"
            id="email"
            value="{{old('email')}}"
            required
          />
          <label for="email" class="form__label">Email Address *</label>
        </div>

        <div class="form__group">
          <input
            type="password"
            placeholder="Password"
            maxlength="8"
            class="form__input"
            id="pass"
            name="password"
            value="password"
            required
          />
          <label for="pass" class="form__label">Password *</label>
        </div>

        @isset($url)
         
        @else
          <div class="form__group flex-center__login">
            <input type="checkbox" class="form__checkbox" id="check" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
            <label for="check" class="form__checklabel">
              <span class="form__checkbox-button"></span>
            </label>
            <span class="form__terms">Stay signed in for a week. </span>
          </div> 
        @endisset

        <div class="form__group">
          <button class="btn__submit" type="submit">Sign In</button>
          @if (Route::has('password.request'))
            <p class="btn__text">
              Unable to login?
              <a href="{{route('password.request')}}" class="form__link"
                ><strong>Forgot Password </strong></a
              >
            </p>
          @endif
        </div>
      </form>
    </div>

    <div class="form__group .u-margin-top-small">
      <p class="btn__text">
        Don't have an account ?
        <a href="{{route('register')}}" class="form__link"
          ><strong>SignUp Here</strong></a
        >
      </p>
    </div>
  </div>
  @endsection
