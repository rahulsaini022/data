@extends('layouts.app')

@section('content')
<div class="container">
<style type="text/css">

  /********************************************/

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

  /********************************************/

  table {font-size: 14px;border-left: none;border-bottom: none;font-family: 'Roboto', sans-serif;text-align: left;line-height: inherit;color: #000;width: 100%;}
  td {text-align: left;padding: 5px;border: 1px solid #000;border-top: none;border-right: none;font-weight: normal;line-height: 22px;}
  td span{color:#093;}
  .page-title {font-size: 30px;font-family: 'Roboto', sans-serif;text-align: center;display: inline-block;width: 100%;color: #333;font-weight: 600;margin: 0 0 30px;}
  .w-20{width:20px;}
  .w-30{width:30px;text-align:center;}
  .border-left {border-left: 1px solid #000!important;}
  .dark-bg{background: #eee;}
  .color-green{color: green;}
  .footer-heading {float: left;width: 100%;border-bottom: 2px solid #222;padding: 30px 0;margin: 30px 0;}
  .footer-heading h1 {font-size: 26px;font-weight: 500;}
  .footer-heading h3 {font-size: 20px;}
  .footer-heading h2 {font-size: 26px;border-top: 2px solid #222;width: 51%;float: left;margin-top: 40px;padding-top: 10px;}
  .print-footer {display: none;}
  .hide-header{display: none;}
  .hide-header-tr{display: none;}
  .white-space-td{white-space: nowrap;}
  td input[type="text"], td input[type="number"] {padding: 0;box-sizing: border-box;color: #008000;border: none;display: inline-block;vertical-align: middle;max-width: 66px;font-size: 13px;}
  td input::-webkit-input-placeholder {color: #008000;opacity: 1;}
  td input::-moz-placeholder {color: #008000;opacity: 1;}
  td input:-ms-input-placeholder {color: #008000;opacity: 1;}
  td input:-moz-placeholder {color: #008000;opacity: 1;}
  td .input_field_wrapper {display: inline-block;width: auto;}
  td input.readonly-feild {border: none;color: #000;}
  td input.readonly-feild::-webkit-input-placeholder {color: #000;}
  td input.readonly-feild::-moz-placeholder {color: #000;}
  td input.readonly-feild:-ms-input-placeholder {color: #000;}
  td input.readonly-feild:-moz-placeholder {color: #000;}
  tfoot {display: none;}
  .preparedby tr td h3 , .preparedby tr td h3 select {color: #333;font-size: 18px;line-height: 2;font-weight: 600;}
  .preparedby tr td h3 select {margin-left: 13px;padding: 3px 10px;width: auto;display: inline-block;}
  .preparedby td span {color: #000;}
  .preparedby td {border: none;padding: 0;line-height: 1.6;}
  /*table.preparedby.table_outer{display: none;}*/
  .Tableworksheet_Outer {width: 100%;margin: 0;}
  td.pd-0 {padding: 0;}
  .inner-table td {border: none;border-right: 1px solid #000;border-bottom: 1px solid #000;}
  .inner-table tr td:last-child {border-right: none;}
  .inner-table tr:last-child td {border-bottom: none;}
  td select {text-transform: none;background: transparent;border: none;}
  .percentage_end {
    padding-right: 0px;
    position: relative;
}

.percentage_end:after {
    content: "%";
    right: 0;
    top: 1px;
    color: #000000;
    position: absolute;
}

.percentage_end > input {
    padding-right: 15px !important;
}
.textright{text-align: right!important;}

  body{min-width: 1170px;width: 100%;}
  body .container {max-width: 100%;width: 1140px;}
  body .container .container{width: 100%;padding:0;}

  @media print {
    body {font-family: 'Roboto', sans-serif;}
    table.preparedby.table_outer {display: table;}
    .container{max-width: 100%;min-width:unset !important;padding: 0;margin: 0;}
    td{padding:1px 2px 1px 2px;line-height: 1.5;}
    table{font-size: 13px;float: left;table-layout: fixed;}
    .table-2 td{padding: 0 1px;line-height: 20px; }
    .footer-heading{padding: 0;margin: 15px 0 0;}
    .table-2{margin-bottom: 50px;}
    .font-s{font-size: 11px!important;}
    .print-footer {display: block;margin-top: 10px;font-size: 13px;float: left;width: 100%;height: 50px;}
    .print-footer span {float: right;}
    .footer-heading h1 {font-size: 20px;font-weight: 500;}
    .footer-heading h3 {font-size: 16px;}
    .page-break{page-break-before: always !important;}
    .footer-heading h2 {font-size: 16px;border-top: 1px solid #222;}
    .footer-heading {border-bottom: 1px solid #222;}
    .hide-header{display:table;}
    .hide-header-tr{display:table-row;}
    td {overflow: hidden;}
    .mb-2{border-bottom: 0;}
    .print-none{display: none;}
    td select {
    text-transform: none;
    background: transparent;
    border: none;
    -webkit-appearance: none;
    }
     tfoot td:last-child{
    text-align: right;
  }

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
  <?php if(isset($case_data['case_id'])){ ?>
  <div class="col-sm-12 hide-print-buttons">
    <div style="text-align: left; float: left; width: 25%;">
        <form method="POST" action="{{route('ajax_update_custody_arrangement_dr_children')}}" autocomplete="off">
          @csrf
          <input type="hidden" name="case_id" id="modal_case_id" value="<?php if(isset($case_data['case_id'])){ echo $case_data['case_id']; } ?>" required="" style="display: none;">
          <input type="hidden" name="sheet_state" value="{{ $sheet_state }}">
          <input class="text-center" type="hidden" name="obligee_name_custody" placeholder="Enter" value="<?php if(isset($case_data['client_full_name'])){ echo $case_data['client_full_name']; } else if (isset($postData['client_full_name'])){ echo $postData['client_full_name']; } ?>">
           <input class="textcenter" type="hidden" name="obligor_name_custody" placeholder="Enter" value="<?php if(isset($case_data['opponent_full_name'])){ echo $case_data['opponent_full_name']; } else if(isset($postData['opponent_full_name'])){ echo $postData['opponent_full_name']; } ?>">
          
          <div class="input-group mb-3 hide-print-buttons">
            <select id="" name="change_sheet_custody" class="form-control mb-1 custom-select change_sheet_custody_dropdown" required="">
                <option value="sole" <?php if(isset($sheet_custody) && $sheet_custody=='sole'){ echo "selected"; } ?>>Sole</option>
                <option value="shared" <?php if(isset($sheet_custody) && $sheet_custody=='shared'){ echo "selected"; } ?>>Shared</option>
                <option value="split" <?php if(isset($sheet_custody) && $sheet_custody=='split'){ echo "selected"; } ?>>Split</option>
            </select>
            <div class="input-group-append">
                <input type="submit" class="btn btn-info hide-print-buttons mb-1" value="Submit">
            </div>
          </div>
      </form>
    </div>
    <div style="float: right;">
      <!-- <input type="button" name="switch" value="Switch Obligor/Obligee" class="btn btn-info hide-print-buttons mb-1" onclick="switchObligorObligee();"> -->
    </div>
  </div>
  <?php } ?>
</div>

     <form id="entryform" method="post" action="{{ route('computed_computations.split') }}" onsubmit="return validateSplitForm();" >
          @csrf
      <input type="hidden" name="sheet_custody" value="{{ $sheet_custody }}">
      <input type="hidden" name="sheet_state" value="{{ $sheet_state }}">
      <input type="hidden" name="chk_prefill" value="{{ $chk_prefill }}">
      <input type="hidden" name="case_id" value="<?php if(isset($case_data['case_id'])){ echo $case_data['case_id']; } ?>">
      <input type="hidden" name="obligee_full_name" value="<?php if(isset($postData['client_full_name'])){ echo $postData['client_full_name']; } else if(isset($case_data['client_full_name'])){ echo $case_data['client_full_name']; } ?>">
      <input type="hidden" name="obligor_full_name" value="<?php if(isset($postData['opponent_full_name'])){ echo $postData['opponent_full_name']; } else if(isset($case_data['opponent_full_name'])){ echo $case_data['opponent_full_name']; } ?>">

         <h3 class="page-title">OHIO </br> <?php echo strtoupper($sheet_custody); ?> PARENTING CHILD SUPPORT  COMPUTATION WORKSHEET</h3>
          @if (isset($success))
            <div class="alert alert-success alert-block text-center">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $success }}</strong>
            </div>
          @endif
                 
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
                    <td class="text-center"><strong>Parent A Name</strong></td>
                    <td class="text-center"><strong>Parent B Name</strong></td>
                    <td class="text-center" class="white-space-td"><strong>Date this form is completed</strong></td>
                </tr>
               <tr>
                    <td class="text-center" >
                     <input class="text-center" type="text" name="obligee_name" placeholder="Enter" value="<?php if(isset($postData['obligee_name'])){ echo $postData['obligee_name']; } else if(isset($case_data['client_name'])){ echo $case_data['client_name']; } ?>" style="max-width: 100%; width: 100%;" required>
                    </td>

                    <td class="text-center">
                      <input class="text-center" type="text" name="obligor_name" placeholder="Enter" value="<?php if(isset($postData['obligor_name'])){ echo $postData['obligor_name']; } else if(isset($case_data['opponent_name'])){ echo $case_data['opponent_name']; } ?>" style="max-width: 100%; width: 100%;" required>
                    </td>

                    <td class="text-center" class="white-space-td">
                     <input class="text-center" type="text" name="created_at" value="<?php echo date("m/d/Y"); ?>" readonly style="max-width: 80px;">
                    </td>
                </tr>
              </tbody>
            </table>

            <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-top: 0;">
                <tbody>
                 <tr>
                    <td class="text-center"><strong>County Name</strong></td>
                    <td class="text-center"><strong>SETS Case Number</strong></td>
                    <td class="text-center"><strong>Court or Administrative Order Number</strong></td>
                    <td class="text-center"><strong>Number of Children of the Order</strong></td>
                </tr>

              <tr>
                    <td class="text-center">
                      <?php $state=isset($sheet_state)?$sheet_state:'';
                            $county_selected=isset($postData['county_name'])?$postData['county_name']:'';
                      ?>
                      <p style="display: none;" id="selected_county">{{ $county_selected }}</p>
                          <select id="county_name" class="county-select" name="county_name">
                            <option value="">Choose County</option>
                          </select>
                    
                    </td>

                    <td class="text-center">
                      <input class="text-center" type="text" name="sets_case_number" placeholder="Enter" value="<?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>">
                    </td>

                    <td class="text-center">
                      <input class="text-center" type="text" name="court_administrative_order_number" placeholder="Enter" value="<?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>">
                    </td>

                    <td class="text-center">
                      <input class="text-center" type="number" min="1" max="15" step="1" id="number_children_order" name="number_children_order" value="<?php echo isset($postData['number_children_order'])?$postData['number_children_order']:''; ?>" placeholder="Enter" required>
                    </td>
                </tr>
              </tbody>
            </table>

         
         <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-top: 0;">
            <tbody>               
               <tr>
                  <td colspan="4"><strong>I. GROSS INCOME</strong></td>
                  <td colspan="4" class="text-center"><strong>Parent A</strong><br>Computed Income</td>
                  <td colspan="3" class="text-center"><strong>Parent B</strong><br>Computed Income</td>
                  <td colspan="4" class="text-center"><strong>Parent A</strong> &nbsp; <strong>Parent B</strong></td>
               </tr>
               <tr>
                  <td rowspan="1" class="calc">1.</td>
                  <td colspan="3" rowspan="1">Annual Gross Income</td>
                  <td class="pd-0"  colspan="4">
                      <table width="100%" class="anuual-income inner-table">
                        <tbody>
                          <tr>
                            <td>
                                <div class="input_field_wrapper_checkbox text-center">
                                <input type="radio" id="obligee_1_checks_year" name="obligee_1_radio" class="es_checkbox" value="year" onclick="enableDisableField1('obligee','obligee_1_input_year')" <?php echo ((!isset($postData['obligee_1_radio'])) || ($postData['obligee_1_radio'] == 'year')) ? 'checked' : ''; ?>>
                              </div></td>
                              <td><input type="text" name="obligee_1_input_year" placeholder="0.00" aria-required="true" inputmode="numeric" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligee_1_input_year" readonly value="<?php echo $postData['obligee_1_input_year'] ?? ''; ?>" onchange="callCalcuAnnualGrossIncome('obligee')"></td>
                              <td><select name="obligee_1_dropdown" id="obligee_1_dropdown" onchange="callCalcuAnnualGrossIncome('obligee')">
                                <option value="0" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 0)) ? 'selected' : '' ?>>Frequency</option>
                                <option value="1" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 1)) ? 'selected' : '' ?>>Yearly</option>
                                <option value="12" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 12)) ? 'selected' : '' ?>>Monthly</option>
                                <option value="24" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 24)) ? 'selected' : '' ?>>Bi-Monthly</option>
                                <option value="26" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 26)) ? 'selected' : '' ?>>Bi-Weekly</option>
                                <option value="52" <?php echo ((isset($postData['obligee_1_dropdown'])) && ($postData['obligee_1_dropdown'] == 52)) ? 'selected' : '' ?>>Weekly</option>
                              </select></td>
                          </tr>
                          <tr>
                            <td><div class="input_field_wrapper_checkbox text-center">
                                <input type="radio" id="obligee_1_ytd_chk_date" name="obligee_1_radio" class="es_checkbox" value="ytd" onclick="enableDisableField1('obligee','obligee_1_input_ytd')" <?php echo ((isset($postData['obligee_1_radio'])) && ($postData['obligee_1_radio'] == 'ytd')) ? 'checked' : ''; ?>>
                              </div></td>
                              <td><input type="text" name="obligee_1_input_ytd" placeholder="YTD Chk Date" class="" aria-required="true" inputmode="numeric" aria-labelledby="" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligee_1_input_ytd" readonly value="<?php echo $postData['obligee_1_input_ytd'] ?? ''; ?>" onchange="callCalcuAnnualGrossIncome('obligee')"></td>
                              <td colspan="2"><input class="text-center datepicker sfont" type="text" id="obligee_1_datepick" name="obligee_1_datepick" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="Date" value="<?php echo (isset($postData['obligee_1_datepick']))?$postData['obligee_1_datepick']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligee')">
                              </td>
                          </tr>
                          <tr>
                            <td><div class="input_field_wrapper_checkbox text-center">
                                <input type="radio" id="obligee_1_ohio_minimum_wage" name="obligee_1_radio" class="es_checkbox" value="oh_min_wage" onclick="enableDisableField1('obligee','default')" <?php echo ((isset($postData['obligee_1_radio'])) && ($postData['obligee_1_radio'] == 'oh_min_wage')) ? 'checked' : ''; ?>>
                              </div></td>
                              <td colspan="2">Ohio Minimum Wage </td>
                          </tr>
                      </tbody>
                    </table>
                  </td>
                  <td class="pd-0" colspan="3">
                      <table width="100%" class="anuual-income inner-table">
                        <tbody>
                          <tr>
                            <td><div class="input_field_wrapper_checkbox text-center">
                              <input type="radio" id="obligor_1_checks_year" name="obligor_1_radio" class="es_checkbox" value="year" onclick="enableDisableField1('obligor','obligor_1_input_year')" <?php echo ((!isset($postData['obligor_1_radio'])) || ($postData['obligor_1_radio'] == 'year')) ? 'checked' : ''; ?>></td>
                            <td><input type="text" name="obligor_1_input_year" placeholder="0.00" aria-required="true" inputmode="numeric" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligor_1_input_year" readonly value="<?php echo $postData['obligor_1_input_year'] ?? ''; ?>" onchange="callCalcuAnnualGrossIncome('obligor')"></td>
                            <td><select name="obligor_1_dropdown" onchange="callCalcuAnnualGrossIncome('obligor')" id="obligor_1_dropdown">
                              <option value="0" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 0)) ? 'selected' : '' ?>>Frequency</option>
                              <option value="1" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 1)) ? 'selected' : '' ?>>Yearly</option>
                              <option value="12" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 12)) ? 'selected' : '' ?>>Monthly</option>
                              <option value="24" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 24)) ? 'selected' : '' ?>>Bi-Monthly</option>
                              <option value="26" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 26)) ? 'selected' : '' ?>>Bi-Weekly</option>
                              <option value="52" <?php echo ((isset($postData['obligor_1_dropdown'])) && ($postData['obligor_1_dropdown'] == 52)) ? 'selected' : '' ?>>Weekly</option>
                            </select></td>
                          </tr>
                          <tr>
                            <td><div class="input_field_wrapper_checkbox text-center">
                                <input type="radio" id="obligor_1_ytd_chk_date" name="obligor_1_radio" class="es_checkbox" value="ytd" onclick="enableDisableField1('obligor','obligor_1_input_ytd')" <?php echo ((isset($postData['obligor_1_radio'])) && ($postData['obligor_1_radio'] == 'ytd')) ? 'checked' : ''; ?>></td>
                              <td><input type="text" name="obligor_1_input_ytd" placeholder="YTD Chk Date" class="" aria-required="true" inputmode="numeric" aria-labelledby="" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligor_1_input_ytd" readonly value="<?php echo isset($postData['obligor_1_input_ytd'])?$postData['obligor_1_input_ytd']: ''; ?>" onchange="callCalcuAnnualGrossIncome('obligor')"></td>
                              <td>
                                <div class="input_field_wrapper">
                                <input class="text-center datepicker sfont" type="text" id="obligor_1_datepick" name="obligor_1_datepick" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="Date" value="<?php echo isset($postData['obligor_1_datepick'])?$postData['obligor_1_datepick']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligor')">
                                </div>
                              </td>
                          </tr>
                          <tr>
                            <td><div class="input_field_wrapper_checkbox text-center"><input type="radio" id="obligor_1_ohio_minimum_wage" name="obligor_1_radio" class="es_checkbox" value="oh_min_wage" onclick="enableDisableField1('obligor','default')" <?php echo ((isset($postData['obligor_1_radio'])) && ($postData['obligor_1_radio'] == 'oh_min_wage')) ? 'checked' : ''; ?>></div></td>
                              <td colspan="2"> Ohio Minimum Wage </td>
                          </tr>
                      </tbody>
                    </table>
                  </td>

                  
                  <td rowspan="1" colspan="2" class="text-right">
                    <div class="input_field_wrapper hide-inputbtns text-center">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_1" name="obligee_1" placeholder="Enter" value="<?php echo isset($postData['obligee_1'])?$postData['obligee_1']:0; ?>" required min=0 readonly>
                    </div>
                  </td>

                  <td rowspan="1" colspan="2" class="text-right">
                    <div class="input_field_wrapper hide-inputbtns text-center">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild"  type="number" id="obligor_1" name="obligor_1" placeholder="Enter"  value="<?php echo isset($postData['obligor_1'])?$postData['obligor_1']:0; ?>" required min=0 readonly>
                    </div>
                  </td>

               </tr>
               <tr>
                  <td rowspan="5">2.</td>
                  <td colspan="14" class="dark-bg">Annual amount of overtime, bonuses, and commissions</td>
               </tr>
               <tr>
                <?php $currentYear = date("Y"); ?>
                  <td colspan="10">a. Year 3 (Three years ago - <?php echo ($currentYear - 3); ?>) </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_2a" name="obligee_2a" placeholder="Enter" value="<?php echo isset($postData['obligee_2a'])?$postData['obligee_2a']:0; ?>" min=0>
            </div></td>
                  <td colspan="2" class="text-right"> <div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency"  type="number" id="obligor_2a" name="obligor_2a" placeholder="Enter" value="<?php echo isset($postData['obligor_2a'])?$postData['obligor_2a']:0; ?>" min=0>
            </div></td>
               </tr>
               <tr>
                  <td colspan="10">b. Year 2 (Two years ago - <?php echo ($currentYear - 2); ?>) </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency"  type="number" id="obligee_2b" name="obligee_2b" placeholder="Enter" value="<?php echo isset($postData['obligee_2b'])?$postData['obligee_2b']:0; ?>" min=0>
            </div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency"  type="number" id="obligor_2b" name="obligor_2b" placeholder="Enter" value="<?php echo isset($postData['obligor_2b'])?$postData['obligor_2b']:0; ?>" min=0>
            </div></td>
               </tr>
               <tr>
                  <td colspan="10">c. Year 1 (Last calendar year - <?php echo ($currentYear - 1); ?>) </td>
                  <td colspan="2" class="text-right"> <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency"  type="number" id="obligee_2c" name="obligee_2c" placeholder="Enter" value="<?php echo isset($postData['obligee_2c'])?$postData['obligee_2c']:0; ?>" min=0>
            </div></td>
                  <td colspan="2" class="text-right"> <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency"  type="number" id="obligor_2c" name="obligor_2c" placeholder="Enter" value="<?php echo isset($postData['obligor_2c'])?$postData['obligor_2c']:0; ?>" min=0>
            </div></td>
               </tr>
               <tr>
                  <td colspan="10">d. Income from overtime, bonuses, and commissions (Enter the lower of the average of   Line 2a plus Line 2b plus Line 2c, or Line 2c) </td>
                  <td colspan="2" class="text-right "> <div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild"  type="number" id="obligee_2d" name="obligee_2d" placeholder="0.00" readonly value="<?php echo isset($postData['obligee_2d'])?$postData['obligee_2d']:''; ?>" >
            </div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency readonly-feild" type="number" id="obligor_2d" name="obligor_2d" placeholder="0.00" value="<?php echo isset($postData['obligor_2d'])?$postData['obligor_2d']:''; ?>" readonly>
            </div></td>
               </tr>
              <tr>
                  <td rowspan="6">3.</td>
                  <td colspan="14" class="dark-bg">Calculation for Self-Employment Income </td>
               </tr>
               <tr>
                  <td colspan="10">a. Gross receipts from business </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency"  type="number" id="obligee_3a" name="obligee_3a" placeholder="Enter" value="<?php echo isset($postData['obligee_3a'])?$postData['obligee_3a']:0; ?>" min=0>
            </div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center"> <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_3a" name="obligor_3a" placeholder="Enter" value="<?php echo isset($postData['obligor_3a'])?$postData['obligor_3a']:0; ?>" min=0> </div></td>
               </tr>
               <tr>
                  <td colspan="10">b. Ordinary and necessary business expenses</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligee_3b" name="obligee_3b" placeholder="Enter" value="<?php echo isset($postData['obligee_3b'])?$postData['obligee_3b']:0; ?>" min=0>
            </div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency" type="number" id="obligor_3b" name="obligor_3b" placeholder="Enter" value="<?php echo isset($postData['obligor_3b'])?$postData['obligor_3b']:0; ?>" min=0>
            </div></td>
               </tr>

               <tr>
                  <td colspan="6" rowspan="2">c. 6.2% of adjusted gross income or  actual marginal difference between  actual rate paid and F.I.C.A rate </td>
                  
                  <td colspan="1"><strong>Parent A</strong></td>
                  <td colspan="3"><strong>Parent B</strong></td>
                  
                  <td rowspan="2" colspan="2" class="text-right">
                    <div class="input_field_wrapper hide-inputbtns text-center">
                        <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_3c" name="obligee_3c" placeholder="0.00" value="<?php echo isset($postData['obligee_3c'])?$postData['obligee_3c']:''; ?>" readonly>
                    </div>
                  </td>

                  <td rowspan="2" colspan="2" class="text-right">
                    <div class="input_field_wrapper hide-inputbtns text-center">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency readonly-feild" type="number" id="obligor_3c" name="obligor_3c" placeholder="0.00" value="<?php echo isset($postData['obligor_3c'])?$postData['obligor_3c']:''; ?>" readonly>
                    </div>
                  </td>

               </tr>
               <tr>
                  <td class="pd-0" colspan="1">
                    <table width="100%" class="anuual-income inner-table">
                        <tr>
                          <td>
                            <div class="input_field_wrapper_checkbox text-center">
                              <input type="radio" id="obligee_3_c_top_override" name="obligee_3_c_radio" class="es_checkbox" value="calculation" onclick="radio3cAction('obligee', 'calculation')" <?php echo ((!isset($postData['obligee_3_c_radio'])) || ($postData['obligee_3_c_radio'] == 'calculation')) ? 'checked' : ''; ?>>
                            </div>
                          </td>

                          <td class="white-space-td">
                            <div class="input_field_wrapper hide-inputbtns text-center">
                              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_3_c_top_override_input" name="obligee_3_c_top_override_input" placeholder="Calculated $ 0.00" readonly value="<?php echo isset($postData['obligee_3_c_top_override_input'])?$postData['obligee_3_c_top_override_input']:''; ?>"><br/>
                            </div>
                          </td>
                      </tr>


                      <tr>    
                          <td>
                            <div class="input_field_wrapper_checkbox text-center">
                              <input type="radio" id="obligee_3_c_override" name="obligee_3_c_radio" class="es_checkbox" value="manual" onclick="radio3cAction('obligee', 'manual')" <?php echo ((isset($postData['obligee_3_c_radio'])) && ($postData['obligee_3_c_radio'] == 'manual')) ? 'checked' : ''; ?>>
                            </div>
                          </td>

                          <td class="white-space-td">
                            <div class="input_field_wrapper hide-inputbtns text-center">
                              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_3_c_override_input" name="obligee_3_c_override_input" placeholder="Actual Marginal $ 0.00" readonly value="<?php echo isset($postData['obligee_3_c_override_input'])?$postData['obligee_3_c_override_input']:''; ?>"><br/>
                            </div>
                          </td>
                      </tr>

                  </table>
                </td>
                <td class="pd-0" colspan="3">
                    <table width="100%" class="anuual-income inner-table">

                      <tr>
                        <td>
                          <div class="input_field_wrapper_checkbox text-center">
                            <input type="radio" id="obligor_3_c_top_override" name="obligor_3_c_radio" class="es_checkbox" value="calculation" onclick="radio3cAction('obligor', 'calculation')" <?php echo ((!isset($postData['obligor_3_c_radio'])) || ($postData['obligor_3_c_radio'] == 'calculation')) ? 'checked' : ''; ?>>
                          </div>
                        </td>

                        <td class="white-space-td">
                          <div class="input_field_wrapper hide-inputbtns text-center">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_3_c_top_override_input" name="obligor_3_c_top_override_input" placeholder="Calculated $ 0.00" readonly value="<?php echo isset($postData['obligor_3_c_top_override_input'])?$postData['obligor_3_c_top_override_input']:''; ?>"><br/>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>
                          <div class="input_field_wrapper_checkbox text-center">
                            <input type="radio" id="obligor_3_c_override" name="obligor_3_c_radio" class="es_checkbox" value="manual" onclick="radio3cAction('obligor', 'manual')" <?php echo ((isset($postData['obligor_3_c_radio'])) && ($postData['obligor_3_c_radio'] == 'manual')) ? 'checked' : ''; ?>>
                          </div>
                        </td>

                        <td class="white-space-td">
                          <div class="input_field_wrapper hide-inputbtns text-center">
                            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_3_c_override_input" name="obligor_3_c_override_input" placeholder="Actual Marginal $ 0.00" readonly value="<?php echo isset($postData['obligor_3_c_override_input'])?$postData['obligor_3_c_override_input']:''; ?>"><br/>
                          </div>
                        </td>
                      </tr>
                  </table>

                </td>
              </tr>

               <tr>
                  <td colspan="10">d. Adjusted annual gross income from self-employment (Line 3a minus Line 3b minus Line 3c) </td>
                  <td colspan="2" class="text-right"> <div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency readonly-feild" type="number" id="obligee_3d" name="obligee_3d" placeholder="0.00" value="<?php echo isset($postData['obligee_3d'])?$postData['obligee_3d']:''; ?>" readonly>
            </div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="textright currency readonly-feild" type="number" id="obligor_3d" name="obligor_3d"  placeholder="0.00" value="<?php echo isset($postData['obligor_3d'])?$postData['obligor_3d']:''; ?>" readonly></div></td>
               </tr>
                  <tr>
                  <td>4.</td>
                  <td colspan="10">Annual income from unemployment compensation</td>
                  <td colspan="2" class="text-right"><div  class="input_field_wrapper hide-inputbtns">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_4" name="obligee_4" placeholder="Enter" value="<?php echo isset($postData['obligee_4'])?$postData['obligee_4']:0; ?>" min=0></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"   class="textright currency" type="number" id="obligor_4" name="obligor_4"  placeholder="Enter" value="<?php echo isset($postData['obligor_4'])?$postData['obligor_4']:0; ?>" min=0></div></td>
               </tr>
                <tr>
                  <td>5.</td>
                  <td colspan="10">Annual income from workers' compensation, disability insurance, or social security  disability/retirement benefits </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_5" name="obligee_5" placeholder="Enter" value="<?php echo isset($postData['obligee_5'])?$postData['obligee_5']:0; ?>" min=0></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_5" name="obligor_5"  placeholder="Enter" value="<?php echo isset($postData['obligor_5'])?$postData['obligor_5']:0; ?>" min=0></div></td>
               </tr>
               <tr>
                  <td>6.</td>
                  <td colspan="10">Other annual income or potential income </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_6" name="obligee_6" placeholder="Enter" value="<?php echo isset($postData['obligee_6'])?$postData['obligee_6']:0; ?>" min=0></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
                <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_6" name="obligor_6"  placeholder="Enter" value="<?php echo isset($postData['obligor_6'])?$postData['obligor_6']:0; ?>" min=0>
            </div></td>
               </tr>

                <tr>
                  <td>7.</td>
                  <td colspan="10">Total annual gross income (Add Lines 1, 2d, 3d, 4, 5 and 6, if Line 7 results in a negative  amount, enter “0”)</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_7" name="obligee_7" placeholder="0.00" value="<?php echo isset($postData['obligee_7'])?$postData['obligee_7']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_7" name="obligor_7"  placeholder="0.00" value="<?php echo isset($postData['obligor_7'])?$postData['obligor_7']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td>8.</td>
                  <td colspan="10">Health insurance maximum (Multiply Line 7 by 5% or .05)</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_8" name="obligee_8" placeholder="0.00" value="<?php echo isset($postData['obligee_8'])?$postData['obligee_8']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_8" name="obligor_8"  placeholder="0.00" value="<?php echo isset($postData['obligor_8'])?$postData['obligor_8']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="15"><strong>II. ADJUSTMENTS TO INCOME</strong></td>
               </tr>
               <tr>
                  <td rowspan="7">9.</td>
                  <td colspan="14" class="dark-bg">Adjustment for Other Minor Children Not of This Order. (Note: Line 9 is only completed if either parent has any children outside  of this order.) If neither parent has any children outside of this order enter "0" on Line 9f and proceed to Line 10.  For each parent:</td>
               </tr>
               <tr>
                  <td colspan="10">a. Enter the total number of children, including children of this order and other children</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input step="1" class="textright" type="number" id="obligee_9a" name="obligee_9a" placeholder="Enter" value="<?php echo isset($postData['obligee_9a'])?$postData['obligee_9a']:0; ?>" min=0></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input  step="1" class="textright currency" type="number" id="obligor_9a" name="obligor_9a" placeholder="Enter" value="<?php echo isset($postData['obligor_9a'])?$postData['obligor_9a']:0; ?>" min=0></div></td>
               </tr>
               <tr>
                  <td colspan="10">b. Enter the number of children subject to this order </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input  step="1" class="textright" type="number" id="obligee_9b" name="obligee_9b" placeholder="Enter" value="<?php echo isset($postData['obligee_9b'])?$postData['obligee_9b']:0; ?>" min=0></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input  step="1" class="textright currency" type="number" id="obligor_9b" name="obligor_9b" placeholder="Enter" value="<?php echo isset($postData['obligor_9b'])?$postData['obligor_9b']:0; ?>" min=0></div></td>
               </tr>
                <tr>
                  <td colspan="10">c. Line 9a minus Line 9b </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input  step="1" class="textright readonly-feild" type="number" id="obligee_9c" name="obligee_9c" placeholder="0.00" value="<?php echo isset($postData['obligee_9c'])?$postData['obligee_9c']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input  step="1" class="textright readonly-feild" type="number" id="obligor_9c" name="obligor_9c" placeholder="0.00" value="<?php echo isset($postData['obligor_9c'])?$postData['obligor_9c']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="10">d. Using the Basic Child Support Schedule, enter the amount from the corresponding cell   for each parent’s total annual gross income from Line 7 for the number of children on Line 9a</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_9d" name="obligee_9d" placeholder="Calculate" value="<?php echo isset($postData['obligee_9d'])?$postData['obligee_9d']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_9d" name="obligor_9d" placeholder="Calculate" readonly value="<?php echo isset($postData['obligor_9d'])?$postData['obligor_9d']:''; ?>"></div></td>
               </tr>
               <tr>
                  <td colspan="10">e. Divide the amount on Line 9d by the number on Line 9a</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_9e" name="obligee_9e" placeholder="0.00" value="<?php echo isset($postData['obligee_9e'])?$postData['obligee_9e']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_9e" name="obligor_9e"  placeholder="0.00" value="<?php echo isset($postData['obligor_9e'])?$postData['obligor_9e']:''; ?>" readonly=""></div></td>
               </tr>
               <tr>
                  <td colspan="10">f. Multiply the amount from Line 9e by the number on Line 9c. This is the adjustment   amount for other minor children for each parent.</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_9f" name="obligee_9f" placeholder="Calculate" value="<?php echo isset($postData['obligee_9f'])?$postData['obligee_9f']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_9f" name="obligor_9f"  placeholder="Calculate" value="<?php echo isset($postData['obligor_9f'])?$postData['obligor_9f']:''; ?>" readonly></div></td>
               </tr>
                 <tr>
                  <td rowspan="2">10.</td>
                  <td colspan="10">a. Identify the health insurance obligor(s).</td>
                  <td colspan="2" class="text-center"><div class="input_field_wrapper_checkbox text-center" >
              <input type="checkbox" id="obligee_10a" name="obligee_10a" class="es_checkbox" value="1" <?php if(isset($postData['obligee_10a']) && $postData['obligee_10a']==1) { echo 'checked'; } ?>>
            </div></td>
                  <td colspan="2" class="text-center"><div class="input_field_wrapper_checkbox text-center">
              <input type="checkbox" id="obligor_10a" name="obligor_10a"  class="es_checkbox" value="1" e="1" <?php if(isset($postData['obligor_10a']) && $postData['obligor_10a']==1) { echo 'checked'; } ?>>
            </div></td>
               </tr>
               <tr>
                  <td colspan="10">b. Enter the total out-of-pocket costs for health insurance premiums for the   parent(s) identified on Line 10a.</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" id="obligee_10b"  class="textright currency" name="obligee_10b" placeholder="Enter" value="<?php echo isset($postData['obligee_10b'])?$postData['obligee_10b']:0; ?>" min=0>
          </div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_10b" name="obligor_10b"  value="<?php echo isset($postData['obligor_10b'])?$postData['obligor_10b']:0; ?>" placeholder="Enter" min=0></div></td>
               </tr>
               <tr>
                  <td>11.</td>
                  <td colspan="10">Annual court ordered spousal support paid; if no spousal support is paid, enter “0”</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligee_11" name="obligee_11" placeholder="Enter" value="<?php echo isset($postData['obligee_11'])?$postData['obligee_11']:0; ?>" min=0></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency" type="number" id="obligor_11" name="obligor_11"  placeholder="Enter" value="<?php echo isset($postData['obligor_11'])?$postData['obligor_11']:0; ?>" min=0></div></td>
               </tr>
               <tr>
                  <td>12.</td>
                  <td colspan="10">Total adjustments to income (Line 9f, plus Line 10b, plus Line 11)</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_12" name="obligee_12" placeholder="0.00" value="<?php echo isset($postData['obligee_12'])?$postData['obligee_12']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_12" name="obligor_12"  placeholder="0.00" value="<?php echo isset($postData['obligor_12'])?$postData['obligor_12']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td>13.</td>
                  <td colspan="10">Adjusted annual gross income (Line 7 minus Line 12; if Line 13 results in a negative  amount, enter "0") </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_13" name="obligee_13" placeholder="0.00" value="<?php echo isset($postData['obligee_13'])?$postData['obligee_13']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_13" name="obligor_13"  placeholder="0.00"  value="<?php echo isset($postData['obligor_13'])?$postData['obligor_13']:''; ?>" readonly></div></td>
               </tr>
                 <tr>
                  <td colspan="11"><strong>III. INCOME SHARES</strong></td>
                  <td colspan="2" class="text-center"><strong>Parent A</strong></td>
                  <td colspan="2" class="text-center"><strong>Parent B</strong></td>
               </tr>
               <tr>
                  <td>14.</td>
                  <td colspan="10">Enter the amount from Line 13 for each parent (Adjusted annual gross income) </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_14" name="obligee_14" placeholder="0.00" value="<?php echo isset($postData['obligee_14'])?$postData['obligee_14']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_14" name="obligor_14"  placeholder="0.00" value="<?php echo isset($postData['obligor_14'])?$postData['obligor_14']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td>15.</td>
                  <td colspan="10">If the parent’s obligation is in the shaded area of the schedule for the children of this order, check  the box for Line 15</td>
                  <td colspan="2" class="text-center"> <div class="input_field_wrapper_checkbox text-center">
                  <input type="checkbox" id="obligee_15_shown" class="es_checkbox" value="" <?php if(isset($postData['obligee_15']) && $postData['obligee_15']==1) { echo 'checked'; } ?> disabled>
              <input type="checkbox" style="display: none;" id="obligee_15" name="obligee_15"  class="es_checkbox" value="1" <?php if(isset($postData['obligee_15']) && $postData['obligee_15']==1) { echo 'checked'; } ?>>
             </div></td>
                  <td colspan="2" class="text-center"> <div class="input_field_wrapper_checkbox text-center">
                <input type="checkbox" id="obligor_15_shown"  class="es_checkbox" value="" <?php if(isset($postData['obligor_15']) && $postData['obligor_15']==1) { echo 'checked'; } ?> disabled>
              <input type="checkbox"  style="display: none;" id="obligor_15" name="obligor_15"  class="es_checkbox" value="1" <?php if(isset($postData['obligor_15']) && $postData['obligor_15']==1) { echo 'checked'; } ?>>
            </div></td>
               </tr>
               <tr>
                  <td>16.</td>
                  <td colspan="10">Combined adjusted annual gross income (Add together the amounts of Line 14 for both parents)</td>
                  <td colspan="4" class="text-center"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild" type="number" id="obligee_16" name="obligee_16" value="<?php echo isset($postData['obligee_16'])?$postData['obligee_16']:''; ?>" placeholder="0.00" readonly></div></td>
               </tr>
               <tr>
                  <td>17.</td>
                  <td colspan="10">Income Share: The percentage of parent's income to combined annual adjusted gross income</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns  percentage_end">
            <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligee_17" name="obligee_17" placeholder="0.00" value="<?php echo isset($postData['obligee_17'])?$postData['obligee_17']:''; ?>" readonly>
          </div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center percentage_end"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency readonly-feild" type="number" id="obligor_17" name="obligor_17"  placeholder="0.00" value="<?php echo isset($postData['obligor_17'])?$postData['obligor_17']:''; ?>" readonly></div></td>
               </tr>
            </tbody>
         </table>
         <p class="print-footer">© <?php echo date("Y");?> First Draft Data, LLC. All Rights Reserved. V <?php echo date("Y");?>-1 <span class="text-right">1/3</span></p>
         <div class="page-break"></div>
         <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tbody>
                <tr class="hide-header-tr">
                  <td colspan="6">Parent A Name
                     <input class="text-center" type="text" name="obligee_name1" placeholder="Enter" value="<?php echo isset($postData['obligee_name'])?$postData['obligee_name']:''; ?>" >
                  </td>
                  <td colspan="5">Parent B Name
                     <input class="text-center" type="text" name="obligor_name1" placeholder="Enter" value="<?php echo isset($postData['obligor_name'])?$postData['obligor_name']:''; ?>">
                  </td>
                  <td colspan="4" class="white-space-td">Date this form is completed
                     <input class="text-center" type="text" name="created_at1" value="<?php echo date("m/d/Y"); ?>" readonly>
                  </td>
               </tr>
               <tr class="hide-header-tr">
                 <td colspan="4">County Name
                      <?php $state=isset($sheet_state)?$sheet_state:'';
                  $county_selected=isset($postData['county_name'])?$postData['county_name']:'';
            ?><select id="county_name" class="county-select" name="county_name1">
                            <option value="">Choose County</option>
                          </select>
                    
                    </td>
                  <td colspan="4">SETS Case Number
                     <input class="text-center" type="text" name="sets_case_number1" placeholder="Enter" value="<?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>">
                  </td>
                  <td colspan="3">Court or Administrative Order Number
                     <input class="text-center" type="text" name="court_administrative_order_number1" placeholder="Enter" value="<?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>">
                  </td>
                  <td colspan="4">Number of Children of the Order
                     <input class="text-center" type="number" min="1" max="15" step="1" id="number_children_order" name="number_children_order1" value="<?php echo isset($postData['number_children_order'])?$postData['number_children_order']:''; ?>" placeholder="Enter">
                  </td>
               </tr>
               <tr>
                  <td colspan="15"><strong>IV. SUPPORT CALCULATION</strong></td>
               </tr>
               <tr>
                  <td rowspan="7">18.</td>
                  <td colspan="14" class="dark-bg">Basic Child Support Obligation</td>
               </tr>
               <tr>
                  <td colspan="5">Number of children with Parent A: <div class="input_field_wrapper hide-inputbtns"><input required step="1" class="textleft" type="number" id="parent_a_children" name="parent_a_children" placeholder="Enter" value="<?php echo isset($postData['parent_a_children'])?$postData['parent_a_children']:0; ?>" min=0></div></td>
                  <td colspan="5">Number of children with Parent B: <div class="input_field_wrapper hide-inputbtns"><input required step="1" class="textleft" type="number" id="parent_b_children" name="parent_b_children" placeholder="Enter" value="<?php echo isset($postData['parent_b_children'])?$postData['parent_b_children']:0; ?>" min=0></div></td>
                  <td colspan="2" class="text-center">Parent A Custodial </td>
                  <td colspan="2" class="text-center">Parent B Custodial</td>
               </tr>
               <tr>
                  <td colspan="10" class="dark-bg"></td>
                  <td class="text-center dark-bg white-space-td">Parent A</td>
                  <td class="text-center dark-bg white-space-td">Parent B</td>
                  <td class="text-center dark-bg white-space-td">Parent A</td>
                  <td class="text-center dark-bg white-space-td">Parent B</td>
               </tr>
               <tr>
                  <td colspan="10" class="font-s">a. Using the Basic Child Support Schedule, enter the amount from the corresponding cell for each
                     parent’s adjusted gross income on Line 14 for the number of children with each parent. If either parent’s Line 14 amount is less than lowest income amount on the Basic Schedule, enter “960”
                  </td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild sfont" type="number" id="18a1" name="18a1" placeholder="0.00" value="<?php echo isset($postData['18a1'])?$postData['18a1']:''; ?>" readonly>
                  </div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="18a2" name="18a2"  placeholder="0.00" value="<?php echo isset($postData['18a2'])?$postData['18a2']:''; ?>" readonly></div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="18a3" name="18a3" placeholder="0.00" value="<?php echo isset($postData['18a3'])?$postData['18a3']:''; ?>" readonly></div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="18a4" name="18a4"  placeholder="0.00" value="<?php echo isset($postData['18a4'])?$postData['18a4']:''; ?>" readonly></div></td>
               </tr>
                <tr>
                  <td colspan="10" class="font-s">b. Using the Basic Child Support Schedule, enter the amount from the corresponding cell for the
                     parents’ combined annual gross incomeon Line 16 for the number of children with each parent. If Line 16 amount is less than lowest income amount on the Basic Schedule, enter “960”
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild" type="number" id="obligee_18b" name="obligee_18b" placeholder="0.00" value="<?php echo isset($postData['obligee_18b'])?$postData['obligee_18b']:''; ?>" readonly></div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild" type="number" id="obligor_18b" name="obligor_18b" placeholder="0.00" value="<?php echo isset($postData['obligor_18b'])?$postData['obligor_18b']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="10">c. Multiply the amount in Line 18b by Line 17 for each parent and enter the amount</td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="18c1" name="18c1" placeholder="0.00" value="<?php echo isset($postData['18c1'])?$postData['18c1']:''; ?>" readonly></div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="18c2" name="18c2"  placeholder="0.00" value="<?php echo isset($postData['18c2'])?$postData['18c2']:''; ?>" readonly></div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild sfont" type="number" id="18c3" name="18c3" placeholder="0.00" value="<?php echo isset($postData['18c3'])?$postData['18c3']:''; ?>" readonly></div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="18c4" name="18c4"  placeholder="0.00" value="<?php echo isset($postData['18c4'])?$postData['18c4']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="10">d. Enter the lower of Line 18a or Line 18c for each parent, if less than “960”, enter “960”</td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild sfont" type="number" id="18d1" name="18d1" placeholder="0.00" value="<?php echo isset($postData['18d1'])?$postData['18d1']:''; ?>" readonly></div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild sfont" type="number" id="18d2" name="18d2"  placeholder="0.00" value="<?php echo isset($postData['18d2'])?$postData['18d2']:''; ?>" readonly></div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild sfont" type="number" id="18d3" name="18d3" placeholder="0.00" value="<?php echo isset($postData['18d3'])?$postData['18d3']:''; ?>" readonly></div></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="18d4" name="18d4"  placeholder="0.00" value="<?php echo isset($postData['18d4'])?$postData['18d4']:''; ?>" readonly></div></td>
               </tr>
              <tr>
                  <td rowspan="3">19.</td>
                  <td colspan="10" class="dark-bg">Parenting Time Orde</td>
                  <td colspan="2" class="text-center dark-bg white-space-td">Parent A Custodial</td>
                  <td colspan="2" class="text-center dark-bg white-space-td">Parent B Custodial</td>
               </tr>
               <tr>
                  <td colspan="10" class="font-s">a. Enter “Yes” for any parent for whom a court has issued or is issuing a parenting time order that
                     equals or exceeds ninety overnights per year
                  </td>
                  <td></td>
                  <td><input type="checkbox" id="obligee_19a" name="obligee_19a" class="es_checkbox" value="1" <?php if(isset($postData['obligee_19a']) && $postData['obligee_19a']==1) { echo 'checked'; } ?>>
                      <label for="checkbox5">Yes</label></td>
                  <td><div class="input_field_wrapper_checkbox text-center">
                    <input type="checkbox" id="obligor_19a" name="obligor_19a"  class="es_checkbox" value="1" <?php if(isset($postData['obligor_19a']) && $postData['obligor_19a']==1) { echo 'checked'; } ?>>
                      <label for="checkbox6">Yes</label>
                  </div></td>
                  <td></td>
               </tr>
               <tr>
                  <td colspan="10" class="font-s">b. If Line 19a is checked, use the amount for that parent from Line 18d and multiply it by 10% or
                     .10, and enter this amount. If Line 19a is blank enter “0”
                  </td>
                  <td></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_19b" name="obligee_19b" placeholder="0.00"  value="<?php echo isset($postData['obligee_19b'])?$postData['obligee_19b']:''; ?>" readonly></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_19b" name="obligor_19b"  placeholder="0.00" value="<?php echo isset($postData['obligor_19b'])?$postData['obligor_19b']:''; ?>" readonly></div></td>
                  <td></td>
               </tr>
              <tr>
                  <td rowspan="2">20.</td>
                  <td colspan="10" class="dark-bg">Derivative Benefit (Child’s benefit on behalf of a parent)</td>
                  <td colspan="2" class="text-center dark-bg">Parent A Custodial</td>
                  <td colspan="2" class="text-center dark-bg">Parent B Custodial</td>
               </tr>
               <tr>
                  <td colspan="10">Enter any non-means-tested benefits received by a child(ren) subject to the order.</td>
                  <td></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="20a2" name="20a2"  placeholder="Enter" value="<?php echo isset($postData['20a2'])?$postData['20a2']:0; ?>" min=0></div></td>
                  <td><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="20a3" name="20a3" placeholder="Enter" value="<?php echo isset($postData['20a3'])?$postData['20a3']:0; ?>" min=0></div></td>
                  <td></td>
               </tr>
               <tr>
                  <td rowspan="35">21.</td>
                  <td colspan="10" class="dark-bg">Child Care Expenses</td>
                  <td colspan="2" class="text-center dark-bg">Parent A Custodial</td>
                  <td colspan="2" class="text-center dark-bg">Parent B Custodial</td>
               </tr>
               <tr>
                  <td colspan="10" class="border-bottom-0"></td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
               </tr>
              <tr>
                  <td colspan="10" class="border-top-0">a. Annual child care expenses for children with each parent (Less any subsidies)</td>
                  <td class="text-center"><div class="input_field_wrapper sfont hide-inputbtns">

                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="21a1" name="21a1" placeholder="Enter" value="<?php echo isset($postData['21a1'])?$postData['21a1']:0; ?>" min=0 readonly>

                  </div></td>
                  <td class="text-center"> <div class="input_field_wrapper  sfont hide-inputbtns">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="21a2" name="21a2" placeholder="Enter" value="<?php echo isset($postData['21a2'])?$postData['21a2']:0; ?>" min=0 readonly>
                  </div></td>
                  <td class="text-center"><div class="input_field_wrapper sfont hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="21a3" name="21a3" placeholder="Enter" value="<?php echo isset($postData['21a3'])?$postData['21a3']:0; ?>" min=0 readonly></div></td>
                  <td class="text-center"><div class="input_field_wrapper  sfont hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="21a4" name="21a4" placeholder="Enter" value="<?php echo isset($postData['21a4'])?$postData['21a4']:0; ?>" min=0 readonly></div></td>
               </tr>
               <tr>
                  <td colspan="14">Children with Parent A</td>
               </tr>
               <tr>
                  <td colspan="2"><a class="btn btn-info hide-print-buttons" href="#" data-toggle="modal" data-target="#myModal">Edit</a></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligee_21b1_child_name'])?$postData['obligee_21b1_child_name']:'Child 1'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligee_21b2_child_name'])?$postData['obligee_21b2_child_name']:'Child 2'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligee_21b3_child_name'])?$postData['obligee_21b3_child_name']:'Child 3'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligee_21b4_child_name'])?$postData['obligee_21b4_child_name']:'Child 4'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligee_21b5_child_name'])?$postData['obligee_21b5_child_name']:'Child 5'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligee_21b6_child_name'])?$postData['obligee_21b6_child_name']:'Child 6'; ?></td>
               </tr>
                <tr>
                  <td colspan="2">Birth Date</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker sfont" type="text" id="obligee_21b1" name="obligee_21b1" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligee_21b1'])?$postData['obligee_21b1']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker sfont"type="text" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" id="obligee_21b2" name="obligee_21b2" placeholder="DatePick" value="<?php echo isset($postData['obligee_21b2'])?$postData['obligee_21b2']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker sfont"type="text" id="obligee_21b3" name="obligee_21b3" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligee_21b3'])?$postData['obligee_21b3']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker sfont" type="text" id="obligee_21b4" name="obligee_21b4" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligee_21b4'])?$postData['obligee_21b4']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker sfont"type="text" id="obligee_21b5" name="obligee_21b5" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligee_21b5'])?$postData['obligee_21b5']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker sfont" type="text" id="obligee_21b6" name="obligee_21b6" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligee_21b6'])?$postData['obligee_21b6']:''; ?>"></div></td>
               </tr>
              <tr>
                  <td colspan="2">b. Age</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center sfont readonly-feild" type="text" id="obligee_21b1a" placeholder="Calculate" name="obligee_21b1a" value="<?php echo isset($postData['obligee_21b1a'])?$postData['obligee_21b1a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center sfont readonly-feild " type="text" id="obligee_21b2a" name="obligee_21b2a" placeholder="Calculate" value="<?php echo isset($postData['obligee_21b2a'])?$postData['obligee_21b2a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="readonly-feild text-center sfont" placeholder="Calculate" type="text" id="obligee_21b3a" name="obligee_21b3a" value="<?php echo isset($postData['obligee_21b3a'])?$postData['obligee_21b3a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="readonly-feild text-center sfont" placeholder="Calculate" type="text" id="obligee_21b4a" name="obligee_21b4a" value="<?php echo isset($postData['obligee_21b4a'])?$postData['obligee_21b4a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="readonly-feild text-center sfont" placeholder="Calculate" type="text" id="obligee_21b5a" name="obligee_21b5a" value="<?php echo isset($postData['obligee_21b5a'])?$postData['obligee_21b5a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="readonly-feild text-center sfont" type="text" id="obligee_21b6a" name="obligee_21b6a" placeholder="Calculate" value="<?php echo isset($postData['obligee_21b6a'])?$postData['obligee_21b6a']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="2">c. Max</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21c1" name="obligee_21c1" placeholder="0.00" value="<?php echo isset($postData['obligee_21c1'])?$postData['obligee_21c1']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21c2" name="obligee_21c2" placeholder="0.00" value="<?php echo isset($postData['obligee_21c2'])?$postData['obligee_21c2']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21c3" name="obligee_21c3" placeholder="0.00" value="<?php echo isset($postData['obligee_21c3'])?$postData['obligee_21c3']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21c4" name="obligee_21c4" value="<?php echo isset($postData['obligee_21c4'])?$postData['obligee_21c4']:''; ?>" placeholder="0.00" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21c5" name="obligee_21c5" placeholder="0.00" value="<?php echo isset($postData['obligee_21c5'])?$postData['obligee_21c5']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21c6" name="obligee_21c6" placeholder="0.00" value="<?php echo isset($postData['obligee_21c6'])?$postData['obligee_21c6']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="2" class="border-bottom-0">d. Actual</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
               </tr>
               <tr>
                  <td colspan="2"></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21d1" name="obligee_21d1" placeholder="Enter" value="<?php echo isset($postData['obligee_21d1'])?$postData['obligee_21d1']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21d1" name="obligor_21d1" placeholder="Enter" value="<?php echo isset($postData['obligor_21d1'])?$postData['obligor_21d1']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21d2" name="obligee_21d2" placeholder="Enter" value="<?php echo isset($postData['obligee_21d2'])?$postData['obligee_21d2']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21d2" name="obligor_21d2" placeholder="Enter" value="<?php echo isset($postData['obligor_21d2'])?$postData['obligor_21d2']:0; ?>" min=0></div></td>
                  <td class="text-center color-green">  <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21d3" name="obligee_21d3" placeholder="Enter" value="<?php echo isset($postData['obligee_21d3'])?$postData['obligee_21d3']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21d3" name="obligor_21d3" placeholder="Enter" value="<?php echo isset($postData['obligor_21d3'])?$postData['obligor_21d3']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21d4" name="obligee_21d4" placeholder="Enter" value="<?php echo isset($postData['obligee_21d4'])?$postData['obligee_21d4']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21d4" name="obligor_21d4" placeholder="Enter" value="<?php echo isset($postData['obligor_21d4'])?$postData['obligor_21d4']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21d5" name="obligee_21d5" placeholder="Enter" value="<?php echo isset($postData['obligee_21d5'])?$postData['obligee_21d5']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21d5" name="obligor_21d5" placeholder="Enter" value="<?php echo isset($postData['obligor_21d5'])?$postData['obligor_21d5']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21d6" name="obligee_21d6" placeholder="Enter" value="<?php echo isset($postData['obligee_21d6'])?$postData['obligee_21d6']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21d6" name="obligor_21d6" placeholder="Enter" value="<?php echo isset($postData['obligor_21d6'])?$postData['obligor_21d6']:0; ?>" min=0></div></td>
               </tr>
                <tr>
                  <td colspan="2">e. Lowest</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21e1" name="obligee_21e1" placeholder="0.00" value="<?php echo isset($postData['obligee_21e1'])?$postData['obligee_21e1']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21e2" name="obligee_21e2"  placeholder="0.00" value="<?php echo isset($postData['obligee_21e2'])?$postData['obligee_21e2']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21e3" name="obligee_21e3" value="<?php echo isset($postData['obligee_21e3'])?$postData['obligee_21e3']:''; ?>" placeholder="0.00" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21e4" name="obligee_21e4" value="<?php echo isset($postData['obligee_21e4'])?$postData['obligee_21e4']:''; ?>"  placeholder="0.00" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21e5" name="obligee_21e5" value="<?php echo isset($postData['obligee_21e5'])?$postData['obligee_21e5']:''; ?>" placeholder="0.00" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21e6" name="obligee_21e6"  placeholder="0.00" value="<?php echo isset($postData['obligee_21e6'])?$postData['obligee_21e6']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="2" class="border-bottom-0">Apportioned</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
               </tr>
               <tr>
                  <td colspan="2"></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_A1" name="21_apportioned_obligee_A1"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_A1'])?$postData['21_apportioned_obligee_A1']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_B1" name="21_apportioned_obligee_B1"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_B1'])?$postData['21_apportioned_obligee_B1']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_A2" name="21_apportioned_obligee_A2"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_A2'])?$postData['21_apportioned_obligee_A2']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_B2" name="21_apportioned_obligee_B2"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_B2'])?$postData['21_apportioned_obligee_B2']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_A3" name="21_apportioned_obligee_A3"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_A3'])?$postData['21_apportioned_obligee_A3']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_B3" name="21_apportioned_obligee_B3"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_B3'])?$postData['21_apportioned_obligee_B3']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_A4" name="21_apportioned_obligee_A4"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_A4'])?$postData['21_apportioned_obligee_A4']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_B4" name="21_apportioned_obligee_B4"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_B4'])?$postData['21_apportioned_obligee_B4']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_A5" name="21_apportioned_obligee_A5"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_A5'])?$postData['21_apportioned_obligee_A5']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_B5" name="21_apportioned_obligee_B5"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_B5'])?$postData['21_apportioned_obligee_B5']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_A6" name="21_apportioned_obligee_A6"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_A6'])?$postData['21_apportioned_obligee_A6']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligee_B6" name="21_apportioned_obligee_B6"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligee_B6'])?$postData['21_apportioned_obligee_B6']:0; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="14">Children with Parent B</td>
               </tr>
               <tr>
                  <td colspan="2"><a class="btn btn-info hide-print-buttons" href="#" data-toggle="modal" data-target="#myModal">Edit</a></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligor_21b1_child_name'])?$postData['obligor_21b1_child_name']:'Child 1'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligor_21b2_child_name'])?$postData['obligor_21b2_child_name']:'Child 2'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligor_21b3_child_name'])?$postData['obligor_21b3_child_name']:'Child 3'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligor_21b4_child_name'])?$postData['obligor_21b4_child_name']:'Child 4'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligor_21b5_child_name'])?$postData['obligor_21b5_child_name']:'Child 5'; ?></td>
                  <td colspan="2" class="text-center"><?php echo isset($postData['obligor_21b6_child_name'])?$postData['obligor_21b6_child_name']:'Child 6'; ?></td>
               </tr>
               <tr>
                  <td colspan="2">Birth Date</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker" type="text" id="obligor_21b1" name="obligor_21b1" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligor_21b1'])?$postData['obligor_21b1']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker"type="text" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" id="obligor_21b2" name="obligor_21b2" placeholder="DatePick" value="<?php echo isset($postData['obligor_21b2'])?$postData['obligor_21b2']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker"type="text" id="obligor_21b3" name="obligor_21b3" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligor_21b3'])?$postData['obligor_21b3']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker" type="text" id="obligor_21b4" name="obligor_21b4" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligor_21b4'])?$postData['obligor_21b4']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker"type="text" id="obligor_21b5" name="obligor_21b5" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligor_21b5'])?$postData['obligor_21b5']:''; ?>"></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center datepicker" type="text" id="obligor_21b6" name="obligor_21b6" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php echo isset($postData['obligor_21b6'])?$postData['obligor_21b6']:''; ?>"></div></td>
               </tr>
               <tr>
                  <td colspan="2">f. Age</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center sfont readonly-feild" type="text" id="obligor_21b1a" placeholder="Calculate" name="obligor_21b1a" value="<?php echo isset($postData['obligor_21b1a'])?$postData['obligor_21b1a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center sfont readonly-feild" type="text" id="obligor_21b2a" name="obligor_21b2a" placeholder="Calculate" value="<?php echo isset($postData['obligor_21b2a'])?$postData['obligor_21b2a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center sfont readonly-feild" placeholder="Calculate" type="text" id="obligor_21b3a" name="obligor_21b3a" value="<?php echo isset($postData['obligor_21b3a'])?$postData['obligor_21b3a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center sfont readonly-feild" placeholder="Calculate" type="text" id="obligor_21b4a" name="obligor_21b4a" value="<?php echo isset($postData['obligor_21b4a'])?$postData['obligor_21b4a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center sfont readonly-feild" placeholder="Calculate" type="text" id="obligor_21b5a" name="obligor_21b5a" value="<?php echo isset($postData['obligor_21b5a'])?$postData['obligor_21b5a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper"><input class="text-center sfont readonly-feild" type="text" id="obligor_21b6a" name="obligor_21b6a" placeholder="Calculate" value="<?php echo isset($postData['obligor_21b6a'])?$postData['obligor_21b6a']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="2">g. Max</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21c1" name="obligor_21c1" placeholder="0.00" value="<?php echo isset($postData['obligor_21c1'])?$postData['obligor_21c1']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21c2" name="obligor_21c2" placeholder="0.00" value="<?php echo isset($postData['obligor_21c2'])?$postData['obligor_21c2']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21c3" name="obligor_21c3" placeholder="0.00" value="<?php echo isset($postData['obligor_21c3'])?$postData['obligor_21c3']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21c4" name="obligor_21c4" value="<?php echo isset($postData['obligor_21c4'])?$postData['obligor_21c4']:''; ?>" placeholder="0.00" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligor_21c5" name="obligor_21c5" placeholder="0.00" value="<?php echo isset($postData['obligor_21c5'])?$postData['obligor_21c5']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21c6" name="obligor_21c6" placeholder="0.00" value="<?php echo isset($postData['obligor_21c6'])?$postData['obligor_21c6']:''; ?>" readonly></div></td>
               </tr>

               <tr>
                  <td colspan="2" class="border-bottom-0">h. Actual</td>
                  <td class="text-center white-space-td">Parent A</td>
                  <td class="text-center white-space-td">Parent B</td>
                  <td class="text-center white-space-td">Parent A</td>
                  <td class="text-center white-space-td">Parent B</td>
                  <td class="text-center white-space-td">Parent A</td>
                  <td class="text-center white-space-td">Parent B</td>
                  <td class="text-center white-space-td">Parent A</td>
                  <td class="text-center white-space-td">Parent B</td>
                  <td class="text-center white-space-td">Parent A</td>
                  <td class="text-center white-space-td">Parent B</td>
                  <td class="text-center white-space-td">Parent A</td>
                  <td class="text-center white-space-td">Parent B</td>
               </tr>
               <tr>
                  <td colspan="2"></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21h1" name="obligee_21h1" placeholder="Enter" value="<?php echo isset($postData['obligee_21h1'])?$postData['obligee_21h1']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21h1" name="obligor_21h1" placeholder="Enter" value="<?php echo isset($postData['obligor_21h1'])?$postData['obligor_21h1']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21h2" name="obligee_21h2" placeholder="Enter" value="<?php echo isset($postData['obligee_21h2'])?$postData['obligee_21h2']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21h2" name="obligor_21h2" placeholder="Enter" value="<?php echo isset($postData['obligor_21h2'])?$postData['obligor_21h2']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligee_21h3" name="obligee_21h3" placeholder="Enter" value="<?php echo isset($postData['obligee_21h3'])?$postData['obligee_21h3']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" id="obligor_21h3" name="obligor_21h3" placeholder="Enter" value="<?php echo isset($postData['obligor_21h3'])?$postData['obligor_21h3']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligee_21h4" name="obligee_21h4" placeholder="Enter" value="<?php echo isset($postData['obligee_21h4'])?$postData['obligee_21h4']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligor_21h4" name="obligor_21h4" placeholder="Enter" value="<?php echo isset($postData['obligor_21h4'])?$postData['obligor_21h4']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligee_21h5" name="obligee_21h5" placeholder="Enter" value="<?php echo isset($postData['obligee_21h5'])?$postData['obligee_21h5']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligor_21h5" name="obligor_21h5" placeholder="Enter" value="<?php echo isset($postData['obligor_21h5'])?$postData['obligor_21h5']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligee_21h6" name="obligee_21h6" placeholder="Enter" value="<?php echo isset($postData['obligee_21h6'])?$postData['obligee_21h6']:0; ?>" min=0></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligor_21h6" name="obligor_21h6" placeholder="Enter" value="<?php echo isset($postData['obligor_21h6'])?$postData['obligor_21h6']:0; ?>" min=0></div></td>
               </tr>

                <tr>
                  <td colspan="2">i. Lowest</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligor_21e1" name="obligor_21e1" placeholder="0.00" value="<?php echo isset($postData['obligor_21e1'])?$postData['obligor_21e1']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21e2" name="obligor_21e2"  placeholder="0.00" value="<?php echo isset($postData['obligor_21e2'])?$postData['obligor_21e2']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21e3" name="obligor_21e3" value="<?php echo isset($postData['obligor_21e3'])?$postData['obligor_21e3']:''; ?>" placeholder="0.00" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21e4" name="obligor_21e4" value="<?php echo isset($postData['obligor_21e4'])?$postData['obligor_21e4']:''; ?>"  placeholder="0.00" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21e5" name="obligor_21e5" value="<?php echo isset($postData['obligor_21e5'])?$postData['obligor_21e5']:''; ?>" placeholder="0.00" readonly></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21e6" name="obligor_21e6"  placeholder="0.00" value="<?php echo isset($postData['obligor_21e6'])?$postData['obligor_21e6']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="2" class="border-bottom-0">Apportioned</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
                  <td class="text-center">Parent A</td>
                  <td class="text-center">Parent B</td>
               </tr>
               <tr>
                  <td colspan="2"></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_A1" name="21_apportioned_obligor_A1"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_A1'])?$postData['21_apportioned_obligor_A1']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_B1" name="21_apportioned_obligor_B1"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_B1'])?$postData['21_apportioned_obligor_B1']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_A2" name="21_apportioned_obligor_A2"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_A2'])?$postData['21_apportioned_obligor_A2']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_B2" name="21_apportioned_obligor_B2"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_B2'])?$postData['21_apportioned_obligor_B2']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_A3" name="21_apportioned_obligor_A3"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_A3'])?$postData['21_apportioned_obligor_A3']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_B3" name="21_apportioned_obligor_B3"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_B3'])?$postData['21_apportioned_obligor_B3']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_A4" name="21_apportioned_obligor_A4"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_A4'])?$postData['21_apportioned_obligor_A4']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"> <div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_B4" name="21_apportioned_obligor_B4"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_B4'])?$postData['21_apportioned_obligor_B4']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_A5" name="21_apportioned_obligor_A5"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_A5'])?$postData['21_apportioned_obligor_A5']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_B5" name="21_apportioned_obligor_B5"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_B5'])?$postData['21_apportioned_obligor_B5']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_A6" name="21_apportioned_obligor_A6"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_A6'])?$postData['21_apportioned_obligor_A6']:0; ?>" readonly></div></td>
                  <td class="text-center color-green"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21_apportioned_obligor_B6" name="21_apportioned_obligor_B6"  placeholder="Calculate" value="<?php echo isset($postData['21_apportioned_obligor_B6'])?$postData['21_apportioned_obligor_B6']:0; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="10">j. Enter total of Line 21e apportioned for children with Parent A</td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="text-center currency readonly-feild" type="number" id="obligee_21j" name="obligee_21j"  placeholder="0.00" value="<?php echo isset($postData['obligee_21j'])?$postData['obligee_21j']:''; ?>" readonly>
                  </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21j" name="obligor_21j" placeholder="0.00" value="<?php echo isset($postData['obligor_21j'])?$postData['obligor_21j']:''; ?>" readonly>
                  </div></td>
                  <td class="border-right-0"></td>
                  <td class="border-left-0"></td>
               </tr>
               <tr>
                  <td colspan="10">k. Enter total of Line 21i apportioned for children with Parent B</td>
                  <td class="border-right-0"></td>
                  <td class="border-left-0"></td>
                  <td class=" text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_21k" name="obligee_21k"  placeholder="0.00" value="<?php echo isset($postData['obligee_21k'])?$postData['obligee_21k']:''; ?>" readonly>
                  </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_21k" name="obligor_21k"  placeholder="0.00" value="<?php echo isset($postData['obligor_21k'])?$postData['obligor_21k']:''; ?>" readonly>
                  </div></td>
               </tr>
                 <tr>
                  <td colspan="10">Federal child care credit percentage (see IRS Pub 503)</td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns percentage_end">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" placeholder="Calc" readonly name="obligee_21ka1" value="<?php echo isset($postData['obligee_21ka1'])?$postData['obligee_21ka1']:''; ?>">
                    </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns percentage_end">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" placeholder="Calc" readonly name="obligee_21ka2" value="<?php echo isset($postData['obligee_21ka2'])?$postData['obligee_21ka2']:''; ?>">
                    </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns percentage_end">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" placeholder="Calc" readonly name="obligor_21ka1" value="<?php echo isset($postData['obligor_21ka1'])?$postData['obligor_21ka1']:''; ?>">
                    </div></td>
                  <td class=" text-center"> <div class="input_field_wrapper hide-inputbtns percentage_end">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" placeholder="Calc" readonly name="obligor_21ka2" value="<?php echo isset($postData['obligor_21ka2'])?$postData['obligor_21ka2']:''; ?>">
                    </div></td>
               </tr>
               <tr>
                  <td colspan="10">Federal child care credit (see IRS Pub 503)</td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" placeholder="0.00" readonly name="obligee_21kb1" value="<?php echo isset($postData['obligee_21kb1'])?$postData['obligee_21kb1']:''; ?>">
                    </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" placeholder="0.00" readonly name="obligee_21kb2" value="<?php echo isset($postData['obligee_21kb2'])?$postData['obligee_21kb2']:''; ?>">
                    </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" placeholder="0.00" readonly name="obligor_21kb1" value="<?php echo isset($postData['obligor_21kb1'])?$postData['obligor_21kb1']:''; ?>">
                    </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" placeholder="0.00" readonly name="obligor_21kb2" value="<?php echo isset($postData['obligor_21kb2'])?$postData['obligor_21kb2']:''; ?>">
                    </div></td>
               </tr>
              <tr>
                  <td colspan="10">Ohio child care credit percentage (see Ohio Instructions PIT-IT1040)</td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns percentage_end">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" placeholder="Calc" readonly name="obligee_21kc1" value="<?php echo isset($postData['obligee_21kc1'])?$postData['obligee_21kc1']:''; ?>">
                    </div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns percentage_end">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" placeholder="Calc" readonly name="obligee_21kc2" value="<?php echo isset($postData['obligee_21kc2'])?$postData['obligee_21kc2']:''; ?>">
                    </div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns percentage_end">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" placeholder="Calc" readonly name="obligor_21kc1" value="<?php echo isset($postData['obligor_21kc1'])?$postData['obligor_21kc1']:''; ?>">
                    </div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns percentage_end">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" placeholder="Calc" readonly name="obligor_21kc2" value="<?php echo isset($postData['obligor_21kc2'])?$postData['obligor_21kc2']:''; ?>">
                    </div></td>
               </tr>
               <tr>
                  <td colspan="10">Ohio child care credit (see Ohio Instructions PIT-IT1040)</td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" placeholder="0.00" readonly name="obligee_21kd1" value="<?php echo isset($postData['obligee_21kd1'])?$postData['obligee_21kd1']:''; ?>">
                    </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" placeholder="0.00" readonly name="obligee_21kd2" value="<?php echo isset($postData['obligee_21kd2'])?$postData['obligee_21kd2']:''; ?>">
                    </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" placeholder="0.00" readonly name="obligor_21kd1" value="<?php echo isset($postData['obligor_21kd1'])?$postData['obligor_21kd1']:''; ?>">
                    </div></td>
                  <td class=" text-center"><div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" placeholder="0.00" readonly name="obligor_21kd2" value="<?php echo isset($postData['obligor_21kd2'])?$postData['obligor_21kd2']:''; ?>">
                    </div></td>
               </tr>
                <tr>
                  <td colspan="4">l. Enter the eligible federal and state tax credits </td>
                  <td colspan="3" class="text-center">Parent A Custodial</td>
                  <td colspan="3" class="text-center">Parent B Custodial</td>

                  
                  <td rowspan="2" class="text-center">
                    <div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="21l1" name="21l1"  placeholder="Enter" value="<?php echo isset($postData['21l1'])?$postData['21l1']:0; ?>" min=0 readonly>
                    </div>
                  </td>
                  
                  <td rowspan="2" class="text-center">
                    <div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="21l2" name="21l2"  placeholder="Enter" value="<?php echo isset($postData['21l2'])?$postData['21l2']:0; ?>" min=0 readonly>
                    </div>
                  </td>
                  
                  <td rowspan="2" class="text-center">
                    <div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21l3" name="21l3" placeholder="Enter" value="<?php echo isset($postData['21l3'])?$postData['21l3']:0; ?>" min=0 readonly>
                    </div>
                  </td>
                  
                  <td rowspan="2" class="text-center">
                    <div class="input_field_wrapper hide-inputbtns">
                      <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21l4" name="21l4" placeholder="Enter" value="<?php echo isset($postData['21l4'])?$postData['21l4']:0; ?>" min=0 readonly>
                    </div>
                  </td>

               </tr>
               <tr>
                  <td colspan="4" class="pd-0">
                  <table width="100%" class="inner-table">
                    <tr>
                      <td colspan="2" style="color: rgba(255,255,255,0);font-size: 0;"> &nbsp;</td>
                    </tr>               
                    <tr>
                      <td class="text-right">Calculated</td>
                    </tr>
                    <tr>
                      <td class="text-right">Override</td>
                    </tr>
                  </table>
                  </td>
                  <td class="pd-0" colspan="3">
                      <table width="100%" class="inner-table">
                        <tbody>
                          <tr>
                            <td class="text-center" colspan="2">Parent A</td>
                            <td class="text-center" colspan="2">Parent B</td>
                          </tr>
                          <tr>
                            <td class="text-center"><div class="input_field_wrapper_checkbox">
                              <input type="radio" id="21l_obligee_ParentA_Cal" name="21l_obligee_ParentA" class="es_checkbox" value="calculation" onclick="enable3cField('21l_obligee_ParentA_Over_input', '21l_obligee_ParentA_Over')" <?php echo ((!isset($postData['21l_obligee_ParentA'])) || ($postData['21l_obligee_ParentA'] == 'calculation')) ? 'checked' : ''; ?>>
                            </div></td>
                            <td class="textleft">Calc</td>
                            <td class="text-center"><div class="input_field_wrapper_checkbox">
                              <input type="radio" id="21l_obligee_ParentB_Cal" name="21l_obligee_ParentB" class="es_checkbox" value="calculation" onclick="enable3cField('21l_obligee_ParentB_Over_input', '21l_obligee_ParentB_Over')" <?php echo ((!isset($postData['21l_obligee_ParentB'])) || ($postData['21l_obligee_ParentB'] == 'calculation')) ? 'checked' : ''; ?>>
                            </div></td>
                            <td class="textleft">Calc</td>
                          </tr>
                          <tr>
                            <td class="text-center"><div class="input_field_wrapper_checkbox">
                                <input type="radio" id="21l_obligee_ParentA_Over" name="21l_obligee_ParentA" class="es_checkbox" value="manual" onclick="enable3cField('21l_obligee_ParentA_Over_input', '21l_obligee_ParentA_Over')" <?php echo ((isset($postData['21l_obligee_ParentA'])) && ($postData['21l_obligee_ParentA'] == 'manual')) ? 'checked' : ''; ?>>
                              </div></td>
                              <td class="text-center"><div class="input_field_wrapper hide-inputbtns ">
                              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" placeholder="Actual" readonly name="21l_obligee_ParentA_Over_input" value="<?php echo isset($postData['21l_obligee_ParentA_Over_input'])?$postData['21l_obligee_ParentA_Over_input']:''; ?>" id="21l_obligee_ParentA_Over_input" style="margin-left: 0px; margin-right: 0px; width: 100%;">
                    </div></td>
                              <td class="text-center"><div class="input_field_wrapper_checkbox">
                                <input type="radio" id="21l_obligee_ParentB_Over" name="21l_obligee_ParentB" class="es_checkbox" value="manual" onclick="enable3cField('21l_obligee_ParentB_Over_input', '21l_obligee_ParentB_Over')" <?php echo ((isset($postData['21l_obligee_ParentB'])) && ($postData['21l_obligee_ParentB'] == 'manual')) ? 'checked' : ''; ?>>
                              </div></td>
                              <td class="text-center"> <div class="input_field_wrapper hide-inputbtns ">
                              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" placeholder="Actual" readonly name="21l_obligee_ParentB_Over_input" value="<?php echo isset($postData['21l_obligee_ParentB_Over_input'])?$postData['21l_obligee_ParentB_Over_input']:''; ?>" id="21l_obligee_ParentB_Over_input" style="margin-left: 0px; margin-right: 0px; width: 100%;">
                            </div></td>
                          </tr>
                        </tbody>
                      </table>
                  </td>
                  <td class="pd-0" colspan="3">
                      <table width="100%" class="inner-table">
                        <tbody>
                          <tr>
                            <td class="text-center" colspan="2">Parent A</td>
                            <td class="text-center" colspan="2">Parent B</td>
                          </tr>
                          <tr>
                            <td class="text-center"><div class="input_field_wrapper_checkbox">
                              <input type="radio" id="21l_obligor_ParentA_Cal" name="21l_obligor_ParentA" class="es_checkbox" value="calculation" onclick="enable3cField('21l_obligor_ParentB_Over_input', '21l_obligor_ParentA_Over')" <?php echo ((!isset($postData['21l_obligor_ParentA'])) || ($postData['21l_obligor_ParentA'] == 'calculation')) ? 'checked' : ''; ?>>
                            </div></td>
                            <td class="textleft">Calc</td>
                            <td class="text-center"> <div class="input_field_wrapper_checkbox">
                              <input type="radio" id="21l_obligor_ParentB_Cal" name="21l_obligor_ParentB" class="es_checkbox" value="calculation" onclick="enable3cField('21l_obligor_ParentB_Over_input', '21l_obligor_ParentB_Over')" <?php echo ((!isset($postData['21l_obligor_ParentB'])) || ($postData['21l_obligor_ParentB'] == 'calculation')) ? 'checked' : ''; ?>>
                            </div></td>
                            <td class="textleft">Calc</td>
                          </tr>
                          <tr>
                            <td class="text-center"><div class="input_field_wrapper_checkbox">
                                <input type="radio" id="21l_obligor_ParentA_Over" name="21l_obligor_ParentA" class="es_checkbox" value="manual" onclick="enable3cField('21l_obligor_ParentA_Over_input', '21l_obligor_ParentA_Over')" <?php echo ((isset($postData['21l_obligor_ParentA'])) && ($postData['21l_obligor_ParentA'] == 'manual')) ? 'checked' : ''; ?>>
                              </div></td>
                              <td class="text-center"><div class="input_field_wrapper hide-inputbtns ">
                              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" placeholder="Actual" readonly name="21l_obligor_ParentA_Over_input" value="<?php echo isset($postData['21l_obligor_ParentA_Over_input'])?$postData['21l_obligor_ParentA_Over_input']:''; ?>" style="margin-left: 0px; margin-right: 0px; width: 100%;" id="21l_obligor_ParentA_Over_input">
                            </div></td>
                              <td class="text-center"><div class="input_field_wrapper_checkbox">
                                <input type="radio" id="21l_obligor_ParentB_Over" name="21l_obligor_ParentB" class="es_checkbox" value="manual" onclick="enable3cField('21l_obligor_ParentB_Over_input', '21l_obligor_ParentB_Over')" <?php echo ((isset($postData['21l_obligor_ParentB'])) && ($postData['21l_obligor_ParentB'] == 'manual')) ? 'checked' : ''; ?>>
                              </div></td>
                              <td class="text-center"><div class="input_field_wrapper hide-inputbtns ">
                              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont" type="number" placeholder="Actual" readonly name="21l_obligor_ParentB_Over_input" value="<?php echo isset($postData['21l_obligor_ParentB_Over_input'])?$postData['21l_obligor_ParentB_Over_input']:''; ?>" style="margin-left: 0px; margin-right: 0px; width: 100%;" id="21l_obligor_ParentB_Over_input">
                            </div></td>
                          </tr>
                        </tbody>
                      </table>
                  </td>
               </tr>                
              <tr>
                  <td colspan="10">m. Line 21j minus combined amounts of Line 21l</td>
                  <td colspan="2" class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21m2" name="21m2" placeholder="0.00" value="<?php echo isset($postData['21m2'])?$postData['21m2']:''; ?>" readonly></div></td>
                  <td colspan="2" style="background: #eeeeee;"></td>
               </tr>
               <tr>
                  <td colspan="10">n. Line 21k minus combined amounts of Line 21l</td>
                  <td colspan="2" style="background: #eeeeee;"></td>
                  <td colspan="2" class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="21n4" name="21n4" placeholder="0.00" value="<?php echo isset($postData['21n4'])?$postData['21n4']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="10" class="font-s">o. Multiply Line 21m and Line 21n by Line 17 for each parent; (If Line 15 is checked for the parent,
                     use the lower percentage amount of either Line 17 or 50.00% to determine the parent’s share).<br><strong>Annual child care costs</strong> 
                  </td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="21o1" name="21o1"  placeholder="0.00" value="<?php echo isset($postData['21o1'])?$postData['21o1']:''; ?>" readonly></div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="21o2" name="21o2"  placeholder="0.00" value="<?php echo isset($postData['21o2'])?$postData['21o2']:''; ?>" readonly></div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="21o3" name="21o3" placeholder="0.00" value="<?php echo isset($postData['21o3'])?$postData['21o3']:''; ?>" readonly></div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency sfont" type="number" id="21o4" name="21o4" placeholder="0.00" value="<?php echo isset($postData['21o4'])?$postData['21o4']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="10">p. Line 21o minus Line 21a. If calculation results in a negative amount, enter "0"</td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21p1" name="21p1" placeholder="0.00" value="<?php echo isset($postData['21p1'])?$postData['21p1']:''; ?>" readonly></div></td>
                  <td class=" text-right"> <div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="21p2" name="21p2" placeholder="0.00" value="<?php echo isset($postData['21p2'])?$postData['21p2']:''; ?>" readonly></div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="text-center currency sfont readonly-feild" type="number" id="21p3" name="21p3"  placeholder="0.00" value="<?php echo isset($postData['21p3'])?$postData['21p3']:''; ?>" readonly></div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01"  class="text-center currency sfont readonly-feild" type="number" id="21p4" name="21p4"  placeholder="0.00" value="<?php echo isset($postData['21p4'])?$postData['21p4']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td>22.</td>
                  <td colspan="10">Adjusted Child Support Obligation (Line 18d minus Line 19b minus Line 20 plus Line 21p; if
                     calculation results in negative amount, enter “0”). Annual child support obligation 
                  </td>
                  <td class="text-center"></td>
                  <td class="text-center "><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_22" name="obligee_22" placeholder="0.00" value="<?php echo isset($postData['obligee_22'])?$postData['obligee_22']:''; ?>" readonly></div></td>
                  <td class="text-center "><div class="input_field_wrapper hide-inputbtns"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_22" name="obligor_22"  placeholder="0.00" value="<?php echo isset($postData['obligor_22'])?$postData['obligor_22']:''; ?>" readonly></div></td>
                  <td class="text-center"></td>
               </tr>
               <tr>
                  <td colspan="15"><strong>V. CASH MEDICAL</strong></td>
               </tr>
               <tr>
                  <td rowspan="3">23.</td>
                  <td colspan="14" class="dark-bg">Cash Medical Obligation for Children Subject to this Order</td>
               </tr>
               <tr>
                  <td colspan="10">a. Annual combined cash medical support obligation</td>
                  <td colspan="2" class=" text-right"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild" type="number" id="obligee_23a" name="obligee_23a" placeholder="0.00" value="<?php echo isset($postData['obligee_23a'])?$postData['obligee_23a']:''; ?>" readonly></div></td>
                  <td colspan="2" class=" text-right"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild" type="number" id="obligor_23a" name="obligor_23a" placeholder="0.00" value="<?php echo isset($postData['obligor_23a'])?$postData['obligor_23a']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td colspan="10">b. Multiply Line 23a by Line 17 for each parent. Annual cash medical obligation</td>
                  <td></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency sfont readonly-feild" type="number" id="obligee_23b" name="obligee_23b" placeholder="0.00" value="<?php echo isset($postData['obligee_23b'])?$postData['obligee_23b']:''; ?>" readonly></div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="textright currency sfont readonly-feild" type="number" id="obligor_23b" name="obligor_23b"  placeholder="0.00" value="<?php echo isset($postData['obligor_23b'])?$postData['obligor_23b']:''; ?>" readonly></div></td>
                  <td></td>
               </tr>
            </tbody>
         </table>         
         <p class="print-footer">© <?php echo date("Y");?> First Draft Data, LLC. All Rights Reserved. V <?php echo date("Y");?>-1 <span class="text-right">2/3</span></p>
         <div class="page-break"></div>
         <table width="100%" border="1" cellspacing="0" cellpadding="0" class="hide-header">
            <tbody>
               <tr class="hide-header-tr">
                  <td colspan="6">Parent A Name
                     <input class="text-center" type="text" name="obligee_name2" placeholder="Enter" value="<?php echo isset($postData['obligee_name'])?$postData['obligee_name']:''; ?>" >
                  </td>
                  <td colspan="5">Parent B Name
                     <input class="text-center" type="text" name="obligor_name2" placeholder="Enter" value="<?php echo isset($postData['obligor_name'])?$postData['obligor_name']:''; ?>">
                  </td>
                  <td colspan="4" class="white-space-td">Date this form is completed
                     <input class="text-center" type="text" name="created_at2" value="<?php echo date("m/d/Y"); ?>" readonly>
                  </td>
               </tr>
                <tr class="hide-header-tr">
                  <td colspan="4">County Name
                      <?php $state=isset($sheet_state)?$sheet_state:'';
                  $county_selected=isset($postData['county_name'])?$postData['county_name']:'';
            ?><select id="county_name" class="county-select" name="county_name2">
                            <option value="">Choose County</option>
                          </select>
                    
                    </td>
                  </td>
                  <td colspan="4">SETS Case Number
                     <input class="text-center" type="text" name="sets_case_number2" placeholder="Enter" value="<?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>">
                  </td>
                  <td colspan="3">Court or Administrative Order Number
                     <input class="text-center" type="text" name="court_administrative_order_number2" placeholder="Enter" value="<?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>">
                  </td>
                  <td colspan="4">Number of Children of the Order
                     <input class="text-center" type="number" min="1" max="15" step="1" id="number_children_order" name="number_children_order2" value="<?php echo isset($postData['number_children_order'])?$postData['number_children_order']:''; ?>" placeholder="Enter">
                  </td>
               </tr>
            </tbody>
         </table>
         <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table-2">
            <tbody>
               <tr>
                  <td colspan="9"><strong>VI. RECOMMENDED MONTHLY ORDERS FOR DECREE</strong></td>
                  <td colspan="2" class="text-center">PARENT A<br>OBLIGATION</td>
                  <td colspan="2" class="text-center">PARENT B<br>OBLIGATION</td>
                  <td colspan="2" class="text-center">NET SUPPORT<br>OBLIGATION</td>
               </tr>
                  <tr>
                  <td>24.</td>
                  <td colspan="8">ANNUAL CHILD SUPPORT AMOUNT (Line 22)</td>
                  <td colspan="2" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_24" name="obligee_24" placeholder="0.00" value="<?php echo isset($postData['obligee_24'])?$postData['obligee_24']:''; ?>" readonly>
            </div></td>
                  <td colspan="2" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input class="text-center currency readonly-feild" data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" id="obligor_24" name="obligor_24"  placeholder="0.00" value="<?php echo isset($postData['obligor_24'])?$postData['obligor_24']:''; ?>" readonly>
            </div></td>
                  <td colspan="2" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input class="text-center currency readonly-feild" data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" id="24nso" name="24nso" placeholder="0.00" value="<?php echo isset($postData['24nso'])?$postData['24nso']:''; ?>" readonly>
            </div></td>
               </tr>
                <tr>
                  <td>25.</td>
                  <td colspan="8">MONTHLY CHILD SUPPORT AMOUNT</td>
                  <td colspan="2" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_25" name="obligee_25" placeholder="0.00" value="<?php echo isset($postData['obligee_25'])?$postData['obligee_25']:''; ?>" readonly>
            </div></td>
                  <td colspan="2" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input class="text-center currency readonly-feild" data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" id="obligor_25" name="obligor_25"  placeholder="0.00" value="<?php echo isset($postData['obligor_25'])?$postData['obligor_25']:''; ?>" readonly>
            </div></td>
                  <td colspan="2"></td>
               </tr>
                 <tr>
                  <td rowspan="16">26.</td>
                  <td class="dark-bg" colspan="14">Line 26 is ONLY completed if the court orders any deviation(s) to child support. (See sections 3119.23, 3119.231 and 3119.24 of the
                     Revised Code)
                  </td>
               </tr>
               <tr>
                  <td colspan="12">a. For 3119.23 factors (Enter the monthly amount)</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center"><strong>A</strong></td>
                  <td class="text-center"><strong>B</strong></td>
                  <td colspan="4"></td>
                  <td class="text-center"><strong>A</strong></td>
                  <td class="text-center"><strong>B</strong></td>
                  <td colspan="4"></td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="obligee_26a_SpecialUnusual" name="obligee_26a_SpecialUnusual" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_SpecialUnusual'])) && ($postData['obligee_26a_SpecialUnusual'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="obligor_26a_SpecialUnusual" name="obligor_26a_SpecialUnusual" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_SpecialUnusual'])) && ($postData['obligor_26a_SpecialUnusual'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Special/Unusual child needs</td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_Significant" name="obligee_26a_Significant" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_Significant'])) && ($postData['obligee_26a_Significant'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_Significant" name="obligor_26a_Significant" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_Significant'])) && ($postData['obligor_26a_Significant'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Significant in-kind parental contributions</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_OtherCourt" name="obligee_26a_OtherCourt" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_OtherCourt'])) && ($postData['obligee_26a_OtherCourt'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_OtherCourt" name="obligor_26a_OtherCourt" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_OtherCourt'])) && ($postData['obligor_26a_OtherCourt'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Other court-ordered payments</td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_Extraordinary" name="obligee_26a_Extraordinaryt" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_Extraordinaryt'])) && ($postData['obligee_26a_Extraordinaryt'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_Extraordinary" name="obligor_26a_Extraordinaryt" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_Extraordinaryt'])) && ($postData['obligor_26a_Extraordinaryt'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Extraordinary parental work-related expenses</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_Extended" name="obligee_26a_Extended" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_Extended'])) && ($postData['obligee_26a_Extended'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_Extended" name="obligor_26a_Extended" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_Extended'])) && ($postData['obligor_26a_Extended'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Extended parenting time/Extraordinary costs</td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ChildStandard" name="obligee_26a_ChildStandardt_living" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ChildStandardt_living'])) && ($postData['obligee_26a_ChildStandardt_living'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ChildStandard" name="obligor_26a_ChildStandardt_living" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ChildStandardt_living'])) && ($postData['obligor_26a_ChildStandardt_living'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Child’s standard of living if parents were married</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="obligee_26a_ChildFinancial" name="obligee_26a_ChildFinancial" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ChildFinancial'])) && ($postData['obligee_26a_ChildFinancial'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="obligor_26a_ChildFinancial" name="obligor_26a_ChildFinancial" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ChildFinancial'])) && ($postData['obligor_26a_ChildFinancial'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Child financial resources</td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ChildEdOps" name="obligee_26a_ChildEdOps" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ChildEdOps'])) && ($postData['obligee_26a_ChildEdOps'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ChildEdOps" name="obligor_26a_ChildEdOps" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ChildEdOps'])) && ($postData['obligor_26a_ChildEdOps'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Child’s educational opportunities</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="obligee_26a_RelativeParental" name="obligee_26a_RelativeParental" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_RelativeParental'])) && ($postData['obligee_26a_RelativeParental'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="obligor_26a_RelativeParental" name="obligor_26a_RelativeParental" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_RelativeParental'])) && ($postData['obligor_26a_RelativeParental'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Relative parental financial resources</td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ParentalSupport" name="obligee_26a_ParentalSupport" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ParentalSupport'])) && ($postData['obligee_26a_ParentalSupport'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ParentalSupport" name="obligor_26a_ParentalSupport" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ParentalSupport'])) && ($postData['obligor_26a_ParentalSupport'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Parental support for other special needs children</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ObligeesIncome" name="obligee_26a_ObligeesIncome" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ObligeesIncome'])) && ($postData['obligee_26a_ObligeesIncome'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ObligeesIncome" name="obligor_26a_ObligeesIncome" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ObligeesIncome'])) && ($postData['obligor_26a_ObligeesIncome'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Obligee’s income below federal poverty</td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ChildPost_secondary" name="obligee_26a_ChildPost_secondary" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ChildPost_secondary'])) && ($postData['obligee_26a_ChildPost_secondary'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ChildPost_secondary" name="obligor_26a_ChildPost_secondary" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ChildPost_secondary'])) && ($postData['obligor_26a_ChildPost_secondary'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Child post-secondary educational expenses</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ParentalRemarriage" name="obligee_26a_ParentalRemarriage" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ParentalRemarriage'])) && ($postData['obligee_26a_ParentalRemarriage'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ParentalRemarriage" name="obligor_26a_ParentalRemarriage" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ParentalRemarriage'])) && ($postData['obligor_26a_ParentalRemarriage'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Parental remarriage/shared living expenses</td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ParentalReunCost" name="obligee_26a_ParentalReunCost" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ParentalReunCost'])) && ($postData['obligee_26a_ParentalReunCost'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ParentalReunCost" name="obligor_26a_ParentalReunCost" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ParentalReunCost'])) && ($postData['obligor_26a_ParentalReunCost'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Parental cost for court-ordered reunification efforts</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ParentalFederal" name="obligee_26a_ParentalFederal" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ParentalFederal'])) && ($postData['obligee_26a_ParentalFederal'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ParentalFederal" name="obligor_26a_ParentalFederal" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ParentalFederal'])) && ($postData['obligor_26a_ParentalFederal'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Parental federal, state, local taxes paid</td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligee_26a_ExtraordinaryChild" name="obligee_26a_ExtraordinaryChild" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_ExtraordinaryChild'])) && ($postData['obligee_26a_ExtraordinaryChild'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                        <input type="checkbox" id="obligor_26a_ExtraordinaryChild" name="obligor_26a_ExtraordinaryChild" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_ExtraordinaryChild'])) && ($postData['obligor_26a_ExtraordinaryChild'] == '1')) ? 'checked' : ''; ?>></div></td>
                  <td colspan="4">Extraordinary child care cost</td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="obligee_26a_relvant" name="obligee_26a_relvant" class="es_checkbox" value="1" <?php echo ((isset($postData['obligee_26a_relvant'])) && ($postData['obligee_26a_relvant'] == '1')) ? 'checked' : ''; ?> onclick="enable3cFieldRelevant('26a_OtherRelevantText', 'obligee_26a_relvant')"></div></td>
                  <td class="text-center" style="width: 60px;"><div class="input_field_wrapper_checkbox">
                    <input type="checkbox" id="obligor_26a_relvant" name="obligor_26a_relvant" class="es_checkbox" value="1" <?php echo ((isset($postData['obligor_26a_relvant'])) && ($postData['obligor_26a_relvant'] == '1')) ? 'checked' : ''; ?> onclick="enable3cFieldRelevant('26a_OtherRelevantText', 'obligor_26a_relvant')"></div></td>
                  <td colspan="10">Other relevant factors: (text only if checked) <input data-number-stepfactor="100" step="1" class="textright currency" type="text" id="26a_OtherRelevantText" name="26a_OtherRelevantText" placeholder="Enter" value="<?php echo isset($postData['26a_OtherRelevantText'])?$postData['26a_OtherRelevantText']:''; ?>" <?php if(isset($postData['obligee_26a_relvant']) && $postData['obligee_26a_relvant'] == '1'){  echo "";}elseif(isset($postData['obligor_26a_relvant']) && $postData['obligor_26a_relvant'] == '1'){echo "";} else {echo "readonly";}?> style="width: 100%; max-width: 440px; text-align: left !important;"></td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td colspan="6"></td>
                  <td colspan="2" class="text-center">PARENT A</td>
                  <td colspan="2" class="text-center">PARENT B</td>
                  <td colspan="2"></td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td colspan="6" class="text-right">Set Monthly Child Support Deviation:</td>
                  <td style="width: 40px;text-align: center;"><input type="radio" name="26a_obligee_child_sport" class="es_checkbox" value="deviation" onclick="radio26ActionSplit('deviation', 'obligee')" <?php echo ((!isset($postData['26a_obligee_child_sport'])) || ($postData['26a_obligee_child_sport'] == 'deviation')) ? 'checked' : ''; ?>></td>
                  <td class="color-green text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="26a_obligee_child_sport_deviation_text" class="text-center currency" placeholder="0.00" readonly value="<?php echo isset($postData['26a_obligee_child_sport_deviation_text'])?$postData['26a_obligee_child_sport_deviation_text']:''; ?>" id="26a_obligee_child_sport_deviation_text" style="margin-left: 0px; margin-right: 0px; width: 100px; -webkit-appearance: none; display: none;">
                        </div></td>
                  <td style="width: 40px;text-align: center;"><input type="radio" name="26a_obligor_child_sport" class="es_checkbox" value="deviation" onclick="radio26ActionSplit('deviation', 'obligor')" <?php echo ((!isset($postData['26a_obligor_child_sport'])) || ($postData['26a_obligor_child_sport'] == 'deviation')) ? 'checked' : ''; ?>></td>
                  <td class="color-green text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="26a_obligor_child_sport_deviation_text" class="text-center currency" value="<?php echo isset($postData['26a_obligor_child_sport_deviation_text'])?$postData['26a_obligor_child_sport_deviation_text']:''; ?>" placeholder="0.00" readonly value="" id="26a_obligor_child_sport_deviation_text" style="margin-left: 0px; margin-right: 0px; width: 100px; -webkit-appearance: none; display: none;">
                        </div></td>
                  <td></td>
                  <td></td>
                  <td colspan="2"></td>
               </tr>
               <tr>
                  <td colspan="6" class="text-right">Set Monthly Child Support:</td>
                  <td style="width: 40px;text-align: center;"><input type="radio" name="26a_obligee_child_sport" class="es_checkbox" value="nonDeviation" onclick="radio26ActionSplit('nonDeviation', 'obligee')" <?php echo ((isset($postData['26a_obligee_child_sport'])) && ($postData['26a_obligee_child_sport'] == 'nonDeviation')) ? 'checked' : ''; ?>></td>
                  <td class="color-green text-right"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="26a_obligee_child_sport_non_deviation_text" class="text-center currency" value="" placeholder="0.00" readonly value="<?php echo isset($postData['26a_obligee_child_sport_non_deviation_text'])?$postData['26a_obligee_child_sport_non_deviation_text']:''; ?>" id="26a_obligee_child_sport_non_deviation_text" style="margin-left: 0px; margin-right: 0px; width: 100px; -webkit-appearance: none; display: none;"></div></td>
                  <td style="width: 40px;text-align: center;"><input type="radio" name="26a_obligor_child_sport" class="es_checkbox" value="nonDeviation" onclick="radio26ActionSplit('nonDeviation', 'obligor')" <?php echo ((isset($postData['26a_obligor_child_sport'])) && ($postData['26a_obligor_child_sport'] == 'nonDeviation')) ? 'checked' : ''; ?>></td>
                  <td class="color-green text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="26a_obligor_child_sport_non_deviation_text" class="text-center currency" value="<?php echo isset($postData['26a_obligor_child_sport_non_deviation_text'])?$postData['26a_obligor_child_sport_non_deviation_text']:''; ?>" placeholder="0.00" readonly value="" id="26a_obligor_child_sport_non_deviation_text" style="margin-left: 0px; margin-right: 0px; width: 100px; -webkit-appearance: none; display: none;">
                        </div></td>
                          <td class="text-right">
                            <div class="input_field_wrapper hide-inputbtns text-center">

                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="obligee_26a" class="text-center currency readonly-feild" value="<?php echo isset($postData['obligee_26a'])?$postData['obligee_26a']:0; ?>" placeholder="Calculate" id="obligee_26a" style="width:100px; -webkit-appearance: none; display: none;" data-number-stepfactor="100" step="1" readonly>

                        </div></td>
                  <td class=" text-right"> <div class="input_field_wrapper hide-inputbtns text-center">
                          <!-- <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="obligee_26a" class="text-center currency" value="<?php //echo isset($postData['obligee_26a'])?$postData['obligee_26a']:0; ?>" placeholder="Calculate" id="obligee_26a" style="width:100px; -webkit-appearance: none; display: none;" data-number-stepfactor="100" step="1" readonly> -->

                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" name="obligor_26a" class="text-center currency readonly-feild" value="<?php echo isset($postData['obligor_26a'])?$postData['obligor_26a']:0; ?>" placeholder="Calculate" value="" id="obligor_26a" style="width:100px; -webkit-appearance: none; display: none;" data-number-stepfactor="100" step="1" readonly>

                        </div></td>
                  <td colspan="2" class="color-green text-right"></td>
               </tr>
               <tr>
                  <td colspan="10">b. For 3119.231 extended parenting time (Enter the monthly amount)</td>
                  <td class="text-right color-green"><div class="input_field_wrapper hide-inputbtns text-center">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligee_26b" name="obligee_26b" placeholder="Enter" value="<?php echo isset($postData['obligee_26b'])?$postData['obligee_26b']:''; ?>">
                        </div></td>
                  <td><div class="input_field_wrapper hide-inputbtns text-center">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" type="number" id="obligor_26b" name="obligor_26b" placeholder="Enter" value="<?php echo isset($postData['obligor_26b'])?$postData['obligor_26b']:''; ?>">
                        </div></td>
                  <td class="text-right color-green" colspan="2"></td>
               </tr>
               <tr>
                  <td colspan="10">c. Total of amounts from Lines 26a and 26b</td>
                  <td class="text-right " ><div class="input_field_wrapper hide-inputbtns text-center">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_26c" name="obligee_26c" placeholder="Calculate" value="<?php echo isset($postData['obligee_26c'])?$postData['obligee_26c']:''; ?>" readonly>
                        </div></td>

                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                          <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_26c" name="obligor_26c"  placeholder="Calculate" value="<?php echo isset($postData['obligor_26c'])?$postData['obligor_26c']:''; ?>" readonly>
                        </div></td>
                  <td class="text-right color-green" colspan="2"></td>
               </tr>
                 <tr>
                  <td>27.</td>
                  <td colspan="10">DEVIATED MONTHLY CHILD SUPPORT AMOUNT (Line 25 plus or minus Line 26c)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_27" name="obligee_27" placeholder="0.00"  value="<?php echo isset($postData['obligee_27'])?$postData['obligee_27']:''; ?>" readonly>
            </div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligor_27" name="obligor_27"  placeholder="0.00"  value="<?php echo isset($postData['obligor_27'])?$postData['obligor_27']:''; ?>" readonly>
            </div></td>
                  <td class="text-right color-green" colspan="2"></td>
               </tr>
               <tr>
                  <td>28.</td>
                  <td colspan="10">ANNUAL CASH MEDICAL AMOUNT (Line 23b)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligee_28" name="obligee_28" placeholder="0.00"  value="<?php echo isset($postData['obligee_28'])?$postData['obligee_28']:''; ?>" readonly>
            </div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_28" name="obligor_28"  placeholder="0.00"  value="<?php echo isset($postData['obligor_28'])?$postData['obligor_28']:''; ?>" readonly>
            </div></td>
                  <td class="text-right " colspan="2"><div class="input_field_wrapper hide-inputbtns text-center">
              <input class="text-center currency readonly-feild" data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" type="number" id="28nso" name="28nso" placeholder="0.00" value="<?php echo isset($postData['28nso'])?$postData['28nso']:''; ?>" readonly>
            </div></td>
               </tr>
               <tr>
                  <td>29.</td>
                  <td colspan="10"> MONTHLY CASH MEDICAL AMOUNT (Net Support Obligation amount from Line 28, divided by 12)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_29" name="obligee_29" placeholder="0.00"  value="<?php echo isset($postData['obligee_29'])?$postData['obligee_29']:''; ?>" readonly>
            </div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligor_29" name="obligor_29"  placeholder="0.00"  value="<?php echo isset($postData['obligor_29'])?$postData['obligor_29']:''; ?>" readonly>
            </div></td>
                  <td class="text-right " colspan="2"></td>
               </tr>
                <tr>
                  <td rowspan="2">30.</td>
                  <td colspan="14" class="dark-bg"> Line 30 is ONLY completed if the court orders a deviation to cash medical. (See section 3119.303 of the Revised Code)</td>
               </tr>
               <tr>
                  <td colspan="10">Cash Medical Deviation amount (Enter the monthly amount)</td>
                  <td class="text-right color-green"><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency" pattern="[0-9]" type="number" id="obligee_30" name="obligee_30" placeholder="Enter" value="<?php echo isset($postData['obligee_30'])?$postData['obligee_30']:0; ?>">
            </div></td>
                  <td class="text-right color-green"><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" pattern="[0-9]" class="text-center currency" pattern="[0-9]" type="number" id="obligor_30" name="obligor_30"  placeholder="Enter"  value="<?php echo isset($postData['obligor_30'])?$postData['obligor_30']:0; ?>">
            </div></td>
                  <td class="text-right color-green" colspan="2"></td>
               </tr>
                 <tr>
                  <td>31.</td>
                  <td colspan="10">DEVIATED MONTHLY CASH MEDICAL AMOUNT (Line 29 plus or minus Line 30)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_31" name="obligee_31" placeholder="0.00"  value="<?php echo isset($postData['obligee_31'])?$postData['obligee_31']:''; ?>" readonly>
            </div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligor_31" name="obligor_31"  placeholder="0.00"  value="<?php echo isset($postData['obligor_31'])?$postData['obligor_31']:''; ?>" readonly>
            </div></td>
                  <td class="text-right" colspan="2"></td>
               </tr>
               <tr>
                  <td colspan="15" class="dark-bg">Lines 32 and 33 is <strong>ONLY</strong> completed if you have one parent with a child support obligation (Line 25 or Line 27) and the other parent with a cash
                     medical obligation (Line 29 or Line 31).
                  </td>
               </tr>
              <tr>
                  <td>32.</td>
                  <td colspan="10">Enter amounts from Line 25 or Line 27 and Line 29 or Line 31</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_32" name="obligee_32" <?php

                if(count($_POST)>0)
                    echo 'placeholder=""';
                else
                    echo 'placeholder="0.00"';
                ?>
                     value="<?php echo isset($postData['obligee_32'])?$postData['obligee_32']:''; ?>" readonly></div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="obligor_32" name="obligor_32"  <?php

                if(count($_POST)>0)
                    echo 'placeholder=""';
                else
                    echo 'placeholder="0.00"';
                ?>   value="<?php echo isset($postData['obligor_32'])?$postData['obligor_32']:''; ?>" readonly></div></td>
                  <td class="text-right " colspan="2"><div class="input_field_wrapper hide-inputbtns text-center"><input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center currency readonly-feild" type="number" id="nso_32" name="nso_32"  <?php

                if(count($_POST)>0)
                    echo 'placeholder=""';
                else
                    echo 'placeholder="0.00"';
                ?>   value="<?php echo isset($postData['nso_32'])?$postData['nso_32']:''; ?>" readonly></div></td>
               </tr>
               <tr>
                  <td>33.</td>
                  <td colspan="10">MONTHLY SUPPORT AMOUNT (Net Support Obligation amount from Line 32)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_33" name="obligee_33" <?php

                if(count($_POST)>0)
                    echo 'placeholder=""';
                else
                    echo 'placeholder="0.00"';
                ?> value="<?php echo isset($postData['obligee_33'])?$postData['obligee_33']:''; ?>" readonly>
              </div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligor_33" name="obligor_33"  <?php

               if(count($_POST)>0)
                    echo 'placeholder=""';
                else
                    echo 'placeholder="0.00"';
                ?>  value="<?php echo isset($postData['obligor_33'])?$postData['obligor_33']:''; ?>" readonly>
              </div></td>
                  <td class="text-right" colspan="2"></td>
               </tr>
               <tr>
                  <td>34.</td>
                  <td colspan="10">Enter ONLY the total monthly obligation for the parent ordered to pay support
                     (Line 25 or Line 27, plus Line 29 or Line 31, or Line 33)
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_34" name="obligee_34"  placeholder="Calculate" value="<?php echo ((isset($postData['obligee_34'])) && ($postData['obligee_34'] != '')) ? $postData['obligee_34']:0; ?>" readonly>
              </div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligor_34" name="obligor_34"  placeholder="Calculate" value="<?php echo ((isset($postData['obligor_34'])) && ($postData['obligor_34'] != '')) ? $postData['obligor_34']:0; ?>" readonly>
              </div></td>
                  <td class="text-right" colspan="2"></td>
               </tr>
               <tr>
                  <td>35.</td>
                  <td colspan="10">Processing Charge Amount</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_35" name="obligee_35"  placeholder="Calculate" value="<?php echo ((isset($postData['obligee_35'])) && ($postData['obligee_35'] != '')) ? $postData['obligee_35']:0; ?>" readonly>
            </div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligor_35" name="obligor_35"  placeholder="Calculate" value="<?php echo ((isset($postData['obligor_35'])) && ($postData['obligor_35'] != '')) ? $postData['obligor_35']:0; ?>" readonly>
            </div></td>
                  <td class="text-right" colspan="2"></td>
               </tr>
               <tr>
                  <td>36.</td>
                  <td colspan="10">Total Monthly Obligation for Order (Child Support, Cash Medical, and Processing
                     Charge)
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligee_36" name="obligee_36"  placeholder="Calculate" value="<?php echo ((isset($postData['obligee_36'])) && ($postData['obligee_36'] != '')) ? $postData['obligee_36']:0; ?>" readonly>
            </div></td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
              <input data-number-to-fixed="2" data-number-stepfactor="100" step="0.01" class="text-center readonly-feild currency" type="number" id="obligor_36" name="obligor_36"  placeholder="Calculate" value="<?php echo ((isset($postData['obligor_36'])) && ($postData['obligor_36'] != '')) ? $postData['obligor_36']:0; ?>" readonly>
            </div></td>
                  <td class="text-right" colspan="2"></td>
               </tr>


                <tr class="print-none">

                  <td colspan="11">© First Draft Data, LLC. All Right Reserved. V<?php echo date("Y");?>-1</td>

                  <td colspan="4" style="text-align: right;">
                    <input type="hidden" name="process" value="1">
                    <input type="button" name="reset" value="Reset" class="btn btn-info" onclick="resetForm();">
                    <input type="submit" name="submit" value="Calculate" class="btn btn-success">
                    <a name="bottomsheet"></a>
                    <br/><br/>
                    <input type="submit" name="submit_email" value="Print" class="btn btn-success">
                    <input type="submit" name="save_form" value="Save" class="btn btn-success">
                    <input type="submit" name="download_form" value="Download" class="btn btn-success" id="download_form">
                  </td>
                  
               </tr>


            </tbody>

         </table>

        <table class="preparedby table_outer" width="100%" style="margin-top:40px">
      <tr>
        <td colspan="3">


          <h3>Prepared by {{ $attorney_data->document_sign_name }}</br>

            Counsel for

            <select name="counsel_dropdown">
              <option value="Parent B" <?php echo ((isset($postData['counsel_dropdown'])) && ($postData['counsel_dropdown'] == 'Parent B')) ? 'selected' : '' ?>>Parent B</option>
              <option value="Parent A" <?php echo ((isset($postData['counsel_dropdown'])) && ($postData['counsel_dropdown'] == 'Parent A')) ? 'selected' : '' ?>>Parent A</option>
            </select>

          </h3>

        </td>
      </tr>
      <tr>
        <td colspan="3" style="font-size: 16px;">
          Worksheet has been reviewed and agreed to:
        </td>
      </tr>
      <tr>
        <td colspan="3" height="50">
        </td>
      </tr>
      <tr>
        <td style="border-bottom: #333333 solid thin;"></td>
        <td width="240"></td>
        <td style="border-bottom: #333333 solid thin;"></td>
      </tr>
      <tr>
        <td><?php if(isset($postData['obligee_name'])){ echo $postData['obligee_name'].', '; } else if(isset($case_data['client_name'])){ echo $case_data['client_name'].', '; } ?>Parent A <span style="float:right">Date</span></td>
        <td width="240"></td>
        <td><?php if(isset($postData['obligor_name'])){ echo $postData['obligor_name'].', '; } else if(isset($case_data['opponent_name'])){ echo $case_data['opponent_name'].', '; } ?>Parent B <span style="float:right">Date</span></td>
      </tr>
      <tr>
        <td colspan="3" height="50">
        </td>
      </tr>
      <tfoot style="border-left: #FFF solid thin;">
        <tr>
          <td colspan="3">© <?php echo date("Y");?> First Draft Data, LLC. All Rights Reserved. V <?php echo date("Y");?>-1</td>
          <td align="right">Page 3 of 3</td>
        </tr>
      </tfoot>
    </table>
        </form>

   <loom-container id="lo-engage-ext-container">
      <loom-shadow classname="resolved"></loom-shadow>
   </loom-container>

  <!-- Modal -->
  <div class="modal fade computed-split-sheet-modal" id="myModal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Change Children Will Reside With Info</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-center">
          <form id="modal-form" class="modal-form" method="POST" action="{{route('ajax_update_children_will_reside_with_dr_children')}}" autocomplete="off">
            @csrf
            <input type="hidden" name="case_id" value="<?php if(isset($case_data['case_id'])){ echo $case_data['case_id']; } ?>" required="" style="display: none;">
            <input type="hidden" name="form_state" value="{{ $sheet_state }}" required="" style="display: none;">
            <input type="hidden" id="computed_from_database" class="" name="computation_sheet_version" value="Computed from Database" style="display: none;">

            <?php 
              $children_length=array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eigth');
              if(isset($postData['client_full_name'])){ 
                $client_full_name= $postData['client_full_name']; 
              } 
              else if(isset($case_data['client_full_name'])){ 
                $client_full_name= $case_data['client_full_name']; 
              } else {
                if(isset($postData['obligee_name'])){ 
                  $client_full_name= $postData['obligee_name']; 
                } else if(isset($case_data['client_name'])){ 
                  $client_full_name= $case_data['client_name']; 
                }
              }
              if(isset($postData['opponent_full_name'])){ 
                $opponent_full_name= $postData['opponent_full_name']; 
              } 
              else if(isset($case_data['opponent_full_name'])){ 
                $opponent_full_name= $case_data['opponent_full_name']; 
              } else {
                if(isset($postData['obligee_name'])){ 
                  $opponent_full_name= $postData['obligee_name']; 
                } else if(isset($case_data['opponent_name'])){ 
                  $opponent_full_name= $case_data['opponent_name']; 
                }
              }
            ?>
            @for($i=0; $i < $postData['number_children_order']; $i++)
              <?php $b=$i+1; ?>
              <div class="row text-left justify-content-center">
                <div class="col-sm-3">
                  <label><strong><?php echo isset($children_name['Child_'.$b.'']['name'])?$children_name['Child_'.$b.'']['name']:'Child '.$b.''; ?></strong> Will Reside With
                  </label>
                </div>
                <div class="col-sm-5">
                  <label><input type="radio" name="This_Marriage_{{$children_length[$i]}}_Child_WILL_Resides_With" value="{{$client_full_name}}" <?php if(isset($children_name['Child_'.$b.'']['parent_name']) && $children_name['Child_'.$b.'']['parent_name'] == $client_full_name){ echo "checked";} ?>> {{$client_full_name}}</label>
                  <label><input type="radio" name="This_Marriage_{{$children_length[$i]}}_Child_WILL_Resides_With" value="{{$opponent_full_name}}" <?php if(isset($children_name['Child_'.$b.'']['parent_name']) && $children_name['Child_'.$b.'']['parent_name'] == $opponent_full_name){ echo "checked";} ?>> {{$opponent_full_name}}</label>
                </div>
              </div>
            @endfor
            <input type="submit" id="modal_submit_btn" class="btn btn-success mt-2" value="Submit">       
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal End-->

@if(isset($bottom_scroll))
<script type="text/javascript">
  $("html, body").animate({ scrollTop: document.body.scrollHeight }, "slow");
</script>
@endif
<script type="text/javascript">

function resetForm(){
  $(':input','#entryform')
  .not(':button, :submit, :reset, :hidden')
  .val('')
  .prop('checked', false)
  .prop('selected', false);
}

function resetFormToBlank(){
  $(':input','#entryform')
  .not(':button, :submit, :reset, :hidden, input[name="obligee_name"], input[name="obligor_name"], input[name="obligee_full_name"], input[name="obligor_full_name"], input[name="created_at"], select[name="county_name"], input[name="sets_case_number"], input[name="court_administrative_order_number"], input[name="number_children_order"]')
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


  function validateSplitForm()
  {
    var number_children_order=parseInt($('#number_children_order').val());
    var sum=parseInt($('#obligee_9b').val())+parseInt($('#obligor_9b').val());

    if(number_children_order!=sum)
    {
      alert("Sum of number of children subject to this order must be equal to "+number_children_order);
      $('#obligee_9b').focus();
      return false;
    }

    var sum=parseInt($('#parent_a_children').val())+parseInt($('#parent_b_children').val());
    if(number_children_order!=sum)
    {
      alert("(Number of children with Parent A + Number of children with Parent B) must be equal to "+number_children_order);
      $('#parent_a_children').focus();
      return false;
    }

    if ($("#26a_relvant").is(":checked"))
    {
      if ($("#26a_OtherRelevantText").val() == '')
      {
        alert('Enter Relevant Text is required.');
        $('#26a_OtherRelevantText').focus();
        return false;
      }
    }

    return true;
  }

  /**
   * Restrict CTRL + P Command 
   */
  $(document).on('keydown', function(e) {
      if(e.ctrlKey && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80) )
      {
          alert("Please use the Print button below for a better rendering on the document");
          e.cancelBubble = true;
          e.preventDefault();
          e.stopImmediatePropagation();
      }  
  });

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
                        $('.county-select').append('<option value='+key+'>'+val+'</option>');
                    });
                    var sel_firm_county=$('#selected_county').text();
                    if(sel_firm_county){
                        $('.county-select option[value='+sel_firm_county+']').attr('selected','selected');
                    }
                }
            }
        });
    }

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

    var onLoadObligee25radio = "<?php echo $postData['26a_child_sport_radio'] ?? 'deviation'; ?>";
    radio25Action(onLoadObligee25radio);

    /**
     * Split Form Js Function
     */

    var sheetCustody = "<?php echo $sheet_custody; ?>";

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
    //var minWage = "<?php //echo isset($postData->OH_Minimum_Wage)?$postData->OH_Minimum_Wage:''?>";
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

  function enable3cFieldRelevant(id, checkboxId)
  {
    if ($("#"+checkboxId).is(":checked"))
    {
      $("#"+id).attr("readonly", false);

    } else {
      if($('#obligee_26a_relvant').prop("checked") == true || $('#obligor_26a_relvant').prop("checked") == true){
          $("#"+id).attr("readonly", false);
      } else {
          $("#"+id).attr("readonly", true);
          $("#"+id).val('');
        }
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
      $("#" + type + "_3_c_override_input").val('');

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
      $("#26a_child_sport_non_deviation_text").attr("readonly", false);

      $("#26a_child_sport_deviation_text").attr("readonly", true);
      $("#26a_child_sport_deviation_text").val('');

    } else {

      $("#26a_child_sport_deviation_text").attr("readonly", false);

      $("#26a_child_sport_non_deviation_text").attr("readonly", true);
      $("#26a_child_sport_non_deviation_text").val('');
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
  // function switchObligorObligee(){
  //   var obligee_name=$('input[name="obligee_name"]').val();
  //   var obligee_full_name=$('input[name="obligee_full_name"]').val();

  //   var obligee_1_input_ytd=$('input[name="obligee_1_input_ytd"]').val();
  //   var obligee_1_datepick=$('input[name="obligee_1_datepick"]').val();
  //   var obligee_1_input_year=$('input[name="obligee_1_input_year"]').val();
  //   var obligee_1_dropdown=$('select[name="obligee_1_dropdown"]').val();
  //   var obligee_1_radio=$('input[name="obligee_1_radio"]:checked').val();

  //   var obligee_1=$('input[name="obligee_1"]').val();
  //   var obligee_2a=$('input[name="obligee_2a"]').val();
  //   var obligee_2b=$('input[name="obligee_2b"]').val();
  //   var obligee_2c=$('input[name="obligee_2c"]').val();
  //   var obligee_2d=$('input[name="obligee_2d"]').val();
  //   var obligee_3_c_top_override_input=$('input[name="obligee_3_c_top_override_input"]').val();



  //   var obligor_name=$('input[name="obligor_name"]').val();
  //   var obligor_full_name=$('input[name="obligor_full_name"]').val();

  //   var obligor_1_input_ytd=$('input[name="obligor_1_input_ytd"]').val();
  //   var obligor_1_datepick=$('input[name="obligor_1_datepick"]').val();
  //   var obligor_1_input_year=$('input[name="obligor_1_input_year"]').val();
  //   var obligor_1_dropdown=$('select[name="obligor_1_dropdown"]').val();
  //   var obligor_1_radio=$('input[name="obligor_1_radio"]:checked').val();

  //   var obligor_1=$('input[name="obligor_1"]').val();
  //   var obligor_2a=$('input[name="obligor_2a"]').val();
  //   var obligor_2b=$('input[name="obligor_2b"]').val();
  //   var obligor_2c=$('input[name="obligor_2c"]').val();
  //   var obligor_2d=$('input[name="obligor_2d"]').val();
  //   var obligor_3_c_top_override_input=$('input[name="obligor_3_c_top_override_input"]').val();

  //   $('input[name="obligor_1_radio"]').prop("checked", false);
  //   $('input[name="obligor_1_input_year"]').val('');
  //   $('select[name="obligor_1_dropdown"]').val('0');
  //   $('input[name="obligor_1_input_ytd"]').val('');
  //   $('input[name="obligor_1_datepick"]').val('');
  //   $('input[name="obligor_1_input_year"], input[name="obligor_1_input_ytd"]').prop("readonly", true);


  //   $('input[name="obligee_1_radio"]').prop("checked", false);
  //   $('input[name="obligee_1_input_year"]').val('');
  //   $('select[name="obligee_1_dropdown"]').val('0');
  //   $('input[name="obligee_1_input_ytd"]').val('');
  //   $('input[name="obligee_1_datepick"]').val('');
  //   $('input[name="obligee_1_input_year"], input[name="obligee_1_input_ytd"]').prop("readonly", true);

  //   // data swapping of obligee to obligor
  //   if(typeof obligee_name !== "undefined")
  //   {
  //     $('input[name="obligor_name"]').val(obligee_name);
  //   }
  //   if(typeof obligee_full_name !== "undefined")
  //   {
  //     $('input[name="obligor_full_name"]').val(obligee_full_name);
  //   }

  //   if(typeof obligee_1_radio !== "undefined")
  //   {
  //       // $('input[name="obligor_1_radio"]').prop("checked", true);
  //       $('input[name="obligor_1_radio"][value="'+obligee_1_radio+'"]').prop('checked', 'checked');

  //       if(typeof obligee_1_input_year !== "undefined" && obligee_1_radio=='year')
  //       {
  //         $('input[name="obligor_1_input_year"]').val(obligee_1_input_year);
  //         $('input[name="obligor_1_input_year"]').prop("readonly", false);
  //       }
  //       if(typeof obligee_1_dropdown !== "undefined" && obligee_1_radio=='year')
  //       {
  //         $('select[name="obligor_1_dropdown"]').val(obligee_1_dropdown);
  //         // $('select[name="obligor_1_dropdown"] option[value="'+obligee_data_array[index].obligee_1_dropdown+'"]').attr("selected", "selected");
  //       }

  //       if(typeof obligee_1_input_ytd !== "undefined" && obligee_1_radio=='ytd')
  //       {
  //         $('input[name="obligor_1_input_ytd"]').val(obligee_1_input_ytd);
  //         $('input[name="obligor_1_input_ytd"]').prop("readonly", false);
  //       }
  //       if(typeof obligee_1_datepick !== "undefined" && obligee_1_radio=='ytd' && obligee_1_datepick !="")
  //       {
  //         // $('input[name="obligor_1_datepick"]').val(obligee_1_datepick);
  //         $('input[name="obligor_1_datepick').datepicker("setDate", new Date(obligee_1_datepick) );
  //       }

  //   }

  //   if(typeof obligee_1 !== "undefined")
  //   {
  //     $('input[name="obligor_1"]').val(obligee_1);
  //   }
  //   if(typeof obligee_2a !== "undefined")
  //   {
  //     $('input[name="obligor_2a"]').val(obligee_2a);
  //   }
  //   if(typeof obligee_2b !== "undefined")
  //   {
  //     $('input[name="obligor_2b"]').val(obligee_2b);
  //   }
  //   if(typeof obligee_2c !== "undefined")
  //   {
  //     $('input[name="obligor_2c"]').val(obligee_2c);
  //   }
  //   if(typeof obligee_2d !== "undefined")
  //   {
  //     $('input[name="obligor_2d"]').val(obligee_2d);
  //   }
  //   if(typeof obligee_3_c_top_override_input !== "undefined")
  //   {
  //     $('input[name="obligor_3_c_top_override_input"]').val(obligee_3_c_top_override_input);
  //   }

  //   // data swapping of obligor to obligee
  //   if(typeof obligor_name !== "undefined")
  //   {
  //     $('input[name="obligee_name"]').val(obligor_name);
  //   }
  //   if(typeof obligor_full_name !== "undefined")
  //   {
  //     $('input[name="obligee_full_name"]').val(obligor_full_name);
  //   }

  //   if(typeof obligor_1_radio !== "undefined")
  //   {
  //       // $('input[name="obligee_1_radio"]').prop("checked", true);
  //       $('input[name="obligee_1_radio"][value="'+obligor_1_radio+'"]').prop('checked', 'checked');

  //       if(typeof obligor_1_input_year !== "undefined" && obligor_1_radio=='year')
  //       {
  //         $('input[name="obligee_1_input_year"]').val(obligor_1_input_year);
  //         $('input[name="obligee_1_input_year"]').prop("readonly", false);
  //       }
  //       if(typeof obligor_1_dropdown !== "undefined" && obligor_1_radio=='year')
  //       {
  //         $('select[name="obligee_1_dropdown"]').val(obligor_1_dropdown);
  //         // $('select[name="obligee_1_dropdown"] option[value="'+obligor_data_array[index].obligor_1_dropdown+'"]').attr("selected", "selected");
  //       }

  //       if(typeof obligor_1_input_ytd !== "undefined" && obligor_1_radio=='ytd')
  //       {
  //         $('input[name="obligee_1_input_ytd"]').val(obligor_1_input_ytd);
  //         $('input[name="obligee_1_input_ytd"]').prop("readonly", false);
  //       }
  //       if(typeof obligor_1_datepick !== "undefined" && obligor_1_radio=='ytd' && obligor_1_datepick !="")
  //       {
  //         // $('input[name="obligee_1_datepick"]').val(obligor_1_datepick);
  //         $('input[name="obligee_1_datepick').datepicker("setDate", new Date(obligor_1_datepick) );
  //       }

  //   }

  //   if(typeof obligor_1 !== "undefined")
  //   {
  //     $('input[name="obligee_1"]').val(obligor_1);
  //   }
  //   if(typeof obligor_2a !== "undefined")
  //   {
  //     $('input[name="obligee_2a"]').val(obligor_2a);
  //   }
  //   if(typeof obligor_2b !== "undefined")
  //   {
  //     $('input[name="obligee_2b"]').val(obligor_2b);
  //   }
  //   if(typeof obligor_2c !== "undefined")
  //   {
  //     $('input[name="obligee_2c"]').val(obligor_2c);
  //   }
  //   if(typeof obligor_2d !== "undefined")
  //   {
  //     $('input[name="obligee_2d"]').val(obligor_2d);
  //   }
  //   if(typeof obligor_3_c_top_override_input !== "undefined")
  //   {
  //     $('input[name="obligee_3_c_top_override_input"]').val(obligor_3_c_top_override_input);
  //   }

  //   // // to switch councel for between parentA/parentB
  //   // var councel_for=$('select[name=counsel_dropdown]').val();
  //   // if(councel_for=='Parent B'){
  //   //   $('select[name=counsel_dropdown] option:selected').removeAttr('selected');
  //   //   $('select[name=counsel_dropdown] option[value="Parent A"]').prop('selected', true);
  //   // }
  //   // if(councel_for=='Parent A'){
  //   //   $('select[name=counsel_dropdown] option:selected').removeAttr('selected');
  //   //   $('select[name=counsel_dropdown] option[value="Parent B"]').prop('selected', true);
  //   // }
    
  //   // to update dr_Children.This_Marriage_Child_Support_Obligor_CLient_OP too.

  //   var case_id="<?php if(isset($case_data['case_id'])){ echo $case_data['case_id']; } ?>";
  //   if(case_id){
  //       var token= $('input[name=_token]').val();
  //       var obligee_full_name=obligee_full_name;
  //       var obligor_full_name=obligor_full_name;
  //       $.ajax({
  //           url:"{{route('ajax_update_obligee_obligor_dr_children')}}",
  //           method:"POST",
  //           dataType: 'json',
  //           data:{
  //               case_id: case_id, 
  //               obligee_name: obligee_full_name, 
  //               obligor_name: obligor_full_name, 
  //               _token: token, 
  //           },
  //           success: function(data){
  //               // console.log(data);
  //               if(data==null || data=='null'){
  //               } else {
  //                 console.log("success");
  //               }
  //           }
  //       });
  //   }

  //   $('input[type="submit"][value="Calculate"]').trigger('click');
  // }

</script>
</div>
@endsection
