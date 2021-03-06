@extends('master')
@section('content')
	<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Sản phẩm {{$sanpham->name}}</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="{{route('trang-chu')}}">Trang chủ</a> / <span>Thông tin chi tiết sản phẩm</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<div class="container">
		<div id="content">
			<div class="row">
				<div class="col-sm-9">

					<div class="row">
						<div class="col-sm-4">
							@if (strpos($sanpham->image, 'lorempixel.com'))
								<img src="{!! $sanpham->image !!}" alt="" height="250px">
							@else
								<img src="upload/images/product/{{$sanpham->image}}" 
									alt="" height="250px">
							@endif
						</div>
						<div class="col-sm-8">
							<div class="single-item-body">
								<p class="single-item-title"><h2>{{$sanpham->name}}</h2></p>
								<p class="single-item-price">
									@if($sanpham->discount==0)
										<span class="flash-sale">{{number_format($sanpham->unit_price)}} đồng</span>
									@else
										<span class="flash-del">{{number_format($sanpham->unit_price)}} đồng</span>
										<span class="flash-sale">{{number_format($sanpham->unit_price - $sanpham->unit_price * $sanpham->discount/100)}} đồng</span>
									@endif
								</p>
							</div>

							<div class="clearfix"></div>
							<div class="space20">&nbsp;</div>

							<div class="single-item-desc">
								<p>{{$sanpham->description}}</p>
							</div>
							<div class="space20">&nbsp;</div>

							<div class="avarible-product" style="margin-bottom: 20px;">
                            	<span class="sum">
                        			Còn {{ $sanpham->quantity }} sản phẩm
                        		</span> 
                    		</div>

							<div class="single-item-options">
								<div class="quantity-spinner">
									<span>Chọn số lượng: </span>
                					<div style="font-size: 18px; font-weight: bold;">
			                        <a href="javascript:void(0)" class="operator operator-minus">-</a>
			                      	<span class="number" style="margin-left: 10px; margin-right: 10px;">1</span>
			                      	<a href="javascript:void(0)" class="operator operator-add">+</a>
			                  		</div>
			                	</div>
 
								<a href="javascript:void(0)" class="add-to-cart pull-left"
									data-id="{{ $sanpham->id }}">
									<i class="fa fa-shopping-cart"></i>
								</a>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>

					<div class="space40">&nbsp;</div>
					<div class="woocommerce-tabs">
						<ul class="tabs">
							<li><a href="#tab-description">Mô tả</a></li>
						</ul>

						<div class="panel" id="tab-description">
							<p>{{$sanpham->content}}</p>
						</div>
					</div>
					<div class="space50">&nbsp;</div>
					<div class="beta-products-list">
						<h4>Sản phẩm tương tự</h4>

						<div class="row">
						@foreach($sp_tuongtu as $sptt)
							<div class="col-sm-4">
								<div class="single-item">
									@if($sptt->discount!=0)
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
									@endif
									<div class="single-item-header">
										<a class="pull-left" href="{{route('chitietsanpham',$sptt->id)}}">
										@if (strpos($sptt->image, 'lorempixel.com'))
											<img src="{!! $sptt->image !!}" alt="" height="250px">
										@else
											<img src="upload/images/product/{{$sptt->image}}" alt="" height="250px">
										@endif
										</a>
									</div>
									<div class="single-item-body">
										<p class="single-item-title">{{$sptt->name}}</p>
										<p class="single-item-price" style="font-size: 18px">
											@if($sptt->discount==0)
												<span class="flash-sale">{{number_format($sanpham->unit_price)}} đồng</span>
											@else
												<span class="flash-del">{{number_format($sanpham->unit_price)}} đồng</span>
												<span class="flash-sale">{{number_format($sptt->unit_price - $sptt->unit_price * $sptt->discount/100)}} đồng</span>
											@endif
										</p>
									</div>
									<div class="single-item-caption">
										<a class="add-to-cart pull-left" href="{{route('cart.addItem')}}"><i class="fa fa-shopping-cart"></i></a>
										<a class="beta-btn primary" href="{{route('chitietsanpham',$sptt->id)}}">Chi tiết <i class="fa fa-chevron-right"></i></a>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						@endforeach
						</div>
						{{-- <div class="row">{{$sp_tuongtu->links()}}</div> --}}
					</div> <!-- .beta-products-list -->
				</div>
				<div class="col-sm-3 aside">
					<div class="widget">
						<h3 class="widget-title">Sản phẩm mới</h3>
						<div class="widget-body">
							<div class="beta-sales beta-lists">
								@foreach($new_product as $new_product_item) 
								<div class="media beta-sales-item">
									<a class="pull-left" href="{{route('chitietsanpham',$new_product_item->id)}}">
										@if (strpos($new_product_item->image, 'lorempixel.com'))
											<img src="{!! $new_product_item->image !!}" alt="" height="250px">
										@else
											<img src="upload/images/product/{{$new_product_item->image}}" alt="" height="250px">
										@endif
									</a>
									<div class="media-body">
										{{$new_product_item->name}}
										@if($new_product_item->discount==0)
											<span class="flash-sale">{{number_format($new_product_item->unit_price)}} đồng</span>
										@else
											<span class="flash-del">{{number_format($new_product_item->unit_price)}} đồng</span>
											<span class="flash-sale">{{number_format($new_product_item->unit_price - $new_product_item->unit_price * $new_product_item->discount/100)}} đồng</span>
										@endif
									</div>
								</div>
								@endforeach
							</div>
						</div>
					</div> <!-- best sellers widget -->
				</div>
			</div>
		</div> <!-- #content -->
	</div> <!-- .container -->

<script src="{!! asset("source/assets/dest/js/jquery.js") !!}"></script>
<script type="text/javascript" src="{!! asset('js/cart.js') !!}"></script>
<script type="text/javascript">
    var cart = new cart;
    cart.init();
</script>
@endsection
