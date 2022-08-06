@extends('layouts/blankLayout')

@section('title', 'Erro 404')

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection


@section('content')
  <!-- Error -->
  <div class="container-xxl container-p-y">
    <div class="misc-wrapper">
      <h2 class="mb-2 mx-2">Página Indisponível :(</h2>
      <p class="mb-4 mx-2">Oops! 😖 O link que você digitou não existe no nosso sistema ainda.</p>
      <a href="{{ route('index') }}" class="btn btn-primary">Voltar à página inicial</a>
      <div class="mt-3">
        <img src="{{asset('assets/img/illustrations/page-misc-error-light.png')}}" alt="page-misc-error-light" width="500" class="img-fluid">
      </div>
    </div>
  </div>
  <!-- /Error -->
@endsection
