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
            Create a new account
            <new-user-form />
          </div>
        </div>
      </a-layout-content>
    </a-layout>
  </div>
</template>

<script>
import NewUserForm from "../components/Auth/NewUserForm.vue";
// @ is an alias to /src

export default {
  name: "Create",
  components: {
    NewUserForm,
  },
};
</script>
