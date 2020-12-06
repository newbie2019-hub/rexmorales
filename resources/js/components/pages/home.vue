<template>
  <div>
    <div class="vld-parent">
      <loading
        :active.sync="loading"
        :can-cancel="false"
        :is-full-page="true"
        :opacity="1"
      ></loading>
    </div>
    <div class="container">
      <h1>Hello</h1>
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
    this.checkToken();
  },
  data() {
    return {
      username: localStorage.getItem("username"),
      data: {
        title: '',
        list: '',
        date: '',
      },
      loading: false,

    };
  },

  methods: {
    async checkToken() {
      this.loading = true;
      const res = await this.callApi(
        "post",
        `api/auth/me?token=${this.$store.state.token}`
      );
      if (res.status == 201) {
        this.loading = false;
        localStorage.removeItem("auth");
        localStorage.setItem("auth", res.data.newToken);
        console.log(res.data.newToken);
        this.$router.go();
      } else if (res.status !== 200) {
        this.loading = false;
        this.$router.push("/");
      }
      this.loading = false;
    },
    async logout() {
      const res = await this.callApi("post", "api/auth/logout", {
        token: this.$store.state.token,
      });
      if (res.status == 200) {
        this.$store.commit("clearToken");
        localStorage.removeItem("username");
        localStorage.removeItem("userid");
        this.$router.push("/");
      }
    },
    async saveBook() {
      if (this.data.title.trim() == "")
        return this.warning("Book Title is required");
      if (this.data.date.trim() == "")
        return this.warning("Genre is required");
      if (this.data.list.trim() == "")
        return this.warning("Author is required");

      this.loading = true;
      const res = await this.callApi(
        "post",
        `api/track/store?token=${this.$store.state.token}`,
        this.data
      );
      if (res.status == 200) {
        this.loading = false;
        this.clearFields();
        this.checkActiveTab()
        this.data.rating = 0;
        return this.success("Book saved successfully!");
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
  },
};
</script>
<style scoped lang="scss">
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
.text-area {
  border: 1px solid rgba(241, 112, 6, 0.966) !important;
}
</style>