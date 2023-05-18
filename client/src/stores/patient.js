import { defineStore } from 'pinia'
import instance from '../api/instance'
export const usePatientStore = defineStore('patient', {
  state: () => ({
    patients: [],
    patient: {}
  }),
  getter: {},
  actions: {
    async getPatients() {
      try {
        const res = await instance({
          method: 'GET',
          url: '/api/patients'
        })
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
          url: '/api/patients/',
          data: payload
        })
        return res.data
      } catch (error) {
        console.log(error)
      }
    },
    async deletePatientData(id){
      try {
        await instance({
          method: "DELETE",
          url: `/api/patients/${id}`
        })
        this.patients = this.patients.filter(el => el.id != id)
      } catch (error) {
        console.log(error)
      }
    }
  }
})
