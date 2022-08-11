
@extends('layouts.app')

@section('content')
<div class="container">
<style type="text/css">

/*
Print Table Record

*/
/* Global CSS */
body {margin: 0; padding: 0;line-height: 1.4; font-family: inherit;color: #333;}

*, *:after, *:before {box-sizing: border-box;}

.textcenter{text-align: center!important;}
.textright{text-align: right!important;}

h1 {margin: 0;padding: 0;line-height: normal;}
.input_field_wrapper input:focus,
.input_field_wrapper input:active,
.input_field_wrapper input:hover {outline: none;}

input[type=number]::-webkit-inner-spin-butt
on,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input:read-only {
  color: #000!important;
}

table.childtable input{width:40px!important;font-size:13px!important;}
table.childtable input:read-only{width:60px!important;font-size:13px!important;}
.sfont{font-size:13px!important;}

.percentage_end {
    padding-right: 15px;
    position: relative;
}

.percentage_end:after {
    content: "%";
    position: absolute;
    right: 0;
    top: 1px;
    color: #000000;
}

input::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #008000;
  opacity: 1; /* Firefox */
}

input:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: #008000;
}

input::-ms-input-placeholder { /* Microsoft Edge */
  color: #008000;
}

input:read-only::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #000000;
  opacity: 1; /* Firefox */
}

input:read-only:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: #000000;
}

input:read-only::-ms-input-placeholder { /* Microsoft Edge */
  color: #000000;
}

/* Print Form CSS */


.Tableworksheet_Outer {
    width: 100%;
    margin: 0;
}


.tbl_full_width, .Tableworksheet {
    border-collapse: collapse;
    width: 100%;
    border-spacing: 0;
}

.Cell_heading {
    width: 80%;
}

.Cell_obligee, .Cell_obligor {
    width: 10%;
}

.Tableworksheet tr th, .Tableworksheet tr td {
    padding: 5px;
    text-align: left;
    font-size: 16px;
    line-height: inherit;
    color: #000;
}

.Tableworksheet .table_header {
    padding: 0;
}

.input_field_wrapper input[type="text"],.input_field_wrapper input[type="number"] {
    font-size: 16px;
    padding: 0;
    box-sizing: border-box;
    width: 100%;
    color:  #008000;
    border: none;
}

.input_field_wrapper_highlight {
    border: 1px solid #333;
    padding: 0 5px;
}

.input_field_wrapper input[type="text"]:focus {
    outline: none;
}

.input_field_wrapper input[type="text"]:focus {
    outline: none;
}

.recordInner_heading {
    font-size: 24px;
    font-weight: normal;
    color: #000;
    text-transform: uppercase;
    font-family: inherit;
}

.Cell_obligee b, .Cell_obligor b , .Cell_obligee strong, .Cell_obligor strong {
    font-size: 24px;
    text-transform: uppercase;
}

.highligt_row {
    background-color: #dcdede;
}

.serial_count {
    width: 50px;
}

.input_field_wrapper_checkbox * {
    display: inline-block;
    vertical-align: middle;
}

.input_field_wrapper_checkbox input[type="checkbox"] {
    transform: scale(1.1);
    border: 1px solid #fff;
}

.inner_table_wrapper {
    border-top: none;
    border-bottom: none;
}

.inner_table td {
    border-color: #333;
}

.inner_table {
    border: 1px solid transparent;
}

.inner_table_wrapper {
    padding: 0 !important;
}

.header_inner_table, .header_inner_table thead {
    border: none;
}

.header_inner_table td, .header_inner_table th {
    border: 1px solid #333;
}

.header_inner_table th {
    border-top: none;
}

.table_header .header_inner_table:last-child tbody td {
    border-bottom: none;
}

.header_inner_table th:first-child, .header_inner_table tbody td:first-child {
    border-left: none;
}

.header_inner_table th:last-child, .header_inner_table tbody td:last-child {
    border-right: none;
}
.Tableworksheet tfoot tr td {
    font-size: 13px;
}

input[type="text"], select {
   
}

table select {
border: none;
background: none;
box-shadow: none !important;
font-size: 14px;
}

select.textcenter {
  text-align-last:center;
}

/********************************/

.anuual-income tr td {
    border: 1px solid #000;
    font-size: 14px;
    border-right: none;
    border-top: none;
}


.pd-0{
  padding: 0!important;
}
.bt-n tr td {
  border-top:none;
}
.border-left{
  border-left:1px solid #000!important;
}

.border-right{
  border-right:1px solid #000!important;
}

.Table-col-2 tr td{
  border-bottom: 1px solid #000;
}
.Table-col-2 tr td:nth-child(odd){
  border-right: 1px solid #000;
}

.border-bottom-custom{
  border-bottom: 1px solid #000;
}

.border-bottom-none{
  border-bottom: none!important;
}
.table-3c tr td {
  border: 1px solid #000;
  font-size: 16px;
  border-right: none;
  border-top: none;
}

.border-left-none{
  border-left: none !important
}
.border-right-none{
  border-right: none !important
}

.tbl-input-full tr td input {
    width: 100%!important;
    font-size: 13px!important;
}
.root-last-tr td, .last-tr td{
  border-bottom: none !important;
}
.anual-child-care input[type="text"] {
  text-align: center !important;
}
.anual-child-care tr td {
  text-align: center;
}

.eligible-federal td {
  border-bottom: #333 solid thin;
  border-right: #333 solid thin;
}

.eligible-federal tr td:last-child{
  border-right:none;
}

.cash-medical td.serial_count{
  width: auto;
}

h3.page-title{
  color: #333;
  font-weight: 600;
  margin-bottom: 30px;
}

.preparedby tr td h3, .preparedby tr td select{
  color: #333;
  font-size: 18px;
  line-height: 2;
  font-weight: 600;
}

tfoot, .print-header{
  display: none
}
.dummy-text{
  opacity: 0;
  display: none;
}


.printingW {
  width: 269px;
}

.printingW1 {
  width: 274px;
}

.countryW{
  width: 274px;
}

.setsW{
  width: 292px;
}

.administrativeW {
  width: 269px;
}

select#county_name {
    font-size: 16px;
    text-align-last: center;
}

.anual-child-care tr.L21d-tr input[type="text"] {
    width: 60px!important;
    font-size: 13px!important;
}

body{min-width: 1170px;width: 100%;}

body .container {max-width: 100%;width: 1140px;}

body .container .container{width: 100%;padding:0;}




@media (max-width:800px){

    .table_outer {
      width: 1080px;
    }

    .Tableworksheet_Outer{
      overflow: auto;
    }

    .table_outer tr td{
      padding: 2px;
    }

    .recordInner_heading, .Cell_obligee b, .Cell_obligor b , .Cell_obligee strong, .Cell_obligor strong{
      font-weight: bold;
    }

    .input_field_wrapper input[type="text"], .input_field_wrapper input[type="number"],
    table.childtable input:read-only,
    .recordInner_heading, .Cell_obligee b, .Cell_obligor b , .Cell_obligee strong, .Cell_obligor strong , 
    .table_outer tr td,
    .Tableworksheet tr th, .Tableworksheet tr td{
      font-size: 12px !important;
    }

    .input_field_wrapper input[type="text"], .input_field_wrapper input[type="number"]{
      text-align: center !important;
    }

}

@media print{

  @page {
    margin: 15px;
  }

  .container{
    min-width: unset !important;
    float: left;
    margin: 0 !important;
    width: 100% !important;
    max-width: 100% !important;
    padding: 0 !important;
  }
  .row{
    margin: 0 !important
  }
  [class*="col-"]{
    padding: 0 !important;
  }

  .serial_count{
    width:auto;
  }
  #page-wrapper{
      padding: 0
  }
  h1{
    line-height: 1.2;
    font-size: 20px
  }
  h3.page-title{
    margin-bottom: 10px;
  }
  .Tableworksheet tr th{
    font-weight:normal;
    font-size: 14px
  }

  .page-break{
    page-break-before: always !important;
    page-break-after: always;
    page-break-inside: always;
  }

  .print-header{
    display: table-row
  }
  tfoot{
    display: table-footer-group;
  }
  tfoot td{
    border: none !important
  }

  tfoot td:last-child{
    text-align: right;
  }
  .anual-child-care tr>td:first-child {
    width: 130px;
    line-height: normal;
  }
  .anual-child-care tr td {
    padding: 2px 5px;
  }
  .root-last-tr td{
    border-bottom: #000 solid 1px !important;
  }
  .income-share{
    line-height: 1.2
  }
  .desktop-tfoot{
    display: none;
  }
  .Cell_obligee b, .Cell_obligor b , .Cell_obligee strong, .Cell_obligor strong{
    font-size: 16px
  }
  .input_field_wrapper input[type="text"], .input_field_wrapper input[type="number"],
  input::-webkit-input-placeholder, input::placeholder{
    color:#000;
  }
  input:focus{
    outline:none;
  }
  input, select{
    border:none;
  }
  select{
    -webkit-appearance:none;
  }
  .number-input-buttons, footer{
    display: none;
  }
  .well{
    padding:15px;
  }

  .Tableworksheet td.Cell_obligee, .Tableworksheet td.Cell_obligor {
    text-align: center;
  }

  .preparedby tr td h3 select {
    font-weight: 600;
  }

  .dummy-text{
    opacity: 0;
    display: block;
  }

  .dummy-text{
    margin-bottom: 10px !important
  }

  .parentB-td{
    width: 150px !important
  }

  .printingW {
    width: 275px;
  }

  .printingW1{
    width: 277px
  }

  .countryW{
    width: 277px;
  }

  .setsW{
    width: 295px;
  }

  .administrativeW {
    width: 275px;
  }

  tr.bg-grey {
    background: #dadada;
  }

}



@media print{

  .bg-grey th {
      font-weight: bold!important;
  }
  .hide-print-buttons {
    display: none;
  }
}
.input-buttons {
    float: right;
}

</style>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="{{ asset('js/polyfiller.js') }}"></script>

 <script>
  $( function() {
    $( ".datepicker" ).datepicker({});
  } );

  webshims.setOptions('forms-ext', {
    replaceUI: 'auto',
    types: 'number'
});
webshims.polyfill('forms forms-ext');
  </script>

<?php
//$result = $db->query("SELECT calcValueOhio2018(10000,4,1,2,1) AS calculation")->results();
if(isset($postData['OH_Minimum_Wage'])){
  $OH_Minimum_Wage=$postData['OH_Minimum_Wage'];
}
if(isset($OH_Minimum_Wage)){
  $OH_Minimum_Wage=$OH_Minimum_Wage;
}
?>

<div class="row">
 <table width="100%" border="0">
  <?php if(isset($case_data['case_id'])){ ?>
  <tr>
    <td align="left" width="33.33%">
      <input type="button" name="reset" value="Reset to blank" class="btn btn-info hide-print-buttons" onclick="resetFormToBlank();">
    </td>
    <td align="center" width="33.33%">
      <input type="button" name="switch" value="Switch Obligor/Obligee" class="btn btn-info hide-print-buttons" onclick="switchObligorObligee();">
    </td>
    <td align="right" width="33.33%">
        <form method="POST" action="{{route('cases.prefill_from_db_computations_sheet')}}" autocomplete="off">
          @csrf
          <input type="hidden" name="case_id" id="modal_case_id" value="<?php if(isset($case_data['case_id'])){ echo $case_data['case_id']; } ?>" required="" style="display: none;">
          <input type="hidden" name="form_state" id="modal_state_id" value="{{ $sheet_state }}" required="" style="display: none;">

          <input type="radio" id="working" name="computation_sheet_version" value="Working" checked="" style="display: none;">

          <input type="hidden" name="form_custody" value="{{ $sheet_custody }}" style="display: none;">

          <input type="submit" class="btn btn-info hide-print-buttons" value="Fill from database">
        </form>
    </td>
  </tr>
  <?php }?>
  <tr>
    <td align="center" colspan="3">
      <h3 class="page-title">OHIO </br> <?php //echo strtoupper($sheet_custody); ?>SOLE AND SHARED PARENTING CHILD SUPPORT  COMPUTATION WORKSHEET</h3>
    </td>
  </tr>
  <tr>
    <td align="center" colspan="3">
      @if (isset($success))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
                  <strong>{{ $success }}</strong>
          </div>
      @endif
    </td>
  </tr>
  </table>
</div>

<form method="post" action="{{ route('computations.sole-shared') }}" onsubmit="return validateSoleForm();" id="sole_shared_form">
  @csrf
  <input type="hidden" name="sheet_custody" value="{{ $sheet_custody }}">
  <input type="hidden" name="sheet_state" value="{{ $sheet_state }}">
  <input type="hidden" name="chk_prefill" value="{{ $chk_prefill }}">
  <input type="hidden" name="users_attorney_submissions_id" value="<?php echo isset($postData['users_attorney_submissions_id'])?$postData['users_attorney_submissions_id']:''; ?>">
  <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
  <input type="hidden" name="case_id" value="<?php if(isset($case_data['case_id'])){ echo $case_data['case_id']; } ?>">
