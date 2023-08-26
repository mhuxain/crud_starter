<template>
  <div>
    <h5>Person View</h5>
    <ul>
      <li>Name: {{ state.formData.first_name}} {{ state.formData.last_name}}</li>
      <li>Date of Birth{{ state.formData.dob}} </li>
      <li>
        <a :href="state.formData.national_id_url" target="_blank">
        {{ state.formData.national_id}} 
        </a>
      </li>
    </ul>

    <hr />
    Addresses of  {{ state.formData.first_name}} {{ state.formData.last_name}}
    <div class="row">
    <qx-select
    class="col-6"
      v-model="state.newAddess" 
      options-url="/api/addresses"
      option-label="label"
      option-value="id"
      emit-value
      map-options

    >
    </qx-select>
    <div class="q-pa-md">
      <q-btn @click="addAddess()">Add</q-btn>
    </div>
  </div>
    <ul>
      <li v-for="address in state.formData.addresses" :key="address.id">
        {{ address.house_name }}, {{ address.street }}
        </li>
    </ul>

<hr />  
  {{state.formData}}
</div>
</template>

<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import QxSelect from '../components/crud/QxSelect.vue';
import QxFileUpload from '../components/crud/QxFileUpload.vue';
import QxDate from '../components/crud/QxDate.vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()
const state = reactive({formData: {}, validationErrors: {}, newAddess: null});
const refForm = ref(null)

const loadViewItem = async () => {
  if(route.params.id) {
    let resp = await axios.get(`/api/people/${route.params.id}`)
    console.log(resp)
    state.formData = reactive(resp.data)
  }
  
}

onMounted(async () => {
  loadViewItem()
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

const addAddess = async () => {
  // refForm.validate()
  let resp = await axios.post(`/api/people/${route.params.id}/addresses/${state.newAddess}`)
  .catch(e => {
    state.validationErrors = e.response.data.errors
  })
  if(resp) {
    loadViewItem()
  }
}

</script>
<style lang="scss">
  
</style>
