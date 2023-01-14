<template>
  <a-form-model
    ref="ruleForm"
    :model="form"
    :label-col="labelCol"
    :wrapper-col="wrapperCol"
    id="form-operation"
  >
    <a-form-model-item ref="amount" prop="amount">
      <p class="title-section">Amount</p>
      <a-input-number
        type="number"
        :min="0"
        :style="{ minWidth: '100%' }"
        v-model="form.amount"
      />
    </a-form-model-item>

    <a-form-model-item
      ref="description"
      prop="description"
      v-if="operationType === 'draft'"
    >
      <p class="title-section">description</p>
      <a-input :style="{ minWidth: '100%' }" v-model="form.description" />
    </a-form-model-item>

    <a-form-model-item
      ref="check"
      prop="check"
      v-if="operationType !== 'draft'"
    >
      <p class="title-section">Check</p>
      <a-input
        @change="uploadFile"
        type="file"
        :style="{ minWidth: '100%', minHeight: '35px' }"
      />
    </a-form-model-item>

    <a-form-model-item :wrapper-col="{ span: 24, offset: 0 }">
      <a-button class="btn-enter" @click="onSubmit"> Submit </a-button>
    </a-form-model-item>
  </a-form-model>
</template>
<script>
import { mapActions } from "vuex";

export default {
  props: {
    handleCancelOperation: {
      type: Function,
      required: true,
      default: () => {},
    },
    operationType: {
      type: String,
      required: true,
      default: null,
    },
  },

  data() {
    return {
      labelCol: { span: 1 },
      wrapperCol: { span: 24 },
      form: {
        amount: undefined,
        description: null,
        check: undefined,
      },
    };
  },
  methods: {
    ...mapActions({
      sendTransaction: "user/sendTransaction",
    }),
    uploadFile(event) {
      this.form.check = event.target.files[0];
    },
    onSubmit() {
      this.sendTransaction({
        ...this.form,
        type: this.operationType.toUpperCase(),
      }).then((response) => {
        if (!response.erro) {
          this.$message.success("Transaction made with success.");
        } else {
          let message = this.logErrors(response.erro);
          this.$message.error(message);
        }

        this.form = {
          amount: undefined,
          description: null,
          check: undefined,
        };
        this.handleCancelOperation();
      });
    },
    logErrors(log) {
      switch (log) {
        case "Insufficient balance to complete this transaction.":
          return "Not enought money!";
        default:
          return "Transaction cannot be done.";
      }
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
#form-operation {
  .ant-input-number-handler-wrap {
    display: none;
  }
}
</style>
