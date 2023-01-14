<template>
  <div class="container">
    <a-form-model
      ref="ruleForm"
      :model="form"
      :label-col="labelCol"
      :wrapper-col="wrapperCol"
      id="form-operation"
    >
      <a-form-model-item ref="name" prop="name">
        <p>Username</p>
        <a-input
          class="input-box underline"
          :style="{ minWidth: '100%' }"
          v-model="form.name"
        />
      </a-form-model-item>

      <a-form-model-item ref="password" prop="password">
        <p class="title-section">Password</p>
        <a-input-password
          class="input-box"
          v-model.trim="form.password"
          type="password"
        />
      </a-form-model-item>

      <a-form-model-item :wrapper-col="{ span: 24, offset: 0 }">
        <a-button class="btn-enter input-box button" @click="onSubmit">
          Login
        </a-button>
      </a-form-model-item>
    </a-form-model>
    <small>
      <a @click="newUser()">new account</a>
    </small>
  </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      labelCol: { span: 1 },
      wrapperCol: { span: 24 },
      form: {
        name: "",
        password: "",
      },
    };
  },
  methods: {
    ...mapActions({
      login: "auth/singIn",
    }),
    onSubmit() {
      this.login({ ...this.form }).then((response) => {
        if (response.data.status !== 200) {
          this.$message.error("Invalid user or password, try again.");
          return;
        }
        this.$router.replace({ name: "Home" });
        this.$message.success("Welcome!");
      });
    },
    newUser() {
      this.$router.replace({ name: "Create" });
    },
  },
};
</script>

<style lang="scss" scoped>
.title-section {
  margin: 0;
}
</style>
<style lang="scss">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}
html,
body {
  display: grid;
  height: 100vh;
  width: 100%;
  place-items: center;
}
.container {
  background: #fff;
  max-width: 350px;
  width: 100%;
  padding: 25px 30px;
  border-radius: 5px;
  box-shadow: 10px 10px 10px 10px rgba(0, 0, 0, 0.15);
}
.container form .title {
  font-size: 30px;
  font-weight: 600;
  margin: 20px 0 10px 0;
  position: relative;
}
.container form .input-box {
  width: 100%;
  position: relative;
}
.container form .input-box input {
  width: 100%;
  height: 100%;
  outline: none;
  font-size: 16px;
  border: none;
}
</style>
