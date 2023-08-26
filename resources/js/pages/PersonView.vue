<template>
  <div>
    <ul>
      <li>{{ state.formData.first_name}} </li>
      <li>{{ state.formData.last_name}} </li>
      <li>{{ state.formData.dob}} </li>
      <li>{{ state.formData.national_id}} </li>
    </ul>
    {{ state.formData.national_id_url }}
  
  {{state.formData}}
  {{ state.validationErrors }}
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
const state = reactive({formData: {}, validationErrors: {}});
const refForm = ref(null)

onMounted(async () => {
  if(route.params.id) {
    let resp = await axios.get(`/api/people/${route.params.id}`)
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
  let resp = await axios.post('/api/people', state.formData)
  .catch(e => {
    state.validationErrors = e.response.data.errors
  })
  if(resp) {
    router.push({ name: 'people' })
  }
}

const update = async () => {
  // refForm.validate()
  let resp = await axios.put(`/api/people/${route.params.id}`, state.formData)
  .catch(e => {
    state.validationErrors = e.response.data.errors
  })
  if(resp) {
    router.push({ name: 'people' })
  }
}

</script>
<style lang="scss">
  
</style>
