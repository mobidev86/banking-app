@extends('tablar::page')

@section('content')
    <!-- Page body -->
    <div class="page-body">
          <div class="container-xl">
            <form method="POST" class="card" id="frm_deposit" action="{{ route('add-deposit') }}">
                <div class="card-header">
                  <h3 class="card-title">Deposit Money</h3>
                </div>
                <div class="card-body">
                  <div class="mb-2">
                    Amount
                  </div>
                  <div class="mb-2">
                  <input type="number" class="form-control numeric" min="1" name="deposit_amount" required placeholder="Enter amount to Deposit ">
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-end">
                      <button type="submit" class="btn btn-primary">Deposit</button>
                    </div>
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            </form>
          </div>
        </div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $("#frm_deposit").validate({
            rules: {
              deposit_amount: "required"
            }
        });
    });
</script>
@endsection