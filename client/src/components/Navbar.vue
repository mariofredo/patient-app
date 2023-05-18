<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <RouterLink class="navbar-brand" to="/">Zi.Care</RouterLink>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-3">
          <RouterLink class="nav-link" aria-current="page" to="/">Home</RouterLink>
          <RouterLink class="nav-link" to="/patient/add">Add patient</RouterLink>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { RouterLink } from 'vue-router'

export default {
  name: 'Navbar',
  components: {
    RouterLink
  }
}
</script>

<style></style>
