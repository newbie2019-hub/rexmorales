<template>
  <div>
    <loading
      :active.sync="loading"
      :can-cancel="true"
      :is-full-page="true"
      :opacity="1"
    ></loading>
    <div class="container-fluid p-0 m-0" style="height: 100vh">
      <div class="row h-100 align-items-center p-0 m-0">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 p-0 m-0 login-bg">
           <div class="d-flex flex-column flex-lg-column flex-md-column justify-content-center align-items-center h-100">
            <p class="text-uppercase header-primary">Rex-Grocery</p>
            <p class="text-white">Easily manage your schedule and items for your grocery.</p>
          </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 h-100 p-0 m-0 ">
          <div class="form-container card p-5" style="min-width: 420px; max-width: 480px">
            <div class="d-flex flex-column flex-lg-column flex-md-column justify-content-center d-flex text-center">
              <h3>Hey There, User!</h3>
              <p>Keep track of your schedule and grocery list.</p>
              <p class="mt-4">We need some of your informations</p>
            </div>
            <div class="row justify-content-center">
              <div class="col-12 col-sm-12 col-md-11 col-lg-9">
                <input
                  type="text"
                  class="form-control mt-3"
                  v-model="data.fname"
                  id="fullname"
                  placeholder="Full Name"
                />
                <input
                  type="email"
                  class="form-control mt-3"
                  v-model="data.email"
                  id="email"
                  placeholder="Email Address"
                />
                <input
                  type="password"
                  class="form-control mt-3"
                  v-model="data.password"
                  id="password"
                  placeholder="Password"
                />
                <input
                  type="password"
                  class="form-control mt-3"
                  v-model="data.cpass"
                  id="cpassword"
                  placeholder="Confirm Password"
                />
                <button
                  class="btn btn-block btn-login mt-4 rounded-pill"
                  @click.prevent="createAccount"
                  :disabled="loading"
                >
                  Create Account
                </button>
                <p class="mt-2">
                  Already have an account?<router-link to="/"
                    ><a href=""> Sign-in</a></router-link
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
  components: {
    Loading,
  },
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
  data() {
    return {
      data: {
        fname: "",
        email: "",
        password: "",
        cpass: "",
      },
      loading: false,
    };
  },
  methods: {
    async createAccount() {
      if (this.data.fname.trim() == "")
        return this.error("Your full name is required");
      if (this.data.email.trim() == "")
        return this.error("Your email address is required");
      if (this.data.password.trim() == "")
        return this.error("Your Password is required");
      if (this.data.password != this.data.cpass)
        return this.error("Your password doesnt match");

      this.loading = true;
      const res = await this.callApi("post", "api/auth/create", this.data);
      if (res.status == 200) {
        this.success("Account created successfuly!");
        this.loading = false;
        this.clearFields();
        this.$router.push('/')
      } else {
        if (res.status == 422) {
          for (let i in res.data.errors) {
            this.warning(res.data.errors[i][0]);
            this.loading = false;
          }
        }
        this.loading = false;
      }
    },
    clearFields() {
      this.data.fname = "";
      this.data.email = "";
      this.data.password = "";
      this.data.cpass = "";
    },
  },
};
</script>