<div  class="Tableworksheet_Outer">
    <table border="1" bordercolor="#333" class="Tableworksheet table_outer" style="border-bottom:none">
        <tr>
          <td colspan="5" class="p-0">
            <table width="100%" class="tbl_full_width header_inner_table">
                <tr class="bg-grey">
                  <th class="textcenter"><b>Obligee Name</b></th>
                  <th class="textcenter">Obligor Name</th>
                  <th class="textcenter">Date this form is completed</th>
                </tr>
              <tbody>
                <tr>
                  <td>
                    <div class="input_field_wrapper">
                      <input class="textcenter" type="text" name="obligee_name" placeholder="Enter" value="<?php if(isset($postData['obligee_name'])){ echo $postData['obligee_name']; } else if(isset($case_data['client_name'])){ echo $case_data['client_name']; } ?>">
                    </div>
                  </td>
                  <td>
                    <div class="input_field_wrapper">
                      <input class="textcenter" type="text" name="obligor_name" placeholder="Enter" value="<?php if(isset($postData['obligor_name'])){ echo $postData['obligor_name']; } else if(isset($case_data['opponent_name'])){ echo $case_data['opponent_name']; } ?>">
                    </div>
                  </td>
                  <td>
                    <div class="input_field_wrapper">
                      <input class="textcenter" type="text" name="created_at" value="<?php echo date("m/d/Y"); ?>" readonly>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <table width="100%" class="tbl_full_width header_inner_table">
                <tr class="bg-grey">
                  <th class="textcenter countryW">County Name</th>
                  <th class="textcenter setsW">SETS Case Number</th>
                  <th class="textcenter administrativeW">Court or Administrative Order Number</th>
                  <th class="textcenter">Number of Children of the Order</th>
                </tr>
              <tbody>
                <tr class="last-tr">
                  <td>
                    <div class="input_field_wrapper textcenter">
                      <?php $state=isset($sheet_state)?$sheet_state:'';
                        $county_selected = isset($postData['county_name']) ? $postData['county_name'] : '';
                      ?>
                      <p style="display: none;" id="selected_county">{{ $county_selected }}</p>

                      <select id="county_name" class="test county-select" name="county_name" style="font-size: 16px;">
                      <option value="">Choose County</option>
                      </select>
                    </div>
                  </td>
                  <td>
                      <div class="input_field_wrapper">
                        <input class="textcenter" type="text" name="sets_case_number" placeholder="Enter" value="<?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>">
                      </div>
                  </td>
                  <td>
                      <div class="input_field_wrapper">
                        <input class="textcenter" type="text" name="court_administrative_order_number" placeholder="Enter" value="<?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>">
                      </div>
                  </td>
                  <td class="textcenter">
                     <div class="input_field_wrapper">
                      <input class="textcenter" type="number" min="1" max="15" step="1" name="number_children_order" value="<?php echo isset($postData['number_children_order'])?$postData['number_children_order']:''; ?>" placeholder="Enter" required>
                     </div>
                   </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td class="Cell_heading p-0" colspan="2">
            <table width="100%">
              <tr>
                <td class="printingW1"><h1 class="recordInner_heading">I. Gross Income</h1></td>
                <td class="textcenter" style="border-left: #000 solid thin;"><strong>OBLIGEE</strong><br/>Computed Income</td>
                <td class="textcenter printingW" style="border-left: #000 solid thin;"><strong>OBLIGOR</strong><br/>Computed Income</td>
               </tr>
            </table>
          </td>

          <td class="Cell_obligee textcenter"><strong>OBLIGEE</strong></td>
          <td class="Cell_obligor textcenter"><strong>OBLIGOR</strong></td>
        </tr>
        <tr>
          <td class="serial_count">1.</td>
          <td class="pd-0">
            <table width="100%" class="pd-0">
              <tr>
                <td style="width: 30%;">Annual Gross Income</td>
                <td class="textcenter pd-0">
                  <table width="100%" class="anuual-income">
                    <tr>
                      <td>
                        <div class="input_field_wrapper_checkbox textcenter">
                          <input type="radio" id="obligee_1_checks_year" name="obligee_1_radio" class="es_checkbox" value="year" onclick="enableDisableField1('obligee','obligee_1_input_year')" <?php echo ((!isset($postData['obligee_1_radio'])) || ($postData['obligee_1_radio'] == 'year')) ? 'checked' : ''; ?>>
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="obligee_1_input_year" placeholder="Checks/Year" class="sfont currency" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligee_1_input_year" readonly value="<?php echo (isset($postData['obligee_1_input_year']))?$postData['obligee_1_input_year']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligee');">
                        </div>
                      </td>
                      <td class="textcenter">
                        <select name="obligee_1_dropdown" id="obligee_1_dropdown" onchange="callCalcuAnnualGrossIncome('obligee')" class="textcenter">
                          <option value="0" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 0)) ? 'selected' : '' ?>>Frequency</option>
                          <option value="1" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 1)) ? 'selected' : '' ?>>Yearly</option>
                          <option value="12" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 12)) ? 'selected' : '' ?>>Monthly</option>
                          <option value="24" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 24)) ? 'selected' : '' ?>>Bi-Monthly</option>
                          <option value="26" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 26)) ? 'selected' : '' ?>>Bi-Weekly</option>
                          <option value="52" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 52)) ? 'selected' : '' ?>>Weekly</option>
                        </select>
                      </td>
                      <td>
                        <div class="input_field_wrapper_checkbox textcenter">
                          <input type="radio" id="obligor_1_checks_year" name="obligor_1_radio" class="es_checkbox" value="year" onclick="enableDisableField1('obligor','obligor_1_input_year')" <?php echo ((!isset($postData['obligor_1_radio'])) || ($postData['obligor_1_radio'] == 'year')) ? 'checked' : ''; ?>>
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="obligor_1_input_year" placeholder="Checks/Year" class="sfont currency" aria-required="true" inputmode="numeric" aria-labelledby="" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligor_1_input_year" readonly value="<?php echo (isset($postData['obligor_1_input_year']))?$postData['obligor_1_input_year']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligor');">
                        </div>
                      </td>
                      <td class="textcenter">
                        <select name="obligor_1_dropdown" onchange="callCalcuAnnualGrossIncome('obligor')" id="obligor_1_dropdown" class="textcenter">
                          <option value="0" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 0)) ? 'selected' : '' ?>>Frequency</option>
                          <option value="1" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 1)) ? 'selected' : '' ?>>Yearly</option>
                          <option value="12" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 12)) ? 'selected' : '' ?>>Monthly</option>
                          <option value="24" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 24)) ? 'selected' : '' ?>>Bi-Monthly</option>
                          <option value="26" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 26)) ? 'selected' : '' ?>>Bi-Weekly</option>
                          <option value="52" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 52)) ? 'selected' : '' ?>>Weekly</option>
                      </select>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="input_field_wrapper_checkbox textcenter">
                          <input type="radio" id="obligee_1_ytd_chk_date" name="obligee_1_radio" class="es_checkbox" value="ytd" onclick="enableDisableField1('obligee','obligee_1_input_ytd')" <?php echo ((isset($postData['obligee_1_radio'])) && ($postData['obligee_1_radio'] == 'ytd')) ? 'checked' : ''; ?>>
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="obligee_1_input_ytd" placeholder="Gross YTD" class="sfont currency" aria-required="true" inputmode="numeric" aria-labelledby="" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligee_1_input_ytd" readonly value="<?php echo (isset($postData['obligee_1_input_ytd']))?$postData['obligee_1_input_ytd']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligee');">
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper">
                          <input class="textcenter datepicker sfont" type="text" id="obligee_1_datepick" name="obligee_1_datepick" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="Pay Date" value="<?php echo (isset($postData['obligee_1_datepick']))?$postData['obligee_1_datepick']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligee')">
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper_checkbox textcenter">
                          <input type="radio" id="obligor_1_ytd_chk_date" name="obligor_1_radio" class="es_checkbox" value="ytd" onclick="enableDisableField1('obligor','obligor_1_input_ytd')" <?php echo ((isset($postData['obligor_1_radio'])) && ($postData['obligor_1_radio'] == 'ytd')) ? 'checked' : ''; ?>>
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper">
                        <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="obligor_1_input_ytd" placeholder="Gross YTD" class="currency sfont" aria-required="true" inputmode="numeric" aria-labelledby="" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligor_1_input_ytd" readonly value="<?php echo (isset($postData['obligor_1_input_ytd']))?$postData['obligor_1_input_ytd']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligor');">
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper">
                          <input class="textcenter datepicker sfont" type="text" id="obligor_1_datepick" name="obligor_1_datepick" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="Pay Date" value="<?php echo isset($postData['obligor_1_datepick'])?$postData['obligor_1_datepick']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligor')">
                        </div>
                      </td>
                    </tr>
                    <tr class="last-tr">
                      <td>
                        <div class="input_field_wrapper_checkbox textcenter">
                          <input type="radio" id="obligee_1_ohio_minimum_wage" name="obligee_1_radio" class="es_checkbox" value="oh_min_wage" onclick="enableDisableField1('obligee','default')" <?php echo ((isset($postData['obligee_1_radio'])) && ($postData['obligee_1_radio'] == 'oh_min_wage')) ? 'checked' : ''; ?>>
                        </div>
                      </td>
                      <td colspan="2" class="text-center">Ohio Minimum Wage</td>
                      <td>
                        <div class="input_field_wrapper_checkbox textcenter">
                          <input type="radio" id="obligor_1_ohio_minimum_wage" name="obligor_1_radio" class="es_checkbox" value="oh_min_wage" onclick="enableDisableField1('obligor','default')" <?php echo ((isset($postData['obligor_1_radio'])) && ($postData['obligor_1_radio'] == 'oh_min_wage')) ? 'checked' : ''; ?>>
                        </div>
                      </td>
                      <td colspan="2" class="text-center">Ohio Minimum Wage</td>
                    </tr>
                  </table>
                </td>
               </tr>
            </table>
          </td>

          <td>
              <div class="input_field_wrapper hide-inputbtns">
                <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-right currency" type="number" id="obligee_1" name="obligee_1" placeholder="Calculate" value="<?php echo isset($postData['obligee_1'])?$postData['obligee_1']:0; ?>" required min=0 readonly>
              </div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency"  type="number" id="obligor_1" name="obligor_1" placeholder="Enter" value="<?php echo isset($postData['obligor_1'])?$postData['obligor_1']:0; ?>" required min=0 readonly></div></td>
        </tr>


        <tr>
          <td rowspan="5" class="serial_count">2.</td>
          <td colspan="3" class="highligt_row">Annual amount of overtime, bonuses, and commissions</td>
        </tr>
        <tr>

          <?php $currentYear = date("Y"); ?>

          <td>a. Year 3 (Three years ago - <?php echo ($currentYear - 3); ?>)</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_2a" name="obligee_2a" placeholder="Enter" value="<?php echo isset($postData['obligee_2a'])?$postData['obligee_2a']:''; ?>"></div>
          </td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency"  type="number" id="obligor_2a" name="obligor_2a" placeholder="Enter" value="<?php echo isset($postData['obligor_2a'])?$postData['obligor_2a']:''; ?>">
            </div>
          </td>
        </tr>
        <tr>

          <td>b. Year 2 (Two years ago - <?php echo ($currentYear - 2); ?>)</td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency"  type="number" id="obligee_2b" name="obligee_2b" placeholder="Enter" value="<?php echo isset($postData['obligee_2b'])?$postData['obligee_2b']:''; ?>">
            </div>
          </td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency"  type="number" id="obligor_2b" name="obligor_2b" placeholder="Enter" value="<?php echo isset($postData['obligor_2b'])?$postData['obligor_2b']:''; ?>">
            </div>
          </td>
        </tr>
        <tr>

          <td>c. Year 1 (Last calendar year - <?php echo ($currentYear - 1); ?>)</td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency"  type="number" id="obligee_2c" name="obligee_2c" placeholder="Enter" value="<?php echo isset($postData['obligee_2c'])?$postData['obligee_2c']:''; ?>">
            </div>
          </td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency"  type="number" id="obligor_2c" name="obligor_2c" placeholder="Enter" value="<?php echo isset($postData['obligor_2c'])?$postData['obligor_2c']:''; ?>">
            </div>
          </td>
        </tr>
        <tr>

          <td>d. Income from overtime, bonuses, and commissions (Enter the lower of the average of
    Line 2a plus Line 2b plus Line 2c, or Line 2c)</td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency"  type="number" id="obligee_2d" name="obligee_2d" placeholder="Calculate" readonly value="<?php echo isset($postData['obligee_2d'])?$postData['obligee_2d']:''; ?>">
            </div>
          </td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_2d" name="obligor_2d" placeholder="Calculate" value="<?php echo isset($postData['obligor_2d'])?$postData['obligor_2d']:''; ?>" readonly>
            </div>
          </td>
        </tr>


        <tr>
          <td rowspan="5" class="serial_count">3.</td>
          <td colspan="3" class="highligt_row">Calculation for Self-Employment Income </td>
        </tr>
        <tr>

          <td>a. Gross receipts from business</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency"  type="number" id="obligee_3a" name="obligee_3a" placeholder="Enter" value="<?php echo isset($postData['obligee_3a'])?$postData['obligee_3a']:''; ?>"></div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_3a" name="obligor_3a" placeholder="Enter" value="<?php echo isset($postData['obligor_3a'])?$postData['obligor_3a']:''; ?>"></div>
          </td>
        </tr>
        <tr>

          <td>b. Ordinary and necessary business expenses</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligee_3b" name="obligee_3b" placeholder="Enter" value="<?php echo isset($postData['obligee_3b'])?$postData['obligee_3b']:''; ?>"></div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_3b" name="obligor_3b" placeholder="Enter" value="<?php echo isset($postData['obligor_3b'])?$postData['obligor_3b']:''; ?>"></div>
          </td>
        </tr>
        <tr>
          <td class="pd-0">

      <table width="100%" class="table-3c">
        <tr>
          <td class="border-bottom-none border-left-none">c. 6.2% of adjusted gross income or actual marginal difference between actual rate paid and F.I.C.A rate</td>
          <td class="border-0 p-0">
            <table width="100%">
              <tr>
                <td></td>
                <td class="text-center">
                  <strong>Obligee</strong>
                </td>
                <td></td>
                <td class="text-center">
                  <strong>Obligee</strong>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="input_field_wrapper_checkbox textcenter">
                    <input type="radio" id="obligee_3_c_top_override" name="obligee_3_c_radio" class="es_checkbox" value="calculation" onclick="radio3cAction('obligee', 'calculation')" <?php echo ((!isset($postData['obligee_3_c_radio'])) || ($postData['obligee_3_c_radio'] != 'manual')) ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper hide-inputbtns">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textleft currency " type="number" id="obligee_3_c_top_override_input" name="obligee_3_c_top_override_input" placeholder="Calculated" readonly value="<?php echo isset($postData['obligee_3_c_top_override_input'])?$postData['obligee_3_c_top_override_input']:''; ?>"><br/>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper_checkbox textcenter">
                    <input type="radio" id="obligor_3_c_top_override" name="obligor_3_c_radio" class="es_checkbox" value="calculation" onclick="radio3cAction('obligor', 'calculation')" <?php echo ((!isset($postData['obligor_3_c_radio'])) || ($postData['obligor_3_c_radio'] != 'manual')) ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper hide-inputbtns">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textleft currency " type="number" id="obligor_3_c_top_override_input" name="obligor_3_c_top_override_input" placeholder="Calculated" readonly value="<?php echo isset($postData['obligor_3_c_top_override_input'])?$postData['obligor_3_c_top_override_input']:''; ?>"><br/>
                  </div>
                </td>
              </tr>
              <tr class="last-tr">
                <td>
                  <div class="input_field_wrapper_checkbox textcenter">
                    <input type="radio" id="obligee_3_c_override" name="obligee_3_c_radio" class="es_checkbox" value="manual" onclick="radio3cAction('obligee', 'manual')" <?php echo ((isset($postData['obligee_3_c_radio'])) && ($postData['obligee_3_c_radio'] == 'manual')) ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper hide-inputbtns">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textleft currency" type="number" id="obligee_3_c_override_input" name="obligee_3_c_override_input" placeholder="Actual" readonly value="<?php echo isset($postData['obligee_3_c_override_input'])?$postData['obligee_3_c_override_input']:''; ?>"><br/>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper_checkbox textcenter">
                    <input type="radio" id="obligor_3_c_override" name="obligor_3_c_radio" class="es_checkbox" value="manual" onclick="radio3cAction('obligor', 'manual')" <?php echo ((isset($postData['obligor_3_c_radio'])) && ($postData['obligor_3_c_radio'] == 'manual')) ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper hide-inputbtns">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textleft currency" type="number" id="obligor_3_c_override_input" name="obligor_3_c_override_input" placeholder="Actual" readonly value="<?php echo isset($postData['obligor_3_c_override_input'])?$postData['obligor_3_c_override_input']:''; ?>"><br/>
                  </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      </td>

          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_3c" name="obligee_3c" placeholder="Calculate" value="<?php echo isset($postData['obligee_3c'])?$postData['obligee_3c']:''; ?>" readonly></div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_3c" name="obligor_3c" placeholder="Calculate" value="<?php echo isset($postData['obligor_3c'])?$postData['obligor_3c']:''; ?>" readonly></div>
          </td>
        </tr>
        <tr>

          <td>d. Adjusted annual gross income from self-employment (Line 3a minus Line 3b minus Line 3c)</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligee_3d" name="obligee_3d" placeholder="Calculate" value="<?php echo isset($postData['obligee_3d'])?$postData['obligee_3d']:''; ?>" readonly></div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_3d" name="obligor_3d"  placeholder="Calculate" value="<?php echo isset($postData['obligor_3d'])?$postData['obligor_3d']:''; ?>" readonly></div>
          </td>
        </tr>

        <tr>
          <td class="serial_count">4.</td>
          <td>Annual income from unemployment compensation</td>
          <td><div  class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_4" name="obligee_4" placeholder="Enter" value="<?php echo isset($postData['obligee_4'])?$postData['obligee_4']:''; ?>"></div>
            </td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"   class="textright currency" type="number" id="obligor_4" name="obligor_4"  placeholder="Enter" value="<?php echo isset($postData['obligor_4'])?$postData['obligor_4']:''; ?>"></div>
          </td>
        </tr>



        <tr>
          <td class="serial_count">5.</td>
          <td>Annual income from workers' compensation, disability insurance, or social security disability/retirement benefits</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_5" name="obligee_5" placeholder="Enter" value="<?php echo isset($postData['obligee_5'])?$postData['obligee_5']:''; ?>"></div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_5" name="obligor_5"  placeholder="Enter" value="<?php echo isset($postData['obligor_5'])?$postData['obligor_5']:''; ?>"></div>
          </td>
        </tr>
        <tr>
          <td class="serial_count">6.</td>
          <td>Other annual income or potential income</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_6" name="obligee_6" placeholder="Enter" value="<?php echo isset($postData['obligee_6'])?$postData['obligee_6']:''; ?>"></div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_6" name="obligor_6"  placeholder="Enter" value="<?php echo isset($postData['obligor_6'])?$postData['obligor_6']:''; ?>"></div></td>
        </tr>

        <tr>
          <td class="serial_count">7.</td>
          <td>Total annual gross income (Add Lines 1, 2d, 3d, 4, 5 and 6, if Line 7 results in a negative
amount, enter “0”)</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_7" name="obligee_7" placeholder="Calculate" value="<?php echo isset($postData['obligee_7'])?$postData['obligee_7']:''; ?>" readonly></div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_7" name="obligor_7"  placeholder="Calculate" value="<?php echo isset($postData['obligor_7'])?$postData['obligor_7']:''; ?>" readonly></div>
          </td>
        </tr>
        <tr>
          <td class="serial_count">8.</td>
          <td>Health insurance maximum (Multiply Line 7 by 5% or .05)</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_8" name="obligee_8" placeholder="Calculate" value="<?php echo isset($postData['obligee_8'])?$postData['obligee_8']:''; ?>" readonly></div>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_8" name="obligor_8"  placeholder="Calculate" value="<?php echo isset($postData['obligor_8'])?$postData['obligor_8']:''; ?>" readonly></div>
          </td>
        </tr>


        <tr>
          <td class="Cell_heading" colspan="2"><h1 class="recordInner_heading">II. ADJUSTMENTS TO INCOME</h1> </td>
          <td class="Cell_obligee"><b>OBLIGEE</b></td>
          <td class="Cell_obligor"><b>OBLIGOR</b></td>
        </tr>
        <tr>
          <td rowspan="7" class="serial_count">9.</td>
          <td colspan="3" class="highligt_row">Adjustment for Other Minor Children Not of This Order. <b>(Note: Line 9 is only completed if either parent has any children outside of this order.) If neither parent has any children outside of this order enter "0" on Line 9f and proceed to Line 10.
          For each parent:</b></td>
        </tr>
        <tr>

          <td>a. Enter the total number of children, including children of this order and other children</td>

          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input step="1" class="textcenter currency" type="number" id="obligee_9a" name="obligee_9a" placeholder="Enter" value="<?php echo isset($postData['obligee_9a'])?$postData['obligee_9a']:''; ?>">
            </div>
          </td>

          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input step="1" class="textcenter currency" type="number" id="obligor_9a" name="obligor_9a" placeholder="Enter" value="<?php echo isset($postData['obligor_9a'])?$postData['obligor_9a']:''; ?>">
            </div>
          </td>

        </tr>
        <tr>

          <td>b. Enter the number of children subject to this order</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input step="1" class="textcenter currency" type="number" id="obligee_9b" name="obligee_9b" placeholder="Enter" value="<?php echo isset($postData['obligee_9b'])?$postData['obligee_9b']:''; ?>"></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input step="1" class="textcenter currency" type="number" id="obligor_9b" name="obligor_9b" placeholder="Enter" value="<?php echo isset($postData['obligor_9b'])?$postData['obligor_9b']:''; ?>"></div></td>
        </tr>
        <tr>

          <td>c. Line 9a minus Line 9b</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input step="1" class="textcenter currency" type="number" id="obligee_9c" name="obligee_9c" placeholder="Calculate" value="<?php echo isset($postData['obligee_9c'])?$postData['obligee_9c']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input step="1" class="textcenter currency" type="number" id="obligor_9c" name="obligor_9c" placeholder="Calculate" value="<?php echo isset($postData['obligor_9c'])?$postData['obligor_9c']:''; ?>" readonly></div></td>
        </tr>
        <tr>

          <td>d. Using the Basic Child Support Schedule, enter the amount from the corresponding cell
    <u>for each parent’s total annual gross income</u> from Line 7 for the number of children on Line 9a</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_9d" name="obligee_9d" placeholder="Calculate" value="<?php echo isset($postData['obligee_9d'])?$postData['obligee_9d']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_9d" name="obligor_9d" placeholder="Calculate" readonly value="<?php echo isset($postData['obligor_9d'])?$postData['obligor_9d']:''; ?>"></div></td>
        </tr>

        <tr>
          <td>e. Divide the amount on Line 9d by the number on Line 9a</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_9e" name="obligee_9e" placeholder="Calculate" value="<?php echo isset($postData['obligee_9e'])?$postData['obligee_9e']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_9e" name="obligor_9e"  placeholder="Calculate" value="<?php echo isset($postData['obligor_9e'])?$postData['obligor_9e']:''; ?>" readonly=""></div></td>
        </tr>
        <tr>
          <td>f. Multiply the amount from Line 9e by the number on Line 9c. This is the adjustment
   amount for other minor children for each parent.</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_9f" name="obligee_9f" placeholder="Calculate" value="<?php echo isset($postData['obligee_9f'])?$postData['obligee_9f']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_9f" name="obligor_9f"  placeholder="Calculate" value="<?php echo isset($postData['obligor_9f'])?$postData['obligor_9f']:''; ?>" readonly></div></td>
        </tr>





        <tr>
          <td rowspan="3" class="serial_count">10.</td>
          <td colspan="3" class="highligt_row">Adjustment for Out-of-Pocket Health Insurance Premiums</td>
        </tr>
        <tr>

          <td>a. Identify the health insurance obligor(s). </td>
          <td>
            <div class="input_field_wrapper_checkbox textcenter" >
              <input type="checkbox" id="obligee_10a" name="obligee_10a" class="es_checkbox" value="1" <?php if(isset($postData['obligee_10a']) && $postData['obligee_10a']==1) { echo 'checked'; } ?>>

            </div>
          </td>
          <td>
            <div class="input_field_wrapper_checkbox textcenter">
              <input type="checkbox" id="obligor_10a" name="obligor_10a"  class="es_checkbox" value="1" e="1" <?php if(isset($postData['obligor_10a']) && $postData['obligor_10a']==1) { echo 'checked'; } ?>>

            </div>
          </td>
        </tr>
        <tr>

          <td>b. Enter the total out-of-pocket costs for health insurance premiums for the
    parent(s) identified on Line 10a.</td>
          <td><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" id="obligee_10b"  class="textright currency" name="obligee_10b" placeholder="Enter" value="<?php echo isset($postData['obligee_10b'])?$postData['obligee_10b']:''; ?>">
          </div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_10b" name="obligor_10b"  value="<?php echo isset($postData['obligor_10b'])?$postData['obligor_10b']:''; ?>" placeholder="Enter"></div></td>
        </tr>
        <tr>
          <td class="serial_count">11.</td>
          <td>Annual court ordered spousal support paid; if no spousal support is paid, enter “0”</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_11" name="obligee_11" placeholder="Enter" value="<?php echo isset($postData['obligee_11'])?$postData['obligee_11']:''; ?>"></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_11" name="obligor_11"  placeholder="Enter" value="<?php echo isset($postData['obligor_11'])?$postData['obligor_11']:''; ?>"></div></td>
        </tr>

        <tr>
          <td class="serial_count">12.</td>
          <td>Total adjustments to income (Line 9f, plus Line 10b, plus Line 11)</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_12" name="obligee_12" placeholder="Calculate" value="<?php echo isset($postData['obligee_12'])?$postData['obligee_12']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_12" name="obligor_12"  placeholder="Calculate" value="<?php echo isset($postData['obligor_12'])?$postData['obligor_12']:''; ?>" readonly></div></td>
        </tr>
        <tr class="root-last-tr">
          <td class="serial_count">13.</td>
          <td>Adjusted annual gross income (Line 7 minus Line 12; if Line 13 results in a negative
amount, enter "0")</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_13" name="obligee_13" placeholder="Calculate" value="<?php echo isset($postData['obligee_13'])?$postData['obligee_13']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_13" name="obligor_13"  placeholder="Calculate"  value="<?php echo isset($postData['obligor_13'])?$postData['obligor_13']:''; ?>" readonly></div></td>
        </tr>
        <tfoot style="border-left: #FFF solid thin;">
          <tr>
            <td colspan="3">© First Draft Data, LLC. All Rights Reserved. V -1</td>
            <td align="right">Page 1 of 3</td>
          </tr>
        </tfoot>
