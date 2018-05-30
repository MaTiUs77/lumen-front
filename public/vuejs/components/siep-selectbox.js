Vue.component('siep-selectbox', {
  data: function () {
    return {
      lista: [],
      error: null
    }
  },
  props: [
    'value',
    'optionValue',
    'optionText',
    'optionCustom',
    'apiForm',
    'name',
    'route',
  ],
  template: `
            <div>
                <div class="form-group" :class="{ 'has-success' : value, 'has-error' : hasError }" style="margin:0">
                    <select class="form-control" v-bind:value="value" @input="$emit('input', $event.target.value)">
                        <option :value="null">{{ optionCustom  || '- Seleccionar ' +name+ ' -' }}</option>
                        <option v-for="item in lista" :value="item[optionValue]" v-text="item[optionText || optionValue]"></option>
                    </select>
                    <span class="help-block" v-if="error">{{ error }}</span>
                </div>
                <a href="javascript:;" class="pull-right" v-if="hasFilter" @click="resetFilter">remover</a>
                <br>
            </div>
            `,
  mounted () {
    this.formOption(this.apiForm);
  },
  methods: {
    formOption: function (route) {
      var self = this;
      axios.get(this.$parent.apiForms +'/'+ route)
          .then(function (response) {
            self.lista = response.data;
          })
          .catch(function (error) {
            self.error = error.message;
          });
    },
    resetFilter() {
      this.$parent.filtro[this.name] = null;
    }
  },
  computed: {
    hasFilter() {
      return this.$parent.filtro[this.name];
    },
    hasError() {
      return this.error;
    }
  }
});