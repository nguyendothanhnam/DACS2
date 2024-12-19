@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê đơn hàng
            </div>
            <div class="row w3-res-tb">
                
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session('message', null);
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã đơn hàng</th>
                            <th>Tình trạng đơn hàng</th>
                            
                            <th>Thời gian</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @php
                            $i = 0;
                        @endphp --}}
                        @foreach ($order as $key => $ord)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ord->order_code }}</td>
                                <td>
                                    @if ($ord -> order_status == 1)
                                    Đơn hàng chưa xử lý
                                    @elseif ($ord -> order_status == 2)
                                    Đơn hàng đã xử lý - Đang giao hàng
                                    @else
                                    Đơn hàng đã hủy - tạm giữ
                                    @endif
                                </td>

                                <td>
                                    <span class="text-ellipsis">
                                        {{ \Carbon\Carbon::parse($ord->created_at)->format('d/m/Y H:i:s') }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ asset('/view-order/'.$ord->order_code) }}" class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-eye text-success text-active"></i>
                                    </a>
                                    <a onclick="return confirm('Bạn có chắc muốn xóa thư mục này không?')" href="{{ asset('/delete-order/'.$ord->order_code) }}" class="active styling-edit" ui-toggle-class=""> 
                                        <i class="fa fa-trash text-danger text"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm"></small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li>{{ $order->links() }}</li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
