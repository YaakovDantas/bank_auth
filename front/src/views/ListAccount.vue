<template>
  <div id="list-account" class="card-content">
    <h1 :style="{ textAlign: 'left', paddingLeft: '30px' }">Transactions</h1>
    <a-list
      class="demo-loadmore-list"
      :loading="loading"
      item-layout="horizontal"
      :data-source="getData"
    >
      <div
        v-if="showLoadingMore"
        slot="loadMore"
        :style="{
          textAlign: 'center',
          marginTop: '32px',
          height: '32px',
          lineHeight: '32px',
        }"
      >
        <a-spin v-if="loadingMore" />
      </div>
      <a-list-item slot="renderItem" slot-scope="item, index">
        <div class="content-item" :key="index">
          <p>
            <a-icon type="clock-circle" />{{ " " }}
            <strong>{{ item.date_time }}</strong>
          </p>
          <p><strong>$ </strong> {{ item.amount }}</p>
          {{ " " }}
          <p>
            Status: {{ item.status }}
            <a-icon
              type="like"
              style="color: green"
              v-if="item.status === 'APPROVED'"
            />
            <a-icon
              type="dislike"
              style="color: red"
              v-if="item.status === 'DECLINED'"
            />
          </p>
          <p v-if="item.type === 'DRAFT'">
            Description: {{ item.description }}
          </p>
          <p v-if="item.type === 'DEPOSIT'">{{ " " }}</p>
          <p v-if="item.type === 'DEPOSIT'"></p>
          <p
            :style="{
              display: 'flex',
              justifyContent: 'left',
              minWidth: '80px',
              gap: '10px',
            }"
          >
            <strong>
              <a-icon
                type="plus"
                style="color: green"
                v-if="item.type === 'DEPOSIT'"
              />
              <a-icon type="minus" style="color: red" v-else />
            </strong>
            {{ item.type === "DRAFT" ? "Withdrawal" : "Deposit" }}
          </p>
        </div>
      </a-list-item>
    </a-list>
  </div>
</template>
<script>
export default {
  data() {
    return {
      loading: true,
      loadingMore: false,
      showLoadingMore: true,
      data: [],
    };
  },
  mounted() {
    setTimeout(() => {
      this.loading = false;
    }, 2000);
  },

  computed: {
    getData() {
      if (this.$store.state.user.user_data.is_adm == 1) {
        return [];
      }
      return this.$store.state.user.historic.data.data || [];
    },
  },

  methods: {
    onLoadMore() {
      this.loadingMore = true;
      this.getData((res) => {
        this.data = this.data.concat(res.results);
        this.loadingMore = false;
        this.$nextTick(() => {
          window.dispatchEvent(new Event("resize"));
        });
      });
    },
  },
};
</script>

<style lang="scss">
#list-account {
  margin: 50px 0;
  .demo-loadmore-list {
    min-height: 350px;
    max-height: 600px;
    overflow-y: auto;
    .content-item {
      display: flex;
      gap: 10px 50px;
      flex-wrap: wrap;
      width: 100%;
      justify-content: space-around;
    }
  }
}
</style>
