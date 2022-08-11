@extends('layouts.app')
@section('content')
<style>
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    bottom: 0;
    right: 0;
    left: 0;
    z-index: 999;
    opacity: 0.5;
    background: rgba(255,255,255,0.8) url({{url('images/reload.gif')}}) center no-repeat;
}
/* Turn off scrollbar when body element has the loading class */
div.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
div.loading .overlay{
    display: block;
}
</style>
<div class="container">
    <div class="row justify-content-center attorney-dashboard case-list-main">
        <div class="col-md-12 loading">
              <div class="overlay"></div>
            <div class="card" style="display: none;">
                <form id="custody_based_redirect" method="POST" action="{{route('cases.computations_sheet')}}" autocomplete="off">
                  @csrf
                  <input type="hidden" name="case_id" id="modal_case_id" value="{{ $case_id }}" required="">
                  <input type="hidden" name="form_state" id="modal_state_id" value="{{ $form_state }}" required="">
                  <input type="radio" id="computed_from_database" class="" name="computation_sheet_version" value="Computed from Database" checked="" required="">
                  <input type="submit" id="modal_submit_btn" class="btn btn-success mt-2" value="Submit">
                </form>
            </div>
        </div>
    </div>
</div>
<script>
  $(document).ready( function () {
    $('#custody_based_redirect').submit();
  });
</script>
@endsection