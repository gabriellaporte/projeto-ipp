@extends('layouts/blankLayout')

@section('title', 'Esqueci a Senha')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{ route('index') }}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',['width'=>25,'withbg' => "#696cff"])</span>
              <span class="app-brand-text demo text-body fw-bolder">{{ config('variables.templateName') }}</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2 text-center">Esqueceu a Senha? 🔒</h4>
          <p class="mb-4 text-center">Sem problemas! Coloque o seu e-mail e enviaremos instruções sobre como recuperar.</p>
          <form id="formAuthentication" class="mb-3" action="javascript:void(0)" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Digite o email da conta..." required autofocus>
            </div>
            <button class="btn btn-primary d-grid w-100">Recuperar Senha</button>
          </form>
          <div class="text-center">
            <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
              <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
              Fazer Login
            </a>
          </div>
        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>
</div>
@endsection
