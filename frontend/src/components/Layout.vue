<template>
  <n-space vertical size="large">
    <n-layout has-sider class="layout-root">
      <n-layout-sider width="220" bordered>
        <Sidebar />
      </n-layout-sider>

      <n-layout>
        <n-layout-header bordered>
          <Header />
        </n-layout-header>

        <n-layout-content class="layout-content">
          <router-view />
        </n-layout-content>

        <n-layout-footer bordered class="layout-footer">
          © 2025 Your Company
        </n-layout-footer>
      </n-layout>
    </n-layout>
  </n-space>
</template>

<script setup>
import Sidebar from "./Sidebar.vue";
import Header from "./Header.vue";
</script>

<!-- <template>
  <n-layout has-sider class="layout-root">
    <n-layout-sider width="220" bordered>
      <Sidebar />
    </n-layout-sider>

    <n-layout class="layout-main">
      <n-layout-header bordered>
        <Header />
      </n-layout-header>

      <n-layout-content class="layout-content">
        <router-view />
      </n-layout-content>

      <n-layout-footer bordered class="layout-footer">
        © 2025 Your Company
      </n-layout-footer>
    </n-layout>
  </n-layout>
</template> -->

<style scoped>
.layout-root {
  height: 100vh;
  display: flex;
  flex-direction: row;
}

.layout-main {
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  height: 100vh;
}

.layout-content {
  flex-grow: 1;
  overflow-y: auto;
  padding: 24px;
  background-color: #fff;
  height: 100vh;
}

.layout-footer {
  text-align: center;
  font-size: 0.875rem;
  color: #888;
}
</style>
