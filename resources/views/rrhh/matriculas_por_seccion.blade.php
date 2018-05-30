@extends('layout.adminlte')

@section('body')
	@verbatim
      <!-- Info boxes -->
      <div class="row" id="app">
          <div class="col-md-9">
              <div class="col-sm-12" v-if="loading">
                  <h3>Descargando informacion, espere...</h3>
              </div>

              <div class="box box-solid box-default" v-if="!loading">
                  <div class="box-header with-border">
                      <h3 class="box-title">Matriculas por seccion</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                      <table class="table table-striped table-bordered">
                          <thead>
                          <tr>
                              <th>Centro</th>
                              <th>Año</th>
                              <th>Division</th>
                              <th>Turno</th>
                              <th>Matriculas</th>
                              <th>Vacantes</th>
                              <th>Varones</th>
                              <th>Ciudad</th>
                          </tr>
                          </thead>
                          <tbody v-if="!loading">
                          <tr v-for="item in data">
                              <td>
                                  {{ item.nombre }}
                                  <small>{{ item.cue}}</small>
                              </td>
                              <td>{{ item.anio }}</td>
                              <td>{{ item.division }}</td>
                              <td>{{ item.turno }}</td>
                              <td>{{ item.matriculas }}</td>
                              <td>{{ item.vacantes }}</td>
                              <td>{{ item.varones }}</td>
                              <td>{{ item.ciudad }}</td>
                          </tr>
                          </tbody>
                      </table>

                  </div>
              </div>
          </div>

          <div class="col-md-3">
              <div class="box box-solid box-default">
                  <div class="box-header with-border">
                      <h3 class="box-title">Opciones</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">

                      <h5>Filtros de Centro</h5>
                      <select class="form-control autocompletar" placeholder="Buscar establecimiento">
                      </select>
                      <br><br>

                      <select class="form-control">
                          <option>- Seleccionar ciudad -</option>
                          <option v-for="item in ciudades" value="{item.id}">{{ item.nombre }}</option>
                      </select>

                      <br>

                      <select class="form-control">
                          <option>- Seleccionar sector -</option>
                          <option v-for="item in sectores" value="{item.sector}">{{ item.sector }}</option>
                      </select>

                      <br>

                      <select class="form-control">
                          <option>- Seleccionar nivel -</option>
                          <option v-for="item in niveles" value="{item.nivel_servicio}">{{ item.nivel_servicio }}</option>
                      </select>

                      <br>

                      <h5>Filtros de Curso</h5>
                      <select class="form-control">
                          <option>- Seleccionar año -</option>
                      </select>

                      <br>
                      <select class="form-control">
                          <option>- Seleccionar division -</option>
                      </select>

                      <br>
                      <select class="form-control">
                          <option>- Seleccionar turno -</option>
                      </select>

                      <br>
                      <select class="form-control">
                          <option>- Seleccionar tipo -</option>
                      </select>
                  </div>
              </div>
              <!-- /.box -->
          </div>

      </div>
      <!-- /.row -->
	@endverbatim
@endsection

@section('footer')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                data: [],
                periodo: [],
                ciudades: [],
                sectores: [],
                niveles: [],
                loading: true,
                error: ''
            },
            mounted () {
                var self = this;
                this.formCiudades();
                this.formSectores();
                this.formNiveles();
                axios
                    .get('{{ env('API_HOST') }}/api/matriculas/cuantitativa/por_seccion?ciclo=2018')
                    .then(function(response){

/*                        // Formatea el array, genera un agrupamiento por categoria.nombre
                        self.data = _.transform(response.data, function(result, item, key) {
                            (result[item.nombre] || (result[item.nombre] = [])).push(item);
                        }, {});*/

                        self.data = response.data.data;

                        self.loading = false;
                    })
                    .catch(function (error) {
                        self.error = error.message;
                    });
            },
            methods: {
                formCiudades: function () {
                    var self = this;
                    axios
                        .get('{{ env('API_HOST') }}/api/forms/ciudades')
                        .then(function(response){
                            self.ciudades = response.data;
                        })
                        .catch(function (error) {
                            self.error = error.message;
                        });
                },
                formSectores: function () {
                    var self = this;
                    axios
                            .get('{{ env('API_HOST') }}/api/forms/sectores')
                            .then(function(response){
                                self.sectores = response.data;
                            })
                            .catch(function (error) {
                                self.error = error.message;
                            });
                },
                formNiveles: function () {
                    var self = this;
                    axios
                            .get('{{ env('API_HOST') }}/api/forms/niveles')
                            .then(function(response){
                                self.niveles = response.data;
                            })
                            .catch(function (error) {
                                self.error = error.message;
                            });
                }
            }
        })

        $(document).ready(function() {
            $('.autocompletar').select2();
        });
    </script>
@append
