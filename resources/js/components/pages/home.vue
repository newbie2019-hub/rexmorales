<template>
  <div>
    <div class="vld-parent">
      <loading
        :active.sync="loading"
        :can-cancel="false"
        :is-full-page="true"
      ></loading>
    </div>
    <div class="container">

    </div>
  </div>
</template>
<script>
import StarRating from "vue-star-rating";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  components: {
    StarRating,
    Loading,
  },
  async mounted() {
    this.checkToken();
    this.getReads();
  },
  data() {
    return {
      username: localStorage.getItem("username"),
      data: {
        bookid: "",
        userid: localStorage.getItem("userid"),
        booktitle: "",
        genre: "",
        author: "",
        synopsis: "",
        rating: 0,
        review: "",
        status: '',
      },
      loading: false,
      reading: {},
      total: 4,
      deleteid: "",
      book: { //ARRAY FOR EDIT
        current_synopsis: "",
        current_title: "",
        current_review: "",
      },
      isActive: 1, //ACTIVE TAB INDICATOR
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
      if (this.data.booktitle.trim() == "")
        return this.warning("Book Title is required");
      if (this.data.genre.trim() == "")
        return this.warning("Genre is required");
      if (this.data.author.trim() == "")
        return this.warning("Author is required");
      if (this.data.synopsis.trim() == "")
        return this.warning("Synopsis is required");
      if (this.data.rating == "") return this.warning("Rating is required");
      if (this.data.review.trim() == "")
        return this.warning("Review is required");

      this.loading = true;
      const res = await this.callApi(
        "post",
        `api/track/store?token=${this.$store.state.token}`,
        this.data
      );
      if (res.status == 200) {
        this.loading = false;
        this.clearFields();
        $("#addModal").modal("hide");
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
    async updateBook() {
      if (this.data.booktitle.trim() == "")
        return this.warning("Book Title is required");
      if (this.data.genre.trim() == "")
        return this.warning("Genre is required");
      if (this.data.author.trim() == "")
        return this.warning("Author is required");
      if (this.data.synopsis.trim() == "")
        return this.warning("Synopsis is required");
      if (this.data.rating == "") return this.warning("Rating is required");
      if (this.data.review.trim() == "")
        return this.warning("Review is required");

      this.loading = true;
      const res = await this.callApi(
        "put",
        `api/track/put?token=${this.$store.state.token}`,
        this.data
      );
      if (res.status == 200) {
        this.checkActiveTab()
        $("#editModal").modal("hide");
        this.loading = false;
        return this.success("Book Record was updated successfully");
      } else {
        this.loading = false;
      }
    },
    async deleteBook() {
      this.loading = true;
      const res = await this.callApi(
        "delete",
        `api/track/delete?id=${this.deleteid}&&token=${this.$store.state.token}`
      );
      if (res.status == 200) {
        this.checkActiveTab()
        $("#deleteModal").modal("hide");
        this.loading = false;
        return this.success("Delete successful");
      }
    },
    checkActiveTab(){
      if(this.isActive == 1){
        this.getReads()
      }
      else if(this.isActive == 2){
        this.toRead()
      }
      else if(this.isActive == 3){
        this.didNotFinish()
      }
    },
    async toRead(page = 1) {
      this.loading = true
      this.isActive = 2
      const res = await this.callApi(
        "get",
        `api/track/getToRead?token=${this.$store.state.token}&&total=${this.total}&&page=${page}`
      );
      if (res.status == 200) {
        this.reading = res.data;
        this.loading = false
      }
    },
    async didNotFinish(page = 1) {
      this.loading = true
      this.isActive = 3
      const res = await this.callApi(
        "get",
        `api/track/getDidNotFinish?token=${this.$store.state.token}&&total=${this.total}&&page=${page}`
      );
      if (res.status == 200) {
        this.reading = res.data;
        this.loading = false
      }
    },
    addBook() {
      this.clearFields();
      $("#addModal").modal("show");
    },
    editBook(book) {
      this.data.booktitle = book.booktitle;
      this.data.bookid = book.id;
      this.data.genre = book.genre;
      this.data.author = book.author;
      this.data.review = book.review;
      this.data.rating = book.rating;
      this.data.synopsis = book.synopsis;
      this.data.status = book.status;

      $("#editModal").modal("show");
    },
    viewSynopsis(book) {
      this.book.current_synopsis = book.synopsis;
      this.book.current_title = book.booktitle;
      $("#synopsisModal").modal("show");
    },
    viewReview(book) {
      this.book.current_synopsis = book.synopsis;
      this.book.current_title = book.booktitle;
      this.book.current_review = book.review;
      $("#reviewModal").modal("show");
    },
    setDelete(book) {
      this.deleteid = book.id;
      $("#deleteModal").modal("show");
    },
    setRating(rating) {
      this.data.rating = rating;
    },
    ChangeTotal(event) {
      this.total = event.target.value;
      this.checkActiveTab()
    },
    clearFields() {
      this.data.rating = 0;
      this.data.booktitle = "";
      this.data.review = "";
      this.data.author = "";
      this.data.synopsis = "";
      this.data.genre = "";
    },
    async getReads(page = 1) {
      this.loading = true
      this.isActive = 1
      const res = await this.callApi(
        "get",
        `api/track/get?token=${this.$store.state.token}&&total=${this.total}&&page=${page}`
      );
      if (res.status == 200) {
        this.reading = res.data;
        this.loading = false
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