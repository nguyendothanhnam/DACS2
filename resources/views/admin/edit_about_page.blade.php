@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Chỉnh sửa trang giới thiệu
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
                        <form role="form" action="{{ URL::to('/update-aboutpage') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung trang</label>
                                <textarea style="resize: none" rows="8" class="form-control ckeditor" name="about_desc"
                                    id="exampleInputPassword1" placeholder="Mô tả thương hiệu">{{ $about->page_desc }}</textarea>
                            </div>
                
                            <button type="submit" class="btn btn-info">Cập nhật trang</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    @endsection
