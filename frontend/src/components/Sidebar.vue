<template>
  <n-layout-sider width="220" bordered>
    <n-menu
      :options="menuOptions"
      :default-value="active"
      @update:value="onUpdate"
    />
  </n-layout-sider>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const active = ref("dashboard");

const menuOptions = [
  { label: "Dashboard", key: "dashboard" },
  { label: "Users", key: "users" },
  { label: "Settings", key: "settings" },
];

function onUpdate(key) {
  active.value = key;
  router.push({ name: key });
}
</script>
