import * as AuthService from "../services/Auth/auth";

export default {
  namespaced: true,

  state: {
    token: null,
  },

  getters: {
    authenticated(state) {
      return state.token;
    },
  },
  mutations: {
    SET_TOKEN(state, token) {
      state.token = token;
    },
  },

  actions: {
    async singIn({ commit }, credentials) {
      let response = await AuthService.login({
        credentials,
      });

      if (response.data.status !== 200) {
        return response;
      }
      commit("SET_TOKEN", response.data.access_token);
      localStorage.setItem("user_token", response.data.access_token);

      return response;
    },

    // eslint-disable-next-line no-empty-pattern
    async createUser({}, data) {
      return await AuthService.create({
        data,
      });
    },

    async userData({ commit, dispatch }) {
      let response = await AuthService.userAuth();
      commit(
        "user/SET_USER_DATA",
        {
          name: response.data.data.name,
          id: response.data.data.id,
          is_adm: response.data.data.is_adm,
        },
        { root: true }
      );

      if (response.data.data.is_adm == 0) {
        commit("user/SET_ACCOUNT_BALANCE", response.data.data.balance, {
          root: true,
        });
        dispatch("user/getHistoric", null, { root: true });
      }
    },

    async logout({ commit }) {
      try {
        let response = await AuthService.logout().then(() => {
          commit("SET_TOKEN", null);
          commit("users/SET_DEFAULT", null, { root: true });
          localStorage.removeItem("user_token");
          location.reload();

          return response;
        });
      } catch (err) {
        return err;
      }
    },
  },
};
