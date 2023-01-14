<template>
  <div id="home-page">
    <a-layout id="components-layout-demo-top" class="layout">
      <a-layout-header class="header">
        <a-menu
          mode="horizontal"
          :default-selected-keys="['1']"
          :style="{ lineHeight: '64px' }"
          class="font-black"
        >
          <a-menu-item key="1" v-if="!is_adm"> My Account </a-menu-item>
          <a-menu-item key="1" v-if="is_adm"> Peddning Deposits </a-menu-item>
          <a-menu-item key="2" v-if="!is_adm" :disabled="true">
            Investments
          </a-menu-item>
          <a-menu-item key="3" v-if="!is_adm" :disabled="true">
            Loans
          </a-menu-item>
          <a-menu-item key="4" @click="logout()"> Logout </a-menu-item>
        </a-menu>
      </a-layout-header>

      <a-layout-content style="padding: 0 50px" v-if="!is_adm">
        <div
          :style="{
            background: 'transparent',
            padding: '14px',
            minHeight: '80vh',
          }"
        >
          <div class="header-content">
            <my-profile v-if="!is_adm" />
          </div>
          <div class="body-content">
            <list-account v-if="!is_adm" />
          </div>
        </div>
      </a-layout-content>

      <a-layout-content style="padding: 0 50px" v-if="is_adm">
        <div
          :style="{
            background: 'transparent',
            padding: '14px',
            minHeight: '80vh',
          }"
        >
          <div class="header-content">
            <list-pending-deposits v-if="is_adm" />
          </div>
        </div>
      </a-layout-content>
      <a-layout-footer style="text-align: center">
        ©2023 Created by Thiago 'Yaakov' Dantas.
      </a-layout-footer>
    </a-layout>
  </div>
</template>

<script>
import ListAccount from "./ListAccount";
import MyProfile from "./MyProfile.vue";
import ListPendingDeposits from "./ListPendingDeposits.vue";
import { mapActions, mapGetters } from "vuex";
// @ is an alias to /src

export default {
  name: "Home",
  components: {
    ListAccount,
    MyProfile,
    ListPendingDeposits,
  },
  computed: {
    ...mapGetters({
      is_adm: "user/is_adm",
    }),
  },
  methods: {
    ...mapActions({
      userData: "auth/userData",
      logoutUser: "auth/logout",
    }),
    logout() {
      this.logoutUser();
    },
  },
  mounted() {
    this.userData();
  },
};
</script>

<style lang="scss">
#home-page {
  .header {
    background: #fff;
    .ant-menu {
      color: #1a1919;
    }
  }
  #components-layout-demo-top .logo {
    width: 120px;
    display: flex;
    height: 31px;
    margin: 16px 24px 16px 0;
    float: left;
    justify-content: center;
    align-items: center;
  }
}
</style>
