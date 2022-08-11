
<html>
<head>
<title>{{ config('app.name', 'First Draft Data') }}</title>
<style type="text/css">
#page-wrapper {
    padding-top: 30px;
}
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
  td select {text-transform: none;background: transparent;border: none;margin: 0 auto;display: table;}

.textright{text-align: right!important;}

  body{min-width: 1170px;width: 100%;}
  body .container {max-width: 100%;width: 1140px;}
  body .container .container{width: 100%;padding:0;}

  tr.bg-grey {
    background: #dadada;
  }


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
    .page-break{page-break-before: always !important;page-break-after: always;page-break-inside: always;}
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
<script src="{{ asset('js/polyfiller.js') }}"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

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

</head>
   <body>
    <div id="page-wrapper">
  <!-- feel free to change between container or container fluid -->
  <div class="container">

<div id="page-wrapper">
<div class="container">
<div class="well">

<div class="row">
  <div class="col-sm-12 col-xs-12">
     <form id="entryformPrint" method="post" action="{{ route('computations.split') }}">
        @csrf
        <input type="hidden" name="sheet_custody" value="{{ $sheet_custody }}">
        <input type="hidden" name="sheet_state" value="{{ $sheet_state }}">
        <input type="hidden" name="chk_prefill" value="{{ $chk_prefill }}">
          @if (isset($success))
            <div class="alert alert-success alert-block text-center">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $success }}</strong>
            </div>
          @endif

         <h3 class="page-title">OHIO </br> <?php echo strtoupper($sheet_custody); ?> PARENTING CHILD SUPPORT  COMPUTATION WORKSHEET</h3>

          <?php   

            // foreach($postData as  $key => $value)
            // {
            //  if (is_numeric($postData[$key]))
            //   {
            //     $postData[$key] = number_format($value, 2, '.', ',');
            //   }
            // }

          ?>

        <table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tbody>
            <tr class="bg-grey">
                    <td class="text-center"><strong>Parent A Name</strong></td>
                    <td class="text-center"><strong>Parent B Name</strong></td>
                    <td class="text-center" class="white-space-td"><strong>Date this form is completed</strong></td>
                </tr>
                <tr>
                  <td class="text-center"><?php if(isset($postData['obligee_name'])){ echo $postData['obligee_name']; } else if(isset($case_data['client_name'])){ echo $case_data['client_name']; } ?></td>
                  <td class="text-center"><?php if(isset($postData['obligor_name'])){ echo $postData['obligor_name']; } else if(isset($case_data['opponent_name'])){ echo $case_data['opponent_name']; } ?></td>
                  <td class="text-center"><?php echo date("m/d/Y"); ?></td>
                </tr>
              </tbody>
            </table>

            <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-top: 0;">
                <tbody>
                 <tr class="bg-grey">
                    <td class="text-center"><strong>County Name</strong></td>
                    <td class="text-center"><strong>SETS Case Number</strong></td>
                    <td class="text-center"><strong>Court or Administrative Order Number</strong></td>
                    <td class="text-center"><strong>Number of Children of the Order</strong></td>
                </tr>

                <tr>
                  <td>
                    <?php $state=isset($sheet_state)?$sheet_state:'';
                            $county_selected=isset($postData['county_name'])?$postData['county_name']:'';
                      ?>
                      <p style="display: none;" id="selected_county">{{ $county_selected }}</p>
                     <select id="county_name" class="county-select" name="county_name" required>
                      <option value="">Choose County</option>
                        
                    </select>
                  </td>

                  <td class="text-center">
                    <?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>    
                  </td>

                  <td class="text-center">
                  <?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>
                  </td>

                  <td class="text-center">
                    <?php echo isset($postData['number_children_order'])? (int) $postData['number_children_order']:''; ?>    
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

                  <td colspan="2" class="text-center"><strong>Parent A</strong></td>
                  <td colspan="2" class="text-center"><strong>Parent B</strong></td>
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
                                </div>
                              </td>

                              <td>
                                <?php echo (!isset($postData['obligee_1_input_year']) || $postData['obligee_1_input_year'] == '') ? '0.00' : $postData['obligee_1_input_year']; 
                                ?>
                              </td>
                              
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
                              
                              <td class="white-space-td">
                                <?php echo (!isset($postData['obligee_1_input_ytd']) || $postData['obligee_1_input_ytd'] == '') ? 'YTD Chk' : $postData['obligee_1_input_ytd']; 
                                ?>
                              </td>
                              
                              <td class="white-space-td" colspan="2">
                                <?php echo (!isset($postData['obligee_1_datepick']) || $postData['obligee_1_datepick'] == '') ? 'Date' : $postData['obligee_1_datepick']; 
                                ?>
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

                              <td class="white-space-td">
                                
                                <?php echo (!isset($postData['obligor_1_input_year']) || $postData['obligor_1_input_year'] == '') ? '0.00' : $postData['obligor_1_input_year']; 
                                ?>
                              </td>
                            
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

                               <!-- <td><input type="text" name="obligor_1_input_ytd" placeholder="YTD Chk" class="readonly-feild" aria-required="true" inputmode="numeric" aria-labelledby="" style="margin-left: 0px; margin-right: 0px; width: 108.2px;" id="obligor_1_input_ytd" readonly value="<?php //echo $postData['obligor_1_input_ytd'] ?? ''; ?>" onchange="callCalcuAnnualGrossIncome('obligor')"></td> -->

                              <td class="white-space-td">

                              <?php echo (!isset($postData['obligor_1_input_ytd']) || $postData['obligor_1_input_ytd'] == '') ? 'YTD Chk' : $postData['obligor_1_input_ytd']; 
                              ?>

                              </td>
                              
                              <td>
                                <div class="input_field_wrapper">
                                <!-- <input class="text-center datepicker sfont readonly-feild" type="text" id="obligor_1_datepick" name="obligor_1_datepick" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" placeholder="DatePick" value="<?php //echo isset($postData['obligor_1_datepick'])?$postData['obligor_1_datepick']:''; ?>" onchange="callCalcuAnnualGrossIncome('obligor')"> -->

                                <?php echo (!isset($postData['obligor_1_datepick']) || $postData['obligor_1_datepick'] == '') ? 'Date' : $postData['obligor_1_datepick']; 
                                ?>

                                </div>
                              </td>
                          </tr>
                          <tr>
                            <td>
                              <div class="input_field_wrapper_checkbox text-center">
                                <input type="radio" id="obligor_1_ohio_minimum_wage" name="obligor_1_radio" class="es_checkbox" value="oh_min_wage" onclick="enableDisableField1('obligor','default')" <?php echo ((isset($postData['obligor_1_radio'])) && ($postData['obligor_1_radio'] == 'oh_min_wage')) ? 'checked' : ''; ?>>
                              </div>
                            </td>
                              <td colspan="2"> Ohio Minimum Wage </td>
                          </tr>
                      </tbody>
                    </table>
                  </td>

                  
                  <td rowspan="1" colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_1'])?number_format($postData['obligee_1'], 2):0.00; ?>
                </div></td>
                  <td rowspan="1" colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_1'])?number_format($postData['obligor_1'], 2):0.00; ?>
            </div></td>
               </tr>
               <tr>
                  <td rowspan="5">2.</td>
                  <td colspan="14" class="dark-bg">Annual amount of overtime, bonuses, and commissions</td>
               </tr>
               <tr>
                <?php $currentYear = date("Y"); ?>
                  <td colspan="10">a. Year 3 (Three years ago - <?php echo ($currentYear - 3); ?>) </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_2a'])?number_format($postData['obligee_2a'], 2):0.00; ?>
                    </div></td>
                  <td colspan="2" class="text-right"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_2a'])?number_format($postData['obligor_2a'], 2):0.00; ?>
                      </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">b. Year 2 (Two years ago - <?php echo ($currentYear - 2); ?>) </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_2b'])?number_format($postData['obligee_2b'], 2):0.00; ?>
                    </div></td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_2b'])?number_format($postData['obligor_2b'], 2):0.00; ?>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">c. Year 1 (Last calendar year - <?php echo ($currentYear - 1); ?>) </td>
                  <td colspan="2" class="text-right"> <div class="input_field_wrapper  hide-inputbtns">
                     <?php echo isset($postData['obligee_2c'])?number_format($postData['obligee_2c'], 2):0.00; ?>
                    </div>
                  </td>
                  <td colspan="2" class="text-right"> <div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_2c'])?number_format($postData['obligor_2c'], 2):0.00; ?>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">d. Income from overtime, bonuses, and commissions (Enter the lower of the average of   Line 2a plus Line 2b plus Line 2c, or Line 2c) </td>
                  <td colspan="2" class="text-right "> <div class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['obligee_2d'])?$postData['obligee_2d']:''; ?>
                    </div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_2d'])?$postData['obligor_2d']:''; ?>
            </div></td>
               </tr>
              <tr>
                  <td rowspan="5">3.</td>
                  <td colspan="14" class="dark-bg">Calculation for Self-Employment Income </td>
               </tr>
               <tr>
                  <td colspan="10">a. Gross receipts from business </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_3a'])?number_format($postData['obligee_3a'], 2):0.00; ?>
                    </div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center"> 
                    <?php echo isset($postData['obligor_3a'])?number_format($postData['obligor_3a'], 2):0.00; ?>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">b. Ordinary and necessary business expenses</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                      <?php echo isset($postData['obligee_3b'])?number_format($postData['obligee_3b'], 2):0.00; ?>
                    </div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_3b'])?number_format($postData['obligor_3b'], 2):0.00; ?>
                    </div>
                  </td>
               </tr>
                <tr>
                  <td colspan="5" rowspan="1" width="400">c. 6.2% of adjusted gross income or  actual marginal difference between  actual rate paid and F.I.C.A rate </td>
                  <td colspan="5" class="pd-0">
                    <table width="100%" class="inner-table">
                        <tr>
                          <td colspan="2" class="text-center"><strong>Parent A</strong></td>
                          <td colspan="2" class="text-center"><strong>Parent B</strong></td>
                        </tr>

                        <tr>
                          <td>
                            <div class="input_field_wrapper_checkbox text-center">
                              <input type="radio" id="obligee_3_c_top_override" name="obligee_3_c_radio" class="es_checkbox" value="calculation" onclick="radio3cAction('obligee', 'calculation')" <?php echo ((!isset($postData['obligee_3_c_radio'])) || ($postData['obligee_3_c_radio'] == 'calculation')) ? 'checked' : ''; ?>>
                            </div>
                          </td>

                          <td class="white-space-td">
                            <div class="input_field_wrapper hide-inputbtns text-center">
                            <?php 
                              // $obligee_3_c_top_override_input = $postData['obligee_3_c_top_override_input'];
                              if(isset($postData['obligee_3_c_top_override_input']))
                              {
                                echo $postData['obligee_3_c_top_override_input'];
                              }
                              else
                              {
                                echo "Calculated";
                              }
                            ?>
                            </div>
                          </td>

                          <!--  -->
                          
                          <td>
                            <div class="input_field_wrapper_checkbox text-center">
                              <input type="radio" id="obligor_3_c_top_override" name="obligor_3_c_radio" class="es_checkbox" value="calculation" onclick="radio3cAction('obligor', 'calculation')" <?php echo ((!isset($postData['obligor_3_c_radio'])) || ($postData['obligor_3_c_radio'] == 'calculation')) ? 'checked' : ''; ?>>
                            </div>
                          </td>

                          <td class="white-space-td">
                            <div class="input_field_wrapper hide-inputbtns text-center">
                              <?php 
                                // $obligor_3_c_top_override_input = $postData['obligor_3_c_top_override_input'];
                                if(isset($postData['obligor_3_c_top_override_input']))
                                {
                                  echo $postData['obligor_3_c_top_override_input'];
                                } else {
                                  echo "Calculated";
                                }
                              ?>
                              </div>
                          </td>

                          <!--  -->

                        </tr>
                        <tr>
                          
                          <!--  -->

                          <td>
                            <div class="input_field_wrapper_checkbox text-center">
                              <input type="radio" id="obligee_3_c_override" name="obligee_3_c_radio" class="es_checkbox" value="manual" onclick="radio3cAction('obligee', 'manual')" <?php echo ((isset($postData['obligee_3_c_radio'])) && ($postData['obligee_3_c_radio'] == 'manual')) ? 'checked' : ''; ?>>
                            </div>
                          </td>

                          <td class="white-space-td">
                            <div class="input_field_wrapper hide-inputbtns text-center">
                                <?php 
                                // $obligee_3_c_override_input = $postData['obligee_3_c_override_input'];
                                  if(isset($postData['obligee_3_c_override_input']))
                                  {
                                    echo $postData['obligee_3_c_override_input'];

                                  } else {
                                    echo "Actual";
                                  }
                                ?>
                              </div>
                          </td>

                          <!--  -->

                          <td>
                            <div class="input_field_wrapper_checkbox text-center">
                              <input type="radio" id="obligor_3_c_override" name="obligor_3_c_radio" class="es_checkbox" value="manual" onclick="radio3cAction('obligor', 'manual')" <?php echo ((isset($postData['obligor_3_c_radio'])) && ($postData['obligor_3_c_radio'] == 'manual')) ? 'checked' : ''; ?>>
                            </div>
                          </td>

                        <td class="white-space-td">
                          <div class="input_field_wrapper hide-inputbtns text-center">
                            <?php 
                              
                              // $obligor_3_c_override_input = $postData['obligor_3_c_override_input'];
                              if(isset($postData['obligor_3_c_override_input']))
                              {
                                echo $postData['obligor_3_c_override_input'];
                              } else {
                                echo "Actual";
                              }

                            ?>
                            </div>
                          </td>

                        </tr>
                     </table>
                  </td>
                  
                  <td rowspan="1" colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php 
                      // $obligee_3c = $postData['obligee_3c'];
                      
                      if(isset($postData['obligee_3c']))
                      {
                        echo $postData['obligee_3c'];
                      }
                      else
                      {
                        echo "0.00";
                      }

                    ?></div>
                  </td>
                  <td rowspan="1" colspan="2" class="text-right">
                    <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php 
                      // $obligor_3c = $postData['obligor_3c'];
                      if(isset($postData['obligor_3c']))
                      {
                        echo $postData['obligor_3c'];
                      }
                      else
                      {
                        echo "0.00";
                      }
                    ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">d. Adjusted annual gross income from self-employment (Line 3a minus Line 3b minus Line 3c) </td>
                  
                  <td colspan="2" class="text-right"> 
                    <div class="input_field_wrapper hide-inputbtns text-center">
                      <?php echo isset($postData['obligee_3d'])?$postData['obligee_3d']:''; ?>
                    </div>
                  </td>
                  
                  <td colspan="2" class="text-right">
                    <div class="input_field_wrapper hide-inputbtns text-center">
                      <?php echo isset($postData['obligor_3d'])?$postData['obligor_3d']:''; ?>
                    </div>
                  </td>
               </tr>
                <tr>
                  <td>4.</td>
                  <td colspan="10">Annual income from unemployment compensation</td>
                  <td colspan="2" class="text-right"><div  class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['obligee_4'])?number_format($postData['obligee_4'], 2):0.00; ?></div>
                  </td>

                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_4'])?number_format($postData['obligor_4'], 2):0.00; ?></div>
                  </td>
               </tr>
                <tr>
                  <td>5.</td>
                  <td colspan="10">Annual income from workers' compensation, disability insurance, or social security  disability/retirement benefits </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_5'])?number_format($postData['obligee_5'], 2):0.00; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_5'])?number_format($postData['obligor_5'], 2):0.00; ?></div>
                  </td>
               </tr>
               <tr>
                  <td>6.</td>
                  <td colspan="10">Other annual income or potential income </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_6'])?number_format($postData['obligee_6'], 2):0.00; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_6'])?number_format($postData['obligor_6'], 2):0.00; ?>
                    </div>
                  </td>
               </tr>

                <tr>
                  <td>7.</td>
                  <td colspan="10">Total annual gross income (Add Lines 1, 2d, 3d, 4, 5 and 6, if Line 7 results in a negative  amount, enter “0”)</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_7'])?number_format($postData['obligee_7'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_7'])?number_format($postData['obligor_7'], 2):''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td>8.</td>
                  <td colspan="10">Health insurance maximum (Multiply Line 7 by 5% or .05)</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_8'])?number_format($postData['obligee_8'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_8'])?number_format($postData['obligor_8'], 2):''; ?></div>
                  </td>
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
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_9a'])?(int) $postData['obligee_9a']:0; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_9a'])?(int) $postData['obligor_9a']:0; ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">b. Enter the number of children subject to this order </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_9b'])?(int) $postData['obligee_9b']:0; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_9b'])?(int) $postData['obligor_9b']:0; ?></div>
                  </td>
               </tr>
                <tr>
                  <td colspan="10">c. Line 9a minus Line 9b </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_9c'])?(int) $postData['obligee_9c']:''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_9c'])?(int) $postData['obligor_9c']:''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">d. Using the Basic Child Support Schedule, enter the amount from the corresponding cell   for each parent’s total annual gross income from Line 7 for the number of children on Line 9a</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns"><?php echo isset($postData['obligee_9d'])?number_format($postData['obligee_9d'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_9d'])?number_format($postData['obligor_9d'], 2):''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">e. Divide the amount on Line 9d by the number on Line 9a</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_9e'])?number_format($postData['obligee_9e'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_9e'])?number_format($postData['obligor_9e'], 2):''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">f. Multiply the amount from Line 9e by the number on Line 9c. This is the adjustment   amount for other minor children for each parent.</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_9f'])?number_format($postData['obligee_9f'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_9f'])?number_format($postData['obligor_9f'], 2):''; ?></div>
                  </td>
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
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_10b'])?number_format($postData['obligee_10b'], 2):0.00; ?>
                    </div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_10b'])?number_format($postData['obligor_10b'], 2):0.00; ?></div>
                  </td>
               </tr>
               <tr>
                  <td>11.</td>
                  <td colspan="10">Annual court ordered spousal support paid; if no spousal support is paid, enter “0”</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_11'])?number_format($postData['obligee_11'], 2):0.00; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_11'])?number_format($postData['obligor_11'], 2):0.00; ?></div>
                  </td>
               </tr>
               <tr>
                  <td>12.</td>
                  <td colspan="10">Total adjustments to income (Line 9f, plus Line 10b, plus Line 11)</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_12'])?number_format($postData['obligee_12'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_12'])?number_format($postData['obligor_12'], 2):''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td>13.</td>
                  <td colspan="10">Adjusted annual gross income (Line 7 minus Line 12; if Line 13 results in a negative  amount, enter "0") </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_13'])?number_format($postData['obligee_13'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_13'])?number_format($postData['obligor_13'], 2):''; ?></div>
                  </td>
               </tr>
                 <tr>
                  <td colspan="11"><strong>III. INCOME SHARES</strong></td>
                  <td colspan="2" class="text-center"><strong>Parent A</strong></td>
                  <td colspan="2" class="text-center"><strong>Parent B</strong></td>
               </tr>
               <tr>
                  <td>14.</td>
                  <td colspan="10">Enter the amount from Line 13 for each parent (Adjusted annual gross income) </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_14'])?number_format($postData['obligee_14'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_14'])?number_format($postData['obligor_14'], 2):''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td>15.</td>
                  <td colspan="10">If the parent’s obligation is in the shaded area of the schedule for the children of this order, check  the box for Line 15</td>
                  <td colspan="2" class="text-center"> <div class="input_field_wrapper_checkbox text-center">
                    <input type="checkbox" id="obligee_15" name="obligee_15"  class="es_checkbox" value="1" readonly <?php if(isset($postData['obligee_15']) && $postData['obligee_15']==1) { echo 'checked'; } ?> disabled>
                    </div>
                  </td>
                  <td colspan="2" class="text-center"> <div class="input_field_wrapper_checkbox text-center">
                    <input type="checkbox"  id="obligor_15" name="obligor_15"  class="es_checkbox" value="1" readonly <?php if(isset($postData['obligor_15']) && $postData['obligor_15']==1) { echo 'checked'; } ?> disabled>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td>16.</td>
                  <td colspan="10">Combined adjusted annual gross income (Add together the amounts of Line 14 for both parents)</td>
                  <td colspan="4" class="text-center"><div class="input_field_wrapper  hide-inputbtns"><?php echo isset($postData['obligee_16'])?number_format($postData['obligee_16'], 2):''; ?></div></td>
               </tr>
               <tr>
                  <td>17.</td>
                  <td colspan="10">Income Share: The percentage of parent's income to combined annual adjusted gross income</td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper  hide-inputbtns  percentage_end">
                    <?php echo isset($postData['obligee_17'])?number_format($postData['obligee_17'], 2):''; ?>%
                    </div>
                  </td>
                  <td colspan="2" class="text-right"><div class="input_field_wrapper hide-inputbtns text-center percentage_end">
                    <?php echo isset($postData['obligor_17'])?number_format($postData['obligor_17'], 2):''; ?>%</div>
                  </td>
               </tr>
            </tbody>
         </table>
         <p class="print-footer">© <?php echo date("Y");?> First Draft Data, LLC. All Rights Reserved. V <?php echo date("Y");?>-1 <span class="text-right">Page 1 of 3</span></p>

         <div class="page-break"></div>
          <table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tbody>

              <tr class="hide-header-tr bg-grey">
                  <td class="text-center"><strong>Parent A Name</strong></td>
                  <td class="text-center"><strong>Parent B Name</strong></td>
                  <td class="text-center" class="white-space-td"><strong>Date this form is completed</strong></td>
              </tr>

              <tr class="hide-header-tr">
                <td class="text-center"><?php echo isset($postData['obligee_name'])?$postData['obligee_name']:''; ?></td>
                <td class="text-center"><?php echo isset($postData['obligor_name'])?$postData['obligor_name']:''; ?></td>
                <td class="text-center"><?php echo date("m/d/Y"); ?></td>
              </tr>

              </tbody>
            </table>

            <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-top: 0;">
              <tbody>

                <tr class="bg-grey hide-header-tr">
                    <td class="text-center"><strong>County Name</strong></td>
                    <td class="text-center"><strong>SETS Case Number</strong></td>
                    <td class="text-center"><strong>Court or Administrative Order Number</strong></td>
                    <td class="text-center"><strong>Number of Children of the Order</strong></td>
                </tr>

                <tr class="hide-header-tr">
                  <td>
                    <?php $state=isset($sheet_state)?$sheet_state:'';
                            $county_selected=isset($postData['county_name'])?$postData['county_name']:'';
                      ?>
                     <select id="county_name" class="county-select" name="county_name1" required>
                      <option value="">Choose County</option>
                    </select>
                  </td>

                  <td class="text-center">
                    <?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>    
                  </td>

                  <td class="text-center">
                  <?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>
                  </td>

                  <td class="text-center">
                    <?php echo isset($postData['number_children_order'])?(int) $postData['number_children_order']:''; ?>    
                  </td>

                </tr>

              </tbody>
            </table>
         <table width="100%" border="1" cellspacing="0" cellpadding="0">
            <tbody>
               <tr>
                  <td colspan="15"><strong>IV. SUPPORT CALCULATION</strong></td>
               </tr>
               <tr>
                  <td rowspan="7">18.</td>
                  <td colspan="14" class="dark-bg">Basic Child Support Obligation</td>
               </tr>
               <tr>
                  <td colspan="5">Number of children with Parent A: <div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['parent_a_children'])?(int) $postData['parent_a_children']:0; ?></div>
                  </td>
                  <td colspan="5">Number of children with Parent B: <div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['parent_b_children'])?(int) $postData['parent_b_children']:0; ?></div>
                  </td>
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
                  <td colspan="10">a. Using the Basic Child Support Schedule, enter the amount from the corresponding cell for each
                     parent’s adjusted gross income on Line 14 for the number of children with each parent. If either parent’s Line 14 amount is less than lowest income amount on the Basic Schedule, enter “960”
                  </td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center text-center">
                    <?php echo isset($postData['18a1'])?number_format($postData['18a1'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['18a2'])?number_format($postData['18a2'], 2):''; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['18a3'])?number_format($postData['18a3'], 2):''; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['18a4'])?number_format($postData['18a4'], 2):''; ?></div>
                  </td>
               </tr>
                <tr>
                  <td colspan="10">b. Using the Basic Child Support Schedule, enter the amount from the corresponding cell for the
                     parents’ combined annual gross incomeon Line 16 for the number of children with each parent. If Line 16 amount is less than lowest income amount on the Basic Schedule, enter “960”
                  </td>
                  <td colspan="2" class="text-center"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_18b'])?number_format($postData['obligee_18b'], 2):''; ?></div></td>
                  <td colspan="2" class="text-center"><div class="input_field_wrapper  hide-inputbtns"><?php echo isset($postData['obligor_18b'])?number_format($postData['obligor_18b'], 2):''; ?></div></td>
               </tr>
               <tr>
                  <td colspan="10">c. Multiply the amount in Line 18b by Line 17 for each parent and enter the amount</td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['18c1'])?number_format($postData['18c1'], 2):''; ?></div></td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['18c2'])?number_format($postData['18c2'], 2):''; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['18c3'])?number_format($postData['18c3'], 2):''; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns"><?php echo isset($postData['18c4'])?number_format($postData['18c4'], 2):''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">d. Enter the lower of Line 18a or Line 18c for each parent, if less than “960”, enter “960”</td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns"><?php echo isset($postData['18d1'])?number_format($postData['18d1'], 2):''; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns"><?php echo isset($postData['18d2'])?number_format($postData['18d2'], 2):''; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['18d3'])?number_format($postData['18d3'], 2):''; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['18d4'])?number_format($postData['18d4'], 2):''; ?></div>
                  </td>
               </tr>
              <tr>
                  <td rowspan="3">19.</td>
                  <td colspan="10" class="dark-bg">Parenting Time Orde</td>
                  <td colspan="2" class="text-center dark-bg white-space-td">Parent A Custodial</td>
                  <td colspan="2" class="text-center dark-bg white-space-td">Parent B Custodial</td>
               </tr>
               <tr>
                  <td colspan="10">a. Enter “Yes” for any parent for whom a court has issued or is issuing a parenting time order that
                     equals or exceeds ninety overnights per year
                  </td>
                  <td class="dark-bg"></td>
                  
                  <td class="text-center">
                    <input type="checkbox"  id="obligee_19a" name="obligee_19a" class="es_checkbox" value="1" <?php if(isset($postData['obligee_19a']) && $postData['obligee_19a']==1) { echo 'checked'; } ?>>
                      <label for="checkbox5">Yes</label>
                  </td>
                  
                  <td class="text-center">
                    <div class="input_field_wrapper_checkbox text-center">
                      <input type="checkbox"  id="obligor_19a" name="obligor_19a"  class="es_checkbox" value="1" <?php if(isset($postData['obligor_19a']) && $postData['obligor_19a']==1) { echo 'checked'; } ?>>
                      <label for="checkbox6">Yes</label>
                    </div>
                  </td>

                  <td class="dark-bg"></td>
               </tr>
               <tr>
                  <td colspan="10" class="font-s">b. If Line 19a is checked, use the amount for that parent from Line 18d and multiply it by 10% or
                     .10, and enter this amount. If Line 19a is blank enter “0”
                  </td>
                  <td class="dark-bg"></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns">
                    <?php echo isset($postData['obligee_19b'])?number_format($postData['obligee_19b'], 2):''; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns">
                    <?php echo isset($postData['obligor_19b'])?number_format($postData['obligor_19b'], 2):''; ?></div>
                  </td>
                  <td class="dark-bg"></td>
               </tr>
              <tr>
                  <td rowspan="2">20.</td>
                  <td colspan="10" class="dark-bg">Derivative Benefit (Child’s benefit on behalf of a parent)</td>
                  <td colspan="2" class="text-center dark-bg">Parent A Custodial</td>
                  <td colspan="2" class="text-center dark-bg">Parent B Custodial</td>
               </tr>
               <tr>
                  <td colspan="10">Enter any non-means-tested benefits received by a child(ren) subject to the order.</td>
                  <td class="dark-bg"></td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['20a2'])?number_format($postData['20a2'], 2):0.00; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['20a3'])?number_format($postData['20a3'], 2):0.00; ?>
                    </div>
                  </td>

                  <td class="dark-bg"></td>
               </tr>
               <tr>
                  <td rowspan="34">21.</td>
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
                  <td colspan="10" class="border-top-0">
                    a. Annual child care expenses for children with each parent (Less any subsidies)
                  </td>

                  <td class="text-right"><div class="input_field_wrapper sfont  hide-inputbtns">
                    <?php echo isset($postData['21a1'])?number_format($postData['21a1'], 2):0.00; ?></div>
                  </td>
                  <td class="text-right"> <div class="input_field_wrapper  sfont hide-inputbtns">
                      <?php echo isset($postData['21a2'])?number_format($postData['21a2'], 2):0.00; ?>
                    </div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper sfont  hide-inputbtns">
                    <?php echo isset($postData['21a3'])?number_format($postData['21a3'], 2):0.00; ?></div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper  sfont hide-inputbtns">
                    <?php echo isset($postData['21a4'])?number_format($postData['21a4'], 2):0.00; ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="14">Children with Parent A</td>
               </tr>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2" class="text-center">Child 1</td>
                  <td colspan="2" class="text-center">Child 2</td>
                  <td colspan="2" class="text-center">Child 3</td>
                  <td colspan="2" class="text-center">Child 4</td>
                  <td colspan="2" class="text-center">Child 5</td>
                  <td colspan="2" class="text-center">Child 6</td>
               </tr>
                <tr>
                  <td colspan="2">Birth Date</td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php 
                        // $obligee_21b1 = $postData['obligee_21b1'];
                        if(isset($postData['obligee_21b1']))
                          echo $postData['obligee_21b1'];
                        else
                          echo "Date"; 
                      ?>
                    </div>
                  </td>

                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligee_21b2 = $postData['obligee_21b2'];
                      if(isset($postData['obligee_21b2']))
                        echo $postData['obligee_21b2'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>

                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligee_21b3 = $postData['obligee_21b3'];
                      if(isset($postData['obligee_21b3']))
                        echo $postData['obligee_21b3'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>
                  
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligee_21b4 = $postData['obligee_21b4'];
                      if(isset($postData['obligee_21b4']))
                        echo $postData['obligee_21b4'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>
                  

                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligee_21b5 = $postData['obligee_21b5'];
                      if(isset($postData['obligee_21b5']))
                        echo $postData['obligee_21b5'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>
                  

                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligee_21b6 = $postData['obligee_21b6'];
                      if(isset($postData['obligee_21b6']))
                        echo $postData['obligee_21b6'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>
               </tr>
              <tr>
                  <td colspan="2">b. Age</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper">
                    <?php //$obligee_21b1a = $postData['obligee_21b1a'];
                    if(isset($postData['obligee_21b1a']))
                      echo $postData['obligee_21b1a'];
                    else
                      echo "Calculate"; ?>
                  </td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                       <?php //$obligee_21b2a = $postData['obligee_21b2a'];
                    if(isset($postData['obligee_21b2a']))
                      echo $postData['obligee_21b2a'];
                    else
                      echo "Calculate"; ?></div>
                  </td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                       <?php //$obligee_21b3a = $postData['obligee_21b3a'];
                    if(isset($postData['obligee_21b3a']))
                      echo $postData['obligee_21b3a'];
                    else
                      echo "Calculate"; ?></div>
                  </td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                         <?php //$obligee_21b4a = $postData['obligee_21b4a'];
                      if(isset($postData['obligee_21b4a']))
                        echo $postData['obligee_21b4a'];
                      else
                        echo "Calculate"; ?>
                    </div>  
                  </td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                         <?php //$obligee_21b5a = $postData['obligee_21b5a'];
                      if(isset($postData['obligee_21b5a']))
                        echo $postData['obligee_21b5a'];
                      else
                        echo "Calculate"; ?>
                    </div>  
                  </td>

                  <td colspan="2" class=" text-center">
                     <?php //$obligee_21b6a = $postData['obligee_21b6a'];
                    if(isset($postData['obligee_21b6a']))
                      echo $postData['obligee_21b6a'];
                    else
                      echo "Calculate"; ?>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">c. Max</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21c1'])?number_format($postData['obligee_21c1'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21c2'])?number_format($postData['obligee_21c2'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21c3'])?number_format($postData['obligee_21c3'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21c4'])?number_format($postData['obligee_21c4'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21c5'])?number_format($postData['obligee_21c5'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21c6'])?number_format($postData['obligee_21c6'], 2):''; ?></div>
                  </td>
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
                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21d1'])?number_format($postData['obligee_21d1'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center"><?php echo isset($postData['obligor_21d1'])?number_format($postData['obligor_21d1'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21d2'])?number_format($postData['obligee_21d2'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21d2'])?number_format($postData['obligor_21d2'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center">  <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21d3'])?number_format($postData['obligee_21d3'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21d3'])?number_format($postData['obligor_21d3'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21d4'])?number_format($postData['obligee_21d4'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21d4'])?number_format($postData['obligor_21d4'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21d5'])?number_format($postData['obligee_21d5'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center"><?php echo isset($postData['obligor_21d5'])?number_format($postData['obligor_21d5'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21d6'])?number_format($postData['obligee_21d6'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21d6'])?number_format($postData['obligor_21d6'], 2, '.', ''):0.00; ?></div>
                  </td>
               </tr>
                <tr>
                  <td colspan="2">e. Lowest</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21e1'])?number_format($postData['obligee_21e1'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21e2'])?number_format($postData['obligee_21e2'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21e3'])?number_format($postData['obligee_21e3'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21e4'])?number_format($postData['obligee_21e4'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21e5'])?number_format($postData['obligee_21e5'], 2):''; ?></div>
                  </td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21e6'])?number_format($postData['obligee_21e6'], 2):''; ?></div>
                  </td>
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
                  <td class="text-center"><?php echo isset($postData['21_apportioned_obligee_A1'])?number_format($postData['21_apportioned_obligee_A1'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><?php echo isset($postData['21_apportioned_obligee_B1'])?number_format($postData['21_apportioned_obligee_B1'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligee_A2'])?number_format($postData['21_apportioned_obligee_A2'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligee_B2'])?number_format($postData['21_apportioned_obligee_B2'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligee_A3'])?number_format($postData['21_apportioned_obligee_A3'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"> <?php echo isset($postData['21_apportioned_obligee_B3'])?number_format($postData['21_apportioned_obligee_B3'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"> <?php echo isset($postData['21_apportioned_obligee_A4'])?number_format($postData['21_apportioned_obligee_A4'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligee_B4'])?number_format($postData['21_apportioned_obligee_B4'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligee_A5'])?number_format($postData['21_apportioned_obligee_A5'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligee_B5'])?number_format($postData['21_apportioned_obligee_B5'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligee_A6'])?number_format($postData['21_apportioned_obligee_A6'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligee_B6'])?number_format($postData['21_apportioned_obligee_B6'], 2, '.', ''):0.00; ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="14">Children with Parent B</td>
               </tr>
               <tr>
                  <td colspan="2"></td>
                  <td colspan="2" class="text-center">Child 1</td>
                  <td colspan="2" class="text-center">Child 2</td>
                  <td colspan="2" class="text-center">Child 3</td>
                  <td colspan="2" class="text-center">Child 4</td>
                  <td colspan="2" class="text-center">Child 5</td>
                  <td colspan="2" class="text-center">Child 6</td>
               </tr>
               <tr>
                  <td colspan="2">Birth Date</td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligor_21b1 = $postData['obligor_21b1'];
                      if(isset($postData['obligor_21b1']))
                        echo $postData['obligor_21b1'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>

                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligor_21b2 = $postData['obligor_21b2'];
                      if(isset($postData['obligor_21b2']))
                        echo $postData['obligor_21b2'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligor_21b3 = $postData['obligor_21b3'];
                      if(isset($postData['obligor_21b3']))
                        echo $postData['obligor_21b3'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligor_21b4 = $postData['obligor_21b4'];
                      if(isset($postData['obligor_21b4']))
                        echo $postData['obligor_21b4'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligor_21b5 = $postData['obligor_21b5'];
                      if(isset($postData['obligor_21b5']))
                        echo $postData['obligor_21b5'];
                      else
                        echo "Date"; ?>
                    </div>
                   </td>
                  <td colspan="2" class=" text-center">
                    <div class="input_field_wrapper">
                      <?php //$obligor_21b6 = $postData['obligor_21b6'];
                      if(isset($postData['obligor_21b6']))
                        echo $postData['obligor_21b6'];
                      else
                        echo "Date"; ?>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">f. Age</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper">
                    <?php //$obligor_21b1a = $postData['obligor_21b1a'];
                    if(isset($postData['obligor_21b1a']))
                    {
                      echo $postData['obligor_21b1a'];
                    }
                    else
                    {
                      echo "Calculate";
                    }

                    ?></div>
                  </td>
                  <td colspan="2" class=" text-center">
                    <?php //$obligor_21b1a = $postData['obligor_21b1a'];
                    if(isset($postData['obligor_21b1a']))
                    {
                      echo $postData['obligor_21b1a'];
                    }
                    else
                    {
                      echo "Calculate";
                    }

                    ?></div>
                  </td>
                  
                  <td colspan="2" class=" text-center"><?php //$obligor_21b3a = $postData['obligor_21b3a'];
                    if(isset($postData['obligor_21b3a']))
                    {
                      echo $postData['obligor_21b3a'];
                    }
                    else
                    {
                      echo "Calculate";
                    }

                    ?></div>
                  </td>
                  
                  <td colspan="2" class=" text-center">
                    <?php //$obligor_21b4a = $postData['obligor_21b4a'];
                    if(isset($postData['obligor_21b4a']))
                    {
                      echo $postData['obligor_21b4a'];
                    }
                    else
                    {
                      echo "Calculate";
                    }

                    ?></div>
                  </td>
                  
                  <td colspan="2" class=" text-center"><?php //$obligor_21b5a = $postData['obligor_21b5a'];
                    if(isset($postData['obligor_21b5a']))
                    {
                      echo $postData['obligor_21b5a'];
                    }
                    else
                    {
                      echo "Calculate";
                    }

                    ?></div>
                  </td>
                  
                  <td colspan="2" class=" text-center"><?php //$obligor_21b6a = $postData['obligor_21b6a'];
                    if(isset($postData['obligor_21b6a']))
                    {
                      echo $postData['obligor_21b6a'];
                    }
                    else
                    {
                      echo "Calculate";
                    }

                    ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="2">g. Max</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21c1'])?number_format($postData['obligor_21c1'], 2):''; ?></div></td>

                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21c2'])?number_format($postData['obligor_21c2'], 2):''; ?></div></td>

                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21c3'])?number_format($postData['obligor_21c3'], 2):''; ?></div></td>

                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21c4'])?number_format($postData['obligor_21c4'], 2):''; ?></div></td>

                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21c5'])?number_format($postData['obligor_21c5'], 2):''; ?></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21c6'])?number_format($postData['obligor_21c6'], 2):''; ?></div>
                  </td>
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
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21h1'])?number_format($postData['obligee_21h1'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21h1'])?number_format($postData['obligor_21h1'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21h2'])?number_format($postData['obligee_21h2'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21h2'])?number_format($postData['obligor_21h2'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21h3'])?number_format($postData['obligee_21h3'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21h3'])?number_format($postData['obligor_21h3'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21h4'])?number_format($postData['obligee_21h4'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21h4'])?number_format($postData['obligor_21h4'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21h5'])?number_format($postData['obligee_21h5'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21h5'])?number_format($postData['obligor_21h5'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_21h6'])?number_format($postData['obligee_21h6'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21h6'])?number_format($postData['obligor_21h6'], 2, '.', ''):0.00; ?></div></td>
               </tr>

                <tr>
                  <td colspan="2">i. Lowest</td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21e1'])?number_format($postData['obligor_21e1'], 2):''; ?></div></td>

                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21e2'])?number_format($postData['obligor_21e2'], 2):''; ?></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21e3'])?number_format($postData['obligor_21e3'], 2):''; ?></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21e4'])?number_format($postData['obligor_21e4'], 2):''; ?></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21e5'])?number_format($postData['obligor_21e5'], 2):''; ?></div></td>
                  <td colspan="2" class=" text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_21e6'])?number_format($postData['obligor_21e6'], 2):''; ?></div></td>
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
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_A1'])?number_format($postData['21_apportioned_obligor_A1'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_B1'])?number_format($postData['21_apportioned_obligor_B1'], 2, '.', ''):0.00; ?></div>
                  </td>
                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_A2'])?number_format($postData['21_apportioned_obligor_A2'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_B2'])?number_format($postData['21_apportioned_obligor_B2'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_A3'])?number_format($postData['21_apportioned_obligor_A3'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center"><?php echo isset($postData['21_apportioned_obligor_B3'])?number_format($postData['21_apportioned_obligor_B3'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center"><?php echo isset($postData['21_apportioned_obligor_A4'])?number_format($postData['21_apportioned_obligor_A4'], 2, '.', ''):0.00; ?>
                    </div></td>
                  <td class="text-center"> <div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_B4'])?number_format($postData['21_apportioned_obligor_B4'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_A5'])?number_format($postData['21_apportioned_obligor_A5'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_B5'])?number_format($postData['21_apportioned_obligor_B5'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_A6'])?number_format($postData['21_apportioned_obligor_A6'], 2, '.', ''):0.00; ?></div></td>

                  <td class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['21_apportioned_obligor_B6'])?number_format($postData['21_apportioned_obligor_B6'], 2, '.', ''):0.00; ?></div></td>
               </tr>
               <tr>
                  <td colspan="10">j. Enter total of Line 21e apportioned for children with Parent A</td>
                  <td class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_21j'])?number_format($postData['obligee_21j'], 2):''; ?>
                  </div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                   <?php echo isset($postData['obligor_21j'])?number_format($postData['obligor_21j'], 2):'';?>
                  </div></td>
                  <td class="border-right-0 dark-bg"></td>
                  <td class="border-left-0 dark-bg"></td>
               </tr>
               <tr>
                  <td colspan="10">k. Enter total of Line 21i apportioned for children with Parent B</td>
                  <td class="border-right-0 dark-bg"></td>
                  <td class="border-left-0 dark-bg"></td>
                  <td class=" text-right"> <div class="input_field_wrapper hide-inputbtns text-right">
                    <?php echo isset($postData['obligee_21k'])?number_format($postData['obligee_21k'], 2):''; ?>
                  </div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns text-right">
                   <?php echo isset($postData['obligor_21k'])?number_format($postData['obligor_21k'], 2):''; ?>
                  </div></td>
               </tr>
                 <tr>
                  <td colspan="10">Federal child care credit percentage (see IRS Pub 503)</td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns percentage_end">
                      <?php echo isset($postData['obligee_21ka1'])?number_format($postData['obligee_21ka1'], 2).'%':''; ?>
                    </div>
                  </td>

                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns percentage_end">
                      <?php echo isset($postData['obligee_21ka2'])?number_format($postData['obligee_21ka2'], 2).'%':''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns percentage_end">
                    <?php echo isset($postData['obligor_21ka1'])?number_format($postData['obligor_21ka1'], 2).'%':''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right"> 
                    <div class="input_field_wrapper  hide-inputbtns percentage_end">
                      <?php echo isset($postData['obligor_21ka2'])?number_format($postData['obligor_21ka2'], 2).'%':''; ?>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">Federal child care credit (see IRS Pub 503)</td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                     <?php echo isset($postData['obligee_21kb1'])?number_format($postData['obligee_21kb1'], 2):''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                     <?php echo isset($postData['obligee_21kb2'])?number_format($postData['obligee_21kb2'], 2):''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                     <?php echo isset($postData['obligor_21kb1'])?number_format($postData['obligor_21kb1'], 2):''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_21kb2'])?number_format($postData['obligor_21kb2'], 2):''; ?>
                    </div>
                  </td>
               </tr>
              <tr>
                  <td colspan="10">Ohio child care credit percentage (see Ohio Instructions PIT-IT1040)</td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper hide-inputbtns percentage_end">
                     <?php echo isset($postData['obligee_21kc1'])?number_format($postData['obligee_21kc1'], 2).'%':''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper hide-inputbtns percentage_end">
                      <?php echo isset($postData['obligee_21kc2'])?number_format($postData['obligee_21kc2'], 2).'%':''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper hide-inputbtns percentage_end">
                    <?php echo isset($postData['obligor_21kc1'])?number_format($postData['obligor_21kc1'], 2).'%':''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper hide-inputbtns percentage_end">
                    <?php echo isset($postData['obligor_21kc2'])?number_format($postData['obligor_21kc2'], 2).'%':''; ?>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">Ohio child care credit (see Ohio Instructions PIT-IT1040)</td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['obligee_21kd1'])?number_format($postData['obligee_21kd1'], 2):''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                     <?php echo isset($postData['obligee_21kd2'])?number_format($postData['obligee_21kd2'], 2):''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                     <?php echo isset($postData['obligor_21kd1'])?number_format($postData['obligor_21kd1'], 2):''; ?>
                    </div>
                  </td>
                  
                  <td class="text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligor_21kd2'])?number_format($postData['obligor_21kd2'], 2):''; ?>
                    </div>
                  </td>
               </tr>
                <tr>                  
                  <td colspan="10" class="pd-0">
                    <table width="100%" class="inner-table">
                    <tr>
                      <td width="300" style="font-size: 13px">l. Enter the eligible federal and state tax credits</td>
                      <td colspan="4" class="text-center">Parent A Custodial</td>
                      <td colspan="4" class="text-center">Parent B Custodial</td>
                    </tr>               
                    <tr>
                      <td> &nbsp;</td>
                      <td colspan="2">Parent A</td>
                      <td colspan="2">Parent B</td>
                      <td colspan="2">Parent A</td>
                      <td colspan="2">Parent B</td>
                    </tr>
                    <tr>
                      <td class="text-right">Calculated</td>
                      <td class="text-center"><div class="input_field_wrapper_checkbox">
                        <input type="radio" id="21l_obligee_ParentA_Cal" name="21l_obligee_ParentA" class="es_checkbox" value="calculation" onclick="enable3cField('21l_obligee_ParentA_Over_input', '21l_obligee_ParentA_Over')" <?php echo ((!isset($postData['21l_obligee_ParentA'])) || ($postData['21l_obligee_ParentA'] == 'calculation')) ? 'checked' : ''; ?>>
                      </div></td>
                      <td class="textleft">Calc</td>
                      <td class="text-center"><div class="input_field_wrapper_checkbox">
                        <input type="radio" id="21l_obligee_ParentB_Cal" name="21l_obligee_ParentB" class="es_checkbox" value="calculation" onclick="enable3cField('21l_obligee_ParentB_Over_input', '21l_obligee_ParentB_Over')" <?php echo ((!isset($postData['21l_obligee_ParentB'])) || ($postData['21l_obligee_ParentB'] == 'calculation')) ? 'checked' : ''; ?>>
                      </div></td>
                      <td class="textleft">Calc</td>
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
                      <td class="text-right">Override</td>
                      <td class="text-center"><div class="input_field_wrapper_checkbox">
                        <input type="radio" id="21l_obligee_ParentA_Over" name="21l_obligee_ParentA" class="es_checkbox" value="manual" onclick="enable3cField('21l_obligee_ParentA_Over_input', '21l_obligee_ParentA_Over')" <?php echo ((isset($postData['21l_obligee_ParentA'])) && ($postData['21l_obligee_ParentA'] == 'manual')) ? 'checked' : ''; ?>>
                      </div></td>
                      <td class="text-center"><div class="input_field_wrapper  hide-inputbtns ">
                        <?php 
                        //$l21_obligee_ParentA_Over_input = $postData['21l_obligee_ParentA_Over_input'];
                        if(isset($postData['21l_obligee_ParentA_Over_input']))
                        {
                            echo $postData['21l_obligee_ParentA_Over_input'];
                        }
                          else
                          {
                            echo "Actual";
                          }
                         ?>
                        </div>
                      </td>
                      <td class="text-center"><div class="input_field_wrapper_checkbox">
                        <input type="radio" id="21l_obligee_ParentB_Over" name="21l_obligee_ParentB" class="es_checkbox" value="manual" onclick="enable3cField('21l_obligee_ParentB_Over_input', '21l_obligee_ParentB_Over')" <?php echo ((isset($postData['21l_obligee_ParentB'])) && ($postData['21l_obligee_ParentB'] == 'manual')) ? 'checked' : ''; ?>>
                      </div></td>
                      <td class="text-center"> <div class="input_field_wrapper  hide-inputbtns ">
                        <?php 
                        //$l21_obligee_ParentB_Over_input = $postData['21l_obligee_ParentB_Over_input'];
                        if(isset($postData['21l_obligee_ParentB_Over_input']))
                        {
                            echo $postData['21l_obligee_ParentB_Over_input'];
                        }
                          else
                          {
                            echo "Actual";
                          }
                         ?>
                          </div>
                      </td>
                      <td class="text-center"><div class="input_field_wrapper_checkbox">
                        <input type="radio" id="21l_obligor_ParentA_Over" name="21l_obligor_ParentA" class="es_checkbox" value="manual" onclick="enable3cField('21l_obligor_ParentA_Over_input', '21l_obligor_ParentA_Over')" <?php echo ((isset($postData['21l_obligor_ParentA'])) && ($postData['21l_obligor_ParentA'] == 'manual')) ? 'checked' : ''; ?>>
                      </div></td>
                      <td class="text-center"><div class="input_field_wrapper  hide-inputbtns ">
                        <?php 
                        //$l21_obligor_ParentA_Over_input = $postData['21l_obligor_ParentA_Over_input'];
                        if(isset($postData['21l_obligor_ParentA_Over_input']))
                        {
                          echo $postData['21l_obligor_ParentA_Over_input'];
                        }
                        else
                        {
                          echo "Actual";
                        }
                        ?>
                      
                    </div></td>
                      <td class="text-center"><div class="input_field_wrapper_checkbox">
                        <input type="radio" id="21l_obligor_ParentB_Over" name="21l_obligor_ParentB" class="es_checkbox" value="manual" onclick="enable3cField('21l_obligor_ParentB_Over_input', '21l_obligor_ParentB_Over')" <?php echo ((isset($postData['21l_obligor_ParentB'])) && ($postData['21l_obligor_ParentB'] == 'manual')) ? 'checked' : ''; ?>>
                      </div></td>
                      <td class="text-center"><div class="input_field_wrapper  hide-inputbtns ">
                         <?php 
                        // $l21_obligor_ParentB_Over_input = $postData['21l_obligor_ParentB_Over_input'];
                        if(isset($postData['21l_obligor_ParentB_Over_input']))
                        {
                          echo $postData['21l_obligor_ParentB_Over_input'];
                        }
                        else
                        {
                          echo "Actual";
                        }
                        ?>
                          </div>
                        </td>
                    </tr>
                  </table>
                  </td>
                  <td rowspan="1" class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21l1'])?number_format($postData['21l1'], 2):0.00; ?></div>
                  </td>
                  <td rowspan="1" class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21l2'])?number_format($postData['21l2'], 2):0.00; ?></div>
                  </td>
                  <td rowspan="1" class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21l3'])?number_format($postData['21l3'], 2):0.00; ?></div>
                  </td>
                  <td rowspan="1" class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21l4'])?number_format($postData['21l4'], 2):0.00; ?></div>
                  </td>
               </tr>              
              <tr>
                  <td colspan="10">m. Line 21j minus combined amounts of Line 21l</td>
                  <td colspan="2" class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21m2'])?number_format($postData['21m2'], 2):''; ?></div>
                  </td>
                  <td colspan="2" style="background: #eeeeee;"></td>
               </tr>
               <tr>
                  <td colspan="10">n. Line 21k minus combined amounts of Line 21l</td>
                  <td colspan="2" style="background: #eeeeee;"></td>
                  <td colspan="2" class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21n4'])?number_format($postData['21n4'], 2):''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">o. Multiply Line 21m and Line 21n by Line 17 for each parent; (If Line 15 is checked for the parent,
                     use the lower percentage amount of either Line 17 or 50.00% to determine the parent’s share).<br><strong>Annual child care costs</strong> 
                  </td>
                  <td class=" text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['21o1'])?number_format($postData['21o1'], 2):"0.00"; ?> 
                      </div>
                  </td>
                  <td class=" text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['21o2'])?number_format($postData['21o2'], 2):"0.00"; ?>    
                      </div>
                  </td>
                  <td class=" text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['21o3'])?number_format($postData['21o3'], 2):"0.00"; ?>    
                      </div>
                  </td>
                  <td class=" text-right">
                    <div class="input_field_wrapper  hide-inputbtns">
                      <?php echo isset($postData['21o4'])?number_format($postData['21o4'], 2):"0.00"; ?>    
                      </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">p. Line 21o minus Line 21a. If calculation results in a negative amount, enter "0"</td>
                  <td class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21p1'])?number_format($postData['21p1'], 2):''; ?></div>
                  </td>
                  <td class=" text-right"> <div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21p2'])?number_format($postData['21p2'], 2):''; ?></div>
                  </td>
                  <td class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21p3'])?number_format($postData['21p3'], 2):''; ?></div>
                  </td>
                  <td class=" text-right"><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['21p4'])?number_format($postData['21p4'], 2):''; ?></div></td>
               </tr>
               <tr>
                  <td>22.</td>
                  <td colspan="10">Adjusted Child Support Obligation (Line 18d minus Line 19b minus Line 20 plus Line 21p; if
                     calculation results in negative amount, enter “0”). Annual child support obligation 
                  </td>
                  <td class="text-center dark-bg"></td>
                  <td class="text-center "><div class="input_field_wrapper  hide-inputbtns">
                    <?php echo isset($postData['obligee_22'])?$postData['obligee_22']:''; ?></div>
                  </td>
                  <td class="text-center "><div class="input_field_wrapper  hide-inputbtns"><?php echo isset($postData['obligor_22'])?$postData['obligor_22']:''; ?></div>
                  </td>
                  <td class="text-center dark-bg"></td>
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
                  <td colspan="2" class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php //$obligee_23a = $postData['obligee_23a'];  
                    if(isset($postData['obligee_23a']))
                    {
                      echo number_format($postData['obligee_23a'], 2);
                    }
                    else
                    {
                      echo "0";
                    }
                    ?>
                    </div>
                  </td>
                  <td colspan="2" class="text-center"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php //$obligor_23a = $postData['obligor_23a'];  
                    if(isset($postData['obligor_23a']))
                    {
                      echo number_format($postData['obligor_23a'], 2);
                    }
                    else
                    {
                      echo "0";
                    }
                    ?>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td colspan="10">b. Multiply Line 23a by Line 17 for each parent. Annual cash medical obligation</td>
                  <td class="dark-bg"></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns text-center"><?php echo isset($postData['obligee_23b'])?number_format($postData['obligee_23b'], 2):''; ?></div></td>
                  <td class=" text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_23b'])?number_format($postData['obligor_23b'], 2):''; ?></div>
                  </td>
                  <td class="dark-bg"></td>
               </tr>
            </tbody>
         </table>         
         <p class="print-footer">© <?php echo date("Y");?> First Draft Data, LLC. All Rights Reserved. V <?php echo date("Y");?>-1 <span class="text-right">Page 2 of 3</span></p>

         <div class="page-break"></div>
         <table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tbody>
            <tr class="bg-grey hide-header-tr">
                <td class="text-center"><strong>Parent A Name</strong></td>
                <td class="text-center"><strong>Parent B Name</strong></td>
                <td class="text-center" class="white-space-td"><strong>Date this form is completed</strong></td>
            </tr>
            <tr class="hide-header-tr">
              <td class="text-center"><?php echo isset($postData['obligee_name'])?$postData['obligee_name']:''; ?></td>
              <td class="text-center"><?php echo isset($postData['obligor_name'])?$postData['obligor_name']:''; ?></td>
              <td class="text-center"><?php echo date("m/d/Y"); ?></td>
            </tr>
          </tbody>
        </table>

        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-top: 0;">
              <tbody>

                <tr class="bg-grey hide-header-tr">
                    <td class="text-center"><strong>County Name</strong></td>
                    <td class="text-center"><strong>SETS Case Number</strong></td>
                    <td class="text-center"><strong>Court or Administrative Order Number</strong></td>
                    <td class="text-center"><strong>Number of Children of the Order</strong></td>
                </tr>

                <tr class="hide-header-tr">
                  <td>
                    <?php 
                      $state=isset($_REQUEST['sheet_state'])?$_REQUEST['sheet_state']:'';
                      $county_selected=isset($postData['county_name'])?$postData['county_name']:'';
                     ?>
                     <select id="county_name" class="county-select" name="county_name1" required>
                      <option value="">Choose County</option>
                    </select>
                  </td>

                  <td class="text-center">
                    <?php echo isset($postData['sets_case_number'])?$postData['sets_case_number']:''; ?>    
                  </td>

                  <td class="text-center">
                  <?php echo isset($postData['court_administrative_order_number'])?$postData['court_administrative_order_number']:''; ?>
                  </td>

                  <td class="text-center">
                    <?php echo isset($postData['number_children_order'])?(int) $postData['number_children_order']:''; ?>    
                  </td>

                </tr>

              </tbody>
         </table>

         <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table-2">
            <tbody>
               <tr>
                  <td colspan="11"><strong>VI. RECOMMENDED MONTHLY ORDERS FOR DECREE</strong></td>
                  <td class="text-center">PARENT A<br>OBLIGATION</td>
                  <td class="text-center">PARENT B<br>OBLIGATION</td>
                  <td colspan="2" class="text-center">NET SUPPORT<br>OBLIGATION</td>
               </tr>
                  <tr>
                  <td>24.</td>
                  <td colspan="10">ANNUAL CHILD SUPPORT AMOUNT (Line 22)</td>
                  <td colspan="1" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_24'])?number_format($postData['obligee_24'], 2):''; ?>
                    </div>
                  </td>
                  <td colspan="1" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_24'])?number_format($postData['obligor_24'], 2):''; ?>
                    </div>
                  </td>
                  <td colspan="2" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['24nso'])?number_format($postData['24nso'], 2):''; ?>
                    </div>
                  </td>
               </tr>
                <tr>
                  <td>25.</td>
                  <td colspan="10">MONTHLY CHILD SUPPORT AMOUNT</td>
                  <td colspan="1" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_25'])?number_format($postData['obligee_25'], 2):''; ?>
                    </div>
                  </td>
                  <td colspan="1" class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_25'])?number_format($postData['obligor_25'], 2):''; ?>
                    </div>
                  </td> 
                  <td colspan="2" class="dark-bg"></td>
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
                  <td colspan="10">Other relevant factors: (text only if checked) <input data-number-stepfactor="100" step="1" class="textright currency" type="text" id="26a_OtherRelevantText" name="26a_OtherRelevantText" placeholder="Enter" value="<?php echo isset($postData['26a_OtherRelevantText'])?$postData['26a_OtherRelevantText']:''; ?>" <?php if(isset($postData['obligee_26a_relvant']) && $postData['obligee_26a_relvant'] == '1'){  echo "";}elseif(isset($postData['obligor_26a_relvant']) && $postData['obligor_26a_relvant'] == '1'){echo "";} else {echo "readonly";}?> style="height:17px; vertical-align:middle; width: 100%; max-width: 300px; text-align: left !important; display: inline-block;"></td>
                  <td colspan="2"></td>
               </tr>
               <tr>
               
                  <td colspan="6"></td>
                  <td colspan="2" class="text-center">PARENT A</td>
                  <td colspan="2" class="text-center">PARENT B</td>
                  <td colspan="2"></td>
                  <td colspan="2" class="dark-bg"></td>
               </tr>
               <tr>
                  <td colspan="6" class="text-right">Set Monthly Child Support Deviation:</td>
                  <td style="width: 40px;text-align: center;"><input type="radio" name="26a_obligee_child_sport" class="es_checkbox" value="deviation" onclick="radio26ActionSplit('deviation', 'obligee')" <?php echo ((!isset($postData['26a_obligee_child_sport'])) || ($postData['26a_obligee_child_sport'] == 'deviation')) ? 'checked' : ''; ?>></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                      <?php 
                        //$a_obligee_child_sport_deviation_text26 = $postData['26a_obligee_child_sport_deviation_text'];
                        if(isset($postData['26a_obligee_child_sport_deviation_text']))
                        {
                          echo number_format($postData['26a_obligee_child_sport_deviation_text'], 2);
                        }
                        else
                        {
                          echo "0.00";
                        }
                        ?>
                        </div>
                  </td>
                  <td style="width: 40px;text-align: center;"><input type="radio" name="26a_obligor_child_sport" class="es_checkbox" value="deviation" onclick="radio26ActionSplit('deviation', 'obligor')" <?php echo ((!isset($postData['26a_obligor_child_sport'])) || ($postData['26a_obligor_child_sport'] == 'deviation')) ? 'checked' : ''; ?>></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                          <?php 
                        // $a_obligor_child_sport_deviation_text26 = $postData['26a_obligor_child_sport_deviation_text'];
                        if(isset($postData['26a_obligor_child_sport_deviation_text']))
                        {
                          echo number_format($postData['26a_obligor_child_sport_deviation_text'], 2);
                        }
                        else
                        {
                          echo "0.00";
                        }
                        ?>
                        </div>
                  </td>
                  <td></td>
                  <td></td>
                  <td colspan="2" class="dark-bg"></td>
               </tr>
               <tr>
                  <td colspan="6" class="text-right">Set Monthly Child Support:</td>
                  <td style="width: 40px;text-align: center;"><input type="radio" name="26a_obligee_child_sport" class="es_checkbox" value="nonDeviation" onclick="radio26ActionSplit('nonDeviation', 'obligee')" <?php echo ((isset($postData['26a_obligee_child_sport'])) && ($postData['26a_obligee_child_sport'] == 'nonDeviation')) ? 'checked' : ''; ?>></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                     <?php 
                        // $a_obligee_child_sport_non_deviation_text26 = $postData['26a_obligee_child_sport_non_deviation_text'];
                        if(isset($postData['26a_obligee_child_sport_non_deviation_text']))
                        {
                          echo number_format($postData['26a_obligee_child_sport_non_deviation_text'], 2);
                        }
                        else
                        {
                          echo "0.00";
                        }
                        ?>
                        </div>
                  </td>
                  <td style="width: 40px;text-align: center;"><input type="radio" name="26a_obligor_child_sport" class="es_checkbox" value="nonDeviation" onclick="radio26ActionSplit('nonDeviation', 'obligor')" <?php echo ((isset($postData['26a_obligor_child_sport'])) && ($postData['26a_obligor_child_sport'] == 'nonDeviation')) ? 'checked' : ''; ?>></td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                      <?php 
                        // $a26_obligor_child_sport_non_deviation_text = $postData['26a_obligor_child_sport_non_deviation_text'];
                        if(isset($postData['26a_obligor_child_sport_non_deviation_text']))
                        {
                          echo number_format($postData['26a_obligor_child_sport_non_deviation_text'], 2);
                        }
                        else
                        {
                          echo "0.00";
                        }
                        ?>
                        </div>
                    </td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                      <?php 
                        // $obligee_26a = $postData['obligee_26a'];
                        if(isset($postData['obligee_26a']))
                        {
                          echo number_format($postData['obligee_26a'], 2);
                        }
                        else
                        {
                          echo "0.00";
                        }
                        ?>
                         
                        </div></td>
                  <td class=" text-right"> <div class="input_field_wrapper hide-inputbtns text-center">
                      <?php 
                        // $obligor_26a = $postData['obligor_26a'];
                        if(isset($postData['obligor_26a']))
                        {
                          echo number_format($postData['obligor_26a'], 2);
                        }
                        else
                        {
                          echo "0.00";
                        }
                        ?>
                      </div>
                    </td>
                  <td colspan="2" class="color-green text-right dark-bg"></td>
               </tr>
               <tr>
                  <td colspan="10">b. For 3119.231 extended parenting time (Enter the monthly amount)</td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                          <?php echo isset($postData['obligee_26b'])?number_format($postData['obligee_26b'], 2):''; ?>
                        </div>
                  </td>
                  <td><div class="input_field_wrapper hide-inputbtns text-center">
                         <?php echo isset($postData['obligor_26b'])?number_format($postData['obligor_26b'], 2):''; ?>
                        </div>
                  </td>
                  <td class="text-right color-green dark-bg" colspan="2"></td>
               </tr>
               <tr>
                  <td colspan="10">c. Total of amounts from Lines 26a and 26b</td>
                  <td class="text-right " ><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_26c'])?number_format($postData['obligee_26c'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                          <?php echo isset($postData['obligor_26c'])?number_format($postData['obligor_26c'], 2):''; ?>
                        </div>
                  </td>
                  <td class="text-right color-green dark-bg" colspan="2"></td>
               </tr>
                 <tr>
                  <td>27.</td>
                  <td colspan="10">DEVIATED MONTHLY CHILD SUPPORT AMOUNT (Line 25 plus or minus Line 26c)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_27'])?number_format($postData['obligee_27'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_27'])?number_format($postData['obligor_27'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right color-green dark-bg" colspan="2"></td>
               </tr>
               <tr>
                  <td>28.</td>
                  <td colspan="10">ANNUAL CASH MEDICAL AMOUNT (Line 23b)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_28'])?number_format($postData['obligee_28'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_28'])?number_format($postData['obligor_28'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right " colspan="2"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['28nso'])?number_format($postData['28nso'], 2):''; ?>
                    </div>
                  </td>
               </tr>
               <tr>
                  <td>29.</td>
                  <td colspan="10"> MONTHLY CASH MEDICAL AMOUNT (Net Support Obligation amount from Line 28, divided by 12)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_29'])?number_format($postData['obligee_29'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_29'])?number_format($postData['obligor_29'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right dark-bg" colspan="2"></td>
               </tr>

                <tr>
                  <td rowspan="2">30.</td>
                  <td colspan="14" class="dark-bg"> Line 30 is ONLY completed if the court orders a deviation to cash medical. (See section 3119.303 of the Revised Code)</td>
               </tr>
               <tr>
                  <td colspan="10">Cash Medical Deviation amount (Enter the monthly amount)</td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_30'])?number_format($postData['obligee_30'], 2):0.00; ?>
                    </div>
                  </td>
                  <td class="text-right"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_30'])?number_format($postData['obligor_30'], 2):0.00; ?>
                    </div>
                  </td>
                  <td class="text-right color-green dark-bg" colspan="2"></td>
               </tr>
                <tr>
                  <td>31.</td>
                  <td colspan="10">DEVIATED MONTHLY CASH MEDICAL AMOUNT (Line 29 plus or minus Line 30)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_31'])?number_format($postData['obligee_31'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_31'])?number_format($postData['obligor_31'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right dark-bg" colspan="2"></td>
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
                    <?php echo isset($postData['obligee_32'])?number_format($postData['obligee_32'], 2):''; ?></div>
                   </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_32'])?number_format($postData['obligor_32'], 2):''; ?></div>
                  </td>
                  <td class="text-right " colspan="2"><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['nso_32'])?number_format($postData['nso_32'], 2):''; ?></div>
                  </td>
               </tr>
               <tr>
                  <td>33.</td>
                  <td colspan="10">MONTHLY SUPPORT AMOUNT (Net Support Obligation amount from Line 32)</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligee_33'])?number_format($postData['obligee_33'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo isset($postData['obligor_33'])?number_format($postData['obligor_33'], 2):''; ?>
                    </div>
                  </td>
                  <td class="text-right dark-bg" colspan="2"></td>
               </tr>
               <tr>
                  <td>34.</td>
                  <td colspan="10">Enter ONLY the total monthly obligation for the parent ordered to pay support
                     (Line 25 or Line 27, plus Line 29 or Line 31, or Line 33)
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo ((isset($postData['obligee_34'])) && ($postData['obligee_34'] != '')) ? number_format($postData['obligee_34'], 2):0.00; ?>
                    </div>
                  </td>
                  <td class="text-right">
                    <div class="input_field_wrapper hide-inputbtns text-center">
                      <?php echo number_format($postData['obligor_34'], 2) ?? 0.00; ?>    
                    </div>
                  </td>
                  <td class="text-right dark-bg" colspan="2"></td>
               </tr>
               <tr>
                  <td>35.</td>
                  <td colspan="10">Processing Charge Amount</td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                      <?php echo ((isset($postData['obligee_35'])) && ($postData['obligee_35'] != '')) ? number_format($postData['obligee_35'], 2):0.00; ?>
                    </div>
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                    <?php echo ((isset($postData['obligor_35'])) && ($postData['obligor_35'] != '')) ? number_format($postData['obligor_35'], 2):0.00; ?>
                    </div>
                  </td>
                  <td class="text-right dark-bg" colspan="2"></td>
               </tr>
               <tr>
                  <td>36.</td>
                  <td colspan="10">Total Monthly Obligation for Order (Child Support, Cash Medical, and Processing
                     Charge)
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                     <?php echo ((isset($postData['obligee_36'])) && ($postData['obligee_36'] != '')) ? number_format($postData['obligee_36'], 2):0.00; ?>
                    </div>
                  </td>
                  <td class="text-right "><div class="input_field_wrapper hide-inputbtns text-center">
                   <?php echo ((isset($postData['obligor_36'])) && ($postData['obligor_36'] != '')) ? number_format($postData['obligor_36'], 2):0.00; ?>
                    </div>
                  </td>
                  <td class="text-right dark-bg" colspan="2"></td>
               </tr>


                <tr class="print-none">
                  <td colspan="11">© First Draft Data, LLC. All Right Reserved. V<?php echo date("Y");?>-1</td>
                  <td colspan="4" style="text-align: right;">
                    <input type="hidden" name="editPrintProcess" value="1">
                    <input type="submit" name="editPrint" value="Edit" class="btn btn-info">
                    <a href="javascript:window.print()" class="btn btn-success">Print</a>
                    <a name="bottomsheet"></a>
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
          
          <!-- <td colspan="3">© 2019 First Draft Data, LLC. All Rights Reserved. V 2019-1</td>
          <td align="right">Page 3 of 3</td>  -->

          <p class="print-footer"  style="margin-top: 0; padding-top: 0">© <?php echo date("Y");?> First Draft Data, LLC. All Rights Reserved. V <?php echo date("Y");?>-1 <span class="text-right">Page 3 of 3</span></p>
          
        </tr>
      </tfoot>
    </table>



        </form>
   <loom-container id="lo-engage-ext-container">
      <loom-shadow classname="resolved"></loom-shadow>
   </loom-container>

    <script type="text/javascript">    

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
                    console.log(data);
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
                        window.print();
                    }
                }
            });
        }
        
      });

    </script>

</body>
</html>