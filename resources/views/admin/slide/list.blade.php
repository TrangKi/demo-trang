@extends('admin.layout.index')

@section('content')

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Danh sách sản phẩm
                    <!-- <small>Danh sách</small> -->
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="clear:both"></div>
            @if(Session::has('thanhcong'))
                <div class="alert alert-success">{{Session::get('thanhcong')}}</div>
            @endif
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Loại sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Nội dung bài viết</th>
                        <th>Giá</th>
                        <th>Giá KM</th>
                        <th>Ảnh</th>
                        <th>Đơn vị</th>
                        <th>Còn tồn</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product as $product_item)
                    <tr class="odd gradeX" align="center">
                        <td>{{ $product_item->id}}</td>
                        <td>{{ $product_item->name}}</td>
                        <td>{{ $product_item->id_type}}</td>
                        <td>{{ $product_item->description}}</td>
                        <td>{{ $product_item->content}}</td>
                        <td>{{ $product_item->unit_price}}</td>
                        <td>{{ $product_item->promotion_price}}</td>
                        <td>{{ $product_item->image}}</td>
                        <td>{{ $product_item->unit}}</td>
                        <td>{{ $product_item->new}}</td>
                        <td>{{ $product_item->created_at}}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/product/delete/{{$product_item->id}}"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/product/edit/{{$product_item->id}}">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

@endsection