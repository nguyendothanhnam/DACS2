@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê Slider Banner
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                    ?>
                    <thead>
                        <tr>
                            <th>Tên slide</th>
                            <th>Hình ảnh</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_slide as $key => $slide)
                            <tr>
                                <td>{{ $slide->slider_name }}</td>
                                <td><img src="public/uploads/slider/{{ $slide->slider_image }}" height="90" width="90" alt=""></td>
                                <td>{!! $slide->slider_desc !!}</td>
                                <td><span class="text-ellipsis">
                                <?php
                                    if ($slide ->slider_status == 0) {
                                        echo '<a href="'. URL::to ('/unactive-slider/'.$slide->slider_id).'"> <span class="fa-thumbs-styling fa fa-eye-slash"></span></a>';
                                    } else {
                                        echo '<a href="'. URL::to ('/active-slider/'.$slide->slider_id).'"><span class="fa-thumbs-styling fa fa-eye"></span></a>';
                                    }    
                                ?>
                                    </span></td>
                                <td>
                                    <a onclick="return confirm('Bạn có chắc muốn xóa slide này không?')" href="{{ URL::to('/delete-slider/'.$slide->slider_id) }}" class="active styling-edit" ui-toggle-class=""> 
                                        <i class="fa fa-trash-o text-danger text"></i>
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
                        
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li>{{ $all_slide->links() }}</li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
