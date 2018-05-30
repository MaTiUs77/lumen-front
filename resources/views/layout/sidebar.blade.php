<section class="sidebar">
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVEGACION</li>
    <li class="active treeview menu-open">
      <a href="#">
        <i class="fa fa-bar-chart"></i> <span>Dir. de RRHH</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href="{{ url('rrhh/alumnos_nominal') }}"><i class="fa fa-circle-o"></i> Alumnos nominal</a>
        </li>
        <li>
          <a href="{{ url('rrhh/matriculas_por_seccion') }}"><i class="fa fa-circle-o"></i> Matriculas por seccion</a>
        </li>
      </ul>
    </li>
  </ul>
</section>
