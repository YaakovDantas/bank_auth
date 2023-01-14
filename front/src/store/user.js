import * as OperationsService from "../services/Operations/operations";
import * as AdminService from "../services/Admin/admin";

function updateBalance(currentValue, { amount: newValue }) {
  currentValue = parseFloat(currentValue);
  newValue = parseFloat(newValue);

  return (currentValue -= newValue);
}

export default {
  namespaced: true,

  state: {
    user_data: {
      name: null,
      id: null,
      is_adm: 0,
    },
    balance: 0,
    historic: [],
    pending_list: [],
  },

  getters: {
    authenticated(state) {
      return state.token;
    },
    user(state) {
      return state.user_data;
    },
    is_adm(state) {
      return state.user_data.is_adm == 1;
    },
  },
  mutations: {
    SET_USER_DATA(state, data) {
      state.user_data = data;
    },
    SET_ACCOUNT_BALANCE(state, data) {
      state.balance = data;
    },
    SET_ACCOUNT_HISTORIC(state, data) {
      state.historic = data;
    },
    SET_PENDING_LIST(state, data) {
      state.pending_list = data;
    },
    SET_DEFAULT(state) {
      state.user_data = {
        name: null,
        id: null,
        is_adm: 0,
      };
      state.balance = 0;
      state.historic = [];
      state.pending_list = [];
    },
  },

  actions: {
    async sendTransaction({ state, commit, dispatch }, transaction) {
      let formData = new FormData();
      formData.append("type", transaction.type);
      formData.append("amount", transaction.amount);
      formData.append("check", transaction.check);
      formData.append("description", transaction.description);

      try {
        let response = await OperationsService.runTransaction(
          formData,
          state.user_data.id
        );

        if (!response.erro && transaction.type === "DRAFT") {
          let newBalance = await updateBalance(state.balance, {
            ...response.data.data,
          });
          dispatch("getHistoric", { ...state.user_data.id });
          commit("SET_ACCOUNT_BALANCE", `${newBalance}`);
          return response.data;
        } else {
          return response;
        }
      } catch (error) {
        Promise.reject(error);
      }
    },

    async getBalanceUser({ commit, state, dispatch }) {
      try {
        let response = await OperationsService.getBalance(state.user_data.id);
        commit("SET_ACCOUNT_BALANCE", response.data.balance);
        dispatch("getHistoric", { ...state.user_data.id });

        Promise.resolve();
      } catch (error) {
        Promise.reject(error);
      }
    },
    async getPendings({ commit, state }) {
      try {
        let response = await AdminService.getPendings(state.user_data.id);
        commit("SET_PENDING_LIST", response.data.data);

        Promise.resolve();
      } catch (error) {
        Promise.reject(error);
      }
    },

    async handleDeposit({ dispatch }, data) {
      try {
        await AdminService.updateTransaction(data);

        dispatch("getPendings");
        Promise.resolve();
      } catch (error) {
        Promise.reject(error);
      }
    },

    async getHistoric({ commit, state }) {
      try {
        let response = await OperationsService.getHistoric(state.user_data.id);

        response.data.data.sort(function (a, b) {
          let one = new Date(a.date_time).valueOf();
          let two = new Date(b.date_time).valueOf();
          return two - one;
        });
        commit("SET_ACCOUNT_HISTORIC", response);
        Promise.resolve();
      } catch (error) {
        Promise.reject(error);
      }
    },
  },

  modules: {},
};
