<template>
  <q-btn flat round size="md" icon="mdi-magnify">
    <q-menu anchor="bottom middle" self="top middle">
      <q-list style="min-width: 300px">
        <q-item
          v-for="(field, index) in filterables"
          :key="index"
        >
          <q-item-section>
              

                <qx-select
                    :ref="`${field.name}`"
                    v-if="field.form_input == 'select'"
                    :label="field.label"
                    :emit-value="field.label !== false"
                    :modelValue="modelValue[field.name]"
                    @update:modelValue="emitFormData($event, field.name)"
                    :optionsUrl="field.inputOptions.itemsUrl"
                    :optionValue="field.inputOptions.itemValue"
                    :optionLabel="field.inputOptions.itemText"
                    :error-messages="validationErrors[field.name]"
                    map-options
                ></qx-select>
                <q-input
                    v-if="['text', 'password', 'textarea', 'email', 'search', 'tel', 'number', 'url'].includes(field.form_input)"
                    :label="field.label"
                    v-model="formData[field.name]"
                    @keyup.enter="emitFormData(formData[field.name], field.name)"
                    :error-messages="validationErrors[field.name]"
                    :type="field.form_input"
                ></q-input>


          </q-item-section>
        </q-item>
        <q-separator />
        <q-item clickable v-close-popup @click="reset">
          Clear
        </q-item>
      </q-list>
    </q-menu>
  </q-btn>
</template>

<script>

export default {
  components: { 
  },
  name: "QxFormPage",
  props: [
      'filterables',
      'modelValue'
  ],
  data() {
    return {
      formData: {},
      validationErrors: {}
    }
  },
  methods:  {
    emitFormData($event, fieldName) {
      let tempObj = {}
      tempObj[fieldName] = $event
      let data = Object.assign({}, this.modelValue, tempObj);
      this.$emit('update:modelValue', data)
    },
    reset() {
        this.formData = {}
      this.$emit('resetFilters')
      this.$router.push({query: {}})
    },
  }
}

</script>

<style scoped></style>
