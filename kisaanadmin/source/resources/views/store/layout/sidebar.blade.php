	<!-- BEGIN #sidebar -->
		<div id="sidebar" class="app-sidebar">
			<!-- BEGIN scrollbar -->
			<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
				<!-- BEGIN menu -->
				<div class="menu">
					<div class="menu-header">{{ __('keywords.Navigation') }}</div>
					<div class="menu-item active">
						<a href="{{route('storeHome')}}" class="menu-link">
							<span class="menu-icon"><i class="fa fa-laptop"></i></span>
							<span class="menu-text">{{ __('keywords.Dashboard') }}</span>
						</a>
					</div>
					
					  	<div class="menu-divider"></div>
						<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-cubes"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Reports') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
						    		<div class="menu-item">
						<a href="{{route('reqfortoday')}}" class="menu-link">
							<span class="menu-icon"><i class="fa fa-map"></i></span>
							<span class="menu-text">{{ __('keywords.Item Requirement') }}</span>
						</a>
					</div>
					<div class="menu-item">
						<a href="{{route('reqforthirty')}}" class="menu-link">
							<span class="menu-icon"><i class="fa fa-map"></i></span>
							<span class="menu-text">{{ __('keywords.Item Sale Report') }} ({{ __('keywords.Last 30 Days')}})</span>
						</a>
				    	</div>
						
						</div>
					</div>
					 
					<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-bell"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Send Notifications') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
						    	<div class="menu-item">
								<a href="{{route('storeNotification')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Send Notification to Users') }}</span>
								</a>
							</div>
		
							<div class="menu-item">
								<a href="{{route('storeNotificationdriver')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Send Notification to Driver') }}</span>
								</a>
							</div>
						
						</div>
					</div>
					<div class="menu-item">
						<a href="{{route('couponlist')}}" class="menu-link">
							<span class="menu-icon"><i class="fa fa-smile"></i></span>
							<span class="menu-text">{{ __('keywords.Coupon') }}</span>
						</a>
					</div>
				
					<div class="menu-item">
						<a href="{{route('payout_req')}}" class="menu-link">
							<span class="menu-icon"><i class="material-icons">layers</i></span>
							<span class="menu-text">{{ __('keywords.Send Payout Request') }}</span>
						</a>
					</div>
					<div class="menu-item">
						<a href="{{route('storebannerlist')}}" class="menu-link">
             
							<span class="menu-icon"> <i class="material-icons">list</i></span>
							<span class="menu-text">{{ __('keywords.Store Banner') }}</span>
						</a>
					</div>


				
					
					<div class="menu-item">
						<a href="{{route('storeproductlist')}}" class="menu-link">
             
							<span class="menu-icon"><i class="fa fa-cubes"></i></span>
							<span class="menu-text">{{ __('keywords.Products') }}</span>
						</a>
					</div>

                 
					<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-cubes"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Admin') }} {{ __('keywords.Category') }}/{{ __('keywords.Product') }} </span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('sel_product')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Add Products') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('stt_product')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Update Price/Mrp') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('st_product')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Update Stock') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('deallist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Deal Products') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('bulkuprice')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Bulk Update Price/Stock') }}</span>
								</a>
							</div>
							<!--<div class="menu-item">-->
							<!--	<a href="{{route('storehomecate')}}" class="menu-link">-->
							<!--		<span class="menu-text">{{ __('keywords.Home Category Group') }}</span>-->
							<!--	</a>-->
							<!--</div>-->

						</div>
					</div>

                 
                      	<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-calendar"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Orders Management') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('store_sales_today')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Day wise orders') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('st_missed_orders')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Missed Orders') }}</span>
								</a>
							</div>
						<div class="menu-item">
						<a href="{{route('storeassignedorders')}}" class="menu-link">
							<span class="menu-text">{{ __('keywords.Today Orders') }}</span>
						</a>
					</div>
					<div class="menu-item">
						<a href="{{route('storeOrders')}}" class="menu-link">
							<span class="menu-text">{{ __('keywords.Next-Day Orders') }}</span>
						</a>
					</div>
						
						</div>
					</div>
	             
					
                   <div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-users"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Delivery Boy') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('store_d_boylist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Delivery Boy') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('store_boy_incentive')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Delivery Boy') }} {{ __('keywords.Incentive') }}</span>
								</a>
							</div>
						
						
						</div>
					</div>
				    <div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-phone"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Callback Requests') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
								<div class="menu-item">
						<a href="{{route('callback_requests')}}" class="menu-link">
						
							<span class="menu-text">{{ __('keywords.Users') }} {{ __('keywords.Callback Requests') }}</span>
						</a>
					</div>
				
					<div class="menu-item">
						<a href="{{route('st_driver_callback_requests')}}" class="menu-link">
						
							<span class="menu-text">{{ __('keywords.Delivery Boy') }} {{ __('keywords.Callback Requests') }}</span>
						</a>
					</div>
						
						
						</div>
					</div>
                   <div class="menu-divider"></div>
					<div class="menu-header">{{ __('keywords.Settings') }}</div>
					<div class="menu-item">
						<a href="{{route('storetimeslot')}}" class="menu-link">
							<span class="menu-icon"><i class="fa fa-cog"></i></span>
							<span class="menu-text">{{ __('keywords.Store Settings') }}</span>
						</a>
					</div>
					
				</div>
				<!-- END menu -->
			</div>
			<!-- END scrollbar -->
			
			<!-- BEGIN mobile-sidebar-backdrop -->
			<button class="app-sidebar-mobile-backdrop" data-dismiss="sidebar-mobile"></button>
			<!-- END mobile-sidebar-backdrop -->
		</div>
		<!-- END #sidebar -->
		

