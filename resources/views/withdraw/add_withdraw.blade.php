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
            <form method="POST" class="card" id="frm_withdraw" action="{{ route('add-withdraw') }}">
                <div class="card-header">
                  <h3 class="card-title">Withdraw Money</h3>
                </div>
                <div class="card-body">
                  <div class="mb-2">
                    Amount
                  </div>
                  <div class="mb-2">
                  <input type="number" class="form-control numeric" min="1" name="withdraw_amount" required placeholder="Enter amount to Withdraw ">
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-end">
                      <button type="submit" class="btn btn-primary">Withdraw</button>
                    </div>
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            </form>
          </div>
        </div>
        <script type="text/javascript">
          jQuery(document).ready(function(){
              $("#frm_withdraw").validate({
                  rules: {
                    withdraw_amount: "required"
                  }
              });
          });
      </script>
@endsection