<template>
  <q-page class="q-pa-md">

    <q-table
      flat bordered
      title="Addresses"
      :rows="state.rows"
      :columns="columns"
      row-key="id"
      :rows-per-page-options="[15,50]"
    >
      <template v-slot:top>
        <h5 class="q-ma-sm q-pa-sm">Address</h5>
        <q-btn color="primary" label="Add new" to="/addresses/create" />
        
      </template>

      <template v-slot:body-cell-island="props">
        <q-td
        :props="props"
      >
          {{  props.row.island?.atoll }}. {{  props.row.island?.island_name }}

      </q-td>
      </template>


      <template v-slot:body-cell-action="props">
        <q-td
        :props="props"
      >
        <q-btn
          round
          flat
          icon="edit"
          @click.stop="1"
          :to="`/quotes/${props.row.id}/edit`"
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

const columns = [
  { name: 'house_name', label: 'House name', field: 'house_name', sortable: true, align: 'left'},
  { name: 'street', label: 'Street', field: 'street' },
  { name: 'island', label: 'Atoll Island', field: 'island' },
  { name: 'action', label: 'Actions', field: 'action' },
]

const state = reactive({ rows: [] })


const loadList = async () => {
  state.rows = await axios.get('/api/addresses').then(res => res.data.data);
}

const deleteData = async ({id}) => {
  await axios.delete(`/api/addresses/${id}`).then(res => {
    console.log(res.data)
    loadList()
    $router.push({ name: 'addresses' })
  });
}


onMounted(async () => {
  await loadList()
  // console.log(state.rows)

})

</script>
<style lang="scss">
  
</style>
