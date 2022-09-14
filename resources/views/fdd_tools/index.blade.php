@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('FDD Tools') }}</strong></div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    <div class="row">
                        <table class="table table-bordered fdd-tools-table dark-border">
                        <tbody>
                            <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ route('fdd_tools.fdd_quick_affidavit_of_basic_information_income_and_expenses', ['show' => 'active']) }}">FDD Quick Affidavit of Basic Information, Income, and Expenses</a>
                                    <br>(included and unlimited per paid seat license)
                                </td>
                                <td>
                                    This is a web-based Family Law Affidavit that automatically calculates and allows everything from quick “what if” testing to fully acceptable affidavits for submission to courts.  The amount of data entered is in your control.  However, this tool can only store on “saved” data.  This tool already has built-in income calculation features and is unlimited to each registered seat license.  Better yet, you have the option of automatically loading the saved data into the FDD Quick Child Support Worksheets for easy drafting of associated child support calculation worksheets. <br> <strong>NOTE:</strong> For a case-specific child family law affidavit tool, register your family law case and it will include a prefilled case-specific FDD Family Law Affidavit and associated FDD Child Support worksheet for unlimited “what if” testing and case-specific database-driven FDD Family Law Affidavit & FDD Child Support Worksheet that are completely prefilled where all you might need to enter on it are deviations for child support and for cash medical. Both FDD forms are automatically calculated and saved for each registered family law case.
                                </td>
                            </tr>
                            <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ route('fdd_tools.fdd_quick_child_support_worksheets', ['show' => 'active']) }}">FDD Quick Child Support Worksheets</a>
                                    <br>(included and unlimited per paid seat license)
                                </td>
                                <td>
                                    This is a web-based child support worksheet that automatically calculates and allows everything from quick “what if” testing to fully acceptable worksheets for submission to courts.  The amount of data entered is in your control. However, this tool can only store one “saved” data set for each type of custody.  This tool already has built-in income calculation tools and is unlimited to each registered seat licensee. <br> <strong>NOTE:</strong> For a case-specific child support tool, register your family law case and it will include a prefilled case-specific FDD Quick Child Support worksheet for unlimited “what if” testing and a case-specific database-driven FDD Child Support worksheet that is completely prefilled and all you might need to enter on it are deviations for child support and for cash medical.  Both case-specific child support worksheets are automatically calculated and saved for each registered family law case.
                                </td>
                            </tr> 
                            <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ route('fdd_tools.fdd_annual_income_calculator') }}">FDD Annual Income Calculator</a>
                                    <br>(included and unlimited per paid seat license)
                                </td>
                                <td>
                                    An annual income calculator which uses periodic payments or year-to-date earnings.  The FDD Annual Income Calculator is built into the FDD Quick Child Support Worksheets but is here separated for convenience and/or other purposes.
                                </td>
                            </tr>
                            <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ route('fdd_tools.fdd_quick_coverture_calculator') }}">FDD Quick Coverture Calculator</a>
                                    <br>(included and unlimited per paid seat license)
                                </td>
                                <td>
                                    This is a web-base coverture calculator designed to calculate the fractional division of a coverture asset (usually a pension or other retirement) between the pension owner and their spouse.  For registered family law cases, this tool is “in line” as part of the web interview.  The result of the FDD Quick Coverture Calculator aren’t saved so print them out if you need to use them elsewhere.
                                </td>
                            </tr> 
                            <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ route('fdd_tools.fdd_loan_finance_calculator') }}">FDD Loan/Finance Calculator</a>
                                    <br>(included and unlimited per paid seat license)
                                </td>
                                <td>
                                    The FDD Loan/Finance Calculator determines periodic payments given basic loan or financing terms.
                                </td>
                            </tr> 
                            <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ route('fdd_tools.fdd_annuity_value_calculator') }}">FDD Annuity Value Calculator</a>
                                    <br>(included and unlimited per paid seat license)
                                </td>
                                <td>
                                    The FDD Annuity Value Calculator determines the value of an annuity at first payout and discounts that value to present day.
                                </td>
                            </tr> 
                            <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ route('fdd_tools.fdd_pension_value_calculator') }}">FDD Pension Value Calculator</a>
                                    <br>(included and unlimited per paid seat license)
                                </td>
                                <td>
                                    The FDD Pension Value Calculator determines pension value at first payout and discounts that value to present day given a variety of facts and estimates.  It includes consideration of pension division, cost of survivorship plans, and different age/life expectancy of pensioner and pensioner’s spouse. 
                                </td>
                            </tr>
                            <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ route('fdd_tools.pdf_tools') }}">FDD PDF Tools</a>
                                    <br>(premium PDF tools)
                                </td>
                                <td>
                                    FDD PDF Tools are <u><i>premium</i></u> tools where document submission size is nominally limited to 1GB and each use of a PDF Tool will expend one to five PDF credits.  A seat license gains 5 PDF credits for each case registration – yes, they add up and only expire if and when the seat license is not timely renewed).  Need more PDF credits? Additional credits are easily purchased at the FDD PDF Tools page.
                                </td>
                            </tr>
                             <tr>
                                <td width="35%" class="text-center">
                                    <a class="btn btn-info new-btn" href="{{ url('orchard-search') }}">Orchard Search</a>
                                    
                                    
                                </td>
                                <td>
                                    Keyword(s) search through documents contributed by users which you can download. These might be complete or portions of pleading or motions. No need to re-invent the wheel to develop your documents if they’re already available here. Take/submit documents so we help each other. No warranty, of course, but you might save a lot of time by searching in the Orchard. Make sure to check authorities given. If you find some "bad" apples, let us know so we can remove them.
                                </td>
                            </tr>
                        </tbody>
                      </table>

                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection