@verbatim
<div class="navbar-custom-menu">
  <ul class="nav navbar-nav" id="siepauth" v-cloak>
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-user"></i>
        <span class="hidden-xs">Bienvenido, <b>{{ userdata.username }}</b></span>
      </a>
      <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
          <p>
            {{ userdata.puesto }}
            <small>{{ userdata.email }}</small>
            <label class="label label-default">{{ userdata.role }}</label>
          </p>

          <p>
            {{ userdata.centro.nombre }}
            <small>{{ userdata.centro.nivel_servicio }}</small>
          </p>

        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="pull-right">
            <button class="btn btn-success btn-flat" @click="logout">Cerrar sesión</button>
          </div>
        </li>
      </ul>
    </li>
  </ul>
</div>
@endverbatim
