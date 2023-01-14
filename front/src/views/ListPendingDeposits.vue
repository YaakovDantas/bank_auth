<template>
  <div id="view-data-component" class="card-content">
    <a-page-header sub-title="">
      <div class="content" style="text-align: left">
        <div class="main">
          <a-descriptions size="small" :column="1">
            <div id="list-account" class="card-content">
              <h1 :style="{ textAlign: 'left', paddingLeft: '30px' }">
                Pending
              </h1>
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
                <a-list-item
                  slot="renderItem"
                  style="display: flex; justify-content: space-around"
                  slot-scope="item, index"
                  :key="index"
                >
                  <p>
                    $ {{ " " }}
                    <strong>{{ item.amount }}</strong>
                  </p>
                  <img width="200px" v-bind:src="item.url" />

                  <a @click.stop.prevent="approved(item.id)">
                    Approved
                    <a-icon type="like" style="color: green" />
                  </a>

                  <a @click.stop.prevent="declined(item.id)">
                    Declined
                    <a-icon type="dislike" style="color: red" />
                  </a>
                </a-list-item>
              </a-list>
            </div>
          </a-descriptions>
        </div>
      </div>
    </a-page-header>
  </div>
</template>
<script>
import { mapActions } from "vuex";

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

    this.getPendings();
  },

  computed: {
    getData() {
      return this.$store.state.user.pending_list || [];
    },
  },

  methods: {
    ...mapActions({
      getPendings: "user/getPendings",
      handleDeposit: "user/handleDeposit",
    }),
    approved(id) {
      this.handleDeposit({ transaction_id: id, type: "APPROVED" });
    },
    declined(id) {
      this.handleDeposit({ transaction_id: id, type: "DECLINED" });
    },
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
