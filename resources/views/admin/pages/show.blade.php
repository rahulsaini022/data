@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center dynamic-page-main">
        <div class="col-md-12">
            <div class="card">
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

                    <h1 style="color: #147fe5; text-transform: uppercase; text-align: center;">{{ $page->title }}</h1>
                    <?php $html='<div class="table-responsive">
                                    <table class="table table-bordered pricing-table">
                                        <caption style="caption-side: top; background: #000000;"><span class="pricing-table-caption">Per Case Fees:</span></caption>
                                        <thead>
                                          <tr>'; ?>
                                            @foreach($data as $pricedata)
                                                <?php $html=$html.'<th>'.$pricedata->package_title.'</th>';?>
                                            @endforeach
                                          <?php $html=$html.'</tr>
                                        </thead>
                                        <tbody>
                                          <tr>';?>
                                            @foreach($data as $pricedata)
                                                <?php $html=$html.'<th><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" onclick="openModal('.$pricedata->id.')">FDD Documents</button></th>'; ?>
                                            @endforeach
                                          <?php $html=$html.'</tr>
                                          <tr>';?>
                                            @foreach($data as $pricedata)
                                                <?php $html=$html.'<th>$'.$pricedata->package_price.'</th>'; ?>
                                            @endforeach
                                          <?php $html=$html.'</tr>
                                        </tbody>
                                    </table>
                                </div>';
                        $content=$page->content;
                        $content=str_replace("[pricing_table]", $html, $content);
                    ?>
                    <div class="dynamic-page-content">
                    {!! $content !!}
                    <div>
                    @if($page->slug=='how-fdd-can-save-you-money')
                        <div class="row mt-4">
                            <div class="col-sm-6"><a class="btn btn-info mb-1 new-btn pull-left" href="{{ route('refer_an_attorney_who_uses_fdd') }}">Please refer an Attorney to me <br> who uses First Draft Data</a></div>
                            <div class="col-sm-6"><a class="btn btn-info mb-1 new-btn pull-right" href="{{ route('inform_my_attorney_to_use_fdd') }}">Please inform my Attorney <br> I want them to start using First Draft Data</a></div>
                        </div>
                    @else
                        <div class="row mt-4">
                            <div class="col-sm-4"><a class="btn btn-info mb-1 pull-left new-back-btn" href="{{ route('home') }}">Back</a></div>
                            <div class="col-sm-4 text-center">
                            @if($page->slug=='what-we-offer')
                                <a class="btn btn-info mb-1 new-btn" href="{{ route('dynamic_page','pricing') }}">Pricing</a>
                            @endif
                            @if($page->slug=='pricing')
                                <a class="btn btn-info mb-1 new-btn" href="{{ route('dynamic_page','what-we-offer') }}">What We Offer</a>
                            @endif
                            </div>
                            <div class="col-sm-4"><a class="btn btn-info mb-1 new-btn pull-right" href="{{ route('demo') }}">Demo</a></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>                    
<!-- Modal -->
  <div class="modal fade fdd-documents-list-modal" id="myModal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">FDD Documents</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-left fdd-documents-list" style="height:auto;max-height: 400px; overflow-y: scroll;">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  <style type="text/css">
      /* ALL LOADERS */

.loader{
  width: 100px;
  height: 100px;
  border-radius: 100%;
  position: relative;
  margin: 0 auto;
}

/* LOADER 6 */

#loader-6{
  top: 40px;
  left: -2.5px;
}

#loader-6 span{
  display: inline-block;
  width: 5px;
  height: 20px;
  background-color: #3498db;
}

#loader-6 span:nth-child(1){
  margin-left:3px; animation: grow 1s ease-in-out infinite;
}

#loader-6 span:nth-child(2){
  margin-left:3px; animation: grow 1s ease-in-out 0.15s infinite;
}

#loader-6 span:nth-child(3){
  margin-left:3px; animation: grow 1s ease-in-out 0.30s infinite;
}

#loader-6 span:nth-child(4){
  margin-left:3px; animation: grow 1s ease-in-out 0.45s infinite;
}

@keyframes grow{
  0%, 100%{
    -webkit-transform: scaleY(1);
    -ms-transform: scaleY(1);
    -o-transform: scaleY(1);
    transform: scaleY(1);
  }

  50%{
    -webkit-transform: scaleY(1.8);
    -ms-transform: scaleY(1.8);
    -o-transform: scaleY(1.8);
    transform: scaleY(1.8);
  }
}
  </style>
  <!-- Modal End-->
<script type="text/javascript">

    function openModal(package_id) {
        $(".fdd-documents-list").html('<div class="loader" id="loader-6"><span></span><span></span><span></span><span></span></div>');
        var url='/ajax-get-case-package-details/'+package_id+'';
        $.ajax({
            url:url,
            method:'GET',
            dataType: 'json',
            success:function(data){
                console.log(data);
                if(data==null || data=='null'){
                } else {
                    $(".fdd-documents-list").html(data.package_description);
                }
            }
        })
    }
</script>
@endsection