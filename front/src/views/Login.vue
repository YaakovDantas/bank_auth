<template>
  <div id="home-page">
    <a-layout id="components-layout-demo-top" class="layout">
      <a-layout-content style="padding: 0 50px; background: white">
        <div
          :style="{
            padding: '14px',
            minHeight: '80vh',
          }"
        >
          <div class="header-content">
            <login-form />
          </div>
        </div>
      </a-layout-content>
    </a-layout>
  </div>
</template>

<script>
import LoginForm from "../components/Auth/LoginForm.vue";
// @ is an alias to /src

export default {
  name: "Login",
  components: {
    LoginForm,
  },
};
</script>
