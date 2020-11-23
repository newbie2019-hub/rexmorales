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
      <div class="row justify-content-center d-flex mt-5">
        <div class="col-11 col-sm-12 col-md-12 col-lg-11">
          <div class="row justify-content-end d-flex mr-1 ml-1">
            <button class="btn btn-login btn-sm mr-2" @click.prevent="addBook">
              Add Book
            </button>
            <button class="btn btn-login btn-sm" @click.prevent="logout">
              Logout
            </button>
          </div>
        </div>
      </div>
      <div class="row justify-content-center d-flex mt-4 mb-4">
        <div class="col-11 col-sm-12 col-md-12 col-lg-11">
          <h5 class="mb-2">Here are your records, {{ username }}!</h5>
          <div class="card p-4 card-shadow">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link active"
                  id="home-tab"
                  data-toggle="tab"
                  href="#home"
                  role="tab"
                  @click.prevent="getReads"
                  aria-controls="home"
                  aria-selected="true"
                  >Reads</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link"
                  id="toread"
                  data-toggle="tab"
                  href="#profile"
                  role="tab"
                  @click.prevent="toRead"
                  aria-controls="profile"
                  aria-selected="false"
                  >To Read</a
                >
              </li>
              <li class="nav-item" role="presentation">
                <a
                  class="nav-link"
                  id="didnotfinish"
                  data-toggle="tab"
                  href="#"
                  role="tab"
                  @click.prevent="didNotFinish"
                  aria-controls="didnotfinish"
                  aria-selected="false"
                  >Did Not Finish</a
                >
              </li>
            </ul>

            <div class="tab-content" id="myTabContent">
              <!--- FIRST TAB --->
              <div
                class="tab-pane fade show active"
                id="home"
                role="tabpanel"
                aria-labelledby="home-tab">
                <div class="table-responsive mt-2">
                  <table class="table table-hover" id="readingsTable">
                    <caption>Showing {{reading.to}} of {{reading.total}} records</caption>
                    <thead>
                      <tr>
                        <th scope="col">Book Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Synopsis</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Review</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(book, i) in reading.data" :key="i">
                        <td>{{ book.booktitle }}</td>
                        <td>{{ book.genre }}</td>
                        <td>{{ book.author }}</td>
                        <td>
                          <a href="" @click.prevent="viewSynopsis(book)">View</a>
                        </td>
                        <td>
                          <star-rating
                            v-bind:max-rating="5"
                            v-bind:star-size="15"
                            v-bind:rounded-corners="true"
                            v-bind:padding="10"
                            active-color="rgba(241, 112, 6, 0.966)"
                            v-bind:animate="true"
                            v-bind:rating="parseInt(book.rating)"
                            v-bind:read-only="true"
                            v-bind:show-rating="false"/>
                        </td>
                        <td>
                          <a href="" @click.prevent="viewReview(book)">View</a>
                        </td>
                        <td>{{ book.status }}</td>
                        <td>
                          <button
                            class="btn btn-primary btn-sm"
                            @click.prevent="editBook(book)"
                          >
                            Edit
                          </button>
                          <button
                            class="btn btn-danger btn-sm"
                            @click.prevent="setDelete(book)"
                          >
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div
                    class=""
                    v-if="reading.data.length == 0"
                    style="overflow: hidden"
                  >
                    <h5 class="text-center mt-5 mb-5">
                      You currently have no books here, Wanna add something?
                    </h5>
                  </div>
                </div>
                <div class="row justify-content-end mr-1">
                  <div class="form-group mr-2">
                    <select
                      id="customSelect"
                      @change="ChangeTotal($event)"
                      class="custom-select"
                    >
                      <option selected value="4">4</option>
                      <option value="6">6</option>
                      <option value="8">8</option>
                      <option value="10">10</option>
                    </select>
                  </div>
                  <pagination
                    :data="reading"
                    @pagination-change-page="getReads"
                  ></pagination>
                </div>
              </div>
              <!--- SECOND TAB --->
              <div
                class="tab-pane fade"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab">
                <div class="table-responsive mt-2">
                  <table class="table table-hover" id="readingsTable">
                    <caption>Showing {{reading.to}} of {{reading.total}} records</caption>
                    <thead>
                      <tr>
                        <th scope="col">Book Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Synopsis</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Review</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(book, i) in reading.data" :key="i">
                        <td>{{ book.booktitle }}</td>
                        <td>{{ book.genre }}</td>
                        <td>{{ book.author }}</td>
                        <td>
                          <a href="" @click.prevent="viewSynopsis(book)">View</a>
                        </td>
                        <td>
                          <star-rating
                            v-bind:max-rating="5"
                            v-bind:star-size="15"
                            v-bind:rounded-corners="true"
                            v-bind:padding="10"
                            active-color="rgba(241, 112, 6, 0.966)"
                            v-bind:animate="true"
                            v-bind:rating="parseInt(book.rating)"
                            v-bind:read-only="true"
                            v-bind:show-rating="false"
                          />
                        </td>
                        <td>
                          <a href="" @click.prevent="viewReview(book)">View</a>
                        </td>
                        <td>{{ book.status}}</td>
                        <td>
                          <button
                            class="btn btn-primary btn-sm"
                            @click.prevent="editBook(book)">
                            Edit
                          </button>
                          <button
                            class="btn btn-danger btn-sm"
                            @click.prevent="setDelete(book)">
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div
                    class=""
                    v-if="reading.data.length == 0"
                    style="overflow: hidden"
                  >
                    <h5 class="text-center mt-5 mb-5">
                      You currently have no books here, Wanna add something?
                    </h5>
                  </div>
                </div>
                <div class="row justify-content-end mr-1">
                  <div class="form-group mr-2">
                    <select
                      id="customSelect"
                      @change="ChangeTotal($event)"
                      class="custom-select"
                    >
                      <option selected value="4">4</option>
                      <option value="6">6</option>
                      <option value="8">8</option>
                      <option value="10">10</option>
                    </select>
                  </div>
                  <pagination
                    :data="reading"
                    @pagination-change-page="getReads"
                  ></pagination>
                </div>
              </div>
              <!--- THIRD TAB -->
              <div
                class="tab-pane fade"
                id="contact"
                role="tabpanel"
                aria-labelledby="contact-tab"
              >
                <div class="table-responsive mt-2">
                  <table class="table table-hover" id="readingsTable">
                    <caption>Showing {{reading.to}} of {{reading.total}} records</caption>
                    <thead>
                      <tr>
                        <th scope="col">Book Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Synopsis</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Review</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(book, i) in reading.data" :key="i">
                        <td>{{ book.booktitle }}</td>
                        <td>{{ book.genre }}</td>
                        <td>{{ book.author }}</td>
                        <td>
                          <a href="" @click.prevent="viewSynopsis(book)">View</a>
                        </td>
                        <td>
                          <star-rating
                            v-bind:max-rating="5"
                            v-bind:star-size="15"
                            v-bind:rounded-corners="true"
                            v-bind:padding="10"
                            active-color="rgba(241, 112, 6, 0.966)"
                            v-bind:animate="true"
                            v-bind:rating="parseInt(book.rating)"
                            v-bind:read-only="true"
                            v-bind:show-rating="false"/>
                        </td>
                        <td>
                          <a href="" @click.prevent="viewReview(book)">View</a>
                        </td>
                        <td>{{ book.status }}</td>
                        <td>
                          <button
                            class="btn btn-primary btn-sm"
                            @click.prevent="editBook(book)"
                          >
                            Edit
                          </button>
                          <button
                            class="btn btn-danger btn-sm"
                            @click.prevent="setDelete(book)"
                          >
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <div
                    class=""
                    v-if="reading.data.length == 0"
                    style="overflow: hidden"
                  >
                    <h5 class="text-center mt-5 mb-5">
                      You currently have no books here, Wanna add something?
                    </h5>
                  </div>
                </div>
                <div class="row justify-content-end mr-1">
                  <div class="form-group mr-2">
                    <select
                      id="customSelect"
                      @change="ChangeTotal($event)"
                      class="custom-select"
                    >
                      <option selected value="4">4</option>
                      <option value="6">6</option>
                      <option value="8">8</option>
                      <option value="10">10</option>
                    </select>
                  </div>
                  <pagination
                    :data="reading"
                    @pagination-change-page="getReads"
                  ></pagination>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--- ADD MODAL --->
      <!-- Modal -->
      <div
        class="modal fade"
        id="addModal"
        tabindex="-1"
        aria-labelledby="AddBookModal"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title">Add Book</h5>
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
              <form>
                <div class="form-group row">
                  <label for="booktitle" class="col-sm-2 col-form-label"
                    >Title</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      v-model="data.booktitle"
                      class="form-control"
                      id="booktitle"
                      placeholder="Book Title"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="genre" class="col-sm-2 col-form-label"
                    >Genre</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      v-model="data.genre"
                      class="form-control"
                      id="genre"
                      placeholder="Genre"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="author" class="col-sm-2 col-form-label"
                    >Author</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      v-model="data.author"
                      class="form-control"
                      id="author"
                      placeholder="Author"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="synopsis" class="col-sm-2 col-form-label"
                    >Synopsis</label
                  >
                  <div class="col-sm-10">
                    <textarea
                      class="form-control"
                      id="synopsis"
                      v-model="data.synopsis"
                      rows="3"
                      placeholder="Synopsis"
                    ></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="rating" class="col-sm-2 col-form-label"
                    >Rating</label
                  >
                  <div class="col-sm-10 mt-1">
                    <star-rating
                      v-bind:max-rating="5"
                      v-bind:star-size="25"
                      v-bind:rounded-corners="true"
                      v-bind:glow="1"
                      v-bind:padding="10"
                      active-color="rgba(241, 112, 6, 0.966)"
                      v-bind:animate="true"
                      @rating-selected="setRating"
                    />
                  </div>
                </div>

                <div class="form-group row">
                  <label for="review" class="col-sm-2 col-form-label"
                    >Review</label
                  >
                  <div class="col-sm-10">
                    <textarea
                      class="form-control"
                      id="review"
                      v-model="data.review"
                      rows="3"
                      placeholder="Review"
                    ></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                  <div class="col-sm-10 mt-1">
                    <select class="form-control custom-select" v-model="data.status" id="exampleFormControlSelect1">
                      <option>To Read</option> 
                      <option>Did Not Finish</option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
              >
                Close
              </button>
              <button
                type="button"
                @click.prevent="saveBook"
                class="btn btn-primary btn-sm"
              >
                Save Book
              </button>
            </div>
          </div>
        </div>
      </div>

      <!--- EDIT MODAL --->
      <!-- Modal -->
      <div
        class="modal fade"
        id="editModal"
        tabindex="-1"
        aria-labelledby="Edit Book"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title">Edit Book</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form>
                <div class="form-group row">
                  <label for="booktitle" class="col-sm-2 col-form-label"
                    >Title</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      v-model="data.booktitle"
                      class="form-control"
                      id="booktitle"
                      placeholder="Book Title"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="genre" class="col-sm-2 col-form-label"
                    >Genre</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      v-model="data.genre"
                      class="form-control"
                      id="genre"
                      placeholder="Genre"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="author" class="col-sm-2 col-form-label"
                    >Author</label
                  >
                  <div class="col-sm-10">
                    <input
                      type="text"
                      v-model="data.author"
                      class="form-control"
                      id="author"
                      placeholder="Author"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="synopsis" class="col-sm-2 col-form-label"
                    >Synopsis</label
                  >
                  <div class="col-sm-10">
                    <textarea
                      class="form-control"
                      id="synopsis"
                      v-model="data.synopsis"
                      rows="3"
                      placeholder="Synopsis"
                    ></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="rating" class="col-sm-2 col-form-label"
                    >Rating</label
                  >
                  <div class="col-sm-10">
                    <star-rating
                      v-bind:max-rating="5"
                      v-bind:star-size="28"
                      v-bind:rounded-corners="true"
                      v-bind:glow="1"
                      v-bind:padding="10"
                      v-bind:rating="data.rating"
                      active-color="rgba(241, 112, 6, 0.966)"
                      v-bind:animate="true"
                      @rating-selected="setRating"
                    />
                  </div>
                </div>
                <div class="form-group row">
                  <label for="review" class="col-sm-2 col-form-label"
                    >Review</label
                  >
                  <div class="col-sm-10">
                    <textarea
                      class="form-control"
                      id="review"
                      v-model="data.review"
                      rows="3"
                      placeholder="Review"
                    ></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="rating" class="col-sm-2 col-form-label">Rating</label>
                  <div class="col-sm-10 mt-1">
                    <select class="form-control custom-select" v-model="data.status" id="exampleFormControlSelect1">
                      <option>To Read</option> 
                      <option>Did Not Finish</option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
              >
                Close
              </button>
              <button
                type="button"
                @click.prevent="updateBook"
                class="btn btn-primary btn-sm"
              >
                Save Book
              </button>
            </div>
          </div>
        </div>
      </div>

      <!--- VIEW SYNOPSIS --->
      <div
        class="modal fade"
        id="synopsisModal"
        tabindex="-1"
        aria-labelledby="AddBookModal"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title">{{ book.current_title }}</h5>
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
              {{ book.current_synopsis }}
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
      <!--- VIEW SYNOPSIS --->
      <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
        aria-labelledby="deleteModal"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title">Confirm Delete</h5>
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">Are you sure you want to delete this?</div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
              >
                Close
              </button>
              <button
                type="button"
                class="btn btn-secondary btn-sm"
                @click.prevent="deleteBook"
              >
                Yes
              </button>
            </div>
          </div>
        </div>
      </div>

      <!---- REVIEW MODAL--->
      <div
        class="modal fade"
        id="reviewModal"
        tabindex="-1"
        aria-labelledby="reviewModal"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="title">{{ book.current_title }}</h5>
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
              {{ book.current_review }}
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary btn-sm"
                data-dismiss="modal"
              >
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
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