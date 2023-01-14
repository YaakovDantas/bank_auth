<template>
  <div id="view-data-component" class="card-content">
    <a-page-header sub-title="Your info">
      <div class="content" style="text-align: left">
        <div class="main">
          <a-descriptions size="small" :column="1">
            <a-descriptions-item>
              <h1 class="name">
                Welcome, <strong>{{ userData.name }}</strong>
              </h1>
            </a-descriptions-item>
            <a-descriptions-item label="Balance">
              <p class="account-number">$ {{ balanceAccount }}</p>
            </a-descriptions-item>
            <a-descriptions-item label="Refresh balance">
              <a @click="reloadBalance">
                <a-icon type="reload" style="color: blue" />
              </a>
            </a-descriptions-item>
          </a-descriptions>
        </div>
        <div class="extra">
          <div
            :style="{
              display: 'flex',
              width: 'max-content',
              justifyContent: 'flex-end',
              gap: '10px',
            }"
            class="btn-actions"
          >
            <a-button
              key="1"
              @click="handleOperation('deposit')"
              class="btn-enter"
            >
              Deposit
            </a-button>
            <a-button
              key="2"
              @click="handleOperation('draft')"
              class="btn-cancel"
            >
              Withdrawal
            </a-button>
          </div>
        </div>
      </div>
    </a-page-header>
  </div>
</template>
<script>
import { mapActions } from "vuex";
export default {
  name: "view-data",

  props: {
    dataObject: {
      type: Object,
      required: false,
    },
    handleOperation: {
      type: Function,
      required: true,
      default: () => {},
    },
  },

  data() {
    return {};
  },

  methods: {
    ...mapActions({
      getBalance: "user/getBalanceUser",
    }),
    reloadBalance(e) {
      e.preventDefault();
      this.getBalance();
    },
  },

  computed: {
    userData() {
      return (
        this.$store.state.user.user_data || {
          name: "Username",
        }
      );
    },
    balanceAccount() {
      return this.$store.state.user.balance || 0;
    },
  },
};
</script>
<style lang="scss">
#view-data-component {
  tr:last-child td {
    padding-bottom: 0;
  }
  .content {
    display: flex;
  }
  .ant-statistic-content {
    font-size: 20px;
    line-height: 28px;
  }

  .extra {
    display: flex;
    align-items: flex-end;
    .btn-actions {
      @media screen and (max-width: 500px) {
        flex-direction: column;
      }
    }
  }

  @media (max-width: 576px) {
    .content {
      display: block;
    }

    .main {
      width: 100%;
      margin-bottom: 12px;
    }

    .extra {
      width: 100%;
      margin-left: 0;
      text-align: left;
    }
  }
}
</style>
