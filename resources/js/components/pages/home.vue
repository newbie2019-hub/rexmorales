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
    <div class="container" style="height: 100vh">
      <h5 class="pt-5">Welcome back, {{ username }}!</h5>
      <h6 class="mt-2">Listed below are your grocery list</h6>
      <div class="row justify-content-center align-items-center">
        <div class="col-9 col-sm-10 col-md-6 col-lg-6 mt-2">
          <div class="d-flex ml-1 mr-1 justify-content-between">
            <a
              href="#"
              class="btn btn-primary btn-sm mt-3"
              data-target="#addModal"
              data-toggle="modal"
              >New Grocery List</a
            >
            <a
              href="#"
              class="btn btn-danger btn-sm mt-3"
              @click.prevent="logout"
              >Log-out</a
            >
          </div>
          <div class="list-group">
            <a
              href="#"
              class="list-group-item d-flex justify-content-between align-items-center mt-2 shadow-sm"
            >
              Grocery for Home (02-20-2020)
              <span class="badge badge-primary badge-pill">14</span>
            </a>
            <a
              href="#"
              class="list-group-item d-flex justify-content-between align-items-center mt-2 shadow-sm"
            >
              Grocery for Home (02-20-2020)
              <span class="badge badge-primary badge-pill">14</span>
            </a>
          </div>
          <div class="row justify-content-end mt-4 mb-3">
            <p class="mr-2 mt-1">Total</p>
            <div class="form-group mr-3">
              <select id="customSelect" class="custom-select">
                <option selected>3</option>
                <option value="5">5</option>
                <option value="8">8</option>
                <option value="10">10</option>
              </select>
            </div>
           
          </div>
        </div>
        <div class="col-9 col-sm-10 col-md-6 col-lg-6 mt-5"></div>
      </div>
    </div>

    <!-- ADD Modal -->
    <div
      class="modal fade"
      id="addModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addModal"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Add New List</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-center">
              <div class="col-12 col-sm-12 col-md-11 col-lg-9">
                <p>Grocery Title</p>
                <input
                  type="text"
                  class="form-control"
                  v-model="data.title"
                  id="title"
                  placeholder="Title"
                />
                <p>Date</p>
                <input
                  class="form-control"
                  type="datetime-local"
                  v-model="data.date"
                  id="date"
                />
                <p>Grocery Items</p>
                <textarea
                  class="form-control"
                  id="list"
                  v-model="data.list"
                  rows="4"
                ></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button type="button" @click.prevent="saveList" class="btn btn-primary">Save List</button>
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
    this.checkToken();
  },
  data() {
    return {
      username: localStorage.getItem("username"),
      data: {
        title: "",
        list: "",
        date: "",
      },
      loading: false,
      total: 3,
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
    async saveList() {
      if (this.data.title.trim() == "")
        return this.warning("Title is required");
      if (this.data.date.trim() == "") return this.warning("Date is required");
      if (this.data.list.trim() == "") return this.warning("List is required");

      this.loading = true;
      const res = await this.callApi(
        "post",
        `api/track/store?token=${this.$store.state.token}`,
        this.data
      );
      if (res.status == 200) {
        this.loading = false;
        this.clearFields();
        this.data.rating = 0;
        return this.success("Grocery List saved successfully!");
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
    rgb(14, 203, 236, 0.822),
    rgba(6, 30, 241, 0.966)
  );
  color: white;
  transition: all 250ms;

  &:hover {
    border: 1px solid rgba(6, 30, 241, 0.966);
  }
}
.form-control {
  border: 1px solid rgba(6, 30, 241, 0.966) !important;
}
.text-area {
  border: 1px solid rgba(6, 30, 241, 0.966) !important;
}
</style>