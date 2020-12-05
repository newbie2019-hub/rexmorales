<template>
  <div>
    <div class="container-fluid p-0 m-0" style="height: 100vh">
      <div class="row h-100 align-items-center justify-content-center p-0 m-0">
        <div class="d-block text-center">
          <img src="images/notfound.gif" class="img-fluid" height="350" width="450"/>
          <p class="header">404</p>
          <p class="header-secondary">Uh Oh! You got lost</p>
          <p>The page you are looking for doesn't exist.</p>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.header {
  font-size: 5rem;
  font-weight: bold;

  &-secondary {
    font-weight: bold;
    font-size: 2rem;
  }
}
</style>