@extends('tablar::page')

@section('content')
    <!-- Page body -->
    <div class="page-body">
          <div class="container-xl">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
                    @endif
                @endforeach
            </div>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Welcome {{Auth::user()->name}}</h3>
              </div>
              <div class="card-body">
                        <div class="mb-2">
                          YOUR ID : <strong>{{Auth::user()->email}}</strong>
                        </div>
                        <div class="mb-2">
                          YOUR BALANCE : <strong>{{ number_format($current_balance, 2) }} INR</strong>
                        </div>
                      </div>
            </div>
          </div>
        </div>
@endsection