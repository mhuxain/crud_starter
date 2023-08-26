<template>
  <div>

  <q-form class="q-pa-md" ref="form">
    <q-input v-model="state.formData.first_name" v-bind="attrs('first_name', 'First name')" />
    <q-input v-model="state.formData.last_name" v-bind="attrs('last_name', 'Last name')" />
    <q-input v-model="state.formData.dob" type="date" v-bind="attrs('dob', 'Date of Birth')" />
    <q-input v-model="state.formData.national_id" v-bind="attrs('national_id', 'National id')" />
    Please attach a scan of National ID
    <qx-file-upload 
              :image-url="state.formData.national_id_url"
              v-model="state.formData.national_id_url"
              :multiple="false"
                      >
    </qx-file-upload>
    <qx-select
      v-model="state.formData.address_id" 
      options-url="/api/addresses"
      option-label="label"
      option-value="id"
      emit-value
      map-options
      v-bind="attrs('address_id', 'Address (Multiple can be added after create)')"
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
