<template>
  <div id="list-account" class="card-content">
    <h1 :style="{ textAlign: 'left', paddingLeft: '30px' }">Transactions</h1>
    <a-table :dataSource="getData" :columns="columns"> </a-table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      data: [],
      columns: [
        {
          title: "Date/Time",
          dataIndex: "date_time",
          key: "date_time",
        },
        {
          title: "Amount",
          dataIndex: "amount",
          key: "amount",
        },
        {
          title: "Status",
          dataIndex: "status",
          key: "status",
        },
        {
          title: "Description",
          dataIndex: "description",
          key: "description",
        },
        {
          title: "Type",
          dataIndex: "type",
          key: "type",
        },
      ],
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
