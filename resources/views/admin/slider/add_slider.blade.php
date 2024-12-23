@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm Slider
                </header>
                <?php
                    $message = Session::get('message');
                    if ($message) {
                        echo '<span class="text-alert">' . $message . '</span>';
                        Session::put('message', null);
                    }
                    ?>
                <div class="panel-body">
                    
                    <div class="position-center">
                        <form role="form" action="{{ URL::to('/insert-slider') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên slide</label>
                                <input type="text" name="slider_name" class="form-control" data-validation="required"
                                    id="exampleInputEmail1" placeholder="Tên slide">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hình ảnh</label>
                                <input type="file" name="slider_image" class="form-control" data-validation="required"
                                    id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả</label>
                                <textarea style="resize: none" rows="8" class="form-control ckeditor" name="slider_desc"
                                    id="exampleInputPassword1" placeholder="Mô tả slide"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Trạng thái</label>
                                <select name="slider_status" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện</option>
                                </select>
                            </div>
                            <button type="submit" name="add_slider" class="btn btn-info">Thêm slide</button>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    @endsection
