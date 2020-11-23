<template>
  <div>
    <div class="vld-parent">
      <loading
        :active.sync="loading"
        :can-cancel="false"
        :is-full-page="true"
      ></loading>
    </div>
    <div class="container-fluid p-0 m-0" style="height: 100vh">
      <div class="row h-100 align-items-center p-0 m-0">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0 m-0 login-bg"></div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 h-100 p-0 m-0">
          <div class="gcircle"></div>
          <div class="gcircle"></div>
          <div class="gcircle"></div>
          <div class="gcircle"></div>
          <div class="form-container">
            <div class="row justify-content-center d-flex text-center">
              <h3>Welcome Back, Guest!</h3>
              <p>Keep track of the books you read.</p>
              <p class="mt-4">Please login your account to proceed</p>
            </div>
            <div class="row justify-content-center">
              <div class="col-12 col-sm-12 col-md-11 col-lg-9">
                <input
                  type="email"
                  class="form-control mt-3"
                  v-model="data.email"
                  id="email"
                  placeholder="Email Address"
                  @keydown.enter="login"
                />
                <input
                  type="password"
                  class="form-control mt-3"
                  v-model="data.password"
                  id="password"
                  placeholder="Password"
                  @keydown.enter="login"
                />
                <button
                  class="btn btn-block btn-login mt-4 rounded-pill"
                  @click.prevent="login"
                  :disabled="loading"
                >
                  Login
                </button>
                <p class="mt-2">
                  Dont have an account?<router-link to="/signup"
                    ><a href=""> Sign-up</a></router-link
                  >
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  async mounted() {
    this.loading = true;
    const res = await this.callApi(
      "post",
      `api/auth/me?token=${this.$store.state.token}`
    );
    if (res.status == 200) {
      this.$router.push("/home");
      this.loading = false;
    } else {
      this.$store.commit("clearToken");
      localStorage.removeItem("username");
      localStorage.removeItem("userid");
      this.loading = false;
    }
  },
  components: {
    Loading,
  },
  data() {
    return {
      data: {
        email: "",
        password: "",
      },
      loading: false,
    };
  },
  methods: {
    async login() {
      if (this.data.email.trim() == "")
        return this.error("Email Address is required");
      if (this.data.password.trim() == "")
        return this.error("Password is required");

      this.loading = true;
      const res = await this.callApi("POST", "api/auth/login", this.data);

      if (res.status == 200 || res.status == 201) {
        const user = await this.callApi("post", "api/auth/me", {
          token: res.data.access_token,
        });
        if (user.status == 200) {
          this.success("Welcome back, " + user.data.name);
          localStorage.setItem("userid", user.data.id);
          localStorage.setItem("username", user.data.name);
          this.$store.commit("setToken", res.data.access_token);
          this.$router.push("/home");
        }
      } else {
        this.data.email = "";
        this.data.password = "";
        this.loading = false;
        return this.error(res["data"]["error"]);
      }

      this.loading = false;
    },
  },
};
</script>
<style lang="scss">
.btn-login {
  background: linear-gradient(
    to right,
    rgba(236, 203, 14, 0.822),
    rgba(241, 112, 6, 0.966)
  );
  color: white;
  transition: all 250ms;

  &:hover {
    border: 1px solid rgb(240, 109, 1);
  }
}
.form-control {
  border: 1px solid rgba(241, 112, 6, 0.966) !important;
}
.form-container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.gcircle {
  position: fixed;
  right: -60px;
  top: -50px;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  background: radial-gradient(
    rgba(236, 203, 14, 0.822),
    rgba(241, 112, 6, 0.966)
  );

  &:nth-child(1) {
    right: 28%;
    top: -40px;
    width: 80px;
    height: 80px;
  }

  &:nth-child(2) {
    right: 38%;
    top: 10%;
    width: 120px;
    height: 120px;
  }

  &:nth-child(3) {
    right: 32%;
    top: 24%;
    width: 70px;
    height: 70px;
  }
}
</style>
