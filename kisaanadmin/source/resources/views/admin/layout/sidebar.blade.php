	<!-- BEGIN #sidebar -->
		<div id="sidebar" class="app-sidebar">
			<!-- BEGIN scrollbar -->
			<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
				<!-- BEGIN menu -->
				<div class="menu">
					<div class="menu-header">{{ __('keywords.Navigation') }}</div>
					<div class="menu-item active">
						<a href="{{route('adminHome')}}" class="menu-link">
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
								<a href="{{route('item_sale_rep')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Item Requirement') }} ({{ __('keywords.Day-Wise') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('admin_reqforthirty')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Item Sales Report') }} ({{ __('keywords.Last 30 Days') }})</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('ad_boy_reports')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Reports') }}</span>
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
								<a href="{{route('adminNotificationuser')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Send Notification to Users') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('adminNotification')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Send Notification to Store')}}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('adminNotificationdriver')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Send Notification to Driver') }}</span>
								</a>
							</div>
						
						</div>
					</div>
					
						<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-users"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Users Management') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('userlist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Users Data')}}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('user_wallet')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Wallet Recharge History') }}</span>
								</a>
							</div>
						
						</div>
					</div>
	
					
						<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-cubes"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Category Management') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('catlist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Parent Categories')}}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('subcatlist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Sub Categories')}}</span>
								</a>
							</div>
						
						</div>
					  </div>
					  
		
						<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-cubes"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Product Catalog') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('productlist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Admin Products')}}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('st_plist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Store Products')}}({{ __('keywords.request')}})</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('bulkup')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Bulk Upload') }}</span>
								</a>
							</div>
						
						</div>
					</div>
				
					
						<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-map"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Area Management') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('citylist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Cities')}}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('societylist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Area/Society') }}</span>
								</a>
							</div>
								<div class="menu-item">
								<a href="{{route('bulkupcity')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Bulk Upload') }}</span>
								</a>
							</div>
						
						</div>
					</div>
		
					
						<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-building"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Store Management') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('storeclist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Store List') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('finance')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Store Earning/Payments') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('storeapprove')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Store Approval') }}</span>
								</a>
							</div>
						
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
								<a href="{{route('store_cancelled')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Rejected By Store') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('admin_pen_orders')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Pending Orders') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('admin_com_orders')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Completed Orders') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('admin_can_orders')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Cancelled Orders') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('sales_today')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Day Wise Orders') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('missed_orders')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Missed Orders') }}</span>
								</a>
							</div>
						
						</div>
					</div>
					
					<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-check"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Payout') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('pay_req')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Payout Requests') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('prv')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Payout Validation') }}</span>
								</a>
							</div>
						
						
						</div>
					</div>
					
				   	<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-trophy"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Rewards') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('RewardList')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Rewards') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('reedem')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Redeem Value') }}</span>
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
								<a href="{{route('d_boylist')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Delivery Boy') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('boy_incentive')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Delivery Boy') }} {{ __('keywords.Incentive') }}</span>
								</a>
							</div>
						
						
						</div>
					</div>

			
					<div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-bookmark"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Pages') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('about_us')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.About Us') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('terms')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Terms & Conditions') }}</span>
								</a>
							</div>
						
						
						</div>
					</div>
					
			   <div class="menu-item has-sub">
						<a href="#" class="menu-link">
							<span class="menu-icon">
								<i class="fa fa-comment"></i>
							</span>
							<span class="menu-text">{{ __('keywords.Feedback') }}</span>
							<span class="menu-caret"><b class="caret"></b></span>
						</a>
						<div class="menu-submenu">
							<div class="menu-item">
								<a href="{{route('user_feedback')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Users') }} {{ __('keywords.Feedback') }}</span>
								</a>
							</div>
							<div class="menu-item">
								<a href="{{route('store_feedback')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Store') }} {{ __('keywords.Feedback') }}</span>
								</a>
							</div>
						<div class="menu-item">
								<a href="{{route('driver_feedback')}}" class="menu-link">
									<span class="menu-text">{{ __('keywords.Delivery Boy') }} {{ __('keywords.Feedback') }}</span>
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
						<a href="{{route('user_callback_requests')}}" class="menu-link">
						
							<span class="menu-text">{{ __('keywords.Users') }} {{ __('keywords.Callback Requests') }}</span>
						</a>
					</div>
					<div class="menu-item">
						<a href="{{route('store_callback_requests')}}" class="menu-link">
						
							<span class="menu-text">{{ __('keywords.Stores') }} {{ __('keywords.Callback Requests') }}</span>
						</a>
					</div>
					
					<div class="menu-item">
						<a href="{{route('driver_callback_requests')}}" class="menu-link">
						
							<span class="menu-text">{{ __('keywords.Delivery Boy') }} {{ __('keywords.Callback Requests') }}</span>
						</a>
					</div>
						
						
						</div>
					</div>
			
				<div class="menu-divider"></div>
					<div class="menu-header">{{ __('keywords.Settings') }}</div>
					<div class="menu-item">
						<a href="{{route('app_details')}}" class="menu-link">
							<span class="menu-icon"><i class="fa fa-cog"></i></span>
							<span class="menu-text">{{ __('keywords.Settings') }}</span>
						</a>
					</div>
					<div class="menu-item">
						<a href="{{route('can_res_list')}}" class="menu-link">
							<span class="menu-icon"><i class="fa fa-list"></i></span>
							<span class="menu-text">{{ __('keywords.Cancelling Reasons') }}</span>
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
		