</table>
<div class="page-break"></div><div class="dummy-text">text</div>
  <table border="1" bordercolor="#333" class="Tableworksheet table_outer income-share page-2" style="border-bottom:none">
      <tr class="print-header">
        <td colspan="5" class="p-0">
          <table width="100%" class="tbl_full_width header_inner_table">
              <tr class="bg-grey">
                <th class="textcenter">Obligee Name</th>
                <th class="textcenter">Obligor Name</th>
                <th class="textcenter" width="242">Date this form is completed</th>
              </tr>
            <tbody>
              <tr>
                <td>
                  <div class="input_field_wrapper">
                    <input class="textcenter" type="text" name="obligee_name1" placeholder="Enter" value="<?php echo isset($postData['obligee_name'])?$postData['obligee_name']:''; ?>" >
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper">
                    <input class="textcenter" type="text" name="obligor_name1" placeholder="Enter" value="<?php echo isset($postData['obligor_name'])?$postData['obligor_name']:''; ?>">
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper">
                    <input class="textcenter" type="text" name="created_at1" value="<?php echo date("m/d/Y"); ?>" readonly>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <table width="100%" class="tbl_full_width header_inner_table">
              <tr class="bg-grey">
                <th class="textcenter">County Name</th>
                <th class="textcenter" width="292">SETS Case Number</th>
                <th class="textcenter" width="269">Court or Administrative Order Number</th>
                <th class="textcenter" width="242">Number of Children of the Order</th>
              </tr>
            <tbody>
              <tr class="last-tr">
                <td class="textcenter">
                  <div class="input_field_wrapper">
                    <?php $state=isset($sheet_state)?$sheet_state:'';
                      $county_selected = isset($postData['county_name']) ? $postData['county_name'] : '';
                    ?>

                    <select class="textcenter" id="county_name1" class="county-select" name="county_name1" style="font-size: 16px;">
                    <option value="">Choose County</option>
                    </select>
                  </div>
                </td>
                <td>
                    <div class="input_field_wrapper">
                      <input class="textcenter" type="text" name="sets_case_number1" placeholder="Enter" value="<?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>">
                    </div>
                </td>
                <td>
                    <div class="input_field_wrapper">
                      <input class="textcenter" type="text" name="court_administrative_order_number1" placeholder="Enter" value="<?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>">
                    </div>
                </td>
                <td class="textcenter">
                   <div class="input_field_wrapper">
                    <input class="textcenter" type="text" min="1" max="15" step="1" name="number_children_order1" value="<?php echo isset($postData['number_children_order'])?$postData['number_children_order']:''; ?>" placeholder="Enter">
                   </div>
                 </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
        <tr>
          <td class="Cell_heading" colspan="2"><h1 class="recordInner_heading">III. INCOME SHARES</h1> </td>
          <td class="Cell_obligee"><b>OBLIGEE</b></td>
          <td class="Cell_obligor"><b>OBLIGOR</b></td>
        </tr>
        <tr>
          <td class="serial_count">14.</td>
          <td>Enter the amount from Line 13 for each parent (Adjusted annual gross income)</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_14" name="obligee_14" placeholder="Calculate" value="<?php echo isset($postData['obligee_14'])?$postData['obligee_14']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_14" name="obligor_14"  placeholder="Calculate" value="<?php echo isset($postData['obligor_14'])?$postData['obligor_14']:''; ?>" readonly></div></td>
        </tr>
        <tr>
          <td class="serial_count">15.</td>
          <td>Using the Basic Child Support Schedule and the parent’s individual income on Line 14, determine if the parent’s obligation is located in the shaded area of the schedule. If the parent’s obligation is in the shaded area of the schedule for the children of this order, check the box for Line 15
