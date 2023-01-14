<template>
  <div id="my-profile">
    <view-data :handleOperation="callOperation" />
    <a-modal v-model="visible" :title="titleOperation" :footer="null">
      <operation-form
        :operationType="operationType"
        :handleCancelOperation="() => (visible = false)"
      />
    </a-modal>
  </div>
</template>

<script>
import OperationForm from "../components/MyProfile/OperationForm.vue";
import ViewData from "../components/MyProfile/ViewData.vue";

export default {
  components: {
    ViewData,
    OperationForm,
  },

  data() {
    return {
      visible: false,
      titleOperation: "Deposit",
      operationType: "",
    };
  },
  methods: {
    callOperation(operation) {
      this.titleOperation = operation === "draft" ? "Withdrawal" : "Deposit";
      this.visible = true;
      this.operationType = operation;
    },
  },
};
</script>
