@extends('layout.default')
@section('title','添加')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 bg-info">
            <a class="btn btn-group" href="{{ route('shop_business.show',compact('shop_business')) }}">查看信息</a>
            <p>商铺名称::{{$shop_business->shop_name}}</p>
            <form action="{{ route('shop_business.update',compact('shop_business')) }}" method="post" enctype="multipart/form-data">
                <br>
                店铺LOGO:
                <div class="form-group">
                    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
                    <div id="uploader-demo">
                        <div id="fileList" class="uploader-list"></div>
                        <div id="filePicker">选择图片</div>
                        <img src="" id="img" alt="">
                    </div>
                    <input type="hidden" name="logo" id="logo">
                </div>

                店铺评分:<input class="form-control" type="text" name="shop_rating" value="{{$shop_business->shop_rating}}" placeholder="店铺评分"><br>

                <label>是否品牌:<input {{$shop_business->brand==0?'':'checked'}} class="form-control" type="checkbox" name="brand" value="1"></label>
                <label>是否准时:<input {{$shop_business->on_time==0?'':'checked'}} class="form-control" type="checkbox" name="on_time" value="1"></label>
                <label>是否蜂鸟:<input {{$shop_business->fengniao==0?'':'checked'}} class="form-control" type="checkbox" name="fengniao" value="1"></label>
                <label>是否保标:<input {{$shop_business->bao==0?'':'checked'}} class="form-control" type="checkbox" name="bao" value="1"></label>
                <label>是否票标:<input {{$shop_business->piao==0?'':'checked'}} class="form-control" type="checkbox" name="piao" value="1"></label>
                <label>是否准标:<input {{$shop_business->zhun==0?'':'checked'}} class="form-control" type="checkbox" name="zhun" value="1"></label><br>

                起送金额:<input class="form-control" type="number" name="start_send" value="{{$shop_business->start_send}}" placeholder="起送金额"><br>
                配送费用:<input class="form-control" type="number" name="send_cost" value="{{$shop_business->send_cost}}" placeholder="配送费用"><br>
                预计时间:<input class="form-control" type="number" name="estimate_time" value="{{$shop_business->estimate_time}}" placeholder="预计时间"><br>
                小店公告:<textarea class="form-control" name="notice">{{$shop_business->notice}}</textarea><br>
                优惠信息:<textarea class="form-control" name="discount">{{$shop_business->discount}}</textarea><br>
                <input class="form-control" type="submit"><br>
                {{ csrf_field() }}
                {{ method_field('PUT') }}
            </form>
        </div>
        <div class="col-sm-3" style="position: relative"><img style="position: absolute;right: 17px;top: 0;" src="{{$shop_business->shop_img}}" alt=""></div>
    </div>
@endsection

@section('jquery')
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
    <script>
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: '/webuploader/Uploader.swf',

            // 文件接收服务端。
            server: '/upload',
            formData: {
                '_token':'{{csrf_token()}}',
                'width':260,
                'height':270,
            },

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        //文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,response ) {
//        $( '#'+file.id ).addClass('upload-state-done');
            var url = response.url;
            $('#img').attr('src',url);
            $('#logo').val(url);
        });
    </script>
@stop