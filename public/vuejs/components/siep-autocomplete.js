Vue.component('siep-autocomplete', {
  props: [
    'value',
    'apiForm',
    'name',
    'selectedValue'
  ],
  template: `
      <div>
          <select class="form-control"></select>
          <a href="javascript:;" class="pull-right" v-if="selectedValue" @click="resetFilter">remover</a>
      </div>
        `,
  mounted: function () {
    var vm = this;
    vm.selectbox = $(vm.$el).find('select');

    axios.get(this.$parent.apiForms +'/'+vm.apiForm)
        .then(function (response) {
          vm.lista = _.map(response.data, function(value, index) {
            return {
              id: value.id,
              text: value.nombre
            }
          }, {});

          vm.selectbox.select2({
            data: vm.lista,
            placeholder: vm.placeholder
          })
              .val(vm.value)
              .trigger('change')
              // emit event on change.
              .on('change', function () {
                vm.selectedValue = this.value;
                vm.$parent.filtro[vm.name] = vm.selectedValue;
              });

        })
        .catch(function (error) {
          vm.error = error.message;
        });

  },
  methods: {
    resetFilter() {
      this.selectedValue = null;
      this.$parent.filtro[this.name] = null;
      this.selectbox.val(null).trigger('change');
    },
  }
});