<template>
  <q-page class="q-pa-md">

    <q-table
      flat bordered
      title="Treats"
      :rows="state.rows"
      :columns="columns"
      row-key="name"
    >
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

const columns = [
  {
    name: 'author',
    required: true,
    label: 'Author',
    align: 'left',
    field: row => row.author,
    format: val => `${val}`,
    sortable: true
  },
  { name: 'quote', label: 'Quote', field: 'quote', sortable: true },
  { name: 'subject', label: 'subject (g)', field: 'subject' },
  { name: 'quoted_on', label: 'quoted_on (g)', field: 'quoted_on' },
  { name: 'action', label: 'Actions', field: 'action' },
]


const state = reactive({ rows: [] })
const deleteData = async ({id}) => {
  await axios.delete(`/api/quotes/${id}`).then(res => {
    console.log(res.data)
    $router.push({ name: 'quotes' })
  });
}

onMounted(async () => {
  state.rows = await axios.get('/api/quotes').then(res => res.data.data);
  // console.log(state.rows)

})

</script>
<style lang="scss">
  
</style>
