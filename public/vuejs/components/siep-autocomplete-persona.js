Vue.component('siep-autocomplete-persona', {
  data: function () {
    return {
      error: null,
      selectbox:null,
      selectedValue: null
    }
  },
  props: [
    'name',
    'placeholder'
  ],
  template: `
            <div>
                <div class="form-group" style="margin:0">
                    <select id="alumno_id" class="form-control"></select>
                    <span class="help-block" v-if="error">{{ error }}</span>
                </div>
                <a href="javascript:;" class="pull-right" v-if="hasFilter" @click="resetFilter">remover</a>
                <br>
            </div>
            `,
  mounted () {
    this.selectbox = $("#alumno_id");
    this.prepareForm();
  },
  methods: {
    prepareForm: function () {
      let self = this;
      self.selectbox.select2({
        ajax: {
          url: this.$parent.apiUrl+"/inscripcion/find/persona",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              fullname: params.term
            };
          },
          processResults: function (data, params) {
            params.page = params.page || 1;

            /*var alumnos = _.transform(data, function(result, value, key) {
              result[key] = value.inscripcion.alumno;
            }, []);*/
            
            return {
              results: data,
              pagination: {
                more: (params.page * 30) < data.total_count
              }
            };
          },
          cache: true
        },
        placeholder: this.placeholder,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 1,
        templateResult: self.templateResult,
        templateSelection: self.templateSelection
      });

      self.selectbox.on('select2:select', function (e) {
        var data = e.params.data;
        self.selectedValue = data.inscripcion.alumno.id;
      });
    },
    templateResult(repo) {
      if (repo.loading) {return repo.text;}

      var markup = "<div class='select2-result-repository clearfix'>" +
          "<div class='select2-result-repository__meta'>";

      if(repo.inscripcion)
      {
        markup += "<div class='select2-result-repository__title'>" + repo.inscripcion.alumno.persona.nombre_completo + "</div>";
        markup += "<div class='select2-result-repository__description'>" + repo.inscripcion.alumno.persona.documento_tipo + ": " + repo.inscripcion.alumno.persona.documento_nro + "</div>";
      }

      markup += "</div></div>";

      return markup;
    },
    templateSelection(repo) {
      if(repo.inscripcion) {
        return repo.inscripcion.alumno.persona.nombre_completo;
      } else {
        return repo.text;
      }
    },

    setFilter() {
      this.$parent.filtro[this.name] = this.selectedValue;
      return this.selectedValue;
    },
    resetFilter() {
      this.selectedValue = null;
      this.$parent.filtro[this.name] = null;
      this.selectbox.val(null).trigger('change');
    },
  },
  computed: {
    hasFilter() {
      return this.setFilter();
    },
    hasError() {
      return this.error;
    }
  }
});