@extends('layout.adminlte')

@section('body')
	@verbatim
      <!-- Info boxes -->
      <div class="row" id="app" v-cloak>
          <div class="col-md-9">
              <div class="box box-solid box-default">
                  <div class="box-header with-border">
                      <h3 class="box-title">Alumnos nominal</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <table class="table">
                          <thead>
                          <tr>
                              <th>Centro</th>
                              <th>Nivel de servicio</th>
                              <th>Nombre</th>
                              <th>Dni</th>
                              <th>Año</th>
                              <th>Division</th>
                              <th>Turno</th>
                              <th>Fecha Alta</th>
                              <th>Fecha Baja</th>
                              <th>Fecha Egreso</th>
                          </tr>
                          </thead>
                          <tbody v-if="!loading">
                          <tr v-for="item in data">
                              <td>{{ item.centro }}</td>
                              <td>{{ item.nivel_servicio }}</td>
                              <td>{{ item.nombre_completo}}</td>
                              <td>{{ item.dni }}</td>
                              <td>{{ item.año }}</td>
                              <td>{{ item.division }}</td>
                              <td>{{ item.turno }}</td>
                              <td>{{ item.fecha_alta }}</td>
                              <td>{{ item.fecha_baja }}</td>
                              <td>{{ item.fecha_egreso }}</td>
                          </tr>
                          </tbody>
                      </table>
                  </div>

                  <div class="box-footer clearfix">
                      <ul class="pagination pagination-sm">
                          <li v-for="num in pagination.render" :class="{active : pagination.current_page == num}">
                              <a href="javascript:;" v-on:click="aplicarFiltro(num)">{{ num }}</a>
                          </li>
                      </ul>
                  </div>

                  <div class="overlay" v-if="loading">
                      <i class="fa fa-refresh fa-spin"></i>
                  </div>
              </div>
          </div>

          <div class="col-md-3">
              <div class="box box-solid box-primary">
                  <div class="box-header with-border">
                      <h3 class="box-title">Opciones</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <siep-autocomplete-persona
                              name="alumno_id"
                              placeholder="Buscar persona"></siep-autocomplete-persona>

                      <siep-autocomplete
                              api-form="centros"
                              name="centro_id"></siep-autocomplete>

                      <h5>Filtrar Ciclo</h5>

                      <siep-selectbox v-model="filtro.ciclo" name="ciclo" api-form="ciclos" option-value="nombre"></siep-selectbox>
                      <siep-selectbox v-model="filtro.ciudad" name="ciudad" api-form="ciudades" option-value="nombre"></siep-selectbox>
                      <siep-selectbox v-model="filtro.sector" name="sector" api-form="sectores" option-value="sector"></siep-selectbox>
                      <siep-selectbox v-model="filtro.nivel_servicio" name="nivel_servicio" api-form="niveles" option-value="nivel_servicio"></siep-selectbox>
                      <siep-selectbox v-model="filtro.division" name="division" api-form="divisiones" option-value="division"></siep-selectbox>
                      <siep-selectbox v-model="filtro.turno" name="turno" api-form="turnos" option-value="turno"></siep-selectbox>
                      <siep-selectbox v-model="filtro.tipo" name="tipo" api-form="tipos" option-value="tipo"></siep-selectbox>
                      <siep-selectbox v-model="filtro.anio" name="anio" api-form="años" option-custom="- Seleccionar año -" option-value="anio"></siep-selectbox>

                      <button class="btn btn-success btn-block" v-on:click="aplicarFiltro">Aplicar filtros</button>
                      <button class="btn btn-danger btn-block" v-on:click="filtro = {}">Remover filtros</button>
                  </div>
              </div>
              <!-- /.box -->
          </div>

      </div>
      <!-- /.row -->
	@endverbatim
@endsection

@section('footer')
    <script src="{{ url('vuejs/components/siep-selectbox.js') }}"></script>
    <script src="{{ url('vuejs/components/siep-autocomplete.js') }}"></script>
    <script src="{{ url('vuejs/components/siep-autocomplete-persona.js') }}"></script>
    <script>

        var app = new Vue({
            el: '#app',
            data: {
                data: [],
                pagination: [],
                filtro: {
                    ciclo: 2018
                },

                apiUrl: `{{ env('API_HOST') }}/api`,
                apiForms: `{{ env('API_HOST') }}/api/forms`,

                loading: true,
                error: ''
            },
            mounted () {
                this.nominalAlumnosInscriptos();
            },
            methods: {
                aplicarFiltro: function (num) {
                    if(num) { this.filtro.page = num; }
                    this.nominalAlumnosInscriptos();
                },
                renderPagination: function() {
                    var self = this;
                    var paginas = _.range(1,self.pagination.last_page+1);
                    self.pagination.render = paginas;
                },
                nominalAlumnosInscriptos: function () {
                    var self = this;
                    self.loading = true;

                    axios.get('{{ env('API_HOST') }}/api/dependencia/rrhh/nominal_alumnos_inscriptos',{
                        params: self.filtro
                    })
                    .then(function(response){

                        /*                        // Formatea el array, genera un agrupamiento por categoria.nombre
                         self.data = _.transform(response.data, function(result, item, key) {
                         (result[item.nombre] || (result[item.nombre] = [])).push(item);
                         }, {});*/

                        self.data = response.data.data;
                        self.pagination = _.omit(response.data,'data');
                        self.renderPagination();

                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.error = error.message;
                        self.loading = false;
                    });
                }
            }
        });
    </script>
@append
