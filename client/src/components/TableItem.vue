<template>
  <tr v-for="(patient, i) in patients" :key="i">
    <th scope="row">{{ patient.id }}</th>
    <td>{{ patient.name }}</td>
    <td>{{ patient.sex }}</td>
    <td>{{ patient.religion }}</td>
    <td>{{ patient.phone }}</td>
    <td>{{ patient.address }}</td>
    <td>{{ patient.nik }}</td>
    <td>
      <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#staticBackdrop"
        @click.prevent="goToDetailPatient(patient.id)"
      >
        Detail
      </button>
    </td>
  </tr>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { usePatientStore } from '../stores/patient'
export default {
  name: 'TableItem',
  props: {
    patients: Array
  },
  computed: {},
  methods: {
    ...mapActions(usePatientStore, ['getPatientDetail']),
    async goToDetailPatient(id) {
      await this.getPatientDetail(id)
    }
  }
}
</script>

<style></style>
