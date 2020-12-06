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
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0 m-0 login-bg">
          <div class="d-flex flex-column flex-lg-column flex-md-column justify-content-center align-items-center h-100">
            <p class="text-uppercase header-primary">Rex-Grocery</p>
            <p class="text-white">Easily manage your schedule and items for your grocery.</p>
          </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 h-100 p-0 m-0 login-bg-mobile">
          <div class="form-container card p-5" style="min-width: 420px; max-width: 480px">
            <div class="d-flex flex-column flex-lg-column flex-md-column justify-content-center  text-center">
              <h3>Welcome Back, Guest!</h3>
              <p>Manage your grocery list easily.</p>
              <p class="mt-4">Please login your account</p>
            </div>
            <div class="row justify-content-center">
              <div class="col-12 col-sm-12 col-md-11 col-lg-10">
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
    const res = await this.callApi("post",`api/auth/me?token=${this.$store.state.token}`);
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
    async callApi(method, url, data) {
      try {
        return await axios({
          method: method,
          url: url,
          data: data
        });
      } catch (e) {
        return e.response
      }
    },
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
    rgba(14, 203, 236, 0.822),
    rgba(6, 30, 241, 0.966)
  );
  color: white;
  transition: all 250ms;

  &:hover {
    border: 1px solid rgb(14, 203, 236, 0.822);
  }
}
.form-control {
  border: 1px solid rgba(6, 30, 241, 0.966) !important;
}
.form-container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.header-primary {
  font-size: 3.5rem;
  font-weight: 400;
  color: white;
}
</style>
