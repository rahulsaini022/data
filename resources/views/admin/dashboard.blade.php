@extends('layouts.app')

@section('content')


    <div class="row page_sidebar_outer admin-dashboard">
        <div class="col dashboard_content_box">
            @hasrole('super admin')
        	<div class="col-md-12">
        		<div class="col-md-6 dashboard-title-div" style="display: inline-block; float: left; padding-left: 0;">
                	<h2> Dashboard </h2>
                </div> 
        		<div class="col-md-6 paddingr dashboard-stats-select-div" style="display: inline-block;">
        			<form autocomplete="off">
        				@csrf
		                <select class="form-control stats-select pull-right">
		                	<option id="all" value="all">All</option>
		                	<option id="days" value="days">This Month</option>
		                	<option id="month" value="1">Last 1 Month</option>
		                	<option id="month" value="6">Last 6 Months</option>
		                	<option id="year" value="1">Last 1 Year</option>
		                	<option id="year" value="2">Last 2 Years</option>
		                	<option id="year" value="3">Last 3 Years</option>
		                	<option id="year" value="4">Last 4 Years</option>
		                	<option id="year" value="5">Last 5 Years</option>
		                </select>
		            </form>     
                </div> 
            </div>
            <div class="all-stats-div">
	            <div class="col-md-12">	
	            	<div class="col-md-6 col-lg-3 col-sm-6 card dashboard-count-box mt-4">
	            		<div class="card-body">
										  <a class="card-link text-dark"  href="{{ route('users.index') }}">
		            		<div class="h1 text-muted text-right mb-4">
					        	<i class="fa fa-users"></i>
					        </div>	
					        <div class="h4 mb-0">
					        	<span class="users-count"></span>
					        </div>
					        <span class="text-muted  font-weight-bold">Users</span>
											</a>
	            		</div>
	            	</div>	
	            	<div class="col-md-6 col-lg-3 col-sm-6 card dashboard-count-box mt-4">
	            		<div class="card-body">
										<a class="card-link text-dark" href="{{ route('attorneys.index') }}">
		            		<div class="h1 text-muted text-right mb-4">
					        	<i class="fa fa-users"></i>
					        </div>	
					        <div class="h4 mb-0">
					        	<span class="attornies-count"></span>
					        </div>
					        <span class="text-muted  font-weight-bold">Attorneys</span>
										</a>
	            		</div>
	            	</div>	
	            	<div class="col-md-6 col-lg-3 col-sm-6 card dashboard-count-box mt-4">
	            		<div class="card-body">
											<a class="card-link text-dark" href="{{ route('all.clients') }}">
		            		<div class="h1 text-muted text-right mb-4">
					        	<i class="fa fa-users"></i>
					        </div>	
					        <div class="h4 mb-0">
					        	<span class="clients-count"></span>
					        </div>
					        <span class="text-muted  font-weight-bold">Clients</span>
											</a>
	            		</div>
	            	</div>	
	            	<div class="col-md-6 col-lg-3 col-sm-6 card dashboard-count-box mt-4">
	            		<div class="card-body">
										<a class="card-link text-dark" href="{{ route('cases.all') }}">
		            		<div class="h1 text-muted text-right mb-4">
					        	<i class="fa fa-book"></i>
					        </div>	
					        <div class="h4 mb-0">
					        	<span class="cases-count"></span>
					        </div>
					        <span class="text-muted  font-weight-bold">Cases</span>
										</a>
	            		</div>
	            	</div>
	            	{{-- <div class="col-md-6 col-lg-3 col-sm-6 card dashboard-count-box mt-4">
	            		<div class="card-body">
		            		<div class="h1 text-muted text-right mb-4">
					        	<i class="fa fa-users" aria-hidden="true"></i>
					        </div>	
					        <div class="h4 mb-0">
					        	<span class="advertiser-count"></span>
					        </div>
					        <span class="text-muted  font-weight-bold">Advertisers</span>
	            		</div>
	            	</div> --}}
	            </div>
	        </div>
        	<div class="col-sm-12 col-md-12 last-active-users-div mt-4" style="display: inline-block;">
			    <div class="card">
					<div class="card-header">
						<strong class="card-title">Last 10 Active Users</strong>
					</div>
					<div class="card-body table-sm table-responsive">
					    <table class="table table-striped">
					        <thead>
					            <tr>
									<th scope="col">Sno.</th>
									<th scope="col">Name</th>
									<th scope="col">Email</th>
									<th scope="col">Last Login</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php $i=0;?>
					            @foreach($last_active_users as $last_active_user)
					            <tr>
					            	<td>{{ ++$i }}</td>
					            	<td>{{ $last_active_user->name }}</td>
					            	<td>{{ $last_active_user->email }}</td>
					            	<td>{{ \Carbon\Carbon::parse($last_active_user->last_login)->format('m/d/Y h:i:s A')}}</td>
					          	</tr>
					            @endforeach
					                          
					        </tbody>
					    </table>
					</div>
			  	</div>
	        </div>
        	<div class="col-sm-12 col-md-12 most-active-users-div mt-4" style="display: inline-block;">
			    <div class="card">
					<div class="card-header">
						<strong class="card-title">10 Most Active Users</strong>
					</div>
					<div class="card-body table-sm table-responsive">
					    <table class="table table-striped most-active-users-table">
					        <thead>
					            <tr>
									<th scope="col">Sno.</th>
									<th scope="col">Name</th>
									<th scope="col">Email</th>
									<th scope="col">Total Logins</th>
					            </tr>
					        </thead>
					        <tbody>
					            
					                          
					        </tbody>
					    </table>
					</div>
			  	</div>
	        </div>
            @endhasrole
			
			@hasrole('admin')   
			<div class="col-md-12">
        		<div class="col-md-6" style="display: inline-block; float: left;">
                	<h2> Dashboard </h2>
                </div>
                <div class="col-md-6" style="display: inline-block;">
                </div> 
            </div>
            <div class="col-md-12 mt-4">    
            	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
            @endhasrole

        </div>
    </div>

