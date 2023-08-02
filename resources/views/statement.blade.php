@extends('tablar::page')

@section('content')
    <!-- Page body -->
    <div class="page-body">
    	<div class="container-xl">

          <p>
              Filter by type:
              <a href="{{ route('statement', []) }}">All</a> |
              <a href="{{ route('statement', ['type' => 'deposit']) }}">Deposit</a> |
              <a href="{{ route('statement', ['type' => 'withdraw']) }}">Withdraw</a> |
              <a href="{{ route('statement', ['type' => 'transfer']) }}">Transfer</a>
          </p>

            <div id="table-default" class="table-responsive">
            	<div class="card">
              <div class="card-body">
                <div id="table-default" class="table-responsive">
                  <table class="table">
				    <tr>
				        <th>Date Time</th>
				        <th>Amount</th>
				        <th>Type</th>
				        <th>Details</th>
				        <th>Balance</th>
				    </tr>
				    @foreach ($statement as $transaction)
				        <tr>
				            <td>{{ $transaction['created_at'] }}</td>
				            <td>{{ $transaction['amount'] }}</td>
				            <td>{{ ucfirst($transaction['type']) }}</td>
				            <td>{{ $transaction['details'] }}</td>
				            <td>{{ $transaction['balance'] }}</td>
				        </tr>
				    @endforeach
                  </table>
                </div>
              </div>
            </div>
            </div>
        </div>
    </div>
    <script>
     
    </script>
@endsection


