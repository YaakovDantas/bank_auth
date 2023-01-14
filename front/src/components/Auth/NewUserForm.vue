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
          Create
        </a-button>
      </a-form-model-item>
    </a-form-model>
    <small>
      <a @click="back()">back</a>
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
      create: "auth/createUser",
    }),
    onSubmit() {
      this.create({ ...this.form }).then((response) => {
        if (response.status) {
          this.$message.success("User created with success.");
          this.$router.replace({ name: "Login" });
        } else {
          let message = this.logErrors(response.erro);
          this.$message.error(message);
        }
      });
    },
    logErrors(log) {
      switch (log) {
        case "Username is already been used, try another one.":
          return "Username is already been used, try another one.";
        default:
          return "Something went wrong.";
      }
    },
    back() {
      this.$router.replace({ name: "Login" });
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
