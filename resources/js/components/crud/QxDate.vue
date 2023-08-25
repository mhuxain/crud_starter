<template>
<q-input v-bind="$attrs" mask="####-##-##" :rules="[]" placeholder="yyyy-mm-dd" :modelValue="modelValue">
      <template v-slot:prepend>
        <q-icon name="mdi-calendar" class="cursor-pointer">
          <q-menu v-model="qDateMenu" ref="qDateMenu" transition-show="jump-down" transition-hide="jump-up">
            <q-date v-bind="$attrs" mask="YYYY-MM-DD" :modelValue="modelValue" @update:modelValue="dateUpdated">
              <div v-if="!autoClose" class="row items-center justify-end">
                <q-btn v-close-popup label="Close" color="primary" flat></q-btn>
              </div>
            </q-date>
          </q-menu>
        </q-icon>
      </template>
    </q-input>
</template>

<script>

export default {
    name: "qxDate",
    data: () => ({
      qDateMenu: false
        
    }),
    props: {
      modelValue: {
        default: null,
      },
      autoClose: {
        type: Boolean,
        default: true
      }
    
    },
    methods: {
      dateUpdated(value, reason, details) {
        if(this.autoClose) {
          this.qDateMenu = false
        }
      }
    }

}
</script>

<style>


</style>