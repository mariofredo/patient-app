<template>
  <div class="d-flex container flex-column justify-content-center align-items-center">
    <h2>Patient List</h2>
    <div class="container bg-light rounded-3">
      <div class="listContainer overflow-auto">
        <table class="table">
          <thead class="sticky-top bg-light">
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Name</th>
              <th scope="col">Sex</th>
              <th scope="col">Religion</th>
              <th scope="col">Phone</th>
              <th scope="col">Address</th>
              <th scope="col">NIK</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <TableItem :patients="patients" />
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div
    class="modal fade"
    id="staticBackdrop"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Patient Detail</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="ms-3">Id: {{ this.patient.id }}</div>
          <div class="ms-3">Name: {{ this.patient.name }}</div>
          <div class="ms-3">Sex: {{ this.patient.sex }}</div>
          <div class="ms-3">Religion: {{ this.patient.religion }}</div>
          <div class="ms-3">Phone: {{ this.patient.phone }}</div>
          <div class="ms-3">Address: {{ this.patient.address }}</div>
          <div class="ms-3">NIK: {{ this.patient.nik }}</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal" @click.prevent="deletePatient(this.patient.id)">Delete</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click.prevent="goToEditForm()">Edit</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { usePatientStore } from '../stores/patient'
import TableItem from '../components/TableItem.vue'
export default {
  name: 'HomeView',
  components: {
    TableItem
  },
  computed: {
    ...mapState(usePatientStore, ['patients', 'patient'])
  },
  methods: {
    ...mapActions(usePatientStore, ['getPatients', 'deletePatientData']),
    async deletePatient(){
        await this.deletePatientData(this.patient.id);
    },
    async goToEditForm(){
      this.$router.push(`/patient/edit/${this.patient.id}`)
    }
  },
  async created() {
    await this.getPatients()
  },
}
</script>

<style>
.listContainer {
  height: 75vh !important;
}
</style>