</td>
          <td>
            <div class="input_field_wrapper_checkbox textcenter">
              <input type="checkbox" id="obligee_15_shown" class="es_checkbox" value="" <?php if(isset($postData['obligee_15']) && $postData['obligee_15']==1) { echo 'checked'; } ?> disabled>
              <input type="checkbox" style="display:none;" id="obligee_15" name="obligee_15"  class="es_checkbox" value="1" <?php if(isset($postData['obligee_15']) && $postData['obligee_15']==1) { echo 'checked'; } ?>>
            </div>
          </td>
          <td>
            <div class="input_field_wrapper_checkbox textcenter">
              <input type="checkbox" id="obligor_15_shown" class="es_checkbox" value="" <?php if(isset($postData['obligor_15']) && $postData['obligor_15']==1) { echo 'checked'; } ?> disabled>
              <input type="checkbox"  style="display:none;" id="obligor_15" name="obligor_15"  class="es_checkbox" value="1" <?php if(isset($postData['obligor_15']) && $postData['obligor_15']==1) { echo 'checked'; } ?>>
            </div>
          </td>
        </tr>
        <tr>
          <td class="serial_count">16.</td>
          <td>Combined adjusted annual gross income (Add together the amounts of Line 14 for both parents)</td>
          <td colspan="2"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textcenter" type="number" id="obligee_16" name="obligee_16" value="<?php echo isset($postData['obligee_16'])?$postData['obligee_16']:''; ?>" placeholder="Calculate" readonly></div></td>
        </tr>

        <tr>
          <td class="serial_count">17.</td>
          <td>Income Share: Enter the percentage of parent's income to combined annual adjusted gross income (Line 14 divided by Line 16 for each parent)</td>
          <td><div class="input_field_wrapper hide-inputbtns  percentage_end">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_17" name="obligee_17" placeholder="Calculate" value="<?php echo isset($postData['obligee_17'])?$postData['obligee_17']:''; ?>" readonly>
          </div></td>
          <td><div class="input_field_wrapper hide-inputbtns percentage_end"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_17" name="obligor_17"  placeholder="Calculate" value="<?php echo isset($postData['obligor_17'])?$postData['obligor_17']:''; ?>" readonly></div></td>
        </tr>
        <tr>
          <td class="Cell_heading" colspan="2"><h1 class="recordInner_heading">IV. SUPPORT CALCULATION</h1> </td>
          <td class="Cell_obligee"><b>OBLIGEE</b></td>
          <td class="Cell_obligor"><b>OBLIGOR</b></td>
        </tr>

        <tr>
          <td rowspan="5" class="serial_count">18.</td>
          <td colspan="3" class="highligt_row">Basic Child Support Obligation</td>
        </tr>

        <tr>
          <td>a. Using the Basic Child Support Schedule, enter the amount from the corresponding cell for each  parent’s adjusted gross income on Line 14 for the number of children of this order. If either parent’s Line 14 amount is less than lowest income amount on the Basic Schedule, enter “960” </td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_18a" name="obligee_18a" placeholder="Calculate" value="<?php echo isset($postData['obligee_18a'])?$postData['obligee_18a']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_18a" name="obligor_18a"  placeholder="Calculate" value="<?php echo isset($postData['obligor_18a'])?$postData['obligor_18a']:''; ?>" readonly></div></td>
        </tr>
        <tr>
          <td>b. Using the Basic Child Support Schedule, enter the amount from the corresponding cell <u>for the  parents’ combined annual gross income</u> on Line 16 for the number of children of this order.  If Line 16 amount is less than lowest income amount on the Basic Schedule, enter “960” </td>
          <td colspan="2"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textcenter" type="number" id="obligee_18b" name="obligee_18b" placeholder="Calculate" value="<?php echo isset($postData['obligee_18b'])?$postData['obligee_18b']:''; ?>" readonly></div></td>
        </tr>
        <tr>
          <td>c. Multiply the amount in Line 18b by Line 17 for each parent. Enter the amount for each parent  </td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_18c" name="obligee_18c" placeholder="Calculate" value="<?php echo isset($postData['obligee_18c'])?$postData['obligee_18c']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_18c" name="obligor_18c"  placeholder="Calculate" value="<?php echo isset($postData['obligor_18c'])?$postData['obligor_18c']:''; ?>" readonly></div></td>
        </tr>
        <tr>
          <td>d. Enter the lower of Line 18a or Line 18c for each parent, if less than “960”, enter “960”</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_18d" name="obligee_18d" placeholder="Calculate" value="<?php echo isset($postData['obligee_18d'])?$postData['obligee_18d']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency"  type="number" id="obligor_18d" name="obligor_18d" placeholder="Calculate" value="<?php echo isset($postData['obligor_18d'])?$postData['obligor_18d']:''; ?>" readonly></div></td>
        </tr>



        <tr>
          <td rowspan="3" class="serial_count">19.</td>
          <td colspan="3" class="highligt_row">Parenting Time Order</td>
        </tr>

        <tr>
          <td>a. Enter “Yes” for any parent for whom a court has issued or is issuing a parenting time order that equals or exceeds ninety overnights per year</td>

          <td><div class="input_field_wrapper_checkbox textcenter">
            <input type="checkbox" id="obligee_19a" name="obligee_19a" class="es_checkbox" value="1" <?php if(isset($postData['obligee_19a']) && $postData['obligee_19a']==1) { echo 'checked'; } ?>>
            <label for="checkbox5">Yes</label>
          </div></td>
          <td><div class="input_field_wrapper_checkbox textcenter">
            <input type="checkbox" id="obligor_19a" name="obligor_19a"  class="es_checkbox" value="1" <?php if(isset($postData['obligor_19a']) && $postData['obligor_19a']==1) { echo 'checked'; } ?>>
            <label for="checkbox6">Yes</label>
          </div></td>
        </tr>
        <tr>
          <td>b. If Line 19a is checked, use the amount for that parent from Line 18d and multiply it by 10% or .10, and enter this amount. If Line 19a is blank enter “0”</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_19b" name="obligee_19b" placeholder="Calculate"  value="<?php echo isset($postData['obligee_19b'])?$postData['obligee_19b']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_19b" name="obligor_19b"  placeholder="Calculate" value="<?php echo isset($postData['obligor_19b'])?$postData['obligor_19b']:''; ?>" readonly></div></td>
        </tr>

        <tr>
          <td rowspan="2" class="serial_count">20.</td>
          <td colspan="3" class="highligt_row">Derivative Benefit</td>
        </tr>
        <tr>
          <td>Enter any non-means-tested benefits received by a child(ren) subject to the order.</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input type="number" data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" id="obligee_20" name="obligee_20" placeholder="Enter"  value="<?php echo isset($postData['obligee_20'])?$postData['obligee_20']:''; ?>"  class="textright currency" ></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input type="number" data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" id="obligor_20" name="obligor_20"  placeholder="Enter"  value="<?php echo isset($postData['obligor_20'])?$postData['obligor_20']:''; ?>"  class="textright currency" ></div></td>
        </tr>
        <tr>
          <td rowspan="12" class="serial_count">21.</td>
          <td colspan="3" class="highligt_row">Child Care Expenses</td>
        </tr>
        <tr>
          <td>a. Annual child care expenses for children of this order (Less any subsidies)</td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21a" name="obligee_21a" placeholder="Calculate"  value="<?php echo isset($postData['obligee_21a'])?$postData['obligee_21a']:''; ?>" readonly>
            </div>
          </td>
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input  class="textright currency" type="number" id="obligor_21a" name="obligor_21a" data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" placeholder="Calculate" value="<?php echo isset($postData['obligor_21a'])?$postData['obligor_21a']:''; ?>" readonly>
            </div>
          </td>

        </tr>
        <tr>
          <td colspan="3" class="inner_table_wrapper">
            <table border="1" class="anual-child-care tbl_full_width  inner_table childtable tbl-input-full">
              <tbody>
                <tr>
                  <td></td>
                  <td class="textcenter sfont">Child 1</td>
                  <td class="textcenter  sfont">Child 2</td>
                  <td class="textcenter  sfont">Child 3</td>
                  <td class="textcenter  sfont">Child 4</td>
                  <td class="textcenter  sfont">Child 5</td>
                  <td class="textcenter  sfont">Child 6</td>
                </tr>
                <tr>
                  <td>Birthdate</td>

                  <td><div class="input_field_wrapper"><input class="textcenter datepicker sfont" type="text" id="obligee_21b1" name="obligee_21b1" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="mm/dd/YYYY" value="<?php echo isset($postData['obligee_21b1'])?$postData['obligee_21b1']:''; ?>"></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter datepicker sfont"type="text" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" id="obligee_21b2" name="obligee_21b2" placeholder="mm/dd/YYYY" value="<?php echo isset($postData['obligee_21b2'])?$postData['obligee_21b2']:''; ?>"></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter datepicker sfont"type="text" id="obligee_21b3" name="obligee_21b3" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="mm/dd/YYYY" value="<?php echo isset($postData['obligee_21b3'])?$postData['obligee_21b3']:''; ?>"></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter datepicker sfont" type="text" id="obligee_21b4" name="obligee_21b4" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="mm/dd/YYYY" value="<?php echo isset($postData['obligee_21b4'])?$postData['obligee_21b4']:''; ?>"></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter datepicker sfont"type="text" id="obligee_21b5" name="obligee_21b5" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="mm/dd/YYYY" value="<?php echo isset($postData['obligee_21b5'])?$postData['obligee_21b5']:''; ?>"></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter datepicker sfont" type="text" id="obligee_21b6" name="obligee_21b6" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="mm/dd/YYYY" value="<?php echo isset($postData['obligee_21b6'])?$postData['obligee_21b6']:''; ?>"></div></td>
                </tr>
                <tr>
                  <td style="text-align: left;">b. Child Age</td>
                  <td><div class="input_field_wrapper"><input class="textcenter sfont" type="text" id="obligee_21b1a" placeholder="Calculate" name="obligee_21b1a" value="<?php echo isset($postData['obligee_21b1a'])?$postData['obligee_21b1a']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter sfont" type="text" id="obligee_21b2a" name="obligee_21b2a" placeholder="Calculate" value="<?php echo isset($postData['obligee_21b2a'])?$postData['obligee_21b2a']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter sfont" placeholder="Calculate" type="text" id="obligee_21b3a" name="obligee_21b3a" value="<?php echo isset($postData['obligee_21b3a'])?$postData['obligee_21b3a']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter sfont" placeholder="Calculate" type="text" id="obligee_21b4a" name="obligee_21b4a" value="<?php echo isset($postData['obligee_21b4a'])?$postData['obligee_21b4a']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter sfont" placeholder="Calculate" type="text" id="obligee_21b5a" name="obligee_21b5a" value="<?php echo isset($postData['obligee_21b5a'])?$postData['obligee_21b5a']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper"><input class="textcenter sfont" type="text" id="obligee_21b6a" name="obligee_21b6a" placeholder="Calculate" value="<?php echo isset($postData['obligee_21b6a'])?$postData['obligee_21b6a']:''; ?>" readonly></div></td>
                </tr>
                <tr>
                  <td style="text-align: left;">c. Maximum Allowable Cost</td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21c1" name="obligee_21c1" placeholder="Calculate" value="<?php echo isset($postData['obligee_21c1'])?$postData['obligee_21c1']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21c2" name="obligee_21c2" placeholder="Calculate" value="<?php echo isset($postData['obligee_21c2'])?$postData['obligee_21c2']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21c3" name="obligee_21c3" placeholder="Calculate" value="<?php echo isset($postData['obligee_21c3'])?$postData['obligee_21c3']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21c4" name="obligee_21c4" value="<?php echo isset($postData['obligee_21c4'])?$postData['obligee_21c4']:''; ?>" placeholder="Calculate" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21c5" name="obligee_21c5" placeholder="Calculate" value="<?php echo isset($postData['obligee_21c5'])?$postData['obligee_21c5']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21c6" name="obligee_21c6" placeholder="Calculate" value="<?php echo isset($postData['obligee_21c6'])?$postData['obligee_21c6']:''; ?>" readonly></div></td>
                </tr>

                <tr class="L21d-tr">
                  <td style="text-align: left;">d. Actual Out of Pocket</td>
                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <br/>
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21d1" name="obligee_21d1" placeholder="Enter" value="<?php echo isset($postData['obligee_21d1'])?$postData['obligee_21d1']:''; ?>">
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <br/>
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_21d1" name="obligor_21d1" placeholder="Enter" value="<?php echo isset($postData['obligor_21d1'])?$postData['obligor_21d1']:''; ?>"></div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <br/>
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21d2" name="obligee_21d2" placeholder="Enter" value="<?php echo isset($postData['obligee_21d2'])?$postData['obligee_21d2']:''; ?>">
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <br/>
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_21d2" name="obligor_21d2" placeholder="Enter" value="<?php echo isset($postData['obligor_21d2'])?$postData['obligor_21d2']:''; ?>">
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21d3" name="obligee_21d3" placeholder="Enter" value="<?php echo isset($postData['obligee_21d3'])?$postData['obligee_21d3']:''; ?>">
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_21d3" name="obligor_21d3" placeholder="Enter" value="<?php echo isset($postData['obligor_21d3'])?$postData['obligor_21d3']:''; ?>">
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21d4" name="obligee_21d4" placeholder="Enter" value="<?php echo isset($postData['obligee_21d4'])?$postData['obligee_21d4']:''; ?>">
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_21d4" name="obligor_21d4" placeholder="Enter" value="<?php echo isset($postData['obligor_21d4'])?$postData['obligor_21d4']:''; ?>">
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21d5" name="obligee_21d5" placeholder="Enter" value="<?php echo isset($postData['obligee_21d5'])?$postData['obligee_21d5']:''; ?>">
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_21d5" name="obligor_21d5" placeholder="Enter" value="<?php echo isset($postData['obligor_21d5'])?$postData['obligor_21d5']:''; ?>">
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21d6" name="obligee_21d6" placeholder="Enter" value="<?php echo isset($postData['obligee_21d6'])?$postData['obligee_21d6']:''; ?>">
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_21d6" name="obligor_21d6" placeholder="Enter" value="<?php echo isset($postData['obligor_21d6'])?$postData['obligor_21d6']:''; ?>">
                          </div>
                        </td>
                      </tr>
                    </table></td>
                </tr>

                <tr>
                  <td style="text-align: left;">e. Enter lower of Line 21c or 21d</td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21e1" name="obligee_21e1" placeholder="Calculate" value="<?php echo isset($postData['obligee_21e1'])?$postData['obligee_21e1']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21e2" name="obligee_21e2"  placeholder="Calculate" value="<?php echo isset($postData['obligee_21e2'])?$postData['obligee_21e2']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21e3" name="obligee_21e3" value="<?php echo isset($postData['obligee_21e3'])?$postData['obligee_21e3']:''; ?>" placeholder="Calculate" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21e4" name="obligee_21e4" value="<?php echo isset($postData['obligee_21e4'])?$postData['obligee_21e4']:''; ?>"  placeholder="Calculate" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21e5" name="obligee_21e5" value="<?php echo isset($postData['obligee_21e5'])?$postData['obligee_21e5']:''; ?>" placeholder="Calculate" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21e6" name="obligee_21e6"  placeholder="Calculate" value="<?php echo isset($postData['obligee_21e6'])?$postData['obligee_21e6']:''; ?>" readonly></div></td>
                </tr>


                <tr>
                  <td>Apportioned</td>
                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <br/>
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligee_21_1" name="apportioned_obligee_21_1" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligee_21_1'])?$postData['apportioned_obligee_21_1']:''; ?>" readonly>
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <br/>
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligor_21_1" name="apportioned_obligor_21_1" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligor_21_1'])?$postData['apportioned_obligor_21_1']:''; ?>" readonly></div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <br/>
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligee_21_2" name="apportioned_obligee_21_2" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligee_21_2'])?$postData['apportioned_obligee_21_2']:''; ?>" readonly>
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <br/>
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligor_21_2" name="apportioned_obligor_21_2" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligor_21_2'])?$postData['apportioned_obligor_21_2']:''; ?>" readonly>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligee_21_3" name="apportioned_obligee_21_3" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligee_21_3'])?$postData['apportioned_obligee_21_3']:''; ?>" readonly>
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligor_21_3" name="apportioned_obligor_21_3" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligor_21_3'])?$postData['apportioned_obligor_21_3']:''; ?>" readonly>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligee_21_4" name="apportioned_obligee_21_4" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligee_21_4'])?$postData['apportioned_obligee_21_4']:''; ?>" readonly>
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligor_21_4" name="apportioned_obligor_21_4" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligor_21_4'])?$postData['apportioned_obligor_21_4']:''; ?>" readonly>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligee_21_5" name="apportioned_obligee_21_5" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligee_21_5'])?$postData['apportioned_obligee_21_5']:''; ?>" readonly>
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligor_21_5" name="apportioned_obligor_21_5" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligor_21_5'])?$postData['apportioned_obligor_21_5']:''; ?>" readonly>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </td>

                  <td>
                    <table>
                      <tr>
                        <td class="sfont">Obligee
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligee_21_6" name="apportioned_obligee_21_6" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligee_21_6'])?$postData['apportioned_obligee_21_6']:''; ?>" readonly>
                          </div>
                        </td>
                        <td class="sfont">Obligor
                          <div class="input_field_wrapper hide-inputbtns">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="apportioned_obligor_21_6" name="apportioned_obligor_21_6" placeholder="Enter" value="<?php echo isset($postData['apportioned_obligor_21_6'])?$postData['apportioned_obligor_21_6']:''; ?>" readonly>
                          </div>
                        </td>
                      </tr>
                    </table></td>
                </tr>

              </tbody>
            </table>
          </td>
        </tr>

        <tr>
          <td>f. Enter total of Line 21e for children of this order</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligee_21f" name="obligee_21f"  placeholder="Calculate" value="<?php echo isset($postData['obligee_21f'])?$postData['obligee_21f']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_21f" name="obligor_21f"  placeholder="Calculate" value="<?php echo isset($postData['obligor_21f'])?$postData['obligor_21f']:''; ?>" readonly></div></td>
        </tr>

        <tr>
          <td>Federal child care credit percentage (see IRS Pub 503)</td>

          <td>
            <div class="input_field_wrapper hide-inputbtns percentage_end">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21fa" name="obligee_21fa" placeholder="Calculate" value="<?php echo isset($postData['obligee_21fa'])?($postData['obligee_21fa']):''; ?>" readonly>
            </div>
          </td>

          <td>
            <div class="input_field_wrapper hide-inputbtns percentage_end">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_21fa" name="obligor_21fa" placeholder="Calculate" value="<?php echo isset($postData['obligor_21fa'])?($postData['obligor_21fa']):''; ?>" readonly>
            </div>
          </td>

        </tr>

        <tr>
          <td>Federal child care credit (see IRS Pub 503)</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligee_21fb" name="obligee_21fb"  placeholder="Calculate" value="<?php echo isset($postData['obligee_21fb'])?$postData['obligee_21fb']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_21fb" name="obligor_21fb"  placeholder="Calculate" value="<?php echo isset($postData['obligor_21fb'])?$postData['obligor_21fb']:''; ?>" readonly></div></td>
        </tr>

        <tr>
          <td>Ohio child care credit percentage (see Ohio Instructions PIT-IT1040)</td>
      <td><div class="input_field_wrapper hide-inputbtns percentage_end"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligee_21fc" name="obligee_21fc"  placeholder="Calculate" value="<?php echo isset($postData['obligee_21fc'])?($postData['obligee_21fc']):''; ?>" readonly></div></td>
      <td><div class="input_field_wrapper hide-inputbtns percentage_end"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_21fc" name="obligor_21fc"  placeholder="Calculate" value="<?php echo isset($postData['obligor_21fc'])?($postData['obligor_21fc']):''; ?>" readonly></div></td>
        </tr>

        <tr>
          <td>Ohio child care credit (see Ohio Instructions PIT-IT1040)</td>
      <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligee_21fd" name="obligee_21fd"  placeholder="Calculate" value="<?php echo isset($postData['obligee_21fd'])?$postData['obligee_21fd']:''; ?>" readonly></div></td>
      <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_21fd" name="obligor_21fd"  placeholder="Calculate" value="<?php echo isset($postData['obligor_21fd'])?$postData['obligor_21fd']:''; ?>" readonly></div></td>
        </tr>

        <tr>
          <td class="p-0">
            <table class="Tableworksheet income-share eligible-federal">
              <tr>
                <td>g. Enter the eligible federal and state tax credits</td>
                <td colspan="2">Obligee</td>
                <td colspan="2">Obligor</td>
              </tr>
              <tr>
                <td class="text-right">Calculated</td>
                <td>
                  <div class="input_field_wrapper_checkbox textcenter">
                    <input type="radio" id="obligee_21_g_calc" name="obligee_21_g_radio" class="es_checkbox" value="calculation" <?php echo ((!isset($postData['obligee_21_g_radio'])) || ($postData['obligee_21_g_radio'] != 'manual')) ? 'checked' : ''; ?> onclick="radio21gAction('obligee', 'calculation')">
                  </div>
                </td>

                <td>Calculated</td>

                <td>
                  <div class="input_field_wrapper_checkbox textcenter">
                    <input type="radio" id="obligor_21_g_calc" name="obligor_21_g_radio" class="es_checkbox" value="calculation" <?php echo ((!isset($postData['obligor_21_g_radio'])) || ($postData['obligor_21_g_radio'] != 'manual')) ? 'checked' : ''; ?> onclick="radio21gAction('obligor', 'calculation')">
                  </div>
                </td>

                <td>Calculated</td>

              </tr>
              <tr class="last-tr">
                <td class="text-right">Override</td>
                <td>
                  <div class="input_field_wrapper_checkbox textcenter">
                    <input type="radio" id="obligee_21_g_override" name="obligee_21_g_radio" class="es_checkbox" value="manual" onclick="radio21gAction('obligee', 'manual')" <?php echo ((isset($postData['obligee_21_g_radio'])) && ($postData['obligee_21_g_radio'] == 'manual')) ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper hide-inputbtns">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textleft currency " type="number" id="obligee_21_g_override_text" name="obligee_21_g_override_text" placeholder="Actual" value="<?php echo isset($postData['obligee_21_g_override_text'])?$postData['obligee_21_g_override_text']:''; ?>" readonly>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper_checkbox textcenter">
                    <input type="radio" id="obligor_21_g_override" name="obligor_21_g_radio" class="es_checkbox" value="manual" onclick="radio21gAction('obligor', 'manual')" <?php echo ((isset($postData['obligor_21_g_radio'])) && ($postData['obligor_21_g_radio'] == 'manual')) ? 'checked' : ''; ?>>
                  </div>
                </td>
                <td>
                  <div class="input_field_wrapper hide-inputbtns">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textleft currency" type="number" id="obligor_21_g_override_text" name="obligor_21_g_override_text" placeholder="Actual" value="<?php echo isset($postData['obligor_21_g_override_text'])?$postData['obligor_21_g_override_text']:''; ?>" readonly>
                  </div>
                </td>
              </tr>
            </table>
          </td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21g" name="obligee_21g" placeholder="Calculate" value="<?php echo isset($postData['obligee_21g'])?$postData['obligee_21g']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_21g" name="obligor_21g"  placeholder="Calculate" value="<?php echo isset($postData['obligor_21g'])?$postData['obligor_21g']:''; ?>" readonly></div></td>
        </tr>
        <tr>
          <td>h. Line 21f minus combined amounts of Line 21g</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21h" name="obligee_21h" placeholder="Calculate" value="<?php echo isset($postData['obligee_21h'])?$postData['obligee_21h']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_21h" name="obligor_21h"  placeholder="Calculate" value="<?php echo isset($postData['obligor_21h'])?$postData['obligor_21h']:''; ?>" readonly></div></td>
        </tr>
        <tr>
          <td>i. Multiply Line 21h by Line 17 for each parent; (If Line 15 is checked for the parent, use the lower percentage amount of either Line 17 or 50.00% to determine the parent’s share).  Annual child care costs</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligee_21i" name="obligee_21i" placeholder="Calculate" value="<?php echo isset($postData['obligee_21i'])?$postData['obligee_21i']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"   class="textright currency" type="number" id="obligor_21i" name="obligor_21i"  placeholder="Calculate" value="<?php echo isset($postData['obligor_21i'])?$postData['obligor_21i']:''; ?>" readonly></div></td>
        </tr>

        <tr>
          <td>j. Line 21i minus Line 21a. If calculation results in a negative amount, enter "0"</td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_21j" name="obligee_21j" placeholder="Calculate" value="<?php echo isset($postData['obligee_21j'])?$postData['obligee_21j']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_21j" name="obligor_21j"  placeholder="Calculate" value="<?php echo isset($postData['obligor_21j'])?$postData['obligor_21j']:''; ?>" readonly></div></td>
        </tr>
        <tr class="root-last-tr">
          <td>22.</td>
          <td>Adjusted Child Support Obligation (Line 18d minus Line 19b minus Line 20 plus Line 21j;
              if calculation results in negative amount, enter “0”).  <strong>Annual child support obligation</strong></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input  data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_22" name="obligee_22" placeholder="Calculate" value="<?php echo isset($postData['obligee_22'])?$postData['obligee_22']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input  data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_22" name="obligor_22"  placeholder="Calculate" value="<?php echo isset($postData['obligor_22'])?$postData['obligor_22']:''; ?>" readonly></div></td>
        </tr>
        <tfoot style="border-left: #FFF solid thin;">
          <tr>
            <td colspan="3">© First Draft Data, LLC. All Rights Reserved. V -1</td>
            <td align="right">Page 2 of 3</td>
          </tr>
        </tfoot>
