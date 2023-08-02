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
            <form method="POST" class="card" id="frm_transfer" action="{{ route('add-transfer') }}">
                <div class="card-header">
                  <h3 class="card-title">Transfer Money</h3>
                </div>
                <div class="card-body">
                  <div class="mb-2">
                    Email address
                  </div>
                  <div class="mb-2">
                  <input type="text" id="tags" class="form-control" name="email_id" placeholder="Enter email" autofocus="">
                  <span id="email-error" style="color: red; display: none;">Please select a valid email from the suggestions.</span>
                  </div>
                </div>
                <div class="card-body">
                  <div class="mb-2">
                    Amount
                  </div>
                  <div class="mb-2">
                  <input type="number" class="form-control numeric" min="1" name="transfer_amount" placeholder="Enter amount to Transfer">
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-end">
                      <button type="submit" class="btn btn-primary">Transfer</button>
                    </div>
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            </form>
          </div>
        </div>
        <script>
              $(document).ready(function() {
                var suggestionSelected = false;
                var validSuggestions = [];

                $("#tags").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('autocomplete.email') }}",
                            data: {
                                term: request.term
                            },
                            dataType: "json",
                            success: function(data) {
                                validSuggestions = data;
                                response(data);
                            }
                        });
                    },
                    focus: function(event, ui) {
                        $("#tags").val(ui.item.value);
                        suggestionSelected = true;
                        return false;
                    },
                    select: function(event, ui) {
                        $("#tags").val(ui.item.value);
                        suggestionSelected = true;
                        return false;
                    },
                });

                $("#tags").blur(function() {
                    if ($("#tags").val() !== "" && validSuggestions.indexOf($("#tags").val()) === -1) {
                        $("#tags").val("");
                        $("#email-error").show();
                        $("#tags").focus();
                    } else if($("#tags").val() == ''){
                        $("#tags").focus();
                    }else{
                        $("#email-error").hide();
                    }
                });
                $("#frm_transfer").validate({
                    rules: {
                        transfer_amount : "required"
                    }
                });
            });
        </script>
@endsection
