<!--导航条-->
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Zongzhi-Cui</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{route('event.index')}}">最新活动 <span class="sr-only">(current)</span></a></li>
                <li><a href="{{route('shop_business.show',\Illuminate\Support\Facades\Auth::user())}}">我的店铺</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">店铺设置<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{route('foodcate.index')}}">菜品分类</a></li>
                        <li><a href="{{route('food.index')}}">菜品</a></li>
                        <li><a href="{{route('order')}}">订单列表</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route('order.count')}}">订单统计</a></li>
                        <li><a href="{{route('food.count')}}">菜品统计</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="/">旧版活动</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="搜索">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                {{--data-toggle="modal" data-target="#myModal"--}}
                @guest
                    <li><a href="#" id="click_a"  data-toggle="modal" data-target="#myModal">登录我的商铺</a></li>
                    <li><a href="{{ route('register1') }}">注册商户</a></li>
                    <li>&emsp;</li>
                @endguest
                @auth
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ \Illuminate\Support\Facades\Auth::user()->email }}<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('shop_user.edit',\Illuminate\Support\Facades\Auth::user())}}">修改密码</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <form action="{{route('logout1')}}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-link">退出登录</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>