</table>
<div class="page-break"></div><div class="dummy-text">text</div>
<table border="1" bordercolor="#333" class="Tableworksheet table_outer income-share cash-medical page-3" style="border-bottom:none">
            <tr class="print-header">
              <td colspan="5" class="p-0">
                <table width="100%" class="tbl_full_width header_inner_table">
                    <tr class="bg-grey">
                      <th class="textcenter">Obligee Name</th>
                      <th class="textcenter">Obligor Name</th>
                      <th class="textcenter" width="242">Date this form is completed</th>
                    </tr>
                  <tbody>
                    <tr>
                      <td>
                        <div class="input_field_wrapper">
                          <input class="textcenter" type="text" name="obligee_name2" placeholder="Enter" value="<?php echo isset($postData['obligee_name'])?$postData['obligee_name']:''; ?>" >
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper">
                          <input class="textcenter" type="text" name="obligor_name2" placeholder="Enter" value="<?php echo isset($postData['obligor_name'])?$postData['obligor_name']:''; ?>">
                        </div>
                      </td>
                      <td>
                        <div class="input_field_wrapper">
                          <input class="textcenter" type="text" name="created_at2" value="<?php echo date("m/d/Y"); ?>" readonly>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <table width="100%" class="tbl_full_width header_inner_table">
                    <tr class="bg-grey">
                      <th class="textcenter">County Name</th>
                      <th class="textcenter" width="292">SETS Case Number</th>
                      <th class="textcenter" width="269">Court or Administrative Order Number</th>
                      <th class="textcenter" width="242">Number of Children of the Order</th>
                    </tr>
                  <tbody>
                    <tr class="last-tr">
                      <td class="textcenter">
                        <div class="input_field_wrapper">
                          <?php $state=isset($sheet_state)?$sheet_state:'';
                            $county_selected = isset($postData['county_name']) ? $postData['county_name'] : '';
                          ?>

                          <select class="textcenter" id="county_name2" class="county-select" name="county_name2" style="font-size: 16px;">
                          <option value="">Choose County</option>
                          </select>
                        </div>
                      </td>
                      <td>
                          <div class="input_field_wrapper">
                            <input class="textcenter" type="text" name="sets_case_number2" placeholder="Enter" value="<?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>">
                          </div>
                      </td>
                      <td>
                          <div class="input_field_wrapper">
                            <input class="textcenter" type="text" name="court_administrative_order_number2" placeholder="Enter" value="<?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>">
                          </div>
                      </td>
                      <td class="textcenter">
                         <div class="input_field_wrapper">
                          <input class="textcenter" type="text" min="1" max="15" step="1" name="number_children_order2" value="<?php echo isset($postData['number_children_order'])?$postData['number_children_order']:''; ?>" placeholder="Enter" >
                         </div>
                       </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
        <tr>
          <td class="Cell_heading" colspan="2"><h1 class="recordInner_heading">V. CASH MEDICAL</h1> </td>
          <td class="Cell_obligee"><b>OBLIGEE</b></td>
          <td class="Cell_obligor"><b>OBLIGOR</b></td>
        </tr>

        <tr>
          <td rowspan="3" class="serial_count">23.</td>
          <td colspan="3" class="highligt_row">Cash Medical Obligation for Children Subject to this Order</td>
        </tr>
        <tr>
          <td>a. Annual combined cash medical support obligation</td>
          <td colspan="2"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textcenter" type="number" id="obligee_23a" name="obligee_23a" placeholder="Calculate" value="<?php echo isset($postData['obligee_23a'])?$postData['obligee_23a']:''; ?>" readonly></div></td>
        </tr>
        <tr>
          <td>b. Multiply Line 23a by Line 17 for each parent.  <b>Annual cash medical obligation</b></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_23b" name="obligee_23b" placeholder="Calculate" value="<?php echo isset($postData['obligee_23b'])?$postData['obligee_23b']:''; ?>" readonly></div></td>
          <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_23b" name="obligor_23b"  placeholder="Calculate" value="<?php echo isset($postData['obligor_23b'])?$postData['obligor_23b']:''; ?>" readonly></div></td>
        </tr>

        <tr>
          <td class="Cell_heading" colspan="2"><h1 class="recordInner_heading">VI. RECOMMENDED MONTHLY ORDERS FOR DECREE</h1> </td>
          <td class="Cell_obligor textcenter sfont" colspan="2"><b>OBLIGOR'S OBLIGATION</b></td>
        </tr>

        <tr>
            <td>24.</td>
            <td>CHILD SUPPORT AMOUNT (Line 22, divided by 12)</td>
            <td colspan="2">
              <div class="input_field_wrapper hide-inputbtns">

                <!-- <input class="textright currency"  data-number-stepfactor="100" step="1"type="number" id="obligee_24" name="obligee_24"  placeholder="Calculate" value="<?php //echo isset($postData['obligee_24'])?number_format((float)$postData['obligee_24'], 2, '.', ''):''; ?>" readonly> -->

                <input class="textright currency"  data-number-stepfactor="100" step="1"type="number" id="obligor_24" name="obligor_24"  placeholder="Calculate" value="<?php echo isset($postData['obligor_24'])?number_format((float)$postData['obligor_24'], 2, '.', ''):''; ?>" readonly>

              </div>
            </td>
        </tr>

        <tr>
          <td rowspan="5" class="serial_count">25.</td>
          <td colspan="4" class="highligt_row">Line 25 is <b>ONLY</b> completed if the court orders any deviation(s) to child support. (See sections 3119.23, 3119.231 and 3119.24 of the Revised Code)</td>
        </tr>

        <tr>
          <td colspan="3"> a. For 3119.23 factors (Enter the monthly amount)

            <!--
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1"class="textright currency" type="number" id="obligee_25a" name="obligee_25a"placeholder="Enter" value="<?php //echo isset($postData['obligee_25a'])?$postData['obligee_25a']:''; ?>" readonly>
            </div>
            -->

             <!--  <td><div class="input_field_wrapper hide-inputbtns"><input   data-number-stepfactor="100" step="1"class="textright currency" type="number" id="obligor_25a" name="obligor_25a"  placeholder="Enter" value="<?php //echo isset($postData['obligor_25a'])?$postData['obligor_25a']:''; ?>"></div></td> -->

          </td>
        </tr>

        <tr>
          <td class="pd-0" colspan="1">
             <table width="100%" class="Table-col-2">
                <tr>
                  <td>
                   <div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_SpecialUnusual" name="25a_SpecialUnusual" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_SpecialUnusual'])) && ($postData['25a_SpecialUnusual'] == 1)) ? 'checked' : ''; ?>>
                          Special/Unusual child needs
                    </div>
                  </td>
                  <td>
                    <div class="input_field_wrapper_checkbox">
                      <input type="checkbox" id="25a_Significant" name="25a_Significant" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_Significant'])) && ($postData['25a_Significant'] == 1)) ? 'checked' : ''; ?>>
                          Significant in-kind parental contributions
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <div class="input_field_wrapper_checkbox">
                      <input type="checkbox" id="25a_OtherCourt" name="25a_OtherCourt" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_OtherCourt'])) && ($postData['25a_OtherCourt'] == 1)) ? 'checked' : ''; ?>>
                      Other court-ordered payments
                    </div>
                  </td>
                  <td>
                    <div class="input_field_wrapper_checkbox">
                      <input type="checkbox" id="25a_Extraordinary" name="25a_Extraordinaryt" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_Extraordinaryt'])) && ($postData['25a_Extraordinaryt'] == 1)) ? 'checked' : ''; ?>>
                      Extraordinary parental work-related expenses
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                   <div class="input_field_wrapper_checkbox">
                      <input type="checkbox" id="25a_Extended" name="25a_Extended" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_Extended'])) && ($postData['25a_Extended'] == 1)) ? 'checked' : ''; ?>>
                          Extended parenting time/Extraordinary costs
                    </div>
                  </td>
                  <td><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="25a_ChildStandardt_living" name="25a_ChildStandardt_living" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ChildStandardt_living'])) && ($postData['25a_ChildStandardt_living'] == 1)) ? 'checked' : ''; ?>>
                          Child’s standard of living if parents were married
                    </div></td>
                </tr>

                <tr>
                  <td>
                   <div class="input_field_wrapper_checkbox">
                      <input type="checkbox" id="25a_ChildFinancial" name="25a_ChildFinancial" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ChildFinancial'])) && ($postData['25a_ChildFinancial'] == 1)) ? 'checked' : ''; ?>>
                          Child Financial Resources
                    </div>
                  </td>
                  <td><div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_ChildEdOps" name="25a_ChildEdOps" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ChildEdOps'])) && ($postData['25a_ChildEdOps'] == 1)) ? 'checked' : ''; ?>>
                          Child's educational opportunities
                    </div></td>
                </tr>

                <tr>
                  <td>
                   <div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_RelativeParental" name="25a_RelativeParental" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_RelativeParental'])) && ($postData['25a_RelativeParental'] == 1)) ? 'checked' : ''; ?>>
                          Relative parental financial resources
                    </div>
                  </td>
                  <td><div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_ParentalSupport" name="25a_ParentalSupport" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ParentalSupport'])) && ($postData['25a_ParentalSupport'] == 1)) ? 'checked' : ''; ?>>
                          Parental support for other special needs children
                    </div></td>
                </tr>

                <tr>
                  <td>
                   <div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_ObligeesIncome" name="25a_ObligeesIncome" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ObligeesIncome'])) && ($postData['25a_ObligeesIncome'] == 1)) ? 'checked' : ''; ?>>
                          Obligee’s income below federal poverty
                    </div>
                  </td>
                  <td><div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_ChildPost_secondary" name="25a_ChildPost_secondary" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ChildPost_secondary'])) && ($postData['25a_ChildPost_secondary'] == 1)) ? 'checked' : ''; ?>>
                          Child post-secondary educational expenses
                    </div></td>
                </tr>

                <tr>
                  <td>
                   <div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_ParentalRemarriage" name="25a_ParentalRemarriage" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ParentalRemarriage'])) && ($postData['25a_ParentalRemarriage'] == 1)) ? 'checked' : ''; ?>>
                          Parental remarriage/shared living expenses
                    </div>
                  </td>
                  <td><div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_ParentReunCost" name="25a_ParentReunCost" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ParentReunCost'])) && ($postData['25a_ParentReunCost'] == 1)) ? 'checked' : ''; ?>>
                          Parental cost for court-ordered reunification efforts
                    </div></td>
                </tr>

                <tr>
                  <td>
                    <div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_ParentalFederal" name="25a_ParentalFederal" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ParentalFederal'])) && ($postData['25a_ParentalFederal'] == 1)) ? 'checked' : ''; ?>>
                          Parental federal, state, local taxes paid
                    </div>
                  </td>
                  <td><div class="input_field_wrapper_checkbox">
                          <input type="checkbox" id="25a_ExtraordinaryChild" name="25a_ExtraordinaryChild" class="es_checkbox" value="1" <?php echo ((isset($postData['25a_ExtraordinaryChild'])) && ($postData['25a_ExtraordinaryChild'] == 1)) ? 'checked' : ''; ?>>
                          Extraordinary child care cost
                    </div></td>
                </tr>

                <tr>

                  <td class="border-right-none" colspan="2">
                    <div class="input_field_wrapper_checkbox" style="float: left;">
                      <input type="checkbox" id="25a_relvant" name="25a_relvant" class="es_checkbox" value="1" onclick="enable3cField('25a_OtherRelevantText', '25a_relvant')" <?php echo ((isset($postData['25a_relvant'])) && ($postData['25a_relvant'] == '1')) ? 'checked' : ''; ?>>
                      Other relevant factors :
                    </div>
                    <div class="input_field_wrapper hide-inputbtns" style="float: left; margin-left: 20px;width: 75%;">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textleft currency" type="text" id="25a_OtherRelevantText" name="25a_OtherRelevantText" placeholder="Enter" value="<?php echo isset($postData['25a_OtherRelevantText'])?$postData['25a_OtherRelevantText']:''; ?>" readonly>
                    </div>
                  </td>

                </tr>

                <tr>
                  <td style="border-right: none;">
                    <div class="input_field_wrapper_checkbox">
                      <input type="radio" id="25a_child_sport_deviation" name="25a_child_sport_radio" class="es_checkbox" value="deviation" onclick="radio25Action('deviation')" <?php echo ((!isset($postData['25a_child_sport_radio'])) || ($postData['25a_child_sport_radio'] == 'deviation')) ? 'checked' : ''; ?>>
                      Set Monthly Child Support Deviation:
                    </div>
                  </td>

                  <td>
                    <div class="input_field_wrapper hide-inputbtns textright">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="25a_child_sport_deviation_text" name="25a_child_sport_deviation_text" placeholder="Enter" value="<?php echo isset($postData['25a_child_sport_deviation_text'])?$postData['25a_child_sport_deviation_text']:''; ?>" readonly></div>
                    </td>
                </tr>

                <tr>

                  <td class="border-bottom-none"  style="border-right: none;">
                    <div class="input_field_wrapper_checkbox">
                      <input type="radio" id="25a_child_sport_non_deviation" name="25a_child_sport_radio" class="es_checkbox" value="nonDeviation" onclick="radio25Action('nonDeviation')" <?php echo ((isset($postData['25a_child_sport_radio'])) && ($postData['25a_child_sport_radio'] == 'nonDeviation')) ? 'checked' : ''; ?>>
                      Set Monthly Child Support:
                    </div>
                  </td>

                  <td class="border-bottom-none textright">
                    <div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="25a_child_sport_non_deviation_text" name="25a_child_sport_non_deviation_text" placeholder="Enter" value="<?php echo isset($postData['25a_child_sport_non_deviation_text'])?$postData['25a_child_sport_non_deviation_text']:''; ?>" readonly>
                    </div>
                  </td>

                </tr>

             </table>

          </td>

          <!--
          <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1"class="textright currency" type="number" id="obligee_25a" name="obligee_25a"placeholder="Enter" value="<?php //echo isset($postData['obligee_25a'])?number_format((float)$postData['obligee_25a'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>
          -->

          <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1"class="textright currency" type="number" id="obligor_25a" name="obligor_25a"  placeholder="Enter" value="<?php echo isset($postData['obligor_25a'])?number_format((float)$postData['obligor_25a'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>

        </tr>

        <tr>
          <td colspan="1">b. For 3119.231 extended parenting time (Enter the monthly) </td>

          <!--
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_25b" name="obligee_25b" placeholder="Enter" value="<?php //echo isset($postData['obligee_25b'])?number_format((float)$postData['obligee_25b'], 2, '.', ''):''; ?>">
            </div>
          </td>
          -->

          <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <!-- <input  data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligor_25b" name="obligor_25b" placeholder="Enter" value="<?php //echo isset($postData['obligor_25b'])?number_format((float)$postData['obligor_25b'], 2, '.', ''):''; ?>"> -->

              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_25b" name="obligor_25b" placeholder="Enter" value="<?php echo isset($postData['obligor_25b'])?number_format((float)$postData['obligor_25b'], 2, '.', ''):''; ?>">
              
            </div>
          </td>

        </tr>

        <tr>
          <td colspan="1">c. Add together the amounts from Lines 25a and 25b </td>

          <!--
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_25c" name="obligee_25c" placeholder="Calculate" value="<?php //echo isset($postData['obligee_25c'])?number_format((float)$postData['obligee_25c'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>
          -->

          <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligor_25c" name="obligor_25c"  placeholder="Calculate" value="<?php echo isset($postData['obligor_25c'])?number_format((float)$postData['obligor_25c'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>

        </tr>

        <tr>
          <td>26.</td>
          <td colspan="1">DEVIATED MONTHLY CHILD SUPPORT AMOUNT (Line 24 plus or minus Line 25c)</td>

          <!--
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligee_26" name="obligee_26" placeholder="Calculate"  value="<?php //echo isset($postData['obligee_26'])?number_format((float)$postData['obligee_26'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>
          -->

          <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligor_26" name="obligor_26"  placeholder="Calculate"  value="<?php echo isset($postData['obligor_26'])?number_format((float)$postData['obligor_26'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>

        </tr>

        <tr>
          <td>27.</td>
          <td colspan="1">CASH MEDICAL SUPPORT AMOUNT (Line 23b, divided by 12)</td>

          <!--
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligee_27" name="obligee_27" placeholder="Calculate"  value="<?php //echo isset($postData['obligee_27'])?number_format((float)$postData['obligee_27'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>
          -->

          <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligor_27" name="obligor_27"  placeholder="Calculate" value="<?php echo isset($postData['obligor_27'])?number_format((float)$postData['obligor_27'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>

        </tr>

        <tr>
          <td rowspan="2" class="serial_count">28.</td>
          <td colspan="3" class="highligt_row">Line 28 is <b>ONLY</b> completed if the court orders a deviation to cash medical.  (See section 3119.303 of the Revised Code)</td>
        </tr>

        <tr>
          <td colspan="1">Cash Medical Deviation amount (Enter the monthly amount)</td>

          <!--
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_28" name="obligee_28" placeholder="Enter" value="<?php //echo isset($postData['obligee_28'])?number_format((float)$postData['obligee_28'], 2, '.', ''):''; ?>">
            </div>
          </td>
          -->

          <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_28" name="obligor_28"  placeholder="Enter" value="<?php echo isset($postData['obligor_28'])?number_format((float)$postData['obligor_28'], 2, '.', ''):''; ?>">
            </div>
          </td>

        </tr>

        <tr>
          <td>29.</td>
          <td colspan="1">DEVIATED MONTHLY CASH MEDICAL AMOUNT (Line 27 plus or minus Line 28a)</td>

          <!--
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligee_29" name="obligee_29" placeholder="Calculate" value="<?php //echo isset($postData['obligee_29'])?number_format((float)$postData['obligee_29'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>
          -->

          <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligor_29" name="obligor_29"  placeholder="Calculate" value="<?php echo isset($postData['obligor_29'])?number_format((float)$postData['obligor_29'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>

        </tr>

        <tr>
          <td>30.</td>

          <td colspan="1">Enter ONLY the total monthly obligation for the parent ordered to pay support (Line 24 or Line 26, plus Line 27 or Line 29)</td>

          <!--
          <td>
            <div class="input_field_wrapper hide-inputbtns">
              <input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligee_30" name="obligee_30" placeholder="Calculate" readonly value="<?php //echo number_format((float)$postData['obligee_30'], 2, '.', '') ?? ''; ?>">
            </div>
          </td>
          -->

           <td colspan="2">
            <div class="input_field_wrapper hide-inputbtns">
              <input  data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligor_30" name="obligor_30"  placeholder="Calculate"  value="<?php echo isset($postData['obligor_30'])?number_format((float)$postData['obligor_30'], 2, '.', ''):''; ?>" readonly>
            </div>
          </td>

        </tr>

        <tr>
          <td>31.</td>
          <td colspan="1">Processing Charge Amount</td>
          <td colspan="2"><div class="input_field_wrapper hide-inputbtns"><input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligor_31" name="obligor_31" placeholder="Calculate"  value="<?php echo isset($postData['obligor_31'])?number_format((float)$postData['obligor_31'], 2, '.', ''):''; ?>" readonly></div></td>
        </tr>

        <tr>
          <td>32.</td>
          <td colspan="1">Total Monthly Obligation for Order (Child Support, Cash Medical, and Processing Charge)</td>
          <td colspan="2"><div class="input_field_wrapper hide-inputbtns"><input data-number-stepfactor="100" step="1" class="textright currency" type="number" id="obligor_32" name="obligor_32" placeholder="Calculate"  value="<?php echo (isset($postData['obligor_32']) && $postData['obligor_32'] > 0)?number_format((float)$postData['obligor_32'], 2, '.', ''):'0.00'; ?>" readonly></div></td>
        </tr>
        <tr class="desktop-tfoot">
          <td colspan="2">&copy First Draft Data, LLC. All Right Reserved. V<?php echo date("Y");?>-1</td>
          <td colspan="2"  class="textright currency" >
            <input type="hidden" name="process" value="1">
            <!-- <a href="" class="btn btn-info">Reset</a>&nbsp; -->
            <!-- <a href="{{ route('computations.sole-shared') }}" class="btn btn-info">Reset</a>&nbsp; -->
            <input type="button" name="reset" value="Reset" class="btn btn-info" onclick="resetForm();">
            <input type="submit" name="submit" value="Calculate" class="btn btn-success">
            <br/><br/>
            <input type="submit" name="submit_email" value="Print" class="btn btn-success" onclick="printForm();" style="display:none;">
            <input type="submit" name="save_form" value="Save" class="btn btn-success">
            <input type="submit" name="download_form" value="Download" class="btn btn-success" id="download_form">
          </td>
        </tr>
      </tbody>

    </table>

    <table class="preparedby table_outer" width="100%" style="margin-top:40px">
      <tr>
        <td colspan="5">

          <?php // echo $user->data()->fname.' '.$user->data()->lname; ?>

          <h3>Prepared by {{ $attorney_data->document_sign_name }}</br>

            Counsel for

            <select name="counsel_dropdown">
              <option value="obligor" <?php echo ((isset($postData['counsel_dropdown'])) && ($postData['counsel_dropdown'] == 'obligor')) ? 'selected' : '' ?>>Obligor</option>
              <option value="obligee" <?php echo ((isset($postData['counsel_dropdown'])) && ($postData['counsel_dropdown'] == 'obligee')) ? 'selected' : '' ?>>Obligee</option>
              <option value="Legal Custodian" <?php echo ((isset($postData['counsel_dropdown'])) && ($postData['counsel_dropdown'] == 'Legal Custodian')) ? 'selected' : '' ?>>Legal Custodian</option>
              <option value="CSEA" <?php echo ((isset($postData['counsel_dropdown'])) && ($postData['counsel_dropdown'] == 'CSEA')) ? 'selected' : '' ?>>CSEA</option>
              <option value="Guardian" <?php echo ((isset($postData['counsel_dropdown'])) && ($postData['counsel_dropdown'] == 'Guardian')) ? 'selected' : '' ?>>Guardian</option>
              <option value="Guardian Ad Litem" <?php echo ((isset($postData['counsel_dropdown'])) && ($postData['counsel_dropdown'] == 'Guardian Ad Litem')) ? 'selected' : '' ?>>Guardian Ad Litem</option>
            </select>

          </h3>

        </td>
      </tr>
      <tr>
        <td colspan="5">
          Worksheet has been reviewed and agreed to:
        </td>
      </tr>
      <tr>
        <td colspan="5" height="50">
        </td>
      </tr>
      <tr>
        <td width="350" style="border-bottom: #333333 solid thin;"></td>
        <td></td>
        <td width="35%"></td>
        <td width="350" style="border-bottom: #333333 solid thin;"></td>
        <td class="text-right"></td>
      </tr>
      <tr>
        <td><?php if(isset($postData['obligor_name'])){ echo $postData['obligor_name'].', '; } else if(isset($case_data['opponent_name'])){ echo $case_data['opponent_name'].', '; } ?>Obligor <span style="float:right">Date</span></td>
        <td></td>
        <td></td>
        <td><?php if(isset($postData['obligee_name'])){ echo $postData['obligee_name'].', '; } else if(isset($case_data['client_name'])){ echo $case_data['client_name'].', '; } ?>Obligee <span style="float:right">Date</span></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="5" height="50">
        </td>
      </tr>
      <tfoot style="border-left: #FFF solid thin;">
        <tr>
          <td colspan="3">© First Draft Data, LLC. All Rights Reserved. V -1</td>
          <td align="right">Page 3 of 3</td>
        </tr>
      </tfoot>
    </table>

  </div>
</form>

<div id="delay-message-myModal" class="delay-message-modal"><div class="delay-message-modal-content"><span class="delay-message-close">&times;</span><p>Your drafts will be available in your download directory soon.</p><div><a class="btn btn-danger delay-message-close-btn"> Close</a><a class="btn btn-info ml-2" href="{{ route('attorney.downloads') }}"> Go to Downloads</a></div></div></div>
</div>

@if(isset($bottom_scroll))
<script type="text/javascript">
  $("html, body").animate({ scrollTop: document.body.scrollHeight }, "slow");
</script>
@endif
@if(isset($print_sheet) && $print_sheet=='1')
<script type="text/javascript">

  printForm();
  function printForm(){
      window.print();
      return false;
  }
</script>
@endif
<script type="text/javascript">

  $('html').bind('keypress', function(e)
{
     if(e.keyCode == 13)
     {
         return e.keyCode = 9; //set event key to tab
     }
});
/*$('input').on("keypress", function(e) {
            /* ENTER PRESSED
            if (e.keyCode == 13) {
                /* FOCUS ELEMENT 
                var inputs = $(this).parents("form").eq(0).find(":input");
                var idx = inputs.index(this);

                if (idx == inputs.length - 1) {
                    inputs[0].select()
                } else {
                    inputs[idx + 1].focus(); //  handles submit buttons
                    inputs[idx + 1].select();
                }
                 e.preventDefault();
                return false;
            }
        });*/
// function showDelayMessage(){
//     var modal = document.getElementById("delay-message-myModal");
//     modal.style.display = "block";

//     // Get the <span> element that closes the modal
//     var span = document.getElementsByClassName("delay-message-close")[0];

//     // When the user clicks on <span> (x), close the modal
//     span.onclick = function() {
//         modal.style.display = "none";
//     }

//     // Get the <span> element that closes the modal
//     var btn = document.getElementsByClassName("delay-message-close-btn")[0];

//     // When the user clicks on <span> (x), close the modal
//     btn.onclick = function() {
//         modal.style.display = "none";
//     }
//     return true;
// }

function printForm(){
      return false;
}

function resetForm(){
  $(':input','#sole_shared_form')
  .not(':button, :submit, :reset, :hidden')
  .val('')
  .prop('checked', false)
  .prop('selected', false);
}

function resetFormToBlank(){
  $(':input','#sole_shared_form')
  .not(':button, :submit, :reset, :hidden, input[name="obligee_name"], input[name="obligor_name"], input[name="created_at"], select[name="county_name"], input[name="sets_case_number"], input[name="court_administrative_order_number"], input[name="number_children_order"]')
  .not($('input[name="number_children_order"]').next())
  .val('')
  .prop('checked', false)
  .prop('selected', false);
}

function fillFromDatabase(){
    var state=$('#sheet_state').val();
    var type=$('#sheet_custody').val();
    
    if(type=='sole' || type=='shared')    
    {
        type='sole-shared';
    }    
    else
    {
        type='split';
    }

    if($('#chk_prefill').prop("checked") == true){
         var prefill='1';
    } else {
         var prefill='0';
    }
    
    $('#computation_sheet_form').attr('action', '/computations/'+type);
}

$(document).ready(function() {
    var firm_state="<?php echo $sheet_state; ?>";
    if(firm_state){
        var token= $('input[name=_token]').val();
        $.ajax({
            url:"{{route('ajax_get_counties_by_state')}}",
            method:"POST",
            dataType: 'json',
            data:{
                id: firm_state, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    // $('.county-select').empty();
                    // $('.county-select').append('<option value="">Choose County</option>');
                    $.each(data, function (key, val) {
                        $('.county-select').append('<option value='+val+'>'+val+'</option>');
                    });

                    var sel_firm_county=$('#selected_county').text();
                    if(sel_firm_county){
                        $('.county-select option[value='+sel_firm_county+']').attr('selected','selected');
                    }
                }
            }
        });
    }
});  
  /**
   * Validate the sole form
   */
  function validateSoleForm()
  {

    if ($('#obligee_1_ytd_chk_date').is(":checked"))
    {
      if ($("#obligee_1_input_ytd").val() == '')
      {
        alert('Please enter the gross ytd amount.');
        $("#obligee_1_input_ytd").focus();
        return false;

      } else if ($("#obligee_1_datepick").val() == '') {

        alert('Please select the gross ytd date.');
        $("#obligee_1_datepick").focus();
        return false;
      }
    }

    if ($('#obligor_1_ytd_chk_date').is(":checked"))
    {
      if ($("#obligor_1_input_ytd").val() == '')
      {
        alert('Please enter the gross ytd amount.');
        $("#obligor_1_input_ytd").focus();
        return false;

      } else if ($("#obligor_1_datepick").val() == '') {

        alert('Please select the gross ytd date.');
        $("#obligor_1_datepick").focus();
        return false;
      }
    }

    if ($('#obligee_3_c_override').is(":checked"))
    {
      if ($("#obligee_3_c_override_input").val() <= 0)
      {
        alert('Value should be greated than 0.00');
        $("#obligee_3_c_override_input").focus();
        return false;
      }
    }

    if ($('#obligor_3_c_override').is(":checked"))
    {
      if ($("#obligor_3_c_override_input").val() <= 0)
      {
        alert('Value should be greated than 0.00');
        $("#obligor_3_c_override_input").focus();
        return false;
      }
    }

    if ($('#25a_relvant').is(":checked"))
    {
      if ($("#25a_OtherRelevantText").val() == '')
      {
        alert('Please fill the text.');
        $("#25a_OtherRelevantText").focus();
        return false;
      }
    }

    return true;
  }

</script>
<script type="text/javascript">

  /**
   * Function handle all the input
   * boxes related to radio button
   * after page loads
   */
  $(document).ready(function()
  {
    /**
     * Enable Default Input fileds for
     * obligee (1)
     */
    var onLoadObligee1radio = "<?php echo $postData['obligee_1_radio'] ?? 'year'; ?>";
    enableDisableField1('obligee', 'obligee_1_input_' + onLoadObligee1radio);

    /**
     * Enable Default Input fileds for
     * obligor (1)
     */
    var onLoadObligor1radio = "<?php echo $postData['obligor_1_radio'] ?? 'year'; ?>";
    enableDisableField1('obligor', 'obligor_1_input_' + onLoadObligor1radio);

    /**
     * Enable Default Input fileds for
     * obligee (3c)
     */
    var onLoadObligee3cradio = "<?php echo $postData['obligee_3_c_radio'] ?? 'calculation'; ?>";
    radio3cAction('obligee', onLoadObligee3cradio);

    /**
     * Enable Default Input fileds for
     * obligor (3c)
     */
    var onLoadObligor3cradio = "<?php echo $postData['obligor_3_c_radio'] ?? 'calculation'; ?>";
    radio3cAction('obligor', onLoadObligor3cradio);

    /**
     * Enable Default Input fileds for
     * obligee (21g)
     */
    var onLoadObligee21gradio = "<?php echo $postData['obligee_21_g_radio'] ?? 'calculation'; ?>";
    radio21gAction('obligee', onLoadObligee21gradio);

    /**
     * Enable Default Input fileds for
     * obligor (21g)
     */
    var onLoadObligor21gradio = "<?php echo $postData['obligor_21_g_radio'] ?? 'calculation'; ?>";
    radio21gAction('obligor', onLoadObligor21gradio);

    var onLoadObligee25radio = "<?php echo $postData['25a_child_sport_radio'] ?? 'deviation'; ?>";
    radio25Action(onLoadObligee25radio);

    /**
     * Split Form Js Function
     */

    var sheetCustody = "<?php echo $sheet_custody ?>";

    if (sheetCustody == 'split')
    {
      enable3cField('21l_obligee_ParentA_Over_input', '21l_obligee_ParentA_Over');
      enable3cField('21l_obligee_ParentB_Over_input', '21l_obligee_ParentB_Over');

      enable3cField('21l_obligor_ParentA_Over_input', '21l_obligor_ParentA_Over');
      enable3cField('21l_obligor_ParentB_Over_input', '21l_obligor_ParentB_Over');

      var onLoadObligee26Splitradio = "<?php echo $postData['26a_obligee_child_sport'] ?? 'deviation'; ?>";
      radio26ActionSplit(onLoadObligee26Splitradio, 'obligee');

      var onLoadObligor26Splitradio = "<?php echo $postData['26a_obligor_child_sport'] ?? 'deviation'; ?>";
      radio26ActionSplit(onLoadObligor26Splitradio, 'obligor');
    }
  });

  /**
   * Calculate Annual Gross Income
   */
  function calcuAnnualGrossIncome(label)
  { 
    //var minWage = "<?php //echo isset($postData['OH_Minimum_Wage'])?$postData['OH_Minimum_Wage']:''?>";
    var minWage = "<?php echo isset($OH_Minimum_Wage)?$OH_Minimum_Wage:''?>";

    var tmpAmount;

    var obligeeMinWageCheck = $("#"+label+"_1_ohio_minimum_wage");
    var obligeeYtdCheckDate = $("#"+label+"_1_ytd_chk_date");
    var obligeeCheckYear = $("#"+label+"_1_checks_year");

    var amount;
    if (obligeeYtdCheckDate.is(":checked")) {

      amount = document.getElementById(label+"_1_input_ytd").value;

    } else if (obligeeCheckYear.is(":checked")) {

      amount = document.getElementById(label+"_1_input_year").value;

    } else {

      amount = 2000;
    }

    if ((obligeeCheckYear.is(":checked")))
    {
      var frequencyForObligee = $('#'+label+'_1_dropdown').val();
      tmpAmount = amount * frequencyForObligee;

      $("#"+label+"_1").prop("readonly", true).val(tmpAmount);

    } else if (obligeeYtdCheckDate.is(":checked")) {

      var obligee_1_Datepick = $("#"+label+"_1_datepick").val();

      var currentDate = new Date(obligee_1_Datepick);
      var first = new Date(currentDate.getFullYear(), 0, 1);
      var theDay = Math.round(((currentDate - first) / 1000 / 60 / 60 / 24) + .5, 0);

      if(isNaN(theDay))
      {
      }
      else
      {
        tmpAmount = amount * (365/theDay);
      }

      $("#"+label+"_1").prop("readonly", true).val(tmpAmount);

      obligeeCheckYear.attr('checked', false);

    } else if ((obligeeMinWageCheck.is(":checked"))) {

      var fixAmount = amount * minWage;

      $("#"+label+"_1").val(fixAmount);

    } else {

      $("#"+label+"_1").val(0.00);
    }
  }

  /**
   * Calculate gross income when
   * select box changed
   */
  function callCalcuAnnualGrossIncome(label)
  {
    var fixAmount;

    if ($("#"+label+"_1_ytd_chk_date").is(":checked"))
    {
      fixAmount = document.getElementById(label+"_1_input_ytd").value;

    } else if ($("#"+label+"_1_checks_year").is(":checked")) {

      fixAmount = document.getElementById(label+"_1_input_year").value;
    }

    if (fixAmount == '')
    {
      alert('Please enter the amount first.');
      return false;

    } else {

      calcuAnnualGrossIncome(label);
    }
  }

  function enable3cField(id, checkboxId)
  {
    if ($("#"+checkboxId).is(":checked"))
    {
      $("#"+id).attr("readonly", false);

    } else {

      $("#"+id).attr("readonly", true);
      $("#"+id).val('');
    }
  }

  function enableDisableField1(type, id)
  {
    if (id == type+'_1_input_year')
    {
      $("#"+id).attr("readonly", false);

      $("#"+type+"_1_input_ytd").attr("readonly", true);
      $("#"+type+"_1_input_ytd").val('');

      $("#"+type+"_1_datepick").val('');

    } else if (id == type+'_1_input_ytd') {

      $("#"+id).attr("readonly", false);

      $("#"+type+"_1_input_year").attr("readonly", true);
      $("#"+type+"_1_input_year").val('');

      $("#"+type+"_1_dropdown").val(0);

    } else {

      $("#"+type+"_1_input_ytd").attr("readonly", true);
      $("#"+type+"_1_input_ytd").val('');
      $("#"+type+"_1_datepick").val('');

      $("#"+type+"_1_input_year").attr("readonly", true);
      $("#"+type+"_1_input_year").val('');
      $("#"+type+"_1_dropdown").val(0);
    }

    $("#"+type+"_1").val('');
    calcuAnnualGrossIncome(type);
  }

  /**
   * Calculate 3c line on the selection
   * of radion button
   */
  function radio3cAction(type, condition)
  {
    if (condition == 'calculation')
    {
      $("#" + type + "_3_c_override_input").attr("readonly", true);
      $("#" + type + "_3_c_override_input").val("");

    } else {

      $("#" + type + "_3_c_override_input").attr("readonly", false);
    }
  }

  function calculate3c(label)
  {
    var a = document.getElementById(label+"_3a").value;
    var b = document.getElementById(label+"_3b").value;

    var price = Math.max((0.062 * (a - b)), 0);
    $("#"+label+"_3_c_top_override_input").val(price);
  }

  /**
   * Calculate 21 line based on
   * radion Actions
   */
  function radio21gAction(type, condition)
  {
    if (condition == 'manual')
    {
      $("#" + type + "_21_g_override_text").attr("readonly", false);

    } else {

      $("#" + type + "_21_g_override_text").val('');
      $("#" + type + "_21_g_override_text").attr("readonly", true);
    }
  }

  /**
   * Calculate 25 line based on
   * radion Actions
   */
  function radio25Action(condition)
  {
    if (condition == 'nonDeviation')
    {
      $("#25a_child_sport_non_deviation_text").attr("readonly", false);

      $("#25a_child_sport_deviation_text").attr("readonly", true);
      $("#25a_child_sport_deviation_text").val('');

    } else {

      $("#25a_child_sport_deviation_text").attr("readonly", false);

      $("#25a_child_sport_non_deviation_text").attr("readonly", true);
      $("#25a_child_sport_non_deviation_text").val('');
    }
  }

  /**
   * Calculate 26 line based on
   * radion Actions (Split)
   */
  function radio26ActionSplit(condition, type)
  {
    if (condition == 'nonDeviation')
    {
      $("#26a_"+ type +"_child_sport_non_deviation_text").attr("readonly", false);

      $("#26a_"+ type +"_child_sport_deviation_text").attr("readonly", true);
      $("#26a_"+ type +"_child_sport_deviation_text").val('');

    } else {

      $("#26a_"+ type +"_child_sport_deviation_text").attr("readonly", false);

      $("#26a_"+ type +"_child_sport_non_deviation_text").attr("readonly", true);
      $("#26a_"+ type +"_child_sport_non_deviation_text").val('');
    }
  }

  // to switch obligor and obligee data
  // to switch obligor and obligee data
  function switchObligorObligee(){
    var obligee_name=$('input[name="obligee_name"]').val();

    var obligee_1_input_ytd=$('input[name="obligee_1_input_ytd"]').val();
    var obligee_1_datepick=$('input[name="obligee_1_datepick"]').val();
    var obligee_1_input_year=$('input[name="obligee_1_input_year"]').val();
    var obligee_1_dropdown=$('select[name="obligee_1_dropdown"]').val();
    var obligee_1_radio=$('input[name="obligee_1_radio"]:checked').val();

    var obligee_1=$('input[name="obligee_1"]').val();
    var obligee_2a=$('input[name="obligee_2a"]').val();
    var obligee_2b=$('input[name="obligee_2b"]').val();
    var obligee_2c=$('input[name="obligee_2c"]').val();
    var obligee_2d=$('input[name="obligee_2d"]').val();
    var obligee_3_c_top_override_input=$('input[name="obligee_3_c_top_override_input"]').val();



    var obligor_name=$('input[name="obligor_name"]').val();

    var obligor_1_input_ytd=$('input[name="obligor_1_input_ytd"]').val();
    var obligor_1_datepick=$('input[name="obligor_1_datepick"]').val();
    var obligor_1_input_year=$('input[name="obligor_1_input_year"]').val();
    var obligor_1_dropdown=$('select[name="obligor_1_dropdown"]').val();
    var obligor_1_radio=$('input[name="obligor_1_radio"]:checked').val();

    var obligor_1=$('input[name="obligor_1"]').val();
    var obligor_2a=$('input[name="obligor_2a"]').val();
    var obligor_2b=$('input[name="obligor_2b"]').val();
    var obligor_2c=$('input[name="obligor_2c"]').val();
    var obligor_2d=$('input[name="obligor_2d"]').val();
    var obligor_3_c_top_override_input=$('input[name="obligor_3_c_top_override_input"]').val();

    $('input[name="obligor_1_radio"]').prop("checked", false);
    $('input[name="obligor_1_input_year"]').val('');
    $('select[name="obligor_1_dropdown"]').val('0');
    $('input[name="obligor_1_input_ytd"]').val('');
    $('input[name="obligor_1_datepick"]').val('');
    $('input[name="obligor_1_input_year"], input[name="obligor_1_input_ytd"]').prop("readonly", true);


    $('input[name="obligee_1_radio"]').prop("checked", false);
    $('input[name="obligee_1_input_year"]').val('');
    $('select[name="obligee_1_dropdown"]').val('0');
    $('input[name="obligee_1_input_ytd"]').val('');
    $('input[name="obligee_1_datepick"]').val('');
    $('input[name="obligee_1_input_year"], input[name="obligee_1_input_ytd"]').prop("readonly", true);

    // data swapping of obligee to obligor
    if(typeof obligee_name !== "undefined")
    {
      $('input[name="obligor_name"]').val(obligee_name);
    }

    if(typeof obligee_1_radio !== "undefined")
    {
        // $('input[name="obligor_1_radio"]').prop("checked", true);
        $('input[name="obligor_1_radio"][value="'+obligee_1_radio+'"]').prop('checked', 'checked');

        if(typeof obligee_1_input_year !== "undefined" && obligee_1_radio=='year')
        {
          $('input[name="obligor_1_input_year"]').val(obligee_1_input_year);
          $('input[name="obligor_1_input_year"]').prop("readonly", false);
        }
        if(typeof obligee_1_dropdown !== "undefined" && obligee_1_radio=='year')
        {
          $('select[name="obligor_1_dropdown"]').val(obligee_1_dropdown);
          // $('select[name="obligor_1_dropdown"] option[value="'+obligee_data_array[index].obligee_1_dropdown+'"]').attr("selected", "selected");
        }

        if(typeof obligee_1_input_ytd !== "undefined" && obligee_1_radio=='ytd')
        {
          $('input[name="obligor_1_input_ytd"]').val(obligee_1_input_ytd);
          $('input[name="obligor_1_input_ytd"]').prop("readonly", false);
        }
        if(typeof obligee_1_datepick !== "undefined" && obligee_1_radio=='ytd' && obligee_1_datepick !="")
        {
          // $('input[name="obligor_1_datepick"]').val(obligee_1_datepick);
          $('input[name="obligor_1_datepick').datepicker("setDate", new Date(obligee_1_datepick) );
        }

    }

    if(typeof obligee_1 !== "undefined")
    {
      $('input[name="obligor_1"]').val(obligee_1);
    }
    if(typeof obligee_2a !== "undefined")
    {
      $('input[name="obligor_2a"]').val(obligee_2a);
    }
    if(typeof obligee_2b !== "undefined")
    {
      $('input[name="obligor_2b"]').val(obligee_2b);
    }
    if(typeof obligee_2c !== "undefined")
    {
      $('input[name="obligor_2c"]').val(obligee_2c);
    }
    if(typeof obligee_2d !== "undefined")
    {
      $('input[name="obligor_2d"]').val(obligee_2d);
    }
    if(typeof obligee_3_c_top_override_input !== "undefined")
    {
      $('input[name="obligor_3_c_top_override_input"]').val(obligee_3_c_top_override_input);
    }

    // data swapping of obligor to obligee
    if(typeof obligor_name !== "undefined")
    {
      $('input[name="obligee_name"]').val(obligor_name);
    }

    if(typeof obligor_1_radio !== "undefined")
    {
        // $('input[name="obligee_1_radio"]').prop("checked", true);
        $('input[name="obligee_1_radio"][value="'+obligor_1_radio+'"]').prop('checked', 'checked');

        if(typeof obligor_1_input_year !== "undefined" && obligor_1_radio=='year')
        {
          $('input[name="obligee_1_input_year"]').val(obligor_1_input_year);
          $('input[name="obligee_1_input_year"]').prop("readonly", false);
        }
        if(typeof obligor_1_dropdown !== "undefined" && obligor_1_radio=='year')
        {
          $('select[name="obligee_1_dropdown"]').val(obligor_1_dropdown);
          // $('select[name="obligee_1_dropdown"] option[value="'+obligor_data_array[index].obligor_1_dropdown+'"]').attr("selected", "selected");
        }

        if(typeof obligor_1_input_ytd !== "undefined" && obligor_1_radio=='ytd')
        {
          $('input[name="obligee_1_input_ytd"]').val(obligor_1_input_ytd);
          $('input[name="obligee_1_input_ytd"]').prop("readonly", false);
        }
        if(typeof obligor_1_datepick !== "undefined" && obligor_1_radio=='ytd' && obligor_1_datepick !="")
        {
          // $('input[name="obligee_1_datepick"]').val(obligor_1_datepick);
          $('input[name="obligee_1_datepick').datepicker("setDate", new Date(obligor_1_datepick) );
        }

    }

    if(typeof obligor_1 !== "undefined")
    {
      $('input[name="obligee_1"]').val(obligor_1);
    }
    if(typeof obligor_2a !== "undefined")
    {
      $('input[name="obligee_2a"]').val(obligor_2a);
    }
    if(typeof obligor_2b !== "undefined")
    {
      $('input[name="obligee_2b"]').val(obligor_2b);
    }
    if(typeof obligor_2c !== "undefined")
    {
      $('input[name="obligee_2c"]').val(obligor_2c);
    }
    if(typeof obligor_2d !== "undefined")
    {
      $('input[name="obligee_2d"]').val(obligor_2d);
    }
    if(typeof obligor_3_c_top_override_input !== "undefined")
    {
      $('input[name="obligee_3_c_top_override_input"]').val(obligor_3_c_top_override_input);
    }
  
  }

</script>
@endsection
