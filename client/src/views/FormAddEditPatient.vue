<template>
  <div class="container vh-100 d-flex flex-column align-items-center mt-5">
    <div class="w-50 d-flex flex-column bg-light rounded-3">
      <div class="col-12 px-3 pt-3">
        <h2 v-if="this.$route.name == 'addPatient'" class="text-center">Add Patient</h2>
        <h2 v-else class="text-center">Edit Patient</h2>
        <hr />
        <div class="row">
          <div class="col-6 mb-3">
            <label class="form-label">Name</label>
            <input v-model="name" type="text" class="form-control" placeholder="Name" />
          </div>
          <div class="col-6 mb-3">
            <label class="form-label">Sex</label>
            <select v-model="sex" class="form-control">
              <option selected disabled value="">Open this select menu</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <label class="form-label">Religion</label>
            <input v-model="religion" type="text" class="form-control" placeholder="Religion" />
          </div>
          <div class="col-6 mb-3">
            <label class="form-label">Phone</label>
            <input v-model="phone" type="text" class="form-control" placeholder="Phone" />
          </div>
        </div>
        <div class="row">
          <div class="col-6 mb-3">
            <label class="form-label">Address</label>
            <input v-model="address" type="text" class="form-control" placeholder="Address" />
          </div>
          <div class="col-6 mb-3">
            <label class="form-label">NIK</label>
            <input v-model="nik" type="text" class="form-control" placeholder="NIK" />
          </div>
        </div>
      </div>
      <button
        v-if="this.$route.name == 'addPatient'"
        class="btn btn-primary mx-3 mb-3"
        @click.prevent="addPatient()"
      >
        Create
      </button>
      <button v-else class="btn btn-primary mx-3 mb-3" @click.prevent="editPatient()">Edit</button>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'pinia'
import { usePatientStore } from '../stores/patient'
export default {
  name: 'FormAddPatient',
  data() {
    return {
      name: '',
      sex: '',
      religion: '',
      phone: '',
      address: '',
      nik: '',
      id: ''
    }
  },
  computed: {
    ...mapState(usePatientStore, ['patient'])
  },
  async created() {
    if (this.$route.name == 'editPatient') {
      this.id = this.$route.params.id
      await this.getPatientDetail(this.id)
      this.name = this.patient.name
      this.sex = this.patient.sex
      this.religion = this.patient.religion
      this.phone = this.patient.phone
      this.address = this.patient.address
      this.nik = this.patient.nik
    } else {
      this.name = ''
      this.sex = ''
      this.religion = ''
      this.phone = ''
      this.address = ''
      this.nik = ''
    }
  },
  methods: {
    ...mapActions(usePatientStore, ['createPatientData', 'editPatientData', 'getPatientDetail']),
    async addPatient() {
      try {
        const payload = {
          name: this.name,
          sex: this.sex,
          religion: this.religion,
          phone: this.phone,
          address: this.address,
          nik: this.nik
        }
        const res = await this.createPatientData(payload)
        if (res.status.code == 201) {
          this.name = ''
          this.sex = ''
          this.religion = ''
          this.phone = ''
          this.address = ''
          this.nik = ''
          this.$router.push('/')
        }
      } catch (error) {
        // console.log(error)
      }
    },
    async editPatient() {
      try {
        this.id = this.$route.params.id
        const payload = {
          name: this.name,
          sex: this.sex,
          religion: this.religion,
          phone: this.phone,
          address: this.address,
          nik: this.nik
        }
        const res = await this.editPatientData(this.id, payload)
        if (res.status.code == 200) {
          this.name = ''
          this.sex = ''
          this.religion = ''
          this.phone = ''
          this.address = ''
          this.nik = ''
          this.$router.push('/')
        }
      } catch (error) {
        // console.log(error)
      }
    }
  }
}
</script>

<style></style>
