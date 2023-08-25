<template>
  <div>
  <q-form class="q-pa-md" ref="form">
    <q-input v-model="state.formData.author" v-bind="attrs('author', 'Author')" />
    <q-input v-model="state.formData.quote" v-bind="attrs('quote', 'Quote')" />
    <q-input v-model="state.formData.subject" v-bind="attrs('subject', 'Subject')" />
    <q-input v-model="state.formData.quoted_on" type="date" v-bind="attrs('quoted_on', 'Quoted On')" />
    
    <qx-select
      v-model="state.formData.related" 
      options-url="/api/quotes"
      option-label="quote"
      option-value="id"
      emit-value
      map-options
      v-bind="attrs('related', 'Related Quote')"
    >
    </qx-select>
  </q-form>
  <q-btn
      color="primary"
      label="Submit"
      @click="save"
    />
  <q-btn
      color="primary"
      label="Update"
      @click="update"
    />
  {{state.formData}}
  {{ state.validationErrors }}
</div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import QxSelect from '../components/crud/QxSelect.vue';
import QxDate from '../components/crud/QxDate.vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()
const state = reactive({formData: {}, validationErrors: {}});
const refForm = ref(null)

onMounted(async () => {
  if(route.params.id) {
    let resp = await axios.get(`/api/quotes/${route.params.id}`)
    console.log(resp)
    state.formData = reactive(resp.data)
  }
})

const attrs = (fieldName, label) => {
  return {
    vModel: state.formData[fieldName],
    label: label,
    lazyRules: true,
    errorMessage: state.validationErrors[fieldName]?.join(', '),
    error: !!state.validationErrors[fieldName],
  }
}
const save = async () => {
  // refForm.validate()
  let resp = await axios.post('/api/quotes', state.formData)
  .catch(e => {
    state.validationErrors = e.response.data.errors
  })
  if(resp) {
    router.push({ name: 'quotes' })
  }
}

const update = async () => {
  // refForm.validate()
  let resp = await axios.put(`/api/quotes/${route.params.id}`, state.formData)
  .catch(e => {
    state.validationErrors = e.response.data.errors
  })
  if(resp) {
    router.push({ name: 'quotes' })
  }
}

</script>
<style lang="scss">
  
</style>