<script type="text/javascript">

    $(document).ready(function(){
    	var type='all';
    	var total='all';
        var token= $('input[name=_token]').val();
        $.ajax({
            url:"{{route('get.stats')}}",
            method:"POST",
            dataType: 'json',
            data:{
                type: type, 
                total: total, 
                _token: token, 
            },
            success: function(data){
                if(data==null || data=='null'){
                } else {
									
                    $('.users-count').text(data.users);
                    // $('.advertiser-count').text(data.advertisers);
                    $('.attornies-count').text(data.attornies);
                    $('.clients-count').text(data.clients);
                    $('.cases-count').text(data.cases);
                    var i=0;
                    var tabledata='';
                    $('.most-active-users-table tbody').empty();
                    // console.log(data.most_active_users);
                    $.each( data.most_active_users, function( key, value ) {
                    	++i;
                    	var tabledata="<tr><td>"+i+"</td><td>"+value.name+"</td><td>"+value.email+"</td><td>"+value.total+"</td></tr>";
                    	$('.most-active-users-table tbody').append(tabledata);
					});
                }
            }
        });

    	$('.stats-select').on('change', function(){
            var total=this.value;
            var type=$('.stats-select option:selected').attr('id');
            var token= $('input[name=_token]').val();
            $.ajax({
                url:"{{route('get.stats')}}",
                method:"POST",
                dataType: 'json',
                data:{
                    type: type, 
                    total: total, 
                    _token: token, 
                },
                success: function(data){
                    if(data==null || data=='null'){
                    } else {
                        $('.users-count').text(data.users);
												// $('.advertiser-count').text(data.advertisers);
                        $('.attornies-count').text(data.attornies);
                        $('.clients-count').text(data.clients);
                        $('.cases-count').text(data.cases);
                        var i=0;
	                    var tabledata='';
	                    $('.most-active-users-table tbody').empty();
	                    // console.log(data.most_active_users);
	                    $.each( data.most_active_users, function( key, value ) {
	                    	++i;
	                    	var tabledata="<tr><td>"+i+"</td><td>"+value.name+"</td><td>"+value.email+"</td><td>"+value.total+"</td></tr>";
	                    	$('.most-active-users-table tbody').append(tabledata);
						});
                    }
                }
            });
        });
    });

</script>  
@endsection

