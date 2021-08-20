@extends('shop.layouts.app')

@push('styles')

    <style>
        .product-title-list {
            margin-top: 20px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        @if (session('status'))
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        <div class="col-md-6 product-title-list">
            <h1>List Product</h1>
        </div>

        <div class="col-md-6 text-right product-title-list">
            <a href="{{ route('product.add') }}" class="btn btn-primary align-right">Add Product</a>
        </div>

        <div class="col-md-12">
            <table class="table table-bordered data-table">
                <thead>
                <tr>
                    <th>Thumb</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th width="100px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('product.ajax') }}",
                columns: [
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'category', name: 'category'},
                    {data: 'sub_category', name: 'sub_category'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            $(document).on('click','.delete',function(){

                var requestData = {
                    id : $(this).data('id')
                }
                console.log(requestData)

                $.ajax({
                    url: "{{ route('product.delete') }}",
                    type: "POST",
                    data: requestData,
                    success: function (response) {
                        if(response.code == 200 ) {
                            alert(response.msg)

                            table.ajax.reload();
                        }
                        else {
                            alert('Something went wrong!.Please try again')
                        }

                    }
                })
            })

        })



    </script>
@endpush
