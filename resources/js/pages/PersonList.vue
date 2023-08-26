<template>
  <q-page class="q-pa-md">
    <q-table
      flat bordered
      title="People"
      :rows="state.rows"
      :columns="columns"
      row-key="id"
      :rows-per-page-options="[15,50]"
    >

    <template v-slot:top>
        <h5 class="q-ma-sm q-pa-sm">People</h5>
        <q-btn color="primary" label="Add new" to="/people/create" />
        
      </template>

    <template v-slot:body-cell-address="props">
        <q-td
        :props="props"
      >
      <ul>
        <li v-for="address in props.row.addresses" :key="address.id">
        {{ address.house_name }}, {{ address.street }}
        </li>
      </ul>

      </q-td>
      </template>

      <template v-slot:body-cell-national_id="props">
        <q-td
        :props="props"
      >
      <a :href="props.row.national_id_url" target="_blank">
        {{ props.value }}
      </a>
      </q-td>
      </template>




      <template v-slot:body-cell-action="props">
        <q-td
        :props="props"
      >
      <q-btn
          round
          flat
          icon="visibility"
          @click.stop="1"
          :to="`/people/${props.row.id}`"
          color="green"
        >
        </q-btn>
        <q-btn
          round
          flat
          icon="edit"
          @click.stop="1"
          :to="`/people/${props.row.id}/edit`"
          color="orange"
        >
        </q-btn>
        <q-btn
          round
          flat
          icon="delete"
          @click.stop="deleteData(props.row)"
          color="blue"
        >

        </q-btn>

      </q-td>
      </template>
    </q-table>

  </q-page>

</template>

<script setup>
import axios from 'axios';
import { onMounted, reactive } from 'vue';
import { useRouter, useRoute } from 'vue-router'
const $router = useRouter()
const route = useRoute()

const columns = [
{ name: 'first_name', label: 'First Name', field: 'first_name', sortable: true, align: 'left'},
  { name: 'last_name', label: 'Last Name', field: 'last_name', align: 'left'},
  { name: 'dob', label: 'Date of Birth', field: 'dob' },
  { name: 'national_id', label: 'National Id', field: 'national_id' },
  { name: 'address', label: 'Address', field: 'address', align: 'left'},
  { name: 'action', label: 'Actions', field: 'action' },
]


const state = reactive({ rows: [] })
const deleteData = async ({id}) => {
  await axios.delete(`/api/people/${id}`).then(res => {
    console.log(res.data)
    loadList()
    $router.push({ name: 'quotes' })
  });
}

const loadList = async () => {
  state.rows = await axios.get('/api/people').then(res => res.data.data);
}


onMounted(async () => {
  loadList()
  // console.log(state.rows)

})

</script>
<style lang="scss">
  
</style>
