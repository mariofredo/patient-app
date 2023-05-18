import { defineStore } from 'pinia'
import instance from '../api/instance'
import Swal from 'sweetalert2'

export const usePatientStore = defineStore('patient', {
  state: () => ({
    patients: [],
    patient: {}
  }),
  getter: {},
  actions: {
    async getPatients(name) {
      try {
        let res
        if (name) {
          res = await instance({
            method: 'GET',
            url: `/api/patients/search/${name}`
          })
        } else {
          res = await instance({
            method: 'GET',
            url: '/api/patients'
          })
        }
        console.log(res.data)
        this.patients = res.data.result
      } catch (error) {
        console.log(error)
      }
    },
    async getPatientDetail(id) {
      try {
        const res = await instance({
          method: 'GET',
          url: `/api/patients/${id}`
        })
        this.patient = res.data.result
      } catch (error) {
        console.log(error)
      }
    },
    async createPatientData(payload) {
      try {
        const res = await instance({
          method: 'POST',
          url: '/api/patients',
          data: payload
        })
        return res.data
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: `Error code ${error.response.data.status.code}`,
          text: `${error.response.data.status.message[0]}`
        })
      }
    },
    async editPatientData(id, payload) {
      try {
        const res = await instance({
          method: 'PUT',
          url: `/api/patients/${id}`,
          data: payload
        })
        return res.data
      } catch (error) {
        Swal.fire({
          icon: 'error',
          title: `Error code ${error.response.data.status.code}`,
          text: `${error.response.data.status.message[0]}`
        })
      }
    },
    async deletePatientData(id) {
      try {
        await instance({
          method: 'DELETE',
          url: `/api/patients/${id}`
        })
        this.patients = this.patients.filter((el) => el.id != id)
        Swal.fire({
          title: `Delete Patient`,
          text: `Success delete patient with Id: ${id}`
        })
      } catch (error) {
        console.log(error)
      }
    }
  }
})
