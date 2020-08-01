@extends('layouts.frontend')
  @section('content')
    <div class="container">
      <div class="content">
        <div class="content__box">
          <div class="logo-box">
            <img src="img/logo.png" alt="Paynaira" class="logo" />
          </div>
          <div class="content__text">
            <h1 class="content__text--h1">
              <span>&nbsp</span> Quick and easy deposit
            </h1>
            <p class="content__text--p">
              We offer the best way that is made easy to make payment into the
              system!
            </p>
          </div>
          <div class="content__text">
            <h1 class="content__text--h1">
              <span>&nbsp</span> Make money today using Paynaira
            </h1>
            <p class="content__text--p">
              You will get profit of 100% ROI in 3 days on your first Investment
              and subsequently get 100%!
            </p>
          </div>
          <div class="content__text">
            <h1 class="content__text--h1">
              <span>&nbsp</span> Fast and easy withdrawal
            </h1>
            <p class="content__text--p">
              Easy withdrawal of your money on the system after you have
              completed your investment.
            </p>
          </div>
        </div>
      </div>
      <div class="form-box">
        <form method="POST" action="{{ route('register') }}" class="form">
          @csrf
          <div class="form__group">
            <h2 class="form__title">Create your Paynaira account</h2>
          </div>
          @if ($errors->any())
              @foreach ($errors->all() as $error)
              <p style="padding:10px; margin-bottom:5px; background-color: #ffccff; font-size:15px;">{{$error}}</p>
              @endforeach
          @endif
          <div class="form__group">
            <input type="hidden" name="referral" value="{{$_GET['ref'] ?? '1'}}">
            <input
              type="text"
              placeholder="Full Name"
              class="form__input"
              id="name"
              name="name"
              value="{{old('name')}}"
              required
            />
            <label for="name" class="form__label">Full Name *</label>
          </div>
          <div class="form__group">
            <input
              type="email"
              placeholder="Email Address"
              class="form__input"
              id="email"
              name="email"
              value="{{old('email')}}"
              required
            />
            <label for="email" class="form__label">Email Address *</label>
          </div>

          <div class="form__group">
            <input
              type="password"
              placeholder="******"
              class="form__input"
              id="password"
              name="password"
              required
            />
            <label for="password" class="form__label">Password</label>
          </div>

          <div class="form__group">
            <input
              type="password"
              placeholder="******"
              class="form__input"
              id="password2"
              name="password_confirmation"
              required
            />
            <label for="password2" class="form__label">Confirm Password</label>
          </div>
          
          <div class="form__group flex-center">
            <input type="checkbox" class="form__checkbox" id="check" required />
            <label for="check" class="form__checklabel">
              <span class="form__checkbox-button"></span>
            </label>
            <span class="form__terms"
              >I agree to all the statements included in the
              <a href="#" class="form__link">Terms of Use</a>.
            </span>
          </div>
          <div class="form__group">
            <button class="btn__submit">Register</button>
            <p class="btn__text">
              Already a member?
              <a href="{{route('login')}}" class="form__link">Login Here</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  @endsection
  
