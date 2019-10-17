@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<ul class="nav nav-tabs nav-bordered" role="tablist">
    <li role="presentation" class="nav-item">
        <a href="#tab_profile" class="nav-link active" aria-controls="tab_profile" role="tab" data-toggle="tab" aria-selected="true">Профиль</a>
    </li>
    <li role="presentation" class="nav-item">
        <a href="#tab_email" class="nav-link" aria-controls="tab_email" role="tab" data-toggle="tab" aria-selected="false">Почта</a>
    </li>
</ul>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab_profile">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf()
            <div>
                <h3><center>{{ Auth::user()->getFullName() }}</center></h3>
                <br>
                <div id="cropContainerEyecandy"></div>
                <div class="form-group member_photo">
                    <img src="{{ asset(Auth::user()->getPhoto()) }}" class="img-circle croppedImg" id="user-photo" alt="User Image">
                    <i class="fa fa-camera" id="member_photo"></i>
                 </div>
                <div class="form-group required">
                    <label class="control-label" for="name-input">Имя:</label>
                    <input type="text" name="name" class="form-control" id="name-input" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group required">
                    <label class="control-label" for="name-input">Фамилия:</label>
                    <input type="text" name="surname" class="form-control" id="surname-input" value="{{ Auth::user()->surname }}">
                </div>

                <div class="form-group required">
                    <label class="control-label" for="name-input">Дата рождения:</label>
                </div>
                <div class="input-group date" id="datepicker">
                    <input type="text" name="birth" class="form-control" value="{{ Auth::user()->birth }}">
                    <span class="input-group-addon">
                        <span class="glyphicon-calendar glyphicon"></span>
                    </span>
                </div>
                <div class="form-group"><br>
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
                <input type="hidden" name="photo" id="input-photo">
            </div>
        </form>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab_email">
        <div class="form-group">
            <label for="email_login" class="control-label">Эл. почта (Логин)</label>
            <input type="text" class="form-control" name="email_login" value="demo@demo.perfectum.in.ua">
        </div>
        <div class="form-group">
            <label for="email_password" class="control-label">Пароль</label>
            <input type="password" class="form-control" name="email_password" value="">
        </div>
    </div>
</div>

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    <link rel="stylesheet" href="{{ asset('css/croppic.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
    <!-- <link href="{{ asset('vendor/eonasdan/bootstrap-datepicker/build/css/bootstrap-datepicker.min.css')}}" rel="stylesheet"/> -->

    @stack('css')
    @yield('css')
@stop

@section('adminlte_js')
    <script src="{{ asset('js/croppic.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
   <!--  <script src="{{ asset('vendor/eonasdan/bootstrap-datepicker/build/js/bootstrap-datepicker.min.js')}}"></script> -->
    <script>
        var croppicContainerEyecandyOptions = {
            processInline: true,
            cropUrl:'{{ route("crop.photo") }}',
            modal: true,
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            customUploadButtonId: "member_photo",
            outputUrlId: 'user-photo',
            modalHeight: 350,
            modalWidth: 350,
            onAfterImgCrop: function() {
                $('#input-photo').val($('#user-photo').attr('src'));
            }
        }
        
        var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);
    </script>
    <style type="text/css">
        #test {
            width: 200px;
            height: 150px;
            position:relative;
        }
    </style>
    
    <script type="text/javascript">
       $('#datepicker').datepicker({
               weekStart: 1,
               daysOfWeekHighlighted: "6,0",
               autoclose: true,
               format: 'yyyy-mm-dd',
           });
    </script>

    @stack('js')
    @yield('js')
@stop