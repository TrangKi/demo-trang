@extends('master')
@section('content')

<div class="container">
	<div id="content" class="space-top-none">
		<div class="main-content">
			<div class="space60">&nbsp;</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="beta-products-list">
						<h4>Tìm kiếm</h4>
						<div class="beta-products-details">
							<p class="pull-left">Tìm thấy {{count($product)}} sản phẩm</p>
							<div class="clearfix"></div>
						</div>

						<div class="row searchResult">
						@foreach($product as $new)
							<div class="col-sm-3" style="padding: 10px">
								<div class="single-item">
								@if($new->discount != 0)
									<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
								@endif
									<div class="single-item-header">
										<a href="{{route('chitietsanpham',$new->id)}}">
											@if (strpos($new->image, 'lorempixel.com'))
												<img src="{!! $new->image !!}" alt="" height="250px"></a>
											@else
												<img src="upload/images/product/{{$new->image}}" alt="" height="250px"></a>
											@endif
										</a>
									</div>
									<div class="single-item-body">
										<p class="single-item-title">{{$new->name}}</p>
										<p class="single-item-price" style="font-size: 18px">
										@if($new->discount==0)
											<span class="flash-sale">{{number_format($new->unit_price)}} đồng</span>
										@else
											<span class="flash-del">{{number_format($new->unit_price)}} đồng</span>
											<span class="flash-sale">{{number_format($new->unit_price - $new->unit_price * $new->discount/100)}} đồng</span>
										@endif
										</p>
									</div>
									<div class="single-item-caption">
										<a href="javascript:void(0)" class="add-to-cart pull-left"
											data-id="{{ $new->id }}">
											<i class="fa fa-shopping-cart"></i>
										</a>
										<a class="beta-btn primary" href="{{route('chitietsanpham',$new->id)}}">Chi tiết <i class="fa fa-chevron-right"></i></a>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						@endforeach
						</div>
						<div class="clearfix"></div>
						<div class="space60">&nbsp;</div>

					</div> <!-- .beta-products-list -->
				</div>
			</div> <!-- end section with sidebar and main content -->
		</div> <!-- .main-content -->
	</div> <!-- #content -->
@endsection