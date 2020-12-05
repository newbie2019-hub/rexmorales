<template>
  <transition name="fade" mode="out-in">
    <router-view />
  </transition>
</template>

<script>
export default {
  mounted() {},
};
</script>
<style lang="scss" scoped>
.fade-enter,
.fade-leave-to {
  opacity: 0;
  transform: translateX(2rem);
}

.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
</style>
