<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Siep | Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('adminlte/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('adminlte/dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ url('adminlte/dist/css/skins/_all-skins.min.css') }}">

  <link rel="stylesheet" href="{{ url('adminlte/bower_components/select2/dist/css/select2.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style type="text/css">
    [v-cloak] {
      display: none;
    }
  </style>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box" id="login" v-cloak>
  <div class="login-logo">
    <a href="#"><b>Siep</b>Admin</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Complete los datos para ingresar al sistema</p>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Nombre de usuario" v-model="logindata.username">
        <span class="fa fa-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Contraseña" v-model="logindata.password">
        <span class="fa fa-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button class="btn btn-primary btn-block btn-flat" @click="requestLogin()">Ingresar</button>
        </div>
        <!-- /.col -->
      </div>
@verbatim
    <p class="login-box-msg">{{ error }}</p>
  @endverbatim
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<!-- VueAmbience -->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

<script>
  var login = new Vue({
    el: '#login',
    data: {
      logindata:{
        username:null,
        password:null
      },

      apiUrl: `{{ env('API_GATEWAY') }}/auth`,

      loading: true,
      error: ''
    },
    mounted () {
      var vm = this;
      vm.loggedin();
    },
    methods: {
      requestLogin: function () {
        var vm = this;
        vm.loading = {};
        localStorage.removeItem('sieptoken');

        axios.post(vm.apiUrl+'/login', vm.logindata)
            .then(function(response){
              let rdata= response.data;

              if(rdata.token)
              {
                localStorage.setItem('sieptoken', rdata.token);
                window.location.href="{{ url('/') }}";
              }

              vm.loading = false;
            })
            .catch(function (error) {
              vm.error = error.message;
              vm.loading = false;
            });
      },
      loggedin: function () {
       /* let token = localStorage.getItem('sieptoken');
        if(token)
        {
         window.location.href="{{ url('/') }}";
        }*/
      }
    }
  });
</script>

</body>
</html>
