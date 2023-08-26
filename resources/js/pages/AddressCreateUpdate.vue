<template>
  <div>
  <q-form class="q-pa-md" ref="form">
    <q-input v-model="state.formData.house_name" v-bind="attrs('house_name', 'House name')" />
    <q-input v-model="state.formData.street" v-bind="attrs('street', 'Street')" />
    
    <qx-select
      v-model="state.formData.island_id" 
      options-url="/api/islands"
      option-label="island_name"
      option-value="id"
      emit-value
      map-options
      v-bind="attrs('island_id', 'Island')"
    >
    </qx-select>
  </q-form>
  <q-btn
      v-if="!route.params.id"
      color="primary"
      label="Submit"
      @click="save"
    />
  <q-btn
      v-else
      color="primary"
      label="Update"
      @click="update"
    />
    <hr />
    {{state.formData}}
  <hr />
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
  let resp = await axios.post('/api/addresses', state.formData)
  .catch(e => {
    state.validationErrors = e.response.data.errors
  })
  if(resp) {
    router.push({ name: 'addresses' })
  }
}

const update = async () => {
  // refForm.validate()
  let resp = await axios.put(`/api/addresses/${route.params.id}`, state.formData)
  .catch(e => {
    state.validationErrors = e.response.data.errors
  })
  if(resp) {
    router.push({ name: 'addresses' })
  }
}

</script>
<style lang="scss">
  
</style>
